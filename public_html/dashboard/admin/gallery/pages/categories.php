<?php
    //error_reporting(0);
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("show_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_GET['order'])) $order = $_GET['order']; // getting order if GET variable is set.
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
?>

<style>
  .disabled-form {
      pointer-events: none;
      opacity: 0.4;
  }
  .custom-checkbox {
    margin-bottom: 10px;
}
</style>


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
            </form>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-create" type="button" class="btn my-button-2" data-dismiss="modal">Cancelar</button>
          <button id="cat-create" type="button" disabled class="btn my-button">Crear</button>
        </div>
      </div>
    </div>
  </div>

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
          <p>¿Estás seguro de que deseas borrar esta categoría? No podrás borrarla si hay imágenes que pertenecen a ella.</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-delete" type="button" class="btn my-button" data-dismiss="modal">Cancelar</button>
          <button id="cat-delete" type="button" class="btn my-button-2"><i class="far fa-trash-alt"></i>Borrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Editing category modal -->
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
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="change-edit-name-chkbx">
          <label class="custom-control-label" for="change-edit-name-chkbx">Editar nombre.</label>
        </div>
        <div id="edit-change-name" class="input-group mb-3 disabled-form">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Nombre</span>
          </div>
          <input type="text" class="form-control" id="update-cat-name" aria-describedby="basic-addon1">
        </div>
        <div class="form-group" hidden id="update-cat-image-preview-div">
            <label for="update-cat-image-preview" style="width: 100%;">Imagen actual: </label>
            <center><img id="update-cat-image-preview" src="#" alt="" width="50%"></center>
        </div>
        <div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="change-edit-image-chkbx">
          <label class="custom-control-label" for="change-edit-image-chkbx">Establecer nueva imagen.</label>
        </div>
          <div id="edit-change-image" class="disabled-form">
            <label>Nueva imagen : </label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-upload'></i></span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="update-new-cat-image" aria-describedby="inputGroupFileAddon01">
                <label id="update-new-cat-image-name" class="custom-file-label" for="update-new-cat-image" data-browse="Buscar...">Seleccionar imagen...</label>
              </div>
            </div>
            <div style="margin-top: 15px;" class="form-group" hidden id="update-new-cat-image-preview-div">
              <label for="update-new-cat-image-preview" style="width: 100%;">Vista previa de nueva imagen: </label>
              <center><img id="update-new-cat-image-preview" src="#" alt="" width="100%" style="width: 50%;"></center>
          </div>
          </div>           
          </div>
          
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-edit" type="button" class="btn my-button-2" data-dismiss="modal">Cancelar</button>
          <button disabled id="cat-edit" type="button" class="btn my-button-3"><i class="far fa-edit"></i>Editar</button>
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
          <button id="cancel-cat-statuschange" type="button" class="btn my-button-2" data-dismiss="modal">Cancelar</button>
          <button id="cat-statuschange" type="button" class="btn my-button">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
<div class="container settings-container">
    <h1 class="title">Categorías</h1>
    <button type="button" id="create-cat" class="btn my-button" style="margin-bottom: 15px;"><i class="far fa-plus-square" style="padding-right:5px;"></i>Crear categoría</button>

<div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
      <select id="result-order" class="form-control">
        <option value="asc" <?=isset($order)?($order=='asc'?'selected':''):''?>>Ascendente</option>
        <option value="desc" <?=isset($order)?($order=='desc'?'selected':''):''?>>Descendente</option>
        <option value="enabled" <?=isset($order)?($order=='enabled'?'selected':''):''?>>Habilitado</option>
        <option value="disabled" <?=isset($order)?($order=='disabled'?'selected':''):''?>>Deshabilitado</option>
      </select>
    </div>
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
                        // Fetching categories from databases and sorting them.
                        $sql = "select * from categories ";
                        if (isset($_GET['order'])) {
                          switch($_GET['order']) {
                            case 'asc':
                              $sql .= " order by name asc";
                              break;
                            case 'desc':
                              $sql .= " order by name desc";
                              break;
                            case 'enabled':
                              $sql .= " where cat_enabled = 'YES' order by name asc";
                              break;
                            case 'disabled':
                              $sql .= " where cat_enabled = 'NO' order by name asc";
                              break;
                            default:
                              $sql .= " order by name asc";
                          } 
                        } else {
                          $sql .= " order by name asc";
                        }
                        $res = $conn->query($sql);
                        if ($res->num_rows == 0) {
                          echo '<p>No hay coincidencias.</p>';
                        } else {
                            while ($rows = $res->fetch_assoc()) {
                                // Showing categories on the page.
                                $status_arrow_icon = $rows['cat_enabled'] == 'YES' ? 'down':'up' ;
                                $cat_status = $rows['cat_enabled'] == 'YES' ? 'Deshabilitar':'Habilitar' ;
                                echo '<tr>';
                                echo '<td>'.$rows['name'].'</td>';
                                echo '<td id="catid-'.$rows['id'].'_cat_status">'.$cat_status = $rows['cat_enabled'] == 'YES' ? 'Habilitada':'Deshabilitada'.'</td>';
                                echo '<td><div>';
                                if ($_SESSION['userid'] == $rows['uploadedBy']) {
                                    echo '<button class="btn my-button-3 cat-edit-form" title="Editar categoría" type="button" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn my-button-2 cat-delete" title="Borrar categoría" type="button" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            <button class="btn btn-dark cat-status-change-form" title="'.$cat_status.' categoría" type="button" id="catid-'.$rows['id'].'" name="'.$rows['name'].'">
                                                <i id="catid-'.$rows['id'].'-change-status-btn" class="fas fa-arrow-circle-'.$status_arrow_icon.'"></i>
                                            </button>';
                                }
                                echo '</div></td>';
                                echo '</tr>';
                                }                   
                            }
                            $res->free(); // Releasing resources from RAM.
                        }     
                    $conn->close(); // Closing database connection.
                ?>
            </tbody>
        </table>
    </div>
</div>