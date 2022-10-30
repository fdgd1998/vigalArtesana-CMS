<?php
    //error_reporting(0);
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("show_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $sql = "select value_info from company_info where key_info = 'gallery-desc'";

    if ($res = $conn->query($sql)) {
        echo "<script>var galleryDesc = '".$res->fetch_assoc()["value_info"]."'</script>";
    }
?>

<div class="container settings-container">
    <h1 class="title">Descripción general</h1>
    <p>Define un texto descriptivo que acompañe a la vista general de la galería.</p>
    <div id="gallery-desc"></div>
    <div style="margin-top: 20px;" class="button-group text-right">
        <button disabled id="submit" class="btn my-button-3"><i class="i-margin fas fa-save"></i>Guardar</button>
    </div>
</div>