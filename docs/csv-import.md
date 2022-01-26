# Import shortcodes via CSV

> The following feature is only available in the [Premium](https://shop.yeken.uk/product/shortcode-variables/) version of the plugin.

Rather than manually add shortcodes to your [shortcode collection]({{ site.baseurl }}/shortcodes-own.html), Snippet Shortcodes has a CSV import tool which allows you to bulk import shortcodes.

**Note:** Depending on your server, you may need to split larger CSV files into smaller, more manageable sizes for performance reasons. As a guide, we'd recommend processing no more than 500 rows at a time.

### CSV Format

A CSV file must adhere to the following rules:

- Have a header row with the following headers:

```
slug,content,global,enabled
```

*Note: The column "content" is required however, the data for each row can be left blank if not required.*

- Have one or more data rows.
- For each row, ensure the following are met:
    - Has a "slug" that is 100 characters or less.
    - Ideally have a value for "content" - otherwise you're importing a blank column.
    - A value of "yes", "no", "true" or "false" for "global".
    - A value of "yes", "no", "true" or "false" for "enabled".
    
**Note:** If the import finds the above rules haven't been met, then the row will either be skipped or fail.

#### A simple CSV example

```
slug,content,global,enabled
business-development,Robust background support,false,false
human-resources,Stand-alone regional encoding,false,true
legal,Automated needs-based utilisation,false,false
support,Our support team is located in Canada,false,false
...
```

### Importing a CSV file

- Via the WordPress Admin menu, navigate to "Snippet Shortcodes" > "Import Shortcodes".
- Using the button labelled "Select CSV", choose a CSV file already uploaded into your Media Library or upload a new one from your computer.
- Examine the output report and action any errors.

#### Dry run mode

If selected, dry run mode will run basic tests against each row without attempting to update the database. We recommend you do this before performing an import as it gives the opportunity to correct any issues before attempting the main import.