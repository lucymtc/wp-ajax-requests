<?php
/*
Plugin Name: WPAjaxRequest Example
Description: This is a simple example of setting up WPAjaxRequest helper
Author: Lucy Tomás
Version: 1
*/

add_action( 'admin_enqueue_scripts', 'wparexample_enqueue' );
add_action( 'admin_menu',  'wparexample_add_menu');
add_action( 'admin_init',  'wparexample_add_requests');


require_once plugin_dir_path( __FILE__ ) . 'lib/wp-ajax-requests/request.php';

///////////////////////////////////////////////////////

function wparexample_add_requests() {

    $args = array(
        'action'     => 'wparexample_action',
        'callback'   => 'wparexample_callback',
        'nonce'      => 'wparexample_nonce',
    );

    wpar_request( $args );

}

function wparexample_callback( $data ) {

       echo $data;
}

///////////////////////////////////////////////////////


function wparexample_enqueue(){

    wp_enqueue_script( 'wparexample', plugin_dir_url( __FILE__ ) . 'js/wparexample.js', array('jquery'), 1 );
}

function wparexample_add_menu() {
   add_options_page('WPAjaxRequest Example', 'WPAjaxRequest Example', 'manage_options', 'wparexample-page', 'wparexample_page');
}


function wparexample_page(){

?>

<h2>Simple Example</h2>
<form id="wparexample-form">

    <label>Name</label>
    <input type="text" value="" name="name" id="name" />

    <button id="send" class="button-primary">Send</button>
 </form>

<?php
}


