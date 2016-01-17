<?php
/**
 * WPAjaxRequest Simple factory
 */

if( ! class_exists( 'WPAjaxRequest' )){

class WPAjaxRequest {

	public $args;

	/**
	 * constructor
	 * @param object Final WPAjaxRequest object created by the method create
	 */
	public function __construct( $args ) {

		$this->set_defaults();
		$this->args = wp_parse_args( $args, $this->args );

		return $this->build();

	}

	/**
	 * set_defaults Set default argumens
	 */
	public function set_defaults(){

		$this->args = array(

        /**
         * Required. The action name to create the custom handler for the wordpress hook.
         * wp_ajax_(action), wp_ajax_nonpriv_(action)
         */
        'action' => '',

        /**
         * Callback function defined by the user to run if the request
         * is valid and passes the security checks.
         */
        'callback' => '',

        /**
         * Action name to create the nonce wp_create_nonce().
         * Security checks will run against this name.
         * If left as null, the nonce verification won't take place.
         */
        'nonce' => null,

        /**
         * Security checks will run against this capability. For example: manage_options
         */
        'capability' => null,

        /**
         * Data output format. Possible values Json, SerializedArra, XML.
         */
        'output' => 'Json',

        /**
         * If set to false, the support for the front end will not be used.
         * The user will need to enqueue scripts and send request manually.
         */
        'use_front' => true,

        /**
         * Name used as a handle for the script in wp_enqueue_script()
         */
        'front_script_handle' => 'wpajaxrequest-script',

        /**
         * You may replace the script responsible to send the request by changing
         * the default path to your own script.
         */
        'front_script_src' => home_url( str_replace( ABSPATH, '', dirname(__DIR__) . '/js/wp-ajax-request.js') ),

        /**
         * The name of the variable which will contain the data for wp_localize_script().
         */
        'localize_name' => 'wpar',

 		);
	}

	/**
	 * create
	 * @return object Final WPAjaxRequest object
	 */
  public function build() {

  	$security = new Security( $this->args['nonce'], $this->args['capability'] );
    $data_handler = new Data( new $this->args['output']() );

    if( $this->args['use_front'] ) {
        $front_handler = new Front( $this->args['front_script_handle'], $this->args['front_script_src'], $this->args['localize_name']);
    } else {
        $front_handler = null;
    }

    return new Handler( $this->args['action'], $this->args['callback'], $security, $data_handler, $front_handler);
  }

}
}