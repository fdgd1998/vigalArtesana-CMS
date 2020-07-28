<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/connection.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/get_http_protocol.php';
    $contact_info= array();
    $URL = getHttpProtocol().'://'.$_SERVER['SERVER_NAME'];
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

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
<nav class="navbar navbar-light navbar-expand-md navigation-clean" style="background-color: #5026D1;">
    <div class="container">
        <a class="navbar-brand" href="#" style="font-family: 'Great Vibes'; font-weight: lighter; color: rgb(255, 255, 255);font-size: 32px;" name="company_name"><?=$contact_info[3]?></a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white;">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url(&quot;<?=$URL?>/includes/img/iconfinder-icon.svg&quot;);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="<?=$URL?>/index.php" style="color: rgb(255, 255, 255);">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-hover-animate="pulse" href="<?=$URL?>/showcase.php" style="color: rgb(255, 255, 255);">Exposición</a></li>
                <?php
                    if (isset($_SESSION['user'])) {
                        echo "
                            <li class='nav-item dropdown'>
                                <a data-toggle='dropdown' data-bs-hover-animate='pulse' aria-expanded='false' class='dropdown-toggle nav-link' href='#' style='color: white;'>
                                    <i class='far fa-user-circle' style='font-size: 20px;'></i>
                                </a>
                                <div role='menu' class='dropdown-menu dropdown-menu-right'>
                                    <a role='presentation' class='dropdown-item' href='".$URL."/dashboard/?page=start'>
                                        <i class='fas fa-cog' style='margin-right: 5px;'></i>
                                        Configuración
                                    </a>
                                    <a role='presentation' class='dropdown-item' href='".$URL."/modules/logout.php'>
                                        <i class='fas fa-power-off' style='margin-right: 5px;'></i>
                                        Cerrar sesión
                                    </a>
                                </div>
                            </li>
                        ";
                    }
                ?>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>