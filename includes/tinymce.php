<?php

	defined('ABSPATH') or die("Jog on!");

	/**
	 * Include Tinymce button
	 */
	function sh_cd_tinymce_button_add() {

		// Ensure user can edit pages before bringing in libraries
		if ( false === current_user_can('edit_posts') || false === current_user_can('edit_pages') ) {
			return;
		}

	    // Ensure WYSIWYG is enabled
	    if ( 'true' === get_user_option( 'rich_editing' ) ) {

			add_filter( 'mce_external_plugins', 'sh_cd_tinymce_button_plugin_js' );
		    add_filter( 'mce_buttons', 'sh_cd_tinymce_button_register' );

		    sh_cd_tinymce_js_variables();
	    }
	}
	add_action( 'admin_head', 'sh_cd_tinymce_button_add' );

	/**
	 * Output Js config
	 */
	function sh_cd_tinymce_js_variables() {

		$config = [
			'button-text' => 'Snippet Shortcodes',
			'select-text' => 'Premade Variables',
			'premium' => SH_CD_IS_PREMIUM,
			'upgrade-url' => sh_cd_license_upgrade_link(),
			'upgrade-text' => 'This is a premium feature. Would you like to upgrade Snippet Shortcodes?',
			'dialog-title' => 'Select a shortcode',
			'dialog-label' => 'Shortcode',
			'values-your' => sh_cd_tinymce_js_varables_shortcodes( 'your' ),
			'values-premade' => sh_cd_tinymce_js_varables_shortcodes( 'premade' )
		];

		printf( '<script type="text/javascript">var sh_cd_tinymce = %s;</script>', json_encode( $config ) );

	}

	/**
	 * Fetch options for shortcode selects
	 *
	 * @param $mode
	 *
	 * @return array
	 */
	function sh_cd_tinymce_js_varables_shortcodes( $mode ) {

		$data = [];

		if ( false === SH_CD_IS_PREMIUM ) {
			return [];
		}

		if ( 'premade' === $mode ) {

			$options = sh_cd_presets_both_lists();
			$options = array_keys( $options );

		} else {

			$options = sh_cd_db_shortcodes_all_enabled();
			$options = wp_list_pluck( $options, 'slug' );
		}

		$formatted = [];

		foreach ( $options as $option ) {

			$formatted[] = [
				'value' => sprintf( '[sv slug="%s"]', $option ),
				'text' => $option
			];


		}

		return  $formatted ;
	}

	/**
	 * Add JS to TinyMCE plugins
	 *
	 * @param $plugins
	 *
	 * @return mixed
	 */
	function sh_cd_tinymce_button_plugin_js( $plugins ) {

		$plugins[ 'sh_cd_tinymce_button' ] = plugins_url( '../assets/js/tinymce.js', __FILE__ );
		return $plugins;
	}

	/**
	 * Register TinyMCE button
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 */
	function sh_cd_tinymce_button_register( $buttons ) {

		array_push( $buttons, 'sh_cd_tinymce_button' );

		return $buttons;
	}
