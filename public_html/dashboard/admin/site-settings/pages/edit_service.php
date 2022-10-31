<?php

    session_start(); // starting the session.

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php'; 
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $services = array();
    
    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "select * from services where id = ".$_GET["id"];
            if ($res = $conn->query($stmt)) {
                if ($rows = $res->fetch_assoc())
                    $services = array($rows["id"],$rows["title"],$rows["description"],$rows["image"]);
            }
        }
    } catch (Exception $e) {
        echo $e;
    }
    echo "<script>var servId = ".$_GET["id"]."</script>";
?>

</style>
<div class="container settings-container">
    <h1 class="title">Editando servicio</h1>
    <p class="title-description">Selecciona los atributos del servicio que quieres modificar.</p>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-title">
        <label class="custom-control-label" for="edit-title">Editar título</label>
    </div>
    <div id="title-div" class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Título</span>
        </div>
        <input disabled type="text" class="form-control" id="title-input-edit" value="<?=$services[1]?>">
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-description">
        <label class="custom-control-label" for="edit-description">Editar descripción</label>
    </div>
    <div id="description-div" class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Descripción:</span>
        </div>
        <textarea disabled class="form-control" id="description-input-edit"><?=$services[2]?></textarea>
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" id="edit-image">
        <label class="custom-control-label" for="edit-image">Editar imagen</label>
    </div>
    <div id="image-div" class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-upload"></i></span>
        </div>
        <div class="custom-file">
            <input disabled type="file" class="custom-file-input" id="image-input-edit" accept=".png,.jpeg,.jpg">
            <label id="image-input-edit-label" class="custom-file-label" for="image-input-edit" data-browse="Buscar...">Seleccionar imagen...</label>
        </div>
    </div>
    <div class="row text-center mb-4">
        <div class="col-6 col-sm-6 col-md-6">
            <p>Imagen actual:</p>
            <img width="100%" style="object-fit: cover !important;" src="../uploads/services/<?=$services[3]?>"/>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <p>Nueva imagen:</p>
            <img id="service-edit-image-preview" width="100%" style="object-fit: cover !important;" src="../includes/img/placeholder-image.jpg"/>
        </div>
    </div>
    <div class="button-group text-right">
        <button id="cancel-service-edit" class="btn my-button-2">Cancelar</button>
        <button disabled id="submit-service-edit" class="btn my-button-3"><i class="far fa-edit"></i>Editar</button>
    </div>
</div>