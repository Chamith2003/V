<?php

class merchcontroller {
    private $model;
    private $donationcontroller;
    
    public function __construct($merchmodel, $donationcontroller = null) {
        $this->model = $merchmodel;
        $this->donationcontroller = $donationcontroller;
    }

    
    
    public function handlePayHereNotify($payhere_data) {
         
        $merchant_id = $payhere_data['merchant_id'];
        $order_id = $payhere_data['order_id'];
        $payment_id = $payhere_data['payment_id'];
        $status_code = $payhere_data['status_code'];
        $md5sig = $payhere_data['md5sig'];
        $amount = $payhere_data['payhere_amount'];
        $currency = $payhere_data['payhere_currency'];
        
        // Verify hash for security
        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg=='; 
        $local_md5sig = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $amount . 
                $currency . 
                $status_code . 
                strtoupper(md5($merchant_secret))
            )
        );

        // Check if payment is successful and hash is valid
        if ($local_md5sig === $md5sig && $status_code == 2) {
            if ($this->fulfillOrder($order_id, $payment_id)) {
            }
        }

        http_response_code(200);
        echo "OK";
        exit();
    }

    public function fulfillOrder($order_id, $payment_id) {
        try {
            // 1. Update purchase record with real payment_id
            $stmt = $this->model->conn->prepare("
                UPDATE item_purchase_log 
                SET payment_id = ? 
                WHERE order_id = ? AND (payment_id IS NULL OR payment_id = '')
            ");
            $stmt->bind_param("ss", $payment_id, $order_id);
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                // 2. Get purchase details from database to update stock
                $purchase = $this->model->getPurchaseByOrderId($order_id);
                
                if ($purchase) {
                    $item_id = $purchase['itemid'];
                    $volunteer_id = $purchase['volunteer_id'];
                    $size = $purchase['size'];
                    $quantity = $purchase['quantity_taken'];
                    $points_to_redeem = $purchase['points_used'];
                
                    // 3. Update inventory stock
                    $stockUpdated = $this->model->updateStock($item_id, $size, $quantity);
                    
                    // 4. Deduct star points if volunteer used points for discount
                    if ($volunteer_id && $points_to_redeem > 0) {
                        $this->model->deductStarPoints($volunteer_id, $points_to_redeem);
                    }
                    return true;
                }
            } else {
                
                // If the order already has a payment_id, it means it's already fulfilled
                $checkStmt = $this->model->conn->prepare("SELECT payment_id FROM item_purchase_log WHERE order_id = ?");
                $checkStmt->bind_param("s", $order_id);
                $checkStmt->execute();
                $res = $checkStmt->get_result()->fetch_assoc();
                if ($res && !empty($res['payment_id'])) {
                     return true; // Already fulfilled is success
                }
            }
        } catch (Exception $e) {
            // Keep error_log for real exceptions
            error_log("Merch fulfillment error: " . $e->getMessage());
        }
        return false;
    }
    
    /* Get purchase data for success page */
    public function getPurchaseData($userid, $usertype, $order_id) {
        $purchase = $this->model->getPurchaseByOrderId($order_id);
        
        if ($purchase) {
            if (($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') 
                && (empty($purchase['payment_id']))) {
                $mock_payment_id = 'MOCK-' . time();
                if ($this->fulfillOrder($order_id, $mock_payment_id)) {
                    // Re-fetch to get updated data
                    $purchase = $this->model->getPurchaseByOrderId($order_id);
                }
            }

            return [
                'order_id' => $purchase['order_id'],
                'transaction_id' => $purchase['payment_id'] ?? 'Pending',
                'transaction_date' => date('F j, Y g:i A', strtotime($purchase['purchase_date'])),
                'item_name' => $purchase['itemtype']. ' - Size ' . $purchase['size'],
                'quantity' => $purchase['quantity_taken'],
                'amount' => number_format($purchase['paid_amount'] ?? 0, 2),
                'discount' => number_format($purchase['discount'] ?? 0, 2),
                'points_used' => $purchase['points_used'] ?? 0
            ];
        }
        
        // Default data if no purchase found
        return [
            'transaction_id' => 'Not Available',
            'transaction_date' => date('F j, Y g:i A'),
            'item_name' => 'Merchandise Item',
            'quantity' => 0,
            'amount' => '0.00'
        ];
    }
    
    public function initiatePayment() {
        // Get user details
        $userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $usertype = isset($_SESSION['role']) ? $_SESSION['role'] : null;

        $sponsorid = ($usertype === 'sponsor') ? $userid : null;
        $volunteer_id = ($usertype === 'volunteer') ? $userid : null;

        $userName = '';
        $userEmail = '';
        $userPhone = '';

        if ($userid && $usertype && $this->donationcontroller) {
            $userDetails = $this->donationcontroller->getUserDetailsForDonation($userid, $usertype);
    
            if ($userDetails) {
                $userName = htmlspecialchars($userDetails['name']);
                $userEmail = htmlspecialchars($userDetails['email']);
                $userPhone = htmlspecialchars($userDetails['contactnumber']);
            }
        }
        
        // Get purchase data from POST
        $item_id = $_POST['item_id'] ?? '';
        $item_name = $_POST['itemtype'] ?? 'Merchandise';
        $size = $_POST['size'] ?? '';
        $quantity = $_POST['quantity_taken'] ?? 1;
        $use_points = $_POST['use_points'] ?? 'false';
        $points_to_redeem = $_POST['points_to_redeem'] ?? 0;
        $subtotal = $_POST['subtotal'] ?? 0;
        $discount = $_POST['discount'] ?? 0;
        $final_amount = $_POST['final_amount'] ?? 0;

        // Validate data
        if (empty($item_id) || empty($size) || $final_amount <= 0) {
            header('Location: /V/router.php?module=merch&action=buymerch');
            exit();
        }

        // Generate unique order ID
        $order_id = 'MERCH-' . time() . '-' . rand(1000, 9999);

        $this->model->recordPurchase($userid, $usertype, $item_id, $quantity, $size, $points_to_redeem, $_POST['discount'], $final_amount, NULL, $order_id);

        // PayHere Configuration
        $merchant_id = '1232952';
        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg=='; 

        $formatted_amount = number_format($final_amount, 2, '.', '');

        // Generate hash for security
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $formatted_amount . 
                'LKR' . 
                strtoupper(md5($merchant_secret))
            )
        );

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        // Prepare payment data
        $paymentData = [
            'merchant_id' => $merchant_id,
            'return_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=merch&action=successfulpurchase&order_id=' . $order_id,
            'cancel_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=merch&action=buymerch',
            'notify_url' => 'https://6677-2402-d000-8114-1046-4486-2c3-d678-7b38.ngrok-free.app/V/router.php?module=merch&action=payherenotify',
            'order_id' => $order_id,
            'items' => $item_name . ' - Size ' . $size . ' (Qty: ' . $quantity . ')',
            'currency' => 'LKR',
            'amount' => number_format($final_amount, 2, '.', ''),
    
            'first_name' => $userName,
            'last_name' => 'Customer',
            'email' => $userEmail,
            'phone' => $userPhone,
            'address' => 'N/A',
            'city' => 'Colombo',
            'country' => 'Sri Lanka',
    
            'hash' => $hash,
    
            // Custom fields to pass data to notify URL
            'custom_1' => $userid,
            'custom_2' => $item_id,
        ];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Processing...</title>
        </head>
        <body>
            <form method="post" id="payhere_form" action="https://sandbox.payhere.lk/pay/checkout">
                <input type="hidden" name="merchant_id" value="<?php echo $paymentData['merchant_id']; ?>">
                <input type="hidden" name="return_url" value="<?php echo $paymentData['return_url']; ?>">
                <input type="hidden" name="cancel_url" value="<?php echo $paymentData['cancel_url']; ?>">
                <input type="hidden" name="notify_url" value="<?php echo $paymentData['notify_url']; ?>">
                <input type="hidden" name="order_id" value="<?php echo $paymentData['order_id']; ?>">
                <input type="hidden" name="items" value="<?php echo $paymentData['items']; ?>">
                <input type="hidden" name="currency" value="<?php echo $paymentData['currency']; ?>">
                <input type="hidden" name="amount" value="<?php echo $paymentData['amount']; ?>">
                <input type="hidden" name="first_name" value="<?php echo $paymentData['first_name']; ?>">
                <input type="hidden" name="last_name" value="<?php echo $paymentData['last_name']; ?>">
                <input type="hidden" name="email" value="<?php echo $paymentData['email']; ?>">
                <input type="hidden" name="phone" value="<?php echo $paymentData['phone']; ?>">
                <input type="hidden" name="address" value="<?php echo $paymentData['address']; ?>">
                <input type="hidden" name="city" value="<?php echo $paymentData['city']; ?>">
                <input type="hidden" name="country" value="<?php echo $paymentData['country']; ?>">
                <input type="hidden" name="hash" value="<?php echo $paymentData['hash']; ?>">
                <input type="hidden" name="custom_1" value="<?php echo $paymentData['custom_1']; ?>">
                <input type="hidden" name="custom_2" value="<?php echo $paymentData['custom_2']; ?>">
            </form>
            <script>document.getElementById('payhere_form').submit();</script>
        </body>
        </html>
        <?php
        exit();
    }
}
?>