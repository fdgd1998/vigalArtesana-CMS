<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../403.php");
        exit();
    }
    require_once "../scripts/connection.php";
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    if ($conn->connect_error) {
        echo "No se ha podido conectar a la base de datos.";
        exit();
    } else {
        $stmt = "select value_info from company_info where key_info='social_media'";
        if ($res = $conn->query($stmt)) {
        $row = $res->fetch_assoc();
            $GLOBALS["social_media"] = $row["value_info"];
        }
    }
    $GLOBALS["social_media"] = json_decode($GLOBALS["social_media"], true);
    $conn->close();
?>
<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom: -15px;">
            <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Configuración de la empresa</h1>
        </div>
    </div>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Redes sociales</h1>
                <p>Si configuras redes sociales, los enlaces aparecerán en la cabecera del sitio web.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="instagram_chkbx" type="checkbox" <?=isset($GLOBALS["social_media"]["instagram"])? "checked" : ""?>>
                <label>Instagram</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">instagram.com/</span>
                    </div>
                    <input type="text" id="instagram_url" <?=isset($GLOBALS["social_media"]["instagram"])? "value='".$GLOBALS["social_media"]["instagram"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="facebook_chkbx" type="checkbox" <?=isset($GLOBALS["social_media"]["facebook"])? "checked" : ""?>>
                <label>Facebook</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">facebook.com/</span>
                    </div>
                    <input type="text" id="facebook_url" <?=isset($GLOBALS["social_media"]["facebook"])? "value='".$GLOBALS["social_media"]["facebook"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <input class="social" id="whatsapp_chkbx" type="checkbox" <?=isset($GLOBALS["social_media"]["whatsapp"])? "checked" : ""?>>
                <label>WhatsApp</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">wa.me/</span>
                    </div>
                    <input type="text" id="whatsapp_url" <?=isset($GLOBALS["social_media"]["whatsapp"])? "value='".$GLOBALS["social_media"]["whatsapp"]."'" : "disabled"?> class="form-control" placeholder="teléfono con prefijo" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right"><button id="submit_social" class="btn btn-success" type="button">Guardar</button></div>
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
    <form style="margin-bottom: 50px;">
        <div class="form-row">
            <div class="col">
                <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Cambiar email</h1>
                <div class="alert alert-warning" role="alert"><span><strong>Tu nuevo email se actualizará una vez lo hayas confirmado.</strong><br></span></div>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 15px;">
            <div class="col"><label>Nuevo email:</label><input class="form-control" type="password"></div>
            <div class="col"><label>Cambiar nuevo email:</label><input class="form-control" type="password"></div>
        </div>
        <div class="form-row">
            <div class="col text-right"><button class="btn btn-success" type="button">Cambiar email</button></div>
        </div>
    </form>
</div>