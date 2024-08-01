<?php

/**
 * The Urlbox Screenshots Plugin
 *
 * @package     Urlbox
 * @author      Urlbox
 * @copyright   2022 Urlbox Ltd
 * @license     GPL-2.0+
 * @since       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Urlbox Screenshots
 * Plugin URI:  https://urlbox.io
 * Description: Take screenshots of websites and display them on your wordpress site.
 * Version:     1.6.1
 * Author:      Urlbox
 * Author URI:  https://github.com/urlbox-io/wordpress-screenshots
 * Text Domain: urlbox-screenshots
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Urlbox class
 */
if (!class_exists('Urlbox')) {

	class Urlbox
	{
		const KEY_API_KEY = 'api_key';
		const KEY_API_SECRET = 'api_secret';
		const KEY_FORMAT = 'format';
		const KEY_URL = 'url';
		const KEY_THUMB_WIDTH = 'thumb_width';
		const KEY_WIDTH = 'width';
		const KEY_HEIGHT = 'height';
		const KEY_DELAY = 'delay';
		const KEY_USER_AGENT = 'user_agent';
		const KEY_QUALITY = 'quality';
		const KEY_DISABLE_JS = 'disable_js';
		const KEY_FULL_PAGE = 'full_page';
		const KEY_RETINA = 'retina';
		const KEY_FORCE = 'force';
		const KEY_TTL = 'ttl';
		const KEY_CUSTOM_CSS = 'customcss';
		const KEY_IMAGE_SIZE = 'imagesize';
		const KEY_DEBUG = 'debug';
		const KEY_FIGURE_CLASS = 'figure_class';
		const KEY_IMG_CLASS = 'img_class';
		const KEY_ALT = 'alt';
		const KEY_USE_PROXY = 'use_proxy';
		const KEY_USERNAME = 'username';
		const KEY_PASSWORD = 'password';
		const KEY_HOSTNAME = 'hostname';
		const KEY_PORT = 'port';
		const KEY_PROTOCOL = 'protocol';

		const PROTOCOL_HTTP = 'http';
		const PROTOCOL_HTTPS = 'https';

		// API Endpoints
		const API_ENDPOINT = 'https://api.urlbox.com/v1';
		const API_ENDPOINT_SYNC = self::API_ENDPOINT . '/render/sync';

		// Keys required to create a proxy endpoint.
		const PROXY_KEYS = [
			self::KEY_USERNAME,
			self::KEY_PASSWORD,
			self::KEY_HOSTNAME,
			self::KEY_PORT,
			self::KEY_PROTOCOL
		];

		// Keys we don't want sent in the request options.
		const FORBIDDEN_KEYS = [
			self::KEY_API_KEY,
			self::KEY_API_SECRET,
			self::KEY_FORMAT,
			self::KEY_CUSTOM_CSS,
			self::KEY_IMAGE_SIZE,
			self::KEY_FIGURE_CLASS,
			self::KEY_IMG_CLASS,
			self::KEY_ALT,
			self::KEY_USE_PROXY,
			self::KEY_USERNAME,
			self::KEY_PASSWORD,
			self::KEY_HOSTNAME,
			self::KEY_PORT,
			self::KEY_PROTOCOL,
		];

		public static $urlboxOptions;
		protected $option_name = 'urlbox_data';
		protected $fields = array();
		public $default_values = array(
			self::KEY_API_KEY => '',
			self::KEY_API_SECRET => '',
			self::KEY_FORMAT => 'png',
			self::KEY_URL => 'google.com',
			self::KEY_THUMB_WIDTH => '',
			self::KEY_WIDTH => '',
			self::KEY_HEIGHT => '',
			self::KEY_DELAY => '',
			self::KEY_USER_AGENT => '',
			self::KEY_QUALITY => '',
			self::KEY_DISABLE_JS => '',
			self::KEY_FULL_PAGE => '',
			self::KEY_RETINA => '',
			self::KEY_FORCE => '',
			self::KEY_TTL => '',
			self::KEY_CUSTOM_CSS => '',
			self::KEY_IMAGE_SIZE => '',
			self::KEY_DEBUG => '',
			self::KEY_FIGURE_CLASS => '',
			self::KEY_IMG_CLASS => '',
			self::KEY_ALT => '',
			self::KEY_USE_PROXY => '',
			self::KEY_USERNAME => '',
			self::KEY_PASSWORD => '',
			self::KEY_HOSTNAME => '',
			self::KEY_PORT => '',
			self::KEY_PROTOCOL => self::PROTOCOL_HTTPS,
		);

		/**
		 * Returns an instance of this class.
		 */
		public static function get_instance()
		{
			if (null == self::$instance) {
				self::$instance = new Urlbox();
			}

			return self::$instance;
		}

		public function __construct()
		{
			$this->set_fields();
			$this->set_hooks();
		}

		/**
		 * Sets the field definitions for the settings page
		 * @returns void
		 */
		public function set_fields()
		{
			$this->fields = array(
				array(
					"id" => "api_key",
					"name" => "API Key",
					"type" => "text",
					"section" => "required_section"
				),
				array(
					"id" => "api_secret",
					"name" => "API Secret",
					"type" => "text",
					"section" => "required_section"
				),
				array(
					"id" => "format",
					"name" => "Image Format",
					"type" => "radio",
					"options" => array('png' => "PNG", 'jpeg' => "JPEG", 'pdf' => "PDF", 'svg' => "SVG", 'webp' => "WEBP", 'html' => "HTML"),
				),
				// array(
				// 	"id" => "url",
				// 	"name" => "URL",
				// 	"type" => "text"
				// ),
				array(
					"id" => "thumb_width",
					"name" => "Thumbnail Width",
					"type" => "number",
					"min" => 0,
					"max" => 2000
				),
				array(
					"id" => "width",
					"name" => "Viewport Width",
					"type" => "number",
					"min" => 0,
					"max" => 4000
				),
				array(
					"id" => "height",
					"name" => "Viewport Height",
					"type" => "number",
					"min" => 0
				),
				array(
					"id" => "delay",
					"name" => "Delay (ms)",
					"type" => "number",
					"min" => 0,
					"max" => 60000
				),
				array(
					"id" => "user_agent",
					"name" => "User Agent String",
					"type" => "text"
				),
				array(
					"id" => "quality",
					"name" => "JPEG Quality",
					"type" => "number",
					"min" => 0,
					"max" => 100
				),
				array(
					"id" => "disable_js",
					"name" => "Disable JS",
					"type" => "checkbox"
				),
				array(
					"id" => "full_page",
					"name" => "Full Page",
					"type" => "checkbox"
				),
				array(
					"id" => "retina",
					"name" => "Retina Screenshot",
					"type" => "checkbox"
				),
				array(
					"id" => "force",
					"name" => "Force",
					"type" => "checkbox"
				),
				array(
					"id" => "ttl",
					"name" => "Time to live (seconds)",
					"type" => "number",
					"min" => 0,
					"max" => 2592000
				),
				array(
					"id" => "debug",
					"name" => "Debug Plugin",
					"type" => "checkbox"
				),
				array(
					"id" => "figure_class",
					"name" => "Figure element CSS class",
					"type" => "text",
					"section" => 'html'
				),
				array(
					"id" => "img_class",
					"name" => "Image element CSS class",
					"type" => "text",
					"section" => 'html'
				),
				array(
					"id" => "use_proxy",
					"name" => "Use Proxy",
					"type" => "checkbox",
					"section" => 'proxy'
				),
				array(
					"id" => "username",
					"name" => "Proxy Username",
					"type" => "text",
					"section" => 'proxy'
				),
				array(
					"id" => "password",
					"name" => "Proxy Password",
					"type" => "text",
					"section" => 'proxy'
				),
				array(
					"id" => "hostname",
					"name" => "Proxy Hostname",
					"type" => "text",
					"section" => 'proxy'
				),
				array(
					"id" => "port",
					"name" => "Proxy Port",
					"type" => "number",
					"section" => 'proxy'
				),
				array(
					"id" => "protocol",
					"name" => "Proxy Protocol",
					"type" => "radio",
					"options" => array('https' => "HTTPS", 'http' => "HTTP"),
					"default" => "https",
					"section" => 'proxy'
				),
			);
		}

		/**
		 * Registers all WordPress hooks and actions for the plugin.
		 *
		 * This method sets up the necessary filters and actions for the plugin's 
		 * operation, including:
		 *
		 * - Adding a settings link to the plugin's entry on the plugins page.
		 * - Registering admin menu pages and settings fields.
		 * - Enqueueing scripts and styles for both the admin dashboard and the frontend.
		 * - Registering AJAX actions for both authenticated and unauthenticated users.
		 * - Defining a shortcode for embedding the plugin's functionality in posts/pages/sites.
		 *
		 * @return void
		 */
		public function set_hooks()
		{
			add_filter('plugin_action_links', array($this, 'add_plugin_settings_link'), 10, 2);
			if (is_admin()) {
				add_action('admin_menu', array($this, 'add_urlbox_options_page'));
				add_action('admin_init', array($this, 'add_fields'));
				add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
				add_action('wp_ajax_test_proxy_connection', array($this, 'ajax_test_proxy_connection'));
			}
			add_shortcode('urlbox', array($this, 'urlbox_shortcode'));

			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
			add_action('wp_ajax_nopriv_proxy_fetch_render_url', array($this, 'ajax_proxy_fetch_render_url'));
			add_action('wp_ajax_proxy_fetch_render_url', array($this, 'ajax_proxy_fetch_render_url'));
		}

		/**
		 * Enqueues and localizes JavaScript for the WordPress admin dashboard.
		 *
		 * This method registers and enqueues the plugin's custom JavaScript file
		 * for the admin area, ensuring that it is loaded with the appropriate 
		 * dependencies. It localizes the script to pass dynamic data, such as 
		 * the AJAX URL and a nonce for security to the JavaScript environment.
		 *
		 * @return void
		 */
		public function enqueue_admin_scripts()
		{
			wp_enqueue_script('urlbox-admin-js', plugin_dir_url(__FILE__) . 'js/urlbox-admin.js', array('jquery'), null, true);
			wp_localize_script('urlbox-admin-js', 'urlbox_admin_ajax', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('urlbox_admin_nonce')
			));
		}

		/**
		 * Enqueues frontend scripts and styles for the plugin.
		 *
		 * This method loads the plugin's CSS and JavaScript files for the 
		 * frontend of the site. It also localizes the JavaScript file to pass
		 * the AJAX URL and a nonce for secure AJAX operations.
		 *
		 * @return void
		 */
		public function enqueue_scripts()
		{
			wp_enqueue_style('urlbox-style', plugin_dir_url(__FILE__) . 'css/urlbox-style.css');
			wp_enqueue_script('urlbox-js', plugin_dir_url(__FILE__) . 'js/urlbox.js', array('jquery'), null, true);
			wp_localize_script('urlbox-js', 'urlbox_ajax', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('urlbox_proxy_nonce')
			));
		}

		/**
		 * Adds the Urlbox options page to the WordPress admin menu.
		 *
		 * @return void
		 */
		public function add_urlbox_options_page()
		{
			// Create menu tab
			add_options_page(
				'Urlbox Options', // page title 
				'Urlbox', 				// menu title
				'manage_options', // capability
				'urlbox-screenshots', 		// menu slug
				array($this, 'render_admin_page') // callback
			);
		}

		/**
		 * Adds the settings link to the Urlbox settings on the plugin page.
		 *
		 * @return array $links
		 */
		public function add_plugin_settings_link($links, $file)
		{
			static $this_plugin;
			if (!isset($this_plugin))
				$this_plugin = plugin_basename(__FILE__);

			if ($file == $this_plugin) {
				$url = admin_url('options-general.php?page=urlbox-screenshots');
				$settings_link = "<a href='$url'>" . __("Settings", 'General') . '</a>';
				array_unshift($links, $settings_link);
			}
			return $links;
		}

		/**
		 * Renders the Urlbox plugin's admin settings page.
		 * Outputs the HTML for the plugin's settings page in the WordPress admin area.
		 *
		 * @return void
		 */
		public function render_admin_page()
		{
			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			// check if the user has submitted settings
			// wordpress will add the "settings-updated" $_GET parameter to the url
			if (isset($_GET['settings-updated'])) {
				add_settings_error('urlbox', 'urlbox_message', __('Settings Saved', 'urlbox'), 'updated');
			}
?>
			<div class='wrap'>
				<h1>Urlbox Settings</h1>
				<form method='post' action='options.php'>
					<?php
					settings_fields($this->option_name);
					do_settings_sections('urlbox-screenshots'); // Prints all settings
					?>
					<div style="display: flex; align-items: center; margin-top: 20px;">
						<button id="test-proxy-connection" class="button button-secondary"><?php _e('Test Proxy Connection', 'urlbox') ?></button>
						<div id="proxy-test-result" style="margin-left: 10px;"></div>
					</div>
					<?php submit_button('Save Settings');
					?>
				</form>
			</div>
<?php
		}

		/**
		 * Registers the settings and adds the fields to the plugin's settings page.
		 * @return void
		 */
		public function add_fields()
		{
			$option_values = get_option($this->option_name, array());
			$data = shortcode_atts($this->default_values, $option_values);

			register_setting(
				$this->option_name, // used by settings_fields() method to get the setting by group
				$this->option_name, // option name, used as key in db
				array($this, 'sanitize') // sanitizes the input before saving
			);
			add_settings_section(
				'required_section', // id
				'Required Options', // title
				array($this, 'printAuthSectionInfo'), // print output
				'urlbox-screenshots' // menu slug (see add_options_page)
			);
			add_settings_section(
				'default',
				'Default Options',
				array($this, 'printSectionInfo'),
				'urlbox-screenshots'
			);

			add_settings_section(
				'html',
				'HTML Options',
				array($this, 'printHtmlSectionInfo'),
				'urlbox-screenshots'
			);

			add_settings_section(
				'proxy',
				'Proxy Options',
				array($this, 'printProxySectionInfo'),
				'urlbox-screenshots'
			);

			foreach ($this->fields as $field) {
				$callback = array($this, 'render_field');
				$value  = isset($data[$field['id']]) ? $data[$field['id']] : '';
				$value  = esc_attr($value);
				$field['value'] = $value;
				$section = isset($field['section']) ? $field['section'] : 'default';

				add_settings_field(
					$field['id'], // id
					$field['name'], // title
					$callback, // callback
					'urlbox-screenshots', // page
					$section, // section
					$field // field
				);
			}
		}

		/**
		 * Renders the input field for the settings page based on the field type.
		 *
		 * This method generates the HTML for the different types of fields 
		 * (text, number, checkbox, radio) used in the plugin's settings page.
		 *
		 * @param array $field Associative array containing field details.
		 * @return void
		 */
		public function render_field(array $field)
		{
			$id     = $field['id'];
			$type   = $field['type'];
			$title  = $field['name'];
			$value  = $field['value'];
			$section = isset($field['section']) ? $field['section'] : 'default';;
			$name   = $this->option_name . '[' . $id . ']';
			$desc   = $this->get_shortcode_help($id);
			$class  = 'regular-text';
			switch ($type) {
				case "text":
					$class = $class . $section == 'required_section' ? ' required' : ' ';
					break;
				case "number":
					$class = "only-digit";
					break;
				case "checkbox":
					print "<input type='checkbox' value='1' class='code' name='$name' id='$id'
							" . checked($value, '1', false) . "/>";
					if (!in_array($section, array('required_section', 'proxy'))) {
						print "<div class='description'>$desc</div>";
					}
					return;
				case "radio":
					foreach ($field['options'] as $option_value => $option_text) {
						// $checked = 
						print "<input type='radio' name='$name' value='$option_value' " . checked($value, $option_value, false) . "/>$option_text<span style='margin-left: 15px' />";
					}
					if (!in_array($section, array('required_section', 'proxy'))) {
						print "<div class='description'>$desc</div>";
					}
					return;
			}
			print "<input type='$type' value='$value' name='$name' id='$id'
				class='$class'/>";
			if ($section == 'default') {
				print "<div class='description'>$desc</div>";
			}
		}

		/**
		 * Generates a helpful description to show how to use a given option.
		 *
		 * @param string $id The ID of the field for which to generate the description.
		 * @return string The formatted help description string.
		 */
		protected function get_shortcode_help($id)
		{
			$desc = __(
				'Use %s in the shortcode to override this value.',
				'plugin_pcd'
			);
			return sprintf($desc, "<code>[urlbox $id=yourvalue]</code>");
		}

		/**
		 * Sanitizes each setting field.
		 *
		 * Processes and sanitizes each input value from the settings form based on the 
		 * type of field, ensuring that the data is sanitised before saving it to the database.
		 *
		 * @param array $input Contains all settings fields as array keys.
		 * @return array $new_input Sanitized input fields.
		 */
		public function sanitize($input)
		{
			$new_input = array();
			foreach ($input as $key => $val) {
				if (isset($input[$key])) {
					foreach ($this->fields as $field) {

						if (in_array($key, array('url', 'user_agent'))) {
							$draft = rawurlencode($val);
							$draft = str_replace('%28', '(', $draft);
							$new_input[$key] = str_replace('%29', ')', $draft);
						}
						if ($field['id'] == $key) {
							switch ($field['type']) {
								case 'text':
									$new_input[$key] = sanitize_text_field($val);
									break;
								case 'number':
									$draft = absint($val);
									if (isset($field['min']) and $draft < $field['min']) {
										add_settings_error(
											'urlbox',
											'number-too-low',
											$field['name'] . " must be between " . $field['min'] . " and " . $field['max']
										);
									} elseif (isset($field['max']) and $draft > $field['max']) {
										add_settings_error(
											'urlbox',
											'number-too-high',
											$field['name'] . " must be between " . $field['min'] . " and " . $field['max']
										);
									} else {
										if ($draft == 0) {
											break;
										}
										$new_input[$key] = $draft;
									}
									break;
								case 'checkbox':
									// Convert 1, true, or 'true' to '1'; all else to '0'
									$new_input[$key] = ($val == '1' || $val == 'true' || $val === true) ? '1' : '0';
									break;
								case 'radio':
									if (array_key_exists($val, $field['options'])) {
										$new_input[$key] = $val;
									}
									break;
								default:
									$new_input[$key] = $val;
									break;
							}
						} else {
							$new_input[$key] = $val;
						}
					}
				} else {
					$new_input[$key] = $val;
				}
			}
			return $new_input;
		}

		/** 
		 * Prints the section text underneath the auth settings
		 */
		public function printAuthSectionInfo()
		{
			print 'Enter your API Key and Secret here. You can get these from your <a href="https://urlbox.io/dashboard">Urlbox Dashboard</a>.';
		}

		/** 
		 * Prints the section text underneath the default settings
		 */
		public function printSectionInfo()
		{
			print 'You can edit the default options here. See <a href="https://urlbox.io/docs/options">Urlbox Options Reference</a> for default values.';
		}

		/** 
		 * Prints the section text underneath the html settings
		 */
		public function printHtmlSectionInfo()
		{
			print 'You can add classes to the wrapping ' . htmlentities("<figure>") . ' element and the inside ' . htmlentities("<img>") . ' element here.';
		}

		/**
		 * Prints the text underneath proxy settings
		 */
		public function printProxySectionInfo()
		{
			print 'You can add proxy settings here.';
		}

		/**
		 * PHP 4 Compatible Constructor
		 */
		function Urlbox()
		{
			$this->__construct();
		}

		/**
		 * Generates the output for the Urlbox shortcode as a render link.
		 *
		 * Processes the shortcode options, sets default values,
		 * sanitizes the input, and generates the HTML output which displays the image.
		 *
		 * @param array $atts The options passed by the user.
		 * @return string The HTML output for the shortcode.
		 * 
		 */
		public function urlbox_shortcode($atts)
		{
			$option_values = get_option($this->option_name, array());
			$data = shortcode_atts($this->default_values, $option_values);
			$data = shortcode_atts($data, $atts);

			// echo '<pre>'; print_r($data); echo '</pre>';

			// setting defaults if needed
			$urlboxOptions = $this->sanitize($data);
			$urlboxOptions = array_merge($urlboxOptions, $atts);
			// echo '<pre>'; print_r($urlboxOptions); echo '</pre>';

			$urlboxOptions['url'] = empty($data['url']) ? 'google.com' : $data['url'];
			$output = '';
			if (empty($urlboxOptions['api_key']) or empty($urlboxOptions['api_secret'])) {
				return '<div>You need to set your api key and secret for urlbox plugin to work!</div>';
			}

			if (isset($urlboxOptions['debug']) and $urlboxOptions['debug'] == 'true') {
				$output .= '<div style="background: rgba(64, 66, 93, 0.7);border-radius:2px; padding: 2rem; font-size:10px; overflow-x: scroll; max-width: 500px; ">';
				$output .= '<ul style="list-style:none;margin-left:0;">';
				foreach ($urlboxOptions as $key => $option) {
					$output .= '<li><code>' . esc_html__($key) . '</code><code style="background: rgba(255,255,255,0.5); margin-left: 5px; color: black;">' . esc_html__($option) . '</code></li>';
				}
				$output .= '</ul>';
			}

			if (isset($urlboxOptions['disable_js']) and $urlboxOptions['disable_js'] == 'true' and isset($urlboxOptions['full_page']) and $urlboxOptions['full_page'] == 'true') {
				$output .= '<div style="background: red; color: white; padding: 10px;">Disable JS and Full Page option are not compatible. Please disable at least one of them!</div>';
			}
			// Start output
			$url = $this->generateUrl($urlboxOptions);
			$format = $urlboxOptions['format'];
			$downloadedUrl = $url;
			// $this->download_image($url, $format);
			$output .= "<figure class='wp-block-image";
			if (isset($urlboxOptions['figure_class']))
				$output .= " " . esc_html__($urlboxOptions['figure_class']);
			$output .= "'>";
			$output .= "<img class='" . esc_html__($urlboxOptions['img_class']) . "' src='" . esc_html__($downloadedUrl) . "'";
			if (isset($urlboxOptions['alt']) && !empty($urlboxOptions['alt']))
				$output .= " alt='" . esc_attr($urlboxOptions['alt']) . "'";
			if (!empty($urlboxOptions['use_proxy']) && $urlboxOptions['use_proxy'] && !get_transient($urlboxOptions['url'])) {
				$output .=  " data-render-url='" . esc_attr($urlboxOptions['url']) . "'";
			}
			$output .= "/>";
			$output .= "</figure>";
			if (isset($urlboxOptions['debug']) and $urlboxOptions['debug'] == 'true')
				$output .= "</figure>";
			return $output;
		}

		/**
		 * Generates a render link given options
		 * @param $urlboxOptions
		 * @return string The render link
		 */
		public function generateUrl($urlboxOptions)
		{
			if (array_key_exists('use_proxy', $urlboxOptions) && $urlboxOptions['use_proxy']) {
				if ($render_url = get_transient($urlboxOptions['url'])) {
					return $render_url;
				}
				return plugin_dir_url(__FILE__) . 'images/default.png';
			}

			$APIKEY = $urlboxOptions['api_key'];
			$SECRET = $urlboxOptions['api_secret'];
			$format = $urlboxOptions['format'];
			$_parts = [];
			// If any of the options do not have the following keys, they're safe, add them to the query string.
			foreach ($urlboxOptions as $key => $value) {
				if (!in_array($key, array('api_key', 'api_secret', 'format', 'customcss', 'imagesize', 'figure_class', 'img_class', 'alt', 'use_proxy', 'username', 'password', 'hostname', 'port', 'protocol'))) {
					if (!empty($value)) {
						$_parts[] = "$key=$value";
					}
				}
			}
			$query_string = implode("&", $_parts);
			$TOKEN = hash_hmac("sha1", $query_string, $SECRET);
			return "https://api.urlbox.io/v1/$APIKEY/$TOKEN/$format?$query_string";
		}

		/**
		 * Fetches a render url using the Urlbox /sync API endpoint.
		 *
		 * @param array $urlboxOptions
		 */
		public function fetch_render_sync(array $urlboxOptions)
		{
			// Filter out any sensitive/unwanted data from request
			$body = $this->removeForbiddenAndEmptyKeys($urlboxOptions);

			$secret = $urlboxOptions['api_secret'];
			if (empty($secret)) {
				wp_send_json_error('Error: No API token provided, please set this up in the Urlbox plugin settings.');
				wp_die();
			}

			if (!array_key_exists('url', $body) && !array_key_exists('html', $body)) {
				wp_send_json_error('Error: No HTML or Url provided, please provide one in your request.');
				wp_die();
			}

			// More information on wp_remote_post
			// https://developer.wordpress.org/reference/classes/wp_http/request/
			// https://developer.wordpress.org/reference/functions/wp_remote_post/
			$options = [
				'body'        => wp_json_encode($body),
				'headers'     => [
					'Content-Type' => 'application/json',
					'Authorization' => "Bearer " . $secret,
				],
				'timeout'     => 60,
				'blocking'    => true,
				'data_format' => 'body',
			];

			$response = wp_remote_post(
				self::API_ENDPOINT_SYNC,
				$options
			);

			$response_body = json_decode(wp_remote_retrieve_body($response), true);

			if (is_wp_error($response_body)) {
				error_log($response_body->get_error_message());
				return new WP_Error('urlbox_error', $response_body->get_error_message());
			}

			if (isset($response_body['error'])) {
				return new WP_Error('urlbox_error', $response_body['error']['message']);
			}

			return $response_body['renderUrl'];
		}

		/**
		 * Constructs a proxy URL from provided options.
		 *
		 * Combines protocol, username, password, hostname, and port 
		 * from the $urlboxOptions array to create a proxy URL.
		 *
		 * @param array $urlboxOptions Options used to build the proxy URL.
		 * @return string The constructed proxy URL.
		 */
		private function build_proxy_url($urlboxOptions)
		{
			if (
				!isset($urlboxOptions[self::KEY_PROTOCOL]) |
				!isset($urlboxOptions[self::KEY_USERNAME]) |
				!isset($urlboxOptions[self::KEY_PASSWORD]) |
				!isset($urlboxOptions[self::KEY_HOSTNAME]) |
				!isset($urlboxOptions[self::KEY_PORT])
			) {
				wp_send_json_error("Error: Missing Proxy setting.");
				wp_die();
			}
			return $urlboxOptions['protocol'] . '://' . $urlboxOptions['username'] . ':' .
				$urlboxOptions['password'] . '@' . $urlboxOptions['hostname'] . ':' .
				$urlboxOptions['port'];
		}

		/**
		 * Tests that the proxy settings a user has entered in the settings work with the API.
		 *
		 * This method checks the user's proxy settings by attempting to connect to a
		 * known URL using the provided proxy. 	
		 */
		public function ajax_test_proxy_connection()
		{
			// Verify nonce
			if (!check_ajax_referer('urlbox_admin_nonce', 'nonce', false)) {
				wp_send_json_error('Invalid nonce. Please refresh the page and try again.');
				wp_die();
			}

			// Gets all data from the post request
			$urlbox_data = $_POST['urlbox_data'];

			$proxyKeys = [];

			// Get proxy keys from main request options
			foreach ($urlbox_data as $key => $value) {
				if (in_array($key, self::PROXY_KEYS)) {
					if (empty($value)) {
						wp_send_json_error("Error: The field '$key' is empty.");
						wp_die();
					}
					$proxyKeys[$key] = sanitize_text_field($value);
				}
			}

			// Set test options
			$urlbox_data['url'] = 'google.com';
			$urlbox_data['proxy'] = $this->build_proxy_url($proxyKeys);

			$response_body = $this->fetch_render_sync($urlbox_data);

			// Check if the response contains an error
			if (is_wp_error($response_body)) {
				wp_send_json_error("Proxy test failed: " . $response_body->get_error_message());
			} else {
				wp_send_json_success('Proxy connection successful.');
			}
		}

		/**
		 * Removes the forbidden keys from an array of options
		 * @param array $options
		 * @return array
		 */
		private function removeForbiddenAndEmptyKeys(array $urlboxOptions): array
		{
			foreach ($urlboxOptions as $key => $option) {
				// If it has a value
				if (!empty($option)) {
					// If it's a forbidden key
					if (in_array($key, self::FORBIDDEN_KEYS)) {
						unset($urlboxOptions[$key]);
					}
				}
			}
			return $urlboxOptions;
		}

		/**
		 * Ajax call to fetch the render URL using a proxy
		 */
		public function ajax_proxy_fetch_render_url()
		{
			check_ajax_referer('urlbox_proxy_nonce', 'nonce');

			$urlboxOptions = get_option($this->option_name, array());
			$urlboxOptions['url'] = sanitize_text_field($_POST['url']);

			$default = [
				'rendered_url' => '',
				'url' => $urlboxOptions['url']
			];

			$rendered_url = $this->fetch_render_sync($urlboxOptions);

			if (!$rendered_url) {
				wp_send_json_success($default);
				return;
			}

			if (is_wp_error($rendered_url)) {
				error_log('Error: ' . $rendered_url->get_error_message());
				wp_send_json_error('Error: ' . $rendered_url->get_error_message());
				return;
			}

			// Set transient for 30 days
			set_transient($urlboxOptions['url'], $rendered_url, 60 * 60 * 24 * 30);

			wp_send_json_success([
				'rendered_url' => $rendered_url,
				'url' => $urlboxOptions['url']
			]);
		}

		// read admin options
		public function getAdminOptions()
		{
			$values = $this->default_values;
			$saved_values = get_option($this->option_name, array());
			if (!empty($saved_values)) {
				foreach ($saved_values as $key => $option) {
					$values[$key] = $option;
				}
			}

			return $values;
		}

		// public function download_image($url, $format) {
		// 	require_once(ABSPATH . 'wp-admin/includes/file.php');

		// 	$timeout_seconds = 60;
		// 	// download file to temp dir
		// 	$temp_file = download_url( $url, $timeout_seconds );

		// 	if (!is_wp_error( $temp_file )) {
		// 		print($temp_file . '</br>');
		// 		// array based on $_FILE as seen in PHP file uploads
		// 		$file = array(
		// 			'name' => basename($url) . '.' . $format,
		// 			'type' => $format == 'png' ? 'image/png' : 'image/jpeg',
		// 			'tmp_name' => $temp_file,
		// 			'error' => 0,
		// 			'size' => filesize($temp_file),
		// 		);

		// 		$overrides = array(
		// 			// tells WordPress to not look for the POST form
		// 			// fields that would normally be present, default is true,
		// 			// we downloaded the file from a remote server, so there
		// 			// will be no form fields
		// 			'test_form' => false,

		// 			// setting this to false lets WordPress allow empty files, not recommended
		// 			'test_size' => true,

		// 			// A properly uploaded file will pass this test. 
		// 			// There should be no reason to override this one.
		// 			'test_upload' => true, 
		// 		);

		// 		// move the temporary file into the uploads directory
		// 		$results = wp_handle_sideload( $file, $overrides );

		// 		if (!empty($results['error'])) {
		// 			// insert any error handling here
		// 			print($results['error']);
		// 		} else {
		// 			print($results['url']);
		// 			$filename = $results['file']; // full path to the file
		// 			$local_url = $results['url']; // URL to the file in the uploads dir
		// 			$type = $results['type']; // MIME type of the file
		// 			return $local_url;
		// 			// perform any actions here based in the above results
		// 		}

		// 	}
		// }			
	} // END class Urlbox
	new Urlbox();
}

?>