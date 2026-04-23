<?php
class eventmodel
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    // Insert new event into volunteering_program table
    public function createEvent($data)
    {
        $sql = "INSERT INTO volunteering_program 
                (name, description, event_type, isauthorized,is_annual, 

                starpoints_reward, levelpoints_reward, event_date,time, location,gmap_link, 
                scale,allocated_budget, max_participants, organizer_id, duration)
                VALUES (?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";


        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("SQL Error: " . $this->db->error);
        }


        $stmt->bind_param(

            "sssssiisssssiiis",

            $data['name'],
            $data['description'],
            $data['event_type'],
            $data['is_authorized'],
            $data['is_annual'],
            $data['starpoints_reward'],
            $data['levelpoints_reward'],
            $data['event_date'],
            $data['time'],
            $data['location'],
            $data['gmap_link'],
            $data['scale'],
            $data['allocated_budget'],
            $data['max_participants'],
            $data['organizer_id'],
            $data['duration']
        );

        // return $stmt->execute();

        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;

    }

    // public function getAllEvents() {
    //     $sql = "SELECT * FROM volunteering_program ";
    //     $result = $this->db->query($sql);

    //     if (!$result) {
    //         die("SQL Error: " . $this->db->error);
    //     }

    //     $events = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $events[] = $row;
    //     }
    //     return $events;
    // }

    public function getAllEvents($filters = [])
    {
        $sql = "SELECT * FROM volunteering_program WHERE is_deleted = 0";
        $params = [];
        $types = "";

        // if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['manager', 'representative'])) {
        $sql .= " AND isauthorized = 1";
        // }
        // Add search filter
        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "ss";
        }

        // Add location filter
        if (!empty($filters['location'])) {
            $sql .= " AND location = ?";
            $params[] = $filters['location'];
            $types .= "s";
        }

        // Add event type filter
        if (!empty($filters['event_type'])) {
            $sql .= " AND event_type = ?";
            $params[] = $filters['event_type'];
            $types .= "s";
        }


        if (!empty($filters['date'])) {
            $sql .= " AND event_date = ?";
            $params[] = $filters['date'];
            $types .= "s";
        }

        // Add is_annual filter
        if (!empty($filters['is_annual'])) {
            $sql .= " AND is_annual = 1";
        }
        if (!empty($filters['isauthorized'])) {
            $sql .= " AND isauthorized = 1";
        }


        // $sql .= " ORDER BY event_date ASC";
        // Order by availability match (if user is logged in), then by event date
        if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer') {
            $sql .= " ORDER BY (
        SELECT COUNT(*)
        FROM volunteer_availability va
        WHERE va.userid = ?
        AND CONCAT(
            CASE DAYOFWEEK(volunteering_program.event_date)
                WHEN 1 THEN 'Sun'
                WHEN 2 THEN 'Mon'
                WHEN 3 THEN 'Tue'
                WHEN 4 THEN 'Wed'
                WHEN 5 THEN 'Thu'
                WHEN 6 THEN 'Fri'
                WHEN 7 THEN 'Sat'
            END,
            '-',
            CASE 
                WHEN TIME(volunteering_program.time) BETWEEN '00:00:00' AND '11:59:59' THEN 'Morning'
                WHEN TIME(volunteering_program.time) BETWEEN '12:00:00' AND '17:59:59' THEN 'Afternoon'
                ELSE 'Evening'
            END
        ) = va.availability
    ) DESC, event_date ASC";

            // Add user_id to params
            if (empty($params)) {
                $params = [];
                $types = "";
            }
            array_unshift($params, $_SESSION['user_id']);
            $types = "i" . $types;
        } else {
            $sql .= " ORDER BY event_date ASC";
        }

        // Prepare and execute
        if (!empty($params)) {
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                die("SQL Error: " . $this->db->error);
            }
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query($sql);
            if (!$result) {
                die("SQL Error: " . $this->db->error);
            }
        }

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    }
    public function deleteEvent($id)
    {
        $sql = "UPDATE volunteering_program 
            SET is_deleted = 1, state_of_event = 'cancelled'
            WHERE event_id = ?";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("SQL Error: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getEventById($id)
    {
        $sql = "SELECT * FROM volunteering_program WHERE event_id = ? AND is_deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUniqueLocations()
    {
        $sql = "SELECT DISTINCT location FROM volunteering_program 
            WHERE location IS NOT NULL AND location != '' AND is_deleted = 0
             AND isauthorized = 1
        AND state_of_event = 'planned'
            ORDER BY location ASC";

        $result = $this->db->query($sql);

        if (!$result) {
            die("SQL Error: " . $this->db->error);
        }

        $locations = [];
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row['location'];
        }
        return $locations;
    }
    //     public function updateEvent($id, $data) {
//     $sql = "UPDATE volunteering_program 
//             SET name = ?, description = ?, event_type = ?, is_annual = ?, 
//                 starpoints_reward = ?, levelpoints_reward = ?, event_date = ?, 
//                 location = ?, scale = ?, max_participants = ?
//             WHERE event_id = ?";

    //     $stmt = $this->db->prepare($sql);
//     if (!$stmt) {
//         die("SQL Error: " . $this->db->error);
//     }

    //     $stmt->bind_param(
//         "ssssiisssii",
//         $data['name'],
//         $data['description'],
//         $data['event_type'],
//         $data['is_annual'],
//         $data['starpoints_reward'],
//         $data['levelpoints_reward'],
//         $data['event_date'],
//         $data['location'],
//         $data['scale'],
//         $data['max_participants'],
//         $id
//     );

    //     return $stmt->execute();
// }



    public function updateEvent($data)
    {
        $sql = "UPDATE volunteering_program 
                SET name = ?, description = ?, event_type = ?, 
                    starpoints_reward = ?, event_date = ?, time = ?,
                    location = ?, max_participants = ? 
                WHERE event_id = ? AND is_deleted = 0";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("SQL Error: " . $this->db->error);
        }

        $stmt->bind_param(
            "sssisssii",
            $data['name'],
            $data['description'],
            $data['event_type'],
            $data['starpoints_reward'],
            $data['event_date'],
            $data['time'],
            $data['location'],
            $data['max_participants'],
            $data['event_id']
        );

        return $stmt->execute();
    }


    //join logics
    public function joinEvent($eventId, $volunteerId, $numParticipants = 1)
    {
        // Check if already joined
        $checkSql = "SELECT * FROM event_participation WHERE event_id = ? AND volunteer_id = ? AND participation_status = 'registered'";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bind_param("ii", $eventId, $volunteerId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Already joined
        }

        // Insert or update participation record
        $sql = "INSERT INTO event_participation (event_id, volunteer_id, participation_status) VALUES (?, ?, 'registered')
        ON DUPLICATE KEY UPDATE participation_status = 'registered'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $eventId, $volunteerId);

        if ($stmt->execute()) {
            // Update current_participants count
            $updateSql = "UPDATE volunteering_program SET current_participants = current_participants + ? WHERE event_id = ? AND is_deleted != 1";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->bind_param("ii", $numParticipants, $eventId);
            return $updateStmt->execute();
        }
        return false;
    }

    public function isUserJoined($eventId, $volunteerId)
    {
        $sql = "SELECT * FROM event_participation WHERE event_id = ? AND volunteer_id = ? AND participation_status IN ('registered','attended','completed')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $eventId, $volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    //withdraw
    public function withdrawEvent($eventId, $volunteerId)
    {
        // Delete participation record
        $sql = "DELETE FROM event_participation WHERE event_id = ? AND volunteer_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $eventId, $volunteerId);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // Decrease current_participants count
            $updateSql = "UPDATE volunteering_program SET current_participants = current_participants - 1 WHERE event_id = ? AND current_participants > 0";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->bind_param("i", $eventId);
            return $updateStmt->execute();
        }
        return false;
    }

    public function getAuthorizedUpcomingEvents()
    {
        $currentDate = date('Y-m-d');
        $sql = "SELECT event_id, name, location, gmap_link, event_type, event_date, state_of_event 
            FROM volunteering_program 
            WHERE isauthorized = 1 
            AND event_date >= ? 
             AND is_deleted = 0
            ORDER BY event_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserRegisteredUpcomingEvents($userId)
    {
        $currentDate = date('Y-m-d');
        $sql = "SELECT DISTINCT vp.event_id, vp.name, vp.location, vp.gmap_link, vp.event_type, vp.event_date, vp.state_of_event 
            FROM volunteering_program vp
            INNER JOIN event_participation ep ON vp.event_id = ep.event_id
            WHERE ep.volunteer_id = ? 
            AND ep.participation_status = 'registered'
            AND vp.isauthorized = 1 
            AND vp.event_date >= ? 
            AND vp.is_deleted = 0
            ORDER BY vp.event_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $userId, $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFilterOptions()
    {
        $currentDate = date('Y-m-d');

        // Get unique cities
        $citySql = "SELECT DISTINCT location FROM volunteering_program 
                WHERE isauthorized = 1 AND event_date >= ? AND is_deleted = 0
                ORDER BY location ASC";
        $stmt = $this->db->prepare($citySql);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $cities = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['location'])) {
                $cities[] = $row['location'];
            }
        }

        // Get unique event types
        $typeSql = "SELECT DISTINCT event_type FROM volunteering_program 
                WHERE isauthorized = 1 AND event_date >= ? AND is_deleted = 0
                ORDER BY event_type ASC";
        $stmt = $this->db->prepare($typeSql);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $types = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['event_type'])) {
                $types[] = $row['event_type'];
            }
        }

        return [
            'cities' => $cities,
            'types' => $types
        ];
    }

    // Get all events with organizer information for approval panel
    public function getAllEventsWithOrganizer()
    {
        $sql = "SELECT 
                vp.*,
                u.name as organizer_name,
                u.email as organizer_email,
                u.contactnumber as organizer_contact
            FROM volunteering_program vp
            LEFT JOIN user u ON vp.organizer_id = u.userid

            LEFT JOIN manager m ON vp.organizer_id = m.userid

            WHERE vp.is_annual = 0

            AND vp.is_deleted = 0


            AND vp.state_of_event = 'planned'

            AND m.userid IS NULL


            ORDER BY vp.createddate DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            die("SQL Error: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Update event authorization status
    public function updateEventAuthorization($eventId, $isAuthorized)
    {
        $sql = "UPDATE volunteering_program SET isauthorized = ? WHERE event_id = ?  AND is_deleted = 0";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $this->db->error);
        }

        $stmt->bind_param("ii", $isAuthorized, $eventId);
        return $stmt->execute();
    }

    // Get single event by ID with organizer info
    public function getEventByIdWithOrganizer($eventId)
    {
        $sql = "SELECT 
                vp.*,
                u.name as organizer_name,
                u.email as organizer_email,
                u.contactnumber as organizer_contact
            FROM volunteering_program vp
            LEFT JOIN user u ON vp.organizer_id = u.userid
            WHERE vp.event_id = ? AND vp.is_deleted = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }





    // Annual Event Approval Logic

    // Add approval record
    public function addAnnualEventApproval($eventId, $approverId, $status)
    {
        // Check if already approved by this user
        if ($this->hasUserApprovedAnnualEvent($eventId, $approverId)) {
            return false;
        }

        $sql = "INSERT INTO annual_event_approvals (event_id, approver_id, approval_status) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $this->db->error);
        }

        $stmt->bind_param("iis", $eventId, $approverId, $status);
        return $stmt->execute();
    }

    // Check if user has already approved
    public function hasUserApprovedAnnualEvent($eventId, $approverId)
    {
        $sql = "SELECT approval_id FROM annual_event_approvals WHERE event_id = ? AND approver_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $eventId, $approverId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Get approval count for an event (only 'approved' status)
    public function getAnnualEventApprovalsCount($eventId)
    {
        $sql = "SELECT COUNT(*) as count FROM annual_event_approvals WHERE event_id = ? AND approval_status = 'approved'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function getAnnualEventRejectionsCount($eventId)
    {
        $sql = "SELECT COUNT(*) as count FROM annual_event_approvals WHERE event_id = ? AND approval_status = 'rejected'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    // Get pending annual events for a specific representative (events they haven't approved yet)
    public function getPendingAnnualEventsForRep($repId)
    {
        $sql = "SELECT vp.*, u.name as organizer_name 
                FROM volunteering_program vp
                LEFT JOIN user u ON vp.organizer_id = u.userid
                WHERE vp.is_annual = 1 
                AND (vp.isauthorized IS NULL OR vp.isauthorized = 0)
                AND vp.state_of_event = 'planned'
                AND vp.is_deleted = 0
                AND vp.event_id NOT IN (
                    SELECT event_id FROM annual_event_approvals WHERE approver_id = ?
                )
                ORDER BY vp.createddate DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $repId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get ALL annual events for a rep, including their approval status (for history)
    public function getAllAnnualEventsForRep($repId)
    {
        $sql = "SELECT 
                    vp.*, 
                    u.name as organizer_name,
                    aea.approval_status as my_approval_status,
                    aea.approval_date,
                    (SELECT GROUP_CONCAT(CONCAT(u2.name, ': ', aea2.approval_status) SEPARATOR ', ')
                     FROM annual_event_approvals aea2
                     JOIN user u2 ON aea2.approver_id = u2.userid
                     WHERE aea2.event_id = vp.event_id AND aea2.approver_id != ?) as other_approval_details
                FROM volunteering_program vp
                LEFT JOIN user u ON vp.organizer_id = u.userid
                LEFT JOIN annual_event_approvals aea ON vp.event_id = aea.event_id AND aea.approver_id = ?
                WHERE vp.is_annual = 1 
                AND vp.is_deleted = 0
                AND vp.state_of_event = 'planned'
                ORDER BY vp.createddate DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $repId, $repId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get all annual events with their current approval status (for Manager view)
    public function getAllAnnualEventsWithStatus()
    {
        $sql = "SELECT 
                    vp.*,
                    (SELECT COUNT(*) FROM annual_event_approvals aea WHERE aea.event_id = vp.event_id AND aea.approval_status = 'approved') as approval_count,
                    (SELECT COUNT(*) FROM annual_event_approvals aea WHERE aea.event_id = vp.event_id AND aea.approval_status = 'rejected') as rejection_count,
                    (SELECT GROUP_CONCAT(CONCAT(u2.name, ' (', aea.approval_status, ')') SEPARATOR ', ') 
                     FROM annual_event_approvals aea 
                     JOIN user u2 ON aea.approver_id = u2.userid 
                     WHERE aea.event_id = vp.event_id) as approval_details,
                    u.name as organizer_name
                FROM volunteering_program vp
                LEFT JOIN user u ON vp.organizer_id = u.userid
                WHERE vp.is_annual = 1 
                AND vp.is_deleted = 0
                AND vp.state_of_event = 'planned'
                ORDER BY vp.createddate DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            die("SQL Error: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function insertBudgetItems($eventId, $budgetItems, $budgetPrices)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO event_budget_item (event_id, item_name, item_price) 
             VALUES (?, ?, ?)"
            );

            for ($i = 0; $i < count($budgetItems); $i++) {
                $itemName = $budgetItems[$i];
                $itemPrice = $budgetPrices[$i];

                $stmt->bind_param("isd", $eventId, $itemName, $itemPrice);
                $stmt->execute();
            }

            return true;
        } catch (Exception $e) {
            error_log("Error inserting budget items: " . $e->getMessage());
            return false;
        }
    }
    public function getBudgetItemsByEventId($eventId)
    {
        $stmt = $this->db->prepare(
            "SELECT budget_item_id, item_name, item_price, created_date 
         FROM event_budget_item 
         WHERE event_id = ? 
         ORDER BY budget_item_id ASC"
        );

        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getTotalBudgetByEventId($eventId)
    {
        $stmt = $this->db->prepare(
            "SELECT SUM(item_price) as total_budget 
         FROM event_budget_item 
         WHERE event_id = ?"
        );

        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total_budget'] ?? 0;
    }

    public function deleteBudgetItemsByEventId($eventId)
    {
        $stmt = $this->db->prepare("DELETE FROM event_budget_item WHERE event_id = ?");
        $stmt->bind_param("i", $eventId);
        return $stmt->execute();
    }

    public function updateBudgetItems($eventId, $budgetItems, $budgetPrices)
    {
        // Delete existing items
        $this->deleteBudgetItemsByEventId($eventId);

        // Insert new items
        return $this->insertBudgetItems($eventId, $budgetItems, $budgetPrices);
    }
    public function getAnnualEvents() 
    {
        $stmt = $this->db->prepare("SELECT event_id as eventid, name, event_date, location FROM volunteering_program WHERE is_annual = 1 AND is_deleted = 0 AND state_of_event = 'planned'");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}

?>