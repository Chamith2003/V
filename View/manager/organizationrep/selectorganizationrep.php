<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" href="/V/View/manager/organizationrep/selectorganizationrep.css">
    <title>V - Choose Organization Representatives</title>
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="header">
            <h1 class="header-title">Organization Representatives Selection</h1>
            <p class="header-subtitle">Choose <?php echo $neededCount; ?>
                representative<?php echo $neededCount > 1 ? 's' : ''; ?> to serve as Organization Representatives for 12
                months
            </p>
        </div>

        <div class="container-applicationbackground">
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="message-box success-message">
                    <?php 
                    echo htmlspecialchars($_SESSION['success_message']); 
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="message-box error-message">
                    <?php 
                    echo htmlspecialchars($_SESSION['error_message']); 
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="stats">
                <div class="stat-card total">
                    <h3>Available Representatives</h3>
                    <div class="number"><?php echo count($availableRepresentatives); ?></div>
                </div>
                <div class="stat-card current">
                    <h3>Current Org Representatives</h3>
                    <div class="number"><?php echo $currentOrgRepsCount; ?> / 2</div>
                </div>
            </div>

            <?php if ($currentOrgRepsCount > 0): ?>
                <div class="current-orgreps-section">
                    <h2 class="section-title">Current Organization Representatives</h2>
                    <div class="orgreps-list">
                        <?php foreach ($currentOrgReps as $orgRep): ?>
                            <?php
                                $appointedDate = new DateTime($orgRep['appointeddate']);
                                $expiryDate = (clone $appointedDate)->add(new DateInterval('P12M'));
                                $today = new DateTime();
                                $daysRemaining = $today->diff($expiryDate)->days;
                                if ($expiryDate < $today) {
                                    $daysRemaining = 0;
                                }
                            ?>
                            <div class="orgrep-card">
                                <div class="orgrep-header">
                                    <div class="orgrep-icon">👤</div>
                                    <div class="orgrep-info">
                                        <h3><?php echo htmlspecialchars($orgRep['name']); ?></h3>
                                        <p class="orgrep-email"><?php echo htmlspecialchars($orgRep['email']); ?></p>
                                    </div>
                                </div>
                                <div class="orgrep-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Contact:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($orgRep['contactnumber'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Appointed:</span>
                                        <span class="detail-value"><?php echo date('M d, Y', strtotime($orgRep['appointeddate'])); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Expires:</span>
                                        <span class="detail-value"><?php echo $expiryDate->format('M d, Y'); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Days Remaining:</span>
                                        <span class="detail-value status-badge"><?php echo $daysRemaining; ?> days</span>
                                    </div>
                                </div>
                                <div class="orgrep-actions">

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($currentOrgRepsCount < 2 && count($availableRepresentatives) > 0): ?>
                <div class="selection-section">
                    <h2 class="section-title">Select Representatives (Choose Exactly <?php echo $neededCount; ?>)</h2>
                    <p class="selection-note">Selected representatives will be appointed for 12 months and their role will
                        be upgraded to Organization Representative.</p>

                    <form method="POST" action="/V/router.php?module=manager&action=appointorgreps" id="selectionForm"
                        data-needed-count="<?php echo $neededCount; ?>">
                        <div class="representatives-grid">
                            <?php foreach ($availableRepresentatives as $rep): ?>
                                <div class="rep-card">
                                    <label class="rep-card-label">
                                        <input type="checkbox" name="selected_reps[]" value="<?php echo $rep['userid']; ?>" class="rep-checkbox">
                                        <div class="rep-card-content">
                                            <div class="rep-header">
                                                <div class="rep-icon">👤</div>
                                                <div class="rep-info">
                                                    <h3><?php echo htmlspecialchars($rep['name']); ?></h3>
                                                    <p class="rep-email"><?php echo htmlspecialchars($rep['email']); ?></p>
                                                </div>
                                            </div>
                                            <div class="rep-details">
                                                <div class="detail-row">
                                                    <span class="detail-label">Level Points:</span>
                                                    <span
                                                        class="detail-value"><?php echo htmlspecialchars($rep['levelpoints'] ?? '0'); ?></span>
                                                </div>
                                                <div class="detail-row">
                                                    <span class="detail-label">Contact:</span>
                                                    <span class="detail-value"><?php echo htmlspecialchars($rep['contactnumber'] ?? 'N/A'); ?></span>
                                                </div>
                                                <div class="detail-row">
                                                    <span class="detail-label">Appointed as Rep:</span>
                                                    <span class="detail-value"><?php echo date('M d, Y', strtotime($rep['appointeddate'])); ?></span>
                                                </div>
                                            </div>
                                            <div class="checkbox-indicator">
                                                <span class="checkmark">✓</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="form-actions">
                            <div class="selection-counter">
                                Selected: <span id="selectedCount">0</span> / <?php echo $neededCount; ?>
                            </div>
                            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                                Appoint Organization Representatives
                            </button>
                        </div>
                    </form>
                </div>
            <?php elseif ($currentOrgRepsCount >= 2): ?>
                <div class="info-box">
                    <h3>✓ Organization Representatives Appointed</h3>
                    <p>2 Organization Representatives are already appointed. You cannot appoint more until their term expires (12 months from appointment date).</p>
                </div>
            <?php else: ?>
                <div class="info-box">
                    <h3>No Available Representatives</h3>
                    <p>There are no representatives available to appoint as Organization Representatives at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="/V/View/manager/organizationrep/selectorganizationrep.js"></script>
</body>
</html>
