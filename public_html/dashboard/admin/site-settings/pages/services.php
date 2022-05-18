<?php
    error_reporting(0);
    session_start(); // starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasAccessToResource("services")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.

    $total_services = 0;
    $services = array();
    try {
      if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
      } else {
        $stmt = "select count(id) from services";
        if ($res = $conn->query($stmt)) {
          $total_services = $res->fetch_assoc()["count(id)"];
        }
        $sql = "select * from services";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($services, array($rows["id"],$rows["title"],$rows["description"],$rows["image"]));
        }
      }
    } catch (Exception $e) {
      echo $e;
    }
?>

<!-- Delete category modal -->
<div class="modal fade" id="delete-service-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel-delete" >Borrando servicio</h5>
        <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body" class="modal-body">
        <p>¿Estás seguro de que deseas borrar este servicio?</p>
      </div>
      <div id="modal-footer1" class="modal-footer">
        <button id="cancel-delete-service" type="button" class="btn my-button" data-dismiss="modal">Cancelar</button>
        <button id="delete-service-btn" type="button" class="btn my-button-2"><i class="far fa-trash-alt"></i>Borrar</button>
      </div>
    </div>
  </div>
</div>
<div class="container settings-container">
  <h1 class="title">Servicios</h1>
  <p class="title-description">Añade en esta sección los servicios que ofreces a tus clientes. Puedes añadir hasta un máximo de 10 servicios.</p>
  <div class="alert my-alert">
    <?php if ($total_services == 0): ?>
      Aún no has creado ningún servicio. Puedes crear un total de 10.
    <?php endif; ?>
    <?php if ($total_services < 10 && $total_services > 0): ?>
      Has creado <strong><?=$total_services?></strong> servicio<?=$total_services>1?"s":""?>. Puedes crear <strong><?=10-$total_services?></strong> más.
    <?php endif; ?>
    <?php if ($total_services == 10): ?>
      No puedes crear más servicios. Para crear uno nuevo, tienes que borrar uno existente.
    <?php endif; ?>
  </div>

  <div class="button-group">
    <button <?=$total_services == 10?"disabled":""?> type="button" onclick="window.location.href='?page=new-service'" class="btn my-button" style="margin-bottom: 15px;"><i class="far fa-plus-square"></i>Nuevo servicio</button>
  </div>
  <?php if ($total_services != 0): ?>
  <div class="row">
    <div class="col-12 carousel-buttons">
        <a class="btn my-button mr-1" href="#services" role="button" data-slide="prev">
            <i class="fa fa-arrow-left i-no-margin"></i>
        </a>
        <a class="btn my-button mr-1" href="#services" role="button" data-slide="next">
            <i class="fa fa-arrow-right i-no-margin"></i>
        </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div id="services" class="carousel slide" data-ride="carousel">
          <!-- The slideshow -->
        <div class="carousel-inner">
          <?php $i = 0; ?>
          <?php foreach ($services as $service): ?>
          <div class="carousel-item <?=$i == 0? "active":""?>">
            <div class="card mb-3">
              <div class="row no-gutters">
                <div class="col-md-6">
                  <img src="../uploads/services/<?=$service[3]?>" class="card-img" alt="...">
                </div>
                <div class="col-md-6 d-flex">
                  <div class="card-body align-self-center">
                    <h5 class="card-title font-weight-bold"><?=$service[1]?></h5>
                    <p class="card-text"><?=$service[2]?></p>
                    <div class="button-group carousel-buttons">
                      <button type="button" id="edit-<?=$service[0]?>" class="btn my-button-3 edit-service"><i class="far fa-edit"></i>Editar</button>
                      <button type="button" id="delete-<?=$service[0]?>" class="btn my-button-2 delete-service"><i class="far fa-trash-alt"></i>Borrar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $i++; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>