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
    $site_settings[8] = json_decode($site_settings[8], true);
    $conn->close();
?>
<div class="container settings-container">
    <h2 class="title">Opciones de contacto y ubicación</h2>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-envelope"></i>Email y teléfono</h3>
                <p class="title-description">Actualiza el email y el teléfono de contacto.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <input type="text" id="email" <?=$site_settings[3]? "value='".$site_settings[3]."'" : ""?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <input type="text" id="phone" <?=$site_settings[0]? "value='".$site_settings[0]."'" : ""?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit_contact_data" class="btn my-button" type="button">Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-comment-alt"></i>Redes sociales</h3>
                <p class="title-description">Si configuras redes sociales, los enlaces aparecerán en la cabecera del sitio web.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="instagram_chkbx" type="checkbox" <?=isset($site_settings[4]["instagram"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">instagram.com/</span>
                    </div>
                    <input type="text" id="instagram_url" <?=isset($site_settings[4]["instagram"])? "value='".$site_settings[4]["instagram"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="facebook_chkbx" type="checkbox" <?=isset($site_settings[4]["facebook"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">facebook.com/</span>
                    </div>
                    <input type="text" id="facebook_url" <?=isset($site_settings[4]["facebook"])? "value='".$site_settings[4]["facebook"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="whatsapp_chkbx" type="checkbox" <?=isset($site_settings[4]["whatsapp"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">wa.me/</span>
                    </div>
                    <input type="text" id="whatsapp_url" <?=isset($site_settings[4]["whatsapp"])? "value='".$site_settings[4]["whatsapp"]."'" : "disabled"?> class="form-control" placeholder="teléfono con prefijo" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col">
                <button id="submit_social" class="btn my-button" type="button">Guardar</button>
            </div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-map"></i>Google Maps</h3>
                <p class="title-description">En la página de contacto se muestra un mapa con la ubicación que especifiques. Copia aquí abajo el enlace proporcionado por Google Maps del elemento <strong>iframe</strong>.</p>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 15px;">
            <div class="col">
                <label>Enlace:</label>
                <textarea id="map-link" class="form-control" rows="3" style="margin-bottom: 15px;"><?=$site_settings[7]?></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right"><button id="submit_map_link" class="btn my-button" type="button">Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-calendar-alt"></i>Horario</h3>
                <p class="title-description">Establece un horario por cada día de la semana. Formato recomendado: <strong>hh:mm - hh:mm | hh:mm - hh:mm</strong>.</p>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 15px;">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Lunes" class="week" <?=isset($site_settings[8]["Lunes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Lunes</span>
                    </div>
                    <input type="text" id="Lunes" class="form-control" <?=isset($site_settings[8]["Lunes"])? "value='".$site_settings[8]["Lunes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Martes" class="week" <?=isset($site_settings[8]["Martes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Martes</span>
                    </div>
                    <input type="text" id="Martes" class="form-control" <?=isset($site_settings[8]["Martes"])? "value='".$site_settings[8]["Martes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Miércoles" class="week" <?=isset($site_settings[8]["Miércoles"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Miércoles</span>
                    </div>
                    <input type="text" id="Miércoles" class="form-control" <?=isset($site_settings[8]["Miércoles"])? "value='".$site_settings[8]["Miércoles"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Jueves" class="week" <?=isset($site_settings[8]["Jueves"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Jueves</span>
                    </div>
                    <input type="text" id="Jueves" class="form-control" <?=isset($site_settings[8]["Jueves"])? "value='".$site_settings[8]["Jueves"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Viernes" class="week" <?=isset($site_settings[8]["Viernes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Viernes</span>
                    </div>
                    <input type="text" id="Viernes" class="form-control" <?=isset($site_settings[8]["Viernes"])? "value='".$site_settings[8]["Viernes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Sábado" class="week" <?=isset($site_settings[8]["Sábado"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Sábado</span>
                    </div>
                    <input type="text" id="Sábado" class="form-control" <?=isset($site_settings[8]["Sábado"])? "value='".$site_settings[8]["Sábado"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Domingo" class="week" <?=isset($site_settings[8]["Domingo"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Domingo</span>
                    </div>
                    <input type="text" id="Domingo" class="form-control" <?=isset($site_settings[8]["Domingo"])? "value='".$site_settings[8]["Domingo"]."'":"disabled"?>>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right">
                <button id="submit_opening_hours" class="btn my-button" type="button">Guardar</button>
            </div>
        </div>
    </form>
    <hr>
</div>