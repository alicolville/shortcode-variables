<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Display admin notice for notification from yeken.uk
 */
function sh_cd_get_marketing_message() {
	
	if ( $cache = get_transient( '_yeken_shortcode_variables_update' ) ) {
		return $cache;
	}

	$response = wp_remote_get( SH_CD_YEKEN_UPDATES_URL );

	// All ok?
	if ( 200 === wp_remote_retrieve_response_code( $response ) ) {

		$body = wp_remote_retrieve_body( $response );

		if ( false === empty( $body ) ) {

			$body = json_decode( $body, true );
			
			set_transient( '_yeken_shortcode_variables_update', $body, HOUR_IN_SECONDS );

			return $body;
		}
	}

	return NULL;
}

/**
 * Get/Set key of notice last dismissed.
 */
function sh_cd_marketing_update_key_last_dismissed( $key = NULL ) {
	
	if ( NULL !== $key ) {
		update_option( '_yeken_shortcode_variables_update_key_last_dismissed', $key );
	}
	
	return (int) get_option( '_yeken_shortcode_variables_update_key_last_dismissed' ) ;

}

/**
 * Display HTML for admin notice
 */
function sh_cd_updates_display_notice( $json ) {

	if ( false === is_array( $json ) ) {
		return;
	}

	$button = '';

	if ( !empty( $json[ 'url'] ) && !empty( $json[ 'url-title' ] ) ) {
		$button = sprintf( '<p>
								<a href="%1$s" class="button button-primary" target="_blank" rel="noopener">%2$s</a>
							</p>',
							esc_url( $json[ 'url' ] ),
							sh_cd_wp_kses( $json[ 'url-title' ] )
		);
	}
				

    printf('<div class="updated notice is-dismissible sh-cd-update-notice" data-update-key="%4$s" data-nonce="%5$s">
                        <p><strong>%1$s</strong>: %2$s</p>
                       	%3$s
                    </div>',
                    esc_html( SH_CD_PLUGIN_NAME ),
                    !empty( $json[ 'message' ] ) ? esc_html( $json[ 'message' ] ) : '',
                    $button,
					esc_html( $json[ '_update_key' ] ),
					esc_attr( wp_create_nonce( 'sh-cd-nonce' ) )
    );
}

 /**
  * display and admin notice if one exists and hasn't been dismissed already.
  */
function sh_cd_updates_admin_notice() {
   
	$json = sh_cd_get_marketing_message();

	if ( $json[ '_update_key' ] <> sh_cd_marketing_update_key_last_dismissed() ) {
	
		sh_cd_updates_display_notice( $json );
	}
}
add_action( 'admin_notices', 'sh_cd_updates_admin_notice' );

 /**
  * Ajax handler to dismiss setup wizard
  */
 function sh_cd_updates_ajax_dismiss() {
 
	check_ajax_referer( 'sh-cd-nonce', 'security' );
 
	if ( true === empty( $_POST[ 'update_key' ] ) ) {
		return;
	}

	$update_key = (int) $_POST[ 'update_key' ];

	if ( false === empty( $update_key ) ) {
		sh_cd_marketing_update_key_last_dismissed( $update_key );
	}
 }
 add_action( 'wp_ajax_sh_cd_dismiss_notice', 'sh_cd_updates_ajax_dismiss' );