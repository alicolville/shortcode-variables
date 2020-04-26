<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Return a list of slugs / titles for free presets
 * @return array
 */
function sh_cd_shortcode_presets_free_list() {

	return [
		'sc-todays-date' => [ 'class' => 'SC_TODAYS_DATE', 'description' => __( 'Displays today\'s date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>', SH_CD_SLUG ) ],
		'sc-user-ip' => [ 'class' => 'SC_USER_IP', 'description' => __( 'Display the current user\'s IP address.', SH_CD_SLUG )],
		'sc-user-agent' => [ 'class' => 'SC_USER_AGENT', 'description' => __( 'Display the current user\'s User Agent', SH_CD_SLUG ) ],
		'sc-site-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => __( 'The Site address (URL) (set in Settings > General)', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'url' ] ],
		'sc-site-title' => [ 'class' => 'SC_BLOG_INFO', 'description' => __( 'Displays the site title.', SH_CD_SLUG ) ],
		'sc-admin-email' => [ 'class' => 'SC_BLOG_INFO', 'description' => __( 'Admin email (set in Settings > General)', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'admin_email' ] ],
		'sc-page-title' => [ 'class' => 'SC_PAGE_TITLE', 'description' => __( 'Displays the page title.', SH_CD_SLUG ) ],
		'sc-login-page' => [ 'class' => 'SC_LOGIN_PAGE', 'description' => __( 'Wordpress login page. Add the parameter "redirect" to specify where the user is taken after a successful login e.g. redirect="http://www.google.co.uk".', SH_CD_SLUG ) ],
		'sc-privacy-url' => [ 'class' => 'SC_POLICY_URL', 'description' => __( 'Displays the privacy page URL.', SH_CD_SLUG ) ],
		'sc-username' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the logged in username.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'user_login' ] ],
		'sc-user-id' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the current user\'s ID.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'ID' ] ],
		'sc-user-email' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the current user\'s email address.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'user_email' ] ],
		'sc-first-name' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the current user\'s username.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'user_firstname' ] ],
		'sc-last-name' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the current user\'s last name.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'user_lastname' ] ],
		'sc-display-name' => [ 'class' => 'SC_USER_INFO', 'description' => __( 'Display the current user\'s display name.', SH_CD_SLUG ), 'args' => [ '_sh_cd_func' => 'display_name' ] ]
	];

	// '' => [ 'class' => '', 'description' => '', 'args' => [ '_sh_cd_func' => 'admin_email' ] ]
}

/**
 * Get a user's ID
 *
 * Class SV_SC_USER_IP
 */
class SV_SC_USER_IP extends SV_Preset {

	protected function unsanitised() {

		// Code based on WP Beginner article: http://www.wpbeginner.com/wp-tutorials/how-to-display-a-users-ip-address-in-wordpress/
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;

	}
}

/**
 * Today's date
 *
 * Class SV_SC_TODAYS_DATE
 */
class SV_SC_TODAYS_DATE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$date_format = ( false === empty( $args['format'] ) ) ? $args['format'] : 'd/m/Y';

		return date( $date_format );

	}
}

/**
 * User Agent
 *
 * Class SV_SC_USER_AGENT
 */
class SV_SC_USER_AGENT extends SV_Preset {
	protected function unsanitised() {
		return $_SERVER['HTTP_USER_AGENT'];
	}
}

/**
 * Page title
 *
 * Class SV_SC_PAGE_TITLE
 */
class SV_SC_PAGE_TITLE extends SV_Preset {

	protected function unsanitised() {
		return the_title('', '', false);
	}
}

/**
 * Login Page
 *
 * Class SV_SC_LOGIN_PAGE
 */
class SV_SC_LOGIN_PAGE extends SV_Preset {

	public function init() {
		$this->escape_method = 'esc_url_raw';
	}

	protected function unsanitised() {

		$args = $this->get_arguments();

		$redirect = ( false === empty( $args['redirect'] ) ) ? $args['redirect'] : '';

		return wp_login_url( $redirect );
	}
}
/**
 * Policy URL
 *
 * Class SV_SC_POLICY_URL
 */
class SV_SC_POLICY_URL extends SV_Preset {

	public function init() {
		$this->escape_method = 'esc_url_raw';
	}

	protected function unsanitised() {
		return get_privacy_policy_url();
	}
}

/**
 * User Info
 *
 * Class SV_USER_INFO
 */
class SV_SC_USER_INFO extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$key = ( false === empty( $args['_sh_cd_func'] ) ) ? $args['_sh_cd_func'] : 'ID';

		$current_user = wp_get_current_user();

		// Not logged in?
		if ( false === $current_user->exists() ) {
			return '';
		}

		switch ( $key ) {

			case 'user_login':
				return  $current_user->user_login;
				break;
			case 'user_email':
				return $current_user->user_email;
				break;
			case 'user_firstname':
				return $current_user->user_firstname;
				break;
			case 'user_lastname':
				return $current_user->user_lastname;
				break;
			case 'display_name':
				return $current_user->display_name;
				break;
			default:
				return $current_user->ID;

		}

		return '';
	}
}
