<?php

/**
 * Handles the front end enqueing required scripts.
 *
 * Options to set different script and enqueue key name.
 */

if( ! class_exists( 'Front' )){

class Front{


    private $_script_handle = null;
    private $_script_url = null;
    private $_localize_name = null;

    private $_nonce = array();
    private $_extra_data = array();

    /**
     *
     */
    public function __construct( $script_handle = '', $script_url = '', $localize_name = '' ){

        $this->_script_handle = $script_handle;
        $this->_script_url = $script_url;
        $this->_localize_name = $localize_name;

        $this->add_actions();
    }


    /**
     * add_actions Adds the actions to enqueue the scripts
     */
    public function add_actions() {

        add_action( 'wp_enqueue_scripts',    array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    }

    /**
     * enqueue_scripts Enqueue and localize the required scripts to run ajax requests.
     * @return void
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->_script_handle, $this->_script_url, array('jquery'), '1.0', true );

        $localize_data = $this->get_localize_script_data();
        wp_localize_script($this->_script_handle, $this->_localize_name, $localize_data);

    }

    /**
     * localize_script Creates the data to wp_localize_script
     *
     * WordPress handles correctly wp_enqueue_script avoiding duplication
     * on enqueueing scripts. But wp_localize script does localize the same
     * values as many times as it's called for the same script.
     *
     * WP doesn't provide a filter to alter the data passed into an existing
     * wp_localize_script. This method will add data to an existing wp_localize_script
     * avoiding duplication.
     *
     * without this the output would be like:
     * var wpajaxrequest = {"nonces":{"my_nonce":"some_value"}};
     * var wpajaxrequest = {"nonces":{"my_second_nonce":"some_value"}};
     *
     * with the function the result is:
     * var wpajaxrequest = {"nonces":{"my_nonce":"some_value","my_second_nonce":"some_value"}};
     *
     * @return void
     */

    public function get_localize_script_data(){

        global $wp_scripts;

        // Get the localized data appended to the given script handle
        $data = $wp_scripts->get_data( $this->_script_handle, 'data' );

        // If empty data setup the data.
        if( empty( $data ) ) {

            return $this->first_localize_data_setup();

        } else {

             // Convert the localized script data in usabale data from its JSON format
            if( ! is_array( $data ) ) {
                $data = json_decode(str_replace('var '. $this->_localize_name .' = ', '', substr($data, 0, -1)), true);
            }

            // Rebuild the data array.
            // Add the new nonce to the existing nonce list from other requests.
            if( ! empty( $data ) ) {

                 foreach( $data as $key => $value ) {
                    $localized_data[$key] = $value;
                 }

                 if( isset( $localized_data['nonces'] ) && ! empty($this->_nonce)) {

                        $nonce_key = key($this->_nonce);
                        $localized_data['nonces'][ $nonce_key ] = $this->_nonce[ $nonce_key ];
                }
            }

            //empty existing localized data before localize the new rebuilt.
            $wp_scripts->add_data($this->_script_handle, 'data', '');

            return $localized_data;
       }
    }

     /**
     * first_localize_data_setup Sets up the first data structure to localize script
     * @return array
     */
    public function first_localize_data_setup() {

        $data = array();

        if( ! empty( $this->_nonce ) ) {
            $data[ 'nonces' ] = $this->_nonce;
        }

        if( ! empty( $this->_extra_data ) ) {

            foreach( $this->_extra_data as $key => $value ) {
                $data[ $key ] = $value;
            }
        }

        return $data;
    }

     /**
     * create_nonce Adds a nonce to $this->_nonce
     * @todo  check if nonce exists in the list and alert the user the nonce is already been used.
     *
     * @return void
     */
    public function create_nonce( $nonce ) {

        $nonce = sanitize_key( $nonce );
        $this->_nonce[ $nonce ] = wp_create_nonce( $nonce );
    }

    /**
     * get_nonce Returns the nonce list
     * @return $_nonce array
     */
    public function get_nonce() {
        return $this->_nonce;
    }

    /**
     * add_localized_data
     * @param array $data Add extra data to add to wp_localize_script
     * @return void
     *
     * @todo alert user if data isn't array.
     */

    public function add_extra_data( $data ) {

        if( is_array( $data ) ) {
            foreach( $data as $key => $value ) {
                $this->_extra_data[ sanitize_key($key) ] = $value;
            }
        }
    }

    /**
     * get_extra_data
     * @todo  get extra data added by the user
     *
     * @return void
     */
    public function get_extra_data() {
        return $this->_extra_data;
    }

}

}


