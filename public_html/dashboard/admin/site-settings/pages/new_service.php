<?php
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
?>
<div class="container content">
    <h1 class="title">Nuevo servicio</h1>
    <p class="title-description">Tamaño máximo de imagen: 5 MB.</p>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Título</span>
        </div>
        <input id="title-new" type="text" class="form-control" maxlength="60">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Descripción</span>
        </div>
        <textarea class="form-control" id="description-new" maxlength="200"></textarea>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-upload"></i></span>
        </div>
        <div class="custom-file">
            <input id="image-input-new" type="file" class="custom-file-input" accept=".jpg, .png, .jpeg">
            <label id="image-input-label-new" class="custom-file-label" for="image-new"  data-browse="Buscar...">Seleccionar imagen...</label>
        </div>
    </div>
    <div hidden id="image-preview-div-new" class="mb-3 text-center">
        <p>Vista previa:</p>
        <img id="image-preview-new" width="50%"><img>
    </div>
    <div class="text-right" style="margin-top: 20px;">
        <button type="button" onclick="window.location.href = '?page=manage-services'" class="btn my-button-2" >Cancelar</button>
        <button disabled type="button" id="new-service-btn" class="btn my-button" ><i class="far fa-save"></i>Guardar</button>
    </div>
</div>