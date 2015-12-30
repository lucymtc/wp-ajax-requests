<?php

class Security{

    private $_capability;
    private $_nonce;
    private $_action;

    public $success = false;

    /**
     *
     */
    public function __construct(){}


    /**
     *
     */
    public function check(){

        /////
        if( ! isset($_POST['nonce']) ) {
             return $this->success = false;
        }

        /////
        if( $this->_capability !== null ) {
            if ( ! current_user_can( $this->_capability ) ) {
                 return $this->success = false;
            }
        }

        /////
        if ( ! check_ajax_referer( $this->_nonce, 'nonce', false) ) {
                return $this->success = false;
        }

        return $this->success = true;
    }


    /**
     *
     */
    public function set_capability( $capability ) {
        $this->_capability = $capability;
    }

    /**
     *
     */
    public function set_action( $action ) {
        $this->_action = $action;
    }

    /**
     *
     */
    public function set_nonce( $nonce ) {
        $this->_nonce = $nonce;
    }
}