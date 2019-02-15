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

	$args = wp_parse_args( $args, [ 'slug' => NULL, 'format' => NULL, 'redirect' => NULL ] );

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
		return sh_cd_render_shortcode_presets( $args );
	}

	// Cached?
	$shortcode = sh_cd_get_cache( $args[ 'slug' ] );

	// If not in cache, hit the database!
	if ( false === empty( $shortcode ) ) {
		$shortcode = sh_cd_get_shortcode_by_slug( $args[ 'slug' ] );
	}

	// If still no reference to a shortcode then slug doesn't exist
	if ( true === empty( $shortcode ) ) {
		return '';
	}

	// Cache it!
	sh_cd_set_cache( $args[ 'slug' ], $shortcode );

	// Process other shortcodes within this one
	$shortcode = do_shortcode( $shortcode );

	// Replace placeholders with user defined parameters
	return sh_cd_apply_user_defined_parameters( $shortcode, $args );
}