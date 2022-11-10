<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_maintenance_status.php";

    $services = array(); // Array to save categories
    $page_id = 8;
    
    $site_settings = getSiteSettings();
    $maintenance = getMaintenanceStatus($site_settings);

    $conn = new DatabaseConnection(); // Opening database connection.
    
    if (!$maintenance || ($maintenance) == 0 && isset($_SESSION["loggedin"])) {
        $sql = "select title, description from pages_metadata where id_page = (select id from pages where id = ".$page_id.")";  
        if ($res = $conn->query($sql)) {
            $page_title = $res[0]['title'];
            $page_description = $res[0]['description'];
        }
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_503_header.php";
        set_503_header();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!$maintenance || ($maintenance && isset($_SESSION["loggedin"]))): ?>
    <title><?=$page_title." | ".$site_settings[2]["value_info"]?></title>
    <meta name="description" content="<?=$page_description?>">
    <meta name="robots" content="index, follow">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
    <?php else: ?>
    <title>Página en mantenimiento | <?=$site_settings[2]["value_info"]?></title>
    <?php endif; ?>
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        .map-responsive{
            overflow:hidden;
            padding-bottom:56.25%;
            position:relative;
            height:0;
            margin-bottom: 40px;
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
    if ($maintenance && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    if ($maintenance && isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
    }
    include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title">Contacto</h1>
        <p class="title-description">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
        <p class="title-description">También puedes usar el formulario de contacto al final de esta página.</p>
        <div class="row">
            <div class="col-lg-7">
                <p class="address"><?=$site_settings[1]["value_info"]?></p>
                <u><a class="contact-data" href="tel:<?=str_replace(' ','',$site_settings[0]["value_info"])?>"><i class="fas fa-phone-alt"></i><?=$site_settings[0]["value_info"]?></a></u>
                <u><a class="contact-data" href="mailto:<?=$site_settings[3]["value_info"]?>"><i class="fas fa-envelope"></i><?=$site_settings[3]["value_info"]?></a></u>
                <?php if (isset($site_settings[4]["value_info"]["whatsapp"])):?>
                    <u><a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$site_settings[4]["value_info"]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a></u>
                <?php endif; ?>
                <?php if (isset($site_settings[4]["value_info"]["instagram"])):?>
                    <u><a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$site_settings[4]["value_info"]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$site_settings[4]["value_info"]["instagram"]?></a></u>
                <?php endif; ?>
                <?php if (isset($site_settings[4]["value_info"]["facebook"])):?>
                    <u><a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$site_settings[4]["value_info"]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$site_settings[4]["value_info"]["facebook"]?></a></u>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <h2 class="title">Horarios</h2>
                <ul class="timetable">
                    <?php $i = 0; foreach ($site_settings[8]["value_info"] as $dia=>$horario): ?>
                        <li><?=$dia.": <strong>".$horario."</strong>"?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 class="title">Ubicación</h2>
                <div class="map-responsive">
                    <iframe class="w-100" src="<?=$site_settings[7]["value_info"]?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-2 col-lg-3"></div>
            <div class="col-12 col-sm-8 col-lg-6">
                <h2 class="title">Formulario de contacto</h2>
                <div class="mb-3">
                    <label>Nombre:</label>
                    <input type="text" class="form-control" id="nombre">
                    <div class="invalid-feedback">
                        Introduce un nombre.
                    </div>
                </div>
                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    <div class="invalid-feedback">
                        Introduce un email válido.
                    </div>
                </div>
                <div class="mb-3">
                    <label>Motivo de contacto:</label>
                    <select class="custom-select" id="motivo">
                        <option value="duda" selected>Consultar duda</option>
                        <option value="precio">Pedir precio</option>
                        <option value="presupuesto">Pedir presupuesto</option>
                        <option value="otro">Otra consulta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Mensaje:</label>
                    <textarea rows="5" id="mensaje" class="form-control"></textarea>
                    <div class="invalid-feedback">
                        El mensaje no puede estar vacío.
                    </div>
                </div>
                <div class="g-recaptcha brochure__form__captcha" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" data-sitekey="6LcpXp0dAAAAAIyqkuLt2hPzrYXE_eJv6adylhP8"></div>
                <div class="button-group text-right">
                    <button disabled style="margin-top: 10px;" class="btn my-button" id="submit-message">Enviar</button>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-lg-3"></div>
        </div>
    </div>

    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/contact.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/hide_spinner.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/show_spinner.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>