<?php

if( !function_exists('json_encode') || !function_exists('json_decode')) {
    require_once dirname(__FILE__) . '/JSON.php';
}

// Future-friendly json_encode. Works with PHP4, too!
if( !function_exists('json_encode') ) {
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}

// Future-friendly json_decode. Works with PHP4, too!
if( !function_exists('json_decode') ) {
    function json_decode($data, $assoc= false) {
        $json = new Services_JSON();
        return( $json->decode($data) );
    }
}
