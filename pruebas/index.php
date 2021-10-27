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
    
    $conn->close();
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
    <link rel="stylesheet" href="./includes/css/carousel.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="index-image-container">
        <img class="index-image" src="./uploads/<?=$GLOBALS["site_settings"][5]?>"></img>
        <div class="index-text-image">
            <p><?=$GLOBALS["site_settings"][6]?></p>
            <button type="button" onclick="window.location.href = 'galeria.php'" class="btn btn-outline-light">Ver galería</button>
        </div>
    </div>
    <div class="container content">
        <h1 style="text-align: center;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>   
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <button style="margin-top: 10px;" onclick="window.location.href = 'sobremi.php'" type="button" class="btn btn-outline-dark">Saber más</button>
    </div>
    <div class="container-fluid services">
    <h1>Servicios</h1>
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 active">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img1">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img2">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img3">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img4">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img5">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img6">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img7">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3">
                    <img src="./uploads/16319907220.jpg" class="img-fluid mx-auto d-block carousel-img" alt="img8">
                    <div class="carousel-caption">
                        <h5>Título</h5>
                        <p>Descripción</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel-example" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="container content">
        <h1>¿Quieres más información?</h1>
        <p>Para ponerte en contacto, consultar la ubicación o el horario, haz clic en el botón de abajo.</p>
        <button style="margin-top: 10px;" onclick="window.location.href = 'contacto.php'" type="button" class="btn btn-outline-dark">Contacto</button>
    </div>
    
    <?php
        include './includes/footer.php';
    ?>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/carousel.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
</body>
</html>