<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Save / Insert a shortcode
 *
 * @return bool
 */
function sh_cd_shortcodes_save_post() {

	// Capture the raw $_POST fields, the save functions will process and validate the data
	$shortcode = sh_cd_get_values_from_post( [ 'id', 'slug', 'previous_slug', 'data', 'disabled', 'multisite' ] );

	return sh_cd_db_shortcodes_save( $shortcode );
}

/**
 * Replace user parameters within a shortcode e.g. look for %%parameter%% and replace
 *
 * @param $shortcode
 * @param $user_defined_parameters
 *
 * @return mixed
 */
function sh_cd_apply_user_defined_parameters( $shortcode, $user_defined_parameters ){

    // Ensure we have something to do!
    if ( true === empty( $user_defined_parameters ) || false === is_array( $user_defined_parameters ) ) {
        return $shortcode;
    }

    foreach ( $user_defined_parameters as $key => $value ) {
        $shortcode = str_replace( '%%' . $key . '%%', $value, $shortcode );
    }

	return $shortcode;
}

/**
 * Generate a unique slug
 *
 * @param $slug
 *
 * @return string
 */
function sh_cd_slug_generate( $slug, $exising_id = NULL ) {

    if ( true === empty( $slug ) ) {
        return NULL;
    }

	$slug = sanitize_title( $slug );

    $original_slug = $slug;

    $try = 1;

    // Ensure the slug is unique
    while ( false === sh_cd_slug_is_unique( $slug, $exising_id ) ) {

	    $slug = sprintf( '%s_%d', $original_slug, $try );

        $try++;
    }

    return $slug;
}

/**
 * Clone an existing shortcode!
 *
 * @param $id
 *
 * @return bool
 */
function sh_cd_clone( $id ) {

	if( false === sh_cd_license_is_premium() ) {
		return true;
	}

	if ( false === is_numeric( $id ) ) {
		return false;
	}

	$to_be_cloned = sh_cd_db_shortcodes_by_id( $id );

	if ( true === empty( $to_be_cloned ) ) {
		return false;
	}

	unset( $to_be_cloned['id'] );

	return sh_cd_db_shortcodes_save( $to_be_cloned );
}

/**
 * Display message in admin UI
 *
 * @param $text
 * @param bool $error
 */
function sh_cd_message_display( $text, $error = false ) {

    if ( true === empty( $text ) ) {
        return;
    }

    printf( '<div class="%s"><p>%s</p></div>',
            true === $error ? 'error' : 'updated',
            esc_html( $text )
    );

    //TODO: Hook this to use admin_notices
}

/**
 * Fetch cache item
 *
 * @param $key
 *
 * @return mixed
 */
function sh_cd_cache_get( $key ) {

    $key = sh_cd_cache_generate_key( $key );

    return get_transient( $key );
}

/**
 * Set cache item
 *
 * @param $key
 * @param $data
 */
function sh_cd_cache_set( $key, $data ) {

    $key = sh_cd_cache_generate_key( $key );

    set_transient( $key, $data, 1 * HOUR_IN_SECONDS );
}

/**
 * Delete cache for given shortcode slug / ID
 *
 * @param $slug_or_key
 */
function sh_cd_cache_delete_by_slug_or_key( $slug_or_key ) {

    if ( true === is_numeric( $slug_or_key ) ) {

	    $slug_or_key = sh_cd_db_shortcodes_get_slug_by_id( $slug_or_key );

        sh_cd_cache_delete( $slug_or_key );

    } else {
	    sh_cd_cache_delete( $slug_or_key );
    }

    // Delete site option
	$slug_or_key = SH_CD_PREFIX . $slug_or_key;

	delete_site_option( $slug_or_key );

}

/**
 * Delete cache item
 *
 * @param $key
 *
 * @return mixed
 */
function sh_cd_cache_delete( $key ) {

    $key = sh_cd_cache_generate_key( $key );

    return delete_transient( $key );
}

/**
 * Generate cache key
 *
 * @param $key
 *
 * @return string
 */
function sh_cd_cache_generate_key( $key ) {
    return SH_CD_SHORTCODE . $key;
}

/**
 * Return link to list own shortcodes
 *
 * @return mixed
 */
function sh_cd_link_your_shortcodes() {

	$link = admin_url('admin.php?page=sh-cd-shortcode-variables-your-shortcodes');

	return esc_url( $link );
}

/**
 * Return link to add own shortcode
 *
 * @return mixed
 */
function sh_cd_link_your_shortcodes_add() {

    $link = admin_url('admin.php?page=sh-cd-shortcode-variables-your-shortcodes&action=add');

    return esc_url( $link );
}

/**
 * Return link to edit own shortcode
 *
 * @return mixed
 */
function sh_cd_link_your_shortcodes_edit( $id ) {

	$link = admin_url('admin.php?page=sh-cd-shortcode-variables-your-shortcodes&action=edit&id=' . (int) $id );

	return esc_url( $link );
}

