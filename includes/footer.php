
<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
                    <h3>Mapa del sitio</h3>
                    <ul>
                        <li><a href="<?=$URL?>/index.php">Inicio</a></li>
                        <li><a href="<?=$URL?>/showcase.php">Exposición</a></li>
                        <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li><a href="'.$URL.'/modules/logout.php">Cerrar sesión</a></li>';
                            } else {
                                echo '<li><a href="'.$URL.'/login.php">Iniciar sesión</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>Contacto</h3>
                    <ul>
                        <li style="color: rgb(240,249,255);"><i class="icon-phone" style="padding-right: 5px;"></i><label id="telephone"><?=$contact_info[0]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="icon-envelope" style="padding-right: 5px;"></i><label id="email"><?=$contact_info[2]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="icon-location-pin" style="padding-right: 5px;"></i><label id="address"><?=$contact_info[1]?></label></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <h3 name="company_name"><?=$contact_info[3]?></h3>
                    <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                </div>
                <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
            </div>
            <p class="copyright"><label name="company_name"><?=$contact_info[3]?></label><label style="margin-right: 3px;margin-left: 3px;">©<br /></label><label id="footer_year"><?=date('Y')?></label></p>
        </div>
    </footer>
</div>