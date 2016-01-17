<?php

/**
 * Object that will handle the request.
 * Dependencies on Security and DataHanlder.
 */

if( ! class_exists( 'Handler' )){

class Handler{

    private $_security;
    private $_data_handler;
    private $_front_handler;

    public $args;

    /**
     *
     */
    public function __construct( $action = '', $callback = '', Security $security, Data $data_handler, Front $front_handler ){

        $this->_action = $action;
        $this->_callback = $callback;
        $this->_security = $security;
        $this->_data_handler = $data_handler;
        $this->_front_handler = $front_handler;

        $this->add_actions();

        if( $front_handler != null ) {
            // send the nonce to the front handler for add to the list.
            $nonce = $this->_security->get_nonce();
            $this->_front_handler->create_nonce($nonce);
        }
    }

    /**
     * Adds actions for the callbacks and ajax requests
     */
    public function add_actions(){

        if( $this->_callback != '') {
            add_action( 'wpajaxrequest_callback_' . $this->_action , $this->_callback );
        }

        if( $this->_action != '') {
            add_action( 'wp_ajax_' . $this->_action , array( $this, 'request_handler') );
            add_action( 'wp_ajax_nopriv_' . $this->_action , array( $this, 'request_handler') );
        }

    }

    /**
     * Calls security chheck method and fires user's callback function if success
     * @return void
     */
    public function request_handler(){

        if( $this->_security->check() ){

            $this->do_callback();

        } else {

            echo $this->_security->get_error();
        }

        wp_die();
    }


   /**
    * Adds the hook action to run users callback returning the data.
    */
    public function do_callback(){

        $posted = array();
        $data = maybe_serialize( $_POST['data'] );

        if( isset( $data ) ){
            wp_parse_str( $data, $posted );
        }

        $this->_data_handler->set_data( $posted );
        $this->_data_handler->add_data( array('success' => true) );

        // Users Callback
        do_action('wpajaxrequest_callback_' . $this->_action, $this->_data_handler->load_output() );

        if( $this->_callback === '' ) echo $this->_data_handler->load_output();
    }
}

}