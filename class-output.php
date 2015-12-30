<?php

interface OutputInterface {

    public function load( $data );
}

class SerializedArrayOutput implements OutputInterface {

    public function load( $data ){
        return maybe_serialize( $data );
    }
}

class JsonOutput implements OutputInterface {

    public function load( $data ){
        return wp_json_encode( $data );
    }
}

/**
 * @todo need to format data to use properly WP_Ajax_Response
 */
class XMLOutput implements OutputInterface {

    public function load( $data ){

        // if( ! is_array( $data )) $data = (array) $data;

        // $xmlResponse = new WP_Ajax_Response($data);
        // return $xmlResponse->send();
    }
}
