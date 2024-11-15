<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Plugin Name: Snippet Shortcodes
 * Description: Create your own shortcodes and assign text / variables to it or use our premade ones. You can then embed these shortcodes throughout your entire site and only have to change the value in one place.
 * Version: 4.1.6
 * Requires at least:   6.0
 * Tested up to: 		6.5
 * Requires PHP:        7.4
 * Author:              Ali Colville
 * Author URI:          https://www.YeKen.uk
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         shortcode-variables
 */

/*  Copyright 2024 YeKen.uk

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

define( 'SH_CD_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'SH_CD_PLUGIN_VERSION', '4.1.6' );
define( 'SH_CD_PLUGIN_NAME', 'Snippet Shortcodes' );
define( 'SH_CD_TABLE', 'SH_CD_SHORTCODES' );
define( 'SH_CD_TABLE_MULTISITE', 'SH_CD_SHORTCODES_MULTISITE' );
define( 'SH_CD_SLUG', 'sh-cd-shortcode-variables' );
define( 'SH_CD_PREFIX', 'sh-cd-' );
define( 'SH_CD_SHORTCODE', 'sv' );
define( 'SH_CD_FREE_SHORTCODE_LIMIT', 10 );
define( 'SH_CD_PREMIUM_PRICE', 2.99 );
define( 'SH_CD_UPGRADE_LINK', 'https://shop.yeken.uk/product/shortcode-variables/' );

// -----------------------------------------------------------------------------------------
// AC: Include all relevant PHP files
// -----------------------------------------------------------------------------------------

include_once SH_CD_ABSPATH . 'includes/class.presets.php';
include_once SH_CD_ABSPATH . 'includes/hooks.php';
include_once SH_CD_ABSPATH . 'includes/functions.php';
include_once SH_CD_ABSPATH . 'includes/db.php';
include_once SH_CD_ABSPATH . 'includes/cron.php';
include_once SH_CD_ABSPATH . 'includes/license.php';

$sh_cd_is_premium = sh_cd_license_is_premium();

define( 'SH_CD_IS_PREMIUM', $sh_cd_is_premium );

include_once SH_CD_ABSPATH . 'includes/shortcode.user.php';
include_once SH_CD_ABSPATH . 'includes/shortcode.presets.core.php';
include_once SH_CD_ABSPATH . 'includes/shortcode.presets.free.php';
include_once SH_CD_ABSPATH . 'includes/shortcode.presets.premium.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.list.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.premade.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.edit.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.settings.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.license.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.help.php';
include_once SH_CD_ABSPATH . 'includes/pages/page.import.php';
include_once SH_CD_ABSPATH . 'includes/tinymce.php';
