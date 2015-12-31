<?php

class SerializedArray implements OutputInterface {

    public function load( $data ){
        return maybe_serialize( $data );
    }
}