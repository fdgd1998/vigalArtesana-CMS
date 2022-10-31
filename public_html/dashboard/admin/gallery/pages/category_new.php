
<?php

    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_session.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $categories = array(); // Array to save categories

    if ($_GET["page"] == "edit-category") {
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
                        $desc = ($_GET["page"] == "edit-category")?$categories["description"]:"";
                        echo "<script>var catDesc = '".$desc."'</script>";
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>
<style>
  .disabled-form {
      pointer-events: none;
      opacity: 0.4;
  }
  .custom-checkbox {
    margin-bottom: 10px;
}
</style>

<div class="container settings-container">
    <?php if ($_GET["page"] == "edit-category"): ?>
    <h1 class="title">Editando categoría "<?=$categories["name"]?>"</h1>
    <?php else: ?>
    <h1 class="title">Nueva categoría</h1>
    <?php endif; ?>
    <?php if ($_GET["page"] == "edit-category"): ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-name-chkbx">
        <label class="custom-control-label" for="change-edit-name-chkbx">Editar nombre.</label>
    </div>
    <?php endif; ?>
    <div id="edit-change-name" class="input-group mb-3 <?=$_GET["page"] == "edit-category"?'disabled-form':''?>">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Nombre</span>
        </div>
        <input type="text" class="form-control" id="<?=$_GET["page"] == "edit-category"?'update':'new'?>-cat-name">
    </div>
    <?php if ($_GET["page"] == "edit-category"): ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-image-chkbx">
        <label class="custom-control-label" for="change-edit-image-chkbx">Establecer nueva imagen.</label>
    </div>
    <?php endif; ?>
    <div  id="edit-change-image" class="<?=$_GET["page"] == "edit-category"?'disabled-form':''?>">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class='fas fa-upload'></i></span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="<?=$_GET["page"] == "edit-category"?'update':'new'?>-cat-image" aria-describedby="inputGroupFileAddon01">
            <label id="update-cat-image-name" class="custom-file-label" for="<?=$_GET["page"] == "edit-category"?'update':'new'?>-cat-image" data-browse="Buscar...">Seleccionar imagen...</label>
        </div>
    </div>
    <?php if ($_GET["page"] == "edit-category"): ?>
    <div class="row text-center mb-4">
        <div class="col-6 col-sm-6 col-md-6">
            <p>Imagen actual:</p>
            <img width="100%" style="object-fit: cover !important;" src="../uploads/categories/<?=$categories["image"]?>"/>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <p>Nueva imagen:</p>
            <img id="update-cat-image-preview" width="100%" style="object-fit: cover !important;" src="../includes/img/placeholder-image.jpg"/>
        </div>
    </div>
    <?php else: ?>
    <div style="margin-top: 15px;" class="form-group" hidden id="new-cat-image-preview-div">
        <label for="new-cat-image-preview" style="width: 100%;">Vista previa de nueva imagen: </label>
        <center><img id="new-cat-image-preview" src="#" alt="" width="100%" style="width: 50%;"></center>
    </div>
    <?php endif; ?>
    </div>
    <?php if ($_GET["page"] == "edit-category"): ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="change-edit-desc-chkbx">
        <label class="custom-control-label" for="change-edit-desc-chkbx">Editar descripción.</label>
    </div>
    <?php else: ?>
    <label  for="cat-edit">Descripción:</label>
    <?php endif; ?>
    <div id="cat-desc" class="disabled-form">
    </div> 
    <div class="button-group text-right" style="margin-top: 20px">
        <button id="cancel-btn" class="btn my-button-2"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
        <button disabled id="<?=($_GET["page"] == "edit-category")?"cat-edit":"cat-create"?>" <?=($_GET["page"] == "edit-category")?'catid="'.$categories["id"].'"':''?> class="btn my-button-3"><i class="i-margin fas fa-<?=($_GET["page"] == "edit-category")?"edit":"save"?>"></i><?=($_GET["page"] == "edit-category")?"Editar":"Crear"?></button>
    </div>   
</div>
