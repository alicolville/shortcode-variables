<?php

	defined('ABSPATH') or die("Jog on!");

	abstract class SV_Preset {

		abstract protected function title();

		abstract protected function unsanitised();

		public function sanitised() {
			return esc_html( $this->unsanitised() );
		}
	}

	/**
	 * Get a user's ID
	 *
	 * Class SV_SC_USER_IP
	 */
	class SV_SC_USER_IP extends SV_Preset {

		public function title() { return 'User\'s IP'; }

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

//
//
//function t() {
//
//	$presets = [
//		'sc-user-ip' => 'SV_SC_USER_IP'
//	];
//
//	$key = 'sc-user-ip';
//
//	if ( false === empty( $presets[ $key ] ) && true === class_exists( $presets[ $key ] ) ) {
//		$a = new $presets[ $key ]();
//		echo $a->title() . ' - ' . $a->sanitised();
//	}
//
//
//
//	//$a = new SV_SC_USER_IP();
//
//
//
//	die;
//}
//add_action('init', 't');