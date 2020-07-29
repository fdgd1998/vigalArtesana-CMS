<?php
    session_start();
    error_reporting(0);
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/get_http_protocol.php'; 

    if (!isset($_SESSION['user'])) {
        header("Location: ../../../403.php");
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
    <link rel="stylesheet" href="../includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="../includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/js/bs-init.js"></script>

    <script src="../includes/js/popper.min.js"></script>
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
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <h3>Menú</h3>
            </div>

            <ul class="list-unstyled components">
                <?php
                    if ($_SESSION['account_type'] == 'superuser') {
                        echo '
                            <li>
                                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="fas fa-user"></i>
                                    Usuarios
                                </a>
                                <ul class="collapse list-unstyled" id="homeSubmenu">
                                    <li>
                                        <a href="?page=create-user">Crear usuario</a>
                                    </li>
                                    <li>
                                        <a href="?page=list-users&order=asc">Listar usuarios</a>
                                    </li>
                                </ul>
                            </li>
                        ';
                    }

                    if ($_SESSION['account_type'] == 'admin' || $_SESSION['account_type'] == 'superuser') {
                       echo '
                            <li>
                                    <a href="#">
                                        <i class="fas fa-briefcase"></i>
                                        Empresa
                                    </a>
                                </li>
                       ';
                    }
                ?>
                
                <li>
                    
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-copy"></i>
                        Posts
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="?page=create-post">Crear post</a>
                        </li>
                        <li>
                            <a href="?page=list-posts&order=asc">Listar posts</a>
                        </li>
                        <li>
                            <a href="?page=categories&order=asc">Categorías</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="?page=profile" class="download">Perfil</a>
                </li>
                <li>
                    <a href="../modules/logout.php" class="article">Cerrar sesión</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="z-index: 1;">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menú</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="javascript:window.location = location.origin">Volver a inicio</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div>
                <?php
                    switch($_GET['page']) {
                        case 'start':
                            include 'start.php';
                            break;
                        case 'list-users':
                            include 'admin/users/pages/list_users.php';
                            break;
                        case 'create-user':
                            include 'admin/users/pages/create_user.php';
                            break;
                        case 'create-post':
                            include 'admin/posts/pages/create_post.php';
                            break;
                        case 'list-posts':
                            include 'admin/posts/pages/list_posts.php';
                            break;
                        case 'categories':
                            include 'admin/posts/pages/categories.php';
                            break;
                        case 'profile':
                            include 'profile.php';
                            break;
                        default:
                            include '404.php';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
    

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>
</html>