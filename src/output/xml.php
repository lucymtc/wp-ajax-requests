<?php

/**
 * Implementation of the Output interface
 * returns data as xml
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

class XML implements OutputInterface {

    public function load( $data ){

        // if( ! is_array( $data )) $data = (array) $data;
        // NEED TO  FORMAT DATA FOR WP_Ajax_Response();
        //
        // $xmlResponse = new WP_Ajax_Response($data);
        // return $xmlResponse->send();
    }
}