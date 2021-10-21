<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';

    // Retrieve new limit value if changed
    if(isset($_GET['records-limit'])){
        $_SESSION['records-limit'] = $_GET['records-limit'];
    }

    $categories = array();
    $GLOBALS["site_settings"] = array();

    $category_name = "";
    $results = array();

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    // Variables for pagination
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 8; // Dynamic limit
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
        $sql = "select value_info from company_info";
            $res = $conn->query($sql);
            while ($rows = $res->fetch_assoc()) {
                array_push($GLOBALS["site_settings"], $rows['value_info']);
            }
        $GLOBALS["site_settings"][4] = json_decode($GLOBALS["site_settings"][4], true);
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
    <link rel="stylesheet" href="./includes/css/galeria.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
        <div class="container content">
            <?php if (!isset($_GET['category'])): ?>
                <div class="intro">
                    <h1 class="text-center" style="margin-bottom: 20px;">Galería</h1>
                    <p class="text-center" style="margin-bottom: 50px;">Haz clic sobre las imágenes para ver los trabajos de cada categoría. </p>
                </div>
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
                    <?php foreach ($categories as $element): ?>
                        <div class='animated category col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                            <a data-lightbox='photos' href='<?=$_SERVER['PHP_SELF']."?category=".$element[0]?>'>
                                <div style="text-align: center;" class='wrap wrap-category'>
                                    <label class='title'><?=$element[1]?></label>
                                    <img class='img-fluid category post_img' src='/uploads/categories/<?=$element[2]?>'/>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>   
            <?php else: ?>
                <div class="intro">
                    <h1 class="text-center" style="margin-bottom: 20px;"><?=$category_name?></h1>
                    <p class="text-center">Pulsa sobre las imágenes para verlas a tamaño completo.</p>
                </div>
                <form action="?category=<?=$_GET['category']?>" method="get">
                    <div class="input-group mb-3" style="width: 220px; padding-bottom: 20px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                        </div>
                        <select name="records-limit" id="records-limit" class="custom-select">
                            <?php foreach([8,16,24] as $limit) : ?>
                            <option
                                <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                                value="<?= $limit; ?>">
                                <?= $limit; ?> resultados
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <input hidden name="category" value="<?=$_GET['category']?>">
                    </div>
                </form>
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
                    <?php foreach ($results as $element): ?>
                        <div class='animated photos col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                            <a data-lightbox='photos'>
                                <div style="text-align: center;" class='wrap'>
                                    <img id="image-<?=$element[0]?>" class='img-fluid photos post_img' src='./uploads/images/<?=$element[1]?>'/>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
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
    <?php
        include './includes/footer.php';
    ?>
    <div class="modal fade" id="modal-galeria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Editar desde aqui -->
                    <div id="galeria" class="carousel slide carousel-fade" data-interval="false" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php $i = 0; foreach ($results as $element):?>
                            <li id="indicator-<?=$element[0]?>" data-target="#galeria" data-slide-to="<?=$i?>" class="carousel-indicator <?php if($i==0) echo 'active'?>"></li>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php $i = 0; foreach ($results as $element): ?>
                            <div id="item-<?=$element[0]?>" class="carousel-item <?php if($i==0) echo 'active' ?>">
                                <img src="./uploads/images/<?=$element[1]?>" class="d-block w-100">
                            </div>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#galeria" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#galeria" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </div>
                    <!-- Hasta aqui -->
                </div>
            </div>
        </div>
    </div>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
    <script src="./includes/js/gallery.js"></script>
    <script src="./includes/js/header.js"></script>
</body>
</html>