<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Correct file paths
require 'includes/phpmailer/src/Exception.php';
require 'includes/phpmailer/src/PHPMailer.php';
require 'includes/phpmailer/src/SMTP.php';

// --- NEW: .env file loader ---
// Ye part variables ko getenv() ke liye available banayega 
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . "=" . trim($value));
    }
}

function sendVerificationEmail($email, $token, $name) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        
        $mail->Username   = getenv('GMAIL_USER'); 
        // Note: App Password mein spaces nahi honi chahiye 
        $mail->Password   = getenv('GMAIL_APP_PASSWORD'); 
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender info - GC University Faisalabad branding [cite: 255]
        $mail->setFrom(getenv('GMAIL_USER'), 'GC University Faisalabad | AI Portal');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - AI Academic Portal';

        // Dynamic Link [cite: 316]
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $base_url = "$protocol://$host/ai_academic_portal";
        $verify_link = "$base_url/verify.php?token=$token";

        $mail->Body = "
            <div style='font-family: Poppins, sans-serif; border: 1px solid #D4AF37; padding: 20px;'>
                <h3 style='color: #B8860B;'>Hello $name,</h3>
                <p>Welcome to the <b>GC University Faisalabad</b> AI Academic Portal.</p>
                <p>Please verify your email to secure your account:</p>
                <p><a href='$verify_link' style='background: #D4AF37; color: #1C1C1C; padding: 10px; text-decoration: none; border-radius: 5px;'>Verify My Email</a></p>
                <br>
                <p>© 2026 GC University Faisalabad</p>
            </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>