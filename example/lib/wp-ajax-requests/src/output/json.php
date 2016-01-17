<?php

/**
 * Implementation of the Output interface
 * returns data as json
 *
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

class Json implements OutputInterface {

    public function load( $data ){
        return wp_json_encode( $data );
    }
}
