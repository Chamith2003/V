<?php
// C:\wamp64\www\V\Model\emailmodel.php

class emailmodel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Find user row by email (returns associative array or null)
    public function findUserByEmail($email) {
        $sql = "SELECT userid, email, name FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }

    // Update password (hashed) by email
    public function updatePasswordByEmail($email, $passwordHash) {
        $sql = "UPDATE user SET password = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('ss', $passwordHash, $email);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>