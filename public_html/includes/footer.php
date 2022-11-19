
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-5 col-md-3 footer-links">
                <ul>
                    <li><a href="<?=GetBaseUri()?>/politica-privacidad"><i class="fas fa-user-secret" style="margin-right: 5px;"></i>Política de privacidad</a></li>
                    <li><a href="<?=GetBaseUri()?>/aviso-legal"><i class="fas fa-balance-scale" style="margin-right: 5px;"></i>Aviso legal</a></li>
                    <?php
                        if (!isset($_SESSION['loggedin'])) {
                            echo '<li><a href="'.GetBaseUri().'/login"><i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i>Iniciar sesión</a></li>';
                        } else {
                            echo '<li><a href="'.GetBaseUri().'/dashboard?page=start"><i class="fas fa-cog" style="margin-right: 5px;"></i>Configuración</a></li>';
                            echo '<li><a href="'.GetBaseUri().'/scripts/logout.php"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i>Cerrar sesión</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="col-12 col-sm-7 col-md-6">
                <p><strong>Contacto</strong></p>
                <ul>
                    <li style="color: rgb(240,249,255);"><i class="fas fa-mobile-alt" style="padding-right: 5px;"></i><label id="telephone"><?=$site_settings[0]["value_info"]?></label></li>
                    <li style="color: rgb(240,249,255);"><i class="fas fa-envelope" style="padding-right: 5px;"></i><label id="email"><?=$site_settings[3]["value_info"]?></label></li>
                    <li style="color: rgb(240,249,255);"><i class="fas fa-location-arrow" style="padding-right: 5px;"></i><label id="address"><?=$site_settings[1]["value_info"]?></label></li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-3 web-author">
                <ul>
                    <li>Todos los derechos reservados © <?=date('Y')?></li>
                    <li>Sitio web desarrollado por Francisco Gálvez</li>
                    <li><a target="blank" href="https://www.linkedin.com/in/fdgd">linkedin.com/in/fdgd</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>