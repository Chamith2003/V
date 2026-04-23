<?php
// C:\wamp64\www\V\Controller\feedbackcontroller.php

require_once __DIR__ . '/../mailconfig.php';

// PHPMailer files
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class FeedbackController {

    public function sendFeedbackEmail() {
        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }

        // Get form data
        $userEmail = trim($_POST['email'] ?? '');
        $eventName = trim($_POST['event_name'] ?? '');
        $eventId = trim($_POST['event_id'] ?? '');
        $feedback = trim($_POST['feedback'] ?? '');
        $rating = intval($_POST['rating'] ?? 0);
        $files = $_FILES['files'] ?? [];

        // Validate input
        if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['success' => false, 'message' => 'Valid email address is required'], 400);
            return;
        }

        // if (empty($feedback) || strlen($feedback) < 10) {
        //     $this->jsonResponse(['success' => false, 'message' => 'Feedback must be at least 10 characters'], 400);
        //     return;
        // }

        if ($rating < 1 || $rating > 5) {
            $this->jsonResponse(['success' => false, 'message' => 'Rating must be between 1 and 5'], 400);
            return;
        }

        // Process files
        $uploadedFiles = [];
        if (isset($files['name']) && is_array($files['name'])) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    // Validate file
                    $fileType = mime_content_type($files['tmp_name'][$i]);
                    if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                        continue; // Skip invalid files
                    }

                    if ($files['size'][$i] > 5 * 1024 * 1024) {
                        continue; // Skip files larger than 5MB
                    }

                    // Read file content
                    $fileContent = file_get_contents($files['tmp_name'][$i]);
                    $uploadedFiles[] = [
                        'name' => basename($files['name'][$i]),
                        'content' => $fileContent,
                        'type' => $fileType
                    ];
                }
            }
        }

        // Send email
        $emailSent = $this->sendFeedbackToAdmin($userEmail, $eventName, $eventId, $feedback, $rating, $uploadedFiles);

        if ($emailSent) {
            // Send confirmation email to user
            $this->sendFeedbackConfirmation($userEmail, $eventName);
            $this->jsonResponse(['success' => true, 'message' => 'Feedback sent successfully!']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to send feedback. Please try again.'], 500);
        }
    }

    private function sendFeedbackToAdmin($userEmail, $eventName, $eventId, $feedback, $rating, $files) {
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
            $mail->setFrom(MAIL_FROM, 'V Platform');
            $mail->addAddress('v4volunteering0000@gmail.com', 'V Platform Admin'); // Change to your admin email
            $mail->addReplyTo($userEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Event Feedback: " . htmlspecialchars($eventName);
            $mail->Body = $this->getFeedbackEmailBody($userEmail, $eventName, $eventId, $feedback, $rating);
            $mail->AltBody = $this->getFeedbackEmailAltBody($userEmail, $eventName, $eventId, $feedback, $rating);

            // Attach files
            foreach ($files as $file) {
                $mail->addStringAttachment($file['content'], $file['name'], 'base64', $file['type']);
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('PHPMailer error (feedback): ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function sendFeedbackConfirmation($userEmail, $eventName) {
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
            $mail->setFrom(MAIL_FROM, 'V Platform');
            $mail->addAddress($userEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Thank You for Your Feedback - V Platform";
            $mail->Body = $this->getConfirmationEmailBody($eventName);
            $mail->AltBody = $this->getConfirmationEmailAltBody($eventName);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('PHPMailer error (feedback confirmation): ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function getFeedbackEmailBody($userEmail, $eventName, $eventId, $feedback, $rating) {
        $stars = str_repeat('⭐', $rating);
        
        return "
        <div style='font-family: Arial, sans-serif; max-width: 700px; margin: 0 auto;'>
            <div style='background: linear-gradient(135deg, #2C3E50, #344A5E); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h2>📋 New Event Feedback Submission</h2>
            </div>
            <div style='padding: 30px; background-color: #f9f9f9;'>
                <h3 style='color: #2C3E50; border-bottom: 2px solid #65ACA0; padding-bottom: 10px;'>Event Details</h3>
                <p><strong>Event Name:</strong> " . htmlspecialchars($eventName) . "</p>
                <p><strong>Event ID:</strong> " . htmlspecialchars($eventId) . "</p>
                <p><strong>Submitted By:</strong> " . htmlspecialchars($userEmail) . "</p>
                
                <h3 style='color: #2C3E50; border-bottom: 2px solid #65ACA0; padding-bottom: 10px; margin-top: 20px;'>Rating</h3>
                <p style='font-size: 20px; color: #FFC107;'>{$stars} ({$rating}/5)</p>
                
                <h3 style='color: #2C3E50; border-bottom: 2px solid #65ACA0; padding-bottom: 10px; margin-top: 20px;'>Feedback</h3>
                <p style='white-space: pre-wrap; color: #555; line-height: 1.6;'>" . htmlspecialchars($feedback) . "</p>
            </div>
            <div style='padding: 20px; text-align: center; color: #666; font-size: 12px; background-color: #f0f0f0; border-radius: 0 0 10px 10px;'>
                <p>Photos are attached to this email if any were submitted.</p>
                <p>V Platform - We Care. We Act. We Change.</p>
            </div>
        </div>
        ";
    }

    private function getFeedbackEmailAltBody($userEmail, $eventName, $eventId, $feedback, $rating) {
        return "New Event Feedback Submission\n\n" .
               "Event Name: " . htmlspecialchars($eventName) . "\n" .
               "Event ID: " . htmlspecialchars($eventId) . "\n" .
               "Submitted By: " . htmlspecialchars($userEmail) . "\n\n" .
               "Rating: " . $rating . "/5\n\n" .
               "Feedback:\n" . htmlspecialchars($feedback) . "\n\n" .
               "---\n" .
               "Photos are attached to this email if any were submitted.\n" .
               "V Platform - We Care. We Act. We Change.";
    }

    private function getConfirmationEmailBody($eventName) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background:linear-gradient(135deg, #2c3e50, #344a5e); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h2>✓ Thank You for Your Feedback!</h2>
            </div>
            <div style='padding: 20px; background-color: #f9f9f9; border-radius: 0 0 10px 10px;'>
                <p>Dear Volunteer,</p>
                <p>Thank you for taking the time to share your feedback about <strong>" . htmlspecialchars($eventName) . "</strong>.</p>
                <p>Your insights and photos help us improve our volunteer programs and create better experiences for our community.</p>
                <p>We truly appreciate your participation and dedication!</p>
                <p style='margin-top: 30px;'>Best regards,<br><strong>The V Team</strong></p>
            </div>
        </div>
        ";
    }

    private function getConfirmationEmailAltBody($eventName) {
        return "Thank you for your feedback!\n\n" .
               "Your feedback about " . htmlspecialchars($eventName) . " has been received successfully.\n\n" .
               "We appreciate your insights and dedication to our volunteer programs.\n\n" .
               "Best regards,\n" .
               "The V Team";
    }

    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>