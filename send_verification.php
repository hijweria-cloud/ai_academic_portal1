
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer files
require 'includes/phpmailer/src/Exception.php';
require 'includes/phpmailer/src/PHPMailer.php';
require 'includes/phpmailer/src/SMTP.php';

// Load .env file
if (file_exists(__DIR__ . '/.env')) {

    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);

        putenv(trim($name) . "=" . trim($value));
    }
}

function sendVerificationEmail($email, $token, $name) {

    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        $mail->Username   = getenv('GMAIL_USER');
        $mail->Password   = getenv('GMAIL_APP_PASSWORD');

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom(getenv('GMAIL_USER'), 'GC University Faisalabad | AI Portal');

        // Receiver
        $mail->addAddress($email);

        // Email Format
        $mail->isHTML(true);

        $mail->Subject = 'Verify Your Email - AI Academic Portal';

        

        $verify_link = "http://localhost/ai_academic_portal%20-%20Copy/verify.php?token=$token";
        // Email Body
        $mail->Body = "

        <div style='
            font-family:Poppins,sans-serif;
            border:1px solid #D4AF37;
            padding:25px;
            border-radius:10px;
            max-width:600px;
            margin:auto;
            background:#fffaf0;
        '>

            <h2 style='color:#B8860B;'>
                Hello $name,
            </h2>

            <p style='font-size:16px; color:#333;'>
                Welcome to the
                <b>GC University Faisalabad AI Academic Portal</b>.
            </p>

            <p style='font-size:15px; color:#444;'>
                Please verify your email by clicking the button below:
            </p>

            <a href='$verify_link'
               style='
                    display:inline-block;
                    margin-top:15px;
                    background:#D4AF37;
                    color:#1C1C1C;
                    padding:12px 20px;
                    text-decoration:none;
                    border-radius:6px;
                    font-weight:bold;
               '>

               Verify My Email

            </a>

            <br><br>

            <p style='font-size:14px; color:#666;'>
                If you did not request this, please ignore this email.
            </p>

            <hr>

            <p style='text-align:center; color:#999; font-size:13px;'>
                © 2026 GC University Faisalabad | AI Academic Portal
            </p>

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
```
