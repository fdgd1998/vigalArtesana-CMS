<?php
    require_once "./scripts/get_company_info.php";
    require_once "./scripts/check_maintenance.php";

    $categories = array();

    $category_name = "";
    $results = array();

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    // Variables for pagination
    $limit = 16; // Dynamic limit
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1; // Current pagination page number
    $paginationStart = ($page - 1) * $limit; // Offset

    $allRecords = 0;
    $totalPages = 0;

    // Prev + Next page
    $prev = $page - 1;
    $next = $page + 1;

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        if(!isset($_GET['category'])) {
            $sql = "select * from categories where cat_enabled='YES'";
            $res = $conn->query($sql);
            while ($rows = $res->fetch_assoc()) {
                array_push($categories, array($rows['id'], $rows['name'], $rows['image']));
            }
            $res->free();
        } else {
            $sql = "select gallery.id, filename from gallery inner join categories on gallery.category = categories.id where gallery.category = ".$_GET['category']." limit $paginationStart, $limit";
            if ($res = $conn->query($sql)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($results, array($rows['id'], $rows['filename']));
                }
                $res->free();
            }

            // Getting all records from database
            $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id where cat_enabled='YES' and gallery.category = ".$_GET['category']; 
            $allRecords = $conn->query($sql)->fetch_assoc()['id'];
            
            // Calculate total pages
            $totalPages = ceil($allRecords / $limit);

            $sql = "select name from categories where id = ".$_GET['category'];
            if ($res = $conn->query($sql)) {
                $rows = $res->fetch_assoc();
                $category_name = $rows['name'];
                $res->free();
            }
        }
    }


    $conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - ViGal Artesana</title>
    <meta name="description" content="Nuestra galería, una exposición de los trabajos que hacemos con madera.">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/css/galeria.css">
    <link rel="stylesheet" href="./includes/css/simple-lightbox.css?v2.8.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FZJ25SLN42"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FZJ25SLN42');
    </script>
</head>

<body>
    <?php include './includes/header.php';?>
    <div class="container content">
        <?php if (!isset($_GET['category'])): ?>
            <h1 class="title wow animate__animated animate__fadeInUp">Galería</h1>
            <p class="title-description wow animate__animated animate__fadeInUp">Selecciona una categoría pinchando sobre una imagen.</p>
            <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 wow animate__animated animate__fadeIn" style="margin-bottom: 20px;">
                <?php foreach ($categories as $element): ?>
                    <div class='animated category col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                        <a href='<?=$_SERVER['PHP_SELF']."?category=".$element[0]?>'>
                            <div class='wrap-category'>
                                <label class='category-title'><?=$element[1]?></label>
                                <img class='img-fluid category photos' src='/uploads/categories/<?=$element[2]?>' alt="<?=$element[1]?>"/>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>   
        <?php else: ?>
            <div class="intro">
                <h1 class="title wow animate__animated animate__fadeInUp"><a href="galeria.php"><i class="fas fa-arrow-left" style="margin-right: 20px !important;"></i></a><?=$category_name?></h1>
                <p class="title-description wow animate__animated animate__fadeInUp">Pincha sobre las imágenes para verlas a tamaño completo. Para volver a la página anterior, pincha sobre la flecha a la izquierda del nombre de la categoría.</p>
            </div>
            <div class="galeria wow animate__animated animate__fadeInUp">
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4"> 
                    <?php foreach ($results as $element): ?>    
                    <a class="animated wrap" href="./uploads/images/<?=$element[1]?>">
                        <img id="image-<?=$element[0]?>" class='img-fluid photos' src="./uploads/images/<?=$element[1]?>" alt="<?=$category_name?>"/>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>   
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($_GET['category'])): ?>
    <nav aria-label="Page navigation example mt-5" style="margin-bottom: 50px;">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>&category=<?= $_GET['category'] ?>"><</a>
            </li>
            <?php if ($totalPages > 10): ?>
                <?php
                    $min = $page - 3 < 1 ? 1 : $page - 3;
                    $max = $page + 3 > $totalPages ? $totalPages : $page + 3;    
                ?>
                <?php if($page >= 5): ?>
                    <li class="page-item disabled">
                        <a class="page-link">...</a>
                    </li>
                <?php endif; ?>
                <?php for($i = $min; $i <= $max; $i++): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="galeria.php?page=<?= $i; ?>&category=<?= $_GET['category'] ?>"> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>
                <?php if($page < $totalPages - 3): ?>
                    <li class="page-item disabled">
                        <a class="page-link">...</a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <?php for($i = 1; $i <= $totalPages; $i++ ): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="galeria.php?page=<?= $i; ?>&category=<?= $_GET['category'] ?>"> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>
            <?php endif; ?>
            <li class="page-item <?php if($page >= $totalPages) { echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page >= $totalPages){ echo '#'; } else {echo "?page=". $next; } ?>&category=<?= $_GET['category'] ?>">></a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
    <?php include './includes/footer.php'; ?>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
    <script src="./includes/js/simple-lightbox.js?v2.8.0"></script>
    <script src="./includes/js/galeria.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/js/wow-init.js"></script>
    <?php if (isset($_GET['category'])): ?>
        <script>
            (function() {
            var $gallery = new SimpleLightbox('.galeria a', {});
        })();
        </script>
    <?php endif; ?>
</body>
</html>