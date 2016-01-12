<?php

/**
 * Implementation of the Output interface
 * returns data as a serialized array
 */

if( ! class_exists( 'SerializedArray' )){

class SerializedArray implements OutputInterface {

    public function load( $data ){
        return maybe_serialize( $data );
    }
}

}