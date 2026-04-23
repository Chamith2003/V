<?php


class InventoryController {
    private $model;
    
    // Business logic constants
    const MIN_POINTS_REQUIRED = 500;
    const MAX_DISCOUNT_PERCENTAGE = 0.2; // 20% max discount
    const POINTS_TO_RUPEES_RATIO = 100; // 100 points = 1 rupee discount
    
    public function __construct($conn) {
        $this->model = new InventoryModel($conn);
    }
    
    /**
     * Display inventory page
     */
    public function index() {
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Please login to access the merchandise store';
            $_SESSION['message_type'] = 'error';
            header('Location: /V/router.php?module=user&action=login');
            exit();
        }
        
        $userid = $_SESSION['user_id'];
        
        // Get volunteer's star points
        $starPoints = $this->model->getVolunteerPoints($userid);
        
        // Get all active inventory items
        $items = $this->model->getAllActiveItems();
        
        // Prepare items data for view
        $itemsData = [];
        foreach ($items as $item) {
            $itemsData[] = [
                'itemid' => $item['itemid'],
                'itemtype' => $item['itemtype'],

                'description' => $item['description'],
                'image_path' => $item['image_path'],
                'price' => number_format($item['price'], 2),
                'price_raw' => $item['price'],
                'sizes' => [
                    'XS' => $item['stock_XS'],
                    'S' => $item['stock_S'],
                    'M' => $item['stock_M'],
                    'L' => $item['stock_L'],
                    'XL' => $item['stock_XL'],
                    'XXL' => $item['stock_XXL']
                ]
            ];
        }
        
