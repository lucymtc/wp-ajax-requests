# WP Ajax Requests
Library to handle ajax requests made in WordPress

It handles communication with WordPress, security checks and data output giving the option to choose output type.

### Usage 

For example from a plugin.

Include all the files:

```
require plugin_dir_path( __FILE__ ) . 'inc/wp-ajax-requests/class-security.php';
require plugin_dir_path( __FILE__ ) . 'inc/wp-ajax-requests/class-output.php';
require plugin_dir_path( __FILE__ ) . 'inc/wp-ajax-requests/class-data-handler.php';
require plugin_dir_path( __FILE__ ) . 'inc/wp-ajax-requests/wp-ajax-request.php';
```

Define a list of arguments for the action, nonce, callback function and capability to check. 

```
function add_requests() {


    $security = new Security();
    $data_handler = new DataHandler( new JsonOutput() );

    $args = array(
        'action'     => 'my_action',
        'nonce'      => 'my_nonce',
        'callback'   => 'my_callback',
        'capability' => 'manage_options',
        );

    new WPAjaxRequest( $args, $security, $data_handler);

}
```

Callback function will be fired if all the security checks pass correctly.

```
function my_callback( $data ) {
       // do stuff
}

```