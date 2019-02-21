=== Plugin Name ===
Contributors: aliakro
Donate link: https://www.paypal.me/yeken
Tags: shortcode, variable, php, text, html, parameter, javascript, embed, reuse
Requires at least: 4.2.0
Tested up to: 5.0.3
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create your own shortcodes and assign text, html, etc to them. Use these across your site and only change in one place.

== Description ==

Do you want to use the same snippet throughout your site but only have to change the value in one location? If so, this plugin maybe just what you need.

You can create your own Shortcodes and assign text, HTML, JavaScript, etc to it. You will then be given a shortcode such as:

[sv slug="your-slug-name"]

You can embed this shortcode throughout your site and it will render the same content. Simply update the Shortcode Variable in Tools > Shortcode Variables and it will change throughout the site!

** Specify Parameters **

Specify your own parameters:

You can now specify your own parameters when inserting a shortcode. For example, say you have a shortcode that renders a HTML table, you can now add parameters to the shortcode and specify where they appear in the shortcode e.g.

[sv slug="render-table" border="0" background="#FFFFFF" width="50%" site-title="YeKen"] to place each parameter within a shortcode use the following syntax %%background%%, %%width%%, etc. See below:

<table border="%%border%%" style="background:%%background%%" width="%%width%%">
	<tr>
		<td>Welcome to our site, %%site-title%%.</td>
	</tr>
</table>

**Premium Shortcodes**

The plugin comes with the following premium shortcodes:

- sc-site-language - Language code for the current site
- sc-site-description - Site tagline (set in Settings > General)
- sc-site-wp-url - The WordPress address (URL) (set in Settings > General)
- sc-site-charset - The "Encoding for pages and feeds"  (set in Settings > Reading)
- sc-site-wp-version - The current WordPress version
- sc-site-html-type - The content-type (default: "text/html"). Themes and plugins
- sc-site-stylesheet-url - URL to the stylesheet for the active theme.
- sc-site-stylesheet_directory - Directory path for the active theme.
- sc-site-template-url - The URL of the active theme's directory.
- sc-site-pingback-url - The pingback XML-RPC file URL (xmlrpc.php)
- sc-site-atom-feed - The Atom feed URL (/feed/atom)
- sc-site-rdf-url - The RDF/RSS 1.0 feed URL (/feed/rfd)
- sc-site-rss-url - The RSS 0.92 feed URL (/feed/rss)
- sc-site-rss2-url - The RSS 2.0 feed URL (/feed)
- sc-site-comments-atom-url - The comments Atom feed URL (/comments/feed)
- sc-site-comments-rss2-url - The comments RSS 2.0 feed URL (/comments/feed)
- sc-php-server-info - Display data from the PHP $_SERVER global e.g. [sv slug="sc-server-info" field="SERVER_SOFTWARE"]. <a href="http://php.net/manual/en/reserved.variables.server.php" rel="noopener" target="_blank">Allowed values for field attribute</a>.
- sc-php-unique-id - Generate a unique ID. Based upon <a href="http://php.net/manual/en/function.uniqid.php" rel="noopener" target="_blank">uniqid()</a>. If you wish the unique ID to be prefixed, add a the prefix attribute e.g. [sv slug="sc-php-unique-id" prefix="yeken"]
- sc-php-timestamp - Display the current unix timestamp. Based upon <a href="http://php.net/manual/en/function.time.php" rel="noopener" target="_blank">time()</a>.
- sc-php-random-number - Display a random number. Based upon <a href="http://php.net/manual/en/function.rand.php" rel="noopener" target="_blank">rand()</a>. It also supports the optional arguments of min and max e.g. [sv slug="sc-php-random-number" min="5" max="20" ]
- sc-php-random-string - Display a random string of characters. It also supports the optional argument of "length". This specifies the number of characters you wish to display (default is 10) [sv slug="sc-php-random-string" length="15"]
- sc-php-post-value - Display a value from the $_POST array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-post-value" key="username" default="Not Found"]
- sc-php-get-value - Display a value from the $_GET array. The "key" arguments specifies which array value to render. It also supports the optional arguments of "default". If there is no value in the array for the given "key" then the "default" will be displayed. [sv slug="sc-php-get-value" key="username" default="Not Found"]
- sc-php-info - Display PHP Info
- sc-post-id - Display ID for the current post.
- sc-post-author - Display the author's display name or ID. The optional argument "field" allows you to specify whether you wish to display the author's "display-name" or "id". [sv slug="sc-post-author" field="id" ]
- sc-post-counts - Display a count of posts for certain statuses. Using the argument status, specify whether to return a count for all posts that have a status of "publish" (default), "future", "draft", "pending" or "private". [sv slug="sc-post-counts" status="draft"]

**Free Shortcodes**

The plugin comes with the following free shortcodes:

