<?php
class requestmodel
{
private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Fetch all representative applications
    public function getAllRepApplications()
    {
        $stmt = $this->conn->prepare("SELECT * FROM request WHERE type = 'applytoberep' ORDER BY date DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Update request status AND approver manager ID
    public function updateRequestStatusWithManager($requestId, $status, $managerId)
    {
        $stmt = $this->conn->prepare("UPDATE request 
                                    SET status = ?, approver_manager_id = ? 
                                    WHERE request_id = ?");
        $stmt->bind_param("sii", $status, $managerId, $requestId);
        return $stmt->execute();
    }

    // Get single request by ID
    public function getRequestById($requestId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM request WHERE request_id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>