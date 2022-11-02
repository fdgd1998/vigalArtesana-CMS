<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    $site_settings[4]["value_info"] = json_decode($site_settings[4]["value_info"], true);
    $site_settings[8]["value_info"] = json_decode($site_settings[8]["value_info"], true);
?>
<div class="container settings-container">
    <h1 class="title">Contacto y ubicación</h1>
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
                    <input type="text" id="email" <?=$site_settings[3]["value_info"]? "value='".$site_settings[3]["value_info"]."'" : ""?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
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
                    <input type="text" id="phone" <?=$site_settings[0]["value_info"]? "value='".$site_settings[0]["value_info"]."'" : ""?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col"><button id="submit_contact_data" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button></div>
        </div>
    </form>
    <hr>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="far fa-comment-alt"></i>Redes sociales</h3>
                <p class="title-description">Si configuras redes sociales, los enlaces aparecerán en la barra de navegación y en la página de contacto.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="instagram_chkbx" type="checkbox" <?=isset($site_settings[4]["value_info"]["instagram"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">instagram.com/</span>
                    </div>
                    <input type="text" id="instagram_url" <?=isset($site_settings[4]["value_info"]["instagram"])? "value='".$site_settings[4]["value_info"]["instagram"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="facebook_chkbx" type="checkbox" <?=isset($site_settings[4]["value_info"]["facebook"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">facebook.com/</span>
                    </div>
                    <input type="text" id="facebook_url" <?=isset($site_settings[4]["value_info"]["facebook"])? "value='".$site_settings[4]["value_info"]["facebook"]."'" : "disabled"?> class="form-control" placeholder="perfil" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input class="social" id="whatsapp_chkbx" type="checkbox" <?=isset($site_settings[4]["value_info"]["whatsapp"])? "checked" : ""?>>
                        </div>
                        <span class="input-group-text" id="basic-addon1">wa.me/</span>
                    </div>
                    <input type="text" id="whatsapp_url" <?=isset($site_settings[4]["value_info"]["whatsapp"])? "value='".$site_settings[4]["value_info"]["whatsapp"]."'" : "disabled"?> class="form-control" placeholder="teléfono con prefijo" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col">
                <button id="submit_social" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button>
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
                <textarea id="map-link" class="form-control" rows="3" style="margin-bottom: 15px;"><?=$site_settings[7]["value_info"]?></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right"><button id="submit_map_link" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button></div>
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
                            <input type="checkbox" id="chkbx-Lunes" class="week" <?=isset($site_settings[8]["value_info"]["Lunes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Lunes</span>
                    </div>
                    <input type="text" id="Lunes" class="form-control" <?=isset($site_settings[8]["value_info"]["Lunes"])? "value='".$site_settings[8]["value_info"]["Lunes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Martes" class="week" <?=isset($site_settings[8]["value_info"]["Martes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Martes</span>
                    </div>
                    <input type="text" id="Martes" class="form-control" <?=isset($site_settings[8]["value_info"]["Martes"])? "value='".$site_settings[8]["value_info"]["Martes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Miércoles" class="week" <?=isset($site_settings[8]["value_info"]["Miércoles"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Miércoles</span>
                    </div>
                    <input type="text" id="Miércoles" class="form-control" <?=isset($site_settings[8]["value_info"]["Miércoles"])? "value='".$site_settings[8]["value_info"]["Miércoles"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Jueves" class="week" <?=isset($site_settings[8]["value_info"]["Jueves"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Jueves</span>
                    </div>
                    <input type="text" id="Jueves" class="form-control" <?=isset($site_settings[8]["value_info"]["Jueves"])? "value='".$site_settings[8]["value_info"]["Jueves"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Viernes" class="week" <?=isset($site_settings[8]["value_info"]["Viernes"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Viernes</span>
                    </div>
                    <input type="text" id="Viernes" class="form-control" <?=isset($site_settings[8]["value_info"]["Viernes"])? "value='".$site_settings[8]["value_info"]["Viernes"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Sábado" class="week" <?=isset($site_settings[8]["value_info"]["Sábado"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Sábado</span>
                    </div>
                    <input type="text" id="Sábado" class="form-control" <?=isset($site_settings[8]["value_info"]["Sábado"])? "value='".$site_settings[8]["value_info"]["Sábado"]."'":"disabled"?>>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="chkbx-Domingo" class="week" <?=isset($site_settings[8]["value_info"]["Domingo"])? "checked":""?>>
                        </div>
                        <span class="input-group-text">Domingo</span>
                    </div>
                    <input type="text" id="Domingo" class="form-control" <?=isset($site_settings[8]["value_info"]["Domingo"])? "value='".$site_settings[8]["value_info"]["Domingo"]."'":"disabled"?>>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right">
                <button id="submit_opening_hours" class="btn my-button-3" type="button"><i class=" i-margin fas fa-save"></i>Guardar</button>
            </div>
        </div>
    </form>
    <hr>
</div>