- sc-todays-date - Displays today's date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>
- sc-user-ip - Display the current user's IP address.
- sc-user-agent - Display the current user's User Agent
- sc-site-url - The Site address (URL) (set in Settings > General)
- sc-site-title - Displays the site title.
- sc-admin-email - Admin email (set in Settings > General)
- sc-page-title - Displays the page title.
- sc-login-page - Wordpress login page. Add the parameter "redirect" to specify where the user is taken after a successful login e.g. redirect="http://www.google.co.uk".
- sc-privacy-url - Displays the privacy page URL.
- sc-username - Display the logged in username.
- sc-user-id - Display the current user's ID.
- sc-user-email - Display the current user's email address.
- sc-first-name - Display the current user's username.
- sc-last-name - Display the current user's last name.
- sc-display-name - Display the current user's display name.

**Features**

- Insert the same piece of data, HTML, text, etc throughout your site and change in only one place.
- TinyMCE editor
- Place other WordPress shortcodes within yours
- Comes with a range of pre-made shortcodes
- Pass your own parameters into a shortcode

* Developed by YeKen.uk *

Paypal Donate: email@YeKen.uk

== Installation ==

1. Login into Wordpress Admin Panel
2. Goto Plugins > Add New
3. Search for "Shortcode Variables"
4. Click Install now and activate plugin
5. Goto Settings > Shortcode Variables

== Frequently Asked Questions ==

= How do I add / edit / delete Shortcode Variables =

Login into Wordpress Admin Panel and goto Settings > Shortcode Variables

== Screenshots ==

1. View all shortcode variables created.
2. Add a new shortcode variable
3. Edit an existing shortcode variable
4. Using the shortcode variables into a page
5. Shortcode variables rendered in a page

== Changelog ==

= 2.0 =

TODO:

- update product description
- documentation site (add a shortcode to this plugin to render it all out).
- update license ( l.php ) to generate a type of "sv-premium"

* New Feature: Added additional premium shortcodes.
* New Feature: Inline editing of shortcodes from the main list screen.
* New Feature: Able to disable / enable shortcodes from shortcode list.
* Improvement: Refactoring and optimisation of the entire plugin code.
* Improvement: Added Fooicons.
* Improvement: Added simple form validation when adding a record.

= 1.8 =

* Improvement: Added escaping for premade shortcodes.
* Improvement: Added new shortcode "sc-privacy-url" for rendering Privacy URL link.

= 1.7.4 =

- Version and readme.txt updated to reflect 4.8 compatibility.

= 1.7.3 =

- BUG FIX: On the very first load of a variable it would return nothing. This was due to a bug in the code. The first load would display nothing to the user, however it would cache the shortcode correctly. Upon the next visit, the shortcode would render correctly!

= 1.7.2 =

- When creating a new shortcode, "Disabled" is set by default to "No".
- Additional upgrade check added. This compares the previously stored version number against the new version number. If there is a difference, it will run the DB table check again.

= 1.7.1 =

- BUG FIX: Tweak made to "on activate" so the code required to change the relevant database tables is called correctly.

= 1.7 =

- Disable a variable. You can now disable a variable via the admin panel - if a shortcode is disabled nothing will be rendered in it's place (will remove the shortcode though).

= 1.6.1 =

- BUG FIX: Array declaration caused 500 error on non PHP 7

= 1.6 =

- Now supports custom parameters. You can now add parameters when inserting a shortcode and specify where in the shortcode those parameters should appear.
- BUG FIX: Removed a stray var_dump()

= 1.5.1 =

* BUG FIX: "Add new" link for message "You haven't created any shortcodes yet." wasn't working correctly
* BUG FIX: Typo - "Shotcodes" instead of "Shortcodes" on "Your Shortcodes" page

= 1.5 =

* Added a shorter shortcode slug. So, instead of [shortcode-variables slug="your-slug-name"] you can also use [s-var slug="your-slug-name"]
* BUG FIX: Some pre-made shortcodes weren't being rendered in the correct place. Fixed.

= 1.4 =
* Added the new pre-made shortcodes:
 * sc-login-page - Wordpress login page. Add the parameter "redirect" to specify where the user is taken after a successful login e.g. redirect="http://www.google.co.uk".
 * sc-username - Display the logged in username.
 * sc-user-id - Display the current user's ID
 * sc-user-ip - Display the current user's IP address.
 * sc-user-email - Display the current user's email address.
 * sc-username - Display the current user's username.
 * sc-first-name - Display the current user's first name.
 * sc-last-name - Display the current user's last name.
 * sc-display-name - Display the current user's display name.
 * sc-user-agent - Display the current user's user agent
* BUG FIX: Deleting a shortcode from cache when deleted from Admin panel. This stops it getting rendered when removed from the plugin.

= 1.3.1 =

* Added some messages to encourage people to suggest premade tags.
* Added version numbers. These are stored in DB to aid future upgrades.

= 1.3 =

This was a dummy release to fix an SVN issue with the 1.2 release!

= 1.2 =

* Added Premade shortcodes and framework to add additional ones
* Added Top Level menu item to support two sub pages. One for user defined shortcodes and another for premade shortcodes.

= 1.1 =
* Added caching to SQL queries. Therefore making shortcode rendering faster and reduce load on mySQL.
* TinyMCE editor for editing shortcode content.
* You can now specify other shortcodes within your shortcode variables.
* Readme.txt fixes

= 1.0 =
* Initial Release
