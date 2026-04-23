<?php
class ItemModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllItems() {
        $stmt = $this->conn->prepare("SELECT * FROM item WHERE is_active = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getItemById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM item WHERE itemid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createItem($data) {
        $sizes = $data['sizes'] ?? [];
        $stmt = $this->conn->prepare(
            "INSERT INTO item (itemtype, description, image_path, price, stock_XS, stock_S, stock_M, stock_L, stock_XL, stock_XXL, managingUserId, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,1)"
        );

        $itemtype = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $image_path = $data['image_path'] ?? null;
        $price = isset($data['price']) ? (float)$data['price'] : 0;

        $stock_XS = isset($sizes['XS']) ? (int)$sizes['XS'] : 0;
        $stock_S  = isset($sizes['S'])  ? (int)$sizes['S']  : 0;
        $stock_M  = isset($sizes['M'])  ? (int)$sizes['M']  : 0;
        $stock_L  = isset($sizes['L'])  ? (int)$sizes['L']  : 0;
        $stock_XL = isset($sizes['XL']) ? (int)$sizes['XL'] : 0;
        $stock_XXL= isset($sizes['XXL'])? (int)$sizes['XXL']: 0;

        $managingUserId = 3; // default value or get from session: $_SESSION['user_id']

        $stmt->bind_param(
            "sssdiiiiiii",
            $itemtype, $description, $image_path, $price,
            $stock_XS, $stock_S, $stock_M,
            $stock_L, $stock_XL, $stock_XXL,
            $managingUserId
        );

        if($stmt->execute()){
            return $this->conn->insert_id;
        }
        return false;
    }

    public function updateItem($id, $data) {
        $sizes = $data['sizes'] ?? [];
        $stmt = $this->conn->prepare(
            "UPDATE item SET itemtype=?, description=?, image_path=?, price=?, stock_XS=?, stock_S=?, stock_M=?, stock_L=?, stock_XL=?, stock_XXL=?, managingUserId=? WHERE itemid=?"
        );

        $itemtype = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $image_path = $data['image_path'] ?? null;
        //$emoji = $data['emoji'] ?? '👕';
        $price = isset($data['price']) ? (float)$data['price'] : 0;

        $stock_XS = isset($sizes['XS']) ? (int)$sizes['XS'] : 0;
        $stock_S  = isset($sizes['S'])  ? (int)$sizes['S']  : 0;
        $stock_M  = isset($sizes['M'])  ? (int)$sizes['M']  : 0;
        $stock_L  = isset($sizes['L'])  ? (int)$sizes['L']  : 0;
        $stock_XL = isset($sizes['XL']) ? (int)$sizes['XL'] : 0;
        $stock_XXL= isset($sizes['XXL'])? (int)$sizes['XXL']: 0;

        $managingUserId = 3;

        $stmt->bind_param(
            "sssdiiiiiiii",
            $itemtype, $description, $image_path, $price,
            $stock_XS, $stock_S, $stock_M,
            $stock_L, $stock_XL, $stock_XXL, $managingUserId,
            $id
        );

        return $stmt->execute();
    }

    public function deleteItem($id) {
        //chnaged ffrom a hard delte to a soft delete
       // $stmt = $this->conn->prepare("DELETE FROM item WHERE itemid=?");
        $stmt = $this->conn->prepare("UPDATE item SET is_active = 0 WHERE itemid = ?");
       $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>