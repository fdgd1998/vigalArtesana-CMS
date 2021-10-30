<div class="container content">
    <h1 class="title">Nuevo servicio</h1>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Título</span>
        </div>
        <input id="title" type="text" class="form-control">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Descripción</span>
        </div>
        <textarea class="form-control" id="description" aria-label="With textarea"></textarea>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-upload"></i></span>
        </div>
        <div class="custom-file">
            <input id="image-input" type="file" class="custom-file-input" accept=".jpg, .png, .jpeg">
            <label id="image-input-label" class="custom-file-label" for="image"  data-browse="Buscar...">Seleccionar imagen...</label>
        </div>
    </div>
    <div hidden id="image-preview-div" class="input-group mb-3 text-center">
        <p>Vista previa:</p>
        <img id="image-preview" width="100%"><img>
    </div>
    <div class="text-right" style="margin-top: 20px;">
        <button type="button" onclick="window.location.href = '?page=manage-services'" class="btn my-button-2" >Cancelar</button>
        <button disabled type="button" id="new-service-btn" class="btn my-button" ><i class="far fa-save"></i>Guardar</button>
    </div>
</div>