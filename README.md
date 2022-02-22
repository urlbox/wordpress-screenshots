# Urlbox WordPress Screenshots

🎉 Easily display screenshots of websites right in your WordPress site 🎉

Uses the [Urlbox](https://urlbox.io) API to generate website screenshots from any URL and displays them in your WordPress site using a simple shortcode.

Just add the `[urlbox]` shortcode to any of your posts with the Shortcode block.

## Basic Example

Just use `[urlbox url=urlbox.io thumb_width=600]` in a Shortcode block.

This will generate the following screenshot:

![urlbox.io](https://api.urlbox.io/v1/ca482d7e-9417-4569-90fe-80f7c5e1c781/8f949c12462f53ea3359a412f536ceb69a8ce8e8/png?url=urlbox.io&thumb_width=600)

## Full Page Screenshot Example

Add full_page=true to your shortcode options `[urlbox url=urlbox.io thumb_width=600 full_page=true]`

And the resulting screenshot will look like this:

![urlbox.io](https://api.urlbox.io/v1/ca482d7e-9417-4569-90fe-80f7c5e1c781/5efad4d9d0ce3b77f1ec529c8b201ad93beeb14c/png?url=urlbox.io&thumb_width=600&full_page=true)

## What do you need

- WordPress
- Urlbox Account
- Urlbox API key and secret

[Sign up to obtain your API Key and Secret at urlbox.io](https://urlbox.io)

## Usage

Using the plugin is very easy:

- First activate the plugin and fill in your Urlbox.io API Key and Secret in the settings page. (Settings -> Urlbox)

- (Optional) Set default options for your screenshots, such as width, height, and thumbnail width on the plugin settings page.

- Now when you want to display a screenshot inside a post, simply use the following shortcode in a Shortcode block:

`[urlbox url=google.com] // display a screenshot of google.com `

- If you want to add any extra settings, simply pass the option into the shortcode:

`[urlbox url=google.com full_page=true thumbnail_width=400] // display a full_page screenshot of google, thumbnailed down to 400px wide`

- The plugin wraps the `<img>` element inside a `<figure>` element. You can set the class of both of these elements from the settings page (which will apply to all screenshots), and also override these settings for individual screenshotscby passing in the options in the shortcode:

`[urlbox url=google.com div_class=my-div-class img_class=my-img-class ] // change the css classes of the elements`

## Frequently asked questions

- How to change options from the shortcode?

Pass them in like so: `[urlbox url=www.bbc.co.uk width=100]`
See the plugin settings page for all possible options

## Screenshots

1. Settings view
   ![Settings view](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/.wordpress-org/screenshot-1.png)

2. Using the shortcode in a post
   ![Using the shortcode in a post](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/.wordpress-org/screenshot-2.png)

3. Viewing the results
   ![Viewing the post](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/.wordpress-org/screenshot-3.png)

## Known Bugs

- None at this time

## Changelog

### 1.5.1

Updated HTML output and instructions for the block editor; tested with WordPress 5.9

### 1.5

Fixed minor bugs and tested with Wordpress 5.7-beta

### 1.0

Initial Release

## Upgrade Notice

### 1.5

Fixed minor bugs and tested with Wordpress 5.7-beta

### 1.0

Initial Release!
