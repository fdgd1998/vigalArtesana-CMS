<?php
    session_start();
    // error_reporting(0);

    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/connection.php';

    $categories = array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select * from categories where cat_enabled='YES'";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($categories, array($rows['id'], $rows['name'], $rows['image']));
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViGal - Exposición</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="./includes/fonts/mrdehaviland-stylesheet.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/bs-init.js"></script>
    <style>
        .animated {
            transition: transform .5s; /* Animation */;
        }

        .animated:hover {
            transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
            z-index: 1;
        }

        .title {
            font-family: 'Great Vibes';
            color: white;
            position: absolute;
            text-shadow: 2px 0 0 #000, -2px 0 0 #000, 0 2px 0 #000, 0 -2px 0 #000, 1px 1px #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 3;
            font-size: 32px;
        }

        img {
            border-radius: 5%;
            opacity: .9;
        }

        .wrap {
            position:relative;
            border-radius: 5%;
        }

        .wrap:before {
            border-radius: 5%;
            content:"";
            position: absolute;
            top:0;
            left:0;
            height:100%;
            width:100%;
            background: rgba(0,0,0,0.5);
            z-index:2;
        }

        .wrap:hover {
            background: rgba(0,0,0,0.8)
        }
    </style>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
    <div class="photo-gallery">
    <div class="container">
        <div class="intro">
            <h2 class="text-center" style="margin-top: 50px; margin-bottom: 10px;">Exposición</h2>
            <p class="text-center" style="margin-bottom: 50px;">Haz clic sobre las imágenes para ver los trabajos de cada categoría. </p>
        </div>
        <div class="row photos" style="margin-bottom: 20px;">
        <?php
            foreach($categories as $element) {
                echo "
                    <div class='animated category col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                        <a data-lightbox='photos' href='".$_SERVER['PHP_SELF']."?category=".$element[0]."'>
                            <div class='wrap'>
                                <label class='title text-center'>".$element[1]."</label>
                                <img class='img-fluid' src='/uploads/categories/".$element[2]."'/>
                            </div>
                        </a>
                    </div>
                ";
            }
            ?>
        </div>
    </div>
</div>
    
    <?php
        include './includes/footer.php';
    ?>
</body>

</html>