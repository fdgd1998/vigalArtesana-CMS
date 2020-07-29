<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/modules/connection.php";
    
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $categories = array();

    if ($conn->connect_error) {
        echo "Error interno del servidor. No se ha posido establecer una conexión con la base de datos.";
        exit();
    } else {
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
    <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Crear entrada</h1>
    <form style="margin-top: 30px;">
        <div class="form-row" style="margin-bottom: 20px;">
            <div class="col" style="margin-right: 10px;">
                <div class="form-group">
                    <label>Título:</label>
                    </div>
                        <input id="title" class="form-control" type="text" style="margin-top: -15px;">
                    </div>
    <div class="col">
        <div class="form-group">
            <label>Categoría:</label>
        </div>
            <select id="category" class="form-control" style="margin-top: -15px;">
                <?php
                    foreach($categories as $id => $name) {
                        echo "<option value=".$id.">".$name."</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-row" style="margin-bottom: 20px;">
        <div class="col" style="margin-right: 10px;">
            <div class="form-rows">
                <label>Seleccionar ficheros (máximo 10).</label>
            </div>
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
    </div>
    <div class="form-row">
        <div class="col" style="margin-right: 10px;">
            <div class="form-group">
                <label>Contenido:</label>
                </div>
                    <textarea maxlength="450" id="post-content" class="form-control" style="height: 140px;"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col text-right" style="margin-top: 30px;">
                    <button id="post-cancel" class="btn btn-danger" type="button" style="margin-right: 10px;">Cancelar</button>
                    <button id="post-create" class="btn btn-success" type="button" disabled>Crear</button>
                <div class="btn-group" role="group"></div>
            </div>
        </div>
    </form>
</div>