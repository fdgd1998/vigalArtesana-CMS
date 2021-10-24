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
    <title>ViGal - Contacto</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="./includes/css/showcase.css">
    <link rel="stylesheet" href="./includes/css/carousel.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
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
        <div class="row">
            <div class="col-lg-7 text-left">
                <h3>Ubicación</h3>
                <div class="map-responsive">
                    <iframe class="w-100" src="<?=$GLOBALS["site_settings"][7]?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="col-lg-5 text-left">
                <h3>Datos de contacto</h3>
                <ul>
                    <li><i style="color: #767676;" class="fas fa-map-marker"></i><?=$GLOBALS["site_settings"][1]?></li>
                    <li><i style="color: #767676;" class="fas fa-phone"></i><a href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a></li>
                    <li><i style="color: #767676;" class="fas fa-envelope"></i><a href="mailto:<?=$GLOBALS["site_settings"][3]?>"><?=$GLOBALS["site_settings"][3]?></a></li>
                </ul>
                <hr>
                <h3>Horario</h3>
                <ul style="list-style-type: none; padding-left: 0;">
                    <?php $i = 0; foreach ($GLOBALS["site_settings"][8] as $dia=>$horario): ?>
                        <li><?=$dia.": ".$horario?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php
        include './includes/footer.php';
    ?>
    <!-- SB Forms JS -->
    <scipt src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/carousel.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            initialCountry: "es",
        });
    </script>
</body>
</html>