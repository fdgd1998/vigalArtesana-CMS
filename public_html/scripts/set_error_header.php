<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    // require_once "check_session.php";
    
    function set_503_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 503 Service Unavailable', true, 503 );
        header( 'Retry-After: 3600' );
    }

    function set_500_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 500 Internal Server Error', true, 500 );
        header( 'Retry-After: 3600' );
    }

    function set_404_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 404 Not Found', true, 404 );
        header( 'Retry-After: 3600' );
    }

    function set_410_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 410 Gone', true, 410 );
        header( 'Retry-After: 3600' );
    }

    function set_400_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 400 Bad Resquest', true, 400 );
        header( 'Retry-After: 3600' );
    }

    function set_403_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 403 Forbidden', true, 403 );
        header( 'Retry-After: 3600' );
    }
?>