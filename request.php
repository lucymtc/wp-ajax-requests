<?php
/**
 * returns the built WPAjaxRequest Objetc
 */



if( !function_exists('wpar_request') ){

require_once 'vendor/autoload.php';

function wpar_request( $args ){

     $defaults = array(

        /**
         * Required. The action name to create the custom handler for the wordpress hook.
         * wp_ajax_(action), wp_ajax_nonpriv_(action)
         */
        'action' => '',

        /**
         * Callback function defined by the user to run if the request
         * is valid and passes the security checks.
         */
        'callback' => '',

        /**
         * Action name to create the nonce wp_create_nonce().
         * Security checks will run against this name.
         * If left as null, the nonce verification won't take place.
         */
        'nonce' => null,

        /**
         * Security checks will run against this capability. For example: manage_options
         */
        'capability' => null,

        /**
         * Data output format. Possible values Json, SerializedArra, XML.
         */
        'output' => 'Json',

        /**
         * If set to false, the support for the front end will not be used.
         * The user will need to enqueue scripts and send request manually.
         */
        'use_front' => true,

        /**
         * Name used as a handle for the script in wp_enqueue_script()
         */
        'front_script_handle' => 'wpajaxrequest-script',

        /**
         * You may replace the script responsible to send the request by changing
         * the default path to your own script.
         */
        'front_script_src' => home_url( str_replace( ABSPATH, '', __DIR__ . '/js/wp-ajax-request.js') ),

        /**
         * The name of the variable which will contain the data for wp_localize_script().
         */
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