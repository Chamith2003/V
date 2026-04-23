<?php

$transaction_id = $donationData['transaction_id'] ?? 'N/A';
$transaction_date = $donationData['transaction_date'] ?? date('F j, Y g:i A');
$amount = $donationData['amount'] ?? '0.00';

?>

<!DOCTYPE html>
<html>
<head>
    <title>V - Donation Success</title>
    <link rel="stylesheet" type="text/css" href="/V/View/donations/successfuldonation.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>

<body>
    <div class="container">
        <h1 class="title">Donation Successful!</h1>
        <p class="subtitle">Thank you for your generous contribution</p>
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
                        <span class="detail-label">Transaction ID</span>
                        <span class="detail-value"><?php echo htmlspecialchars($transaction_id); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date & Time</span>
                        <span class="detail-value"><?php echo htmlspecialchars($transaction_date); ?></span>
                    </div>
                    
                    <div class="amount-highlight">
                        <div class="amount-label">Total Donation Amount</div>
                        <div class="amount-value">LKR <?php echo htmlspecialchars($amount); ?></div>
                    </div>

                    

                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="window.print()"> Download Receipt</button>
                        <button class="btn btn-secondary" onclick="window.location.href='/V/router.php?module=page&action=homepage'">← Back to Home</button>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    

    <script src="/V/View/donations/successfuldonation.js"></script> 
</body>
</html>