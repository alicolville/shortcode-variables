<?php

defined('ABSPATH') or die('Jog on!');

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
function sh_cd_slug_generate( $slug ) {

    if ( true === empty( $slug ) ) {
        return NULL;
    }

	$slug = sanitize_title( $slug );

    $original_slug = $slug;

    $try = 1;

    // Ensure the slug is unique
    while ( false === sh_cd_slug_is_unique( $slug ) ) {

	    $slug = sprintf( '%s_%d', $original_slug, $try );

        $try++;
    }

    return $slug;
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

        sh_cd_cache_delete( sh_cd_db_shortcodes_get_slug_by_id( $slug_or_key ) );

    } else {
	    sh_cd_cache_delete( $slug_or_key );
    }
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