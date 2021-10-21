<?php
    session_start(); // Starting the session.
    require_once "../scripts/connection.php"; // Database connection info.
    
    // If a non-logged user access to the current script, is redirected to a 403 page.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $categories = array(); // Array to save categories

    if ($conn->connect_error) {
        echo "Error interno del servidor. No se ha podido establecer una conexión con la base de datos.";
        exit();
    } else {
        // Fetching categories from database and storing then in the array for further use.
        $sql = "select id, name from categories order by name asc";
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                $categories[$rows["id"]] = $rows["name"];
            }
        }
    }

    // Variables for storing data to edit, just in case if needed.
    $edit = false;
    $category = '';
    $title = '';
    $content = '';
    $images = '';

?>
<style>
    img {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    .image {
        display: inline-block;
    }

    .current-image {
        margin-right: -5px;
        margin-left: 5px;
        margin-top: 5px;
        margin-bottom: 5px; 
    }

    .new-image {
        margin: 8px;
    }

    input[type="checkbox"] {
        position: relative;
        left: -20px;
        top: 3px;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom: -15px;">
            <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Subir imágenes</h1>
        </div>
    </div>
    <form style="margin-bottom: 20px;padding-top: 17px;" enctype="multipart/form-data">
        <div class="form-row" style="margin-top: 10px;">
            <label>Seleccionar ficheros (máximo <?=$edit ? 10-count($images):10?>).</label>
            <script>maxFilesToUpload = <?=$edit?10-count($images):10?></script>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-upload"></i>
                    </span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="upload-files" accept="image/*" multiple aria-describedby="inputGroupFileAddon01">
                    <label id="upload-files-name" class="custom-file-label" for="upload-files" data-browse="Buscar...">Seleccionar fichero(s)...</label>
                </div>
            </div>
        </div>
        <div id="images-preview" class="row row-cols-2 row-cols-md-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-top: 10px;">
        </div>
        <div class="form-row text-right" style="margin-top: 20px;">
            <div class="col">
                <button id="cancel" class="btn btn-danger" type="button">Cancelar</button>
                <button id="upload" disabled class="btn btn-success" type="button" style="margin-left: 5px;">Cargar</button>
            </div>
        </div>
    </form>
</div>