<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_permissions.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    if (!HasPermission("manage_advancedSettings")) {
        include $_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/forbidden.php";
        exit();
    }

?>
<div class="container settings-container">
    <h1 class="title">Logs</h1>
    <table id="logs" class="table table-striped table-bordered table-compact" style="width:100%">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Timestamp</th>
            </tr>
        </tfoot>
    </table>
</div>