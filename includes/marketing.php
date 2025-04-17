<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Display admin notice for notification from yeken.uk
 */
function ws_ls_get_marketing_message() {
	
	if ( $cache = get_transient( '_yeken_weight_tracker_update' ) ) {
		return $cache;
	}

	$response = wp_remote_get( WE_LS_YEKEN_UPDATES_URL );

	// All ok?
	if ( 200 === wp_remote_retrieve_response_code( $response ) ) {

		$body = wp_remote_retrieve_body( $response );

		if ( false === empty( $body ) ) {

			$body = json_decode( $body, true );
			
			set_transient( '_yeken_weight_tracker_update', $body, HOUR_IN_SECONDS );

			return $body;
		}
	}

	return NULL;
}

/**
 * Get/Set key of notice last dismissed.
 */
function ws_ls_marketing_update_key_last_dismissed( $key = NULL ) {
	
	if ( NULL !== $key ) {
		update_option( '_yeken_weight_tracker_update_key_last_dismissed', $key );
	}
	
	return get_option( '_yeken_weight_tracker_update_key_last_dismissed' ) ;

}

/**
 * Display HTML for admin notice
 */
function ws_ls_updates_display_notice( $json ) {

	if ( false === is_array( $json ) ) {
		return;
	}

	$button = '';

	if ( !empty( $json[ 'url'] ) && !empty( $json[ 'url-title' ] ) ) {
		$button = sprintf( '<p>
								<a href="%1$s" class="button button-primary" target="_blank" rel="noopener">%2$s</a>
							</p>',
							esc_url( $json[ 'url' ] ),
							ws_ls_wp_kses( $json[ 'url-title' ] )
		);
	}
				

    printf('<div class="updated notice is-dismissible ws-ls-update-notice" data-update-key="%4$s" data-nonce="%5$s">
                        <p><strong>%1$s</strong>: %2$s.</p>
                       	%3$s
                    </div>',
                    esc_html( WE_LS_TITLE ),
                    !empty( $json[ 'message' ] ) ? esc_html( $json[ 'message' ] ) : '',
                    $button,
					esc_html( $json[ '_update_key' ] ),
					esc_attr( wp_create_nonce( 'ws-ls-nonce' ) )
    );
}

 /**
  * display and admin notice if one exists and hasn't been dismissed already.
  */
function ws_ls_updates_admin_notice() {
   
	$json = ws_ls_get_marketing_message();

	if ( $json[ '_update_key' ] <> ws_ls_marketing_update_key_last_dismissed() ) {
	
		ws_ls_updates_display_notice( $json );
	}
}
add_action( 'admin_notices', 'ws_ls_updates_admin_notice' );

 /**
  * Ajax handler to dismiss setup wizard
  */
 function ws_ls_updates_ajax_dismiss() {
 
	check_ajax_referer( 'ws-ls-nonce', 'security' );
 
	$update_key = sanitize_text_field( ws_ls_post_value( 'update_key' ) );

	if ( false === empty( $update_key ) ) {
		ws_ls_marketing_update_key_last_dismissed( $update_key );
	}
 }
 add_action( 'wp_ajax_ws_ls_dismiss_notice', 'ws_ls_updates_ajax_dismiss' );

/**
 * Render a list of features
 * @param array features
 * @param bool $echo
 * @param string $format 'table' or 'ul' or 'markdown'
 */
function ws_ls_display_features( $features, $echo = true, $format = 'table'  ) {

	if ( true === empty( $features ) ) {
		return;
	}

	switch( $format ) {
		case 'table':
			$html = '';
			break;
		case 'ul':
			$html = '';
			break;
		default:
			$html = '';
	}

	$html = 'table' === $format ? '<table class="form-table yk-mt-features-table">' : '<ul>';

	$class = '';

	foreach ( $features as $feature ) {

		$class 	= ('alternate' == $class) ? '' : 'alternate';

		switch( $format ) {
			case 'table':
				$html_template = '<tr class="%1$s">
										<td>
											&middot; <strong>%2$s</strong> - %3$s
										</td>
									</tr>';
				break;
			case 'ul':
				$html_template = '<li><strong>%2$s</strong> - %3$s</li>';
				break;
			default:	
				$html_template = '* **%2$s** - %3$s' . PHP_EOL;
		}

		$row 	= sprintf( 	$html_template,
							$class,
							$feature[ 'title' ],
							$feature[ 'description' ] );

		$html .= $row;
	}	

	switch( $format ) {
		case 'table':
			$html .= '</table>';
			break;
		case 'ul':
			$html .= '</ul>';
			break;
		default:
			$html .= '';
	}

	if ( false === $echo ) {
		return $html;
	}

	ws_ls_echo_wp_kses( $html );	
}

/**
 * Render a list of features
 * @param array features
 */
function ws_ls_shortcode_display_features() {
	return ws_ls_display_features( ws_ls_feature_list_pro(), false, 'ul' );
}
add_shortcode( 'wt-features-table', 'ws_ls_shortcode_display_features' );

/**
 * Render a list of pro features
 * @param array features
 */
function ws_ls_shortcode_display_pro_features() {
	return ws_ls_display_features( ws_ls_feature_list_pro_plus(), false, 'ul' );
}
add_shortcode( 'wt-pro-features-table', 'ws_ls_shortcode_display_pro_features' );

/**
 * Display WP Version
 * @return text
 */
function ws_ls_shortcode_version() {
	return esc_html( WE_LS_CURRENT_VERSION );
}
add_shortcode( 'wt-version', 'ws_ls_shortcode_version' );

// add_action( 'init', function() {
// 	ws_ls_display_features(  ws_ls_feature_list_premium(), true, $format = 'markdown'  );
// 	die;
// });