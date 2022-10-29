<nav class="nav-solid navbar navbar-expand-lg navigation-clean">
    <div class="container">
        <a class="navbar-brand" href="<?=GetBaseUri()?>" name="company_name"><?=$GLOBALS["site_settings"][2]?></a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid grey">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url('/includes/img/icons8-menu.svg');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1" style="margin-left: 5%;">
            <ul class="navbar-nav nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link underline-animated" href="<?=GetBaseUri()?>">Inicio</a></li>
                <li class="nav-item"><a class="nav-link underline-animated" href="<?=GetBaseUri()?>/galeria">Galería</a></li>
                <li class="nav-item"><a class="nav-link underline-animated" href="<?=GetBaseUri()?>/sobre-nosotros">Sobre nosotros</a></li>
                <li class="nav-item"><a class="nav-link underline-animated" href="<?=GetBaseUri()?>/contacto">Contacto</a></li>

                <li class="nav-item">
                    <div class="social-div">
                        <?php if (isset($GLOBALS["site_settings"][4]["whatsapp"])):?>
                            <div class="social-link">
                                <a class="nav-link whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][4]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($GLOBALS["site_settings"][4]["instagram"])):?>
                            <div class="social-link">
                                <a class="nav-link instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][4]["instagram"]?>"><i class="fab fa-instagram"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($GLOBALS["site_settings"][4]["facebook"])):?>
                            <div class="social-link">
                                <a class="nav-link facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][4]["facebook"]?>"><i class="fab fa-facebook-square"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
