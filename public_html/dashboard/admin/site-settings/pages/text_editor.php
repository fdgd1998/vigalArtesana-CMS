<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    // configuration
    $url = GetbaseUri()."/dasboard?page=text-editor&file=".$_GET["file"];
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
        <textarea rows="30" class="form-control" name="text"s><?php echo htmlspecialchars($text); ?></textarea>
        <!-- <div class="form-row text-right" style="margin-top: 20px;"> -->
            <div class="button-group-right mt-3">
                <a class="btn my-button" style="margin-top: -5px" href="<?=GetBaseUri().'/dashboard/admin/site-settings/download.php?file='.$_GET['file']?>"><i class="i-margin fa-solid fa-download"></i>Descargar</a>
                <button class="btn my-button-3" type="submit" ><i class="i-margin fas fa-save"></i>Guardar</button>            
            </div>
        <!-- </div> -->
    </form>
</div>