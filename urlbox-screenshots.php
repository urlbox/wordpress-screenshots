<?php

/**
 * The Urlbox Screenshots Plugin
 *
 * @package     Urlbox
 * @author      Urlbox
 * @copyright   2021 Urlbox Ltd
 * @license     GPL-2.0+
 * @since       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Urlbox Screenshots
 * Plugin URI:  https://urlbox.io
 * Description: Take screenshots of websites and display them on your wordpress site.
 * Version:     1.5.1
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
		public static $urlboxOptions;
		protected $option_name = 'urlbox_data';
		protected $fields = array();
		public $default_values = array(
			'api_key' => '',
			'api_secret' => '',
			'format' => 'png',
			'url' => 'google.com',
			'thumb_width' => '',
			'width' => '',
			'height' => '',
			'delay' => '',
			'user_agent' => '',
			'quality' => '',
			'disable_js' => '',
			'full_page' => '',
			'retina' => '',
			'force' => '',
			'ttl' => '',
			'customcss' => '',
			'imagesize' => '',
			'debug' => '',
			'figure_class' => '',
			'img_class' => ''
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
					"options" => array('png' => "PNG", 'jpeg' => "JPEG")
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
					"name" => "Wrapping element CSS class",
					"type" => "text",
					"section" => 'html'
				),
				array(
					"id" => "img_class",
					"name" => "Image element CSS class",
					"type" => "text",
					"section" => 'html'
				)
			);
		}

		public function set_hooks()
		{
			add_filter('plugin_action_links', array($this, 'add_plugin_settings_link'), 10, 2);
			if (is_admin()) {
				add_action('admin_menu', array($this, 'add_urlbox_options_page'));
				add_action('admin_init', array($this, 'add_fields'));
			}
			add_shortcode('urlbox', array($this, 'urlbox_shortcode'));
		}

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
		 * Add Settings link to plugin
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
					do_settings_sections('urlbox-screenshots');
					submit_button('Save Settings');
					?>
				</form>
			</div>
<?php
		}

		public function add_fields()
		{

			$option_values = get_option($this->option_name, array());
			$data = shortcode_atts($this->default_values, $option_values);

			register_setting(
				$this->option_name, // group, used for settings_fields()
				$this->option_name, // option name, used as key in db
				array($this, 'sanitize') // validation cb
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
				'Html Options',
				array($this, 'printHtmlSectionInfo'),
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
						 " . checked($value, 'true', false) . "/>";
					if ($section !== 'required_section') {
						print "<div class='description'>$desc</div>";
					}
					return;
				case "radio":
					foreach ($field['options'] as $option_value => $option_text) {
						// $checked = 
						print "<input type='radio' name='$name' value='$option_value' " . checked($value, $option_value, false) . "/>$option_text<span style='margin-left: 15px' />";
					}
					if ($section !== 'required_section') {
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

		protected function get_shortcode_help($id)
		{
			$desc = __(
				'Use %s in the shortcode to override this value.',
				'plugin_pcd'
			);
			return sprintf($desc, "<code>[urlbox $id=yourvalue]</code>");
		}

		/**
		 * Sanitize each setting field as needed
		 *
		 * @param array $input Contains all settings fields as array keys
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
									// if(array_key_exists($val, array('true','false'))) {
									// convert 0,1 to false,true for boolean keys
									if (in_array($key, array('retina', 'disable_js', 'full_page', 'force', 'debug'))) {
										if ($val == 1 or $val == 'true') {
											$new_input[$key] = 'true';
										}
									}
									// if($new_input['disable_js'] == 'true' and $new_input['full_page'] == 'true'){

									// }
									break;
								case 'radio':
									if (array_key_exists($val, $field['options'])) {
										$new_input[$key] = $val;
									}
									break;
							}
						}
					}
				}
			}
			return $new_input;
		}

		/** 
		 * Print the Section text
		 */
		public function printAuthSectionInfo()
		{
			print 'Enter your API Key and Secret below:</br></br>';
			print 'You can retrieve them by logging in at <a href="https://urlbox.io">Urlbox</a>';
		}

		public function printSectionInfo()
		{
			print 'Enter your default options below';
		}
		public function printHtmlSectionInfo()
		{
			print 'Enter HTML options below';
		}

		/**
		 * PHP 4 Compatible Constructor
		 */
		function Urlbox()
		{
			$this->__construct();
		}

		/**
		 * Function Urlboxplugin
		 *
		 * @return string article display
		 *        
		 */
		public function urlbox_shortcode($atts)
		{

			$option_values = get_option($this->option_name, array());
			$data = shortcode_atts($this->default_values, $option_values);
			$data = shortcode_atts($data, $atts);

			// setting defaults if needed
			$urlboxOptions = $this->sanitize($data);
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
			$output .= "<img class='" . esc_html__($urlboxOptions['img_class']) . "' src='" . esc_html__($downloadedUrl) . "'/>";
			$output .= "</figure>";
			if (isset($urlboxOptions['debug']) and $urlboxOptions['debug'] == 'true')
				$output .= "</figure>";
			return $output;
		}

		public function generateUrl($urlboxOptions)
		{
			$APIKEY = $urlboxOptions['api_key'];
			$SECRET = $urlboxOptions['api_secret'];
			$format = $urlboxOptions['format'];
			$_parts = [];
			foreach ($urlboxOptions as $key => $value) {
				if (!in_array($key, array('api_key', 'api_secret', 'format', 'customcss', 'imagesize', 'figure_class', 'img_class'))) {
					if (!empty($value)) {
						$_parts[] = "$key=$value";
					}
				}
			}
			$query_string = implode("&", $_parts);
			$TOKEN = hash_hmac("sha1", $query_string, $SECRET);
			return "https://api.urlbox.io/v1/$APIKEY/$TOKEN/$format?$query_string";
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