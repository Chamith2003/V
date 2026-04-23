<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/login/login.css">
    
</head>

<body>
    <div class="background"></div>

    <div class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <div class="header-content">
                    <div class="logo"><img src="/V/View/resources/nav-logo.png"></div>
                    <div class="header-text">
                        <h2>Welcome Back</h2>
                        <p>Sign in to your account</p>
                    </div>
                </div>
                <!-- <button class="close-btn" onclick="closeModal()" href="/V/router.php?action=return">×</button> -->
                <button class="close-btn" onclick="window.history.back()">×</button>
                <!-- buitlt in back function of js -->
            </div>



            <div class="form-container">
                <form method="POST" action="/V/router.php?module=user&action=login" id="signinForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <?php if (isset($_SESSION['login_error'])): ?>
                            <div class="error-message" style="display: block;">
                                <?php
                                echo htmlspecialchars($_SESSION['login_error']);
                                unset($_SESSION['login_error']);
                                ?>
                                <a href="/V/router.php?module=page&action=aboutus#contact" class="contact-link" >Contact Us</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-options">
                        <a href="/V/router.php?module=user&action=forgotpw" class="forgot-password">Forgot password?</a>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="btn btn-primary btn-full">Sign In & Continue</button>
                    </div>

                    <div class="signup-link">
                        Don't have an account? <a href="/V/router.php?module=registration&action=register" class="signup-link-text">Sign
                            up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <script src="/V/View/login/login.js"></script> 
</body>

</html>