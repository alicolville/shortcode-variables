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

	if( false === SH_CD_IS_PREMIUM ) {
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
function sh_cd_cache_set( $key, $data, $expire = NULL ) {


	$expire = ( false === empty( $expire ) ) ? (int) $expire : 1 * HOUR_IN_SECONDS;

    $key = sh_cd_cache_generate_key( $key );

    set_transient( $key, $data, $expire );
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
    return SH_CD_SHORTCODE . SH_CD_PLUGIN_VERSION . $key;
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
 * @param $id
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
 * @param $keys
 * @return array
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
 * @return int|null
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
 * @return string
 */
function sh_cd_display_premade_shortcodes( $display = 'all' ) {

	$premium_user = SH_CD_IS_PREMIUM;
	$upgrade_link = sprintf( '<a class="button" href="%1$s"><i class="fas fa-check"></i> %2$s</a>', sh_cd_license_upgrade_link(), __('Upgrade now', SH_CD_SLUG ) );

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

	$html = sprintf('<table class="widefat sh-cd-table" width="100%%">
                <tr class="row-title">
                    <th class="row-title" width="30%%">%s</th>', __('Shortcode', SH_CD_SLUG ) );

                     if ( true === $show_premium_col) {
	                     $html .= sprintf( '<th class="row-title">%s</th>', __('Premium', SH_CD_SLUG ) );
                     }

					$html .= sprintf( '<th width="*">%s</th>
											</tr>', __('Description', SH_CD_SLUG ) );

	$class = '';

		foreach ( $shortcodes as $key => $data ) {

			$class = ($class == 'alternate') ? '' : 'alternate';

			$shortcode = '[' . SH_CD_SHORTCODE. ' slug="' . $key . '"]';

			$premium_shortcode = ( true === isset( $data['premium'] ) && true === $data['premium'] );

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
 *
 * @param string $css_class
 * @param null $link
 */
function sh_cd_upgrade_button( $css_class = '', $link = NULL ) {

    $link = ( false === empty( $link ) ) ? $link : SH_CD_UPGRADE_LINK . '?hash=' . sh_cd_generate_site_hash() ;

	echo sprintf('<a href="%s" class="button-primary sh-cd-upgrade-button%s"><i class="far fa-credit-card"></i> %s £%s %s</a>',
		esc_url( $link ),
		esc_attr( ' ' . $css_class ),
        __( 'Upgrade to Premium for ', SH_CD_SLUG ),
        esc_html( sh_cd_license_price() ),
		__( 'a year ', SH_CD_SLUG )
	);
}

/**
 * Is multsite functionality active for this install?
 *
 * @return bool
 */
function sh_cd_is_multisite_enabled() {

	if ( false === is_multisite() ) {
		return false;
	}

	if ( false === SH_CD_IS_PREMIUM ) {
		return false;
	}

	return true;
}

/**
 * Fetch all multisite slugs
 *
 * @return array|null
 */
function sh_cd_multisite_slugs() {

	if ( false === is_multisite() ) {
		return [];
	}

	$cache = sh_cd_cache_get( 'sh-cd-multisite-slugs' );

	if ( false !== $cache ) {
		return $cache;
	}

	$slugs = sh_cd_db_shortcodes_multisite_slugs();

	$slugs = ( false === empty( $slugs ) ) ? wp_list_pluck( $slugs, 'slug' ) : [];

	// Cache this for a short time
	sh_cd_cache_set( 'sh-cd-multisite-slugs', $slugs, 30 );

	return ( true === is_array( $slugs ) ) ? $slugs : [];
}

/**
 * Have we reached the limit of free shortcodes?
 * @return bool
 */
function sh_cd_reached_free_limit() {

	if ( true === SH_CD_IS_PREMIUM ) {
		return false;
	}

	$existing_shortcodes = sh_cd_db_shortcodes_count();

	if ( true === empty( $existing_shortcodes ) ) {
		return false;
	}

	return ( (int) $existing_shortcodes >= SH_CD_FREE_SHORTCODE_LIMIT );
}

/**
 * Get the minimum user role allowed for viewing data pages in admin
 * @return mixed|void
 */
function sh_cd_permission_role() {

	// If not premium, then admin only
	if ( false === SH_CD_IS_PREMIUM ) {
		return 'manage_options';
	}

	$permission_role = get_option( 'sh-cd-edit-permissions', 'manage_options' );

	return ( false === empty( $permission_role ) ) ? $permission_role : 'manage_options';
}

/**
 * Does the user have the correct permissions to view this page?
 */
function sh_cd_permission_check() {

	$allowed_viewer = sh_cd_permission_role();

	if ( false === current_user_can( $allowed_viewer ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', SH_CD_SLUG ) );
	}
}

/**
 * Is the shortcode [sv slug="sc-db-value-by-id"] enabled
 * @return bool (default false)
 */
function sh_cd_is_shortcode_db_value_by_id_enabled() {

    if ( false === SH_CD_IS_PREMIUM ) {
        return false;
    }

    // Disabling by filter overrides the setting in WP admin
    if ( true === apply_filters( 'disable-ss-sc-db-value-by-id', __return_false() ) ) {
        return false;
    }

    $value = get_option( 'sh-cd-shortcode-db-value-by-id-enabled', false );

    return sh_cd_to_bool( $value );
}

/**
 * Display upgrade notice
 *
 * @param bool $pro_plus
 */
function sh_cd_display_pro_upgrade_notice( ) {
	?>

	<div class="postbox sh-cd-advertise-premium">
		<h3 class="hndle"><span><?php echo __( 'Upgrade Snippet Shortcodes and get more features!', SH_CD_SLUG ); ?> </span></h3>
		<div style="padding: 0px 15px 0px 15px">
			<p><a href="<?php echo esc_url( admin_url('admin.php?page=sh-cd-shortcode-variables-license') ); ?>" class="button-primary"><?php echo __( 'Upgrade now', SH_CD_SLUG ); ?></a></p>
		</div>
	</div>

	<?php
}


/**
 * Process a CSV attachment and import into database
 *
 * @param $attachment_id
 *
 * @param bool $dry_run
 *
 * @return string
 */
function sh_cd_import_csv( $attachment_id, $dry_run = true ) {

	if ( false === sh_cd_permission_check() ) {
		return 'You do not have the correct admin permissions';
	}

	if ( false === SH_CD_IS_PREMIUM ) {
		return 'This is a premium feature';
	}

	$csv_path = get_attached_file( $attachment_id );
	$admin_id = get_current_user_id();

	if ( true === empty( $csv_path ) || false === file_exists( $csv_path )) {
		return 'Error: Error loading CSV from disk.';
	}

	$csv = array_map('str_getcsv', file( $csv_path ) );

	if ( true === empty( $csv ) ) {
		return 'Error: The CSV appears to be empty.';
	}

	array_walk($csv, function(&$a) use ($csv) {
		$a = array_combine($csv[0], $a);
	});

	$validate_header_result = sh_cd_import_csv_validate_header( $csv[0] );

	if ( true !== $validate_header_result ) {
		return $validate_header_result;
	}

	array_shift($csv );

	if ( true === empty( $csv ) ) {
		return 'Error: The CSV appears to be empty (when header hs been removed).';
	}

	$errors = 0;

	$output = sprintf( '%d rows to process...' . PHP_EOL, count( $csv ) );

	if ( true === $dry_run ) {
		$output .= 'DRY RUN MODE! No data will be imported.' . PHP_EOL;
	}

	foreach ( $csv as $row ) {

		if ( $errors >= 50 ) {
			$output .= 'Aborted! More than 50 errors have been detected in this file.' . PHP_EOL;
			break;
		}

		$row = array_change_key_case( $row ); // Force CSV headers to lowercase

		$validation_result = sh_cd_import_csv_validate_row( $row );

		// Validate a row before proceeding
		if ( true !== $validation_result ) {
			$output .= $validation_result . PHP_EOL;
			$errors++;
			continue;
		}

		if ( false === $dry_run ) {

			$shortcode = [	'slug' 			=> $row[ 'slug' ],
							'previous_slug' => '',
							'data' 			=> $row[ 'content' ],
							'disabled' 		=> ! sh_cd_to_bool( $row[ 'enabled' ] ),
							'multisite' 	=> sh_cd_to_bool( $row[ 'global' ] )
			];

			$result = sh_cd_db_shortcodes_save( $shortcode );

			if ( false === $result ) {
				$output .= 'Skipped: Error inserting into database (most likely a field contains too many characters or in the wrong format): ' .  implode( ',', $row ) . PHP_EOL;
			}
		}

	}

	if ( $errors > 0 ) {
		$output .= sprintf( '%d errors were detected and the rows skipped.' . PHP_EOL, $errors );
	}

	$output .= 'Completed.';

	return $output;

}

/**
 * Verify header row
 * @param $header_row
 *
 * @return bool|string
 */
function sh_cd_import_csv_validate_header( $header_row ) {

	$expected_headers = [ 'slug', 'content', 'global', 'enabled' ];

	foreach ( $expected_headers as $column ) {

		if ( false === isset( $header_row[ $column ] ) ) {
			return 'Missing column: ' . $column . '. Expecting: ' . implode( ',', $expected_headers ) . PHP_EOL;
		}
	}

	return true;
}

/**
 * Validate CSV row
 * @param $csv_row
 *
 * @return bool|string
 */
function sh_cd_import_csv_validate_row( $csv_row ) {

	if ( true === empty( $csv_row[ 'slug' ] ) ) {
		return 'Skipped: Missing slug: ' . implode( ',', $csv_row );
	}

	if ( false === empty( $isset[ 'content' ] ) ) {
		return 'Skipped: Content: ' . implode( ',', $csv_row );
	}

	$allowed_bools = [ 'yes', 'no', 'true', 'false', '1', '0' ];

	if ( true === empty( $csv_row[ 'global' ] ) ||
		 false === in_array( $csv_row[ 'global' ], $allowed_bools ) ) {
		return 'Skipped: Invalid "global" value. Must be "yes" or "no": ' . implode( ',', $csv_row );
	}

	if ( true === empty( $csv_row[ 'enabled' ] ) ||
		 false === in_array( $csv_row[ 'enabled' ], $allowed_bools ) ) {
		return 'Skipped: Invalid "enabled" value. Must be "yes" or "no": ' . implode( ',', $csv_row );
	}

	return true;
}

/**
 * Convert string to bool
 * @param $string
 * @return mixed
 */
function sh_cd_to_bool( $string ) {
	return filter_var( $string, FILTER_VALIDATE_BOOLEAN );
}