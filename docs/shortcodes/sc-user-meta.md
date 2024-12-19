## [sv slug="sc-user-meta"]

> The following shortcode are only available in the [Premium](https://shop.yeken.uk/product/shortcode-variables/) version of the plugin.

Fetch and display a WordPress user meta field for the user currently logged in. This shortcode, in essence, wraps around the WP PHP function [get_user_meta()](https://developer.wordpress.org/reference/functions/get_user_meta/).

**Easy-to-use examples**

Below are some examples of default WordPress user meta fields. However, plugins often add their own (e.g. [[WooCommerce]]({{ site.baseurl }}/shortcodes/sc-user-meta.html) ) this shortcode will allow you to fetch their fields too.


```
[sv slug="sc-user-meta" field="user_login"]
[sv slug="sc-user-meta" field="first_name"]
[sv slug="sc-user-meta" field="last_name"]
[sv slug="sc-user-meta" field="nickname"]
[sv slug="sc-user-meta" field="email"]
[sv slug="sc-user-meta" field="user_url"]
[sv slug="sc-user-meta" field="description"]
```

**Shortcode Arguments**

The shortcode supports the following arguments:

| Argument          | Description                                                                              | Options                                         | Example |
|-------------------|------------------------------------------------------------------------------------------|-------------------------------------------------|--|
| field             | User meta field to display e.g. last_name                                                                    | text                                            | [sv slug="sc-user-meta" field="last_name"]
| message-not-found             | Message to display if field is empty    | Text                        | [sv slug="sc-user-meta" field="last_name" message-not-found="Last name is missing"]