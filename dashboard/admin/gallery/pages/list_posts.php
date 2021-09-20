<?php
    session_start(); // stating the session
    require_once '../scripts/connection.php'; //Database connection data

    // If a non-logged user access to the current script, is redirected to a 403 page.
    if (!isset($_SESSION['user'])) {
      header("Location: ../../../../403.php");
      exit();
    }

    // Keeping sort order if the GET variable exists.
    if (isset($_GET['order'])) $order = $_GET['order'];

    // Opening database connection.
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
?>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="admin/posts/js/list-posts.js"></script>

<!-- Bootstrap modal for deleting posts -->
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

<!-- Bootstrap modal for changing post status -->
<div class="modal fade" id="post-status-change" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel-statuschange"></h5>
        <button id="close-statuschange-post" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body" class="modal-body">
        <p id="statuschange_modal_info_text"></p>
      </div>
      <div id="modal-footer1" class="modal-footer">
        <button id="cancel-post-statuschange" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="post-statuschange" type="button" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;">Posts</h1>
  <div class="input-group" style="margin-bottom: 20px;">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
    <select id="result-order" class="form-control">
      <option value="asc" <?=isset($order)?($order=='asc'?'selected':''):''?>>Ascendente</option>
      <option value="desc" <?=isset($order)?($order=='desc'?'selected':''):''?>>Descendente</option>
      <option value="published" <?=isset($order)?($order=='published'?'selected':''):''?>>Publicado</option>
      <option value="notpublished" <?=isset($order)?($order=='notpublished'?'selected':''):''?>>No publicado</option>
      <option value="bycategory" <?=isset($_GET['category'])?'selected':''?>>Por categoría</option>
    </select>
    <?php 
      //If the GET variable 'category' is set, a dropdown element is created.
      if (isset($_GET['category'])): 
    ?>
      <select id="category-order" class="form-control">
      <?php else: ?>
      <select hidden id="category-order" class="form-control">
      
      <?php endif; ?>
      <?php
          if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
          } else {
            $sql = "select id, name from categories";
            
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
              while ($row = $res->fetch_assoc()) {
                $selected = "false";
                if ($_GET['category']==$row['id']) {
                  echo "<option value='".$row['id']."' selected>".$row['name']."</option>";
                } else {
                  echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }   
              }
            }
            $res->free();
          }
        ?>
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
            // Fetching posts information from database.
            echo '<script>account_name = "'.$_SESSION['user'].'"</script>';
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
              $sql = "select posts.id, posts.author, categories.name, posts.title, posts.content, posts.images, posts.published from posts inner join categories on categories.id = posts.category";
                // Setting posts order depending on user's choice.
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
                    case 'category':
                      $sql .= " where categories.id = ".$_GET['category'];
                      break;
                  } 
                }

                // Fetching sorted posts results from database.
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
                                  <button class="btn btn-success post-edit-form" title="Editar post" type="button" style="margin-right: 1px;" id="postid-'.$rows['id'].'" name="'.$rows['title'].'">
                                      <i class="fas fa-edit"></i>
                                  </button>
                          ';

                        // Showing options to manage posts (edit, delete and change status - published/not published).
                        $status_arrow_icon = $rows['published'] == 'YES' ? 'down':'up' ; // Setting arrow icon for changing post status depending on the current status.
                        $post_status = $rows['published'] == 'YES' ? 'Deshabilitar':'Habilitar'; // Setting action text for changing post status depending on the current status.
                        echo '
                          <button class="btn btn-danger post-delete" title="Borrar post" type="button" style="margin-right: 1px;" id="postid-'.$rows['id'].'" name="'.$rows['title'].'">
                                      <i class="fas fa-trash"></i>
                                  </button>
                                  <button class="btn btn-dark post-status-change-form" title="'.$post_status.' post" type="button" id="postid-'.$rows['id'].'" name="'.$rows['title'].'">
                                      <i id="postid-'.$rows['id'].'-change-status-btn" class="fas fa-arrow-circle-'.$status_arrow_icon.'"></i>
                                  </button>
                              </div>
                          </td>';
                      }       
                      echo '</tr>';
                    }                   
                  };
                
                $res->free(); // Releasing results from RAM.  
            $conn->close(); // Closing databas connection.
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap modal form for creating posts. 
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
</div> -->