        // Pass data to view
        require_once __DIR__ . '/../View/buymerch/inventory.php';
    }
    
    /**
     * Get inventory items (AJAX)
     */
    public function getItems() {
        header('Content-Type: application/json');
        
        $items = $this->model->getAllActiveItems();
        
        $itemsFormatted = [];
        foreach ($items as $item) {
            $itemsFormatted[] = [
                'itemid' => $item['itemid'],
                'itemtype' => $item['itemtype'],
                'description' => $item['description'],
                'price' => $item['price'],
                'sizes' => [
                    'XS' => $item['stock_XS'],
                    'S' => $item['stock_S'],
                    'M' => $item['stock_M'],
                    'L' => $item['stock_L'],
                    'XL' => $item['stock_XL'],
                    'XXL' => $item['stock_XXL']
                ]
            ];
        }
        
        echo json_encode([
            'success' => true,
            'items' => $itemsFormatted
        ]);
    }
    
    /**
     * Get volunteer star points (AJAX)
     */
    public function getVolunteerPoints() {
        header('Content-Type: application/json');
        
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $userid = $_SESSION['user_id'];
        $points = $this->model->getVolunteerPoints($userid);
        
        echo json_encode([
            'success' => true,
            'points' => $points,
            'canUseDiscount' => $points >= self::MIN_POINTS_REQUIRED,
            'minRequired' => self::MIN_POINTS_REQUIRED
        ]);
    }
    
    /**
     * Calculate discount based on star points
     */
    private function calculateDiscount($itemPrice, $quantity, $currentPoints) {
        if ($currentPoints < self::MIN_POINTS_REQUIRED) {
            return [
                'discount_amount' => 0,
                'points_used' => 0,
                'can_afford' => false
            ];
        }
        
        $subtotal = $itemPrice * $quantity;
        
        // Maximum discount allowed (25% of subtotal)
        $maxDiscount = $subtotal * self::MAX_DISCOUNT_PERCENTAGE;
        
        // Calculate discount from available points
        // 100 points = 1 rupee discount
        $possibleDiscount = $currentPoints / self::POINTS_TO_RUPEES_RATIO;
        
        // Use the minimum of max allowed discount or possible discount
        $actualDiscount = min($maxDiscount, $possibleDiscount);
        
        // Calculate points needed
        $pointsNeeded = $actualDiscount * self::POINTS_TO_RUPEES_RATIO;
        
        return [
            'discount_amount' => $actualDiscount,
            'points_used' => $pointsNeeded,
            'can_afford' => $currentPoints >= $pointsNeeded
        ];
    }
    
    /**
     * Validate purchase request
     */
    private function validatePurchase($data, $currentPoints) {
        $errors = [];
        
        // Validate item
        if (empty($data['itemid'])) {
            $errors[] = 'Item ID is required';
        }
        
        // Validate size
        if (empty($data['size'])) {
            $errors[] = 'Size selection is required';
        }
        
        $validSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        if (!in_array($data['size'], $validSizes)) {
            $errors[] = 'Invalid size selected';
        }
        
        // Validate quantity
        if (empty($data['quantity']) || $data['quantity'] < 1) {
            $errors[] = 'Valid quantity is required';
        }
        
        // Check stock availability
        $item = $this->model->getItemById($data['itemid']);
        if (!$item) {
            $errors[] = 'Item not found';
            return $errors;
        }
        
        $sizeColumn = 'stock_' . $data['size'];
        $availableStock = $item[$sizeColumn];
        
        if ($availableStock < $data['quantity']) {
            $errors[] = "Insufficient stock. Only {$availableStock} items available in size {$data['size']}";
        }
        
        // Validate star points usage
        if ($data['use_star_points']) {
            if ($currentPoints < self::MIN_POINTS_REQUIRED) {
                $errors[] = 'You need at least ' . self::MIN_POINTS_REQUIRED . ' points to use discount';
            }
            
            $discount = $this->calculateDiscount($item['price'], $data['quantity'], $currentPoints);
            
            if (!$discount['can_afford']) {
                $errors[] = 'Insufficient star points for this purchase';
            }
        }
        
        return $errors;
    }
    
    /**
     * Process purchase (AJAX)
     */
    public function processPurchase() {
        header('Content-Type: application/json');
        
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        $userid = $_SESSION['user_id'];
        $itemid = $input['itemid'] ?? null;
        $size = $input['size'] ?? null;
        $quantity = (int)($input['quantity'] ?? 0);
        $useStarPoints = (bool)($input['use_star_points'] ?? false);
        
        $currentPoints = $this->model->getVolunteerPoints($userid);
        
        // Validate purchase
        $errors = $this->validatePurchase([
            'itemid' => $itemid,
            'size' => $size,
            'quantity' => $quantity,
            'use_star_points' => $useStarPoints
        ], $currentPoints);
        
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'message' => implode(', ', $errors)
            ]);
            return;
        }
        
        try {
            // Start transaction
            $this->model->beginTransaction();
            
            // Get item details
            $item = $this->model->getItemById($itemid);
            
            // Calculate amounts
            $subtotal = $item['price'] * $quantity;
            $discountAmount = 0;
            $pointsUsed = 0;
            
            if ($useStarPoints) {
                $discount = $this->calculateDiscount($item['price'], $quantity, $currentPoints);
                $discountAmount = $discount['discount_amount'];
                $pointsUsed = $discount['points_used'];
            }
            
            $finalAmount = $subtotal - $discountAmount;
            
            // Update inventory stock
            $stockUpdated = $this->model->updateInventoryStock($itemid, $size, $quantity);
            if (!$stockUpdated) {
                throw new Exception('Failed to update inventory stock');
            }
            
            // Update volunteer points if used
            if ($pointsUsed > 0) {
                $newPoints = $currentPoints - $pointsUsed;
                $pointsUpdated = $this->model->updateVolunteerPoints($userid, $newPoints);
                if (!$pointsUpdated) {
                    throw new Exception('Failed to update star points');
                }
            }
            
            // Create purchase log
            $purchaseCreated = $this->model->createPurchaseLog($userid, $itemid, $quantity);
            if (!$purchaseCreated) {
                throw new Exception('Failed to create purchase record');
            }
            
            // Commit transaction
            $this->model->commit();
            
            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Purchase completed successfully',
                'data' => [
                    'itemtype' => $item['itemtype'],
                    'size' => $size,
                    'quantity' => $quantity,
                    'subtotal' => number_format($subtotal, 2),
                    'discount_amount' => number_format($discountAmount, 2),
                    'points_used' => $pointsUsed,
                    'final_amount' => number_format($finalAmount, 2),
                    'new_points_balance' => $currentPoints - $pointsUsed
                ]
            ]);
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->model->rollback();
            
            echo json_encode([
                'success' => false,
                'message' => 'Purchase failed: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get purchase history (AJAX)
     */
    public function getPurchaseHistory() {
        header('Content-Type: application/json');
        
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $userid = $_SESSION['user_id'];
        $purchases = $this->model->getVolunteerPurchases($userid);
        
        echo json_encode([
            'success' => true,
            'purchases' => $purchases
        ]);
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /V/router.php?module=merch&action=buymerch");
            exit();
        }

        // Get payment data from POST
        $itemId = intval($_POST['item_id'] ?? 0);
        $size = $_POST['size'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);
        $usePoints = isset($_POST['use_points']) && $_POST['use_points'] === 'true';
        $pointsToRedeem = intval($_POST['points_to_redeem'] ?? 0);
        $finalAmount = floatval($_POST['final_amount'] ?? 0);
        
        if (!$itemId || !$size || $quantity <= 0) {
            $_SESSION['message'] = 'Invalid purchase data';
            $_SESSION['message_type'] = 'error';
            header("Location: /V/router.php?module=merch&action=buymerch");
            exit();
        }

        // Generate unique order ID
        $order_id = 'MERCH-' . time() . '-' . rand(1000, 9999);
        
        // Get item details
        $item = $this->model->getItemById($itemId);
        
        if (!$item) {
            $_SESSION['message'] = 'Item not found';
            $_SESSION['message_type'] = 'error';
            header("Location: /V/router.php?module=merch&action=buymerch");
            exit();
        }
        
        // Store purchase data in session for later
        $_SESSION['pending_purchase'] = [
            'order_id' => $order_id,
            'item_id' => $itemId,
            'item_name' => $item['itemtype'],
            'item_price' => $item['price'],
            'size' => $size,
            'quantity' => $quantity,
            'use_points' => $usePoints,
            'points_redeemed' => $pointsToRedeem,
            'final_amount' => $finalAmount,
            'user_id' => $_SESSION['user_id']
        ];

        // Prepare PayHere payment data
        $merchant_id = '1232952'; // Your PayHere merchant ID
        
        $amount = number_format($finalAmount, 2, '.', '');
        $currency = "LKR";

        $hashedSecret = strtoupper(md5($this->merchant_secret));
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $amount . 
                $currency . 
                $hashedSecret
            )
        );

        $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        
        // Get user details
        require_once 'Model/usermodel.php';
        $userModel = new usermodel($this->model->conn ?? $GLOBALS['conn']);
        $userDetails = $userModel->getUserById($_SESSION['user_id']);
        
        $paymentData = [
            'merchant_id' => $merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'currency' => $currency,
            'hash' => $hash,
            'items' => 'Merchandise - ' . $item['itemtype'],
            'first_name' => $userDetails['name'] ?? 'Customer',
            'last_name' => '',
            'email' => $userDetails['email'] ?? '',
            'phone' => $userDetails['contactnumber'] ?? '',
            'address' => $userDetails['address'] ?? 'N/A',
            'city' => $userDetails['city'] ?? 'Colombo',
            'country' => 'Sri Lanka',
            'return_url' => $base_url . '/V/router.php?module=merch&action=paymentsuccess&order_id=' . $order_id,
            'cancel_url' => $base_url . '/V/router.php?module=merch&action=buymerch',
            'notify_url' => $base_url . '/V/router.php?module=merch&action=payherenotify',
            'custom_1' => $itemId,
            'custom_2' => $_SESSION['user_id']
        ];
        
        // Load the processpayment.php file (this will show the redirect page)
        include __DIR__ . '/../View/buymerch/processpayment.php';
    }
}
?>