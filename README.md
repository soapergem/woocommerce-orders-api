# WooCommerce Orders API

This WordPress plugin adds a simple API endpoint to allow you to retrieve recent orders as a JSON list.

## Installation

Go to the [Releases] and find the most recent plugin.zip file. Unzip the contents and copy the folder
contained therein (named `woocommerce-orders-api`) into your `wp-content/plugins/` directory. Finally,
be sure to go into the Plugins page in your Administrative interface and activate the plugin.

In the future I may try and publish this on wordpress.org to make things easier. However at the time
I'm writing this, their plugin submission queue is currently closed.

## Usage

To authenticate you need to create an [Application Password]. Log into your administrative interface
and go to Users. Keep note of your user's username as you will use this. Click on Edit User and scroll
down to the section labeled "Application Passwords." Here you will need to enter a name for your
calling application in the box labeled "New Application Password Name" and then click the
"Add New Application Password" button. It will show you the generated password exactly once so be sure
to copy it down. Note that spaces in the password do not matter as they get stripped off automatically.
Also note that whatever value you entered in the box to name your calling application does not matter
and will never be used; it is merely a way of identifying your application on this Edit User screen
in case you ever need to revoke it in the future.

Once you know your username and have generated your application password, you can use it by hitting
the endpoint that this plugin provides. If your site is hosted at mywpsite.com, you could access it
by doing this:

```bash
curl -u 'USERNAME:APP_PASSWORD' 'https://mywpsite.com/wp-json/wc-orders-api/v1/orders'
```

There are currently two supported query string parameters:

* `limit` - How many results to return (default: 25)
* `after` - Date after which orders should be filtered (default: *none*)

So for instance you might call the endpoint like this:

```bash
curl -u 'USERNAME:APP_PASSWORD' 'https://mywpsite.com/wp-json/wc-orders-api/v1/orders?limit=10&after=2025-01-15'
```

Doing so would retrieve up to 10 orders that came in after January 15, 2025. The results are always
ordered by showing the most recent order first.


[Releases]: https://github.com/soapergem/woocommerce-orders-api/releases
[Application Password]: https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
