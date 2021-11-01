<?php
    session_start();

    if (isset($_POST)) {
        $from = $_POST["from"];
        $to = $_POST["to"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: ".$from;

        if (mail($to, $subject, $message, $headers)) {
            echo "El mensaje se ha enviado correctamente.";
        } else {
            echo "Ha ocurrido un error enviando el mensaje.";
        }
        
    } else {
        header("Location: ../403.php");
        exit();
    }
?>