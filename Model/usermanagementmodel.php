<?php
class usermanagementmodel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getAllUsers() {
        $sql = "SELECT 
                    u.userid,
                    u.name,
                    u.email,
                    u.contactnumber,
                    u.role,
                    u.createddate,
                    u.status,
                    COALESCE(v.levelpoints, 0) as levelpoints,
                    COALESCE(v.starpoints, 0) as starpoints,
                    COALESCE(v.noofmembers, 0) as noofmembers,
                    v.dob,
                    v.volunteer_experience,
                    v.preferred_location_1,
                    v.preferred_location_2,
                    v.preferred_location_3,
                    r.duration as rep_duration,
                    r.appointeddate as rep_appointeddate
                FROM user u
                LEFT JOIN volunteer v ON u.userid = v.userid AND u.role = 'volunteer'
                LEFT JOIN representative r ON u.userid = r.userid AND u.role = 'representative'
                WHERE u.role IN ('volunteer', 'representative', 'organisationrep', 'sponsor')
                ORDER BY u.createddate DESC";
        
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($userId) {
        $sql = "SELECT 
                    u.*,
                    COALESCE(v.levelpoints, 0) as levelpoints,
                    COALESCE(v.starpoints, 0) as starpoints,
                    COALESCE(v.noofmembers, 0) as noofmembers,
                    v.dob,
                    v.QR,
                    v.volunteer_experience,
                    v.preferred_location_1,
                    v.preferred_location_2,
                    v.preferred_location_3,
                    r.duration as rep_duration,
                    r.appointeddate as rep_appointeddate
                FROM user u
                LEFT JOIN volunteer v ON u.userid = v.userid
                LEFT JOIN representative r ON u.userid = r.userid
                WHERE u.userid = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUserSkills($userId) {
        $sql = "SELECT skill FROM volunteer_skill WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $skills = [];
        while ($row = $result->fetch_assoc()) {
            $skills[] = $row['skill'];
        }
        return $skills;
    }

    public function getUserAvailability($userId) {
        $sql = "SELECT availability FROM volunteer_availability WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $availability = [];
        while ($row = $result->fetch_assoc()) {
            $availability[] = $row['availability'];
        }
        return $availability;
    }

    public function getUserDisabilities($userId) {
        $sql = "SELECT disability FROM volunteer_disability WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $disabilities = [];
        while ($row = $result->fetch_assoc()) {
            $disabilities[] = $row['disability'];
        }
        return $disabilities;
    }

    public function getUserBadges($userId) {
        $sql = "SELECT badgeearned, earneddate FROM volunteer_badge WHERE userid = ? ORDER BY earneddate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUser($userId, $data) {
        // Start transaction
        $this->db->begin_transaction();
        
        try {
            // Update main user table
            $sql = "UPDATE user SET 
                    name = ?, 
                    email = ?, 
                    contactnumber = ?
                    WHERE userid = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", 
                $data['name'], 
                $data['email'], 
                $data['contactnumber'],
                $userId
            );
            $stmt->execute();

            // If volunteer, update volunteer table
            if ($data['role'] === 'volunteer' && isset($data['dob'])) {
                $sql = "UPDATE volunteer SET 
                        dob = ?,
                        noofmembers = ?,
                        volunteer_experience = ?,
                        preferred_location_1 = ?,
                        preferred_location_2 = ?,
                        preferred_location_3 = ?
                        WHERE userid = ?";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("sisssssi",
                    $data['dob'],
                    $data['noofmembers'],
                    $data['volunteer_experience'],
                    $data['preferred_location_1'],
                    $data['preferred_location_2'],
                    $data['preferred_location_3'],
                    $userId
                );
                $stmt->execute();

                // Update skills if provided
                if (isset($data['skills'])) {
                    // Delete existing skills
                    $this->db->query("DELETE FROM volunteer_skill WHERE userid = $userId");
                    
                    // Insert new skills
                    if (!empty($data['skills'])) {
                        foreach ($data['skills'] as $skill) {
                            $sql = "INSERT INTO volunteer_skill (userid, skill) VALUES (?, ?)";
                            $stmt = $this->db->prepare($sql);
                            $stmt->bind_param("is", $userId, $skill);
                            $stmt->execute();
                        }
                    }
                }

                // Update availability if provided
                if (isset($data['availability'])) {
                    // Delete existing availability
                    $this->db->query("DELETE FROM volunteer_availability WHERE userid = $userId");
                    
                    // Insert new availability
                    if (!empty($data['availability'])) {
                        foreach ($data['availability'] as $avail) {
                            $sql = "INSERT INTO volunteer_availability (userid, availability) VALUES (?, ?)";
                            $stmt = $this->db->prepare($sql);
                            $stmt->bind_param("is", $userId, $avail);
                            $stmt->execute();
                        }
                    }
                }
            }

            // If representative, update representative table
            if ($data['role'] === 'representative' && isset($data['duration'])) {
                $sql = "UPDATE representative SET 
                        duration = ?
                        WHERE userid = ?";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ii", $data['duration'], $userId);
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function updateUserStatus($userId, $status) {
        $sql = "UPDATE user SET status = ? WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $userId);
        return $stmt->execute();
    }

    public function deleteUser($userId) {
        // CASCADE DELETE will handle role tables automatically
        $sql = "DELETE FROM user WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function getUserStats() {
        $stats = [
            'total' => 0,
            'volunteers' => 0,
            'representatives' => 0,
            'sponsors' => 0,
            'managers' => 0,
            'admins' => 0
        ];

        // Get total users
        $result = $this->db->query("SELECT COUNT(*) as count FROM user");
        $stats['total'] = $result->fetch_assoc()['count'];

        // Get role counts
        $result = $this->db->query("SELECT role, COUNT(*) as count FROM user GROUP BY role");
        while ($row = $result->fetch_assoc()) {
            $stats[$row['role'] . 's'] = $row['count'];
        }

        return $stats;
    }

    public function searchUsers($searchTerm, $roleFilter) {
        $sql = "SELECT 
                    u.userid,
                    u.name,
                    u.email,
                    u.contactnumber,
                    u.role,
                    u.createddate,
                    u.status,
                    COALESCE(v.levelpoints, 0) as levelpoints,
                    COALESCE(v.starpoints, 0) as starpoints
                FROM user u
                LEFT JOIN volunteer v ON u.userid = v.userid
                WHERE 1=1";

        $params = [];
        $types = "";

        if (!empty($searchTerm)) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.contactnumber LIKE ?)";
            $searchParam = "%$searchTerm%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "sss";
        }

        if ($roleFilter !== 'all') {
            $sql .= " AND u.role = ?";
            $params[] = $roleFilter;
            $types .= "s";
        }

        $sql .= " ORDER BY u.createddate DESC";

        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>