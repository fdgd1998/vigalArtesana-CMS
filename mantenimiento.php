<?php
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';
    $GLOBALS["site_settings"] = array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info where key_info in('phone','name','email','social_media')";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($GLOBALS["site_settings"], $rows['value_info']);
        }
    }
    $GLOBALS["site_settings"][3] = json_decode($GLOBALS["site_settings"][3], true);
    
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link href="http://fonts.cdnfonts.com/css/gotham" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <div class="container maintenance text-center">
        <div class="">
            <h1 class="maintenance-title "><?=$GLOBALS["site_settings"][1]?></h1><br>
            <p>En estos momentos estamos realizando el mantenimiento del sitio web. Volveremos en la mayor brevedad posible.</p>
            <p>Mientras tanto, puedes visitar nuestros perfiles en redes sociales.</p>
            <div style="margin-top: 30px;">
                <?php if (isset($GLOBALS["site_settings"][3]["whatsapp"])):?>
                    <a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][3]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][3]["instagram"])):?>
                    <a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][3]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$GLOBALS["site_settings"][3]["instagram"]?></a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][3]["facebook"])):?>
                    <a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][3]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$GLOBALS["site_settings"][3]["facebook"]?></a>
                <?php endif; ?>
            </div>
            <div style="margin-top: 30px; margin-bottom: 30px;">
                <p>También puedes ponerme en contacto con nosotros</p>
                <a class="contact-data" href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a>
                <a class="contact-data" href="mailto:<?=$GLOBALS["site_settings"][2]?>"><?=$GLOBALS["site_settings"][2]?></a>
            </div>
        </div>
        <hr>
        <p style="margin-top: 30px;">Si eres el propietario del sitio web, puedes iniciar sesión haciendo clic <u><a href="login.php">aquí.</a></u></p>
    </div>
</body>
</html>