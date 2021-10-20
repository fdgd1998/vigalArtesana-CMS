<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 item">
                    <ul>
                        <li><a href="privacidad.php">Política de privacidad</a></li>
                        <li><a href="legal.php">Aviso legal</a></li>
                        <?php
                            if (!isset($_SESSION['user'])) {
                                echo '<button style="margin-top: 10px;" onclick="window.location.href = &apos;login.php&apos;" type="button" class="btn btn-outline-light">Iniciar sesión</button>';
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
