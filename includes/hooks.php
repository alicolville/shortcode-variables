<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_build_admin_menu()
{
	add_menu_page( SH_CD_PLUGIN_NAME, SH_CD_PLUGIN_NAME, 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_user_defined_page', 'dashicons-editor-kitchensink' );

	// Hide duplicated sub menu (wee hack!)
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', '', '', 'manage_options', 'sh-cd-shortcode-variables-main-menu', 'sh_cd_user_defined_page');

	// Add sub menus
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __('Your Shortcodes'),  __('Your shortcodes'), 'manage_options', 'sh-cd-shortcode-variables-user-defined', 'sh_cd_user_defined_page');
	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', __('Premade Shortcodes'),  __('Premade shortcodes'), 'manage_options', 'sh-cd-shortcode-variables-sub-premade', 'sh_cd_premade_shortcodes_page');
}
add_action( 'admin_menu', 'sh_cd_build_admin_menu' );
