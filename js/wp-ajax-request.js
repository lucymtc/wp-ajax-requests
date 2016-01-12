
/**
 * WPAjaxRequest constructor
 * @param options
 */
var WPAjaxRequest = function( options ) {

	this.options = jQuery.extend({
		action: '',
		success: this.success,
		error: this.error,
		type: 'POST',
		dataType: 'json',
		url: ajaxurl,
		nonce: ''
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

	console.log( response );
    return;
}


/**
 * default error funcion
 * @return void
 */
WPAjaxRequest.prototype.error = function( response ) {

	console.log( response );
    return;
}