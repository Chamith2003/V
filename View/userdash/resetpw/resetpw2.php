<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$pw_success = $_SESSION['pw_update_success'] ?? null;
$pw_error = $_SESSION['pw_update_error'] ?? null;
unset($_SESSION['pw_update_success'], $_SESSION['pw_update_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
     <!-- <link rel="stylesheet" href="resetpw2.css"> -->
         <link rel="stylesheet" type="text/css" href="/V/View/userdash/resetpw/resetpw2.css">

</head>
<body>

    <div class="modal-card">
        <div class="modal-header">
            <h3>Change Password</h3>
            <!-- The close button is omitted since it's no longer a modal -->
        </div>
        
        <!-- Messages -->
        <?php if ($pw_success): ?>
            <div class="alert success-banner" style="margin-bottom:16px; padding:12px 18px; border-radius:8px; background:#e6ffed; color:#155724; border:1px solid #c3f0d6; font-weight:500;">
                ✓ <?= htmlspecialchars($pw_success) ?>
            </div>
        <?php elseif ($pw_error): ?>
            <div class="alert error-banner" style="margin-bottom:16px; padding:12px 18px; border-radius:8px; background:#fdecea; color:#721c24; border:1px solid #f5c6cb; font-weight:500;">
                ✗ <?= htmlspecialchars($pw_error) ?>
            </div>
        <?php endif; ?>



        

        <form method="POST" action="/V/router.php?module=pwreset&action=updatepassword" id="resetPasswordForm">

        <div class="form-field">
            <label for="newPassword">New Password</label>
            <input type="password" name="newPassword" id="newPassword" placeholder="Enter new password">
        </div>

        <div class="form-field">
            <label for="confirmNewPassword">Confirm New Password</label>
            <input type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirm new password">
        </div>

        <div class="password-criteria">
            <img src="/V/View/userdash/resetpw/information.png" alt="information" />
            Password must be at least 8 characters with uppercase, lowercase, and numbers
        </div>

        <div class="form-actions2">
            <button  type="submit" class="btn btn-save" id="updatePasswordBtn">
                Update Password</button>
            <button class="btn btn-cancel" id="cancelPasswordBtn" value="reset">Cancel</button>
        </div>
        </form>
    </div>
    <script src="/V/View/userdash/resetpw/resetpw.js"></script>

</body>
</html>
