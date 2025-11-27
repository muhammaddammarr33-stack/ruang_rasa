<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailHelper
{
    public static function send($to, $subject, $body)
    {
        try {
            $config = include __DIR__ . '/../../config/mail.php';
            $mode = $config['mode'];

            $mail = new PHPMailer(true);
            $mail->isSMTP();

            if ($mode === 'gmail') {
                $mail->Host = $config['gmail']['host'];
                $mail->Port = $config['gmail']['port'];
                $mail->SMTPAuth = true;
                $mail->Username = $config['gmail']['user'];
                $mail->Password = $config['gmail']['pass'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->Host = $config['mailhog']['host'];
                $mail->Port = $config['mailhog']['port'];
                $mail->SMTPAuth = false;
            }

            $mail->setFrom('no-reply@ruangrasa.local', 'Ruang Rasa');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
