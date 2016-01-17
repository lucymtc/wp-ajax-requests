<?php

/**
 * Strategy pattern. The output type can be swaped.
 *
 * @package Lucymtc\WPAjaxRequest
 */

namespace Lucymtc\WPAjaxRequest;

interface OutputInterface {

    public function load( $data );
}


