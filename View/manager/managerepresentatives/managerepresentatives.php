<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Representatives - V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" href="/V/View/manager/managerepresentatives/managerepresentatives.css">
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
</head>

<body>
    <div class="container-background">
        <div class="header">
            <h1 class="header-title">Manage Representatives</h1>
            <p class="header-subtitle">View active representatives and manage their roles</p>
        </div>

        <div class="container-applicationbackground">

            <?php if (isset($_SESSION['toast_message'])): ?>
                <div
                    class="message-box <?php echo ($_SESSION['toast_type'] === 'success') ? 'success-message' : 'error-message'; ?>">
                    <?php
                    echo htmlspecialchars($_SESSION['toast_message']);
                    unset($_SESSION['toast_message']);
                    unset($_SESSION['toast_type']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="stats">
                <div class="stat-card total">
                    <h3>Available Representatives</h3>
                    <div class="number"><?php echo count($representatives); ?></div>
                </div>
                <div class="stat-card pending">
                    <h3>Pending Applications</h3>
                    <div class="number"><?php echo $pendingApplicationsCount; ?></div>
                </div>
            </div>

            <h2 class="section-title">Active Representatives</h2>

            <?php if (empty($representatives)): ?>
                <div class="empty-state">
                    <h3>No Representatives Found</h3>
                    <p>There are no active representatives at this time.</p>
                </div>
            <?php else: ?>
                <div class="representatives-grid">
                    <?php foreach ($representatives as $rep):
                        $appointedDate = new DateTime($rep['appointeddate']);
                        $duration = (int) $rep['duration'];
                        $expiryDate = (clone $appointedDate)->add(new DateInterval('P' . $duration . 'M'));
                        $today = new DateTime();

                        $isExpired = $today > $expiryDate;
                        $daysRemaining = 0;

                        if (!$isExpired) {
                            $daysRemaining = $today->diff($expiryDate)->days;
                        }
                        ?>
                        <div class="rep-card <?php echo $isExpired ? 'expired' : ''; ?>">
                            <div class="rep-header">
                                <div class="rep-icon">
                                    👤
                                </div>
                                <div class="rep-info">
                                    <h3><?php echo htmlspecialchars($rep['name']); ?></h3>
                                    <div class="rep-contact"><?php echo htmlspecialchars($rep['contactnumber']); ?></div>
                                </div>
                            </div>

                            <div class="rep-details">
                                <div class="detail-row">
                                    <span class="detail-label">Appointed</span>
                                    <span class="detail-value"><?php echo $appointedDate->format('M d, Y'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Expires</span>
                                    <span class="detail-value"><?php echo $expiryDate->format('M d, Y'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Status</span>
                                    <?php if ($isExpired): ?>
                                        <span class="status-badge status-expired">Expired</span>
                                    <?php else: ?>
                                        <span class="status-badge status-valid"><?php echo $daysRemaining; ?> Days Left</span>
                                    <?php endif; ?>
                                </div>
                            </div>


                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>