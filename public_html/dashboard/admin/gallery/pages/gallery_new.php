<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $categories = array(); // Array to save categories
    $sql = "select id, name from categories order by name asc";
    if ($res = $conn->query($sql)) {
        foreach ($res as $item) {
            $categories[$item["id"]] = $item["name"];
        }
    }

    // Variables for storing data to edit, just in case if needed.
    $edit = false;
    $category = '';
    $title = '';
    $content = '';
    $images = '';

?>
<style>
    img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .image {
        display: inline-block;
    }

    .current-image {
        margin-right: -5px;
        margin-left: 5px;
        margin-top: 5px;
        margin-bottom: 5px; 
    }

    .new-image {
        margin: 8px;
    }

    input[type="checkbox"] {
        position: relative;
        left: -20px;
        top: 3px;
    }

    #images-preview {
        width: 100%;
        display: inline-block;
        *display: inline;
    }

    .card-div-img {
        width: 10%;
        height: auto;
        object-fit: cover;
        display: inline-block;
        padding: 5px 10px 5px 5px;
        vertical-align: middle;
    }

    .card-div-alt-text {
        width: 70%;
        display: inline-block;
        padding: 5px;
    }

    .card-div-category {
        width: 30%;
        display: inline-block;
        padding: 5px;
    }

    .main-div {
        border: 1px solid lightgrey;
        border-radius: 2px;
        margin-bottom: 10px;
    }
    
    .input-label {
        display: inline-block;
        padding-left: 5px:
    }

</style>


<div class="container settings-container">
    <h1 class="title">Subir imágenes</h1>
    <?php if (count($categories) > 0) : ?>
    <p class="title-description">Sube imágenes a tu galería. Puedes subir un máximo de 5 ficheros simultáneamente y un peso de 5 MB máximo por cada uno.</p>
    <form style="margin-bottom: 20px;padding-top: 17px;" enctype="multipart/form-data">
        <div class="form-row" style="margin-top: 10px;">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-upload"></i>
                    </span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="upload-files" accept=".jpg,.png" multiple aria-describedby="inputGroupFileAddon01">
                    <label id="upload-files-name" class="custom-file-label" for="upload-files" data-browse="Buscar...">Seleccionar fichero(s)...</label>
                </div>
            </div>
        </div>
        <!-- class="row row-cols-2 row-cols-md-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" -->
        <div id="images-preview"  style="margin-top: 10px;">
        </div>
        <div class="button-group-right">
            <button id="cancel" class="btn my-button-2" type="button"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
            <button id="uploadbtn" disabled class="btn my-button" type="button" style="margin-left: 5px;"><i class="i-margin fa-solid fa-upload"></i>Subir imágenes</button>
        </div>
    </form>
    <?php else: ?>
    <p>No has creado ninguna categoría. Para subir imágenes, crea al menos una categoría.</p>
    <div class="button-group-left">
        <button type="button" id="create-category" class="btn my-button"><i class="i-margin fas fa-plus-circle"></i>Nueva categoría</button>
    </div>    
    <?php endif; ?>
</div>
