<?php
/**
 * returns the built WPAjaxRequest Objetc
 */



if( !function_exists('wpar_request') ){

require_once 'vendor/autoload.php';

function wpar_request( $args ){

     $defaults = array(
        'action' => '',
        'callback' => '',
        'nonce' => null,
        'capability' => null,
        'output' => 'Json',
        'use_front' => true,
        'front_script_handle' => 'wpajaxrequest-script',
        'front_script_src' => home_url( str_replace( ABSPATH, '', __DIR__ . '/js/wp-ajax-request.js') ),
        'localize_name' => 'wpar',
    );

    $args = wp_parse_args( $args, $defaults);

    $security = new Security( $args['nonce'], $args['capability'] );
    $data_handler = new Data( new $args['output']() );

    if( $args['use_front'] ) {
        $front_handler = new Front( $args['front_script_handle'], $args['front_script_src'], $args['localize_name']);
    } else {
        $front_handler = null;
    }

    return new WPAjaxRequest( $args['action'], $args['callback'], $security, $data_handler, $front_handler);

}

}