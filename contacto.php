<?php
    require_once "./scripts/get_company_info.php";
    require_once "./scripts/check_maintenance.php";
    $semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacta con nosotros - ViGal Artesana</title>
    <meta name="description" content="Ponte en contacto con ViGal Artesana.">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        .map-responsive{

            overflow:hidden;

            padding-bottom:56.25%;

            position:relative;

            height:0;

            }

            .map-responsive iframe{

            left:0;

            top:0;

            height:100%;

            width:100%;

            position:absolute;

            }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FZJ25SLN42"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FZJ25SLN42');
    </script>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title wow animate__animated animate__fadeInUp">Contacto</h1>
        <p class="title-description wow animate__animated animate__fadeInUp">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
        <div class="row wow animate__animated animate__fadeInUp">
            <div class="col-lg-7">
                <p class="address"><?=$GLOBALS["site_settings"][1]?></p>
                <a class="contact-data" href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a>
                <a class="contact-data" href="mailto:<?=$GLOBALS["site_settings"][3]?>"><?=$GLOBALS["site_settings"][3]?></a>
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
            <div class="col-lg-5">
                <h2 class="title">Horarios</h2>
                <ul class="timetable">
                    <?php $i = 0; foreach ($GLOBALS["site_settings"][8] as $dia=>$horario): ?>
                        <li><?=$dia.": <strong>".$horario."</strong>"?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div>
                <h2 class="title wow animate__animated animate__fadeInUp">Ubicación</h2>
                <div class="map-responsive wow animate__animated animate__fadeInUp">
                    <iframe class="w-100" src="<?=$GLOBALS["site_settings"][7]?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
    </div>

    <?php
        include './includes/footer.php';
    ?>
    <!-- SB Forms JS -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/wow-init.js"></script>
</body>
</html>