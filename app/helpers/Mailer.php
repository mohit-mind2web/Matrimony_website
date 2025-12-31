<?php

namespace App\helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function sendWelcomeEmail($toEmail, $toName)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; 
            $mail->Debugoutput = 'html'; // print Output properly in browser
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = trim($_ENV['MAIL_USERNAME'] ?? '');
            $mail->Password   = str_replace(' ', '', $_ENV['MAIL_PASSWORD'] ?? '');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'] ?? '587';

            // Recipients
            $mail->setFrom($_ENV['MAIL_USERNAME'] ?? 'noreply@matrimony.com', 'Soulmates Matrimony');
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Soulmates!';
            $mail->Body    = "
                <h1>Welcome, {$toName}!</h1>
                <p>Thank you for registering with Soulmates.</p>
                <p>We are excited to help you find your perfect match.</p>
                <br>
                <p>Best Regards,<br>Soulmates Team</p>
            ";
            $mail->AltBody = "Welcome, {$toName}! Thank you for registering with Soulmates.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            die();
        }
    }
}
