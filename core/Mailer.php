<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        // SMTP Config
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'pbl.labdt@gmail.com';
        $this->mail->Password = 'zwln apxf nlcp nlrn';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;

        // Default Sender
        $this->mail->setFrom('pbl.labdt@gmail.com', 'PBL Lab DT');
        $this->mail->isHTML(true);
    }

    public function send($to, $subject, $body)
    {
        try {
            $this->mail->clearAddresses(); // Clear previous recipients
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            // Log error or rethrow
            error_log("Mailer Error: " . $this->mail->ErrorInfo);
            return false;
        }
    }
}
