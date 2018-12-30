<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_shortcode( $atts )
{
	$user_defined_parameters = false;

	$default_arguments = array(
        'slug' => false,
        'format' => false,
		'redirect' => false
    );

	$shortcode_args = shortcode_atts( $default_arguments, $atts );

	// User defined parameters
	$user_defined_parameters = sh_cd_get_user_defined_arguments($default_arguments, $atts);

	return sh_cd_render_shortcode_from_db($shortcode_args, $user_defined_parameters);

}
add_shortcode( SH_CD_SHORTCODE, 'sh_cd_shortcode' );
add_shortcode( SH_CD_SHORTCODE_SMALL, 'sh_cd_shortcode' );

function sh_cd_render_shortcode_from_db($shortcode_args, $user_defined_parameters = false)
{
	$slug = $shortcode_args['slug'];

	if ($slug != false && !empty($slug))
	{
		// Check if a shortcode preset
		if (sh_cd_is_shortcode_preset($slug))		{
			return sh_cd_render_shortcode_presets($shortcode_args);
		}
		else
		{
			$cached_shortcode = sh_cd_get_cache($slug);

			if ($cached_shortcode != false)
			{
				// Process other shortcodes
				$cached_shortcode = do_shortcode($cached_shortcode);

				// No shortcode found or disabled? Then return nothing.
				if(!$cached_shortcode) {
					return '';
				}

				// Replace placeholders with user defined parameters
				$cached_shortcode = sh_cd_apply_user_defined_parameters($cached_shortcode, $user_defined_parameters);

				return $cached_shortcode;
			}
			else
			{
				$shortcode = sh_cd_get_shortcode_by_slug($slug);

				if ($shortcode)
				{
					sh_cd_set_cache($slug, $shortcode);

					// No shortcode found or disabled? Then return nothing.
					if(!$shortcode) {
						return '';
					}

					// Process other shortcodes
					$shortcode = do_shortcode($shortcode);

					// Replace placeholders with user defined parameters
					$shortcode = sh_cd_apply_user_defined_parameters($shortcode, $user_defined_parameters);

					return $shortcode;
				}
			}
		}
	}
}
