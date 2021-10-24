<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 item">
                    <ul>
                        <li><a href="privacidad.php"><i class="fas fa-user-secret" style="margin-right: 5px;"></i>Política de privacidad</a></li>
                        <li><a href="legal.php"><i class="fas fa-balance-scale" style="margin-right: 5px;"></i>Aviso legal</a></li>
                        <?php
                            if (!isset($_SESSION['user'])) {
                                echo '<li><a href="login.php"><i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i>Iniciar sesión</a></li>';
                            } else {
                                echo '<li><a href="dashboard?page=start"><i class="fas fa-cog" style="margin-right: 5px;"></i>Configuración</a></li>';
                                echo '<li><a href="scripts/logout.php"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i>Cerrar sesión</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-4 item">
                    <h3>Contacto</h3>
                    <ul>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-mobile-alt" style="padding-right: 5px;"></i><label id="telephone"><?=$GLOBALS["site_settings"][0]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-envelope" style="padding-right: 5px;"></i><label id="email"><?=$GLOBALS["site_settings"][3]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-location-arrow" style="padding-right: 5px;"></i><label id="address"><?=$GLOBALS["site_settings"][1]?></label></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-4 item">
                    <ul>
                        <li>© <?=date('Y')?></li>
                        <li>Sitio web desarrollado por Francisco Gálvez</li>
                        <li>Código fuente: <a class="footer_link" target="blank" href="https://www.github.com/fdgd1998/vigalArtesanos-CMS">github.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
