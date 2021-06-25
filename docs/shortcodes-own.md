# Your own shortcodes

The biggest advantage of Snippet Shortcodes is the ability to create a library of shortcodes. Each shortcode allows you to render the same content throughout your site and only requires you to update the content in one place.

The initial screen (“Shortcode Snippets” > “Your Shortcodes”) will list all of your existing shortcodes. If you have the [Premium version](https://shop.yeken.uk/product/shortcode-variables/) then you will have the ability to edit and toggle settings inline. For each shortcode you have the ability to edit or delete a shortcode.

[![List]({{ site.baseurl }}/assets/images/list.png)]({{ site.baseurl }}/assets/images/list.png)

Adding or editing a shortcode will show you the following screen. Here you can specify a slug for the shortcode as well as the content that should be rendered where the shortcode is placed.

[![Add/Edit]({{ site.baseurl }}/assets/images/add-edit.png)]({{ site.baseurl }}/assets/images/add-edit.png)

### Specify Parameters
In some cases you may wish to make your shortcodes more extendable. This is where parameters come in. For example, you may have a shortcode that renders a HTML table, however, depending on where you place that shortcode on your site, you may wish to specify additional arguments. Take the example below, you can see the additional arguments passed into shortcode, “border”, “background” etc.

```
[ sv slug="render-table" border="0" background="#FFFFFF" width="50%" site-title="YeKen"]
```

Each argument can be rendered into the shortcode in the with the following syntax %%background%%, %%width%%, etc. Below is an example:

```
<table border=”%%border%%” style=”background:%%background%%” width=”%%width%%”>
   <tr>
   <td>Welcome to our site, %%site-title%%.</td>
   </tr>
</table>
```
