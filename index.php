<?php
    header("Content-Type: text/html;charset=utf-8");
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViGal - Inicio</title>
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
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
    <!-- <script src="./includes/js/bs-init.js"></script> -->
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="index-image-container">
        <img class="index-image" src="./uploads/16319907220.jpg"></img>
        <div class="index-text-image">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <button type="button" class="btn btn-outline-light">Ver galería</button>
        </div>
    </div>
    <div class="container content">
        <h1 style="text-align: center;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>
            
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

        <h1 class="text-center">Servicios</h1>
        <div class="container">
            <div class="row services-items">
                <div class="col-sm">
                    <h2>Diseño de planos 2D</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <div class="col-sm">
                    <img class="services-items-images" src="./uploads/16319907220.jpg"></img>
                </div>
            </div>
            <div class="row services-items">
                <div class="col-sm">
                    <h2>Diseño de planos 2D</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <div class="col-sm">
                    <img class="services-items-images" src="./uploads/16319907220.jpg"></img>
                </div>
            </div>
            <div class="row services-items">
                <div class="col-sm">
                    <h2>Diseño de planos 2D</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <div class="col-sm">
                    <img class="services-items-images" src="./uploads/16319907220.jpg"></img>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        include './includes/footer.php';
    ?>
</body>
</html>