<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    function set_503_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 503 Service Unavailable', true, 503 );
        header( 'Retry-After: 3600' );
    }
?>