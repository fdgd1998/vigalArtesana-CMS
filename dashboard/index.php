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
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <link rel="stylesheet" href="../includes/css/showcase.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/js/bs-init.js"></script>
    <script src="admin/company/company.js"></script>

     
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="includes/js/toast.js"></script> -->


    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
</head>

<body>
    <!-- <div id="toast" style="z-index: 2; position: relative; height: 150px; text-align: center; margin-top 20px; background-color: transparent;"></div> -->
    <?php
        // if (isset($_GET['user-message'])) {
        //     switch($_GET['user-message']) {
        //         case 'create-success':
        //             showToastMessage('success', 'El usuario se ha creado correctamente.');
        //             break;
        //         case 'password-pending':
        //             showToastMessage('warning', 'Es necesario que el usuario establezca la contraseña en el primer inicio de sesión.');
        //             break;
        //         case 'email-pending':
        //             showToastMessage('success', 'Se han enviado instrucciones a tu dirección de email.');
        //             break;
        //         case 'create-error':
        //             showToastMessage('danger', 'Ha ocurrido un error al crear el usuario.');
        //             break;
        //     }
        // }
    ?>
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean" style="background-color: #82D470;">
        <div class="container">
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid whiteM">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon" style="background-image: url('../includes/img/iconfinder-icon.svg');"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php
                    if ($_SESSION['account_type'] == 'admin' || $_SESSION['account_type'] == 'superuser') {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" data-bs-hover-animate="pulse" href="/dashboard?page=company" style="color: rgb(255, 255, 255);">Empresa</a>
                            </li>
                        ';
                    }
                    if ($_SESSION['account_type'] == 'superuser') {
                        echo "
                            <li class='nav-item dropdown'>
                            <a data-toggle='dropdown' data-bs-hover-animate='pulse' aria-expanded='false' class='dropdown-toggle nav-link' href='#' style='color: white;'>
                                Usuarios
                            </a>
                            <div role='menu' class='dropdown-menu dropdown-menu-right'>
                                <a role='presentation' class='dropdown-item' href='/dashboard?page=create-user'>
                                    <i class='fas fa-user-plus' style='margin-right: 5px;'></i>
                                    Nuevo usuario
                                </a>
                                <a role='presentation' class='dropdown-item' href='/dashboard?page=list-users'>
                                    <i class='fas fa-users' style='margin-right: 5px;'></i>
                                    Listar usuarios
                                </a>
                            </div>
                        </li>
                        ";
                    }?>
                
                    <li class='nav-item dropdown'>
                        <a data-toggle='dropdown' data-bs-hover-animate='pulse' aria-expanded='false' class='dropdown-toggle nav-link' href='#' style='color: white;'>
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
                            <div class="dropdown-divider"></div>
                            <a role='presentation' class='dropdown-item' href='/dashboard?page=categories'>
                                <i class='fas fa-ellipsis-h' style='margin-right: 5px;'></i>
                                Categorías
                            </a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="/dashboard?page=profile" style="color: rgb(255, 255, 255);">Mi perfil</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="../scripts/logout.php" style="color: rgb(255, 255, 255);">Cerrar sesión</a></li>
                    
                </ul>
                <div style="display: block;">
                    <a class="nav-link" data-bs-hover-animate="pulse" href="../" style="color: rgb(255, 255, 255);">Volver a inicio</a>
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
                        case 'company':
                            include 'admin/company/company.php';
                            break;
                        default:
                            include 'start.php';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</body>
</html>