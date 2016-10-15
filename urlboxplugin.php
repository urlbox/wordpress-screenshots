<?php
/**
 * Plugin Name: WP-Urlboxplugin
 * Plugin URI: http://wordpress.org/extend/plugins/wp-urlboxplugin/
 * Description: This plugin uses the Urlbox API to generate website screenshots and display them on your site
 * Version: 1.0
 * Author: Chris Roebuck
 */
@set_time_limit(0);


// disabled w3tc
// define('DONOTCACHEPAGE', true);
// define('DONOTCACHEDB', true);
// define('DONOTMINIFY', true);
// define('DONOTCDN', true);
// define('DONOTCACHEOBJECT', true);

/**
 * WP_Urlboxplugin class
 */
if (!class_exists('WP_Urlboxplugin')) {
	class WP_Urlboxplugin {
		private $stringTextdomain = 'urlboxplugin';
		public static $urlboxOptions;
		private static $worksWithLocale = true;
		public $defaultOptions = array (
				'api' => '',
				'secret' => '',
				'url' => '',
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
				'format' => '',
				'customcss' => '',
				'imagesize' => '',
				'debug' => ''
		);
		
		/**
		 * Returns an instance of this class.
		 */
		public static function get_instance() {
			if (null == self::$instance) {
				self::$instance = new WP_Urlboxplugin();
			}
	
			return self::$instance;
		}

		public function __construct(){
			add_shortcode('urlbox', array (
					$this,
					'Urlboxplugin' 
			));
			
			// admin check
			if (is_admin()) {
				// Regenerate cache after activation of the plugin
				// register_activation_hook(__FILE__, array(&$this,'helperClearCacheQuery'));
				// register_activation_hook( __FILE__, array(&$this,'registerRewriteRules'));
				// register_deactivation_hook( __FILE__, array(&$this,'flushRewriteRules'));
				
				// add Admin menu
				add_action('admin_menu', array (
						&$this,
						'addPluginPage' 
				));
				// add Plugin settings link
				add_filter('plugin_action_links', array (
						&$this,
						'addPluginSettingsLink' 
				), 10, 2);
			}
		}
		
		/**
		 * PHP 4 Compatible Constructor
		 */
		function WP_Urlboxplugin(){
			$this->__construct();
		}
		
		/**
		 * Function Urlboxplugin
		 *
		 * @return string article display
		 *        
		 */
		public function Urlboxplugin($atts){

			$articleCleanData = array (); // Array with article informations for sorting and filtering
			$articleCleanDataComplete = array (); // Array with article informations for sorting and filtering
			$articleData = array ();
			$designsData = array ();

			// get admin options (default option set on admin page)
			$conOp = $this->getAdminOptions();

			// shortcode overwrites admin options (default option set on admin page) if available
			$arrSc = shortcode_atts($this->defaultOptions, $atts);
			
			// replace options by shortcode if set
			if (!empty($arrSc)) {
				foreach ($arrSc as $key => $option) {
					if ($option != '') {
						$conOp[$key] = $option;
					}
				}
			}
			
			// setting defaults if needed
			self::$urlboxOptions = $conOp;
			self::$urlboxOptions['url'] = (empty($conOp['url']) ? 'google.com' : $conOp['url']);
			
			if (!empty(self::$urlboxOptions['api']) && !empty(self::$urlboxOptions['secret'])) {
				// Start output
				$output = (!empty($conOp['url_anchor'])?'<a name="' . $conOp['url_anchor'] . '"></a>':"");
				$url = $this->generateUrl();
				$output .= "<img src='$url'/>";
				if(self::$urlboxOptions['debug'] == 1){
					$output .= '<ul>';
					foreach (self::$urlboxOptions as $key => $option) {
						$output .= '<li>'.$key.$option.'</li>';
					}
					$output .= '</ul>';
				}
			} else {
				$output = '<div>Hey you need to set your api key and secret for urlbox to work!</div>';
			}
			
			return $output;
		}

		public function generateUrl() {
			$APIKEY = self::$urlboxOptions['api'];
			$SECRET = self::$urlboxOptions['secret'];
			$format = self::$urlboxOptions['format'] == 1 ? 'png' : 'jpg';
			$_parts = [];
			foreach (self::$urlboxOptions as $key => $value) {
				if (!in_array($key,array('api','secret','format', 'customcss', 'imagesize'))) {
					if(!empty($value)){
						if(in_array($key, array('url', 'user_agent'))){
							$value = rawurlencode($value);
							$value = str_replace('%28', '(', $value);
							$value = str_replace('%29', ')', $value);
						}
						// convert 0,1 to false,true for boolean keys
						if(in_array($key, array('retina', 'disable_js', 'full_page', 'force'))){
							if($value == 1){
								$value = 'true';
							} else {
								$value = 'false';
							}
						}
        		$_parts[] = "$key=$value";
					}
				}
    	}
			$query_string = implode("&", $_parts);
    	$TOKEN = hash_hmac("sha1", $query_string, $SECRET);
			return "https://api.urlbox.io/v1/$APIKEY/$TOKEN/$format/?$query_string";
		}

		// read admin options
		public function getAdminOptions(){
			$scOptions = $this->defaultOptions;
			$splgOptions = get_option('urlbox_plugin_options');
			if (!empty($splgOptions)) {
				foreach ($splgOptions as $key => $option) {
					$scOptions[$key] = $option;
				}
			}

			return $scOptions;
		}

		/**
		 * Admin
		 */
		public function addPluginPage(){
			// Create menu tab
			add_options_page('Set Urlboxplugin options', 'Urlboxplugin', 'manage_options', 'urlbox_plugin_options', array (
					$this,
					'pageOptions' 
			));
		}

			// call page options
		public function pageOptions(){
			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			
			// display options page
			include (plugin_dir_path(__FILE__) . '/options.php');
		}

			/**
		 * Add Settings link to plugin
		 */
		public function addPluginSettingsLink($links, $file){
			static $this_plugin;
			if (!$this_plugin)
				$this_plugin = plugin_basename(__FILE__);
			
			if ($file == $this_plugin) {
				$settings_link = '<a href="options-general.php?page=urlbox_plugin_options">' . __("Settings", $this->stringTextdomain) . '</a>';
				array_unshift($links, $settings_link);
			}
			
			return $links;
		}
		
				
	} // END class WP_Urlboxplugin
	
	new WP_Urlboxplugin();
}

?>