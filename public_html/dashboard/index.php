<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_permissions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/database_connection.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_session.php";

    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/forbidden.php";
        exit();
    }

    $metadata = array();
    $conn = new DatabaseConnection();
    $site_settings = getSiteSettings();
    $page = "";
    $title = "";

    if (!isset($_GET['page'])) $title = 'Panel de control | '.$site_settings[2]["value_info"];
    
    switch($_GET['page']) {
        case 'logs':
            $page = '/dashboard/admin/site-settings/pages/logs.php';
            $title = 'Logs | '.$site_settings[2]["value_info"];
            break;
        case 'new-user':
            $page = '/dashboard/admin/users/pages/new_user.php';
            $title = 'Nuevo usuario | '.$site_settings[2]["value_info"];
            break;
        case 'user-profile':
            $page = '/dashboard/admin/users/pages/user_profile.php';
            $title = 'Perfil | '.$site_settings[2]["value_info"];
            break;
        case 'manage-users':
            $page = '/dashboard/admin/users/pages/manage_users.php';
            $title = 'Administrar usuarios | '.$site_settings[2]["value_info"];
            break;
        case 'seo-notify':
            $page = '/dashboard/admin/site-settings/pages/seo_notify.php';
            $title = 'Notificar cambios SEO | '.$site_settings[2]["value_info"];
            break;
        case 'text-editor':
            $page = '/dashboard/admin/site-settings/pages/text_editor.php';
            $title = 'Editor: '.$_GET['file'].' | '.$site_settings[2]["value_info"];
            break;
        case 'new-category':
            $page = '/dashboard/admin/gallery/pages/category_new.php';
            $title = 'Nueva categoría | '.$site_settings[2]["value_info"];
            break;
        case 'gallery-desc':
            $page = '/dashboard/admin/gallery/pages/gallery_desc.php';
            $title = 'Descripción de la galería | '.$site_settings[2]["value_info"];
            break;
        case 'edit-category':
            $page = '/dashboard/admin/gallery/pages/category_new.php';
            $title = 'Editar categoría | '.$site_settings[2]["value_info"]; 
            break;
        case 'manage-gallery':
            $page = '/dashboard/admin/gallery/pages/manage_gallery.php';
            $title = 'Administrar galería | '.$site_settings[2]["value_info"];
            break;
        case 'metadata-settings':
            $page = '/dashboard/admin/site-settings/pages/pages_metadata.php';
            $title = 'Títulos y descripciones de páginas (metadatos) | '.$site_settings[2]["value_info"];
            break;
        case 'gallery-new':
            $page = '/dashboard/admin/gallery/pages/gallery_new.php';
            $title = 'Subir imágenes | '.$site_settings[2]["value_info"];
            break;
        case 'categories':
            $page = '/dashboard/admin/gallery/pages/categories.php';
            $title = 'Administrar categorías | '.$site_settings[2]["value_info"];
            break;
        case 'general-settings':
            $page = '/dashboard/admin/site-settings/pages/general.php';
            $title = 'Opciones de la página de inicio | '.$site_settings[2]["value_info"];
            break;
        case 'contact-settings':
            $page = '/dashboard/admin/site-settings/pages/contact.php';
            $title = 'Opciones de contacto | '.$site_settings[2]["value_info"];
            break;
        case 'manage-services':
            $page = '/dashboard/admin/site-settings/pages/services.php';
            $title = 'Administrar servicios | '.$site_settings[2]["value_info"];
            break;
        case 'new-service':
            $page = '/dashboard/admin/site-settings/pages/new_service.php';
            $title = 'Nuevo servicio | '.$site_settings[2]["value_info"];
            break;
        case 'about-us':
            $page = '/dashboard/admin/site-settings/pages/about_us.php';
            $title = 'Editar sobre nosotros | '.$site_settings[2]["value_info"];
            break;
        case 'advanced':
            $page = '/dashboard/admin/site-settings/pages/advanced.php';
            $title = 'Opciones avanzadas | '.$site_settings[2]["value_info"];
            break;
        case 'edit-service':
            $page = '/dashboard/admin/site-settings/pages/edit_service.php';
            $title = 'Editar servicio | '.$site_settings[2]["value_info"];
            break;
        default:
            $page = '/dashboard/start.php';
            $title = 'Panel de control | '.$site_settings[2]["value_info"];
    }
    

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?=$title?></title>
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/gallery.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/summernote/summernote-bs4.min.css" />
</head>

