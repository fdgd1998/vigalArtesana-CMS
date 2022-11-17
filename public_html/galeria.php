<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_maintenance_status.php";

    $site_settings = getSiteSettings();
    $maintenance = getMaintenanceStatus($site_settings);
    
    $conn = new DatabaseConnection(); // Opening database connection.
    $pageNotFound = false;

    if (!$maintenance || ($maintenance && isset($_SESSION["loggedin"]))) { 
        $categories = array();
        $results = array();
        $category_name = "";
        $category_description = "";
        $category_id = 0;
        $page_id = 6;
        $page_title = "";
        $page_description = "";

        // Variables for pagination
        $limit = 12; // Dynamic limit
        $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1; // Current pagination page number
        $paginationStart = ($page - 1) * $limit; // Offset

        $allRecords = 0;
        $totalPages = 0;

        // Prev + Next page
        $prev = $page - 1;
        $next = $page + 1;

        if(!isset($_GET['category'])) {
            $sql = "select * from categories";
            $res = $conn->query($sql);
            foreach ($res as $item) {
                array_push($categories, array($item['friendly_url'], $item['name'], $item['image'], $item['description']));
            }
        } else {
            $sql = "select id, name, description from categories where id = (select id from categories where friendly_url = '".$_GET['category']."')";
            if ($res = $conn->query($sql)) {
                $category_id = $res[0]['id'];
                $category_name = $res[0]['name'];
                $category_description = $res[0]['description'];
                $sql = "select gallery.id, filename, dir, altText from gallery inner join categories on gallery.category = categories.id where gallery.category = (select id from categories where friendly_url = '".$_GET['category']."') limit $paginationStart, $limit";
                if ($res = $conn->query($sql)) {
                    foreach ($res as $item) {
                        array_push($results, array($item['id'], $item['filename'], $item['dir'], $item['altText']));
                    }
                }
            } else {
                $pageNotFound = true;
            }

            // Getting all records from database
            $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id where cat_enabled='YES' and gallery.category = (select id from categories where friendly_url = '".$_GET['category']."')"; 
            $allRecords = $conn->query($sql)[0]['id'];
            
            // Calculate total pages
            $totalPages = ceil($allRecords / $limit);
            
            if (isset($_GET['page']) > $totalPages) {
                if ($_GET['page'] > $totalPages) {
                    $pageNotFound = true;
                }
            }

            
        }

        // Getting page metadata
        if (!isset($_GET["category"])) {
            $sql = "select title, description from pages_metadata where id_page = (select id from pages where id = ".$page_id.")";  
        } else {
            $sql = "select title, description from pages_metadata where id_page = (select id from pages where cat_id = ".$category_id.")";
        }
        
        if ($res = $conn->query($sql)) {
            $page_title = $res[0]['title'];
            $page_description = $res[0]['description'];
        }
    } else {
        set_503_header();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!$maintenance && !$pageNotFound): ?>
    <title><?=$page_title?> | <?=$site_settings[2]["value_info"]; isset($_GET["category"]) ? (isset($_GET["page"])?" | Página ".$page:"Página 1") : ""?></title>
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
    <?php endif; ?>
    <?php if ($pageNotFound && $site_settings[11]["value_info"] != "false"): ?>
    <?php set_404_header(); ?>
    <title>Página no encontrada | <?=$site_settings[2]["value_info"]?></title>
    <?php else: ?>
    <title>Página en mantenimiento | <?=$site_settings[2]["value_info"]?></title>
    <?php endif; ?>
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="icon" href="/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/fontawesome.all.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/gallery.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/simple-lightbox.css?v2.8.0"> 
</head>

<body>
    <?php if (!$pageNotFound): ?> 
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
            <?php if (!isset($_GET['category'])): ?>
                <h1 class="title">Galería</h1>
                <p class="title-description"><?=$site_settings[12]["value_info"]?></p>
                <p class="title-description">Selecciona una categoría pulsando sobre una imagen.</p>
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
                    <?php foreach ($categories as $element): ?>
                        <div class='category col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                            <a href='<?=GetBaseUri()?>/galeria/<?=$element[0]?>'>
                                <div class='wrap-category animated-item'>
                                    <label class='category-title'><?=$element[1]?></label>
                                    <img loading="lazy" class='img-fluid category photos' src='<?=GetBaseUri()?>/uploads/categories/<?=$element[2]?>' alt="<?=$element[1]?>"/>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>   
            <?php else: ?>
                <div class="intro">
                    <h1 class="title"><a href="<?=GetBaseUri()?>/galeria"><i class="fas fa-arrow-left" style="margin-right: 20px !important;"></i></a><?=$category_name?></h1>
                    <?php if (count($results) > 0): ?>
                        <p><?=$category_description?></p>
                        <p class="title-description">Pincha sobre las imágenes para verlas a tamaño completo. Para volver a la página anterior, pulsa la flecha a la izquierda del nombre de la categoría.</p>
                    <?php else: ?>
                        <p><?=$category_description?></p>
                        <p class="title-description">No se han encontrado elementos en esta categoría. Visita esta página más tarde.</p>
                    <?php endif; ?>
                </div>
                <?php if (count($results) > 0): ?>
                    <div class="galeria">
                        <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4"> 
                            <?php foreach ($results as $element): ?>    
                            <a class="animated-item wrap" href="<?=GetBaseUri()?>/uploads/images/<?=$element[2].$element[1]?>">
                                <img loading="lazy" id="image-<?=$element[0]?>" class='img-fluid photos' src="<?=GetBaseUri()?>/uploads/images/<?=$element[2].$element[1]?>" alt="<?=$element[3]?>" title="<?=$element[3]?>"/>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($_GET['category']) && count($results) > 0): ?>
        <nav style="margin-bottom: 50px;">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "/galeria/".$_GET['category']."/" . $prev; } ?>"><</a>
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
                        <a class="page-link" href="/galeria/<?= $_GET['category'] ?>/<?=$i?>"> <?= $i; ?> </a>
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
                        <a class="page-link" href="/galeria/<?= $_GET['category'] ?>/<?=$i?>"> <?= $i; ?> </a>
                    </li>
                    <?php endfor; ?>
                <?php endif; ?>
                <li class="page-item <?php if($page >= $totalPages) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page >= $totalPages){ echo '#'; } else {echo "/galeria/".$_GET['category']."/" . $next; } ?>">></a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php'; ?>
        <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
        <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=GetBaseUri()?>/includes/js/simple-lightbox.js?v2.8.0"></script>
        <?php if (isset($_GET['category'])): ?>
        <script>
            (function() {
            var $gallery = new SimpleLightbox('.galeria a', {});
        })();
        </script>
    <?php endif; ?>
    <?php endif; ?>
    <?php if (($pageNotFound && $maintenance) && !isset($_SESSION["loggedin"])): ?> 
    <?php set_503_header() ?>
    <?php endif; ?>
    <?php if ($pageNotFound): ?>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
        include $_SERVER["DOCUMENT_ROOT"].'/snippets/404.php';
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <?php endif; ?>
</body>
</html>