# WP Ajax Requests

Helper to handle Ajax requests in WordPress.

### Features

- Handles security checks, like user capabilities and nonce verifications.
- Takes care of the communication with WordPress adding the required action hooks.
- Has front end support which enqueues scripts, localize and takes care of sending the ajax request.
- Handles data output with options to choose the format type (json, serialized array...)

### Usage

To get it going you need to include the file that will build the final object:
```
require_once SOME_PATH . 'wp-ajax-requests/request.php';
```
Then you would create a new instance of WPAjaxRequest `new WPAjaxRequest()` passing in some arguments.
For example:

```php
$args = array(
        'action'     => 'my_action',
        'callback'   => 'my_callback',
        'nonce'      => 'my_nonce',
        'capability' => 'manage_options',
        'output'     => 'Json',
    );

new WPAjaxRequest( $args );
```
(All arguments explained bellow).

You would have to add your callback function.
This can be a function or a method of a class, which you would pass in like:
array('MyClass', 'my_method');

```php
function my_callback( $data ) {
    // do stuff
    echo $data;
}
```

Now you can use the JavaScript helper to send the request.
For example, if you are going to send the request on submit a form you onlye need to instantiate a new `WPAjaxRequest()` with some options,
then you would call it's method `send()` passing the data to be sent as a parameter.

```javascript
var request = new WPAjaxRequest({
	action: 'my_action',
	nonce: 'my_nonce'
});

myForm.on('submit', function(event){
	event.preventDefault();

	var data = myForm.serialize();
	request.send( data );

});

```
### Arguments

The arguments and it's defaults when calling `new WPAjaxRequest( $args );`:

```php
 $defaults = array(

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
        'front_script_src' => home_url( str_replace( ABSPATH, '', __DIR__ . '/js/wp-ajax-request.js') ),

        /**
         * The name of the variable which will contain the data for wp_localize_script().
         */
        'localize_name' => 'wpar',

    );
);
```
### Options JS

The options and it's defaults for the JavaScript object `WPAjaxRequest()`:

```javascript
		/**
		 * Required. The action name to create the custom handler for the wordpress hook.
		 * wp_ajax_(action), wp_ajax_nonpriv_(action)
		 */
		action: '',

		/**
		 *Request type. Default POST
		 */
		type: 'POST',

		/**
		 * Data type. Default json
		 */
		dataType: 'json',

		/**
		 * URL to send the request. Default the WordPress admin ajax url.
		 */
		url: ajaxurl,

		/**
		 * Action name to create the nonce wp_create_nonce().
		 * Security checks will run against this name.
		 * Same action name defined before. If not needed leave blank.
		 */
		nonce: '',

		/**
		 * Callback function if success on sending the request.
		 */
		success: this.success,

		/**
		 * Callback function if the request faild.
		 */
		error: this.error
```