<body class="d-flex">
    <?php 
    if ($site_settings[11]["value_info"] == "true" && HasPermission("manage_siteSettings")) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
    }
    if ($site_settings[13]["value_info"] == "true" && HasPermission("manage_seoSettings")) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/seo_message.php";
    }
    ?>
    <nav class="nav-solid navbar navbar-expand-lg navigation-clean">
        <div class="container">
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid grey">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon" style="background-image: url('<?=GetBaseUri()?>/includes/img/icons8-menu.svg');"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php if (HasPermission("manage_siteSettings")): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Configuración del sitio
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <h6 class="dropdown-header">Información de la empresa</h6>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=general-settings">
                                    <i class="fas fa-home"></i>
                                    Página de inicio
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=contact-settings">
                                    <i class="fas fa-address-book"></i>
                                    Contacto, ubicación y horario
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=about-us">
                                    <i class="fas fa-industry"></i>
                                    Sobre nosotros
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Servicios</h6>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=manage-services">
                                    <i class="fas fa-wrench"></i>
                                    Gestionar servicios
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=new-service">
                                    <i class="fas fa-plus-circle"></i>
                                    Nuevo servicio
                                </a>
                            </div>
                        </li>
                        <?php if (HasPermission("manage_advancedSettings")): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Avanzado
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=advanced">
                                    <i class="fas fa-code"></i>
                                    Opciones avanzadas
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=logs">
                                    <i class="fas fa-file-code"></i>
                                    Ver logs
                                </a>
                            </div>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (HasPermission("manage_seoSettings")): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                SEO
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=seo-notify">
                                    <i class="fab fa-searchengin"></i>
                                    Notificar cambios a motores de búsqueda
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Metadatos</h6>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=metadata-settings">
                                    <i class="fas fa-window-maximize"></i>
                                    Título y descripción de las páginas (metadatos)
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=text-editor&file=sitemap.xml">
                                    <i class="fas fa-file-code"></i>
                                    Modificar sitemap.xml
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=text-editor&file=robots.txt">
                                    <i class="fas fa-file-alt"></i>
                                    Modificar robots.txt
                                </a>
                            </div>
                        </li>
                        <?php if (HasPermission("manage_users")): ?>
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle nav-link" href="#">
                                Usuarios
                            </a>
                            <div role="menu" class="dropdown-menu">
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=manage-users">
                                    <i class="fas fa-users"></i>
                                    Gestionar usuarios
                                </a>
                                <a role="presentation" class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=new-user">
                                    <i class="fas fa-user-plus"></i>
                                    Nuevo usuario
                                </a>
                            </div>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class='nav-item dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle nav-link' href='#'>
                            Galería
                        </a>
                        <div role='menu' class='dropdown-menu'>
                        <h6 class="dropdown-header">Galería</h6>
                            <a role='presentation' class='dropdown-item' href='<?=GetBaseUri()?>/dashboard?page=gallery-desc'>
                                <i class="fas fa-align-left"></i>
                                Descripción general
                            </a>
                            <a role='presentation' class='dropdown-item' href='<?=GetBaseUri()?>/dashboard?page=gallery-new'>
                                <i class='fas fa-upload'></i>
                                Subir imágenes
                            </a>
                            <a role='presentation' class='dropdown-item' href='<?=GetBaseUri()?>/dashboard?page=manage-gallery'>
                                <i class='fas fa-images'></i>
                                Gestionar galería
                            </a>
                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header">Categorías</h6>
                            <a role='presentation' class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=categories">
                                <i class="fas fa-ellipsis-h"></i>
                                Gestionar categorías
                            </a>
                            <a role='presentation' class="dropdown-item" href="<?=GetBaseUri()?>/dashboard?page=new-category">
                                <i class="fas fa-plus-circle"></i>
                                Nueva categoría
                            </a>
                        </div>
                    </li>
                </ul>
                <div style="display: block;">
                    <a class="nav-link" href="<?=GetBaseUri()?>/dashboard?page=user-profile"><i class="fas fa-user-circle"></i></a>
                    <a class="nav-link" href="<?=GetBaseUri()?>"><i class="fas fa-home"></i></a>
                    <a class="nav-link" href="<?=GetBaseUri()?>/scripts/logout.php"><i class="fas fa-power-off"></i></a>
                <div>
            </div>
        </nav>
        <div class="wrapper">
        <!-- Page Content  -->
        <div id="content">
            <div>
                <?php include $_SERVER["DOCUMENT_ROOT"].$page?>
            </div>
        </div>
    </div>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/popper.min.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/load-images.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/show_spinner.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/hide_spinner.js"></script>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "manage-gallery" || $_GET["page"] == "gallery-new")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/gallery_new.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/gallery-manage.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "categories")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/categories.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "new-category" || $_GET["page"] == "edit-category")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/new_category.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/summernote-bs4.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/lang/summernote-es-ES.js"></script>
    <script>
        $("#cat-desc").summernote({
            lang: 'es-ES',
            height: 300,
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
                    <?php if ($_GET["page"] == "edit-category"):?>
                        if (catDesc) $(this).summernote('code', catDesc);
                    <?php endif; ?>
                },
                onChange: function() {
                    <?php if ($_GET["page"] == "edit-category"):?>
                        console.log('onEditChange:', $(this).summernote("code"));
                        enableEditFormBtn();
                    <?php else: ?>
                        console.log('onNewChange:', $(this).summernote("code"));
                        enableCreateFormBtn();
                    <?php endif; ?>
                }
            },
        });
    </script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "general-settings"): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/general.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/summernote-bs4.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/lang/summernote-es-ES.js"></script>
    <script>
        $("#index-brief-description").summernote({
            lang: 'es-ES',
            height: 400,
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
                    if (indexDescription) $(this).summernote('code', indexDescription);
                }
            }
        });
    </script>
    <?php endif; ?>
    <?php if (isset($_GET["page"]) && $_GET["page"] == "gallery-desc"): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/gallery/js/category_desc.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/summernote-bs4.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/lang/summernote-es-ES.js"></script>
    <script>
        $("#gallery-desc").summernote({
            lang: 'es-ES',
            height: 400,
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
                    if (galleryDesc) $(this).summernote('code', galleryDesc);
                },
                onChange: function() {
                    console.log('onChange:', $(this).summernote("code"));
                    enableEditBtn($(this).summernote("code"));
                }
            }
        });
    </script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "contact-settings"): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/contact.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && $_GET["page"] == "advanced"): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/advanced.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "manage-services") || $_GET["page"] == "new-service" || preg_match('^edit-service&id=(\d{1,2})$^', isset($_GET["id"])?$_GET["page"]."&id=".$_GET["id"]:$_GET["page"])): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/services.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "metadata-settings") || $_GET["page"] == "new-service" || preg_match('^edit-service&id=(\d{1,2})$^', isset($_GET["id"])?$_GET["page"]."&id=".$_GET["id"]:$_GET["page"])): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/pages-metadata.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "user-profile")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/users/js/user_profile.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/validations.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "new-user")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/users/js/user_new.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/validations.js"></script>
    <?php endif; ?>

    <?php if (isset($_GET["page"]) && ($_GET["page"] == "manage-users")): ?>
    <script src="<?=GetBaseUri()?>/dashboard/admin/users/js/manage_users.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/validations.js"></script>
    <?php endif; ?>
    
    <?php if(isset($_GET["page"]) && $_GET["page"] == "about-us"): ?>
    <script src="<?=GetBaseUri()?>/includes/summernote/summernote-bs4.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/summernote/lang/summernote-es-ES.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/admin/site-settings/js/about-us.js"></script>
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