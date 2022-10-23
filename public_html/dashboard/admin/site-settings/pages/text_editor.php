<?php
    error_reporting(0);
    session_start();

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    // configuration
    $url = (isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]."/dasboard?page=text-editor&file=".$_GET["file"];
    $file = $_GET["file"];
    $path = $_SERVER["DOCUMENT_ROOT"]."/";

    // check if form has been submitted
    if (isset($_POST['text']))
    {
        // save the text contents
        file_put_contents($path.$file, $_POST['text']);

        // redirect to form again
        header('Location: '.$url);
    }

    // read the textfile
    $text = file_get_contents($path.$file);
?>
<div class="container settings-container">
    <h1 class="title"></i>Editando <em><?=$_GET["file"]?></em></h1>

    <form action="" method="post">
        <textarea rows="30" class="form-control" name="text"><?php echo htmlspecialchars($text); ?></textarea>
        <div class="form-row text-right" style="margin-top: 20px;">
            <div class="col">
                <input class="btn my-button" type="submit" value="Guardar"></input>
            </div>
        </div>
    </form>
</div>