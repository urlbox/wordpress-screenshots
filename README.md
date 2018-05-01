# Easily display screenshots of websites right in your Wordpress site#
Uses the [Urlbox](https://urlbox.io) API to generate screenshots and display them in your wordpress using a simple shortcode

As simple as ```[urlbox url='urlbox.io' thumb_width='600' full_page=true]```!

This shortcode would generate the following screenshot:
![urlbox.io](https://api.urlbox.io/v1/ca482d7e-9417-4569-90fe-80f7c5e1c781/5efad4d9d0ce3b77f1ec529c8b201ad93beeb14c/png?url=urlbox.io&thumb_width=600&full_page=true)


## What do you need ##

* Wordpress
* Urlbox Account
* Urlbox API key and secret 

[Signup for your free trial at urlbox.io](https://urlbox.io)

## Usage ##

Using the plugin is very easy..

* First activate the plugin and fill in your Urlbox.io API Key and Secret in the settings page.

* Set default options for your screenshots, such as width, height, thumbnail_width on the plugin settings page.

* Now when you want to display a screenshot inside a post, simply use the following shortcode:

```[urlbox url='google.com'] // this will display a screenshot of google.com ```

* If you want to override any of the settings, simply pass the option into the shortcode:

```[urlbox url='google.com' full_page='true' thumbnail_width=400] // displays a full_page screenshot of google, thumnailed down to 400px wide```

* The plugin wraps the ```<img>``` tag inside a ```<div>```, you can set the class of both this div and the img tag from the settings page, and also override these settings by passing in the options in the shortcode:

```[urlbox url='google.com' div_class='mydivclass' img_class='myimgclass' ] // change the css classes of the wrapping div and img element```


## Frequently asked questions ##

* How to change options from the shortcode?

Pass them in like ```[urlbox url='www.bbc.co.uk' width='100']```
See the plugin settings page for all possible options

## Screenshots ##

1. Settings view
![Settings view](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/screenshot-1.png)

2. Using the shortcode in a post
![Using the shortcode in a post](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/screenshot-2.png)

3. Viewing the results
![Viewing the post](https://raw.githubusercontent.com/urlbox-io/wordpress-screenshots/master/screenshot-3.png)

## Known Bugs ##

* None at this time

## Changelog ##

### 1.0 ###
Initial Release

## Upgrade Notice ##

### 1.0 ###
Initial Release!
