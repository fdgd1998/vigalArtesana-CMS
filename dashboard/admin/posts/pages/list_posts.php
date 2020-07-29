<?php
    require_once '../modules/connection.php';
    require_once '../modules/crypt.php';

    if (!isset($_SESSION['user'])) {
      header("Location: ../../../../403.php");
      exit();
    }

    if (isset($_GET['order'])) $order = $_GET['order'];

    $change_account_type = true;
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
?>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="admin/users/js/list-users.js"></script>

  <!-- Delete user modal -->
  <div class="modal fade" id="delete-user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-delete">Editando usuario ...</h5>
          <button id="close-edit-user" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas eliminar este usuario?</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-user-delete" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="user-delete" type="button" class="btn btn-success">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Enabling/disabling user modal -->
  <div class="modal fade" id="user-status-change" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-statuschange">Editando usuario ...</h5>
          <button id="close-statuschange-user" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p id="statuschange_modal_info_text"></p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-user-statuschange" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="user-statuschange" type="button" class="btn btn-success">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Restoring user password modal -->
  <div class="modal fade" id="user-password" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-password">Restaleciendo contraseña para ...</h5>
          <button id="close-password-recover" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p id="password_recover_modal_info_text"></p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-password-recover" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="submit-password-recover" type="button" class="btn btn-success">Restablecer</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Posts</h1>
    
    <div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
      <select id="result-order" class="form-control" name="account" id="account-edit">
        <option value="asc" <?=isset($order)?($order=='asc'?'selected':''):''?>>Ascendente</option>
        <option value="desc" <?=isset($order)?($order=='desc'?'selected':''):''?>>Descendente</option>
        <option value="published" <?=isset($order)?($order=='enabled'?'selected':''):''?>>Publicado</option>
        <option value="not-published" <?=isset($order)?($order=='disabled'?'selected':''):''?>>No publicado</option>
        <option value="category" <?=isset($order)?($order=='disabled'?'selected':''):''?>>Por categoría</option>
      </select>
    </div>
    <div class="table-responsive">
      <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Apellidos</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo de cuenta</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
          <?php
              echo '<script>account_name = "'.$_SESSION['user'].'"</script>';
              if ($conn->connect_error) {
                  print("No se ha podido conectar a la base de datos");
                  exit();
              } else {
                $sql = "select id, username, firstname, surname, email, account_type, account_enabled from users";
                  if (isset($_GET['order'])) {
                    switch($_GET['order']) {
                      case 'asc':
                        $sql .= " order by username asc";
                        break;
                      case 'desc':
                        $sql .= " order by username desc";
                        break;
                      case 'enabled':
                        $sql .= " where account_enabled = 'YES'";
                        break;
                      case 'disabled':
                        $sql .= " where account_enabled = 'NO'";
                        break;
                    } 
                  }

                  $res = $conn->query($sql);
                  if ($res->num_rows == 0) {
                    echo '<p>No hay coincidencias.</p>';
                  } else {
                    while ($rows = $res->fetch_assoc()) {
                      if ($_SESSION['account_type'] == 'admin' && $rows['account_type'] == 'superuser') {
                        continue;
                      } else {
                        echo '<tr>';
                        echo '<td>'.$rows['username'].'</td>';
                        echo '<td>'.OpenSSLDecrypt($rows['surname']).'</td>';
                        echo '<td>'.OpenSSLDecrypt($rows['firstname']).'</td>';
                        echo '<td>'.$rows['email'].'</td>';
                        if ($_SESSION['user'] == $rows['username']) $change_account_type = false;
  
                        $account_type = '';
                        switch ($rows['account_type']) {
                            case 'superuser':
                                $account_type = 'Superusuario';
                                break;
                            case 'publisher':
                                $account_type = 'Publicador';
                                break;
                            case 'admin':
                                $account_type = 'Administrador';
                                break;
                        }
                        echo '<td>'.$account_type.'</td>';
                        echo '<td id="userid-'.$rows['id'].'_account_status">'.$account_status = $rows['account_enabled'] == 'YES' ? 'Habilitada':'Deshabilitada'.'</td>';
                        echo '
                            <td>
                                <div>
                                    <button class="btn btn-success user-edit-form" title="Editar usuario" type="button" style="margin-right: 1px;" id="userid-'.$rows['id'].'" name="'.$rows['username'].'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                            ';
                        if ($rows['account_type'] != 'superuser' && $_SESSION['user'] != $rows['username']) {
                          $status_arrow_icon = $rows['account_enabled'] == 'YES' ? 'down':'up' ;
                          $user_status = $rows['account_enabled'] == 'YES' ? 'Deshabilitar':'Habilitar' ;
                          echo '
                            <button class="btn btn-danger user-delete" title="Borrar usuario" type="button" style="margin-right: 1px;" id="userid-'.$rows['id'].'" name="'.$rows['username'].'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-dark user-status-change-form" title="'.$user_status.' usuario" type="button" id="userid-'.$rows['id'].'" name="'.$rows['username'].'">
                                        <i id="userid-'.$rows['id'].'-change-status-btn" class="fas fa-arrow-circle-'.$status_arrow_icon.'"></i>
                                    </button>
                                    <button id="useremail-'.$rows['email'].'" class="btn btn-warning password-recover-form" title="Recuperar contraseña" type="button" id="userid-'.$rows['id'].'" name="'.$rows['username'].'">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </td>';
                        }       
                        echo '</tr>';
                      }                   
                    };
                  }
                  $res->free();
              }          
              $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Editing user modal -->
  <div class="modal fade" id="edit-user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-edit">Editando usuario ...</h5>
          <button id="close-user-edit" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <div class="form-group">
              <label for="email1-input-edit">Email: </label>
              <input id="email1-input-edit" class="form-control" name="email" type="text">
          </div>
          <div class="form-group">
              <label for="email2-input-edit">Confirma email: </label>
              <input id="email2-input-edit" class="form-control" name="email" type="text">
          </div>  
            <div id='select-account' class="form-group"></div>          
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-user-edit" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="user-edit" disabled="true" type="button" class="btn btn-success">Crear</button>
        </div>
      </div>
    </div>
  </div>
<!-- </body>
</html> -->