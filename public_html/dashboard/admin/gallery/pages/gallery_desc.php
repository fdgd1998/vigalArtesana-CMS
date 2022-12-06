<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $sql = "select value_info from company_info where key_info = 'gallery-desc'";

    if ($res = $conn->query($sql)) {
        echo "<script>var galleryDesc = '".$res[0]["value_info"]."'</script>";
    }
?>

<div class="container settings-container">
    <h1 class="title">Descripción general</h1>
    <p>Escribe una breve descripción para tu galería. Este texto se mostrará en la página principal de la galería, encima de la vista general de categorías.</p>
    <div id="gallery-desc"></div>
    <div class="button-group-right mt-3">
        <button disabled id="submit" class="btn my-button-3"><i class="i-margin fas fa-save"></i>Guardar</button>
    </div>
</div>