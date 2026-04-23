<?php
$order_id = $purchaseData['order_id'] ?? 'N/A';
$transaction_id = $purchaseData['transaction_id'] ?? 'N/A';
$transaction_date = $purchaseData['transaction_date'] ?? date('F j, Y g:i A');
$item_name = $purchaseData['item_name'] ?? 'Item';
$quantity = $purchaseData['quantity'] ?? 0;
$amount = $purchaseData['amount'] ?? '0.00';
$discount = $purchaseData['discount'] ?? '0.00';
$points_used = $purchaseData['points_used'] ?? 0;

// Check if user is a sponsor to hide irrelevant fields
$is_sponsor = (isset($_SESSION['role']) && $_SESSION['role'] === 'sponsor');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase Successful</title>
    <link rel="stylesheet" type="text/css" href="/V/View/donations/successfuldonation.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>
<body>
    <div class="container">
        <h1 class="title">Purchase Successful!</h1>
        <p class="subtitle">Thank you for your purchase</p>
        <div class="success-icon">
            <div class="checkmark"></div>
        </div>
        
        <div class="completion-card">
            <div class="completion-box">
                <div class="section-header">
                   Transaction Details 
                </div>
                <div class="completion-grid">
                    <div class="detail-row">
                        <span class="detail-label">Order ID</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order_id); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Transaction ID </span>
                        <span class="detail-value"><?php echo htmlspecialchars($transaction_id); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date & Time</span>
                        <span class="detail-value"><?php echo htmlspecialchars($transaction_date); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Item</span>
                        <span class="detail-value"><?php echo htmlspecialchars($item_name); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Quantity</span>
                        <span class="detail-value"><?php echo htmlspecialchars($quantity); ?></span>
                    </div>
                    <?php if (!$is_sponsor): ?>
                    <div class="detail-row">
                        <span class="detail-label">Star Points Used</span>
                        <span class="detail-value"><?php echo htmlspecialchars($points_used); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Discount Applied</span>
                        <span class="detail-value">LKR <?php echo htmlspecialchars(number_format($discount, 2)); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="amount-highlight">
                        <div class="amount-label">Total Amount Paid</div>
                        <div class="amount-value">LKR <?php echo htmlspecialchars($amount); ?></div>
                    </div>

                    

                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="window.print()">Download Receipt</button>
                        <button class="btn btn-secondary" onclick="window.location.href='/V/router.php?module=merch&action=buymerch'">Back to Store</button>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
    <script>
        // Check if transaction ID is available, refresh if not
        document.addEventListener('DOMContentLoaded', function() {
            const transactionId = '<?php echo addslashes($transaction_id); ?>';
            const orderId = '<?php echo addslashes($order_id); ?>';

            console.log('Transaction ID:', transactionId);
            console.log('Order ID:', orderId);

            if (transactionId === 'Not Available' || transactionId === 'N/A' || transactionId === '') {
                console.log('Transaction ID not available, will refresh in 3 seconds...');
                // Wait 3 seconds and refresh to allow notify to complete
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            } else {
                console.log('Transaction ID found:', transactionId);
            }
        });
    </script>
</body>
</html>