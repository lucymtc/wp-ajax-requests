<?php

/**
 * Implementation of the Output interface
 * returns data as json
 */


if( ! class_exists( 'Json' )){

class Json implements OutputInterface {

    public function load( $data ){
        return wp_json_encode( $data );
    }
}

}