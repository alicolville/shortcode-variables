## [sv slug="sc-woocommerce"]

> The following shortcode are only available in the [Premium](https://shop.yeken.uk/product/shortcode-variables/) version of the plugin.

Fetch and display a WooCommerce user profile field for the user currently logged in. 

**Easy-to-use examples**

Below are some examples, however, following [WooCommerce's documentation](https://developer.woocommerce.com/docs/customizing-checkout-fields-using-actions-and-filters/) will provide additional field names.

```
[sv slug="sc-woocommerce" field="billing_first_name"]
[sv slug="sc-woocommerce" field="billing_last_name"]
[sv slug="sc-woocommerce" field="billing_company"]
[sv slug="sc-woocommerce" field="billing_address_1"]
[sv slug="sc-woocommerce" field="billing_address_2"]
[sv slug="sc-woocommerce" field="billing_city"]
[sv slug="sc-woocommerce" field="billing_postcode"]
[sv slug="sc-woocommerce" field="billing_country"]
[sv slug="sc-woocommerce" field="billing_state"]
[sv slug="sc-woocommerce" field="billing_email"]
[sv slug="sc-woocommerce" field="billing_phone"]
[sv slug="sc-woocommerce" field="shipping_first_name"]
[sv slug="sc-woocommerce" field="shipping_last_name"]
[sv slug="sc-woocommerce" field="shipping_company"]
[sv slug="sc-woocommerce" field="shipping_address_1"]
[sv slug="sc-woocommerce" field="shipping_address_2"]
[sv slug="sc-woocommerce" field="shipping_city"]
[sv slug="sc-woocommerce" field="shipping_postcode"]
[sv slug="sc-woocommerce" field="shipping_country"]
[sv slug="sc-woocommerce" field="shipping_state"]
```

**Shortcode Arguments**

The shortcode supports the following arguments:

| Argument          | Description                                                                              | Options                                         | Example |
|-------------------|------------------------------------------------------------------------------------------|-------------------------------------------------|--|
| field             | WooCommerce field to display e.g. billing_address                                                                    | text                                            | [sv slug="sc-woocommerce" field="billing_phone"]
| message-not-found             | Message to display if field is empty    | Text                        | [sv slug="sc-woocommerce" field="billing_phone" message-not-found="Phone number is missing"]