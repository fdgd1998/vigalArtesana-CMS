<?php   
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    echo "<script>var indexDescription = '".$site_settings[10]["value_info"]."'</script>";
?>
<div class="container settings-container">
    <h1 class="title"></i>Página de inicio</h1>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="fa-regular fa-image"></i></i>Imagen de portada</h3>
                <p class="title-description">Establece una imagen de portada que se verá en la página principal del sitio web (máximo 5 MB). Observa la imagen de la siguiente sección para guiarte.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-upload"></i>
                        </span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload-index-image" accept=".png,.jpeg,.jpg" aria-describedby="inputGroupFileAddon01">
                        <label id="upload-index-name" class="custom-file-label" for="upload-files" data-browse="Buscar...">Seleccionar imagen...</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="basic-url">Descripción de la imagen:</label>
                    <div class="input-group mb-3">
                        <input id="image-desc" type="text" class="form-control" maxlength="60">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 col-sm-6 col-md-6">
                <p>Imagen actual:</p>
                <img width="100%" style="object-fit: cover !important;" src="../uploads/<?=$site_settings[5]["value_info"]?>"/>
            </div>
            <div class="col-6 col-sm-6 col-md-6">
                <p>Nueva imagen:</p>
                <img id="index-image-preview" width="100%" style="object-fit: cover !important;" src="../includes/img/placeholder-image.jpg"/>
            </div>
        </div>
        <div class="button-group-right mt-3"><button id="submit-index-image" disabled class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button></div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title">Eslogan de la empresa</h3>
                <p class="title-description">Establece un eslogan que se mostrará sobre la imagen de la página principal configurada en la opción de arriba. Observa la imagen de abajo para guiarte.</p>
            <img width="100%" class="mb-5" style="object-fit: contain; max-height: 400px" src="<?=GetBaseUri()?>/includes/img/index-image-example.jpg">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <textarea id="index-image-description" class="form-control"><?= ($site_settings[6]["value_info"] != ""? $site_settings[6]["value_info"]:"")?></textarea>
                </div>
            </div>
        </div>
        <div class="button-group-right"><button id="submit-index-image-description" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button></div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title">Descripción de la empresa</h3>
                <p class="title-description">Describe brevemente tu negocio. Esta descripción aparecerá debajo de la imagen de la página principal.</p>
            </div>
        </div>
        <div id="index-brief-description"></div>
        <div class="button-group-right mt-3"><button id="submit-index-brief-description" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button></div>
    </form>
</div>