=== Snippet Shortcodes ===
Contributors: aliakro
Donate link: https://www.paypal.me/yeken
Tags: shortcode, variable, php, text, html, parameter, javascript, embed, reuse
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 4.1.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://www.paypal.me/yeken

Create your own shortcodes and assign text, html, etc to them. Use these across your site and only change in one place - saving time and effort!

== Description ==

= DOCUMENTATON / UPGRADE =

[Snippet Shortcodes Website](https://snippet-shortcodes.yeken.uk/ "Snippet Shortcodes Website")

= WHAT IS SNIPPET SHORTCODES? =

Do you want to use the same snippet of text or HTML throughout your site but only have to change the value in one location? If so, this plugin maybe just what you need.

Create your own Shortcodes and assign content to them. Using the standard WP editor, you can add text, HTML, JavaScript, images or other elements that your WordPress install and plugins allow. The main advantage is ability to create a shortcode once and re-use it throughout your site.

[ sv slug="your-slug-name"]

= FEATURES =

* Create a shortcode once and place in multiple locations.
* Update the shortcode in one location and it changes throughout your site.
* Parameters to extend your shortcodes.
* Free and Premium helper shortcodes to make life easier.
* Multi-site support.
* Process shortcodes within WordPress menu titles.

= SPECIFY PARAMETERS =

In some cases you may wish to make your shortcodes more extendable. This is where parameters come in. For example, you may have a shortcode that renders a HTML table, however, depending on where you place that shortcode on your site, you may wish to specify additional arguments. Take the example below, you can see the additional arguments passed into shortcode, “border”, “background” etc.

[ sv slug="render-table" border="0" background="#FFFFFF" width="50%" site-title="YeKen"]

Each argument can be rendered into the shortcode in the with the following syntax %%background%%, %%width%%, etc. Below is an example:

<table border=”%%border%%” style=”background:%%background%%” width=”%%width%%”>
<tr>
<td>Welcome to our site, %%site-title%%.</td>
</tr>
</table>

**Premium Shortcodes**

The plugin comes with the following premium shortcodes:

- sc-date - A shortcode that displays today's date with the ability to add or subtract days, months and years. To specify an interval to add or subtract onto the date use the parameter "interval" e.g. [sv slug="sc-date" interval="-1 year"], [sv slug="sc-date" interval="+5 days"], [sv slug="sc-date" interval="+3 months"]. Intervals are based upon PHP intervals and are outlined here <a href="https://www.php.net/manual/en/dateinterval.createfromdatestring.php" target="_blank">https://www.php.net/manual/en/dateinterval.createfromdatestring.php</a>. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>
- sc-db-value-by-id - A shortcode that fetches a value from the given MySQL table. Specify which column the value should be fetched from as well as specify which column should be matched against for the given key.
- sc-site-language - Language code for the current site
- sc-site-description - Site tagline (set in Settings > General)
- sc-site-wp-url - The WordPress address (URL) (set in Settings > General)
- sc-site-charset - The "Encoding for pages and feeds"  (set in Settings > Reading)
- sc-site-wp-version - The current WordPress version
- sc-site-html-type - The content-type (default: "text/html"). Themes and plugins
- sc-site-stylesheet-url - URL to the stylesheet for the active theme.
- sc-site-stylesheet_directory - Directory path for the active theme.
- sc-site-template-url - The URL of the active theme's directory.
- sc-site-current-url - The current URL.
- sc-site-register-url - The URL to the WordPress registration page.
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
- sc-user-counts - Display a count of all WordPress users or the number of WordPress users for a given role e.g. [sv slug="sc-user-counts" role="subscriber"] or [sv slug="sc-user-counts"].
- sc-user-profile-photo - Display the WordPress profile photo for the logged in user e.g. [sv slug="sc-user-profile-photo" width="150"] or [sv slug="sc-user-profile-photo"]. Please note, width defaults to 96px.

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
3. Search for "Snippet Shortcodes"
4. Click Install now and activate plugin
5. Goto Settings > Snippet Shortcodes

== Frequently Asked Questions ==

= How do I add / edit / delete Snippet Shortcodes =

Login into Wordpress Admin Panel and goto Settings > Snippet Shortcodes

== Screenshots ==

1. View all Snippet Shortcodes created.
2. Add a new Snippet Shortcode
3. Edit an existing Snippet Shortcode
4. Using the Snippet Shortcodes into a page
5. Snippet Shortcodes rendered in a page

== Upgrade Notice ==

4.1 -[sv slug="sc-db-value-by-id"], new Premium shortcode for fetching a value from a MySQL table.

== Changelog ==

= 4.1.7 =

* Improvement: Added additional security checks to Ajax handlers.

= 4.1.6 =

* New Feature: Extended [sv slug="sc-db-value-by-id"] shortcode to include the new argument "key-query-string". This allows a key to be read from the matching querystring value. Read more: https://snippet-shortcodes.yeken.uk/shortcodes/sc-db-value-by-id.html

= 4.1.5 =

* Maintenance: Added a nonce to the main admin Add/Edit UI screen. Although the form was on an admin screen and not exposed to the public, it doesn't hurt to add a nonce as well. Thanks Benedictus Jovan (aillesiM).

= 4.1.4 =

* Maintenance: Updated tested with WP 6.5 note.

= 4.1.3 =

* Bug fix: Fixed incorrect reference to ws_ls_to_bool() with sh_cd_to_bool()

= 4.1.2 =

* Improvement: By default, the shortcode [sv slug="sc-db-value-by-id"] shall be disabled unless explicitly enabled in WP Admin.
* Improvement: Added the setting ''"sc-db-value-by-id" shortcode enabled?' to enable the shortcode [sv slug="sc-db-value-by-id"].
* Improvement: Added filter "disable-ss-sc-db-value-by-id" to hard disable the shortcode [sv slug="sc-db-value-by-id"].

= 4.1.1 =

* Improvement: Dropped the database table prefix from the shortcode [sv slug="sc-db-value-by-id"] e.g. instead of specifying "users" table, it would now be "wp_users" (i.e. if a WP table, specify the prefix)

= 4.1 =

* New Feature: New Premium shortcode for fetching a value from a MySQL table, [sv slug="sc-db-value-by-id"]. Read more: https://snippet-shortcodes.yeken.uk/shortcodes/sc-db-value-by-id.html

= 4.0.4 =

* Bug fix: Added extra error handling around no multisite tags.

= 4.0.3 =

* Updated "Tested upto" statement.

= 4.0.2 =

* Tested up to version 6.0.

= 4.0.1 =

* Updated "Tested upto" WP version.

= 4.0 =

* New feature: Bulk import of shortcodes via CSV.
* New feature: Quick Add shortcodes without having to open the editor and wait for page refreshes.
* Improvement: Shortcodes can be deleted via Ajax on the list page. This saves waiting for a page refresh.
* Improvement: Added "loading" animations on relevant UI elements.
* Improvement: General code refactoring.
* Bug fix: Allowed text in JS files to be correctly localised.

= 3.5.4 =

* Updated version WP compatibility statement.

= 3.5.3 =

* Updated version WP compatibility statement.

= 3.5.2 =

* Version bump.

= 3.5.1 =

* Bug fix: Corrected documentation and GitHub issue links.
* Added a little text about emailing in suggestions.

= 3.5 =

* New Feature: New settings page.
* New Feature: Allow authors and editors to view and edit your shortcodes.

= 3.4.1 =

* Bug fix: Fixed issue with saving.

= 3.4 =

* Improvement: Cosmetic tweaks to shortcode list table.
* Bug fix: Fixed an issue where license price wasn't being displayed correctly.
* Change: Updated links to new documentation website: https://snippet-shortcodes.yeken.uk/
* Change: Free users are now limited to 15 shortcodes.
* Change: Tweaked Upgrade URL and default price.

= 3.3.3 =

* Updated "Tested upto" statement within readme.txt.

= 3.3.2 =

* Renamed plugin to Snippet Shortcodes!

= 3.3.1 =

* Updated tested upto version for 5.6

= 3.3 =

* Improvement: Removed "Your shortcode has been saved" confirmation page.

= 3.2.1 =

* Readme tweaks.

= 3.2 =

* New Shortcode: "sc-user-profile-photo" - display the current user's profile photo.

= 3.1.1 =

* Updated compatibility version number.

= 3.1 =

* New Shortcode: "sc-site-current-url" - get the current URL.
* New Shortcode: "sc-site-register-url" - get the URL for the WordPress registration page.
* Improvement: Added localised strings so plugin can now be translated.
* Improvement: Licenses are now checked daily and on each upgrade to ensure they are still valid.
* Bug fix: Missing array element throwing error on shortcode listing page.
* Bug fix: PHP warning being thrown on license page when one hasn't been added.
* Bug fix: Always create multisite database table regardless.

= 3.0.4 =

* Improvement: Fetch license price from YeKen API

= 3.0.3 =

* Bug fix: Removed debug data altogether as causing unintended behaviour.

= 3.0.2 =

* Bug fix: Only display HTML caching comment on pages / posts. Currently rendering on things like AJAX responses and causing unintended behaviour.

= 3.0.1 =

* Bug fix: Fix error being thrown when not a multi site and DB table missing.

= 3.0 =

* Improvement: Support for multi-site variables.
* Improvement: Replace shortcodes within menu titles.

= 2.4.1 =

* Bug fix: fixed save_result undeclared variable error.

= 2.4 =

* New Feature: Added a button to the WordPress text editor (classic mode) to allow users to easily insert shortcodes.
* New Fetaure: Added a new shortcode sc-date. Allows you to do render today's date and add or subtract days, months and years.

= 2.3 =

* Improvement: sc-user-counts - Display a count of all WordPress users or the number of WordPress users for a given role e.g. [sv slug="sc-user-counts" role="subscriber"] or [sv slug="sc-user-counts"].

= 2.2.1 =

* Bug fix: Fixed issue with clone.

= 2.2 =

* Improvement: Slugs can now be edited.

= 2.1 =

* New Feature: Added the ability to clone your own shortcodes.

= 2.0.1 =

* Bug fix: Fixed broken menu

= 2.0 =

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
* You can now specify other shortcodes within your Snippet Shortcodes.
* Readme.txt fixes

= 1.0 =
* Initial Release
