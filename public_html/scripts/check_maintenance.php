<?php if ($GLOBALS["site_settings"][11] == "true" && isset($_SESSION["loggedin"])): ?>
<div id="maintenance-warning" class="container-fluid">
    <p> <i class="fas fa-exclamation-triangle"></i>El modo de mantenimiento está activado. Puedes ver el sitio web porque has iniciado sesión, pero no estará disponible en internet hasta que lo desactives.</p>
    <p>Puedes desactivarlo <u><a href="./dashboard?page=advanced">aquí</a></u>.</p>
</div>
<?php elseif ($GLOBALS["site_settings"][11] == "true" && !isset($_SESSION["loggedin"])): ?>
<?php header("Location: /mantenimiento"); die();?>
<?php endif; ?>