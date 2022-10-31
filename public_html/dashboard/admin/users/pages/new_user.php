<?php
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $roles = array();

    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        $roles = array(); // Array to save categories
    
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $sql = "select id, role from user_roles";
            if ($res = $conn->query($sql)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($roles, array("id" => $rows["id"], "role" => $rows["role"]));
                }
                $res->free();
            }
            $conn->close();
        }
    } catch (Exception $e) {
        $conn->close();
        echo $e;
    }

?>

<div class="container settings-container">
    <h1 class="title">Nuevo usuario</h1>
    <h3 class="title">Información de la cuenta</h3>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Nombre de usuario:</label>
            <input id="username" type="text" class="form-control">
            <div id="username-feedback" class="invalid-feedback">
                El usuario ya existe.
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Tipo de cuenta:</label>
            <select class="custom-select mr-sm-2" id="role">
                <?php foreach ($roles as $roles):?>
                <option value="<?=$roles["id"]?>"><?=$roles["role"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Correo electrónico:</label>
            <input id="email" type="email" class="form-control">
            <div id="email-feedback" class="invalid-feedback">
                El campo no puede estar vacío.
            </div>
        </div>
    </div>
    <h3 class="title">Establecer contraseña</h3>
    <p>Requisitos de complejidad:</p>
    <ul style="list-style-type: disc; margin-left: 30px;">
        <li>Longitud mínima de 8 caracteres.</li>
        <li>Letras minúsculas (<strong>a-z</strong>).</li>
        <li>Letras mayúsculas (<strong>A-Z</strong>).</li>
        <li>Dígitos del <strong>0 al 9</strong></li>
        <li>Caracteres especiales (<strong>!, @, #, $, %, ^, &, (, ), \, -, _, +, .</strong>).</li>
    </ul>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Nueva contraseña:</label>
            <input type="password" class="form-control" id="new-password-1">
 
        </div>
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Confirmar nueva contraseña:</label>
            <input type="password" class="form-control" id="new-password-2">
            <div id="pass-feedback-2" class="invalid-feedback">
                Las contraseñas no coinciden.
            </div>
        </div>
    </div>
    <div class="button-group text-right" style="margin-top: 20px">
        <button id="cancel-create-user" class="btn my-button-2"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
        <button disabled id="create-user" class="btn my-button-3"><i class="i-margin fas fa-user-plus"></i>Crear usuario</button>
    </div> 
</div>
    
