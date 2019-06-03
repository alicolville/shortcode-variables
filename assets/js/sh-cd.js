jQuery( document ).ready(function ($) {

    /**
     * Show save button
     */
    $( '.inline-text-shortcode' ).bind('input propertychange', function( e ) {

        var id = $( this ).data( 'id' );

        var element_id = '#sh-cd-save-button-' + id;

        sh_cd_save_button_reset( id );

        $( element_id ).removeClass( 'sh-cd-hide' );

    });

    /**
     * Save inline shortcode changes
     */
    $( '.sh-cd-inline-save-button' ).on( 'click', function( e ) {

        if ( '1' == sh_cd['premium'] ) {

            var data = {};
            data['id'] = $( this ).data( 'id' );
            data['content'] = $( '#sh-cd-text-area-' + data['id'] ).val();

            sh_cd_post_data_to_WP( 'update_shortcode', data, sh_cd_handle_update_shortcode );

        } else {
            sh_cd_promo();
        }
    });

    /**
     * Toggle shortcode status
     */
    $( '.toggle-disable' ).on( 'click', function( e ) {

        if ( '1' == sh_cd['premium'] ) {

            var data = {};
            data['id'] = $( this ).data( 'id' );

            sh_cd_post_data_to_WP( 'toggle_status', data, sh_cd_handle_toggle_disable );

        } else {
            sh_cd_promo();
        }
    });

    /**
     * Toggle status of a shortcode
     * @param response
     * @param data
     */
    function sh_cd_handle_toggle_disable( response, data ) {

        if ( 1 == response.ok ) {

            var element_id = '#sc-cd-toggle-' + response.id + ' i';

            if ( 1 == response.status ) {
                $( element_id ).removeClass( 'fa-check' );
                $( element_id ).addClass( 'fa-times' );
            } else {
                $( element_id ).removeClass( 'fa-times' );
                $( element_id ).addClass( 'fa-check' );
            }
        }
    }

    /**
     * Toggle multisite status
     */
    $( '.toggle-multisite' ).on( 'click', function( e ) {

        if ( '1' == sh_cd['premium'] ) {

            var data = {};
            data['id'] = $( this ).data( 'id' );

            sh_cd_post_data_to_WP( 'toggle_multisite', data, sh_cd_handle_toggle_multisite );

        } else {
            sh_cd_promo();
        }
    });

    /**
     * Toggle multiside of a shortcode
     * @param response
     * @param data
     */
    function sh_cd_handle_toggle_multisite( response, data ) {

        if ( 1 == response.ok ) {

            var element_id = '#sc-cd-multisite-' + response.id + ' i';

            if ( 0 == response.multisite ) {
                $( element_id ).removeClass( 'fa-check' );
                $( element_id ).addClass( 'fa-times' );
            } else {
                $( element_id ).removeClass( 'fa-times' );
                $( element_id ).addClass( 'fa-check' );
            }
        }
    }

    /**
     * Toggle status of a shortcode
     * @param response
     * @param data
     */
    function sh_cd_handle_update_shortcode( response, data ) {
        if ( 1 == response.ok ) {
            sh_cd_save_button_success( response.id );
        }
    }

    /**
     * Set save button to success
     * @param i
     */
    function sh_cd_save_button_success( i ) {

        var element_id = '#sh-cd-save-button-' + i;

        $( element_id ).html('<i class="fas fa-check"></i> Saved!');

    }

    /**
     * Set save button to save
     * @param i
     */
    function sh_cd_save_button_reset( i ) {

        var element_id = '#sh-cd-save-button-' + i;

        $( element_id ).html('<i class="fas fa-save"></i> Save');
    }

    /**
     * Post Data to ajax handler
     *
     * @param action
     * @param data
     * @param callback
     */
    function sh_cd_post_data_to_WP( action, data, callback ) {

        post_data = {};
        post_data['action'] = action;
        post_data['security'] = sh_cd['security'];

        // var post_data = $.merge(post_data, data);
        var post_data = obj3 = $.extend( post_data, data );

        $.post( ajaxurl, post_data, function( response, post_data ) {
            callback && callback( response, post_data );
        });
    }

    /**
     * Show Promo stuff
     */
    function sh_cd_promo() {
        sh_cd_show_upgrade_buttons();
        alert( 'Upgrade to Premium to enable this feature');
    }

    /**
     * Show upgrade buttons
     */
    function sh_cd_show_upgrade_buttons() {
        $( '.sh-cd-upgrade-button' ).removeClass( 'sh-cd-hide' )
    }

});
