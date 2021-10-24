<?php
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

    <title>Panel de control</title>
    <link rel="stylesheet" href="../includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../includes/css/galeria.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean" style="background-color: #F1F1F1;">
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
                            <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link" href="#">
                                Configuración del sitio
                            </a>
                            <div role="menu" class="dropdown-menu dropdown-menu-right">
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=general-settings">
                                    <i class="fas fa-cog" style="margin-right: 5px;"></i>
                                    Configuración general
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=contact-settings">
                                    <i class="fas fa-address-book" style="margin-right: 5px;"></i>
                                    Opciones de contacto y ubicación
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=services-settings">
                                    <i class="fas fa-wrench" style="margin-right: 5px;"></i>
                                    Servicios
                                </a>
                            </div>
                        </li>
                        ';
                    }
                ?>
                
                    <li class='nav-item dropdown'>
                        <a data-toggle='dropdown' aria-expanded='false' class='dropdown-toggle nav-link' href='#'>
                            Galería
                        </a>
                        <div role='menu' class='dropdown-menu dropdown-menu-right'>
                            <a role='presentation' class='dropdown-item' href='/dashboard?page=gallery-new'>
                                <i class='fas fa-upload' style='margin-right: 5px;'></i>
                                Subir imágenes
                            </a>
                            <a role='presentation' class='dropdown-item' href='/dashboard?page=manage-gallery'>
                                <i class='fas fa-images' style='margin-right: 5px;'></i>
                                Gestionar galería
                            </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/dashboard?page=categories">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="../scripts/logout.php">Cerrar sesión</a></li>
                    
                </ul>
                <div style="display: block;">
                    <a class="nav-link" href="../">Volver a inicio</a>
                <div>
            </div>
        </nav>
        <div class="wrapper">
        <!-- Page Content  -->
        <div id="content">
            <div>
                <?php
                    // reading GET variable and load corresponding page
                    switch($_GET['page']) {
                        case 'list-users':
                            include 'admin/users/pages/list_users.php';
                            break;
                        case 'create-user':
                            include 'admin/users/pages/create_user.php';
                            break;
                        case 'gallery-new':
                            include 'admin/gallery/pages/gallery_new.php';
                            break;
                        case 'manage-gallery':
                            include 'admin/gallery/pages/manage_gallery.php';
                            break;
                        case 'categories':
                            include 'admin/gallery/pages/categories.php';
                            break;
                        case 'profile':
                            include 'profile.php';
                            break;
                        case 'general-settings':
                            include 'admin/site-settings/pages/general.php';
                            break;
                        case 'contact-settings':
                            include 'admin/site-settings/pages/contact.php';
                            break;
                        case 'services-settings':
                            include 'admin/site-settings/pages/services.php';
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
    <script src="../includes/js/bs-init.js"></script>
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="/dashboard/admin/gallery/js/gallery_new.js"></script>
    <script src="./admin/gallery/js/gallery-manage.js"></script>
    <script src="./admin/site-settings/js/general.js"></script>
    <script src="./admin/site-settings/js/contact.js"></script>
    <script src="./admin/site-settings/js/services.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="admin/gallery/js/ajax.js"></script>
    <script src="admin/gallery/js/categories.js"></script>
    <!-- <script src="includes/js/toast.js"></script> -->


    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>