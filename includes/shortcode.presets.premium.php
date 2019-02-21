<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Return a list of slugs / titles for free presets
 * @return array
 */
function sh_cd_shortcode_presets_premium_list() {

	return [
		'sc-site-language' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Language code for the current site', 'args' => [ '_sh_cd_func' => 'language' ], 'premium' => true ],
		'sc-site-description' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Site tagline (set in Settings > General)', 'args' => [ '_sh_cd_func' => 'description' ], 'premium' => true ],
		'sc-site-wp-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The WordPress address (URL) (set in Settings > General)', 'args' => [ '_sh_cd_func' => 'wpurl' ], 'premium' => true ],
		'sc-site-charset' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The "Encoding for pages and feeds"  (set in Settings > Reading)', 'args' => [ '_sh_cd_func' => 'charset' ], 'premium' => true ],
		'sc-site-wp-version' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The current WordPress version', 'args' => [ '_sh_cd_func' => 'version' ], 'premium' => true ],
		'sc-site-html-type' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The content-type (default: "text/html"). Themes and plugins', 'args' => [ '_sh_cd_func' => 'html_type' ], 'premium' => true ],
		'sc-site-stylesheet-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'URL to the stylesheet for the active theme.', 'args' => [ '_sh_cd_func' => 'stylesheet_url' ], 'premium' => true ],
		'sc-site-stylesheet_directory' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'Directory path for the active theme.', 'args' => [ '_sh_cd_func' => 'stylesheet_directory' ], 'premium' => true ],
		'sc-site-template-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The URL of the active theme\'s directory.', 'args' => [ '_sh_cd_func' => 'template_url' ], 'premium' => true],
		'sc-site-pingback-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The pingback XML-RPC file URL (xmlrpc.php)', 'args' => [ '_sh_cd_func' => 'pingback_url' ], 'premium' => true ],
		'sc-site-atom-feed' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The Atom feed URL (/feed/atom)', 'args' => [ '_sh_cd_func' => 'atom_url' ], 'premium' => true ],
		'sc-site-rdf-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RDF/RSS 1.0 feed URL (/feed/rfd)', 'args' => [ '_sh_cd_func' => 'rdf_url' ], 'premium' => true ],
		'sc-site-rss-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RSS 0.92 feed URL (/feed/rss)', 'args' => [ '_sh_cd_func' => 'rss_url' ], 'premium' => true ],
		'sc-site-rss2-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The RSS 2.0 feed URL (/feed)', 'args' => [ '_sh_cd_func' => 'rss2_url' ], 'premium' => true ],
		'sc-site-comments-atom-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The comments Atom feed URL (/comments/feed)', 'args' => [ '_sh_cd_func' => 'comments_atom_url' ], 'premium' => true ],
		'sc-site-comments-rss2-url' => [ 'class' => 'SC_BLOG_INFO', 'description' => 'The comments RSS 2.0 feed URL (/comments/feed)', 'args' => [ '_sh_cd_func' => 'comments_rss2_url' ], 'premium' => true ],
		'sc-php-server-info' => [ 'class' => 'SC_SERVER_INFO', 'description' => 'Display data from the PHP $_SERVER global e.g. [sv slug="sc-server-info" field="SERVER_SOFTWARE"]. <a href="http://php.net/manual/en/reserved.variables.server.php" rel="noopener" target="_blank">Allowed values for field attribute</a>.', 'premium' => true ],
		'sc-php-unique-id' => [ 'class' => 'SC_UNIQUE_ID', 'description' => 'Generate a unique ID. Based upon <a href="http://php.net/manual/en/function.uniqid.php" rel="noopener" target="_blank">uniqid()</a>. If you wish the unique ID to be prefixed, add a the prefix attribute e.g. [sv slug="sc-php-unique-id" prefix="yeken"]', 'premium' => true ],
		'sc-php-timestamp' => [ 'class' => 'SC_TIMESTAMP', 'description' => 'Display the current unix timestamp. Based upon <a href="http://php.net/manual/en/function.time.php" rel="noopener" target="_blank">time()</a>.', 'premium' => true ],
		'sc-php-random-number' => [ 'class' => 'SC_RAND_NUMBER', 'description' => 'Display a random number. Based upon <a href="http://php.net/manual/en/function.rand.php" rel="noopener" target="_blank">rand()</a>. It also supports the optional arguments of min and max e.g. [sv slug="sc-php-random-number" min="5" max="20" ]', 'premium' => true ],
		'sc-php-random-string' => [ 'class' => 'SC_RAND_STRING', 'description' => 'Display a random string of characters. It also supports the optional argument of "length". This specifies the number of characters you wish to display (default is 10) [sv slug="sc-php-random-string" length="15"]', 'premium' => true ],
		'sc-php-post-value' => [ 'class' => 'SC_POST_VALUE', 'description' => 'Display a value from the $_POST array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-post-value" key="username" default="Not Found"]', 'premium' => true ],
		'sc-php-get-value' => [ 'class' => 'SC_GET_VALUE', 'description' => 'Display a value from the $_GET array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-get-value" key="username" default="Not Found"]', 'premium' => true ],
		'sc-php-info' => [ 'class' => 'SC_PHP_INFO', 'description' => 'Display PHP Info', 'premium' => true ],
		'sc-post-id' => [ 'class' => 'SC_POST_ID', 'description' => 'Display ID for the current post.', 'premium' => true ],
		'sc-post-author' => [ 'class' => 'SC_POST_AUTHOR', 'description' => 'Display the author\'s display name or ID. The optional argument "field" allows you to specify whether you wish to display the author\'s "display-name" or "id". [sv slug="sc-post-author" field="id" ]', 'premium' => true ],
		'sc-post-counts' => [ 'class' => 'SC_POST_COUNTS', 'description' => 'Display a count of posts for certain statuses. Using the argument status, specify whether to return a count for all posts that have a status of "publish" (default), "future", "draft", "pending" or "private". [sv slug="sc-post-counts" status="draft"]', 'premium' => true ]

		// '' => [ 'class' => '', 'description' => '', 'premium' => true ]
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

