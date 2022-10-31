<?php
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $users = array();

    if ($conn->connect_error) {
      print("No se ha podido conectar a la base de datos");
      exit();
    } else {
        if ($_SESSION["account_type"] != "superuser") {
            $sql = "select users.id, username, email, role from users inner join user_roles on users.account_type = user_roles.id where role != 'superuser'";
        } else {
            $sql = "select users.id, username, email, role from users inner join user_roles on users.account_type = user_roles.id";
        }
        if ($res = $conn->query($sql)) {
          while ($rows = $res->fetch_assoc()) {
            array_push($users, array (
                "id" => $rows["id"], 
                "username" => $rows["username"],
                "email" => $rows["email"],
                "account_type" => $rows["role"]
            ));
          }
        }
    }
    $conn->close();
?>

<!-- Delete category modal -->
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

<!-- Delete category modal -->
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
    <button type="button" id="create-user" class="btn my-button" style="margin-bottom: 15px;"><i class="i-margin fas fa-user-plus"></i>Crear usuario</button>

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
                    if ($_SESSION["userid"] != $item["id"]) {
                        echo '<tr>';
                        echo '<td class="username">'.$item['username'].'</td>';
                        echo '<td>'.$item['email'].'</td>';
                        echo '<td>'.$item['account_type'].'</td>';
                        echo '<td><div>';
                        echo '<a class="btn my-button-3 user-edit" userid="'.$item['id'].'">
                                <i class="i-margin fas fa-user-cog"></i>
                                Editar
                            </a>
                            <a class="btn my-button user-reset" userid="'.$item['id'].'">
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