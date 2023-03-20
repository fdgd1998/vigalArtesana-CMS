<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $categories = array();
    $sql = "select * from categories ";
    if ($res = $conn->query($sql)) {
      foreach ($res as $item) {
        array_push($categories, array ("id" => $item["id"], "name" => $item["name"]));
      }
    }
?>

<!-- Delete category modal -->
<div class="modal fade" id="delete-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
          <button id="cancel-cat-delete" type="button" class="btn my-button" data-dismiss="modal"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
          <button id="cat-delete" type="button" class="btn my-button-2"><i class="i-margin fas fa-trash"></i>Borrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container settings-container">
    <h1 class="title">Categorías</h1>
    <div class="button-group-left">
      <button type="button" id="create-cat" class="btn my-button" style="margin-bottom: 15px;"><i class="i-margin fas fa-plus-circle"></i>Nueva categoría</button>
    </div>
    <div class="table-responsive">
      <?php if (count($categories) > 0): ?>
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $item) {
                    // Showing categories on the page.
                    echo '<tr>';
                    echo '<td>'.$item['name'].'</td>';
                    echo '<td><div>';
                    echo '<a class="btn my-button-3 cat-edit-form" title="Editar categoría" id="catid-'.$item['id'].'" name="'.$item['name'].'">
                              <i class="i-margin fas fa-edit"></i>
                              Editar
                          </a>
                          <a class="btn my-button-2 cat-delete" title="Borrar categoría" id="catid-'.$item['id'].'" name="'.$item['name'].'">
                              <i class="i-margin fas fa-trash"></i>
                              Borrar
                          </a>';
                    }
                    echo '</div></td>';
                    echo '</tr>';    
                ?>
            </tbody>
        </table>
        <?php else: ?>
          <p style="font-size: 20px; text-align: center; margin-top: 50px;">NO HAY RESULTADOS</p>
        <?php endif; ?>
    </div>
</div>