<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Plugin Name: Shortcode Variables
 * Description: Create your own shortcodes and assign text / variables to it or use our premade ones. You can then embed these shortcodes throughout your entire site and only have to change the value in one place.
 * Version: 1.8
 * Author: YeKen
 * Author URI: http://www.YeKen.uk
 * License: GPL2
 * Text Domain: shortcode-variables
 */
/*  Copyright 2017 YeKen.uk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('SH_CD_ABSPATH', plugin_dir_path( __FILE__ ));

define('SH_CD_PLUGIN_VERSION', '1.8');

// -----------------------------------------------------------------------------------------
// AC: Include all relevant PHP files
// -----------------------------------------------------------------------------------------

include SH_CD_ABSPATH . 'includes/globals.php';
include SH_CD_ABSPATH . 'includes/hooks.php';
include SH_CD_ABSPATH . 'includes/pages.php';
include SH_CD_ABSPATH . 'includes/functions.php';
include SH_CD_ABSPATH . 'includes/shortcode.php';
include SH_CD_ABSPATH . 'includes/shortcode-premade.php';

// -----------------------------------------------------------------------------------------
// AC: Load relevant language files
// -----------------------------------------------------------------------------------------

load_plugin_textdomain( SH_CD_SLUG, false, dirname( plugin_basename( __FILE__ )  ) . '/languages/' );

// -----------------------------------------------------------------------------------------
// Activation - create table
// -----------------------------------------------------------------------------------------

register_activation_hook(   __FILE__, 'sh_cd_create_database_table');

// -----------------------------------------------------------------------------------------
// Upgrade tasks?
// -----------------------------------------------------------------------------------------
if(SH_CD_PLUGIN_VERSION <> get_option('sh-cd-version', SH_CD_PLUGIN_VERSION)) {
	// Run Database check / upgrade code again
	sh_cd_create_database_table();
	update_option('sh-cd-version', SH_CD_PLUGIN_VERSION);
}
