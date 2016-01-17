<?php

/**
 * Implementation of the Output interface
 * returns data as a serialized array
 *
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

class SerializedArray implements OutputInterface {

    public function load( $data ){
        return maybe_serialize( $data );
    }
}