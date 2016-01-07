# WP Ajax Requests
This is an unfinished library. Made to handle ajax requests made in WordPress

It handles communication with WordPress, security checks and data output giving the option to choose output type.

### Usage

Include the file that will return the object.

```
require_once plugin_dir_path( __FILE__ ) . 'wp-ajax-requests/request.php';

```
Call wpar_request() setting the arguments, this function will return the final object.

```
$args = array(
        'action'     => 'my_action',
        'callback'   => 'my_callback',
        'nonce'      => 'my_nonce',
        'capability' => 'manage_options',
        'output'     => 'Json',
    );

wpar_request( $args );

```

Callback function will be fired if all the security checks pass correctly.

```
function my_callback( $data ) {
    // do stuff
    echo $data;
}

```
Note:
It needs a Sanitation object to handle sanitation of the data.