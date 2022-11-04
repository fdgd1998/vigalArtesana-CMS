<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
?>

<div class="container maintenance text-center">
    <div class="">
        
        <img height="200" src="<?=GetBaseUri()?>/includes/img/maintenance.svg">
        <h1 class="maintenance-title "><?=$site_settings[2]["value_info"]?></h1><br>
        <p>En estos momentos estamos realizando cambios en sitio web. Volveremos en la mayor brevedad posible.</p>
        <p>Mientras tanto, puedes visitar nuestros perfiles en redes sociales.</p>
        <div style="margin-top: 30px;">
            <?php if (isset($site_settings[4]["value_info"]["whatsapp"])):?>
                <a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$site_settings[4]["value_info"]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a>
            <?php endif; ?>
            <?php if (isset($site_settings[4]["value_info"]["instagram"])):?>
                <a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$site_settings[4]["value_info"]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$site_settings[4]["value_info"]["instagram"]?></a>
            <?php endif; ?>
            <?php if (isset($site_settings[4]["value_info"]["facebook"])):?>
                <a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$site_settings[4]["value_info"]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$site_settings[4]["value_info"]["facebook"]?></a>
            <?php endif; ?>
        </div>
        <div style="margin-top: 30px; margin-bottom: 30px;">
            <p>También puedes ponerte en contacto con nosotros</p>
            <a class="contact-data" href="tel:<?=str_replace(' ','',$site_settings[0]["value_info"])?>"><?=$site_settings[0]["value_info"]?></a>
            <a class="contact-data" href="mailto:<?=$site_settings[3]["value_info"]?>"><?=$site_settings[3]["value_info"]?></a>
        </div>
    </div>
    <hr>
    <p style="margin-top: 30px;">Si eres el propietario del sitio web, puedes iniciar sesión haciendo clic <u><a href="<?=GetBaseUri()?>/login">aquí.</a></u></p>
</div>