/**
 * Return link to delete own shortcode
 *
 * @return mixed
 */
function sh_cd_link_your_shortcodes_delete( $id ) {

	$link = admin_url('admin.php?page=sh-cd-shortcode-variables-your-shortcodes&action=delete&id=' . (int) $id );

	return esc_url( $link );
}

/**
 * Either fetch data from the $_POST object or from the array passed in!
 *
 * @param $object
 * @param $key
 * @return string
 */
function sh_cd_get_value_from_post_or_obj( $object, $key ) {

	if ( true === isset( $_POST[ $key ] ) ) {
		return $_POST[ $key ];
	}

	if ( true === isset( $object[ $key ] ) ) {
		return $object[ $key ];
	}

	return '';
}

/**
 * Either fetch data from the $_POST object for the given object keys
 *
 * @param $meta_field
 * @return string
 */
function sh_cd_get_values_from_post( $keys ) {

	$data = [];

	foreach ( $keys as $key ) {

		if ( true === isset( $_POST[ $key ] ) ) {
			$data[ $key ] = $_POST[ $key ];
		} else {
			$data[ $key ] = '';
		}

	}

	return $data;
}

/**
 * Toggle the status of a shortcode
 *
 * @param $id
 */
function sh_cd_toggle_status( $id ) {

	$slug = sh_cd_db_shortcodes_by_id( (int) $id );

	if ( false === empty( $slug ) ) {

	    $status = ( 1 === (int) $slug['disabled'] ) ? 0 : 1 ;

		sh_cd_db_shortcodes_update_status( $id, $status );

	    return $status;
    }

	return NULL;
}

/**
 * Toggle the multisite of a shortcode
 *
 * @param $id
 */
function sh_cd_toggle_multisite( $id ) {

	$slug = sh_cd_db_shortcodes_by_id( (int) $id );

	if ( false === empty( $slug ) ) {

		$multisite = ( 1 === (int) $slug['multisite'] ) ? 0 : 1 ;

		sh_cd_db_shortcodes_update_multisite( $id, $multisite );

		return $multisite;
	}

	return NULL;
}


/**
 * Display a table of premade shortcodes
 *
 * @param string $display
 */
function sh_cd_display_premade_shortcodes( $display = 'all' ) {

	$premium_user = sh_cd_license_is_premium();
	$upgrade_link = sprintf( '<a class="button" href="%s"><i class="fas fa-check"></i> Upgrade now</a>', sh_cd_license_upgrade_link() );

	switch ( $display ) {
		case 'free':
			$shortcodes = sh_cd_shortcode_presets_free_list();
			$show_premium_col = false;
			break;
		case 'premium':
			$shortcodes = sh_cd_shortcode_presets_premium_list();
			$show_premium_col = false;
			break;
		default:
			$shortcodes = sh_cd_presets_both_lists();
			$show_premium_col = true;
	}

	$html = '<table class="widefat sh-cd-table" width="100%">
                <tr class="row-title">
                    <th class="row-title" width="30%">Shortcode</th>';

                     if ( true === $show_premium_col) {
	                     $html .= '<th class="row-title">Premium</th>';
                     }

	                $html .= '<th width="*">Description</th>
                </tr>';

		$class = '';

		foreach ( $shortcodes as $key => $data ) {

			$class = ($class == 'alternate') ? '' : 'alternate';

			$shortcode = '[' . SH_CD_SHORTCODE. ' slug="' . $key . '"]';

			$premium_shortcode = ( true === $data['premium'] );

			$html .= sprintf( '<tr class="%s"><td>%s</td>', $class, esc_html( $shortcode ) );


            if ( true === $show_premium_col) {

                $html .= sprintf( '<td align="middle">%s%s</td>',
                    ( true === $premium_shortcode && true === $premium_user ) ? '<i class="fas fa-check"></i>' : '',
                    ( true == $premium_shortcode && false === $premium_user ) ? $upgrade_link : ''
                );
            }

			$html .= sprintf( '<td>%s</td></tr>', wp_kses_post( $data['description'] ) );

        }

    $html .= '</table>';

	return $html;
}

/**
 * Display an upgrade button
 */
function sh_cd_upgrade_button( $css_class = '', $link = NULL ) {

    $link = ( false === empty( $link ) ) ? $link : SH_CD_UPGRADE_LINK . '?hash=' . sh_cd_generate_site_hash() ;

	echo sprintf('<a href="%s" class="button-primary sh-cd-upgrade-button%s"><i class="far fa-credit-card"></i> %s £%d %s</a>',
		esc_url( $link ),
		esc_attr( ' ' . $css_class ),
        __('Upgrade to Premium for ', SH_CD_SLUG),
		SH_CD_PREMIUM_PRICE,
		__('a year ', SH_CD_SLUG)
	);
}