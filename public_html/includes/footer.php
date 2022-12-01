
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 links-block links-spacing">
                <a href="<?=GetBaseUri()?>">Inicio</a>
                <a href="<?=GetBaseUri()?>/galeria">Galería</a>
                <a href="<?=GetBaseUri()?>/sobre-nosotros">Sobre nosotros</a>
                <a href="<?=GetBaseUri()?>/contacto">Contacto</a>
                <a href="<?=GetBaseUri()?>/politica-privacidad">Política de privacidad</a>
                <a href="<?=GetBaseUri()?>/aviso-legal">Aviso legal</a>
                <?php
                    if (!isset($_SESSION['loggedin'])) {
                        echo '<a href="'.GetBaseUri().'/login">Iniciar sesión</a>';
                    } else {
                        echo '<a href="'.GetBaseUri().'/dashboard?page=start">Configuración</a>';
                        echo '<a href="'.GetBaseUri().'/scripts/logout.php">Cerrar sesión</a>';
                    }
                ?>   
            </div>
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col contact_info links-spacing">
                        <a href="tel:<?=$site_settings[0]["value_info"]?>"><i style="color: #E34234;" class="i-margin fa-solid fa-phone"></i><?=$site_settings[0]["value_info"]?></a>
                        <a href="mailto:<?=$site_settings[3]["value_info"]?>"><i style="color: #E34234;" class="i-margin fa-solid fa-envelope"></i><?=$site_settings[3]["value_info"]?></a>
                        <div class="social">
                            <?php if (isset($site_settings[4]["value_info"]["whatsapp"])):?>
                                <a class="whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$site_settings[4]["value_info"]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i></a>
                            <?php endif; ?>
                            <?php if (isset($site_settings[4]["value_info"]["instagram"])):?>
                                <a class="instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$site_settings[4]["value_info"]["instagram"]?>"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (isset($site_settings[4]["value_info"]["facebook"])):?>
                                <a class="facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$site_settings[4]["value_info"]["facebook"]?>"><i class="fab fa-facebook-square"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col site_info links-block links-spacing">
                        <p class="company_name"><?=$site_settings[2]["value_info"]?></p>
                        <?=date('Y')?> © Sitio web desarrollado por Francisco Gálvez
                        <a target="blank" href="https://www.linkedin.com/in/fdgd">linkedin.com/in/fdgd</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>