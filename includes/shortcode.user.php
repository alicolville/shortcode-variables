<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Render the main user defined shortcode [sv]
 *
 * @param $args
 *
 * @return bool|mixed|string
 */
function sh_cd_shortcode( $args ) {

	$args = wp_parse_args( $args, [ 'slug' => NULL ] );

	return sh_cd_shortcode_render( $args );
}
add_shortcode( SH_CD_SHORTCODE, 'sh_cd_shortcode' );
add_shortcode( 'shortcode-variables', 'sh_cd_shortcode' );  // Backwards compatibility
add_shortcode( 's-var', 'sh_cd_shortcode' );                // Backwards compatibility

/**
 * Process the shortcode and render
 *
 * @param $args
 *
 * @return mixed|string
 */
function sh_cd_shortcode_render( $args ) {

	// Have a slug?
	if ( true === empty( $args[ 'slug' ] ) ) {
		return '';
	}

	// Preset shortcode?
	if ( false !== sh_cd_is_preset( $args[ 'slug' ] ) ) {
		return sh_cd_shortcode_presets_render( $args );
	}

	// Cached?
	$shortcode = sh_cd_cache_get( $args[ 'slug' ] );

	// If not in cache, hit the database!
	if ( false === $shortcode ) {

		$shortcode = sh_cd_db_shortcodes_by_slug( $args[ 'slug' ] );

		// Cache it! If a multisite, only cache the shortcode for 30 seconds. Otherwise, fall back to default cache time.
		$cache_time = ( true === SH_CD_IS_PREMIUM && true === in_array( $args[ 'slug' ], sh_cd_multisite_slugs() ) ) ? 30 : NULL;

		sh_cd_cache_set( $args[ 'slug' ], $shortcode, $cache_time );

	}

	// If still no reference to a shortcode then slug doesn't exist
	if ( true === empty( $shortcode ) ) {
		return '';
	}

	// Process other shortcodes within this one
	$shortcode = do_shortcode( $shortcode );

	// Replace placeholders with user defined parameters
	return sh_cd_apply_user_defined_parameters( $shortcode, $args );
}
