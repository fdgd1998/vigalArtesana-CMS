<?php
    session_start(); // stating the session
    require_once '../scripts/connection.php'; //Database connection data

    // If a non-logged user access to the current script, is redirected to a 403 page.
    if (!isset($_SESSION['user'])) {
      header("Location: ../../../../403.php");
      exit();
    }
    $results = array();

    // Retrieve new limit value if changed
    if(isset($_GET['records-limit'])){
      $_SESSION['records-limit'] = $_GET['records-limit'];
    }

    // Variables for pagination
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 8; // Dynamic limit
    $page = (isset($_GET['n']) && is_numeric($_GET['n']) ) ? $_GET['n'] : 1; // Current pagination page number
    $paginationStart = ($page - 1) * $limit; // Offset

    $allRecords = 0;
    $totalPages = 0;

    // Prev + Next page
    $prev = $page - 1;
    $next = $page + 1;

    // Keeping sort order if the GET variable exists.
    $display = "all";
    if (isset($_GET['display'])&&$_GET['display']=="bycategory") $display = $_GET['display'];

    // Opening database connection.
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $sql = "select gallery.id, filename from gallery inner join categories on gallery.category = categories.id";
    if (isset($_GET["c"])) {
      $sql.=" where gallery.category = ".$_GET["c"];
    }
    $sql.=" limit $paginationStart, $limit";
    if ($res = $conn->query($sql)) {
        while ($rows = $res->fetch_assoc()) {
            array_push($results, array($rows['id'], $rows['filename']));
        }
        $res->free();
    }
    // Getting all records from database
    $sql = "";
    if (isset($_GET['c'])) {
      $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id where gallery.category = ".$_GET['c'];
    } else {
      $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id";
    }
    $allRecords = $conn->query($sql)->fetch_assoc()['id'];
    
    // Calculate total pages
    $totalPages = ceil($allRecords / $limit);

    // defining base URLs for pagination
    $baseURL = "";
    if (isset($_GET['c'])) {
      $baseURL.="?page=manage-gallery&display=bycategory&c=".$_GET['c']."&n=";
    } else {
      $baseURL.="?page=manage-gallery&display=all&n=";
    }
?>

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

<div class="container settings-container">
  <h2 class="title">Galería</h1>
  <button type="button" id="upload-images" class="btn my-button" style="margin-bottom: 15px;"><i class="fas fa-upload"></i>Subir imágenes...</button>
  <div class="input-group" style="margin-bottom: 20px;">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
    <select id="display-order" class="form-control">
      <option value="all" <?=$display=='all'?'selected':''?>>Todos</option>
      <option value="bycategory" <?=isset($_GET['c'])?'selected':''?>>Por categoría</option>
    </select>
    <?php 
      //If the GET variable 'category' is set, a dropdown element is created.
      if (isset($_GET['c'])): 
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
                if ($_GET['c']==$row['id']) {
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
  <form id="set-limit" action="<?=$baseURL?>" method="get">
    <div class="input-group mb-3" style="width: 220px; padding-bottom: 20px;">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Mostrar</span>
        </div>
        <select name="records-limit" id="records-limit" class="custom-select">
            <?php foreach([8,16,24] as $limit) : ?>
            <option
                <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                value="<?= $limit; ?>">
                <?= $limit; ?> resultados
            </option>
            <?php endforeach; ?>
        </select>
      </div>
  </form>
  <div class="container gallery-manage row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
    <?php foreach ($results as $element): ?>
        <div class='col-sm-6 col-md-4 col-lg-3' style='margin-bottom: 30px;'>
            <a class='gallery-item animated'>
              <img id="<?=$element[1]?>" class='photos img-fluid' src='../uploads/images/<?=$element[1]?>'/>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<!-- Pagination -->
<nav aria-label="Page navigation example mt-5" style="margin-bottom: 50px;">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo $baseURL.$prev; }?>"><</a>
        </li>
        <?php if ($totalPages > 10): ?>
            <?php
                $min = $page - 3 < 1 ? 1 : $page - 3;
                $max = $page + 3 > $totalPages ? $totalPages : $page + 3;    
            ?>
            <?php if($page >= 5): ?>
                <li class="page-item disabled">
                    <a class="page-link">...</a>
                </li>
            <?php endif; ?>
            <?php for($i = $min; $i <= $max; $i++): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="<?= $baseURL.$i;?>"> <?= $i; ?> </a>
            </li>
            <?php endfor; ?>
            <?php if($page < $totalPages - 3): ?>
                <li class="page-item disabled">
                    <a class="page-link">...</a>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <?php for($i = 1; $i <= $totalPages; $i++ ): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="<?= $baseURL.$i; ?>"> <?= $i; ?> </a>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        <li class="page-item <?php if($page >= $totalPages) { echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($page >= $totalPages){ echo '#'; } else {echo $baseURL.$next; } ?>">></a>
        </li>
    </ul>
</nav>
</div>
<script src="../includes/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
            $('#records-limit').change(function () {
        window.location.href = "<?=$baseURL?>1&records-limit="+$("#records-limit").val();
      })

      $('#upload-images').click(function() {
      window.location.href = "?page=gallery-new";
      })
    });
</script>