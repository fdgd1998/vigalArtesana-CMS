<?php
    require_once '../modules/connection.php';

    if (!isset($_SESSION['user'])) {
      header("Location: ../../../403.php");
    }

    if (isset($_GET['order'])) $order = $_GET['order'];
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
?>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="admin/posts/js/ajax.js"></script>
<script src="admin/posts/js/input_actions.js"></script>


<!-- create cat modal -->
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
                    <label for="new-cat-image">Imagen de fondo: </label>
                    <input id="new-cat-image" name="new-cat-image" type="file" accept="image/*" width="100%">
                </div>
                <div class="form-group" hidden id="new-cat-image-preview-div">
                    <label for="new-cat-image-preview">Vista previa: </label>
                    <img id="new-cat-image-preview" src="#" alt="" width="100%">
                </div>
            </form>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-create" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="cat-create" type="button" disabled class="btn btn-success">Crear</button>
        </div>
      </div>
    </div>
  </div>

<!-- Delete cat modal -->
<div class="modal fade" id="delete-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-delete">Editando categoría ...</h5>
          <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas eliminar esta categoría? Si hay elementos pertenecientes a esta categoría, tendrás que cambiarla manualmente después.</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-delete" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="cat-delete" type="button" class="btn btn-success">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Editing cat modal -->
  <div class="modal fade" id="edit-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-edit">Editando categoría ...</h5>
          <button id="close-cat-edit" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body"> 
            <div id='category-name' class="form-group"></div>
            <div class="form-group" hidden id="update-cat-image-preview-div">
                <label for="update-cat-image-preview">Imagen de fondo actual: </label>
                <img id="update-cat-image-preview" src="#" alt="" width="100%">
            </div>
            <div>
                <label>Nueva imagen de fondo: </label>
                <input id="update-cat-image" type="file" accept="image/*">
            </div>
            <div style="margin-top: 15px;" class="form-group" hidden id="update-new-cat-image-preview-div">
                <label for="update-new-cat-image-preview">Vista previa de nueva imagen: </label>
                <img id="update-new-cat-image-preview" src="#" alt="" width="100%">
            </div>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-edit" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="cat-edit" type="button" class="btn btn-success">Crear</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Enabling/disabling category modal -->
  <div class="modal fade" id="cat-status-change" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-statuschange">Editando categoría ...</h5>
          <button id="close-statuschange-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p id="statuschange_modal_info_text"></p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-statuschange" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="cat-statuschange" type="button" class="btn btn-success">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
<div class="container">
<button type="button" id="create-cat" class="btn btn-info" style="margin-bottom: 10px;">Crear categoría</button>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($conn->connect_error) {
                        print("No se ha podido conectar a la base de datos");
                        exit();
                    } else {
                        $sql = "select * from categories";
                        $res = $conn->query($sql);
                        if ($res->num_rows == 0) {
                        echo '<p>No hay coincidencias.</p>';
                        } 
                        else {
                            while ($rows = $res->fetch_assoc()) {
                                $status_arrow_icon = $rows['cat_enabled'] == 'YES' ? 'down':'up' ;
                                $cat_status = $rows['cat_enabled'] == 'YES' ? 'Deshabilitar':'Habilitar' ;
                                echo '<tr>';
                                echo '<td>'.$rows['name'].'</td>';
                                echo '<td id="catid-'.$rows['id'].'_cat_status">'.$cat_status = $rows['cat_enabled'] == 'YES' ? 'Habilitada':'Deshabilitada'.'</td>';
                                echo '
                                    <td>
                                        <div>
                                            <button class="btn btn-success cat-edit-form" title="Editar categoría" type="button" style="margin-right: 1px;" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger cat-delete" title="Borrar categoría" type="button" style="margin-right: 1px;" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-dark cat-status-change-form" title="'.$cat_status.' categoría" type="button" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i id="catid-'.$rows['id'].'-change-status-btn" class="fas fa-arrow-circle-'.$status_arrow_icon.'"></i>
                                            </button>
                                        </div>
                                    </td>';
                                echo '</tr>';
                                }                   
                            }
                        }     
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>