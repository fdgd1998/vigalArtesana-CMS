<nav class="navbar navbar-light navbar-expand-md navigation-clean" style="background-color: #5026D1;">
    <div class="container">
        <a class="navbar-brand" href="#" style="color: rgb(255, 255, 255);font-size: 20px;">Panel de control</a>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1" style="color: white;">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon" style="background-image: url(&quot;../includes/img/iconfinder-icon.svg&quot;);"></span>
        </button>
        <div
            class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-hover-animate="pulse" style="color: rgb(255, 255, 255);" href="../index.php" >Volver al sitio web</a>
                </li>
                <?php
                    if ($_SESSION['account_type'] != 'publisher') {
                        echo '<li class="nav-item" role="presentation">
                        <a id="userconfig" class="nav-link" data-bs-hover-animate="pulse" style="color: rgb(255, 255, 255);" href="./admin/users/users.php?order=asc" target="mainFrame">Usuarios</a>
                        </li>';
                        echo '<li class="nav-item" role="presentation">
                        <a id="companyconfig" class="nav-link" data-bs-hover-animate="pulse" style="color: rgb(255, 255, 255);">Personalización del sitio</a>
                        </li>';
                    }
                ?>
                
                <li class="nav-item" role="presentation">
                    <a id="postconfig" class="nav-link" data-bs-hover-animate="pulse"  style="color: rgb(255, 255, 255);">Posts</a>
                </li>
                
                <li class='nav-item dropdown'>
                    <a data-toggle='dropdown' data-bs-hover-animate='pulse' aria-expanded='false' class='dropdown-toggle nav-link' href='#' style='color: white;'>
                        <i class='far fa-user-circle' style='font-size: 20px;'></i>
                    </a>
                    <div role='menu' class='dropdown-menu dropdown-menu-right'>
                        <a role='presentation' class='dropdown-item' href='dashboard.php'>
                            <i class='fas fa-user' style='margin-right: 5px;'></i>Perfil
                        </a>
                        <a role='presentation' class='dropdown-item' href='../../modules/logout.php'>
                            <i class='fas fa-power-off' style='margin-right: 5px;'></i>Cerrar sesión
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>