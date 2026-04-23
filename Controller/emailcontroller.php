<?php
// C:\wamp64\www\V\Controller\emailcontroller.php



require_once __DIR__ . '/../Model/emailmodel.php';
require_once __DIR__ . '/../mailconfig.php';

// PHPMailer files -- adjust path relative to this controller file
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class emailcontroller {
    private $model;
    private $conn;

    public function __construct($model) {
        $this->model = $model;
    }

    // POST /V/router.php?module=pwreset&action=sendcode
    // expects JSON { email: "user@example.com" }
    public function sendCode() {
        // Accept JSON or form-encoded
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? ($_POST['email'] ?? null);
        if (!$email) {
            $this->jsonResponse(['success' => false, 'message' => 'Email required'], 400);
            return;
        }

        // Check if user exists
        $user = $this->model->findUserByEmail($email);
        if (!$user) {
            // For security, respond with success (avoid probing), but you might choose to say "no user" during dev.
            $this->jsonResponse(['success' => false, 'message' => 'No account with that email'], 404);
            return;
        }

        // Generate 6-digit code
        try {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } catch (Exception $e) {
            $code = sprintf("%06d", mt_rand(0, 999999));
        }

        // Store code, email, and expiry (10 minutes) in session
        $_SESSION['pwreset'] = [
            'email' => $email,
            'code' => $code,
            'expires_at' => time() + 600, // 10 minutes
            'attempts' => 0
        ];

        // Send email
        $mailSent = $this->sendMail($email, $user['name'] ?? '', $code);

        if ($mailSent) {
            $this->jsonResponse(['success' => true, 'message' => 'Verification code sent']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to send email'], 500);
        }
    }

    // POST /V/router.php?module=pwreset&action=verifycode
    // expects JSON { code: "123456" }
    public function verifyCode() {
        $data = json_decode(file_get_contents('php://input'), true);
        $code = $data['code'] ?? ($_POST['code'] ?? null);

        if (!isset($_SESSION['pwreset'])) {
            $this->jsonResponse(['success' => false, 'message' => 'No verification in progress'], 400);
            return;
        }

        $session = &$_SESSION['pwreset'];

        // expiry check
        if (time() > $session['expires_at']) {
            unset($_SESSION['pwreset']);
            $this->jsonResponse(['success' => false, 'message' => 'Code expired'], 400);
            return;
        }

        // attempt limiting
        $session['attempts'] = ($session['attempts'] ?? 0) + 1;
        if ($session['attempts'] > 5) {
            unset($_SESSION['pwreset']);
            $this->jsonResponse(['success' => false, 'message' => 'Too many attempts'], 429);
            return;
        }

        if ($code === $session['code']) {
            // mark as verified
            $session['verified'] = true;
            $this->jsonResponse(['success' => true, 'message' => 'Code verified']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid code'], 400);
        }
    }

    // POST /V/router.php?module=pwreset&action=updatepassword
    // Handles both JSON API requests and form POST submissions
    public function updatePassword() {
        // Detect content type
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $isJson = stripos($contentType, 'application/json') !== false;
        
        // Read password from JSON or form POST
        if ($isJson) {
            $data = json_decode(file_get_contents('php://input'), true);
            $newPassword = $data['newPassword'] ?? null;
        } else {
            $newPassword = $_POST['newPassword'] ?? null;
            $confirmPassword = $_POST['confirmNewPassword'] ?? null;
            
            // For form POST, validate passwords match
            if ($newPassword !== $confirmPassword) {
                $_SESSION['pw_update_error'] = 'Passwords do not match!';
                header("Location: /V/router.php?module=pwreset&action=showchange");
                exit;
            }
        }

        // Check if verification is complete
        if (!isset($_SESSION['pwreset']) || !($_SESSION['pwreset']['verified'] ?? false)) {
            if ($isJson) {
                $this->jsonResponse(['success' => false, 'message' => 'Not verified to change password'], 403);
            } else {
                $_SESSION['pw_update_error'] = 'Verification expired. Please try resetting your password again.';
                header("Location: /V/router.php?module=pwreset&action=show");
            }
            return;
        }

        // Validate password
        if (!$newPassword || strlen($newPassword) < 8) {
            if ($isJson) {
                $this->jsonResponse(['success' => false, 'message' => 'Password must be at least 8 characters'], 400);
            } else {
                $_SESSION['pw_update_error'] = 'Password must be at least 8 characters.';
                header("Location: /V/router.php?module=pwreset&action=showchange");
            }
            return;
        }

        $email = $_SESSION['pwreset']['email'];

        // Hash password
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in DB
        $ok = $this->model->updatePasswordByEmail($email, $hash);
        if ($ok) {
            // Cleanup session
            unset($_SESSION['pwreset']);
            
            if ($isJson) {
                $this->jsonResponse(['success' => true, 'message' => 'Password updated']);
            } else {
                // For form POST, set success message and redirect to login
                $_SESSION['pw_update_success'] = 'Password updated successfully! Please log in with your new password.';
                header("Location: /V/router.php?module=user&action=login");
            }
        } else {
            if ($isJson) {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to update password'], 500);
            } else {
                $_SESSION['pw_update_error'] = 'Failed to update password. Please try again.';
                header("Location: /V/router.php?module=pwreset&action=showchange");
            }
        }
    }

    // helper to send email via PHPMailer
    private function sendMail($toEmail, $toName, $code) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_SMTP_SECURE;
            $mail->Port = MAIL_PORT;

            // Recipients
            $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your V password reset code';
            $mail->Body    = "<p>Hello " . htmlspecialchars($toName ?: $toEmail) . ",</p>
                              <p>Your password reset verification code is:</p>
                              <h2 style='letter-spacing:4px;'>$code</h2>
                              <p>This code expires in 10 minutes.</p>";
            $mail->AltBody = "Hello,\n\nYour password reset verification code is: $code\n\nThis code expires in 10 minutes.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // For debugging you can log $mail->ErrorInfo
            error_log('PHPMailer error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>