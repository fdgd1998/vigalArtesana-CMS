<?php

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
<div class="modal fade" id="page-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="page-edit-title"></h5>
          <button id="page-edit-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
            <form id="new-cat-form">
                <div class="form-group">
                    <label for="page-title">Título: </label>
                    <input class="form-control" id="page-title" type="text">
                </div>
                <div class="form-group">
                    <label for="page-desc">Descripción: </label>
                    <textarea class="form-control" id="page-desc" rows="8"></textarea>
                </div>
            </form>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-page-edit" type="button" class="btn my-button-2" data-dismiss="modal"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
          <button id="page-edit-btn" type="button" disabled class="btn my-button-3"><i class="i-margin fas fa-edit"></i>Guardar</button>
        </div>
      </div>
    </div>
  </div>

<div class="container settings-container">
    <h1 class="title">Título y descripción de las páginas (metadatos) </h1>
    <p>En esta página se pueden configurar los títulos y descripciones de las páginas del sitio web. Estos datos se usarán para funciones de SEO.</p>
    <p>Selecciona uno de los enlaces para cambiar los metadatos de las páginas.</p>
  <div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
    <ul style="list-style-type:disc; margin-left: 30px;">
      <?php foreach ($pages as $page): ?>
        <li>
          <a class="metadata-edit" id="pageid-<?=$page["id"]?>" href="#"><?=$page["page"]?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>