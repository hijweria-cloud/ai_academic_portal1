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

        // Your Gmail & App Password
        $mail->Username   = 'hijweria@gmail.com';
        $mail->Password   = 'vmyx veom gdhr nine'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('hijweria@gmail.com', 'AI Academic Portal');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - AI Academic Portal';

        $verify_link = "http://localhost/ai_academic_portal/verify.php?token=$token";

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
        return false;
    }
}
?>
