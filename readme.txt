=== Urlbox Screenshots ===
Contributors: Chris Roebuck, Ankur Gurha, James Ogilvie
Author: Urlbox
Tags: screenshot,screenshots,puppeteer,playwright,urlbox,url screenshot,url to png, url2png,wordpress website screenshots,retina screenshots,responsive screenshots,wordpress,plugin,integration
Requires at least: 3.3
Tested up to: 5.9
Stable tag: 1.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

🎉 Easily display website screenshots of any URL in your Wordpress site 🎉

This plugin uses the Urlbox API to generate website screenshots and display them on your site. Please note the Urlbox API is a paid service - you can sign up for a trial at <https://urlbox.io>.

**How to use the plugin**

1. First activate the plugin and fill in your Urlbox.io API Key and Secret in the settings page.

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
* Your Urlbox API key and secret (From: <https://urlbox.io>)

== Installation ==

1. Upload the Urlbox plugin directory to the `/wp-content/plugins/urlbox` directory or install using the WordPress plugin installer
2. Activate the plugin through the **Plugins** menu in WordPress
3. Edit default settings as necessary using **Urlbox Options**
4. Create a new page or post, or edit an existing one
5. Insert your shortcode using the Shortcode block
6. Customise your screenshots by changing options in your shortcodes

== Frequently asked questions ==

= How to change options from the shortcode

Pass them in like so: [urlbox url=www.bbc.co.uk width=100]
See <https://urlbox.io/docs/options> for default values

== Screenshots ==

1. Settings view
2. Using the shortcode in a post
3. Viewing the results

== Known Bugs ==

* None at this time

== Changelog ==

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