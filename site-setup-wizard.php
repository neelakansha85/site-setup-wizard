<?php
/**
 * Plugin Name: Site Setup Wizard
 * Description: Allows users to create new sites using a wizard of multiple steps and pre-selecting site settings such as theme, plugins, privacy, etc. You can use the wizard by adding shortcode [site_setup_wizard] at any place on the site. The plugin is completely customizable.
 * Plugin URI: https://github.com/neelakansha85/site-setup-wizard
 * Author: Neel Shah <neel@nsdesigners.com>
 * Author URI: http://neelshah.info
 * License: GPL2
 * Version: 1.5.8
 */

define('SSW_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('SSW_PLUGIN_DIR', dirname( __FILE__ ).'/');
// SSW Plugin Main table name
define('SSW_MAIN_TABLE', 'nsd_site_setup_wizard');
// SSW Plugin Root Dir name
define('SSW_PLUGIN_FIXED_DIR', 'site-setup-wizard');
// This is the slug used for the plugin's create site wizard page 
define('SSW_CREATE_SITE_SLUG', 'Site_Setup_Wizard');
define('SSW_OPTIONS_PAGE_SLUG', 'Site_Setup_Wizard_Options');
define('SSW_ANALYTICS_PAGE_SLUG', 'Site_Setup_Wizard_Analytics');
define('SSW_CONFIG_OPTIONS_FOR_DATABASE', 'nsd_ssw_config_options');
define('SSW_PLUGINS_CATEGORIES_FOR_DATABASE', 'nsd_ssw_plugins_categories');
define('SSW_PLUGINS_LIST_FOR_DATABASE', 'nsd_ssw_plugins_list');
define('SSW_THEMES_CATEGORIES_FOR_DATABASE', 'nsd_ssw_themes_categories');
define('SSW_THEMES_LIST_FOR_DATABASE', 'nsd_ssw_themes_list');
define('SSW_SITE_TYPE_KEY', 'nsd_ssw_site_type');
define('SSW_USER_ROLE_KEY', 'nsd_ssw_user_role');
define('SSW_VERSION_KEY', 'nsd_ssw_version');
define('SSW_VERSION_NUM', '1.5.8');


if(!class_exists('Site_Setup_Wizard')) {
	class Site_Setup_Wizard {

		// All public variables that will be used for dynamic programming 
		public $multisite;		
		public $path;

		// Site Meta options for WPMU Pretty Plugins in which it stores Plugins categories and other information
		public $wpmu_pretty_plugins_categories_site_option = 'wmd_prettyplugins_plugins_categories';
		public $wpmu_pretty_plugins_plugins_list_site_option = 'wmd_prettyplugins_plugins_custom_data';
		public $wpmu_multisite_theme_manager_categories_site_option = 'wmd_prettythemes_themes_categories';
		public $wpmu_multisite_theme_manager_themes_list_site_option = 'wmd_prettythemes_themes_custom_data';
		
		// Construct the plugin object
		public function __construct() {

			// Installation and Deactivation hooks
			register_activation_hook(__FILE__, array( $this, 'ssw_activate' ) );
			// Plugin Deactivation Hook
			register_deactivation_hook(__FILE__, array( $this, 'ssw_deactivate' ) );
			
			// Add action to display Create Site menu item in Site's Dashboard
			// add_action( 'admin_menu', array($this, 'ssw_menu'));
			
			// Add action to display Create Site menu item in Network Admin's Dashboard
			add_action( 'network_admin_menu', array( $this, 'ssw_network_menu' ) );
			
			// Check and filter out all Network Activated plugin whenever 
			// any plugin is activated in the complete system
			add_action( 'activated_plugin', array( $this, 'ssw_find_plugins' ) );
			
			// Check and filter out all Network Activated plugin whenever any plugin is deactivated in the complete system */
			add_action( 'deactivated_plugin', array( $this, 'ssw_find_plugins' ) );
			
			// Display all errors as admin message if occured
			add_action( 'admin_notices', array( $this, 'ssw_admin_errors' ) );
			
			add_action( 'plugins_loaded', array( $this, 'ssw_check_version' ) );
			add_action( 'plugins_loaded', array( $this, 'ssw_find_plugins' ) );
			
			add_action( 'admin_init', array($this, 'ssw_export_options') );
			add_action( 'admin_init', array($this, 'ssw_import_options') );
			
			// Include Javascripts and CSS for SSW Plugin on the backend
			add_action( 'admin_enqueue_scripts', array( $this, 'ssw_admin_scripts' ) );
			
			// Include Javascripts and CSS for SSW Plugin on the frontend
			add_action( 'wp_enqueue_scripts', array( $this, 'ssw_frontend_scripts' ) );

			// Add ajax request handlers for all buttons of wizard for admin section
			add_action( 'wp_ajax_ssw_submit_form_cancel', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_previous', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_next', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_skip', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_check_domain_exists', array( $this, 'ssw_check_domain_exists'));
			add_action( 'wp_ajax_ssw_check_admin_email_exists', array( $this, 'ssw_check_admin_email_exists'));
			add_action( 'wp_ajax_ssw_set_default_options', array( $this, 'ssw_set_default_options' ) );
			add_action( 'wp_ajax_ssw_save_options', array( $this, 'ssw_save_options' ) );

			// Add ajax request handlers for all buttons of wizard for frontend section
			add_action( 'wp_ajax_nopriv_ssw_submit_form_cancel', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_previous', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_next', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_skip', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_check_domain_exists', array( $this, 'ssw_check_domain_exists'));
			add_action( 'wp_ajax_nopriv_ssw_check_admin_email_exists', array( $this, 'ssw_check_admin_email_exists'));
			
			// Add shortcode [site_setup_wizard] to any page to display Site Setup Wizard over it
			add_shortcode('site_setup_wizard', array( $this, 'ssw_shortcode' ) );
			
			// Add action to handle when a site is deleted
			add_action( 'delete_blog', array( &$this, 'ssw_handle_site_deleted' ), 10, 1);
			
			// Check and store is the wordpress installation is multisite or not
			$this->multisite = is_multisite();

		}

		/**
		 * Find Site Setup Wizard Plugin's main table name with wp prefixes
		 *
		 * @since  1.0
		 * @return string            value of the main table with proper wordpress prefixes
		 */
		public function ssw_main_table() {
			global $wpdb;
			$ssw_main_table = $wpdb->base_prefix.SSW_MAIN_TABLE;
			return $ssw_main_table;
		}

		/**
		 * Checks for the current version of plugin and performs updates if any
		 *
		 * @since 1.4.1
		 * @return void
		 */
		public function ssw_check_version() {
			if(SSW_VERSION_NUM !== get_site_option(SSW_VERSION_KEY)) {
				$this->ssw_activate();
			}
		}

		/**
		 * Fetch configuration options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.0
		 * @return associative_array gives an array of all options for SSW
		 */
		public function ssw_fetch_config_options() {
			$options = get_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			return $options;
		}

		/**
		 * Update configuration options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.3.1
		 * @param  array $new_ssw_config_options provide updated config options to be saved
		 * @return array                         get new config options from db
		 */
		public function ssw_update_config_options($new_ssw_config_options) {
			update_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE, $new_ssw_config_options );
		}

		/**
		 * Set Default Config options for SSW_CONFIG_OPTIONS_FOR_DATABASE
		 *
		 * @since  1.4
		 * @return string JSON object with new default options set
		 */
		public function ssw_set_default_options() {
			if (isset($_POST['ssw_ajax_nonce']) && wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				
				include(SSW_PLUGIN_DIR.'admin/ssw_default_options.php');
				$this->ssw_update_config_options($ssw_default_options);
				$options = $this->ssw_fetch_config_options();
				
				// Return new config options to reload Options Page
				header('Content-Type: application/json');
				echo json_encode($options);

	      // Extra wp_die is to stop ajax call from appending extra 0 to the resposne
				wp_die();
			}
		}

		/**
		 * Export current config options to download as JSON file
		 *
		 * @since  1.4
		 * @return string JSON object as attachment if function is called from Options Page
		 */
		public function ssw_export_options() {
			if(!empty($_POST['ssw_action']) && $_POST['ssw_action'] == 'export_options') {
				
				if(!wp_verify_nonce($_POST['ssw_export_nonce'], 'ssw_export_nonce'))
					return;
				
				if(!current_user_can('manage_network'))
					return;
				
				$options = get_site_option(SSW_CONFIG_OPTIONS_FOR_DATABASE);
				ignore_user_abort(true);

				nocache_headers();
				header('Content-Type: application/json; charset=utf-8');
				header('Content-Disposition: attachment; filename=ssw-settings-export-'.date('m-d-Y').'.json');
				header("Expires: 0");
				echo json_encode($options);
				
				exit;
			}
		}

		/**
		 * Import config options from previous JSON backup file
		 *
		 * @since  1.4
		 * @return void redirects to Options page after updating new imported options
		 */
		public function ssw_import_options() {
			if(!empty($_POST['ssw_action']) && $_POST['ssw_action'] == 'import_options') {
				if(!wp_verify_nonce($_POST['ssw_import_nonce'], 'ssw_import_nonce'))
					return;
				if(!current_user_can('manage_network'))
					return;
				$extension = end(explode('.', $_FILES['import_file']['name']));
				if($extension != 'json') {
					wp_die(__('Please upload a valid .json file'));
				}
				$import_file = $_FILES['import_file']['tmp_name'];
				if(empty($import_file)) {
					wp_die(__('Please upload a file to import settings'));
				}
				$new_options = json_decode(file_get_contents($import_file), true);
				$this->ssw_update_config_options($new_options);

				wp_safe_redirect(network_admin_url('admin.php?page='.SSW_OPTIONS_PAGE_SLUG));
				exit;
			}
		}

		/**
		 * Save options for SSW Plugin for wp_sitemeta table
		 *
		 * @since  1.3
		 * @return string if request came through ajax, reloads options page otherwise
		 */
		public function ssw_save_options() {
			if (isset($_POST['ssw_ajax_nonce']) && wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				$options = $this->ssw_fetch_config_options();
				$site_user_category = $options['site_user_category'];
				$site_type = $options['site_type'];

				if(isset($_POST['new_user_role'])) {
					$new_user_role = $this->ssw_sanitize_option('sanitize_field', $_POST['new_user_role']);
					if($new_user_role != '' && $new_user_role != 'add_new') {
						if(!isset($site_user_category[$new_user_role])) {
							$site_user_category[$new_user_role] = array();
						}
						if(!isset($site_type[$new_user_role])) {
							$site_type[$new_user_role] = array();
						}
					}
				}
				
				else if(isset($_POST['remove_user_role'])) {
					$remove_user_role = $this->ssw_sanitize_option('sanitize_field', $_POST['remove_user_role']);
					if($remove_user_role != '') {
						if(isset($site_user_category[$remove_user_role])) {
							unset($site_user_category[$remove_user_role]);
						}
						if(isset($site_type[$remove_user_role])) {
							unset($site_type[$remove_user_role]);
						}
					}
				}
				
				else if(isset($_POST['update_user_role'])) {
					$update_user_role = $this->ssw_sanitize_option('sanitize_field', $_POST['update_user_role']);
					if($update_user_role != '') {
						
						if(isset($site_user_category[$update_user_role])) {
							$ssw_site_category_array = $this->ssw_sanitize_option('to_array_on_eol', $_POST['site_category']);
							$site_user_category[$update_user_role] = $ssw_site_category_array;
						}
						
						if(isset($site_type[$update_user_role])) {
							$ssw_site_type_array = $this->ssw_sanitize_option('to_array_on_eol', $_POST['site_type']);
							$site_type[$update_user_role] = $ssw_site_type_array;
						}
					}
				}
				// Updating new values for configuration options
				$options['site_user_category'] = $site_user_category;
				$options['site_type'] = $site_type;
				$this->ssw_update_config_options($options);

				// Return new config options to reload Options Page
				header('Content-Type: application/json');
				echo json_encode($options);

				// Extra wp_die is to stop ajax call from appending extra 0 to the resposne
				wp_die();
			}
			
			// This is to save remaining options which do not come via ajax request 
			else {
				include(SSW_PLUGIN_DIR.'admin/ssw_save_options.php');
				$this->ssw_update_config_options($new_ssw_config_options);
			}

		}
		
		/**
		 * Fetch Plugin options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.0
		 * @return array gets current list of all plugins and their categories from db
		 */
		public function ssw_fetch_plugin_options() {
			$plugin_options['plugins_categories'] = get_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE );
			$plugin_options['plugins_list'] = get_site_option( SSW_PLUGINS_LIST_FOR_DATABASE );
			return $plugin_options;
		}

		/**
		 * Update Plugin options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.0
		 * @param  array $new_plugin_options takes array of new list of plugins and their categories to save in db
		 * @return array                     with new list of plugins and their categories from db
		 */
		public function ssw_update_plugin_options( $new_plugin_options ) {
			$plugin_options['plugins_categories'] = update_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE, $new_plugin_options['plugins_categories'] );
			$plugin_options['plugins_list'] = update_site_option( SSW_PLUGINS_LIST_FOR_DATABASE, $new_plugin_options['plugins_list'] );
			return $plugin_options;
		}

		/**
		 * Fetch Theme options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.0
		 * @return array get's current list of themes and their categories from db
		 */
		public function ssw_fetch_theme_options() {
			$theme_options['themes_categories'] = get_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE );
			$theme_options['themes_list'] = get_site_option( SSW_THEMES_LIST_FOR_DATABASE );
			return $theme_options;
		}

		/**
		 * Update Theme options for SSW Plugin from wp_sitemeta table
		 *
		 * @since  1.0
		 * @param  array $new_theme_options takes array of new list of themes and their categories to save in db
		 * @return array                    with new list of themes and their categories from db
		 */
		public function ssw_update_theme_options( $new_theme_options ) {
			$theme_options['themes_categories'] = update_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE, $new_theme_options['themes_categories'] );
			$theme_options['themes_list'] = update_site_option( SSW_THEMES_LIST_FOR_DATABASE, $new_theme_options['themes_list'] );
			return $theme_options;
		}

		/**
		 * All actions performed while activating Site Setup Wizard plugin
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_activate() {
			include(SSW_PLUGIN_DIR.'admin/ssw_activate.php');
			include(SSW_PLUGIN_DIR.'admin/ssw_default_options.php');
			// Add SSW plugin options to the wp_sitemeta table for network wide settings
			$current_options = get_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			if ($current_options === false)
				$current_options = array();

			update_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE, array_merge($ssw_default_options, $current_options) );

			if (get_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE ) === false)
				update_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE, '' );

			if (get_site_option( SSW_PLUGINS_LIST_FOR_DATABASE ) === false)
				update_site_option( SSW_PLUGINS_LIST_FOR_DATABASE, '' );

			if (get_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE ) === false)
				update_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE, '' );

			if (get_site_option( SSW_THEMES_LIST_FOR_DATABASE ) === false)
				update_site_option( SSW_THEMES_LIST_FOR_DATABASE, '' );

			update_site_option( SSW_VERSION_KEY, SSW_VERSION_NUM );

			// Find list of all plugins available in network when this plugin is activated 
			$this->ssw_find_plugins();
		} 

		/**
		 * All actions performed while deactivating this plugin
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_deactivate() {
			// Simply deactivate the plugin for now
			
		} 
		
		/**
		 * Menu function to display Site Setup Wizard -> Create Site in Site's Dashboard
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_menu() {
			// Adding Menu item "Create Site" in Dashboard, allowing it to be displayed for 
			// all users including subscribers with "read" capability and displaying it 
			// above the Dashboard with position "1.38"
			add_menu_page('Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array( $this, 'ssw_create_site' ), 'dashicons-plus', '1.38');
		}

		/**
		 * Menu function to display Site Setup Wizard -> Create Site in the Network Admin's Dashboard
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_network_menu() {

			// Adding Menu item "Create Site" in Dashboard, allowing it to be displayed for 
			// all users including subscribers with "read" capability and displaying it 
			// above the Dashboard with position "1.38"
			add_menu_page('Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array($this, 'ssw_create_site'), 'dashicons-plus', '1.38');

			// Adding First Sub menu item in the SSW Plugin to reflect the Create Site functionality in the sub menu
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array($this, 'ssw_create_site') );

			// Adding SSW Options page in the Network Dashboard below the Create Site menu item 
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard Options', 'Options', 'manage_network', 
				SSW_OPTIONS_PAGE_SLUG, array($this, 'ssw_options_page') );

			// Adding SSW Reports page in the Network Dashboard below the Create Site menu item
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard Analytics', 'Analytics', 'manage_network', 
				SSW_ANALYTICS_PAGE_SLUG, array($this, 'ssw_analytics_page') );
		}

		/**
		 * Log all MySQL errors to nsd_ssw_sql_log.log file in wp-contents/uploads dir
		 *
		 * @since  1.2.0
		 * @param  string $error takes WP_Error class object
		 * @return void
		 */
		public function ssw_log_sql_error( $error ) {
			$options = $this->ssw_fetch_config_options();
			$is_debug_mode = $options['debug_mode'];
			if ($is_debug_mode == true) {
				if($error!=NULL) {
					$uploads = wp_upload_dir();
					$upload_path = $uploads['basedir'];
					$filename = $upload_path.'/nsd_ssw_sql_log.log';
					$open = fopen($filename, "a"); 
					$write = fputs($open,"\n".'error at ( '.date('Y-m-d H:i:s').' '. $error); 
					fclose($open);
				}
			}
		}

		/**
		 * Log all variables for DEBUG to nsd_ssw_debug_log.log file in wp-contents/uploads dir
		 *
		 * @since  1.2.0
		 * @param  string $error takes WP_Error class object
		 * @return void
		 */
		public function ssw_debug_log( $file_name, $var_name, $value ) {
			$options = $this->ssw_fetch_config_options();
			$is_debug_mode = $options['debug_mode'];
			if ($is_debug_mode == true) {
				$uploads = wp_upload_dir();
				$upload_path = $uploads['basedir'];
				$filename = $upload_path.'/nsd_ssw_debug_log.log';
				$open = fopen($filename, "a");
				$write = fputs($open,"\nReferrer: ".$file_name." $".$var_name." = ".print_r($value, true)); 
				fclose($open);
			}
		}   

		/**
		 * Display all admin message errors when occurs
		 *
		 * @since  1.0
		 * @param  int $error takes error code from within ssw functions
		 * @return void
		 */
		public function ssw_admin_errors( $error ) {
			if($error == 1000) {
				echo '
				<div class="error">
					<p>Plugin Activation Error: There exists another plugin which uses the same config options name as Site Setup Wizard Plugin uses.</p>
				</div>
				';
			}
		}

		/**
		 * Register CSS Stylesheet for Admin section pages on the backend
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_admin_scripts() {
			$options = $this->ssw_fetch_config_options();
			$site_category_no_prefix = $options['site_category_no_prefix'];
			for($i=0 ; $i<count($site_category_no_prefix); $i++) {
				$site_category_no_prefix[$i] = $this->ssw_sanitize_option('sanitize_url', $site_category_no_prefix[$i]);
			}

			// Register all required Javascripts for SSW Plugin with it's wp_register_script hook
			wp_register_script( 'ssw-main-js', SSW_PLUGIN_URL.'js/ssw-main.js' );
			
			// For Analytics Page
			wp_register_script( 'd3-min-js', 'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js' );
			wp_register_script( 'nv-d3-min-js', SSW_PLUGIN_URL.'lib/nv.d3/nv.d3.min.js', array('d3-min-js') );
			wp_register_script( 'ssw-analytics-js', SSW_PLUGIN_URL.'js/ssw-analytics.js' );
			
			// Include the Javascripts for the ssw plugin while trying to create a site
			wp_enqueue_script( 'ssw-main-js' );

			wp_localize_script( 'ssw-main-js', 'ssw_main_ajax', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'ssw_ajax_nonce' => wp_create_nonce( 'ssw_ajax_action' ),
				'site_category_no_prefix' => $site_category_no_prefix
				)
			);

			// Register Options Page Javascript for SSW Plugin
			wp_register_script( 'ssw-options-js', SSW_PLUGIN_URL.'js/ssw-options.js');   

			// Link stylesheets for the SSW Plugin when plugin is called for
			wp_register_style( 'ssw-style-css', SSW_PLUGIN_URL.'css/ssw-style.css' );
			wp_register_style( 'ssw-style-admin-css', SSW_PLUGIN_URL.'css/ssw-style-admin.css' );
			wp_register_style( 'ssw-media-css', SSW_PLUGIN_URL.'css/ssw-media.css' );
			
			// For Analytics Page
			wp_register_style( 'bootstrap-min-css', SSW_PLUGIN_URL.'lib/bootstrap/css/bootstrap.min.css');
			wp_register_style( 'nv-d3-min-css', SSW_PLUGIN_URL.'lib/nv.d3/nv.d3.min.css' );
			
			wp_enqueue_style( 'ssw-style-css' );
			wp_enqueue_style( 'ssw-media-css' );
		}

		/**
		 * Register Javascripts for the frontend and backend
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_frontend_scripts() {
			$options = $this->ssw_fetch_config_options();
			$site_category_no_prefix = $options['site_category_no_prefix'];
			for($i=0 ; $i<count($site_category_no_prefix); $i++) {
				$site_category_no_prefix[$i] = $this->ssw_sanitize_option('sanitize_url', $site_category_no_prefix[$i]);
			}

			// Register all required Javascripts for SSW Plugin with it's wp_register_script hook
			wp_register_script( 'ssw-main-js', SSW_PLUGIN_URL.'js/ssw-main.js' );

			// Include the Javascripts for the ssw plugin while trying to create a site
			wp_enqueue_script( 'ssw-main-js' );

			wp_localize_script( 'ssw-main-js', 'ssw_main_ajax', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'ssw_ajax_nonce' => wp_create_nonce( 'ssw_ajax_action' ),
				'site_category_no_prefix' => $site_category_no_prefix
				)
			);

			// Link stylesheets for the SSW Plugin when plugin is called for
			wp_register_style( 'ssw-style-css', SSW_PLUGIN_URL.'css/ssw-style.css' );
			wp_register_style( 'ssw-media-css', SSW_PLUGIN_URL.'css/ssw-media.css' );
			wp_enqueue_style( 'ssw-style-css' );
			wp_enqueue_style( 'ssw-media-css' );
		}

		/**
		 * Find all currently available plugins excluding network deactivated to offer for the Features page
		 *
		 * @since  1.0
		 * @return void updates the list of all plugins in db if available
		 */
		public function ssw_find_plugins() {
			global $wpdb;
			$options = $this->ssw_fetch_config_options();
			$wpmu_pretty_plugins = $options['external_plugins']['wpmu_pretty_plugins'];
			$plugins_list = array('');

			if ($wpmu_pretty_plugins == true) {
				$plugins_categories = get_site_option($this->wpmu_pretty_plugins_categories_site_option);
				$all_plugins = get_site_option($this->wpmu_pretty_plugins_plugins_list_site_option);
				$this->ssw_debug_log('ssw_find_plugins()', 'all_plugins value from Pretty Plugins', $all_plugins);
				$this->ssw_debug_log('ssw_find_plugins()', 'wpmu_pretty_plugins_plugins_list_site_option', $this->wpmu_pretty_plugins_plugins_list_site_option);
				if ( ! $all_plugins ) {
					$all_plugins = array();
				}
				foreach ($all_plugins as $key => $value) {
					if ( !function_exists( 'validate_plugin' ) ) {
						require_once ABSPATH . 'wp-admin/includes/plugin.php';
					}

					// Validate if the plugin still exists in the system though 
					// it is present in Pretty Plugins list
					$validated = validate_plugin( $key );
					if( !is_wp_error( $validated ) ) {
						// Find list of all plugins which are not network activated 
						// and store it in plugins_list variable
						if( !is_plugin_active_for_network( $key ) ) {
							$plugins_list[$key] = $value;
						}
					}
				}
			}

			else {
				if ( !function_exists( 'get_plugins' ) ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				$all_plugins = get_plugins();
				foreach ($all_plugins as $key => $value) {
					// Find list of all plugins which are not network activated 
					// and store it in plugins_list variable
					if( !is_plugin_active_for_network( $key ) ) {
						$plugins_list[$key] = $value;
					}
				}
				$plugins_categories = array('');
			}
			$plugin_options['plugins_categories'] = $plugins_categories;
			$plugin_options['plugins_list'] = $plugins_list;

			$this->ssw_update_plugin_options( $plugin_options );
		}

		/**
		 * Find all currently available themes which are network activated to offer for the Themes page 
		 *
		 * @since  1.0
		 * @return void updates list of all themes in db if available
		 */
		public function ssw_find_themes() {
			global $wpdb;
			$options = $this->ssw_fetch_config_options();

			$wpmu_multisite_theme_manager = $options['external_plugins']['wpmu_multisite_theme_manager'];

			if ($wpmu_multisite_theme_manager == true) {
				$themes_categories = get_site_option($this->wpmu_multisite_theme_manager_categories_site_option);
				$all_themes = get_site_option($this->wpmu_multisite_theme_manager_themes_list_site_option);
				foreach ($all_themes as $key => $value) {
					/* #TODO: Have to find and remove themes which are not network enabled from the list of all themes */
					/* Find list of all plugins which are not network activated and store it in themes_list variable */
					// if( !is_plugin_active_for_network( $key ) ) {
					$themes_list[$key] = $value;
	                // }
				}
			}

			else {
				if ( !function_exists( 'wp_get_themes' ) ) {
					require_once ABSPATH . 'wp-includes/theme.php';
				}
				$all_themes = wp_get_themes();
				foreach ($all_themes as $key => $value) {
					/* #TODO: Have to find and remove themes which are not network enabled from the list of all themes */
					/* Find list of all plugins which are not network activated and store it in themes_list variable */
					// if( !is_plugin_active_for_network( $key ) ) {
					$themes_list[$key] = $value;
	                // }
				}
				$themes_categories = array('');
			}
			$theme_options['themes_categories'] = $themes_categories;
			$theme_options['themes_list'] = $themes_list;

			$this->ssw_update_theme_options( $theme_options );
		}

		/**
		 * Sanitize user inputted options before saving them
		 *
		 * @since  1.3
		 * @param  string $sanitize_type takes type of sanitization to be performed over plain_text
		 * @param  string $plain_text    takes the plain_text inputted by user using some form in SSW
		 * @return string                which is sanitized and clean for saving in db
		 */
		public function ssw_sanitize_option( $sanitize_type, $plain_text ) {
			if ($sanitize_type == 'to_array_on_eol') {
				$sanitized_text = stripslashes(wp_kses_post($plain_text));
				$sanitized_text = array_map('trim', explode("\n", $sanitized_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'to_array_on_comma') {
				$sanitized_text = stripslashes(wp_kses_post($plain_text));
				$sanitized_text = array_map('trim', explode(",", $sanitized_text));
				return $sanitized_text;
			}
			else if ($sanitize_type == 'allow_html') {
				$sanitized_text = stripslashes(wp_kses_post($plain_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_field') {
				$sanitized_text = stripslashes(sanitize_text_field($plain_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_url') {
				$sanitized_text = str_replace( '-', '', stripslashes(sanitize_key($plain_text)));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_email') {
				$sanitized_text = stripslashes(sanitize_email($plain_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_key') {
				$sanitized_text = stripslashes(sanitize_key($plain_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_text_field') {
				$sanitized_text = stripslashes(sanitize_text_field($plain_text));
				return $sanitized_text;
			}
			else if($sanitize_type == 'sanitize_title_for_query') {
				$sanitized_text = stripslashes(sanitize_title_for_query($plain_text));
				return $sanitized_text;
			}
			else {
				$sanitized_text = stripslashes(sanitize_key($plain_text));
				return $sanitized_text;
			}	

		}

		/**
		 * SSW Shortcode function
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_shortcode() {
			if( !is_user_logged_in()) {
				$login_url = wp_login_url( get_permalink() );
				echo sprintf( __( 'You must first <a href="%s">log in</a> to create a new site.' ), $login_url );
			}
			else {
				$this->ssw_create_site();
			}
		}

		/**
		 * SSW Options Page which is displayed under the Network Dashboard -> Create Site -> Options Page
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_options_page() {
			include(SSW_PLUGIN_DIR.'admin/ssw_options_page.php');
		}

		/**
		 * SSW Reports Page which is displayed under the Network Dashboard -> Create Site -> Reports Page
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_analytics_page() {
			include(SSW_PLUGIN_DIR.'admin/ssw_analytics_page.php');
		}

		/**
		 * Check if given path is already taken by another site or not
		 *
		 * @since  1.0
		 * @return int 2 if it is banned_site, 1 if site already exits and 0 if doesn't exist.
		 */
		public function ssw_check_domain_exists() {
			if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				global $current_blog;
				global $current_site;
				global $wpdb;
				$options = $this->ssw_fetch_config_options();
				$site_category = $options['site_user_category'];
				$site_category_no_prefix = $options['site_category_no_prefix'];
				$banned_site_address = $options['banned_site_address'];
				$is_debug_mode = $options['debug_mode'];

				$site_category_selected = sanitize_key( $_POST['site_category']);

				// Replace '-' from site address since it is being used to separate a 
				// site name from site category/bucket 
				$site_address = str_replace( '-', '', sanitize_key( $_POST['site_address'] ));
				$is_banned_site = 0;
				for($i=0 ; $i<count($site_category_no_prefix); $i++) {
					$site_category_no_prefix[$i] = $this->ssw_sanitize_option('sanitize_url', $site_category_no_prefix[$i]);
				}
				if( in_array($site_category_selected, $site_category_no_prefix) != true && $site_category_selected != '' ) {
					$path = $site_category_selected.'-'.$site_address;
				}
				else {
					$path = $site_address;
				}

				$this->ssw_debug_log('ssw_check_domain_exists()', 'site path', $path);
				
				// Validate if user's given path is a banned site address
				if( in_array($path, $banned_site_address) != true ) {
					$site_exists = domain_exists( $current_blog->domain, $current_site->path.$path );   
				}
				else {
					$is_banned_site = 1;
				}

				// Validate if user's given path is name of a site category
				// Super admins are allowed to create sites with address as one of site category
				if ( !is_super_admin() ) {
					foreach ( $site_category as $site_category_user => $site_category_user_value ) {
						foreach ( $site_category_user_value as $key => $value) {
							if( $path == $this->ssw_sanitize_option('sanitize_url', $value)) {
								$is_banned_site = 1;
							}
						}
					}
				}
				
				// Validate for error flags if set
				if( $is_banned_site == 1 ) {
					echo '2';
				}
				else {
					if( $site_exists ) {
						echo '1';
					}
					else {
						echo '0';
					}
				}
				// Extra wp_die is to stop ajax call from appending extra 0 to the resposne
				wp_die();
			}
			else {
				wp_die("Please use valid forms to send data.");
			}
		}

		/**
		 * Check if given admin email address is a registered user of the system 
		 *
		 * @since  1.0
		 * @return int 0 if email doesn't exist otherwise user_id for registered email address
		 */
		public function ssw_check_admin_email_exists() {
			if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				global $wpdb;
				global $current_user;
				$current_user_id = $current_user->ID;
				$current_user_email = $current_user->user_email;
				// sanitize_email sanitizes the value to allowed email address for 
				// passing in to a SQL query
				$admin_email = sanitize_email( $_POST['admin_email'] );

				if( $admin_email == $current_user_email ) {
					$admin_user_id = $current_user_id;
				}
				else {
					// Find Admin's ID if current user is not going to be the admin of the site 
					// from wp_users table to store since it will be used as a parameter
					// in wpmu_create_blog function 
					$admin_user_id = $wpdb->get_var( 'SELECT ID FROM '.$wpdb->base_prefix.'users WHERE user_email = \''.$admin_email.'\'' );
				}
				if( $admin_user_id != '' ) {
					echo $admin_user_id;
				}
				else {
					echo '0';
				}
				// Extra wp_die is to stop ajax call from appending extra 0 to the resposne
				wp_die();
			}
			else {
				wp_die("Please use valid forms to send data.");
			}
		}
		
		/**
		 * SSW Create Site function which is the main function
		 *
		 * @since  1.0
		 * @return void
		 */
		public function ssw_create_site() {

			// SSW Container for AJAX start
			echo '<div id="ssw-container-for-ajax" name="ssw_container_for_ajax">';

			if ( !is_user_logged_in() ) {
				wp_die( 'You must be logged in to run this script.' );
			}

			//	Currently this plugin only supports sub directory path hence unless it
			//	sub domain path value please do not allow users with sub domain to activate it. 
			if( is_subdomain_install() ) {
				echo '<h2>This plugin only supports sub directory wordpress installation. Please switch 
				to sub directory installation or contact your system administrator.</h2>';
			}

			// Fetch information of current user based on his role assigned 
			// on root site by switching to root site
			if ( get_current_blog_id() != 1 ) {
				switch_to_blog(1);
			}			
			global $wpdb;
			global $current_user;
			global $current_blog;
			global $current_site;

			$current_user_id = $current_user->ID;
			$current_user_email = $current_user->user_email;
			
			// Identifing current domain and path on domain where wordpress is running from
			$current_site_root_address = $current_blog->domain.$current_site->path;
			
			// Identifying current user's role to restrict some content based on that
			$current_user_role_array = $current_user->roles;
			if(!$current_user_role_array) {
				$current_user_role = Array();
			}
			else {
				$current_user_role = $current_user_role_array[0];	
			}

			// Restore to original blog it came from before you switched to 
			// root site in case you did
			restore_current_blog();

			// Site Setup Wizard implementation starts here
			$options = $this->ssw_fetch_config_options();
			$site_user_category = $options['site_user_category'];
			$site_category_no_prefix = $options['site_category_no_prefix'];
			$hide_plugin_category = $options['hide_plugin_category'];
			$external_plugins = $options['external_plugins'];
			$user_role_mapping = $options['user_role_mapping'];
			$site_type = $options['site_type'];
			$is_user_role_restriction = $options['user_role_restriction'];
			$ssw_not_available = $options['ssw_not_available'];
			$ssw_not_available_txt = $options['ssw_not_available_txt'];
			$terms_of_use = $options['terms_of_use'];
			$hide_themes = $options['hide_themes'];
			$hide_plugins = $options['hide_plugins'];
			$plugins_page_txt = $options['plugins_page_txt'];
			$finish_page_txt = $options['finish_page_txt'];
			$steps_name = isset($options['steps_name']) ? $options['steps_name'] : '';
			$is_privacy_selection = isset($options['privacy_selection']) ? $options['privacy_selection'] : false;
			$is_debug_mode = isset($options['debug_mode']) ? $options['debug_mode'] : false;
			$is_master_user = isset($options['master_user']) ? $options['master_user'] : false;

			// Fetch values if the given external plugins are installed or not
			$wpmu_multisite_privacy_plugin = $external_plugins['wpmu_multisite_privacy_plugin'];
			$wpmu_pretty_plugins = $external_plugins['wpmu_pretty_plugins'];
			$wpmu_new_blog_template = $external_plugins['wpmu_new_blog_template'];

			// Advanced Privacy Settings Text
			$privacy_selection_txt = $options['advanced_privacy']['privacy_selection_txt'];
			$private_network_users_txt = $options['advanced_privacy']['private_network_users_txt'];
			$private_site_users_txt = $options['advanced_privacy']['private_site_users_txt'];
			$private_administrator_txt = $options['advanced_privacy']['private_administrator_txt'];

			// Fetch theme options to get list of all themes and their categories
			$theme_options = $this->ssw_fetch_theme_options();
			$themes_categories = $theme_options['themes_categories'];
			$themes_list = $theme_options['themes_list'];
			
			// Fetch plugin options to get list of all plugins and their categories
			$plugin_options = $this->ssw_fetch_plugin_options();
			$plugins_categories = $plugin_options['plugins_categories'];
			$plugins_list = $plugin_options['plugins_list'];

			if ( $current_user_role == $ssw_not_available ) {
				_e($ssw_not_available_txt);
			}
			
			else {
				
				/**
				 * Apply Filter for performing extra check before loading all steps
				 *
				 * @since  1.5.3 
				 */
				$ssw_hide_steps = apply_filters('ssw_additional_checks', FALSE);

				if(true === $ssw_hide_steps)
					return;

				$ssw_main_table = $this->ssw_main_table();

				// Cancel current site setup Wizard Process and restart it
				if( isset( $_POST['ssw_cancel'] ) && 'true' === $_POST['ssw_cancel'] )
				{
					$wpdb->query( 'DELETE FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.' and wizard_completed = false' );
					$this->ssw_log_sql_error($wpdb->last_error);

					// $wpdb->delete ($ssw_main_table, array('user_id'=>$current_user_id));
					echo 'Let\'s Create a new site again!';
				}

				// Resume Site Setup Wizard from where left off before
				$ssw_next_stage = $wpdb->get_var(
					'SELECT next_stage FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.' and wizard_completed = false'
					);
				$this->ssw_log_sql_error($wpdb->last_error);

				// Move to the next step using this POST variable "ssw_next_stage" 
				if( ! empty( $_POST['ssw_next_stage'] ) ) {
					$ssw_next_stage = $_POST['ssw_next_stage'];
				}

				// Display all forms based on the "ssw_next_stage" POST variable
				echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="ssw-steps" name="ssw-steps">';

				if($ssw_next_stage == '' || $ssw_next_stage =='ssw_step1') {
					include(SSW_PLUGIN_DIR.'wizard/step1.php');                    
				}

				else if($ssw_next_stage =='ssw_step2') {
					if ( isset( $_POST['step1_nonce'] ) && wp_verify_nonce($_POST['step1_nonce'], 'step1_action') ){
						include(SSW_PLUGIN_DIR.'admin/step1_process.php');

						// DEBUG variables in ssw_create_site() which are defined before Step1
						$this->ssw_debug_log('ssw', 'current_user_id', $current_user_id);
						$this->ssw_debug_log('ssw', 'current_user_email', $current_user_email);
						$this->ssw_debug_log('ssw', 'current_site_root_address', $current_site_root_address);
						$this->ssw_debug_log('ssw', 'current_user_role_array', $current_user_role_array);
						$this->ssw_debug_log('ssw', 'current_user_role', $current_user_role);
						$this->ssw_debug_log('ssw', 'options', $options);
						$this->ssw_debug_log('ssw', 'theme_options', $theme_options);
						$this->ssw_debug_log('ssw', 'plugin_options', $plugin_options);
					}
					include(SSW_PLUGIN_DIR.'wizard/step2.php');
				}

				else if($ssw_next_stage =='ssw_step3') {
					if ( isset( $_POST['step2_nonce'] ) && wp_verify_nonce($_POST['step2_nonce'], 'step2_action') ){
						include(SSW_PLUGIN_DIR.'admin/step2_process.php');

						// You can include this file at any step during which you want to create new site
						include(SSW_PLUGIN_DIR.'admin/create_new_site.php');
					}
					include(SSW_PLUGIN_DIR.'wizard/step3.php');
				}
				
				else if($ssw_next_stage =='ssw_step4') {
					if ( isset( $_POST['step2_nonce'] ) && wp_verify_nonce($_POST['step2_nonce'], 'step2_action') ){
						include(SSW_PLUGIN_DIR.'admin/step2_process.php');
						
						// Create a new site based on information given (reserving url for user)
						// You can include this file at any step during which you want to create new site
						include(SSW_PLUGIN_DIR.'admin/create_new_site.php');
					}
					else if ( isset( $_POST['step3_nonce'] ) && wp_verify_nonce($_POST['step3_nonce'], 'step3_action' ) ){
						include(SSW_PLUGIN_DIR.'admin/step3_process.php');

					}
					include(SSW_PLUGIN_DIR.'wizard/step4.php');
				}
				
				else if($ssw_next_stage == 'ssw_finish') {
					if ( isset( $_POST['step3_nonce'] ) && wp_verify_nonce($_POST['step3_nonce'], 'step3_action' ) ){
						include(SSW_PLUGIN_DIR.'admin/step3_process.php');

					}
					else if ( isset( $_POST['step4_nonce'] ) && wp_verify_nonce( $_POST['step4_nonce'], 'step4_action' ) ){
						include(SSW_PLUGIN_DIR.'admin/step4_process.php');

					}
					include(SSW_PLUGIN_DIR.'wizard/finish.php');
				}
				echo '</form>';
				echo '</div>';
				// Die when doing AJAX to prevent extra output.
				if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
					die();
				}
			}
		}

		/**
		 * SSW Remove an incomplete workflow when a site is deleted
		 *
		 * @since  1.5.9
		 * @return void
		 */
		public function ssw_handle_site_deleted($blog_id) {
			global $wpdb;
			$wpdb->query( 'DELETE FROM '.$this->ssw_main_table().' WHERE blog_id = '.$blog_id.' and wizard_completed = false' );
		}
	}
}

if(class_exists('Site_Setup_Wizard')) {
	// instantiate plugin class
	$site_setup_wizard = new Site_Setup_Wizard();
}

?>