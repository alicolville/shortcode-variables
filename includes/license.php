<?php

	defined('ABSPATH') or die('Jog on!');

	/**
	 * Premium license?
	 *
	 * @return bool
	 */
	function sh_cd_license_is_premium() {
		return (bool) get_option( 'sh-cd-license-valid', false );
	}

	/**
	 * Return a link to the upgrade page
	 *
	 * @return string
	 */
	function sh_cd_license_upgrade_link() {

		//TODO
		return '#';
	}

	/**
	 *	Check an existing license's hash is still valid
	 **/
	function sh_cd_license_validate( $license ) {

		if ( true === empty( $license ) ) {
			return __( 'License missing', WE_LS_SLUG );
		}

		// Decode license
		$license = sh_cd_license_decode( $license );

		if ( true === empty( $license ) ) {
			return 'Could not decode / verify license';
		}

		// Does site hash in license meet this site's actual hash?
		if ( true === empty( $license['site-hash'] ) ) {
			return 'Invalid license hash';
		}

		// Match this site hash?
		if ( sh_cd_generate_site_hash() !== $license['site-hash']) {
			return 'This license doesn\'t appear to be for this site (no match on site hash).';
		}

		// Valid date?
		$today_time = strtotime( date( 'Y-m-d' ) );
		$expire_time = strtotime( $license['expiry-date'] );

		if ( $expire_time < $today_time ) {
			return 'This license has expired.';
		}

		return true;
	}

	/**
	 * Validate and decode a license
	 **/
	function sh_cd_license_decode( $license ) {

		if( true === empty( $license ) ) {
			return NULL;
		}

		// Base64 and JSON decode
		$license = base64_decode( $license );

		if( false === $license ) {
			return NULL;
		}

		$license = json_decode( $license, true );

		if( true === empty( $license ) ) {
			return NULL;
		}
		//Todo: Set type to 'sh-cd-pro'
		// Validate hash!
		$verify_hash = md5( 'yeken.uk' . $license['type'] . $license['expiry-days'] . $license['site-hash'] . $license['expiry-date'] );

		return ( $license['hash'] == $verify_hash && false === empty( $license ) ) ? $license : NULL;
	}


	/**
	 * Validate and apply a license
	 **/
	function sh_cd_license_apply( $license ) {

		// Validate license
		$license_result = sh_cd_license_validate($license);

		if( true === $license_result ) {

			update_option( 'sh-cd-license', $license );
			update_option( 'sh-cd-license-valid', true );

			return true;
		}

		return false;
	}

	/**
	 *	Generate a site hash to identify this site.
	 **/
	function sh_cd_generate_site_hash() {

		$site_hash = get_option( 'sh-cd-hash' );

		// Generate a basic site key from URL and plugin slug
		if( false == $site_hash ) {

			$site_hash = md5( 'yeken-sh-cd-' . site_url() );
			$site_hash = substr( $site_hash, 0, 6 );

			update_option( 'sh-cd-hash', $site_hash );

		}
		return $site_hash;
	}

	/**
	 * Fetch license
	 *
	 * @return mixed
	 */
	function sh_cd_license() {
		return get_option( 'sh-cd-license', '' );
	}
