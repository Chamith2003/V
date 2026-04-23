<?php
class representativemodel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertApplication($data)
    {
        $query = "INSERT INTO request (requester_volunteer_id, description, linkedin, experience, status, type)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ississ",
            $data['requester_volunteer_id'],
            $data['description'],
            $data['linkedin'],
            $data['experience'],
            $data['status'],
            $data['type']
        );

        return $stmt->execute();
    }

    public function checkExistingApplication($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM request 
            WHERE requester_volunteer_id = ? AND type = 'applytoberep' AND status IN ('pending')
            ORDER BY request_id DESC 
            LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getApplicationStatus($userId)
    {
        $stmt = $this->conn->prepare("SELECT status FROM request 
            WHERE requester_volunteer_id = ? AND type = 'applytoberep'
            ORDER BY request_id DESC 
            LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['status'] : null;
    }

    public function updateApplication($userId, $data)
    {
        $query = "UPDATE request 
                SET description = ?,  
                    linkedin = ?, 
                    status = ?
                WHERE requester_volunteer_id = ? AND type = 'applytoberep'";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssisi",
            $data['description'],
            $data['linkedin'],
            $data['experience'],
            $data['status'],
            $userId
        );

        return $stmt->execute();
    }

    public function deleteApplication($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM request 
            WHERE requester_volunteer_id = ? AND type = 'applytoberep'");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function insertRepresentative($userId, $duration = 12)
    {
        $appointedDate = date('Y-m-d'); 

        $checkStmt = $this->conn->prepare("SELECT userid FROM representative WHERE userid = ?");
        $checkStmt->bind_param("i", $userId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $stmt = $this->conn->prepare("UPDATE representative SET is_active = 1, duration = ?, appointeddate = ?, isorgrep = 0 WHERE userid = ?");
            $stmt->bind_param("isi", $duration, $appointedDate, $userId);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO representative (userid, duration, appointeddate, is_active, isorgrep) VALUES (?, ?, ?, 1, 0)");
            $stmt->bind_param("iis", $userId, $duration, $appointedDate);
        }

        return $stmt->execute();
    }

    public function downgradeExpiredRepresentatives()
    {
        $query = "SELECT userid FROM representative 
                  WHERE is_active = 1 
                  AND isorgrep = 0 
                  AND DATE_ADD(appointeddate, INTERVAL duration MONTH) <= CURDATE()";

        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->downgradeToVolunteer($row['userid']);
            }
        }
    }

    public function downgradeToVolunteer($userId)
    {
        $this->conn->begin_transaction();
        try {
            $updateUser = $this->conn->prepare("UPDATE user SET role = 'volunteer' WHERE userid = ?");
            $updateUser->bind_param("i", $userId);
            $updateUser->execute();

            $updateRep = $this->conn->prepare("UPDATE representative SET is_active = 0 WHERE userid = ?");
            $updateRep->bind_param("i", $userId);
            $updateRep->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function isTermExpired($userId)
    {
        $query = "SELECT duration, appointeddate FROM representative 
                  WHERE userid = ? AND is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $appointedDate = new DateTime($row['appointeddate']);
            $duration = (int) $row['duration'];

            $expiryDate = (clone $appointedDate)->add(new DateInterval('P' . $duration . 'M'));
            $today = new DateTime();

            return $today > $expiryDate;
        }
        return false;
    }

    public function checkIfRepresentative($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM representative WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTotalRepresentatives()
    {
        $query = "SELECT COUNT(*) as count FROM representative WHERE is_active = 1";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['count'] ?? 0;
    }

    public function getTotalPendingApplications()
    {
        $query = "SELECT COUNT(*) as count FROM request WHERE type = 'applytoberep' AND status = 'pending'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['count'] ?? 0;
    }
    public function getActiveRepresentatives()
    {
        $query = "SELECT r.*, u.name, u.contactnumber 
                  FROM representative r
                  JOIN user u ON r.userid = u.userid
                  WHERE r.is_active = 1 AND r.isorgrep = 0";

        $result = $this->conn->query($query);

        $reps = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reps[] = $row;
            }
        }
        return $reps;
    }
}
?>