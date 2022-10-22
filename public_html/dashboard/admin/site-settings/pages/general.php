<?php
    error_reporting(0);
    session_start();

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $site_settings = array();

    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $stmt = "select * from company_info";
            if ($res = $conn->query($stmt)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($site_settings, $rows["value_info"]);
                }
            }
        }
        $site_settings[4] = json_decode($site_settings[4], true);
        echo "<script>var indexDescription = '".$site_settings[10]."'</script>";
        $conn->close();
    } catch (Exception $e) {

    }
?>
<div class="container settings-container">
    <h1 class="title"></i>Página de inicio</h1>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-image"></i>Imagen de portada</h3>
                <p class="title-description">Establece una imagen de portada que se verá en la página principal (máximo 5 MB).</p>
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
            </div>
        </div>
        <div class="form-row">
            <div class="col text-center mb-3" hidden>
                <img id="index-image-preview" class="text-center w-50"/>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit-index-image" disabled class="btn my-button" type="button"><i class="far fa-save"></i>Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title">Descripción de la imagen de portada</h3>
                <p class="title-description">Establece una descripción que se mostrará sobre la imagen de la página principal configurada en la opción de arriba.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Descripción</span>
                    </div>
                    <textarea id="index-image-description" class="form-control"><?= ($site_settings[6] != ""? $site_settings[6]:"")?></textarea>
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit-index-image-description" class="btn my-button" type="button"><i class="far fa-save"></i>Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title">Texto resumen página de inicio</h3>
                <p class="title-description">Describe brevemente tu negocio. Esta descripción aparecerá debajo de la imagen de la página principal.</p>
            </div>
        </div>
        <div id="index-brief-description"></div>
        <!-- <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Descripción</span>
                    </div>
                    <textarea id="index-brief-description" rows="5" class="form-control"><?= ($site_settings[10] != ""? $site_settings[10]:"")?></textarea>
                </div>
            </div>
        </div> -->
        <div style="margin-top: 15px;" class="form-row text-right">
            <div class="col"><button id="submit-index-brief-description" class="btn my-button" type="button"><i class="far fa-save"></i>Guardar</button></div>
        </div>
    </form>
</div>