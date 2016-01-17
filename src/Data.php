<?php

/**
 * Handles the data.
 * Dependency on Output Interface
 *
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

class Data{

    public $data;
    public $output;

    /**
     *
     */
    public function __construct( OutputInterface $output = null ){

        $this->output = $output;
    }

    /**
     *
     */
    public function  set_data( $data ) {
        $this->data = $data;
    }

    /**
     *
     */
    public function  add_data( $args = array() ) {

        if( ! empty($args) && is_array( $args ) ) {

            foreach( $args as $key => $value ) {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     *
     */
    public function load_output(){

        if( $this->output === null ) {
            return $this->data;
        }

        if( $this->data !== null ){
            return $this->output->load( $this->data );
        }
    }



}