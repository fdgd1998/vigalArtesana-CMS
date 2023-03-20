<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_current_page.php";

    $request_uri = ltrim($_SERVER["REQUEST_URI"], "/");
    $is_index_page = 0;
    if (strcmp($_SERVER['REQUEST_URI'], "/") == 0) $is_index_page = 1;
    echo "<script>var is_index_page = $is_index_page </script>";
?>
<nav class="nav-<?=$is_index_page?"transparent":"solid"?> navbar navbar-expand-lg navigation-clean">
    <div class="container">
        <a class="navbar-brand" href="<?=GetBaseUri()?>" name="company_name"><?=$site_settings[2]["value_info"]?></a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid grey">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url('/includes/img/<?=$is_index_page?"menu-white":"menu-black"?>.svg');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link nav-header underline-animated <?=currentPage($request_uri, "")?'current-page':''?>" href="<?=GetBaseUri()?>" >Inicio</a></li>
                <li class="nav-item"><a class="nav-link nav-header underline-animated <?=currentPage($request_uri, "galeria")?'current-page':''?>" href="<?=GetBaseUri()?>/galeria">Galería</a></li>
                <li class="nav-item"><a class="nav-link nav-header underline-animated <?=currentPage($request_uri, "sobre-nosotros")?'current-page':''?>" href="<?=GetBaseUri()?>/sobre-nosotros">Sobre nosotros</a></li>
                <li class="nav-item"><a class="nav-link nav-header underline-animated <?=currentPage($request_uri, "contacto")?'current-page':''?>" href="<?=GetBaseUri()?>/contacto">Contacto</a></li>

                <li class="nav-item">
                    <div class="social-div">
                        <?php if (isset($site_settings[4]["value_info"]["whatsapp"])):?>
                            <div class="social-link">
                                <a class="nav-link whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$site_settings[4]["value_info"]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($site_settings[4]["value_info"]["instagram"])):?>
                            <div class="social-link">
                                <a class="nav-link instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$site_settings[4]["value_info"]["instagram"]?>"><i class="fab fa-instagram"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($site_settings[4]["value_info"]["facebook"])):?>
                            <div class="social-link">
                                <a class="nav-link facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$site_settings[4]["value_info"]["facebook"]?>"><i class="fab fa-facebook-square"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
                <li class="nav-item dropdown" hidden>
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    <?php if (strcmp($_SESSION["lang"], "es") == 0): ?>
                    <span class="flag-icon flag-icon-esp"></span>Español
                    <?php else: ?>
                    <span class="flag-icon flag-icon-gbr"></span>English
                    <?php endif; ?>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?=$_SERVER['REQUEST_URI']?>"><span class="flag-icon flag-icon-esp"></span>Español</a>
                    <a class="dropdown-item" href="/en<?=$_SERVER['REQUEST_URI']?>"><span class="flag-icon flag-icon-gbr"></span>English</a>
                </li>
            </ul>
        </div>
    </div>
</nav>