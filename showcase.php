<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/connection.php';

    // Retrieve new limit value if changed
    if(isset($_POST['records-limit'])){
        $_SESSION['records-limit'] = $_POST['records-limit'];
    }

    $categories = array();

    $category_name = "";
    $results = array();

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    // Variables for pagination
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 4; // Dynamic limit
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1; // Current pagination page number
    $paginationStart = ($page - 1) * $limit; // Offset

    $allRecords = 0;
    $totalPages = 0;

    // Prev + Next page
    $prev = $page - 1;
    $next = $page + 1;

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        if(!isset($_GET['category'])) {
            $sql = "select * from categories where cat_enabled='YES'";
            $res = $conn->query($sql);
            while ($rows = $res->fetch_assoc()) {
                array_push($categories, array($rows['id'], $rows['name'], $rows['image']));
            }
            $res->free();
        } else {
            $sql = "select POSTS.id, CATEGORIES.name, author, title, content, images from posts inner join categories on POSTS.category = CATEGORIES.id where cat_enabled='YES' and POSTS.category = ".$_GET['category']." limit $paginationStart, $limit";
            if ($res = $conn->query($sql)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($results, array($rows['id'], $rows['author'], $rows['title'], $rows['content'], explode(",", $rows['images'])[0]));
                }
                $res->free();
            }

            // Getting all records from database
            $sql = "select count(POSTS.id) as id from posts inner join categories on POSTS.category = CATEGORIES.id where cat_enabled='YES' and POSTS.category = ".$_GET['category']; 
            $allRecords = $conn->query($sql)->fetch_assoc()['id'];
            
            // Calculate total pages
            $totalPages = ceil($allRecords / $limit);

            $sql = "select name from categories where id = ".$_GET['category'];
            if ($res = $conn->query($sql)) {
                $rows = $res->fetch_assoc();
                $category_name = $rows['name'];
                $res->free();
            }
        }
    }


    $conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViGal - Exposición</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="./includes/css/showcase.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/bs-init.js"></script>
</head>

<body>
    <?php
        include './includes/header.php';
    ?>
        <div class="container">
            <?php if (!isset($_GET['category'])): ?>
                <div class="intro">
                    <h2 class="text-center" style="margin-top: 50px; margin-bottom: 10px;">Exposición</h2>
                    <p class="text-center" style="margin-bottom: 50px;">Haz clic sobre las imágenes para ver los trabajos de cada categoría. </p>
                </div>
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
                    <?php foreach ($categories as $element): ?>
                        <div class='animated category col-sm-6 col-md-4 col-lg-3 item' style='margin-bottom: 30px;'>
                            <a data-lightbox='photos' href='<?=$_SERVER['PHP_SELF']."?category=".$element[0]?>'>
                                <div class='wrap'>
                                    <label class='title text-center'><?=$element[1]?></label>
                                    <img class='img-fluid category' src='/uploads/categories/<?=$element[2]?>'/>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>   
            <?php else: ?>
                <div class="intro">
                    <h2 class="text-center" style="margin-top: 50px; margin-bottom: 40px;"><?=$category_name?></h2>
                </div>
                <form action="?page=<?=$page?>&category=<?=$_GET['category']?>" method="post">
                    <div class="input-group mb-3" style="width: 150px">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                        </div>
                        <select name="records-limit" id="records-limit" class="custom-select">
                            <?php foreach([4,8,16] as $limit) : ?>
                            <option
                                <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                                value="<?= $limit; ?>">
                                <?= $limit; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            
                <div class="row row-cols-2 row-cols-md-3 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4" style="margin-bottom: 20px;">
                <?php foreach ($results as $element): ?>
                <div class="col mb-4">
                    <div class="card h-100">
                    <img class="card-img-top img-fluid" src="<?='/uploads/posts/'.$element[4]?>">
                    <div class="card-body">
                        <h5 class="card-title"><?=$element[2]?></h5>
                        <p class="card-text"><?=substr($element[3],0,200)."..."?></p>
                        <button style="margin-right: 3px;" class="btn btn-dark" type="button">Leer más</button>
                        <?php 
                            if (isset($_SESSION['user'])):
                                if ($element[1] == $_SESSION['user']):
                                ?>
                                <div style="display: inline-block;">
                                <button class="btn btn-success edit-post" type="button" id="edit-post-<?=$element[0]?>"><i class="far fa-edit"></i></button>
                                <button class="btn btn-danger delete-post" type="button" style="margin-left: 1px;" id="delete-post-<?=$element[0]?>"><i class="far fa-trash-alt"></i></button>
                                </div>
                                <?php 
                                endif; 
                            endif;
                        ?>
                    </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($_GET['category'])): ?>
        <nav aria-label="Page navigation example mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>&category=<?= $_GET['category'] ?>"><</a>
                </li>

                <?php for($i = 1; $i <= $totalPages; $i++ ): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="showcase.php?page=<?= $i; ?>&category=<?= $_GET['category'] ?>"> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>

                <li class="page-item <?php if($page >= $totalPages) { echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page >= $totalPages){ echo '#'; } else {echo "?page=". $next; } ?>&category=<?= $_GET['category'] ?>">></a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    <?php
        include './includes/footer.php';
    ?>
    <script>
        $(document).ready(function () {
            $('#records-limit').change(function () {
                $('form').submit();
            })

            $('.edit-post').click(function () {
                var id = $(this).prop('id').substr(10);
                window.location = "/dashboard?page=create-post&action=edit&id="+id;
            })
        });
    </script>
</body>
</html>