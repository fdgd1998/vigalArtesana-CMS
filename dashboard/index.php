<?php
    error_reporting(0);
    session_start();
    require_once '../scripts/get_http_protocol.php'; 

    if (!isset($_SESSION['user'])) {
        header("Location: ../403.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Panel de control - ViGal Artesana</title>
    <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../includes/css/galeria.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    

</head>

<body>
    <nav class="nav-solid navbar navbar-expand-lg navigation-clean">
        <div class="container">
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon" style="background-image: url('../includes/img/icons8-menu.svg');"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php
                    if ($_SESSION['account_type'] == 'admin' || $_SESSION['account_type'] == 'superuser') {
                        echo '
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Configuración del sitio
                            </a>
                            <div role="menu" class="dropdown-menu">
                            <h6 class="dropdown-header">Opciones generales</h6>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=general-settings">
                                    <i class="fas fa-cog"></i>
                                    Página de inicio
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=contact-settings">
                                    <i class="fas fa-address-book"></i>
                                    Contacto y ubicación
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Servicios</h6>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=manage-services">
                                    <i class="fas fa-wrench"></i>
                                    Gestionar servicios
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=new-service">
                                    <i class="fas fa-plus-circle"></i>
                                    Nuevo servicio
                                </a>
                                <div class="dropdown-divider"></div>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=services-settings">
                                    <i class="fas fa-code"></i>
                                    Opciones avanzadas
                                </a>
                            </div>
                        </li>
                        ';
                    }
                ?>
                
                    <li class='nav-item dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle nav-link' href='#'>
                            Galería
                        </a>
                        <div role='menu' class='dropdown-menu'>
                            <a role='presentation' class='dropdown-item' href='/dashboard?page=gallery-new'>
                                <i class='fas fa-upload'></i>
                                Subir imágenes
                            </a>
                            <a role='presentation' class='dropdown-item' href='/dashboard?page=manage-gallery'>
                                <i class='fas fa-images'></i>
                                Gestionar galería
                            </a>
                            <div class="dropdown-divider"></div>
                            <a role='presentation' class="dropdown-item" href="/dashboard?page=categories">
                                <i class="fas fa-ellipsis-h"></i>
                                Categorías
                            </a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../">Volver a inicio</a></li>
                </ul>
                <div style="display: block;">
                    <a class="nav-link" href="../scripts/logout.php">Cerrar sesión</a>
                <div>
            </div>
        </nav>
        <div class="wrapper">
        <!-- Page Content  -->
        <div id="content">
            <div>
                <?php
                    // reading GET variable and load corresponding page
                    switch(true) {
                        case $_GET['page'] == 'manage-gallery':
                            include 'admin/gallery/pages/manage_gallery.php';
                            break;
                        case $_GET['page'] == 'gallery-new':
                            include 'admin/gallery/pages/gallery_new.php';
                            break;
                        case $_GET['page'] == 'categories':
                            include 'admin/gallery/pages/categories.php';
                            break;
                        case $_GET['page'] == 'general-settings':
                            include 'admin/site-settings/pages/general.php';
                            break;
                        case $_GET['page'] == 'contact-settings':
                            include 'admin/site-settings/pages/contact.php';
                            break;
                        case $_GET['page'] == 'manage-services':
                            include 'admin/site-settings/pages/services.php';
                            break;
                        case $_GET['page'] == 'new-service':
                            include 'admin/site-settings/pages/new_service.php';
                            break;
                        case preg_match('^edit-service&id=(\d{1,2})$^', isset($_GET["id"])?$_GET["page"]."&id=".$_GET["id"]:$_GET["page"]):
                            include 'admin/site-settings/pages/edit_service.php';
                            break;
                        default:
                            include 'start.php';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/js/popper.min.js"></script>
    <script src="./admin/gallery/js/load-images.js"></script>
    <script src="/dashboard/admin/gallery/js/gallery_new.js"></script>
    <script src="./admin/gallery/js/gallery-manage.js"></script>
    <script src="./admin/site-settings/js/general.js"></script>
    <script src="./admin/site-settings/js/contact.js"></script>
    <script src="./admin/site-settings/js/services.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="./admin/gallery/js/ajax.js"></script>
    <script src="./admin/gallery/js/categories.js"></script>
</body>
</html>