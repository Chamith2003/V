<?php
// C:\wamp64\www\V\Controller\contactcontroller.php

require_once __DIR__ . '/../Model/contactmodel.php';
require_once __DIR__ . '/../mailconfig.php';

// PHPMailer files
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Handle contact form submission
    public function sendContactMessage() {
        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }

        // Get form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validate input
        $errors = $this->validateInput($name, $email, $subject, $message);
        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'message' => implode(', ', $errors)], 400);
            return;
        }

        // Sanitize input
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $subject = htmlspecialchars($subject);
        $message = htmlspecialchars($message);

        // Send email to admin
        $emailSent = $this->sendEmailToAdmin($name, $email, $subject, $message);

        // Send confirmation email to user
        $this->sendConfirmationEmail($name, $email, $subject);

        if ($emailSent) {
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Thank you for your message! We will get back to you soon.'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false, 
                'message' => 'Failed to send message. Please try again later.'
            ], 500);
        }
    }

    // Validate form input
    private function validateInput($name, $email, $subject, $message) {
        $errors = [];

        if (empty($name) || strlen($name) < 2) {
            $errors[] = 'Name must be at least 2 characters';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email address is required';
        }

        if (empty($subject) || strlen($subject) < 3) {
            $errors[] = 'Subject must be at least 3 characters';
        }

        if (empty($message) || strlen($message) < 10) {
            $errors[] = 'Message must be at least 10 characters';
        }

        return $errors;
    }

    // Send email to admin
    private function sendEmailToAdmin($name, $email, $subject, $message) {
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
            $mail->addAddress($this->model->getAdminEmail(), 'V Platform Admin');
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Contact Form: " . $subject;
            $mail->Body    = $this->getAdminEmailBody($name, $email, $subject, $message);
            $mail->AltBody = $this->getAdminEmailAltBody($name, $email, $subject, $message);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('PHPMailer error (admin): ' . $mail->ErrorInfo);
            return false;
        }
    }

    // Send confirmation email to user
    private function sendConfirmationEmail($name, $email, $subject) {
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
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "We received your message - V Platform";
            $mail->Body    = $this->getConfirmationEmailBody($name, $subject);
            $mail->AltBody = $this->getConfirmationEmailAltBody($name, $subject);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('PHPMailer error (confirmation): ' . $mail->ErrorInfo);
            return false;
        }
    }

    // Email body for admin
    private function getAdminEmailBody($name, $email, $subject, $message) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background-color: #172941; color: white; padding: 20px; text-align: center;'>
                <h2>Contact Form Submission from users</h2>
            </div>
            <div style='padding: 20px; background-color: #ffffffff;'>
                <h3>Contact Details:</h3>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Subject:</strong> {$subject}</p>
                <hr>
                <h3>Message:</h3>
                <p style='white-space: pre-wrap;'>{$message}</p>
            </div>
            <div style='padding: 10px; text-align: center; color: #666; font-size: 12px;'>
                <p>This email was sent from the V Platform contact form</p>
            </div>
        </div>
        ";
    }

    // Alt body for admin
    private function getAdminEmailAltBody($name, $email, $subject, $message) {
        return "New Contact Form Submission\n\n" .
               "Name: {$name}\n" .
               "Email: {$email}\n" .
               "Subject: {$subject}\n\n" .
               "Message:\n{$message}\n\n" .
               "---\n" .
               "This email was sent from the V Platform contact form";
    }

    // Confirmation email body for user
    private function getConfirmationEmailBody($name, $subject) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background-color: #53998E; color: white; padding: 20px; text-align: center;'>
                <h2>Thank You for Contacting V</h2>
            </div>
            <div style='padding: 20px; background-color: #f9f9f9;'>
                <p>Dear {$name},</p>
                <p>Thank you for reaching out to us. We have received your message regarding <strong>\"{$subject}\"</strong>.</p>
                <p>Our team will review your message and get back to you as soon as possible, typically within 24-48 hours.</p>
                <p>In the meantime, feel free to explore our platform and learn more about our environmental initiatives.</p>
                <p>Best regards,<br><strong>The V Team</strong></p>
            </div>
            <div style='padding: 10px; text-align: center; color: #666; font-size: 12px;'>
                <p>V Platform - We Care. We Act. We Change.</p>
                <p>If you did not send this message, please ignore this email.</p>
            </div>
        </div>
        ";
    }

    // Confirmation email alt body
    private function getConfirmationEmailAltBody($name, $subject) {
        return "Dear {$name},\n\n" .
               "Thank you for reaching out to us. We have received your message regarding \"{$subject}\".\n\n" .
               "Our team will review your message and get back to you as soon as possible, typically within 24-48 hours.\n\n" .
               "Best regards,\n" .
               "The V Team\n\n" .
               "---\n" .
               "V Platform - We Care. We Act. We Change.";
    }

    // JSON response helper
    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>