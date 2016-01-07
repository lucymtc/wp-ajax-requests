<?php
/**
 * returns the built WPAjaxRequest Objetc
 */

if( !function_exists('wpar_request') ){

require_once 'vendor/autoload.php';

function wpar_request( $args ){

     $defaults = array(
            'action'     => '',
            'callback'   => '',
            'nonce'      => null,
            'capability' => null,
            'output'     => 'Json',
        );

    $args = wp_parse_args( $args, $defaults);

    $security = new Security( $args['nonce'], $args['capability'] );
    $data_handler = new DataHandler( new $args['output']() );

    return new WPAjaxRequest( $args['action'], $args['callback'], $security, $data_handler);

}

}