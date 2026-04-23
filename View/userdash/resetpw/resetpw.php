<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <!-- <link rel="stylesheet" href="resetpw.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/userdash/resetpw/resetpw.css">
  <!-- <1?php include __DIR__ . '/../../navbar/navbar.php'; ?> -->
</head>
<body>


    <div class="modal">
          
        <div id="email-state">
            <div class="icon-container">
                <img src="/V/View/userdash/resetpw/lock.png" alt="security" />
            </div>
            
            <h1>Reset Password</h1>
            <p class="description">Enter your email address and we'll send you a verification code</p>
            
            <form id="email-form">
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-container">                        
                        <input type="email" id="email" class="form-input" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <button type="submit" class="primary-button">
                    Send Verification Code
                </button>
            </form>
            
            <a href="/V/router.php?module=page&action=homepage" class="back-link">Back to Home</a>
        </div>

        <div id="verification-state" class="hidden">
            <div class="icon-container">
                <img src="/V/View/userdash/resetpw/verification.png" alt="security" />
            </div>
            
            <h1>Enter Verification Code</h1>
            <p class="description">We've sent a 6-digit code to <span id="sent-email"></span></p>
            
            <form id="verification-form">
                <div class="code-inputs">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                </div>
                
                <button type="submit" class="primary-button">
                    Verify Code
                </button>
            </form>
            
            <div class="resend-text">
                Didn't receive the code? <a href="#" class="resend-link" id="resend-code">Resend</a>
            </div>
            
            <a href="#" class="back-link" id="back-to-email">Back to Email</a>
        </div>


            <div class="hidden" id="changePasswordModal">
            <div class="modal-card">
                <div class="modal-header">
                    <h3>Change Password</h3>
                    <button class="modal-close-btn">&times;</button>
                </div>
                <!-- Success message -->
                <div id="passwordUpdateSuccessMessage" class="success-message">
                    Password successfully updated!
                </div>
                <div class="form-field">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" placeholder="Enter current password">
                </div>
                <div class="form-field">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" placeholder="Enter new password">
                </div>
                <div class="form-field">
                    <label for="confirmNewPassword">Confirm New Password</label>
                    <input type="password" id="confirmNewPassword" placeholder="Confirm new password">
                </div>
                <div class="password-criteria">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: inline;">
                        <path d="M11 7h2v2h-2zm0 4h2v6h-2z"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                    Password must be at least 8 characters with uppercase, lowercase, and numbers
                </div>
                <div class="form-actions2">
                    <button class="btn btn-save" id="updatePasswordBtn">Update Password</button>
                    <button class="btn btn-cancel" id="cancelPasswordBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/V/View/userdash/resetpw/resetpw.js"></script>
</body>
</html>
