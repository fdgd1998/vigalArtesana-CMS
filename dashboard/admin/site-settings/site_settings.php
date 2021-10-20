<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../403.php");
        exit();
    }
    require_once "../scripts/connection.php";
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    $site_settings = array();
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
    $conn->close();
?>
<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom: -15px;">
            <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Configuración del sitio</h1>
        </div>
    </div>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Imagen de portada</h1>
                <p>Establece una imagen de portada que se verá en la página principal.</p>
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
                        <input type="file" class="custom-file-input" id="upload-index-image" accept="image/*" aria-describedby="inputGroupFileAddon01">
                        <label id="upload-index-name" class="custom-file-label" for="upload-files" data-browse="Buscar...">Seleccionar fichero...</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
            <div id="index-image-preview" class="text-center"></div>
        </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit-index-image" disabled class="btn btn-success" type="button">Guardar</button></div>
        </div>
    </form>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Descripción de la imagen de portada</h1>
                <p>Establece una descripción que se mostrará sobre la imagen de la portada configurada en la opción de arriba.</p>
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
            <div class="col"><button id="submit-index-image-description" class="btn btn-success" type="button">Guardar</button></div>
        </div>
    </form>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Redes sociales</h1>
                <p>Si configuras redes sociales, los enlaces aparecerán en la cabecera del sitio web.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="instagram_chkbx" type="checkbox" <?=isset($site_settings[4]["instagram"])? "checked" : ""?>>
                <label>Instagram</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">instagram.com/</span>
                    </div>
                    <input type="text" id="instagram_url" <?=isset($site_settings[4]["instagram"])? "value='".$site_settings[4]["instagram"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="facebook_chkbx" type="checkbox" <?=isset($site_settings[4]["facebook"])? "checked" : ""?>>
                <label>Facebook</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">facebook.com/</span>
                    </div>
                    <input type="text" id="facebook_url" <?=isset($site_settings[4]["facebook"])? "value='".$site_settings[4]["facebook"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="whatsapp_chkbx" type="checkbox" <?=isset($site_settings[4]["whatsapp"])? "checked" : ""?>>
                <label>WhatsApp</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">wa.me/</span>
                    </div>
                    <input type="text" id="whatsapp_url" <?=isset($site_settings[4]["whatsapp"])? "value='".$site_settings[4]["whatsapp"]."'" : "disabled"?> class="form-control" placeholder="teléfono con prefijo" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit_social" class="btn btn-success" type="button">Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Servicios</h1>
                <p>En esta sección, define los servicios que ofreces. Aparecerán en la página principal del sitio web.</p>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 15px;">
            <div class="col"><label>Contraseña actual:</label><input class="form-control" type="password" style="margin-bottom: 15px;"></div>
            <div class="col"></div>
        </div>
        <div class="form-row" style="margin-bottom: 15px;">
            <div class="col"><label>Nueva contraseña:</label><input class="form-control" type="password"></div>
            <div class="col"><label>Confirma contraseña:</label><input class="form-control" type="password"></div>
        </div>
        <div class="form-row">
            <div class="col text-right"><button class="btn btn-success" type="button">Cambiar contraseña</button></div>
        </div>
    </form>
    <hr>
</div>