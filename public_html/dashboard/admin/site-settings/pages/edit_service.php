<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    $services = $conn->query("select * from services where id = ".$_GET["id"]);

    echo "<script>var servId = ".$_GET["id"]."</script>";
?>

</style>
<div class="container settings-container">
    <h1 class="title">Editando servicio</h1>
    <p class="title-description">Selecciona los atributos del servicio que quieres modificar.</p>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-title">
        <label class="custom-control-label" for="edit-title">Editar título</label>
    </div>
    <div id="title-div" class="input-group mb-3">
        <input disabled type="text" class="form-control" id="title-input-edit" maxlength="60" value="<?=$services[0]["title"]?>">
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-description">
        <label class="custom-control-label" for="edit-description">Editar descripción</label>
    </div>
    <div id="description-div" class="input-group mb-3">
        <textarea disabled class="form-control" id="description-input-edit" maxlength="200"><?=$services[0]["description"]?></textarea>
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-image">
        <label class="custom-control-label" for="edit-image">Editar imagen</label>
    </div>
    <div id="image-div">
        <div class="mb-3">
            <label for="basic-url">Descripción de la imagen:</label>
            <div class="input-group mb-3">
                <input disabled id="edit-image-desc" type="text" class="form-control" maxlength="60">
            </div>
        </div>
        <div id="image-div" class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-upload"></i></span>
            </div>
            <div class="custom-file">
                <input disabled type="file" class="custom-file-input" id="image-input-edit" accept=".png,.jpeg,.jpg">
                <label id="image-input-edit-label" class="custom-file-label" for="image-input-edit" data-browse="Buscar...">Seleccionar imagen...</label>
            </div>
        </div>
    </div>
    <div class="row text-center mb-4">
        <div class="col-6 col-sm-6 col-md-6">
            <p>Imagen actual:</p>
            <img width="100%" style="object-fit: cover !important;" src="../uploads/services/<?=$services[0]["image"]?>"/>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <p>Nueva imagen:</p>
            <img id="service-edit-image-preview" width="100%" style="object-fit: cover !important;" src="../includes/img/placeholder-image.jpg"/>
        </div>
    </div>
    <div class="button-group text-right">
        <button id="cancel-service-edit" class="btn my-button-2">Cancelar</button>
        <button disabled id="submit-service-edit" class="btn my-button-3"><i class="far fa-edit"></i>Editar</button>
    </div>
</div>