/**
 * Get data from $_SERVER
 *
 * Class SV_SC_SERVER_INFO
 */
class SV_SC_SERVER_INFO extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		return ( false === empty( $_SERVER[ $args['field'] ] ) ) ? $_SERVER[ $args['field'] ] : '';
	}
}

/**
 * Get a unique ID
 *
 * Class SV_SC_UNIQUE_ID
 */
class SV_SC_UNIQUE_ID extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$prefix = ( false === empty( $args['prefix'] ) ) ? $args['prefix'] : '';

		return uniqid ( $prefix, true );
	}
}

/**
 * Get timestamp
 *
 * Class SV_SC_TIMESTAMP
 */
class SV_SC_TIMESTAMP extends SV_Preset {

	protected function unsanitised() {
		return time();
	}
}

/**
 * Display PHP INFO
 *
 * Class SV_SC_PHP_INFO
 */
class SV_SC_PHP_INFO extends SV_Preset {

	protected function unsanitised() {
		return phpinfo();
	}
}

/**
 * Random number
 *
 * Class SV_SC_RAND_NUMBER
 */
class SV_SC_RAND_NUMBER extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$min = ( false === empty( $args['min'] ) ) ? (int) $args['min'] : 0;

		$max = ( false === empty( $args['max'] ) ) ? (int) $args['max'] : getrandmax();

		return rand( $min, $max );
	}
}

/**
 * Random string
 *
 * Based upon: https://stackoverflow.com/questions/4356289/php-random-string-generator
 *
 * Class SV_SC_RAND_STRING
 */
class SV_SC_RAND_STRING extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$length = ( false === empty( $args['length'] ) ) ? (int) $args['length'] : 10;

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$no_characters = strlen( $characters );
		$random_string = '';

		for ($i = 0; $i < $length; $i++) {
			$random_string .= $characters[ rand( 0, $no_characters - 1 ) ];
		}

		return $random_string;
	}
}

/**
 * Fetch an item from the $_POST array
 *
 * Class SV_SC_POST_VALUE
 */
class SV_SC_POST_VALUE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$post_value = ( false === empty( $_POST[ $args['key'] ] ) ) ? $_POST[ $args['key'] ] : NULL;

		if ( null !== $post_value ) {
			return $post_value;
		}

		// Do we have a fall back default?
		return ( false === empty( $args['default'] ) ) ? $args['default'] : '';

	}
}

/**
 * Fetch an item from the $_GET array
 *
 * Class SV_SC_GET_VALUE
 */
class SV_SC_GET_VALUE extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$post_value = ( false === empty( $_GET[ $args['key'] ] ) ) ? $_GET[ $args['key'] ] : NULL;

		if ( null !== $post_value ) {
			return $post_value;
		}

		// Do we have a fall back default?
		return ( false === empty( $args['default'] ) ) ? $args['default'] : '';

	}
}

/**
 * Display current Post ID
 *
 * Class SV_SC_POST_ID
 */
class SV_SC_POST_ID extends SV_Preset {

	protected function unsanitised() {
		return get_the_ID();
	}
}

/**
 * Display author of current post
 *
 * Class SV_SC_POST_AUTHOR
 */
class SV_SC_POST_AUTHOR extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		switch ( $args['field'] ) {
			case 'id':
					return get_the_author_meta( 'ID' );
				break;
			default:
				return get_the_author();
		}
	}
}

/**
 * Display post counts
 *
 * Class SV_SC_POST_COUNTS
 */
class SV_SC_POST_COUNTS extends SV_Preset {

	protected function unsanitised() {

		$args = $this->get_arguments();

		$counts = wp_count_posts();

		switch ( $args['status'] ) {
			case 'future':
					return $counts->future;
				break;
			case 'draft':
				return $counts->draft;
				break;
			case 'pending':
				return $counts->pending;
				break;
			case 'private':
				return $counts->private;
				break;
			default:
				return $counts->publish;
		}
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