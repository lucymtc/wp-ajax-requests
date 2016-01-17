<?php

/**
 * Responsable for security checks.
 *
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

class Security{

    private $_capability;
    private $_nonce;
    private $_result;

    /**
     *
     */
    public function __construct( $nonce = null, $capability = null){

        $this->_nonce = $nonce;
        $this->_capability = $capability;
        $this->_result = new \stdClass();
    }


    /**
     * Steps of security checks
     * @return boolean
     */
    public function check(){

        /////
        if( $this->_nonce !== null && !isset($_POST['nonce']) ) {

            $this->_result->message = 'Nonce is required to be sent, in other case set nonce to null.';
            return false;
        }

        /////
        if( $this->_capability !== null ) {
            if ( ! current_user_can( $this->_capability ) ) {
                 $this->_result->message = 'User capability failed.';
                 return false;
            }
        }

        /////
        if ( ! check_ajax_referer( $this->_nonce, 'nonce', false) ) {
            $this->_result->message = 'Nonce verification failed';
            return false;
        }

        return true;
    }

    /**
     * @return object error data
     */
    public function get_error(){
        return wp_send_json_error($this->_result);
    }

     /**
     * @return nonce
     */
    public function get_nonce(){
        return $this->_nonce;
    }

}
