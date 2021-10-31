<?php
    require_once "./scripts/get_company_info.php";
    require_once "./scripts/set_503_header.php";
    set_503_header();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - ViGal Artesana</title>
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <div class="container maintenance text-center">
        <div class="">
            <h1 class="maintenance-title "><?=$GLOBALS["site_settings"][2]?></h1><br>
            <p>En estos momentos estamos realizando el mantenimiento del sitio web. Volveremos en la mayor brevedad posible.</p>
            <p>Mientras tanto, puedes visitar nuestros perfiles en redes sociales.</p>
            <div style="margin-top: 30px;">
                <?php if (isset($GLOBALS["site_settings"][4]["whatsapp"])):?>
                    <a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][4]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][4]["instagram"])):?>
                    <a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][4]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$GLOBALS["site_settings"][4]["instagram"]?></a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][4]["facebook"])):?>
                    <a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][4]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$GLOBALS["site_settings"][4]["facebook"]?></a>
                <?php endif; ?>
            </div>
            <div style="margin-top: 30px; margin-bottom: 30px;">
                <p>También puedes ponerme en contacto con nosotros</p>
                <a class="contact-data" href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a>
                <a class="contact-data" href="mailto:<?=$GLOBALS["site_settings"][3]?>"><?=$GLOBALS["site_settings"][3]?></a>
            </div>
        </div>
        <hr>
        <p style="margin-top: 30px;">Si eres el propietario del sitio web, puedes iniciar sesión haciendo clic <u><a href="login.php">aquí.</a></u></p>
    </div>
</body>
</html>