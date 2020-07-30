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
<script src="admin/posts/js/list-posts.js"></script>

  <!-- Delete post modal -->
  <div class="modal fade" id="delete-post" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-delete">Eliminando post ...</h5>
          <button id="close-edit-post" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas eliminar este post?</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-post-delete" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="post-delete" type="button" class="btn btn-success">Eliminar</button>
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

  <div class="container">
    <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Posts</h1>
    
    <div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
      <select id="result-order" class="form-control" name="account" id="account-edit">
        <option value="asc" <?=isset($order)?($order=='asc'?'selected':''):''?>>Ascendente</option>
        <option value="desc" <?=isset($order)?($order=='desc'?'selected':''):''?>>Descendente</option>
        <option value="published" <?=isset($order)?($order=='published'?'selected':''):''?>>Publicado</option>
        <option value="notpublished" <?=isset($order)?($order=='notpublished'?'selected':''):''?>>No publicado</option>
      </select>
    </div>
    <div class="table-responsive">
      <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Autor</th>
                <th>Publicado</th>
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
                $sql = "select POSTS.id, POSTS.author, CATEGORIES.name, POSTS.title, POSTS.content, POSTS.images, POSTS.published from posts inner join categories on CATEGORIES.id = POSTS.category";
                  if (isset($_GET['order'])) {
                    switch($_GET['order']) {
                      case 'asc':
                        $sql .= " order by title asc";
                        break;
                      case 'desc':
                        $sql .= " order by title desc";
                        break;
                      case 'published':
                        $sql .= " where published = 'YES' order by title asc";
                        break;
                      case 'notpublished':
                        $sql .= " where published = 'NO' order by title asc";
                        break;
                    } 
                  }

                  $res = $conn->query($sql);
                  if ($res->num_rows == 0) {
                    echo '<p>No hay coincidencias.</p>';
                  } else {
                    while ($rows = $res->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$rows['title'].'</td>';
                        echo '<td>'.$rows['name'].'</td>';
                        echo '<td>'.$rows['author'].'</td>';
                        $enabled = $rows['published'] == 'YES' ? 'Sí':'No';
                        echo '<td id="postid-'.$rows['id'].'_status">'.$enabled.'</td>';
                        echo '
                            <td>
                                <div>
                                    <button class="btn btn-success post-edit-form" title="Editar post" type="button" style="margin-right: 1px;" id="postid-'.$rows['id'].' name="'.$rows['title'].'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                            ';
                        if ($rows['account_type'] != 'superuser' && $_SESSION['user'] != $rows['username']) {
                          $status_arrow_icon = $rows['published'] == 'YES' ? 'down':'up' ;
                          $post_status = $rows['published'] == 'YES' ? 'Deshabilitar':'Habilitar' ;
                          echo '
                            <button class="btn btn-danger post-delete" title="Borrar post" type="button" style="margin-right: 1px;" id="postid-'.$rows['id'].'" name="'.$rows['title'].'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-dark post-status-change-form" title="'.$post_status.' usuario" type="button" id="postid-'.$rows['id'].'" name="'.$rows['title'].'">
                                        <i id="postid-'.$rows['id'].'-change-status-btn" class="fas fa-arrow-circle-'.$status_arrow_icon.'"></i>
                                    </button>
                                </div>
                            </td>';
                        }       
                        echo '</tr>';
                      }                   
                    };
                  }
                  $res->free();        
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