<?php

/**
 * Implementation of the Output interface
 * returns data as xml
 */


if( ! class_exists( 'XML' )){

class XML implements OutputInterface {

    public function load( $data ){

        // if( ! is_array( $data )) $data = (array) $data;
        // NEED TO  FORMAT DATA FOR WP_Ajax_Response();
        //
        // $xmlResponse = new WP_Ajax_Response($data);
        // return $xmlResponse->send();
    }
}

}