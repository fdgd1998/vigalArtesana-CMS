<?php
    require "PHPMailer/PHPMailer.php";
    require "PHPMailer/SMTP.php";
    require "PHPMailer/Exception.php";
    
    function SendEmail($from, $name, $to, $subject, $body) {
        try {
            include "../../email_settings.php";
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPDebug = $debugLevel;
            $mail->SMTPSecure = "ssl";
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SetFrom($username, "");
            $mail->AddReplyTo($username, "");
            $mail->addAddress($to,"");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->IsHTML(true);
            
            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        } catch (phpmailerException $e) {
            echo $e;
        }
    }
?>