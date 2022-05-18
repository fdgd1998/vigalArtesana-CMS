<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';

    $maintenance = "";
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info where key_info = 'maintenance'";
        
        if ($res = $conn->query($sql)) {
            $maintenance = $res->fetch_assoc()["value_info"];
        }
    }
    
    $conn->close();
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
    <link rel="stylesheet" href="../includes/css/gallery.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="../includes/summernote/summernote-bs4.min.css" />
</head>

<body class="d-flex">
    <?php if ($maintenance == "true"): ?>
    <div id="maintenance-warning" class="container-fluid">
        <p> <i class="fas fa-exclamation-triangle"></i>El modo de mantenimiento está activado. Puedes ver el sitio web porque has iniciado sesión, pero no estará disponible en internet hasta que lo desactives.</p>
        <p>Puedes desactivarlo <u><a href="?page=advanced">aquí</a></u>.</p>
    </div>
    <?php endif; ?>
    <nav class="nav-solid navbar navbar-expand-lg navigation-clean">
        <div class="container">
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon" style="background-image: url('../includes/img/icons8-menu.svg');"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php if ($_SESSION['account_type'] == 'administrator' || $_SESSION['account_type'] == 'superuser'): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Configuración del sitio
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <h6 class="dropdown-header">Información de la empresa</h6>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=general-settings">
                                    <i class="fas fa-home"></i>
                                    Página de inicio
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=contact-settings">
                                    <i class="fas fa-address-book"></i>
                                    Contacto y ubicación
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=about-us">
                                    <i class="fas fa-address-card"></i>
                                    Sobre nosotros
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
                                <?php if ($_SESSION['account_type'] == 'superuser'): ?>
                                <div class="dropdown-divider"></div>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=advanced">
                                    <i class="fas fa-code"></i>
                                    Opciones avanzadas
                                </a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                     <?php if ($_SESSION['account_type'] == 'superuser'): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Usuarios
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=manage-users">
                                    <i class="fas fa-user"></i>
                                    Gestionar usuarios
                                </a>
                                <a role="presentation" class="dropdown-item" href="/dashboard?page=new-user">
                                    <i class="fas fa-plus-circle"></i>
                                    Nuevo usuario
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
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
                        case $_GET['page'] == 'about-us':
                            include 'admin/site-settings/pages/about_us.php';
                            break;
                        case $_GET['page'] == 'advanced':
                            include 'admin/site-settings/pages/advanced.php';
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
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/js/popper.min.js"></script>
    <script src="admin/gallery/js/load-images.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="js/show_spinner.js"></script>
    <script src="js/hide_spinner.js"></script>
    <script src="js/check_image_size.js"></script>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "manage-gallery" || $_GET["page"] == "gallery-new" || $_GET["page"] == "categories")): ?>
    <script src="admin/gallery/js/gallery_new.js"></script>
    <script src="admin/gallery/js/gallery-manage.js"></script>
    <script src="admin/gallery/js/ajax.js"></script>
    <script src="admin/gallery/js/categories.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "general-settings"): ?>
    <script src="admin/site-settings/js/general.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "contact-settings"): ?>
    <script src="admin/site-settings/js/contact.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "advanced"): ?>
    <script src="admin/site-settings/js/advanced.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "manage-services") || $_GET["page"] == "new-service" || preg_match('^edit-service&id=(\d{1,2})$^', isset($_GET["id"])?$_GET["page"]."&id=".$_GET["id"]:$_GET["page"])): ?>
    <script src="admin/site-settings/js/services.js"></script>
    <?php endif; ?>
    
    <?php if(isset($_GET["page"]) && $_GET["page"] == "about-us"): ?>
    <script src="../includes/summernote/summernote-bs4.min.js"></script>
    <script src="../includes/summernote/lang/summernote-es-ES.js"></script>
    <script src="admin/site-settings/js/about-us.js"></script>
    <script>
        $("#summernote").summernote({
            lang: 'es-ES',
            height: 500,
            disableDragAndDrop: true,
            styleTags: [
                {
                    title: 'párrafo',
                    tag: 'p',
                    value: 'p'
                },
                {
                    title: 'H2 título',
                    tag: 'h2',
                    className: 'title',
                    value: 'h2'
                },
                {
                    title: 'H3 título',
                    tag: 'h3',
                    className: 'title',
                    value: 'h3'
                }
            ],
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
                ['font', ['superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['picture', ['picture']],
                ['table', ['table']],
                ['hr', ['hr']],
                ['misc', ['undo', 'redo', 'codeview']]
            ],
            callbacks: {
                onInit: function() {
                    $(this).summernote('code', '<?=$about_text?>');
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>