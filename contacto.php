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
        $sql = "select value_info from company_info";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($GLOBALS["site_settings"], $rows['value_info']);
        }
    }
    $GLOBALS["site_settings"][4] = json_decode($GLOBALS["site_settings"][4], true);
    $GLOBALS["site_settings"][8] = json_decode($GLOBALS["site_settings"][8], true);
    $semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacta con nosotros - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link href="http://fonts.cdnfonts.com/css/gotham" rel="stylesheet">
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
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title">Contacto</h1>
        <p class="title-description">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte! También puedes usar el formulario de contacto al final de esta página.</p>
        <div class="row">
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
                        <li><?=$dia.": ".$horario?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div>
                <h2 class="title">Ubicación</h2>
                <div class="map-responsive">
                    <iframe class="w-100" src="<?=$GLOBALS["site_settings"][7]?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
    </div>

    <?php
        include './includes/footer.php';
    ?>
    <!-- SB Forms JS -->
    <scipt src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>