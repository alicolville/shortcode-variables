jQuery( document ).ready(function ($) {

    /**
     * Show save button
     */
    $( '.inline-text-shortcode' ).bind('input propertychange', function( e ) {

        let id = $( this ).data( 'id' );

        sh_cd_save_button_reset( id );

        $( '#sh-cd-save-button-' + id ).removeClass( 'sh-cd-hide' );

    });

   /**
   * Show inline form
   */
    $( '.button-add-inline' ).on( 'click', function( e ) {
        $( '#sh-cd-add-inline' ).toggleClass( 'sh-cd-hide' );
    });

    /**
     * Save inline form
     */
    $( '#sh-cd-add-button' ).on( 'click', function( e ) {

      if ( '1' == sh_cd['premium'] ) {

        $( '#sh-cd-add-button' ).html('<i class="fas fa-spinner fa-spin"></i>' );

        let data = {};
        data['content']       = $( '#sh-cd-add-inline-text' ).val();
        data['slug']          = $( '#sh-cd-add-inline-slug' ).val();
        data['multisite']     = $( '#sh-cd-add-inline-global' ).is(':checked');
        data['enabled']       = $( '#sh-cd-add-inline-enabled' ).is(':checked');

        sh_cd_post_data_to_WP( 'add_shortcode', data, sh_cd_handle_add_shortcode );

      } else {
        sh_cd_promo();
      }
    });

    /**
     * Reset Add button state
     */
    $( '#sh-cd-add-inline-text, #sh-cd-add-inline-slug, #sh-cd-add-inline-global, #sh-cd-add-inline-enabled' ).bind('input propertychange', function( e ) {
      $( '#sh-cd-add-button' ).html('<i class="fas fa-save"></i> ' + sh_cd[ 'text-add' ])
    });

    /**
     * Handle add of shortcode
     * @param response
     * @param data
     */
    function sh_cd_handle_add_shortcode( response, data ) {

      if ( 1 == response.ok ) {

        if ( $( '#sh-cd-add-inline-clear' ).is(':checked') ) {
          $( '#sh-cd-add-inline-text' ).val( '' );
          $( '#sh-cd-add-inline-slug' ).val( '' );
          $( '#sh-cd-add-inline-global' ).prop( "checked", false )
          $( '#sh-cd-add-inline-enabled' ).prop( "checked", false )

          $( '#sh-cd-add-button' ).html('<i class="fas fa-check"></i> ' + sh_cd[ 'text-saved' ]);
        }

        $( '#sh-cd-add-inline-results' ).removeClass( 'sh-cd-hide' );

        let text = $( '#sh-cd-add-inline-results span' ).text();

        if ( '' !== text ) {
          text += ', ';
        }

        text += ' [sv slug="' + response.shortcode.slug + '"]';

        $( '#sh-cd-add-inline-results span' ).text( text );

      } else {
        alert( response.error_message );
      }
    }

    /**
     * Save inline shortcode changes
     */
    $( '.sh-cd-inline-save-button' ).on( 'click', function( e ) {

        if ( '1' == sh_cd['premium'] ) {

            let data = {};
            data['id'] = $( this ).data( 'id' );
            data['content'] = $( '#sh-cd-text-area-' + data['id'] ).val();

            $( '#sh-cd-save-button-' + data['id'] ).html('<i class="fas fa-spinner fa-spin"></i>' );

            sh_cd_post_data_to_WP( 'update_shortcode', data, sh_cd_handle_update_shortcode );

        } else {
            sh_cd_promo();
        }
    });

    /**
     * Delete shortcode
     */
    $( '.delete-shortcode' ).on( 'click', function( e ) {

        if ( false === confirm( sh_cd[ 'text-delete-confirm' ] ) ) {
          return;
        }

        let data = {};
        data['id'] = $( this ).data( 'id' );

        $( '#' + $( this ).attr( 'id' ) + ' i' ).removeClass( 'fa-trash-alt' ).addClass( 'fa-spinner fa-spin' );

        sh_cd_post_data_to_WP( 'delete_shortcode', data, sh_cd_handle_delete_shortcode );

    });

  /**
   * Handle deleting of shortcode
   * @param response
   * @param data
   */
  function sh_cd_handle_delete_shortcode( response, data ) {

    if ( 1 == response.ok ) {
      $( '#sh-cd-row-' + response.id ).remove();
    } else {
      $( '#sc-cd-delete-' + response.id + ' i' ).addClass( 'fa-trash-alt' ).removeClass( 'fa-spinner fa-spin' );
      alert( sh_cd[ 'text-error' ] );
    }
  }

    /**
     * Toggle shortcode status
     */
    $( '.toggle-disable' ).on( 'click', function( e ) {

        if ( '1' == sh_cd['premium'] ) {

            let data = {};
            data['id'] = $( this ).data( 'id' );

            $( '#' + $( this ).attr( 'id' ) + ' i' ).removeClass( 'fa-check' ).removeClass( 'fa-times' ).addClass( 'fa-spinner fa-spin' );

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

            let element_id = '#sc-cd-toggle-' + response.id + ' i';

            $( element_id ).removeClass( 'fa-spinner fa-spin' )

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

            let data = {};
            data['id'] = $( this ).data( 'id' );

            $( '#' + $( this ).attr( 'id' ) + ' i' ).removeClass( 'fa-check' ).removeClass( 'fa-times' ).addClass( 'fa-spinner fa-spin' );

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

            let element_id = '#sc-cd-multisite-' + response.id + ' i';

            $( element_id ).removeClass( 'fa-spinner fa-spin' )

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
      $( '#sh-cd-save-button-' + i ).html('<i class="fas fa-check"></i> ' + sh_cd[ 'text-saved' ]);
    }

    /**
     * Set save button to save
     * @param i
     */
    function sh_cd_save_button_reset( i ) {
      $( '#sh-cd-save-button-' + i ).html('<i class="fas fa-save"></i> ' + sh_cd[ 'text-save' ]);
    }

    /**
     * Post Data to ajax handler
     *
     * @param action
     * @param data
     * @param callback
     */
    function sh_cd_post_data_to_WP( action, data, callback ) {

        var post_data = {};
        post_data['action'] = action;
        post_data['security'] = sh_cd['security'];

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
    }

    /**
     * Show upgrade buttons
     */
    function sh_cd_show_upgrade_buttons() {
        $( '.sh-cd-upgrade-button' ).removeClass( 'sh-cd-hide' )
    }

});
