<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Correct file paths:
require 'includes/phpmailer/src/Exception.php';
require 'includes/phpmailer/src/PHPMailer.php';
require 'includes/phpmailer/src/SMTP.php';

function sendVerificationEmail($email, $token, $name) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // --- FIX 1: Secrets (Code se hata kar environment variables se uthaye hain) ---
        // PHP mein .env use karne ke liye getenv() function istemal hota hai
        $mail->Username   = getenv('GMAIL_USER'); 
        $mail->Password   = getenv('GMAIL_APP_PASSWORD'); 
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom(getenv('GMAIL_USER'), 'AI Academic Portal');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - AI Academic Portal';

        // --- FIX 2: Dynamic Verification Link ---
        // Hard-coded localhost hata kar dynamic banaya hai taake har system par chalay
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $base_url = "$protocol://$host/ai_academic_portal";
        $verify_link = "$base_url/verify.php?token=$token";

        $mail->Body = "
            <h3>Hello $name,</h3>
            <p>Thank you for registering on the AI Academic Portal.</p>
            <p>Please verify your email by clicking the link below:</p>
            <p><a href='$verify_link'>Verify My Email</a></p>
            <br>
            <p>If you did not request this, ignore this message.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        // Error logging for debugging
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>