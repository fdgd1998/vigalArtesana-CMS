<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $results = array();

    // Retrieve new limit value if changed
    if(isset($_GET['records-limit'])){
      $_SESSION['records-limit'] = $_GET['records-limit'];
    }

    // Variables for pagination
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 12; // Dynamic limit
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
    
    $sql = "select gallery.id, dir, filename, category from gallery inner join categories on gallery.category = categories.id";
    if (isset($_GET["c"])) {
      $sql .= " and gallery.category = ".$_GET["c"];
    }
    
    $sql.=" limit $paginationStart, $limit";

    if ($res = $conn->query($sql)) {
        foreach ($res as $item) {
            array_push($results, array($item["id"], $item["dir"], $item["filename"], $item["category"]));
        }
    }
    // Getting all records from database
    $sql = "";
    if (isset($_GET['c'])) {
        $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id where gallery.category = ".$_GET['c'];
    } else {
      $sql = "select count(gallery.id) as id from gallery inner join categories on gallery.category = categories.id";
    }

    $allRecords = $conn->query($sql)[0]['id'];
    
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
<div class="container content">
  <h1 class="title">Galería</h1>
  <p class="title-descirption">Gestiona la galería. Haz clic sobre las imágenes para seleccionarlas y borrarlas.</p>
  <div class="button-group mb-3">
    <button type="button" id="upload-images" class="btn my-button"><i class="i-margin fas fa-upload"></i>Subir imágenes...</button>
  </div>
  <?php if (count($results) > 0): ?>

  <div class="input-group" style="margin-bottom: 20px;">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1">Ordenar</span>
    </div>
    <select id="display-order" class="form-control">
      <option value="all" <?=$display=='all'?'selected':''?>>Todos</option>
      <option value="bycategory" <?=isset($_GET['c'])?'selected':''?>>Por categoría</option>
    </select>
    <?php if (isset($_GET['c'])): ?>
    <select id="category-order" class="form-control">
    <?php else: ?>
    <select hidden id="category-order" class="form-control">
    
    <?php endif; ?>
    <?php
        $sql = "select id, name from categories";
        if ($res = $conn->query($sql)) {
          foreach ($res as $item) {
            $selected = "false";
            if ($_GET['c']==$item['id']) {
              echo "<option value='".$item['id']."' selected>".$item['name']."</option>";
            } else {
              echo "<option value='".$item['id']."'>".$item['name']."</option>";
            }   
          }
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
          <?php foreach([12,16,24] as $limit) : ?>
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
      <div class="wrap animated-item">
        <a class='gallery-item'>
          <img class="photos img-fluid" id="<?=$element[2]?>" category="<?=$element[3]?>" dir="<?=$element[1]?>" src='../uploads/images/<?=$element[1].$element[2]?>'/>
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
  <?php else: ?>
    <p style="text-align: center; font-size: 20px; margin-top: 50px;">NO HAY RESULTADOS</p>
  <?php endif ?>
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