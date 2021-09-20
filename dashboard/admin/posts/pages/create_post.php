<?php
    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/connection.php"; // Database connection info.
    
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

    // If the action to perform is to edit a post, current post data is retrieved form database and showed up in the page.
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $edit = true;
        $sql = "select posts.id, categories.name, posts.title, posts.content, posts.images from posts inner join categories on categories.id = posts.category where posts.id = ".$_GET['id'];
        
        if ($res = $conn->query($sql)) {
            if ($res->num_rows == 1) {
                $row = $res->fetch_assoc();
                $category = $row['name'];
                $title = $row['title'];
                $content = $row['content'];
                $images = explode(",", $row['images']);
            }
        }
    }

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

<script src="/dashboard/admin/posts/js/create_post.js"></script>
<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom: -15px;">
            <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;"><?=$edit ? "Editar post":"Crear post"?></h1>
        </div>
    </div>
    <form style="margin-bottom: 20px;padding-top: 17px;">
        <div class="form-row">
            <div class="col">
                <label>Título: </label>
                <?php if ($edit): ?>
                <input id="title" class="form-control" type="text" style="margin-bottom: 15px;" value="<?=$title?>" />
                <?php else: ?>
                <input id="title" class="form-control" type="text" style="margin-bottom: 15px;" />
                <?php endif; ?>
            </div>
            <div class="col">
                <label>Categoría: </label>
                <select id="category" class="form-control" <?=count($categories) > 0 ? "":"disabled"?>>
                    <?php
                        if (count($categories) > 0) {
                            // Showing existing categories in a dropdown menu.
                            foreach ($categories as $id => $name) {
                                if ($edit && $name == $category) {
                                    echo "<option value=".$id." selected>".$name."</option>";
                                } else {
                                    echo "<option value=".$id.">".$name."</option>";
                                }
                            }
                        } else {
                            echo "<option selected>Sin resultados.</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-top: 10px;">
            <label>Seleccionar ficheros (máximo <?=$edit ? 10-count($images):10?>).</label>
            <script>maxFilesToUpload = <?=$edit?10-count($images):10?></script>
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
        <?php if($edit): ?>
        <div class="form-row" style="margin-top: 10px;">
        <label>Imágenes actuales (si quieres eliminar alguna imagen selecciónalas aquí abajo).</label>
            <div style="width:100%;">
                <?php foreach ($images as $item): ?>
                <div class="image current-image">
                    <input class="remove-image" type="checkbox" id="<?=$item?>">
                    <img src="<?='/uploads/posts/'.$item?>" class="rounded float-left" alt="">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif;?>
        <div id="new-image-container" hidden class="form-row" style="margin-top: 10px;">
        <label>Nuevas mágenes.</label>
            <div id="images-preview" style="width:100%;"></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col">
                <label>Contenido:</label>
                <?php if($edit): ?>
                <textarea id="post-content" class="form-control" style="height: 500px"><?=$content?></textarea>
                <?php else: ?>
                <textarea id="post-content" class="form-control" style="height: 500px"></textarea>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-row text-right" style="margin-top: 20px;">
            <div class="col">
                <button id="post-cancel" class="btn btn-danger" type="button">Cancelar</button>
                <?php if ($edit): ?>
                    <?php echo  "<script>var post_id = ".$_GET['id']."</script>"?>
                    <button id="post-create" class="btn btn-success" type="button" style="margin-left: 5px;">Editar</button>
                <?php else: ?>
                    <button id="post-create" class="btn btn-success" type="button" disabled style="margin-left: 5px;">Crear</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>