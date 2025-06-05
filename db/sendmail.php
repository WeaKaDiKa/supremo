<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db/PHPMailer-master/src/Exception.php';
require 'db/PHPMailer-master/src/PHPMailer.php';
require 'db/PHPMailer-master/src/SMTP.php';

function sendmail($email, $name, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'supremofurbabies@gmail.com';
        $mail->Password = 'vowdjcrbaozgruuv';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('supremofurbabies@gmail.com', 'Supremo Fur Babies');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h1>$subject</h1>

            <p>$message</p>

        ";

        $mail->send();
        json_encode(['status' => 'success', 'message' => 'Email sent successfully.']);
    } catch (Exception $e) {
        json_encode(['status' => 'error', 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
    }
}