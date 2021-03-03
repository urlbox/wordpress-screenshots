=== WP-Urlboxplugin ===
Contributors: Chris Roebuck, Ankur Gurha
Author: Urlbox
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EZLKTKW8UR6PQ
Tags: screenshot,screenshots,puppeteer,playwright,urlbox,url screenshot,url to png, url2png,website screenshots,retina screenshots,responsive screenshots,wordpress,plugin,integration
Requires at least: 3.3
Tested up to: 5.7
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin uses the Urlbox API to generate website screenshots and display them on your site

== Description ==

Easily display screenshots of websites right in your Wordpress site.  

Using the plugin is very easy..

First activate the plugin and fill in your Urlbox.io API Key and Secret in the settings page.

You can also set default options for your screenshots, such as width, height, thumbnail_width on the plugin settings page.

Now when you want to display a screenshot inside a post, simply use the following shortcode:

[urlbox url='google.com'] // this will display a screenshot of google.com 

If you want to override any of the settings, simply pass the option into the shortcode:

[urlbox url='google.com' full_page='true' thumbnail_width=400] // displays a full_page screenshot of google, thumnailed down to 400px wide

The plugin wraps the <img> tag inside a <div>, you can set the class of both this div and the img tag from the settings page, and also override these settings by passing in the options in the shortcode:

[urlbox url='google.com' div_class='mydivclass' img_class='myimgclass' ] // change the css classes of the wrapping div and img element

**What do you need**

* Wordpress
* Urlbox Account
* Urlbox API key and secret (From: `https://urlbox.io`)

== Installation ==

1. Upload the urlbox plugin directory to the `/wp-content/plugins/urlbox` Directory or install using wordpress plugin installer
2. Activate the plugin through the **Plugins** menu in WordPress
3. Edit default settings using **Urlbox Options**
4. Create a new site or edit an existing site
5. Insert shortcode into post

[urlbox url='google.com']

6. Customise screenshots via the shortcode

[urlbox url='google.com' width=320] // display mobile screenshot of google.com


== Frequently asked questions ==

= How to change options from the shortcode

Pass them in like [urlbox url='www.bbc.co.uk' width='100']

== Screenshots ==

1. Settings view
2. Using the shortcode in a post
3. Viewing the results

== Known Bugs ==

* None at this time

== Changelog ==

= 1.3 =
Fixed minor bugs and tested with Wordpress 5.7-beta

= 1.0 =
Initial Release

== Upgrade Notice ==

= 1.3 =
Fixed minor bugs and tested with Wordpress 5.7-beta

= 1.0 =
Initial Release!