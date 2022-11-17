<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/users/get_user_roles.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $roles = getUserRoles();
    $userdata = array();
    $editUser = strcmp($_GET["page"], "edit-user") == 0 ? true : false;

    if (strcmp($_GET["page"], "edit-user") == 0) {
        $sql = "select users.id, username, email, role, account_type from users inner join user_roles on users.account_type = user_roles.id where users.id = ".$_GET["id"];
    
        if ($res = $conn->query($sql)) {
            foreach ($res[0] as $key => $value) {
                $userdata[$key] = $value;
            }
        }

        echo "<script>var userid = ".$userdata["id"]."</script>";
    }
?>

<div class="container settings-container">
    <h1 class="title"><?=$editUser ? "Editar usuario" : "Nuevo usuario"?></h1>
    <h3 class="title">Información de la cuenta</h3>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Nombre de usuario:</label>
            <input id="username" type="text" class="form-control" <?=$editUser ? "value='".$userdata["username"]."' disabled" : ""?>/>
            <div id="username-feedback" class="invalid-feedback">
                El usuario ya existe.
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Tipo de cuenta:</label>
            <select class="custom-select mr-sm-2" id="role">
                <?php foreach ($roles as $role): ?>
                <option value="<?=$role["id"]?>"<?=$editUser ? ($role["id"] == $userdata["account_type"] ? "selected" : "") : ""?>><?=$role["role"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mt-3">
            <label for="basic-url">Correo electrónico:</label>
            <input id="email" type="email" class="form-control" <?=$editUser ? "value='".$userdata["email"]."' disabled" : ""?>/>
            <div id="email-feedback" class="invalid-feedback">
                El campo no puede estar vacío.
            </div>
        </div>
    </div>
    <h3 class="title">Establecer contraseña</h3>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 mb-3">
            <div class="alert alert-warning" role="alert">
                Copia la contraseña generada en un lugar seguro. Tras salir de esta página, no podrás volver a verla. También se enviará al usuario un email con las nuevas credenciales.
            </div>
            <label for="basic-url">Nueva contraseña:</label>
            <input disabled type="text" class="form-control" id="password">
            <div class="button-group" style="margin-top: 20px">
                <button id="generate" class="btn my-button"><i class="i-margin fas fa-key"></i>Generar contraseña</button>
                <?php if ($editUser): ?>
                <button disabled id="edit-pass" class="btn my-button-3 ml-2"><i class="i-margin fas fa-save"></i>Cambiar contraseña</button>
                <?php endif; ?>
            </div> 
        </div>
    </div>
    
    <div class="button-group text-right" style="margin-top: 20px">
        <button id="cancel-create-user" class="btn my-button-2"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
        <?php if (!$editUser): ?>
        <button disabled id="create-user" class="btn my-button-3"><i class="i-margin fas fa-user-plus"></i>Crear usuario</button>
        <?php endif; ?> 
    </div>
</div>
    
