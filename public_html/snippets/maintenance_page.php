<div class="container maintenance text-center">
    <div class="">
        <h1 class="maintenance-title "><?=$GLOBALS["site_settings"][2]?></h1><br>
        <p>En estos momentos estamos realizando el mantenimiento del sitio web. Volveremos en la mayor brevedad posible.</p>
        <p>Mientras tanto, puedes visitar nuestros perfiles en redes sociales.</p>
        <div style="margin-top: 30px;">
            <?php if (isset($GLOBALS["site_settings"][4]["whatsapp"])):?>
                <a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][4]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a>
            <?php endif; ?>
            <?php if (isset($GLOBALS["site_settings"][4]["instagram"])):?>
                <a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][4]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$GLOBALS["site_settings"][4]["instagram"]?></a>
            <?php endif; ?>
            <?php if (isset($GLOBALS["site_settings"][4]["facebook"])):?>
                <a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][4]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$GLOBALS["site_settings"][4]["facebook"]?></a>
            <?php endif; ?>
        </div>
        <div style="margin-top: 30px; margin-bottom: 30px;">
            <p>También puedes ponerte en contacto con nosotros</p>
            <a class="contact-data" href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a>
            <a class="contact-data" href="mailto:<?=$GLOBALS["site_settings"][3]?>"><?=$GLOBALS["site_settings"][3]?></a>
        </div>
    </div>
    <hr>
    <p style="margin-top: 30px;">Si eres el propietario del sitio web, puedes iniciar sesión haciendo clic <u><a href="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/login">aquí.</a></u></p>
</div>