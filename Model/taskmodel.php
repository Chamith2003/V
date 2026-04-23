<?php
class taskmodel
{
    private $modelvar;

    public function __construct($conn)
    {
        $this->modelvar = $conn;
    }



    public function fetchTasksByEvent($eventId)
    {
        $stmt = $this->modelvar->prepare("SELECT * FROM task WHERE event_id = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    //getevetname

    public function getEventName($eventId)
    {
        $stmt = $this->modelvar->prepare("SELECT name FROM volunteering_program WHERE event_id = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['name'] ?? 'Unknown Event';
    }

    //have to change this function, didnt do any chnages, continue in the moringn from here... we are cleaning up task page and making a model for that ugly ui
    public function fetchUnassignedVolunteersByEvent($eventId)
    {
        $stmt = $this->modelvar->prepare("
        SELECT v.userid as volunteer_id, u.name, u.email, u.contactnumber
        FROM volunteer v
        INNER JOIN user u ON v.userid = u.userid
        INNER JOIN event_participation ep ON v.userid = ep.volunteer_id
        WHERE ep.event_id = ? AND ep.participation_status='attended'
        AND v.userid NOT IN (
            SELECT volunteer_id FROM task_assignment WHERE task_id IN (
                SELECT task_id FROM task WHERE event_id = ?
            )
        )
    ");
        $stmt->bind_param("ii", $eventId, $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }






    public function createTask($taskData)
    {
        $stmt = $this->modelvar->prepare("
        INSERT INTO task (name, description, status, event_id, max_participants, organizer_id, createddate) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");


        $stmt->bind_param(
            "sssiii",
            $taskData['name'],
            $taskData['description'],
            $taskData['status'],
            $taskData['event_id'],
            $taskData['max_participants'],
            $taskData['organizer_id']
        );

        return $stmt->execute();
    }

    public function updateTask($taskId, $taskData)
    {
        $stmt = $this->modelvar->prepare("
        UPDATE task 
        SET name = ?, description = ?, event_id = ?, max_participants = ?, status = ?
        WHERE task_id = ?
    ");

        $stmt->bind_param(
            "ssiisi",
            $taskData['name'],
            $taskData['description'],
            $taskData['event_id'],
            $taskData['max_participants'],
            $taskData['status'],
            $taskId
        );

        return $stmt->execute();
    }


    public function deleteTask($taskId)
    {
        // Start transaction
        $this->modelvar->begin_transaction();

        try {
            // First, remove all volunteer assignments for this task
            $stmt1 = $this->modelvar->prepare("DELETE FROM task_assignment WHERE task_id = ?");
            $stmt1->bind_param("i", $taskId);
            $stmt1->execute();

            // Then delete the task
            $stmt2 = $this->modelvar->prepare("DELETE FROM task WHERE task_id = ?");
            $stmt2->bind_param("i", $taskId);
            $result = $stmt2->execute();

            // Commit transaction
            $this->modelvar->commit();
            return $result;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->modelvar->rollback();
            throw $e;
        }
    }


    public function getTaskById($taskId)
    {
        $stmt = $this->modelvar->prepare("
            SELECT t.*, u.name as creator_name
            FROM task t
            LEFT JOIN user u ON t.organizer_id = u.userid
            WHERE t.task_id = ?
        ");

        $stmt->bind_param("i", $taskId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }




    public function assignVolunteerToTask($taskId, $volunteerId)
    {
        $stmt = $this->modelvar->prepare("
        INSERT INTO task_assignment (task_id, volunteer_id, assignment_date) 
        VALUES (?, ?, NOW())
    ");

        $stmt->bind_param("ii", $taskId, $volunteerId);
        return $stmt->execute();
    }



    public function removeVolunteerFromTask($taskId, $volunteerId)
    {
        $stmt = $this->modelvar->prepare("
        DELETE FROM task_assignment 
        WHERE task_id = ? AND volunteer_id = ?
    ");

        $stmt->bind_param("ii", $taskId, $volunteerId);
        return $stmt->execute();
    }



    public function getTaskVolunteers($taskId)
    {//READ all the volunteers currently assigned to a specific task
        $stmt = $this->modelvar->prepare("
        SELECT v.userid as volunteer_id, u.name, ta.assignment_date
        FROM task_assignment ta
        JOIN volunteer v ON ta.volunteer_id = v.userid
        JOIN user u ON v.userid = u.userid
        WHERE ta.task_id = ?
        ORDER BY ta.assignment_date ASC
    ");

        $stmt->bind_param("i", $taskId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
        //get everything at once(instead of getting row by row) returned as an associative array with column names as keys eg:$row['name'] gives "Nadin"
    }




    public function isVolunteerAssignedToTask($taskId, $volunteerId)
    {
        $stmt = $this->modelvar->prepare("
        SELECT COUNT(*) as count 
        FROM task_assignment 
        WHERE task_id = ? AND volunteer_id = ?
    ");

        $stmt->bind_param("ii", $taskId, $volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['count'] > 0;
    }



    //     public function getAllVolunteers()
// {
//     $stmt = $this->modelvar->prepare("
//         SELECT v.userid as volunteer_id, u.name, u.email, u.contactnumber
//         FROM volunteer v
//         JOIN user u ON v.userid = u.userid
//         WHERE u.role = 'volunteer'
//         ORDER BY u.name ASC
//     ");

    //     $stmt->execute();
//     $result = $stmt->get_result();

    //     return $result->fetch_all(MYSQLI_ASSOC);
// }






    public function getVolunteerById($volunteerId)
    {
        $stmt = $this->modelvar->prepare("
        SELECT v.userid as volunteer_id, u.name, u.email, u.contactnumber
        FROM volunteer v
        JOIN user u ON v.userid = u.userid
        WHERE v.userid = ?
    ");

        $stmt->bind_param("i", $volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }



    // Get database connection for advanced operations

    public function getConnection()
    {
        return $this->modelvar;
    }
}
?>