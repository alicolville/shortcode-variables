<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Build database table
 */
function sh_cd_create_database_table() {

	global $wpdb;

	$table_name = $wpdb->prefix . SH_CD_TABLE;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  slug varchar(100) NOT NULL,
	  data text,
	  disabled bit default 0,
	  UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );
}

/**
 * Fetch all Shortcodes
 *
 * @return bool
 */
function sh_cd_db_shortcodes_all() {

	global $wpdb;

	return $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . SH_CD_TABLE . ' order by slug asc', ARRAY_A );
}

/**
 * Fetch a shortcode by ID (mainly used for quick lookups in admin)
 *
 * @param $id
 *
 * @return mixed
 */
function sh_cd_db_shortcodes_by_id( $id ) {

	global $wpdb;

	$sql = $wpdb->prepare('SELECT id, slug, data, disabled FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where id = %d', $id);

	return $wpdb->get_row( $sql, ARRAY_A );
}

/**
 * Fetch the content of the shortcode by slug
 *
 * @param $slug
 *
 * @return null|string
 */
function sh_cd_db_shortcodes_by_slug( $slug ) {

	global $wpdb;

	$sql = $wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where slug = %s and disabled <> 1', $slug);

	$row = $wpdb->get_var( $sql );

	return ( false === empty( $row ) ? stripslashes( $row ) : NULL );
}

/**
 * Get a Shortcode's slug from the slug ID
 *
 * @param $id
 *
 * @return bool
 */
function sh_cd_db_shortcodes_get_slug_by_id( $id ) {

	global $wpdb;

	$sql = $wpdb->prepare('SELECT slug FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where id = %d', $id);

	return $wpdb->get_var( $sql );
}

/**
 * Save / Insert a shortcode
 *
 * @param $shortcode
 *
 * @return bool
 */
function sh_cd_db_shortcodes_save( $shortcode ) {

	if ( false === is_admin() ) {
		return false;
	}

	$shortcode = wp_parse_args( $shortcode, [
		'id' => NULL,
		'slug' => NULL,
		'data' => NULL,
		'disabled' => 0
	]);

	// We need either a slug or an ID
	if ( true === empty( $shortcode['slug'] ) && true === empty( $shortcode['id'] ) ) {
		return false;
	}

	$shortcode['disabled'] = (int) $shortcode['disabled'];

	global $wpdb;

	$result = false;

	// Updating an existing shortcode?
	if ( false === empty( $shortcode['id'] ) && true === is_numeric( $shortcode['id'] ) ){

		// Once set, a slug cannot be updated.
		unset( $shortcode['slug'] );

		$formats = sh_cd_db_get_formats( $shortcode );

		$result = $wpdb->update(
			$wpdb->prefix . SH_CD_TABLE,
			$shortcode,
			[ 'id' => $shortcode['id'] ],
			$formats,
			[ '%d' ]
		);

		sh_cd_cache_delete_by_slug_or_key( $shortcode['id'] );

		// Adding a new shortcode
	} else {

		unset( $shortcode['id'] );

		// Ensure slug is santised and unique
		$shortcode['slug'] = sh_cd_slug_generate( $shortcode['slug'] );

		$formats = sh_cd_db_get_formats( $shortcode );

		$result = $wpdb->insert(
			$wpdb->prefix . SH_CD_TABLE,
			$shortcode,
			$formats
		);

		// It's an insert, so there should be no cache... however, just a wee sanity check in case
		// a shortcode with the same slug previously exists.
		sh_cd_cache_delete_by_slug_or_key( $shortcode['slug'] );
	}

	return ( false !== $result );
}

/**
 * Update a shortcode's status
 *
 * @param $shortcode
 *
 * @return bool
 */
function sh_cd_db_shortcodes_update_status( $id, $data ) {

	if ( false === is_admin() ) {
		return false;
	}

	global $wpdb;

	$result = $wpdb->update(
		$wpdb->prefix . SH_CD_TABLE,
		[ 'data' => $data ],
		[ 'id' => $id ],
		[ '%s' ],
		[ '%d' ]
	);

	sh_cd_cache_delete_by_slug_or_key( $id );

	return ( false !== $result );
}

/**
 * Update a shortcode's content
 *
 * @param $shortcode
 *
 * @return bool
 */
function sh_cd_db_shortcodes_update_content( $id, $status ) {

	if ( false === is_admin() ) {
		return false;
	}

	global $wpdb;

	$result = $wpdb->update(
		$wpdb->prefix . SH_CD_TABLE,
		[ 'disabled' => $status ],
		[ 'id' => $id ],
		[ '%d' ],
		[ '%d' ]
	);

	sh_cd_cache_delete_by_slug_or_key( $id );

	return ( false !== $result );
}


/**
 * Delete a shortcode
 *
 * @param $id
 *
 * @return bool
 */
function sh_cd_db_shortcodes_delete( $id ) {

	if ( false === is_admin() || false === is_numeric( $id ) ) {
		return false;
	}

	global $wpdb;

	// Clear cached version
	sh_cd_cache_delete_by_slug_or_key( $id );

	$result = $wpdb->delete( $wpdb->prefix . SH_CD_TABLE, [ 'id' => $id ], [ '%d' ] );

	return ( false !== $result );
}

/**
 * For a given key value array, look up and return the expected MySQL data formats.
 *
 * @param $data
 *
 * @return array
 */
function sh_cd_db_get_formats( $data ) {

	$lookup = [
		'id' => '%d',
		'slug' => '%s',
		'data' => '%s',
		'disabled' => '%d'
	];

	$formats = [];

	foreach ( $data as $key => $value ) {

		if ( false === empty( $lookup[ $key ] ) ) {
			$formats[] = $lookup[ $key ];
		}
	}

	return $formats;
}

/**
 * Check if the slug already exists
 *
 * @param $slug
 *
 * @return bool
 */
function sh_cd_slug_is_unique( $slug ) {

	if ( true === empty( $slug ) ) {
		return false;
	}

	global $wpdb;

	$sql = $wpdb->prepare( 'SELECT count(slug) FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where slug = %s', $slug );

	$row = $wpdb->get_var( $sql );

	return ( empty( $row ) );
}
