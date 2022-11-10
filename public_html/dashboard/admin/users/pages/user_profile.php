<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/users/get_user_roles.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $userdata = array();
    $editUser = ($_GET["page"] == "edit-user" && isset($_GET["id"]))? $_GET["id"] : false;
    $roles = getUserRoles();

    $sql = "select username, email, role from users inner join user_roles on users.account_type = user_roles.id where users.id = ".$_GET["id"];

    if ($res = $conn->query($sql)) {
        foreach ($res[0] as $key => $value) {
            $userdata[$key] = $value;
        }
    }
        

    function getRanddomPass() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&()\-_+,.';
        $randomString = '';
    
        for ($i = 0; $i <= 12; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
    
        return $randomString;
    }
?>

<div class="container settings-container">
    <h1 class="title"><?php if($editUser) {echo "Editar usuario";} else {echo "Perfil de usuario";}?></h1>
    <h3 class="title">Información de la cuenta</h3>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Nombre de usuario:</label>
            <div class="input-group mb-3">
                <input type="text" id="username" disabled class="form-control" value="<?=$userdata["username"]?>">
            </div>
        </div>
        <?php if (!$editUser): ?>
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Tipo de cuenta:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["role"]?>">
            </div>
        </div>
        <?php else: ?>
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Tipo de cuenta:</label>
            <select class="custom-select mr-sm-2" id="role">
                <?php foreach ($roles as $role):?>
                    <?php echo $role["role"] == $userdata["role"]."<br>"?>
                <option <?=strcmp($role["role"], $userdata["role"]) == 0?"selected":""?> value="<?=$role["id"]?>"><?=$role["role"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <label for="basic-url">Correo electrónico:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["email"]?>">
            </div>
        </div>
    </div>
    <h3 class="title">Contraseña</h3>
    <p>Requisitos de complejidad:</p>
    <ul style="list-style-type: disc; margin-left: 30px;">
        <li>Longitud mínima de 8 caracteres.</li>
        <li>Letras minúsculas (<strong>a-z</strong>).</li>
        <li>Letras mayúsculas (<strong>A-Z</strong>).</li>
        <li>Dígitos del <strong>0 al 9</strong></li>
        <li>Caracteres especiales (<strong>!, @, #, $, %, ^, &, (, ), \, -, _, +, .</strong>).</li>
    </ul>
    
    <?php if (!$editUser): ?>
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
    <?php else: ?>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mb-3">
            <label for="basic-url">Nueva contraseña:</label>
            <input disabled type="text" class="form-control" id="new-password">
            <div class="button-group" style="margin-top: 20px">
                <button id="generate" class="btn my-button"><i class="i-margin fas fa-key"></i>Generar contraseña</button>
                <button disabled id="edit-pass" class="btn my-button-3 ml-2"><i class="i-margin fas fa-save"></i>Guardar</button>
            </div> 
        </div>
    </div>
    <?php endif; ?>
</div>
    
