
/**
 * WPAjaxRequest constructor
 * @param options
 */
var WPAjaxRequest = function( options ) {

	this.options = jQuery.extend({

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

	}, options);

}

/**
 * send Sends the request
 * @return void
 */
WPAjaxRequest.prototype.send = function( data ) {

	jQuery.ajax({
			url: this.options.url,
			type: this.options.type,
			dataType: this.options.dataType,
			data: {
				data: data,
				action : this.options.action,
				nonce : wpar.nonces[ this.options.nonce ]
				},
			success: this.options.success,
			error: this.options.error
		});
}

/**
 * default success funcion
 * @return void
 */
WPAjaxRequest.prototype.success = function( response ) {
	console.log(response);
	return;
}


/**
 * default error funcion
 * @return void
 */
WPAjaxRequest.prototype.error = function( response ) {
	console.log(response);
	return;
}