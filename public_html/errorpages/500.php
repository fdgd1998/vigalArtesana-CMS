<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    set_500_header();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error interno del servidor - ViGal Boutique</title>
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
</head>

<body>
    <div class="container maintenance text-center">
        <div>
            <h1 class=" text-center">500</h1>
            <h2>Error interno del servidor.</h2>
            <p>Estamos trabajando para solucionar el problema en la mayor brevedad posible.</p>
        </div>
    </div>
</body>
</html>