<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Return a list of slugs / titles for free presets
 * @return array
 */
function sh_cd_shortcode_presets_premium_list() {

	return [
		'sc-site-language' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Language code for the current site', 'args' => [ '_sh_cd_func' => 'language' ] ],
		'sc-site-description' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Site tagline (set in Settings > General)', 'args' => [ '_sh_cd_func' => 'description' ] ],
		'sc-site-wp-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The WordPress address (URL) (set in Settings > General)', 'args' => [ '_sh_cd_func' => 'wpurl' ] ],
		'sc-site-charset' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The "Encoding for pages and feeds"  (set in Settings > Reading)', 'args' => [ '_sh_cd_func' => 'charset' ] ],
		'sc-site-wp-version' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The current WordPress version', 'args' => [ '_sh_cd_func' => 'version' ] ],
		'sc-site-html-type' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The content-type (default: "text/html"). Themes and plugins', 'args' => [ '_sh_cd_func' => 'html_type' ] ],
		'sc-site-stylesheet-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'URL to the stylesheet for the active theme.', 'args' => [ '_sh_cd_func' => 'stylesheet_url' ] ],
		'sc-site-stylesheet_directory' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Directory path for the active theme.', 'args' => [ '_sh_cd_func' => 'stylesheet_directory' ] ],
		'sc-site-template-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'tURL of the active theme\'s directory.', 'args' => [ '_sh_cd_func' => 'template_url' ] ],
		'sc-site-pingback-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The pingback XML-RPC file URL (xmlrpc.php)', 'args' => [ '_sh_cd_func' => 'pingback_url' ] ],
		'sc-site-atom-feed' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The Atom feed URL (/feed/atom)', 'args' => [ '_sh_cd_func' => 'atom_url' ] ],
		'sc-site-rdf-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RDF/RSS 1.0 feed URL (/feed/rfd)', 'args' => [ '_sh_cd_func' => 'rdf_url' ] ],
		'sc-site-rss-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RSS 0.92 feed URL (/feed/rss)', 'args' => [ '_sh_cd_func' => 'rss_url' ] ],
		'sc-site-rss2-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RSS 2.0 feed URL (/feed)', 'args' => [ '_sh_cd_func' => 'rss2_url' ] ],
		'sc-site-comments-atom-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The comments Atom feed URL (/comments/feed)', 'args' => [ '_sh_cd_func' => 'comments_atom_url' ] ],
		'sc-site-comments-rss2-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The comments RSS 2.0 feed URL (/comments/feed)', 'args' => [ '_sh_cd_func' => 'comments_rss2_url' ] ]
	];
}

/**
 * Get data from get_bloginfo()
 *
 * Class SV_SC_SITE_TITLE
 */
class SV_SC_BLOG_INFO extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$key = ( false === empty( $args['_sh_cd_func'] ) ) ? $args['_sh_cd_func'] : 'name';

		return get_bloginfo( $key );
	}
}

// todo
//
//function t() {
//
//	foreach ( sh_cd_shortcode_presets_premium_list() as $key => $value ) {
//
//		printf('<h4>%s</h4><p>[sv slug="%s"]</p>', $key, $key );
//
//	}
//die;
//}
//add_action('init', 't');