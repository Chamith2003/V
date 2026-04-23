<?php
class ItemController {
    private $model;

    public function __construct($itemModel) {
        $this->model = $itemModel;
    }

    // Display all items
    public function displayItems() {
        try {
            $items = $this->model->getAllItems();
            
            // Transform items to include sizes array
            foreach ($items as &$item) {
                $item['sizes'] = [
                    'XS' => (int)($item['stock_XS'] ?? 0),
                    'S' => (int)($item['stock_S'] ?? 0),
                    'M' => (int)($item['stock_M'] ?? 0),
                    'L' => (int)($item['stock_L'] ?? 0),
                    'XL' => (int)($item['stock_XL'] ?? 0),
                    'XXL' => (int)($item['stock_XXL'] ?? 0)
                ];
            }
            
            return ['success' => true, 'data' => $items];
        } catch (Exception $e) {
            error_log("Error getting items: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load items', 'data' => []];
        }
    }

    // Create new item
    public function createItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->formatData($_POST);
            $newId = $this->model->createItem($data);

            if ($newId) {
                $_SESSION['message'] = 'Item created successfully!';
                $_SESSION['message_type'] = 'success';
                $_SESSION['item_id'] = $newId;
            } else {
                $_SESSION['message'] = 'Failed to create item';
                $_SESSION['message_type'] = 'error';
            }

            header("Location: /V/router.php?module=inventory&action=inventorymanagement");
            exit();
        }
    }

    // Update existing item
    public function updateItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            
            if ($id) {
                $data = $this->formatData($_POST);
                $success = $this->model->updateItem($id, $data);
                
                if ($success) {
                    $_SESSION['message'] = 'Item updated successfully!';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Failed to update item';
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                $_SESSION['message'] = 'Invalid item ID';
                $_SESSION['message_type'] = 'error';
            }

            header("Location: /V/router.php?module=inventory&action=inventorymanagement");
            exit();
        }
    }

    // Delete item
    public function deleteItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            
            if ($id) {
                $success = $this->model->deleteItem($id);
                
                if ($success) {
                    $_SESSION['message'] = 'Item deleted successfully!';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Failed to delete item';
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                $_SESSION['message'] = 'Invalid item ID';
                $_SESSION['message_type'] = 'error';
            }

            header("Location: /V/router.php?module=inventory&action=inventorymanagement");
            exit();
        }
    }

    // Format POST data for the model
    private function formatData($post) {
        $sizes = [];
        foreach (['XS','S','M','L','XL','XXL'] as $size) {
            if (isset($post['sizes'][$size])) {
                $sizes[$size] = (int)$post['sizes'][$size];
            }
        }

        return [
            'name' => $post['name'] ?? '',
            'description' => $post['description'] ?? '',
            'price' => isset($post['price']) ? (float)$post['price'] : 0,
            'image_path' => $this->handleImageUpload(),
            'sizes' => $sizes
        ];
    }

    private function handleImageUpload() {
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../View/uploads/items/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = strtolower(pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            return $_POST['existing_image'] ?? null;
        }

        $filename = 'item_' . time() . '_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $uploadDir . $filename)) {
            return '/V/View/uploads/items/' . $filename;
        }
    }
    return isset($_POST['existing_image']) && $_POST['existing_image'] !== ''
        ? $_POST['existing_image'] : null;
}
}
?>