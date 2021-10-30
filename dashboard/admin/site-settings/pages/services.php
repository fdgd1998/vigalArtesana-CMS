<?php
    session_start(); // starting the session.
    require_once '../scripts/connection.php';

    // Redirecting to 403 page if user is not logged in and access is attemped.
    if (!isset($_SESSION['user'])) {
      header("Location: ../../../../403.php");
      exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
?>

<!-- Delete category modal -->
<div class="modal fade" id="delete-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel-delete" >Editando categoría ...</h5>
        <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body" class="modal-body">
        <p>¿Estás seguro de que deseas eliminar esta categoría? No podrás borrarla si hay imágenes que pertenecen a ella.</p>
      </div>
      <div id="modal-footer1" class="modal-footer">
        <button id="cancel-cat-delete" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="cat-delete" type="button" class="btn my-button">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<div class="container settings-container">
    <h1 class="title">Servicios</h1>
    <p class="title-description">Añade en esta sección los servicios que ofreces a tus clientes. Puedes añadir hasta un máximo de 10.</p>
    <div class="button-group">
      <button type="button" id="new-service" onclick="window.location.href='?page=new-service'" class="btn my-button" style="margin-bottom: 15px;"><i class="far fa-plus-square"></i>Nuevo servicio</button>
    </div>
    <p class="title-description">Para editar un servicio, ve a la página principal y edítalo desde allí.</p>
    <div class="button-group">
      <button type="button" id="new-service" onclick="window.location.href='../'" class="btn my-button" style="margin-bottom: 15px;"><i class="fas fa-home"></i>Ir a la página principal</button>
    </div>
</div>