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
        <div class="col">
            <label for="basic-url">Nombre de usuario:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["username"]?>">
            </div>
        </div>
        <div class="col">
            <label for="basic-url">Tipo de cuenta:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["role"]?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="basic-url">Correo electrónico:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="<?=$userdata["email"]?>">
            </div>
        </div>
    </div>
    <h3 class="title">Cambiar contraseña</h3>
    <div class="row">
        <div class="col">
            <label for="basic-url">Contraseña actual:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" id="basic-url" aria-describedby="basic-addon3">
            </div>
        </div>
        <div class="col">
            <label for="basic-url">Nueva contraseña:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" id="basic-url" aria-describedby="basic-addon3">
            </div>
            <label for="basic-url">Confirma nueva contraseña:</label>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" id="basic-url" aria-describedby="basic-addon3">
            </div>
        </div>
    </div>
</div>
    
