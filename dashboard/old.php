<!DOCTYPE html>
<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/get_http_protocol.php'; 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../includes/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="../includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="../includes/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../includes/css/Data-Table-1.css">
    <link rel="stylesheet" href="../includes/css/Data-Table.css">
    <link rel="stylesheet" href="../includes/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="../includes/css/styles.css">
    <style type="text/css">
        body { overflow-y: hidden; }
        html, body, iframe { margin:0; padding:0; height:100%; }
        iframe { display:block; width:100%; border:none;} 
    </style>
</head>
<body>
    <?php
        if(isset($_SESSION['user'])) {
            include './includes/header.php';
            echo '
                <div>
                    <iframe id="mainFrame" style="position: absolute; height:90%; border: none" name="mainFrame" src="includes/start.php"></iframe> 
                </div>
            ';
        } else {
            echo '<script type="text/javascript">
                window.location = "'.getHttpProtocol().'://'.$_SERVER['SERVER_NAME'].'/403.php"
            </script>';
        }
    ?>
    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/js/bs-init.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
</body>
</html>