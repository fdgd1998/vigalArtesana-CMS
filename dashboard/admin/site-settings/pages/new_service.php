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
            <span class="input-group-text"><i class="fas fa-upload"></i></span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile01">
            <label id="image" class="custom-file-label" for="inputGroupFile01" data-browse="Buscar...">Seleccionar imagen...</label>
        </div>
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Descripción</span>
        </div>
        <textarea class="form-control" id="description" aria-label="With textarea"></textarea>
    </div>
    <div class="text-right" style="margin-top: 20px;">
        <button type="button" onclick="window.location.href = '?page=manage-services'" class="btn btn-danger" style="margin-bottom: 15px;">Cancelar</button>
        <button disabled type="button" id="new-service" class="btn my-button" style="margin-bottom: 15px;"><i class="fas fa-save"></i>Guardar</button>
    </div>
</div>