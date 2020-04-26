<?php

defined('ABSPATH') or die("Jog on!");

// Fetch the existing license from WP Options and run it through validation again.
function sh_cd_cron_licence_check() {
;
	$existing_license = sh_cd_license();

	sh_cd_license_apply( $existing_license );
}
add_action( 'daily', 'sh_cd_cron_licence_check' );
add_action( 'sh-cd-upgrade', 'sh_cd_cron_licence_check' );
