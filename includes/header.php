<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';
    $contact_info= array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info limit 4";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($contact_info, $rows['value_info']);
        }
    }
    $conn->close();
?>

<nav class="navbar navbar-light navbar-expand-lg navigation-clean" style="background-color: #82D470;">
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
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="contact.php">Ubicación</a></li>
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
            </ul>
        </div>
    </div>
</nav>