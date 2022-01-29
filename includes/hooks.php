<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Build admin menu
 */
function sh_cd_build_admin_menu() {

	$allowed_viewer = sh_cd_permission_role();

	add_menu_page( SH_CD_PLUGIN_NAME, SH_CD_PLUGIN_NAME, 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_pages_your_shortcodes', 'dashicons-editor-kitchensink' );

	// Hide duplicated sub menu (wee hack!)
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', '', '', 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_pages_your_shortcodes');

	// Add sub menus
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Your Shortcodes', SH_CD_SLUG ),  __( 'Your shortcodes', SH_CD_SLUG ), $allowed_viewer, 'sh-cd-shortcode-variables-your-shortcodes', 'sh_cd_pages_your_shortcodes');
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Premade Shortcodes', SH_CD_SLUG ),  __( 'Premade shortcodes', SH_CD_SLUG ), $allowed_viewer, 'sh-cd-shortcode-variables-sub-premade', 'sh_cd_premade_shortcodes_page');

	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Import shortcodes', SH_CD_SLUG ),  __( 'Import shortcodes', SH_CD_SLUG ), 'manage_options', 'sh-cd-import', 'sh_cd_admin_page_import' );

	$menu_text = ( true === SH_CD_IS_PREMIUM ) ? __( 'Your License', SH_CD_SLUG ) : __( 'Upgrade to Premium', SH_CD_SLUG );

	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', $menu_text,  $menu_text, 'manage_options', 'sh-cd-shortcode-variables-license', 'sh_cd_advertise_pro');
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Settings', SH_CD_SLUG ),  __( 'Settings', SH_CD_SLUG ), 'manage_options', 'sh-cd-settings', 'sh_cd_settings_page_generic' );
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __( 'Help', SH_CD_SLUG ),  __( 'Help', SH_CD_SLUG ), 'manage_options', 'sh-cd-help', 'sh_cd_help_page' );
}
add_action( 'admin_menu', 'sh_cd_build_admin_menu' );

/**
 * Enqueue relevant CSS / JS
 */
function sh_cd_enqueue_scripts() {
	wp_enqueue_style( 'sh-cd', plugins_url( '../assets/css/sh-cd.css', __FILE__ ), [], SH_CD_PLUGIN_VERSION ) ;
	wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', [], SH_CD_PLUGIN_VERSION);
	wp_enqueue_script( 'sh-cd', plugins_url( '../assets/js/sh-cd.js', __FILE__ ), [ 'jquery' ], SH_CD_PLUGIN_VERSION, true );

	wp_localize_script( 'sh-cd', 'sh_cd', sh_cd_js_config() );

}
add_action( 'admin_enqueue_scripts', 'sh_cd_enqueue_scripts' );

/**
 * Config for JS
 * @return array
 */
function sh_cd_js_config() {
	return [
				'security'                  => wp_create_nonce( 'sh-cd-security' ),
				'premium'                   => SH_CD_IS_PREMIUM,
				'text-delete-confirm'       => __( 'Are you sure you wish to delete this shortcode?', SH_CD_SLUG ),
				'text-add'                  => __( 'Add', SH_CD_SLUG ),
				'text-save'                 => __( 'Save', SH_CD_SLUG ),
				'text-saved'                => __( 'Saved!', SH_CD_SLUG ),
				'text-error'                => __( 'Unfortunately something went wrong!', SH_CD_SLUG )
	];
}

/**
 * Run installer on each version number change or install
 */
function sh_cd_upgrade() {

	if ( true === update_option( 'sh-cd-version-number-2021', SH_CD_PLUGIN_VERSION ) ) {

		sh_cd_create_database_table();

		sh_cd_create_database_table_multisite();

		sh_cd_cron_licence_check();

		do_action( 'sh-cd-upgrade' );
	}
}
add_action('admin_init', 'sh_cd_upgrade');


/**
	Ajax handler for toggling disable status of a shortcode
 **/
function sh_cd_ajax_toggle_status() {

	if ( false === SH_CD_IS_PREMIUM ) {
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
Ajax handler for deleting a shortcode
 **/
function sh_cd_ajax_delete_shortcode() {

	check_ajax_referer( 'sh-cd-security', 'security' );

	$id = ( false === empty( $_POST['id'] ) ) ? (int) $_POST['id'] : NULL;

	if ( false === empty( $id ) ) {

		$result = sh_cd_db_shortcodes_delete( $id );

		wp_send_json( [ 'id' => $id, 'ok' => $result ] );
	}

	wp_send_json( 'shortcode-not-found' );
}
add_action( 'wp_ajax_delete_shortcode', 'sh_cd_ajax_delete_shortcode' );

/**
Ajax handler for toggling disable status of a shortcode
 **/
function sh_cd_ajax_toggle_multisite() {

	if ( false === SH_CD_IS_PREMIUM ) {
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

	if ( false === SH_CD_IS_PREMIUM ) {
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

/**
Ajax handler for adding shortcode inline
 **/
function sh_cd_ajax_add_shortcode() {

	if ( false === SH_CD_IS_PREMIUM ) {
		wp_send_json( 'not-premium' );
	}

	check_ajax_referer( 'sh-cd-security', 'security' );

	if( true === empty( $_POST['slug'] ) ) {
		wp_send_json( [ 'id' => 0, 'ok' => 0, 'error_message' => __( 'Error: Please specify a "Slug".', SH_CD_SLUG ) ] );
	}

	if( true === empty( $_POST['content'] ) ) {
		wp_send_json( [ 'id' => 0, 'ok' => 0, 'error_message' => __( 'Error: Please add something for "Content".', SH_CD_SLUG ) ] );
	}

	$shortcode = [	  'slug' 			=> $_POST['slug'],
	                  'previous_slug'   => '',
	                  'data' 			=> $_POST['content'],
	                  'disabled' 		=> ! sh_cd_to_bool( $_POST[ 'enabled' ] ),
	                  'multisite' 	    => sh_cd_to_bool( $_POST[ 'multisite' ] )
	];

	$result = sh_cd_db_shortcodes_save( $shortcode, true );

	wp_send_json( [ 'shortcode' => $result, 'ok' => ( false !== $result ), 'error_message' => __( 'Error: There was an error when saving your shortcode.', SH_CD_SLUG ) ] );

}
add_action( 'wp_ajax_add_shortcode', 'sh_cd_ajax_add_shortcode' );

/**
 * Replace shortcodes within menu titles.
 *
 * @param $title
 * @return mixed
 */
function sh_cd_menu_replace_shortcodes( $title ) {
    return do_shortcode( $title );
}
add_filter('nav_menu_item_title', 'sh_cd_menu_replace_shortcodes', 10, 1);
