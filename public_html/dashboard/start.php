<?php
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
?>
<div class="container">
    <h1 class="text-center" style="margin-top: 10%;">¡Hola <?=$_SESSION['user']?>!</h1>
    <h1 class="text-center" style="margin-top: 5%;font-size: 28px;">Navega por las distintas páginas para configurar el sitio o gestionar el contenido.</h1>
</div>