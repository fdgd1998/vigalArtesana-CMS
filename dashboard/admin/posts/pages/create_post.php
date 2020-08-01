<?php
    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/modules/connection.php"; // Database connection info.
    
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
        // Fetching categories from database and storing then in the arrat for further use.
        $sql = "select id, name from categories order by name asc";
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                $categories[$rows["id"]] = $rows["name"];
            }
        }
    }
?>
<script src="/dashboard/admin/posts/js/create_post.js"></script>
<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom: -15px;">
            <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Crear post</h1>
        </div>
    </div>
    <form style="margin-bottom: 20px;padding-top: 17px;">
        <div class="form-row">
            <div class="col">
                <label>Título: </label>
                <input id="title" class="form-control" type="text" style="margin-bottom: 15px;" />
            </div>
            <div class="col">
                <label>Categoría: </label>
                <select id="category" class="form-control">
                    <?php
                        // Showing existing categories in a dropdown menu.
                        foreach($categories as $id => $name) {
                            echo "<option value=".$id.">".$name."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-top: 10px;">
            <label>Seleccionar ficheros (máximo 10).</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <icon class='icon-cloud-upload'></icon>
                    </span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="upload-files" accept="image/*" multiple aria-describedby="inputGroupFileAddon01">
                    <label id="upload-files-name" class="custom-file-label" for="upload-files" data-browse="Buscar...">Subir fichero(s)...</label>
                </div>
            </div>
            <div><ul id="file-list" style="list-style-type: none; margin: 0;"></ul></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col">
                <label>Contenido:</label>
                <textarea id="post-content" class="form-control" style="height: 500px"></textarea>
            </div>
        </div>
        <div class="form-row text-right" style="margin-top: 20px;">
            <div class="col">
                <button id="post-cancel" class="btn btn-danger" type="button">Cancelar</button>
                <button id="post-create" class="btn btn-success" type="button" disabled style="margin-left: 5px;">Crear</button>
            </div>
        </div>
    </form>
</div>