<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Return a list of slugs / titles for free presets
 * @return array
 */
function sh_cd_shortcode_presets_premium_list() {

	return [
		'sc-test' => 'Displays today\'s date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>'
	];
}