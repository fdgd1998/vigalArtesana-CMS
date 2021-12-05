<?php
    function set_503_header() {
        $protocol = 'HTTP/1.0';
    
        if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
            $protocol = 'HTTP/1.1';
        }
    
        header( $protocol . ' 503 Service Unavailable', true, 503 );
        header( 'Retry-After: 3600' );
    }
?>