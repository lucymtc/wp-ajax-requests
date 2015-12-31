<?php

class Json implements OutputInterface {

    public function load( $data ){
        return wp_json_encode( $data );
    }
}