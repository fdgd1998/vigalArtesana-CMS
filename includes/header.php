<nav class="header nav-transparent navbar navbar-light sticky-top navbar-expand-lg navigation-clean">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="font-family: 'Great Vibes'; letter-spacing: 2px; padding-right: 15px;  font-weight: lighter; color: black ;font-size: 30px;" name="company_name"><?=$GLOBALS["site_settings"][2]?></a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid grey">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url('/includes/img/icons8-menu.svg');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1" style="margin-left: 5%;">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link nav-link-ltr" data-bs-hover-animate="pulse" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link nav-link-ltr" data-bs-hover-animate="pulse" href="galeria.php">Galería</a></li>
                <li class="nav-item"><a class="nav-link nav-link-ltr" data-bs-hover-animate="pulse" href="sobremi.php">Sobre mí</a></li>
                <li class="nav-item"><a class="nav-link nav-link-ltr" data-bs-hover-animate="pulse" href="contacto.php">Contacto</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li class='nav-item dropdown'>
                        <a data-toggle='dropdown' data-bs-hover-animate='pulse' aria-expanded='false' class='dropdown-toggle nav-link' href='#' style='color: white;'>
                            <i class='far fa-user-circle' style='font-size: 20px;'></i>
                        </a>
                        <div role='menu' class='dropdown-menu dropdown-menu-right'>
                            <a role='presentation' class='dropdown-item' href='/dashboard/?page=start'>
                                <i class='fas fa-cog' style='margin-right: 5px;'></i>
                                Configuración
                            </a>
                            <a role='presentation' class='dropdown-item' href='/scripts/logout.php'>
                                <i class='fas fa-power-off' style='margin-right: 5px;'></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <div class="social-div">
                        <?php if (isset($GLOBALS["site_settings"][4]["whatsapp"])):?>
                            <div class="social-link">
                                <a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][4]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($GLOBALS["site_settings"][4]["instagram"])):?>
                            <div class="social-link">
                                <a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][4]["instagram"]?>"><i class="fab fa-instagram"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($GLOBALS["site_settings"][4]["facebook"])):?>
                            <div class="social-link">
                                <a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][4]["facebook"]?>"><i class="fab fa-facebook-square"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>