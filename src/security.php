<?php

class Security{

    private $_capability;
    private $_nonce;

    public $success = false;

    /**
     *
     */
    public function __construct( $nonce, $capability = null){

        $this->_nonce = $nonce;
        $this->_capability = $capability;
    }


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

}