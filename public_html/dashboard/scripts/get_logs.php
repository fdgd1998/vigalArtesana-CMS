<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_permissions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";

    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    if (!HasPermission("manage_siteSettings")) {
        include $_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/forbidden.php";
        exit();
    }
    /*
    * DataTables example server-side processing script.
    *
    * Please note that this script is intentionally extremely simple to show how
    * server-side processing can be implemented, and probably shouldn't be used as
    * the basis for a large complex system. It is suitable for simple use cases as
    * for learning.
    *
    * See http://datatables.net/usage/server-side for full details on the server-
    * side processing requirements of DataTables.
    *
    * @license MIT - http://datatables.net/license_mit
    */
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Easy set variables
    */
    
    // DB table to use
    $table = 'logs';
    
    // Table's primary key
    $primaryKey = 'id';
    
    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case object
    // parameter names
    $columns = array(
        array( 'db' => 'text', 'dt' => 'description' ),
        array( 'db' => 'type',  'dt' => 'type' ),
        array( 'db' => 'timestamp',   'dt' => 'timestamp' )
    );
    
    // SQL server connection information
    $sql_details = array(
        'user' => 'root',
        'pass' => '',
        'db'   => 'vigal',
        'host' => 'localhost'
    );
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * If you just want to use the basic configuration for DataTables with PHP
    * server-side, there is no need to edit below this line.
    */
    
    require( $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/ssp.class.php' );
    
    echo json_encode(
        SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
    );
?>