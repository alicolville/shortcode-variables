# Premium helper shortcodes

> The following shortcodes are only available in the [Premium](https://shop.yeken.uk/product/shortcode-variables/) version of the plugin.

Besides the ability to create [your own shortcodes]({{ site.baseurl }}/shortcodes-own.html), Snippet Shortcode has a collection of out the box helper shortcodes. Shortcodes functionality are implemented using [WordPress shortcodes](https://codex.wordpress.org/Shortcode_API).

For additional shortcodes, check out the [Free helper shortcodes]({{ site.baseurl }}/shortcodes-free.html).

|--|--|
|[sv slug="sc-date"] |A shortcode that displays today's date with the ability to add or subtract days, months and years. To specify an interval to add or subtract onto the date use the parameter "interval" e.g. [sv slug="sc-date" interval="-1 year"], [sv slug="sc-date" interval="+5 days"], [sv slug="sc-date" interval="+3 months"]. Intervals are based upon PHP intervals and are outlined here https://www.php.net/manual/en/dateinterval.createfromdatestring.php. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: http://php.net/manual/en/function.date.php
|[[sv slug="sc-db-value-by-id"]]({{ site.baseurl }}/shortcodes/sc-db-value-by-id.html) |Fetch a value from the given MySQL table. Specify which column the value should be fetched from as well as specify which column should be matched against for the given key.
|[sv slug="sc-site-language"]|	Language code for the current site
|[sv slug="sc-site-description"]|	Site tagline (set in Settings > General)
|[sv slug="sc-site-wp-url"]	|The WordPress address (URL) (set in Settings > General)
|[sv slug="sc-site-charset"]|	The "Encoding for pages and feeds" (set in Settings > Reading)
|[sv slug="sc-site-wp-version"]	|The current WordPress version
|[sv slug="sc-site-html-type"]|	The content-type (default: "text/html"). Themes and plugins
|[sv slug="sc-site-stylesheet-url"]|	URL to the stylesheet for the active theme.
|[sv slug="sc-site-stylesheet_directory"]|	Directory path for the active theme.
|[sv slug="sc-site-current-url"]	|Get the current URL.
|[sv slug="sc-site-register-url"]|	Get the URL to the WordPress registration page.
|[sv slug="sc-site-template-url"]	|The URL of the active theme's directory.
|[sv slug="sc-site-pingback-url"]|	The pingback XML-RPC file URL (xmlrpc.php)
|[sv slug="sc-site-atom-feed"]	|The Atom feed URL (/feed/atom)
|[sv slug="sc-site-rdf-url"]	|The RDF/RSS 1.0 feed URL (/feed/rfd)
|[sv slug="sc-site-rss-url"]	|The RSS 0.92 feed URL (/feed/rss)
|[sv slug="sc-site-rss2-url"]|	The RSS 2.0 feed URL (/feed)
|[sv slug="sc-site-comments-atom-url"]	|The comments Atom feed URL (/comments/feed)
|[sv slug="sc-site-comments-rss2-url"]	|The comments RSS 2.0 feed URL (/comments/feed)
|[sv slug="sc-php-server-info"]|	Display data from the PHP $_SERVER global e.g. [sv slug="sc-server-info" field="SERVER_SOFTWARE"]. Allowed values for field attribute.
|[sv slug="sc-php-unique-id"]	|Generate a unique ID. Based upon uniqid(). If you wish the unique ID to be prefixed, add a the prefix attribute e.g. [sv slug="sc-php-unique-id" prefix="yeken"]
|[sv slug="sc-php-timestamp"]	|Display the current unix timestamp. Based upon time().
|[sv slug="sc-php-random-number"]|	Display a random number. Based upon rand(). It also supports the optional arguments of min and max e.g. [sv slug="sc-php-random-number" min="5" max="20" ]
|[sv slug="sc-php-random-string"]	|Display a random string of characters. It also supports the optional argument of "length". This specifies the number of characters you wish to display (default is 10) [sv slug="sc-php-random-string" length="15"]
|[sv slug="sc-php-post-value"]	|Display a value from the $_POST array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-post-value" key="username" default="Not Found"]
|[sv slug="sc-php-get-value"]|	Display a value from the $_GET array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-get-value" key="username" default="Not Found"]
|[sv slug="sc-php-info"]	|Display PHP Info
|[sv slug="sc-post-id"]|	Display ID for the current post.
|[sv slug="sc-post-author"]|	Display the author's display name or ID. The optional argument "field" allows you to specify whether you wish to display the author's "display-name" or "id". [sv slug="sc-post-author" field="id" ]
|[sv slug="sc-post-counts"]|	Display a count of posts for certain statuses. Using the argument status, specify whether to return a count for all posts that have a status of "publish" (default), "future", "draft", "pending" or "private". [sv slug="sc-post-counts" status="draft"]
|[sv slug="sc-user-counts"]	|Display a count of all WordPress users or the number of WordPress users for a given role e.g. [sv slug="sc-user-counts" role="subscriber"] or [sv slug="sc-user-counts"]
|[[sv slug="sc-user-meta"]]({{ site.baseurl }}/shortcodes/sc-user-meta.html) |Display a WordPress user meta field (wraps get_user_meta) field e.g. last_name. 
|[sv slug="sc-user-profile-photo"]	|Display the WordPress profile photo for the logged in user e.g. [sv slug="sc-user-profile-photo" width="150"] or [sv slug="sc-user-profile-photo"]. Please note, width defaults to 96px.
|[[sv slug="sc-woocommerce"]]({{ site.baseurl }}/shortcodes/sc-woocommerce.html) |Display a WooCommerce user meta field field e.g. billing_phone. 