<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/PHPMailer/PHPMailer.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/PHPMailer/Exception.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/PHPMailer/SMTP.php";
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";

    function sendEmail($to, $subject, $body) {
        try {
            require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/email_settings.php";
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->CharSet = "utf-8"; 
            $mail->Host = $host;
            $mail->Port = $port;
            // $mail->SMTPDebug = $debugLevel;
            $mail->SMTPSecure = "ssl";
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SetFrom($username, "Vigal Boutique");
            $mail->addAddress($to, $to);
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