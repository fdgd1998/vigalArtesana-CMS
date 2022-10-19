<?php
    //error_reporting(0);
    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_session.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $categories = array(); // Array to save categories

    if (isset($_GET["id"])) {
        try {
            if ($conn->connect_error) {
                echo "No se ha podido establecer una conexión con la base de datos.";
                exit();
            } else {
                // Fetching categories from database and storing then in the array for further use.
                $sql = "select id, name, description, image from categories where id = ".$_GET["id"];
                if ($res = $conn->query($sql)) {
                    if ($rows = $res->fetch_assoc()) {
                        $categories["id"] = $rows["id"];
                        $categories["name"] = $rows["name"];
                        $categories["description"] = $rows["description"];
                        $categories["image"] = $rows["image"];
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
    
?>

<div class="container settings-container">
    <?php if (isset($_GET["id"])): ?>
    <h1 class="title">Editando categoría "<?=$categories["name"]?>"</h1>
    <?php else: ?>
    <h1 class="title">Crear categoría</h1>
    <?php endif; ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-name-chkbx">
        <label class="custom-control-label" for="change-edit-name-chkbx">Editar nombre.</label>
    </div>
    <div id="edit-change-name" class="input-group mb-3 disabled-form">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Nombre</span>
        </div>
        <input type="text" class="form-control" id="update-cat-name" aria-describedby="basic-addon1">
    </div>
    <div class="form-group" hidden id="update-cat-image-preview-div">
        <label for="update-cat-image-preview" style="width: 100%;">Imagen actual: </label>
        <center><img id="update-cat-image-preview" src="#" alt="" width="50%"></center>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-image-chkbx">
        <label class="custom-control-label" for="change-edit-image-chkbx">Establecer nueva imagen.</label>
    </div>
    <div id="edit-change-image" class="disabled-form">
        <label>Nueva imagen : </label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-upload'></i></span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="update-new-cat-image" aria-describedby="inputGroupFileAddon01">
                <label id="update-new-cat-image-name" class="custom-file-label" for="update-new-cat-image" data-browse="Buscar...">Seleccionar imagen...</label>
            </div>
        </div>
        <div style="margin-top: 15px;" class="form-group" hidden id="update-new-cat-image-preview-div">
            <label for="update-new-cat-image-preview" style="width: 100%;">Vista previa de nueva imagen: </label>
            <center><img id="update-new-cat-image-preview" src="#" alt="" width="100%" style="width: 50%;"></center>
        </div>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-desc-chkbx">
        <label class="custom-control-label" for="change-edit-desc-chkbx">Editar descripción.</label>
    </div>
    <div id="edit-change-desc" class=" mb-3 disabled-form">
        <label for="edit-cat-desc">Descripción: </label>
        <textarea class="form-control" id="update-cat-desc" rows="8"></textarea>
    </div>     
</div>
