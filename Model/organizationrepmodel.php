<?php
class organizationrepmodel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllRepresentatives()
    {
        $query = "SELECT u.userid, u.name, u.email, u.contactnumber, 
                  r.duration, r.appointeddate, v.levelpoints
                  FROM user u
                  INNER JOIN representative r ON u.userid = r.userid
                  LEFT JOIN volunteer v ON u.userid = v.userid
                  WHERE u.role = 'representative' AND u.status = 'active'
                  ORDER BY v.levelpoints DESC
                  LIMIT 2";

        $result = $this->conn->query($query);
        $representatives = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $representatives[] = $row;
            }
        }

        return $representatives;
    }

    public function getCurrentOrgRepresentatives()
    {
        $query = "SELECT u.userid, u.name, u.email, u.contactnumber, 
                  o.duration, o.appointeddate
                  FROM user u
                  INNER JOIN org_representative o ON u.userid = o.userid
                  WHERE u.role = 'organisationrep' AND u.status = 'active' AND o.is_active = 1
                  ORDER BY o.appointeddate DESC";

        $result = $this->conn->query($query);
        $orgReps = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orgReps[] = $row;
            }
        }

        return $orgReps;
    }

    public function countCurrentOrgReps()
    {
        $query = "SELECT COUNT(*) as count FROM user 
                  WHERE role = 'organisationrep' AND status = 'active'";

        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return (int) $row['count'];
        }

        return 0;
    }

    public function promoteToOrgRep($userId)
    {
        $this->conn->begin_transaction();

        try {
            $updateUserQuery = "UPDATE user SET role = 'organisationrep' WHERE userid = ?";
            $stmt1 = $this->conn->prepare($updateUserQuery);
            $stmt1->bind_param("i", $userId);
            $stmt1->execute();

            $appointedDate = date('Y-m-d');
            $duration = 12;

            $checkQuery = "SELECT userid FROM org_representative WHERE userid = ?";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bind_param("i", $userId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $upsertQuery = "UPDATE org_representative SET is_active = 1, duration = ?, appointeddate = ? WHERE userid = ?";
                $stmt2 = $this->conn->prepare($upsertQuery);
                $stmt2->bind_param("isi", $duration, $appointedDate, $userId);
            } else {
                $upsertQuery = "INSERT INTO org_representative (userid, duration, appointeddate, is_active) VALUES (?, ?, ?, 1)";
                $stmt2 = $this->conn->prepare($upsertQuery);
                $stmt2->bind_param("iis", $userId, $duration, $appointedDate);
            }
            $stmt2->execute();

            $updateRepQuery = "UPDATE representative SET isorgrep = 1 WHERE userid = ?";
            $stmt3 = $this->conn->prepare($updateRepQuery);
            $stmt3->bind_param("i", $userId);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function downgradeExpiredOrgReps()
    {
        $query = "SELECT userid, appointeddate FROM org_representative 
                  WHERE is_active = 1 AND DATE_ADD(appointeddate, INTERVAL 12 MONTH) <= CURDATE()";

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
            $updateUserQuery = "UPDATE user SET role = 'volunteer' WHERE userid = ?";
            $stmt1 = $this->conn->prepare($updateUserQuery);
            $stmt1->bind_param("i", $userId);
            $stmt1->execute();

            $updateRepQuery = "UPDATE representative SET isorgrep = 0, is_active = 0 WHERE userid = ?";
            $stmt2 = $this->conn->prepare($updateRepQuery);
            $stmt2->bind_param("i", $userId);
            $stmt2->execute();

            $updateOrgRepQuery = "UPDATE org_representative SET is_active = 0 WHERE userid = ?";
            $stmt3 = $this->conn->prepare($updateOrgRepQuery);
            $stmt3->bind_param("i", $userId);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function isTermExpired($userId)
    {
        $query = "SELECT duration, appointeddate FROM org_representative 
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

    public function isOrgRepresentative($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM org_representative WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>