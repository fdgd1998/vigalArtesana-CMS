<?php
    session_start();
    require_once "./scripts/get_company_info.php";
    require_once "./scripts/check_maintenance.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso prohibido - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title"><i class="fas fa-ban"></i>Acceso prohibido</h1>
        <p class="title-description">No tienes acceso al recurso solicitado. Verifica que tienes permisos para acceder a este recurso e inténtalo de nuevo.</p>
    </div>
        
    <?php
        include './includes/footer.php';
    ?>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>