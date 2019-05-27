<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Build admin menu
 */
function sh_cd_build_admin_menu() {

	add_menu_page( SH_CD_PLUGIN_NAME, SH_CD_PLUGIN_NAME, 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_pages_your_shortcodes', 'dashicons-editor-kitchensink' );

	// Hide duplicated sub menu (wee hack!)
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', '', '', 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_pages_your_shortcodes');

	// Add sub menus
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Your Shortcodes', SH_CD_SLUG ),  __('Your shortcodes'), 'manage_options', 'sh-cd-shortcode-variables-your-shortcodes', 'sh_cd_pages_your_shortcodes');
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Premade Shortcodes', SH_CD_SLUG ),  __('Premade shortcodes'), 'manage_options', 'sh-cd-shortcode-variables-sub-premade', 'sh_cd_premade_shortcodes_page');

	$menu_text = ( true === sh_cd_license_is_premium() ) ? __('Your License', SH_CD_SLUG ) : __('Upgrade to Premium', SH_CD_SLUG );

	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', $menu_text,  $menu_text, 'manage_options', 'sh-cd-shortcode-variables-license', 'sh_cd_advertise_pro');
}
add_action( 'admin_menu', 'sh_cd_build_admin_menu' );

/**
 * Enqueue relevant CSS / JS
 */
function sh_cd_enqueue_scripts() {
	wp_enqueue_style( 'sh-cd', plugins_url( '../assets/css/sh-cd.css', __FILE__ ), [], SH_CD_PLUGIN_VERSION ) ;
	wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', [], SH_CD_PLUGIN_VERSION);
	wp_enqueue_script( 'sh-cd', plugins_url( '../assets/js/sh-cd.js', __FILE__ ), [ 'jquery' ], SH_CD_PLUGIN_VERSION);

	wp_localize_script( 'sh-cd', 'sh_cd', [ 'security' => wp_create_nonce( 'sh-cd-security' ), 'premium' => sh_cd_license_is_premium() ] );

}
add_action( 'admin_enqueue_scripts', 'sh_cd_enqueue_scripts' );

/**
 * Run installer on each version number change or install
 */
function sh_cd_upgrade() {

	if ( true === update_option( 'sh-cd-version-number', SH_CD_PLUGIN_VERSION ) ) {
		sh_cd_create_database_table();
	}
}
add_action('admin_init', 'sh_cd_upgrade');


/**
	Ajax handler for toggling disable status of a shortcode
 **/
function sh_cd_ajax_toggle_status() {

	if ( false === sh_cd_license_is_premium() ) {
		wp_send_json( 'not-premium' );
	}

	check_ajax_referer( 'sh-cd-security', 'security' );

	$id = ( false === empty( $_POST['id'] ) ) ? (int) $_POST['id'] : NULL;

	if ( false === empty( $id ) ) {

		$new_status = sh_cd_toggle_status( $id );

		wp_send_json( [ 'id' => $id, 'status' => $new_status, 'ok' => 1 ] );
	}

	wp_send_json( 'shortcode-not-found' );
}
add_action( 'wp_ajax_toggle_status', 'sh_cd_ajax_toggle_status' );

/**
Ajax handler for toggling disable status of a shortcode
 **/
function sh_cd_ajax_toggle_multisite() {

	if ( false === sh_cd_license_is_premium() ) {
		wp_send_json( 'not-premium' );
	}

	check_ajax_referer( 'sh-cd-security', 'security' );

	$id = ( false === empty( $_POST['id'] ) ) ? (int) $_POST['id'] : NULL;

	if ( false === empty( $id ) ) {

		$new_multisite = sh_cd_toggle_multisite( $id );

		wp_send_json( [ 'id' => $id, 'multisite' => $new_multisite, 'ok' => 1 ] );
	}

	wp_send_json( 'shortcode-not-found' );
}
add_action( 'wp_ajax_toggle_multisite', 'sh_cd_ajax_toggle_multisite' );

/**
Ajax handler for saving shortcode inline
 **/
function sh_cd_ajax_update_shortcode() {

	if ( false === sh_cd_license_is_premium() ) {
		wp_send_json( 'not-premium' );
	}

	check_ajax_referer( 'sh-cd-security', 'security' );

	$id = ( false === empty( $_POST['id'] ) ) ? (int) $_POST['id'] : NULL;
	$content = ( false === empty( $_POST['content'] ) ) ? $_POST['content'] : '';

	if ( false === empty( $id ) ) {

		$result = sh_cd_db_shortcodes_update_content( $id, $content );

		wp_send_json( [ 'id' => $id, 'ok' => ( true === $result ) ? 1 : 0 ] );
	}

	wp_send_json( 'shortcode-not-found' );
}
add_action( 'wp_ajax_update_shortcode', 'sh_cd_ajax_update_shortcode' );