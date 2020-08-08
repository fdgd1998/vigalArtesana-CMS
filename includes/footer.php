<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 item">
                    <h3>Mapa del sitio</h3>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="showcase.php">Exposición</a></li>
                        <li><a href="contact.php">Contacto</a></li>

                        <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li><a href="modules/logout.php">Cerrar sesión</a></li>';
                            } else {
                                echo '<li><a href="login.php">Iniciar sesión</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-4 item">
                    <h3>Contacto</h3>
                    <ul>
                        <li style="color: rgb(240,249,255);"><i class="icon-phone" style="padding-right: 5px;"></i><label id="telephone"><?=$contact_info[0]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="icon-envelope" style="padding-right: 5px;"></i><label id="email"><?=$contact_info[2]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="icon-location-pin" style="padding-right: 5px;"></i><label id="address"><?=$contact_info[1]?></label></li>
                    </ul>
                </div>
                <div class="item social col-sm-4 col-md-4">
                    <h3 style="padding-bottom: 10px;">Síguenos en redes sociales</h3>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-facebook"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-twitter"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-snapchat"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-instagram"></i></a>
                </div>
            </div>
            <div class="copyright">
                <label name="company_name"><?=$contact_info[3]?></label>
                <label style="margin-right: 3px;margin-left: 3px;">©<br/>
                </label><label id="footer_year"><?=date('Y')?></label>
            </div>
        </div>
    </footer>
</div>
