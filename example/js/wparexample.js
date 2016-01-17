/**
 * WPAjaxRequest example
 * @since 1.0
 */

jQuery(document).ready(function($) {

    var request = new WPAjaxRequest({
        action: 'wparexample_action',
        nonce: 'wparexample_nonce'
    });

    var form = $('#wparexample-form');

    form.on('submit', function(event){
        event.preventDefault();
        event.stopPropagation();

        var data = form.serialize();
        request.send( data );

    });

});