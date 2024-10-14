=== Urlbox Screenshots ===
Contributors: Chris Roebuck, Ankur Gurha, James Ogilvie, Arnold Cubici-Jones
Author: Urlbox
Tags: screenshot,screenshots,puppeteer,playwright,url to png
Requires at least: 6.0
Tested up to: 6.6.1
Stable tag: 1.6.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

🎉 Easily display website screenshots of any URL in your Wordpress site 🎉

This plugin uses the Urlbox API to generate website screenshots and display them on your site. Please note the Urlbox API is a paid service - you can sign up for a trial at <https://urlbox.com>.

**How to use the plugin**

When running Wordpress locally or in a containerised environment, we recommend you use at least Wordpress version 6.0 and PHP 8.0.

1. First activate the plugin and fill in your Urlbox.com API Key and Secret in the settings page.

2. (Optional) You can set default options for your screenshots such as width, height, and thumbnail width on the plugin settings page.

3. Now when you want to display a screenshot inside a post or page, just use the following in a Shortcode block:

[urlbox url=google.com] // display a screenshot of google.com 

If you want to override any of the settings, just pass the option into the shortcode:

[urlbox url=google.com full_page=true thumbnail_width=400] // display a full_page screenshot of google.com thumnailed down to 400px wide

The plugin wraps the `<img>` element inside a `<figure>` element. You can set the class of both the figure and the img elements from the settings page (which will apply to all screenshots), and also override these settings for an individual screenshot by passing the options in the shortcode:

[urlbox url=google.com figure_class=my-figure-class img_class=my-img-class ] // change the css classes of the wrapping figure and img element

**What do you need**

* WordPress
* A Urlbox Account
* Your Urlbox API key and secret (From: <https://urlbox.com>)

== Installation ==

1. Upload the Urlbox plugin directory to the `/wp-content/plugins/urlbox` directory or install using the Wordpress plugin installer
2. Activate the plugin through the **Plugins** menu in Wordpress
3. Edit default settings as necessary using **Urlbox Options**
4. Create a new page or post, or edit an existing one
5. Insert your shortcode using the Shortcode block
6. Customise your screenshots by changing options in your shortcodes

== Frequently asked questions ==

= How to change options from the shortcode

Pass them in like so: [urlbox url=www.bbc.co.uk width=100]
See <https://urlbox.com/docs/options> for default values

== Screenshots ==

1. Settings view
2. Using the shortcode in a post
3. Viewing the results

== Known Bugs ==

1.6.0 - Bug in proxy logic. Testing one's proxy connection in the plugin's settings will not work due to an 'Invalid JSON' error, because of a lack of JSON encoding. This error does not display in the Wordpress playground, but will display in any dockerised/live environment. Action taken was to fix the bug and release 1.6.1, and introduce a dockerised test/development environment for future coverage before releases.

== Changelog ==

= 1.6.2 =

Update instances of .io to .com. This includes the generated URL made by the generateUrl() method.

= 1.6.1 =

Performs a refactor of the plugin, fixing a bug in the proxy logic, adding more documentation to docblocks, improving security issues, and decoupling proxy logic into a specific test method for the proxy connection and a generalised POST /sync method.

= 1.6.0 =

Introduce proxy logic, so users can make urlbox screenshot requests via their proxy which is set in the plugin settings.

= 1.5.4 =

Fixes minor bug introduced in 1.5.3 - Checkbox state wasn't held in settings.

= 1.5.3 =
Updates shortcode logic to allow an 'alt' attribute in the <img> tag

= 1.5.2 =
Updated shortcode logic to allow all Urlbox API options

= 1.5.1 =
Updated HTML output and instructions for the block editor; tested with WordPress 5.9

= 1.5 =
Fixed minor bugs and tested with WordPress 5.7-beta

= 1.0 =
Initial Release

== Upgrade Notice ==

= 1.5 =
Fixed minor bugs and tested with WordPress 5.7-beta

= 1.0 =
Initial Release!
