<?php


class WPAjaxRequest{

    private $_security;
    private $_data_handler;

    public $args;

    /**
     *
     */
    public function __construct( $args = array(), Security $security, DataHandler $data_handler ){

        $this->_security = $security;
        $this->_data_handler = $data_handler;

        $this->args = $this->set_arguments( $args );
        $this->add_actions();
    }

    /**
     *
     */
    private function set_arguments( $args ){

        $defaults = array(
            'action'     => '',
            'callback'   => '',
        );

        return wp_parse_args( $args, $defaults);
    }

    /**
     * @todo  actions for front end requests wp_ajax_nopriv_
     */
    public function add_actions(){

        if( $this->args['callback'] != '') {
            add_action( 'wpajaxrequest_callback_' . $this->args['action'] , $this->args['callback'] );
        }

        if( $this->args['action'] != '') {
            add_action( 'wp_ajax_' . $this->args['action'] , array( $this, 'request_handler') );
        }

    }

    /**
     * @todo  handle error messages
     */
    public function request_handler(){

        if( $this->_security->check() ){

            $this->do_callback();
            return;

        } else {

            $this->_data_handler->add_data( array(
                'success' => false,
                'error_message' => 'no no no',
            ));

            return $this->_data_handler->load_output();
        }
    }

    /**
     *
     */
    public function do_callback(){

        $posted = array();

        if( isset( $_POST['data'] ) ){
            wp_parse_str( $_POST['data'], $posted );
        }

        $this->_data_handler->set_data( $posted );
        $this->_data_handler->add_data( array('success' => true) );

        // Users Callback
        do_action('wpajaxrequest_callback_' . $this->args['action'], $this->_data_handler->load_output() );

        if( $this->args['callback'] === '' ) echo $this->_data_handler->load_output();
    }



}