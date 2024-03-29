<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $users = array();

    $sql = "select users.id, username, email, role from users inner join user_roles on users.account_type = user_roles.id";
    if ($res = $conn->query($sql)) {
      foreach ($res as $item) {
        array_push($users, array (
            "id" => $item["id"], 
            "username" => $item["username"],
            "email" => $item["email"],
            "account_type" => $item["role"]
        ));
      }
    }
?>


<div class="modal fade" id="delete-user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-delete" >Borrando usuario</h5>
          <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas eliminar este usuario? El contenido que haya creado permanecerá en el sitio web.</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-user-delete" type="button" class="btn my-button" data-dismiss="modal"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
          <button id="user-delete" type="button" class="btn my-button-2"><i class="i-margin fas fa-user-times"></i>Borrar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="reset-user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-reset" >Restableciendo contraseña de</h5>
          <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas restablecer la contraseña de este usuario?</p>
          <p>La solicitud será válida durante 24h, pasado este tiempo, tendrás que enviar otra solicitud de restablecimiento de contraseña.</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-user-reset" type="button" class="btn my-button-2" data-dismiss="modal"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
          <button id="user-reset" type="button" class="btn my-button"><i class="i-margin fas fa-key"></i>Restablecer</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container settings-container">
    <h1 class="title">Usuarios</h1>
    <div class="button-group-left">
      <button type="button" id="create-user" class="btn my-button" style="margin-bottom: 15px;"><i class="i-margin fas fa-user-plus"></i>Crear usuario</button>
    </div>
  <?php if (count($users) > 1): ?>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Tipo de cuenta</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $item) {
                    // Showing categories on the page.
                    if ($_SESSION["userid"] != $item["id"] && $item["id"] != 0) {
                        echo '<tr>';
                        echo '<td class="username">'.$item['username'].'</td>';
                        echo '<td>'.$item['email'].'</td>';
                        echo '<td>'.$item['account_type'].'</td>';
                        echo '<td><div>';
                        echo '<a class="btn my-button-3 user-edit" userid="'.$item['id'].'">
                                <i class="i-margin fas fa-user-cog"></i>
                                Editar
                            </a>
                            <a class="btn my-button user-reset" email="'.$item['email'].'">
                                <i class="i-margin fas fa-key"></i>
                                Reset
                            </a>
                            <a class="btn my-button-2 user-delete" userid="'.$item['id'].'">
                                <i class="i-margin fas fa-user-times"></i>
                                Borrar
                            </a>';
                        echo '</div></td>';
                        echo '</tr>';
                        }  
                    }  
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
  <p style="font-size: 20px; text-align: center; margin-top: 50px;">NO HAY RESULTADOS</p>
<?php endif; ?>