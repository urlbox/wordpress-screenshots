# Urlbox WordPress Screenshots

🎉 Easily display screenshots of websites right in your WordPress site 🎉

Uses the [Urlbox](https://urlbox.com) API to generate website screenshots from any URL and displays them in your WordPress site using a simple shortcode.

Just add the `[urlbox]` shortcode to any of your posts with the Shortcode block.

## Basic Example

Just use `[urlbox url=urlbox.com thumb_width=600]` in a Shortcode block.

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

[Sign up to obtain your API Key and Secret at urlbox.com](https://urlbox.com)

## Usage

Using the plugin is very easy:

- First activate the plugin and fill in your Urlbox.io API Key and Secret in the settings page. (Settings -> Urlbox)

- (Optional) Set default options for your screenshots, such as width, height, and thumbnail width on the plugin settings page.

- Now when you want to display a screenshot inside a post, simply use the following shortcode in a Shortcode block:

`[urlbox url=google.com] // display a screenshot of google.com `

- If you want to add any extra settings, simply pass the option into the shortcode:

`[urlbox url=google.com full_page=true thumbnail_width=400] // display a full_page screenshot of google, thumbnailed down to 400px wide`

- The plugin wraps the `<img>` element inside a `<figure>` element. You can set the class of both of these elements from the settings page (which will apply to all screenshots), and also override these settings for individual screenshots by passing in the options in the shortcode:

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

### 1.5.3 

Updates shortcode logic to allow an 'alt' attribute in the <img> tag

### 1.5.2

Updated shortcode logic to allow all Urlbox API options

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

## Releasing/Updating the Plugin on Wordpress

[Wordpress URLBox Screenshots Plugin for Developers](https://wordpress.org/plugins/urlbox-screenshots/#developers)

### Overview

By creating a new tagged release with the zipped repo, GH actions should automatically update the wordpress.org repository.

Wordpress uses SVN, similar to Github.

The plugin is stored centrally on their servers, so any changes need to be pushed to their server using the svn CLI (there are also GUI's).

The publicly available svn repo is available for anyone to check out.

Simply go to:

https://plugins.svn.wordpress.org/urlbox-screenshots/

And you'll see the publicly available repo served by apache.

NOTE - When updating to a new tag, ensure that the tag number is updated in the wordpress meta fields in both the readme.txt and the core .php file.

### Steps to update manually via SVN:

If the GH actions deployment isn't working you can update the plugin manually via SVN.

1. Checkout the svn repo

``` svn checkout https://plugins.svn.wordpress.org/urlbox-screenshots/ ```

2. Make changes from Github

Copy any files which changed in the github repo into the svn repo's /trunk directory. This would typically be the readme.txt (which Wordpress uses for your readme on their website) and urlbox-screenshots.php.

The /trunk directory is the 'working' or 'dev' directory. It is where unstable releases would typically sit.

NOTE - Make sure that readme.txt and urlbox-screenshots.php now includes the latest tag number.

3. make a new tag by copying the trunk folder into the new tag number (use versioning major/minor/patch):

``` cp /trunk /tags/1.5.3 ```

Check the svn status:

``` svn status ```

Any new files will have a `?` beside them, and any modified will have `M` beside them.

Add new files using:

``` svn add your/filepath ```

4. Finally, by committing them changes will be pushed to the remote server:

``` svn commit --username=USERNAMEGOESHERE --password=PASSWORDGOESHERE ```

Ensure the changes took effect by going [here](https://wordpress.org/plugins/urlbox-screenshots/#developers)

#### Further resources

https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/

See every publicly served github plugin - https://plugins.svn.wordpress.org/
