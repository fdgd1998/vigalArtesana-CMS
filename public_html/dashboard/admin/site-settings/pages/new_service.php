<?php
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
?>
<div class="container content">
    <h1 class="title">Nuevo servicio</h1>
    <p class="title-description">
        Describe el servicio. Aporta un título, descripción e imagen.
        Junto a la imagen, porporciona una descripción acorde a su contenido para propósitos de SEO.
    </p>
    <p class="title-description">Tamaño máximo de imagen: 5 MB.</p>
    <div class="mb-3">
        <label for="basic-url">Título:</label>
        <div class="input-group mb-3">
            <input id="title-new" type="text" class="form-control">
        </div>
    </div>
    <div class="mb-3">
        <label for="basic-url">Descripción:</label>
        <div class="input-group mb-3">
            <textarea class="form-control" id="description-new"></textarea>
        </div>
    </div>
    <div class="mb-3">
        <label for="basic-url">Descripción de la imagen:</label>
        <div class="input-group mb-3">
            <input id="new-image-desc" type="text" class="form-control">
        </div>
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
    <div class="button-group-right">
        <button type="button" onclick="window.location.href = '?page=manage-services'" class="btn my-button-2" ><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
        <button disabled type="button" id="new-service-btn" class="btn my-button-3" ><i class="i-margin fas fa-save"></i>Guardar</button>
    </div>
</div>