<?php
    //error_reporting(0);
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    $userdata = array();
    $sql = "select username, email, role from users inner join user_roles on users.account_type = user_roles.id where users.id = ".$_SESSION["userid"];


    if ($res = $conn->query($sql)) {
        $rows = $res->fetch_assoc();
        foreach($rows as $key => $value) {
            $userdata[$key] = $value;
        }
    }
?>

<div class="container settings-container">
    <h1 class="title">Perfil de usuario</h1>
    <h3 class="title">Información de la cuenta</h3>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Nombre de usuario:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["username"]?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Tipo de cuenta:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["role"]?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Correo electrónico:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["email"]?>">
            </div>
        </div>
    </div>
    <h3 class="title">Cambiar contraseña</h3>
    <p>Requisitos de complejidad:</p>
    <ul style="list-style-type: disc; margin-left: 30px;">
        <li>Longitud mínima de 8 caracteres.</li>
        <li>Letras minúsculas (<strong>a-z</strong>).</li>
        <li>Letras mayúsculas (<strong>A-Z</strong>).</li>
        <li>Dígitos del <strong>0 al 9</strong></li>
        <li>Caracteres especiales (<strong>!, @, #, $, %, ^, &, (, ), \, -, _, +, .</strong>).</li>
    </ul>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mb-3">
            <label for="basic-url">Contraseña actual:</label>
            <input type="password" class="form-control" id="current-password">
            <div id="current-pass-feedback" class="invalid-feedback">
                El campo no puede estar vacío.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mb-3">
            <label for="basic-url">Nueva contraseña:</label>
            <input type="password" class="form-control" id="new-password-1">
 
        </div>
        <div class="col-12 col-sm-12 col-md-6 mb-3">
            <label for="basic-url">Confirmar nueva contraseña:</label>
            <input type="password" class="form-control" id="new-password-2">
            <div id="pass-feedback-2" class="invalid-feedback">
                Las contraseñas no coinciden.
            </div>
        </div>
    </div>
    <div class="button-group text-right" style="margin-top: 20px">
        <button disabled id="change-password" class="btn my-button"><i class="i-margin fas fa-key"></i>Cambiar contraseña</button>
    </div> 
</div>
    
