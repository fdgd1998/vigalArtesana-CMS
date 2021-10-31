<?php
    require_once "./scripts/get_company_info.php";
    require_once "./scripts/check_maintenance.php";
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="container content wow animate__animated animate__fadeInUp">
        <h1 class="title">Sobre nosotros</h1>
        <?=$GLOBALS["site_settings"][9]?>
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