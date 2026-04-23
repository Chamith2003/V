<?php
// Model/InventoryModel.php

class InventoryModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Get all active inventory items with their stock information
     * Based on actual database structure: item table
     */
    public function getAllActiveItems() {
        $query = "SELECT 
                    itemid,
                    itemtype,
                    description,
                    image_path,
                    price,
                    stock_XS,
                    stock_S,
                    stock_M,
                    stock_L,
                    stock_XL,
                    stock_XXL,
                    managinguserid
                  FROM item
                  WHERE is_active = 1
                  ORDER BY itemid";
        
        $result = $this->conn->query($query);
        
        if (!$result) {
            return [];
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get specific item by ID
     */
    public function getItemById($itemid) {
        $query = "SELECT 
                    itemid,
                    itemtype,
                    emoji,
                    description,
                    price,
                    stock_XS,
                    stock_S,
                    stock_M,
                    stock_L,
                    stock_XL,
                    stock_XXL,
                    managinguserid
                  FROM item
                  WHERE itemid = ? AND is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $itemid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get volunteer's star points
     * Based on actual database structure: volunteer table
     */
    public function getVolunteerPoints($userid) {
        $query = "SELECT starpoints FROM volunteer WHERE userid = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row ? (int)$row['starpoints'] : 0;
    }
    
    /**
     * Update volunteer's star points after purchase
     */
    public function updateVolunteerPoints($userid, $newPoints) {
        $query = "UPDATE volunteer SET starpoints = ? WHERE userid = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $newPoints, $userid);
        
        return $stmt->execute();
    }
    
    /**
     * Update inventory stock after purchase
     * Dynamically updates the correct size column
     */
    public function updateInventoryStock($itemid, $size, $quantity) {
        // Map size to column name
        $sizeColumn = 'stock_' . $size;
        
        // Validate size column exists
        $validSizes = ['stock_XS', 'stock_S', 'stock_M', 'stock_L', 'stock_XL', 'stock_XXL'];
        if (!in_array($sizeColumn, $validSizes)) {
            return false;
        }
        
        // Update stock - decrease by quantity
        $query = "UPDATE item 
                  SET $sizeColumn = $sizeColumn - ? 
                  WHERE itemid = ? AND $sizeColumn >= ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $quantity, $itemid, $quantity);
        
        return $stmt->execute() && $stmt->affected_rows > 0;
    }
    
    /**
     * Get stock for a specific size
     */
    public function getSizeStock($itemid, $size) {
        $sizeColumn = 'stock_' . $size;
        
        $query = "SELECT $sizeColumn as stock_quantity FROM item WHERE itemid = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $itemid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Create purchase record in item_purchase_log
     * Based on actual database structure: item_purchase_log table
     */
    public function createPurchaseLog($volunteer_id, $itemid, $quantity) {
        $query = "INSERT INTO item_purchase_log 
                  (volunteer_id, itemid, quantity_taken, purchase_date)
                  VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $volunteer_id, $itemid, $quantity);
        
        return $stmt->execute();
    }
    
    /**
     * Get volunteer's purchase history
     */
    public function getVolunteerPurchases($volunteer_id) {
        $query = "SELECT 
                    l.log_id,
                    l.volunteer_id,
                    l.itemid,
                    l.quantity_taken,
                    l.purchase_date,
                    i.itemtype,
                    i.emoji,
                    i.description,
                    i.price
                  FROM item_purchase_log l
                  JOIN item i ON l.itemid = i.itemid
                  WHERE l.volunteer_id = ?
                  ORDER BY l.purchase_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->conn->begin_transaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return $this->conn->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->conn->rollback();
    }
}
?>