<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';
    $contact_info= array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info limit 5";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($contact_info, $rows['value_info']);
        }
    }
    $social_media = json_decode($contact_info[4], true);
    
    $conn->close();
?>
<script>
    $(document).ready(function() {
        $(window).on("scroll", function() {
                if($(window).scrollTop()) {
                    $('.header').addClass('nav-solid');
                    $('.header').removeClass('nav-transparent');
                }
                else {
                    $('.header').addClass('nav-transparent');
                    $('.header').removeClass('nav-solid');
                }
        });
        $('.header').on('shown.bs.collapse', function() {
            $('.header').addClass('nav-solid');
            $('.header').removeClass('nav-transparent');
        });

        $('.header').on('hidden.bs.collapse', function() {
            if($(window).scrollTop()) {
                    $('.header').addClass('nav-solid');
                    $('.header').removeClass('nav-transparent');
                }
                else {
                    $('.header').addClass('nav-transparent');
                    $('.header').removeClass('nav-solid');
                } 
        });
    });
</script>

<nav class="header nav-transparent navbar navbar-light sticky-top navbar-expand-lg navigation-clean">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="font-family: 'Great Vibes'; letter-spacing: 2px; padding-right: 15px;  font-weight: lighter; color: black ;font-size: 35px;" name="company_name"><?=$contact_info[2]?></a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white; border: 1px solid grey">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url('/includes/img/icons8-menu.svg');"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1" style="margin-left: 5%;">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="showcase.php">Galería</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="contact.php">Sobre mí</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="contact.php">Contacto</a></li>

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
                <div class="social-div">
                    <?php if (isset($social_media["whatsapp"])):?>
                        <div class="social-link">
                            <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$social_media["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i></a></li>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($social_media["instagram"])):?>
                        <div class="social-link">
                            <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$social_media["instagram"]?>"><i class="fab fa-instagram"></i></a></li>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($social_media["facebook"])):?>
                        <div class="social-link">
                            <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$social_media["facebook"]?>"><i class="fab fa-facebook-square"></i></a></li>
                        </div>
                    <?php endif; ?>
                </div>
            </ul>
        </div>
    </div>
</nav>