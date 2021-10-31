<?php 
    require_once "./scripts/set_503_header.php";
    set_503_header();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <div class="container maintenance text-center">
        <div>
            <h1 class=" text-center"><i class="fas fa-exclamation-triangle"></i></h1>
            <h2>Ha ocurrido un error en el servidor.</h2>
            <p>Estamos trabajando para solucionar el problema en la mayor brevedad posible.</p>
            <p>Disculpen las molestias.</p>
    </div>
</body>
</html>