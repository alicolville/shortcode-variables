<?php

defined('ABSPATH') or die("Jog on!");

function sh_cd_is_shortcode_preset($slug)
{
	if (!empty($slug) && array_key_exists($slug, sh_cd_shortcode_presets())) {
		return true;
	}

	return false;

}

function sh_cd_shortcode_presets()
{
	return array(

		'sc-todays-date' => 'Displays today\'s date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>',
		'sc-site-title' => 'Displays the site title.',
		'sc-site-url' => 'Displays the site URL.',
		'sc-page-title' => 'Displays the page title.',
		'sc-admin-email' => 'Displays the admin email address.',
		'sc-login-page' => 'Wordpress login page. Add the parameter "redirect" to specify where the user is taken after a successful login e.g. redirect="http://www.google.co.uk".',
		'sc-username' => 'Display the logged in username.',
		'sc-user-id' => 'Display the current user\'s ID',
		'sc-user-ip' => 'Display the current user\'s IP address.',
		'sc-user-email' => 'Display the current user\'s email address.',
		'sc-username' => 'Display the current user\'s username.',
		'sc-first-name' => 'Display the current user\'s first name.',
		'sc-last-name' => 'Display the current user\'s last name.',
		'sc-display-name' => 'Display the current user\'s display name.',
		'sc-user-agent' => 'Display the current user\'s user agent',
        'sc-privacy-url' => 'Displays the privacy page URL.'
		);
}

function sh_cd_render_shortcode_presets($shortcode_args)
{
	$slug = $shortcode_args['slug'];

	$sanitise_method = 'esc_html';

	switch ( $slug ) {
		case 'sc-todays-date':
			$data = sh_cd_render_todays_date( $shortcode_args['format' ]);
			break;
		case 'sc-user-agent':
            $data = $_SERVER['HTTP_USER_AGENT'];
			break;
		case 'sc-site-url':
            $data = site_url();
            $sanitise_method = 'esc_url';
			break;
		case 'sc-page-title':
            $data = the_title('', '', false);
			break;
		case 'sc-site-title':
            $data = get_bloginfo( 'name');
			break;
		case 'sc-admin-email':
            $data = get_bloginfo( 'admin_email');
			break;
		case 'sc-login-page':
			$redirect_page = (false == $shortcode_args['redirect']) ? '' : $shortcode_args['redirect'];
            $data = wp_login_url($redirect_page);
            $sanitise_method = 'esc_url';
			break;
		case 'sc-user-ip':
            $data = sh_cd_get_user_ip();
			break;
        case 'sc-privacy-url':
            $data = get_privacy_policy_url();
            $sanitise_method = 'esc_url';
            break;
	default:
            $data = sh_cd_user_data( $slug );
			break;
	}

    return ( 'esc_url' === $sanitise_method ) ? esc_url( $data ) : esc_html( $data );
}

function sh_cd_user_data($slug) {

        global $current_user;
        get_currentuserinfo();

		if (!empty($current_user->data->ID))
		{
				switch ( $slug ) {
					case 'sc-username':
						return $current_user->user_login;
						break;
					case 'sc-first-name':
						return $current_user->user_firstname;
						break;
					case 'sc-last-name':
						return $current_user->user_lastname;
						break;
					case 'sc-display-name':
						return $current_user->display_name;
						break;
					case 'sc-user-id':
						return $current_user->ID;
						break;
					case 'sc-user-email':
						return $current_user->user_email;
						break;
					default:
						break;
				}
		}

		return '';
}

function sh_cd_get_user_ip() {

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

function sh_cd_render_todays_date($format)
{
	if (false == $format) {
		$format = 'd/m/Y';
	}

	return date($format);
}
