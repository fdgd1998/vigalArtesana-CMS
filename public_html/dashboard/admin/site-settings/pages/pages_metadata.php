<?php
    //error_reporting(0);
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("show_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $pages = array();
    try {
      if ($conn->connect_error) {
          echo "No se ha podido establecer una conexión con la base de datos.";
          exit();
      } else {
          // Fetching categories from database and storing then in the array for further use.
          $sql = "select * from pages";
          if ($res = $conn->query($sql)) {
              while ($rows = $res->fetch_assoc()) {
                array_push($pages, array("id" => $rows["id"], "page" => $rows["page"], "cat_id" => $rows["cat_id"]));
              }
          }
      }
  } catch (Exception $e) {
      echo $e;
  }
?>

<!-- create category modal -->
<div class="modal fade" id="new-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-create">Nueva categoría</h5>
          <button id="close-cat-create" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
            <form id="new-cat-form">
                <div class="form-group">
                    <label for="new-cat-name">Nombre: </label>
                    <input class="form-control" id="new-cat-name" type="text">
                </div>
                <div class="form-group">
                    <label for="new-cat-image">Imagen (máximo 2 MB): </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01"><icon class='fas fa-upload'></icon></span>
                      </div>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="new-cat-image" aria-describedby="inputGroupFileAddon01">
                        <label id="new-cat-image-name" class="custom-file-label" for="new-cat-image" data-browse="Buscar...">Seleccionar imagen...</label>
                      </div>
                    </div>
                </div>
                <div class="form-group" hidden id="new-cat-image-preview-div">
                    <label for="new-cat-image-preview" style="width: 100%;">Vista previa: </label>
                    <center><img id="new-cat-image-preview" src="#" alt="" width="50%"></center>
                </div>
                <div class="form-group">
                    <label for="new-cat-desc">Descripción: </label>
                    <textarea class="form-control" id="new-cat-desc" rows="8"></textarea>
                </div>
            </form>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-create" type="button" class="btn my-button-2" data-dismiss="modal">Cancelar</button>
          <button id="cat-create" type="button" disabled class="btn my-button">Crear</button>
        </div>
      </div>
    </div>
  </div>

<div class="container settings-container">
    <h1 class="title">Título y descripción de las páginas</h1>
    <p>En esta página se pueden configurar los títulos y descripciones de las páginas del sitio. Selecciona uno de los enlaces para cambiar los metadatos de las páginas.</p>
  <div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
    <ul style="list-style-type:disc; margin-left: 30px;">
      <?php foreach ($pages as $page): ?>
        <li>
          <a id="pageid-<?=$page["id"]?>" href=""><?=$page["page"]?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>