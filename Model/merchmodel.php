<?php
class merchmodel {
    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* Record purchase in log table */
    public function recordPurchase($userid, $usertype, $itemid, $quantity, $size, $points_used, $discount, $paid_amount, $payment_id = NULL, $order_id = NULL) {
        $volunteer_id = ($usertype === 'volunteer') ? $userid : NULL;
        $sponsorid = ($usertype === 'sponsor') ? $userid : NULL;
        $stmt = $this->conn->prepare("
            INSERT INTO item_purchase_log (payment_id, order_id, volunteer_id, sponsorid, itemid, quantity_taken, size, points_used, discount, paid_amount, purchase_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("ssiiiisidd", $payment_id, $order_id, $volunteer_id, $sponsorid, $itemid, $quantity, $size, $points_used, $discount, $paid_amount);
        return $stmt->execute();
    }

    /* Update inventory stock for specific size */
    public function updateStock($itemid, $size, $quantity) {
        // Build dynamic column name (stock_XS, stock_S, etc.)
        $stock_column = 'stock_' . $size;
        
        $stmt = $this->conn->prepare("
            UPDATE item 
            SET $stock_column = $stock_column - ? 
            WHERE itemid = ? AND $stock_column >= ?
        ");
        $stmt->bind_param("iii", $quantity, $itemid, $quantity);
        
        $success = $stmt->execute();
        if (!$success) {
            error_log("SQL Error in updateStock: " . $stmt->error);
        }
        return $success && $stmt->affected_rows > 0;
    }

    /* Deduct star points from volunteer */
    public function deductStarPoints($userid, $points) {
        $stmt = $this->conn->prepare("
            UPDATE volunteer 
            SET starpoints = starpoints - ? 
            WHERE userid = ? AND starpoints >= ?
        ");
        $stmt->bind_param("iii", $points, $userid, $points);
        
        $success = $stmt->execute();
        if (!$success) {
            error_log("SQL Error in deductStarPoints: " . $stmt->error);
        }
        return $success && $stmt->affected_rows > 0;
    }
    

    /* Get volunteer's star points */
    public function getUserPoints($userid) {
        $stmt = $this->conn->prepare("
            SELECT starpoints 
            FROM volunteer 
            WHERE userid = ?
        ");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user ? (int)$user['starpoints'] : 0;
    }

    /* Get purchase by order ID */
    public function getPurchaseByOrderId($order_id) {
        $stmt = $this->conn->prepare("
            SELECT l.*, i.itemtype, i.price 
            FROM item_purchase_log l 
            JOIN item i ON l.itemid = i.itemid 
            WHERE l.order_id = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>