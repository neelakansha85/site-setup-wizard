<?php
/*
Plugin Name: Site Setup Wizard
Description: Allows creating sites automatically using a simple shortcode [site_setup_wizard] placed on the site. The plugin is completely customizable.
Plugin URI: http://neelshah.info
Author: Neel Shah <neel@nsdesigners.com>
Author URI: http://neelshah.info
License: GPL2
Version: 1.2.2
*/


define('SSW_PLUGIN_URL', plugin_dir_url( __FILE__ ));
//define('SSW_PLUGIN_URL', plugins_url( __FILE__ ).'/');
define('SSW_PLUGIN_DIR', dirname( __FILE__ ).'/');
// SSW Plugin Main table name
define('SSW_MAIN_TABLE', 'ssw_main_nsd');
// SSW Plugin Root Dir name
define('SSW_PLUGIN_FIXED_DIR', 'nsd-site-setup-wizard');
// This is the slug used for the plugin's create site wizard page 
define('SSW_CREATE_SITE_SLUG', 'Site_Setup_Wizard');
define('SSW_OPTIONS_PAGE_SLUG', 'Site_Setup_Wizard_Options');
define('SSW_ANALYTICS_PAGE_SLUG', 'Site_Setup_Wizard_Analytics');
define('SSW_CONFIG_OPTIONS_FOR_DATABASE', 'ssw_config_options_nsd');
define('SSW_PLUGINS_CATEGORIES_FOR_DATABASE', 'ssw_plugins_categories_nsd');
define('SSW_PLUGINS_LIST_FOR_DATABASE', 'ssw_plugins_list_nsd');
define('SSW_THEMES_CATEGORIES_FOR_DATABASE', 'ssw_themes_categories_nsd');
define('SSW_THEMES_LIST_FOR_DATABASE', 'ssw_themes_list_nsd');
define('SSW_VERSION', '1.2.2');


if(!class_exists('Site_Setup_Wizard_NSD')) {
	class Site_Setup_Wizard_NSD {

		/* All public variables that will be used for dynamic programming */	
			public $multiste;		
			/* Site Path variable */
			public $path;

			/* Site Meta options for WPMU Pretty Plugins in which it stores Plugins categories and other information */
			public $wpmu_pretty_plugins_categories_site_option = 'wmd_prettyplugins_plugins_categories';
			public $wpmu_pretty_plugins_plugins_list_site_option = 'wmd_prettyplugins_plugins_custom_data';
			public $wpmu_multisite_theme_manager_categories_site_option = 'wmd_prettythemes_themes_categories';
			public $wpmu_multisite_theme_manager_themes_list_site_option = 'wmd_prettythemes_themes_custom_data';
		
    	/*	Construct the plugin object	*/
		public function __construct() {

			// Installation and Deactivation hooks
			register_activation_hook(__FILE__, array( $this, 'ssw_activate' ) );
			// Plugin Deactivation Hook
			register_deactivation_hook(__FILE__, array( $this, 'ssw_deactivate' ) );
			
			/* Add action to display Create Site menu item in Site's Dashboard */
			// add_action( 'admin_menu', array($this, 'ssw_menu'));
			/* Add action to display Create Site menu item in Network Admin's Dashboard */
			add_action( 'network_admin_menu', array( $this, 'ssw_network_menu' ) );
			/* Check and filter out all Network Activated plugin whenever any plugin is activated in the complete system */
			add_action( 'activated_plugin', array( $this, 'ssw_find_plugins' ) );
			/* Check and filter out all Network Activated plugin whenever any plugin is deactivated in the complete system */
			add_action( 'deactivated_plugin', array( $this, 'ssw_find_plugins' ) );
			/* Display all errors as admin message if occured */
			add_action( 'admin_notices', array( $this, 'ssw_admin_errors' ) );
			add_action( 'plugins_loaded', array( $this, 'ssw_find_plugins' ) );
			
			/* Include Javascripts and CSS for SSW Plugin on the backend */
			add_action( 'admin_enqueue_scripts', array( $this, 'ssw_admin_scripts' ) );
			/* Include Javascripts and CSS for SSW Plugin on the frontend */
			add_action( 'wp_enqueue_scripts', array( $this, 'ssw_frontend_scripts' ) );
			/* Add filter to replace dash to null for function sanitize_key() for sanitizing site path */
			add_filter( 'sanitize_key', array( $this, 'ssw_dash_to_null' ) );

			/* Add ajax request handlers for all buttons of wizard for admin section */
			add_action( 'wp_ajax_ssw_submit_form_cancel', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_previous', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_next', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_submit_form_skip', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_ssw_check_domain_exists', array( $this, 'ssw_check_domain_exists'));
			add_action( 'wp_ajax_ssw_check_admin_email_exists', array( $this, 'ssw_check_admin_email_exists'));
			add_action( 'wp_ajax_ssw_update_config_options', array( $this, 'ssw_update_config_options'));

			/* Add ajax request handlers for all buttons of wizard for frontend section */
			add_action( 'wp_ajax_nopriv_ssw_submit_form_cancel', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_previous', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_next', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_submit_form_skip', array( $this, 'ssw_create_site' ) );
			add_action( 'wp_ajax_nopriv_ssw_check_domain_exists', array( $this, 'ssw_check_domain_exists'));
			add_action( 'wp_ajax_nopriv_ssw_check_admin_email_exists', array( $this, 'ssw_check_admin_email_exists'));
			
			/* Add shortcode [site_setuo_wizard] to any page to display Site Setup Wizard over it */
			add_shortcode('site_setup_wizard', array( $this, 'ssw_shortcode' ) );
			
			/* Check and store is the wordpress installation is multisite or not */
			$this->multiste = is_multisite();

		}

		/* Store SSW Plugin's main table name in variable based on multisite */
		public function ssw_main_table( $tablename = SSW_MAIN_TABLE ) {
			global $wpdb;
			$ssw_main_table = $wpdb->base_prefix.$tablename;
			return $ssw_main_table;
		} 

		/* Fetch configuration options for SSW Plugin from wp_sitemeta table */
		public function ssw_fetch_config_options() {
			$options = get_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			return $options;
		}
		/* Update configuration options for SSW Plugin from wp_sitemeta table */
		public function ssw_update_config_options() {
			if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				include(SSW_PLUGIN_DIR.'admin/ssw_update_options.php');
				$options = update_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE, $ssw_config_options_nsd );
				if( $options ) {
					echo '1';
				}
				else {
					echo '0';
				}
		        /* Extra wp_die is to stop ajax call from appending extra 0 to the resposne */
				wp_die();
			}
			else {
				wp_die("Please use valid forms to send data.");
			}

			
		}
		/* Fetch Plugin options for SSW Plugin from wp_sitemeta table */
		public function ssw_fetch_plugin_options() {
			$plugin_options['plugins_categories'] = get_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE );
			$plugin_options['plugins_list'] = get_site_option( SSW_PLUGINS_LIST_FOR_DATABASE );
			return $plugin_options;
		}
		/* Update Plugin options for SSW Plugin from wp_sitemeta table */
		public function ssw_update_plugin_options( $new_plugin_options ) {
			$plugin_options['plugins_categories'] = update_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE, $new_plugin_options['plugins_categories'] );
			$plugin_options['plugins_list'] = update_site_option( SSW_PLUGINS_LIST_FOR_DATABASE, $new_plugin_options['plugins_list'] );
			return $plugin_options;
		}
		/* Fetch Theme options for SSW Plugin from wp_sitemeta table */
		public function ssw_fetch_theme_options() {
			$theme_options['themes_categories'] = get_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE );
			$theme_options['themes_list'] = get_site_option( SSW_THEMES_LIST_FOR_DATABASE );
			return $theme_options;
		}
		/* Update Theme options for SSW Plugin from wp_sitemeta table */
		public function ssw_update_theme_options( $new_theme_options ) {
			$theme_options['themes_categories'] = update_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE, $new_theme_options['themes_categories'] );
			$theme_options['themes_list'] = update_site_option( SSW_THEMES_LIST_FOR_DATABASE, $new_theme_options['themes_list'] );
			return $theme_options;
		}

		/* Activate the plugin	*/  
		public function ssw_activate() {
			include(SSW_PLUGIN_DIR.'admin/ssw_activate.php');
			include(SSW_PLUGIN_DIR.'admin/ssw_add_options.php');
			/* Add SSW plugin options to the wp_sitemeta table for network wide settings */
			$config_options_exist = get_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			if($config_options_exist == '')
			{
			    add_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE, $ssw_config_options_nsd );
			}
			else {
			    $error = 1000;
				$this->ssw_admin_errors( $error );
			}
			$plugins_categories_options_exist = get_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE, '' );
			if($plugins_categories_options_exist == '')
			{
			    add_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE, '' );
			}
			else {
			    $error = 1001;
				$this->ssw_admin_errors( $error );
			}
			$plugins_list_options_exist = get_site_option( SSW_PLUGINS_LIST_FOR_DATABASE, '' );
			if($plugins_list_options_exist == '')
			{
			    add_site_option( SSW_PLUGINS_LIST_FOR_DATABASE, '' );
			}
			else {
			    $error = 1002;
				$this->ssw_admin_errors( $error );
			}
			$themes_categories_options_exist = get_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE, '' );
			if($themes_categories_options_exist == '')
			{
			    add_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE, '' );
			}
			else {
			    $error = 1003;
				$this->ssw_admin_errors( $error );
			}
			$themes_list_options_exist = add_site_option( SSW_THEMES_LIST_FOR_DATABASE,'' );
			if($themes_list_options_exist == '')
			{
			    add_site_option( SSW_THEMES_LIST_FOR_DATABASE, '' );
			}
			else {
			    $error = 1004;
				$this->ssw_admin_errors( $error );
			}
			/* Find list of all plugins available in network when this plugin is activated */
			$this->ssw_find_plugins();
		} 

		/*	Deactivate the plugin	*/
		public function ssw_deactivate() {
			/* Simply deactivate the plugin for now */			
			/*	#TODO:	NEEL PLEASE REMOVE THIS FOR PRODUCTION	*/
			/*
			
			global $wpdb;
			if ( !is_user_logged_in() ) {
				wp_die( 'You must be logged in to run this script.' );
			}
			if ( !current_user_can( 'install_plugins' ) ) {
				wp_die( 'You do not have permission to run this script.' );
			}
			delete_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			delete_site_option( SSW_PLUGINS_CATEGORIES_FOR_DATABASE );
			delete_site_option( SSW_PLUGINS_LIST_FOR_DATABASE );
			delete_site_option( SSW_THEMES_CATEGORIES_FOR_DATABASE );
			delete_site_option( SSW_THEMES_LIST_FOR_DATABASE );
			$ssw_main_table = $wpdb->base_prefix.SSW_MAIN_TABLE;
			// Drop SSW Main Table
			$wpdb->query( 'DROP TABLE IF EXISTS '.$ssw_main_table );
			
			*/

			delete_site_option( SSW_CONFIG_OPTIONS_FOR_DATABASE );
			
		} 
		
		/*	Menu function to display Site Setup Wizard -> Create Site in Site's Dashboard	*/
		public function ssw_menu() {
			/*	Adding Menu item "Create Site" in Dashboard, allowing it to be displayed for all users including 
				subscribers with "read" capability and displaying it above the Dashboard with position "1.7"
			*/
			add_menu_page('Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array( $this, 'ssw_create_site' ), plugins_url(SSW_PLUGIN_FIXED_DIR.'/images/icon.png'), '1.38');
		}

		/*	Menu function to display Site Setup Wizard -> Create Site in the Network Admin's Dashboard	*/
		public function ssw_network_menu() {
			/*	Adding Menu item "Create Site" in Dashboard, allowing it to be displayed for all users including 
				subscribers with "read" capability and displaying it above the Dashboard with position "1.7"
			*/
			add_menu_page('Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array($this, 'ssw_create_site'), plugins_url(SSW_PLUGIN_FIXED_DIR.'/images/icon.png'), '1.38');
			/* Adding First Sub menu item in the SSW Plugin to reflect the Create Site functionality in the sub menu */
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard', 'Create Site', 'read', SSW_CREATE_SITE_SLUG, 
				array($this, 'ssw_create_site') );
			/* Adding SSW Options page in the Network Dashboard below the Create Site menu item */
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard Options', 'Options', 'manage_network', 
				SSW_OPTIONS_PAGE_SLUG, array($this, 'ssw_options_page') );
			/* Adding SSW Reports page in the Network Dashboard below the Create Site menu item */
			add_submenu_page(SSW_CREATE_SITE_SLUG, 'Site Setup Wizard Analytics', 'Analytics', 'manage_network', 
				SSW_ANALYTICS_PAGE_SLUG, array($this, 'ssw_analytics_page') );
		}

		/* Display all admin message errors when occurs */
		public function ssw_admin_errors( $error ) {
			if($error == 1000) {
				echo '
					<div class="error">
						<p>Plugin Activation Error: There exists another plugin which uses the same config options name
						as Site Setup Wizard Plugin uses.</p>
					</div>
				';
			}
		}

		/* Register CSS Stylesheet for Admin section pages on the backend */
		public function ssw_admin_scripts() {
			$options = $this->ssw_fetch_config_options();
			$site_address_bucket_none_value = $options['site_address_bucket_none_value'];

			/* Register all required Javascripts for SSW Plugin with it's wp_register_script hook */
			wp_register_script( 'ssw-custom-js', SSW_PLUGIN_URL.'js/custom.js' );
			/* Include the Javascripts for the ssw plugin while trying to create a site */
    		wp_enqueue_script( 'ssw-custom-js' );

    		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
			wp_localize_script( 'ssw-custom-js', 'ssw_custom_ajax', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				/* generate a nonce with a unique ID "ssw_ajax_nonce"
            	so that you can check it later when an AJAX request is sent */
            	'ssw_ajax_nonce' => wp_create_nonce( 'ssw_ajax_action' ),
            	'site_address_bucket_none_value' => $site_address_bucket_none_value
            	)
			);

			/* Link stylesheets for the SSW Plugin when plugin is called for */
			wp_register_style( 'ssw-style-css', SSW_PLUGIN_URL.'css/ssw-style.css' );
			wp_register_style( 'ssw-media-css', SSW_PLUGIN_URL.'css/ssw-media.css' );
			wp_enqueue_style( 'ssw-style-css' );
  			wp_enqueue_style( 'ssw-media-css' );
		}

		/* Register Javascripts for the frontend and backend */
		public function ssw_frontend_scripts() {
			$options = $this->ssw_fetch_config_options();
			$site_address_bucket_none_value = $options['site_address_bucket_none_value'];

			/* Register all required Javascripts for SSW Plugin with it's wp_register_script hook */
			wp_register_script( 'ssw-custom-js', SSW_PLUGIN_URL.'js/custom.js' );

			/* Include the Javascripts for the ssw plugin while trying to create a site */
    		wp_enqueue_script( 'ssw-custom-js' );

			// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
			wp_localize_script( 'ssw-custom-js', 'ssw_custom_ajax', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				/* generate a nonce with a unique ID "ssw_ajax_nonce"
            	so that you can check it later when an AJAX request is sent */
            	'ssw_ajax_nonce' => wp_create_nonce( 'ssw_ajax_action' ),
            	'site_address_bucket_none_value' => $site_address_bucket_none_value
            	)
			);

			/* Link stylesheets for the SSW Plugin when plugin is called for */
			wp_register_style( 'ssw-style-css', SSW_PLUGIN_URL.'css/ssw-style.css' );
			wp_register_style( 'ssw-media-css', SSW_PLUGIN_URL.'css/ssw-media.css' );
			wp_enqueue_style( 'ssw-style-css' );
  			wp_enqueue_style( 'ssw-media-css' );
		}

		/* Find all currently available plugins and are not network activated to offer for the Features page */
		public function ssw_find_plugins() {
			global $wpdb;
			$options = $this->ssw_fetch_config_options();
			$wpmu_pretty_plugins = $options['external_plugins']['wpmu_pretty_plugins'];
			$plugins_list = array('');

			if ($wpmu_pretty_plugins == true) {
				$plugins_categories = get_site_option($this->wpmu_pretty_plugins_categories_site_option);
				$all_plugins = get_site_option($this->wpmu_pretty_plugins_plugins_list_site_option);
				foreach ($all_plugins as $key => $value) {
					if ( !function_exists( 'validate_plugin' ) ) {
		        		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	    			}

					/* Validate if the plugin still exists in the system though it is present in Pretty Plugins list */
					$validated = validate_plugin( $key );
					if( !is_wp_error( $validated ) ) {
						/* Find list of all plugins which are not network activated and store it in plugins_list variable */
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
					/* Find list of all plugins which are not network activated and store it in plugins_list variable */
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
		/* Find all currently available themes which are network activated to offer for the Themes page */
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
		/* SSW Shortcode function */
		public function ssw_shortcode() {
			if( !is_user_logged_in()) {
				$login_url = site_url( 'wp-login.php?redirect_to='.urlencode( network_site_url( $_SERVER['REQUEST_URI'] ) ) ).'&action=shibboleth';
				echo sprintf( __( 'You must first <a href="%s">log in</a>, and then you can create a new site.' ), $login_url );
			}
			else {
				$this->ssw_create_site();
			}
		}

		/* SSW Options Page which is displayed under the Network Dashboard -> Create Site -> Options Page */
		public function ssw_options_page() {
			include(SSW_PLUGIN_DIR.'admin/ssw_options_page.php');
		}

		/* SSW Reports Page which is displayed under the Network Dashboard -> Create Site -> Reports Page */
		public function ssw_analytics_page() {
			include(SSW_PLUGIN_DIR.'admin/ssw_analytics_page.php');
		}

		/* Replaces dash in string to null for sanitizing site path */
		public function ssw_dash_to_null($site_path) {
			return str_replace( '-', '', $site_path );
		}

		/* Check if given path is already taken by another site or not */
		public function ssw_check_domain_exists() {
			if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				global $current_blog;
				global $current_site;
				global $wpdb;
				$options = $this->ssw_fetch_config_options();
				$site_address_bucket_none_value = $options['site_address_bucket_none_value'];
				$banned_root_site_address = $options['banned_root_site_address'];
    			$banned_site_address = $options['banned_site_address'];
    			$is_debug_mode = $options['debug_mode'];
    			
    			$site_address_bucket = sanitize_key( $_POST['site_address_bucket']);
    			$site_address = sanitize_key( $_POST['site_address']);
    			$is_banned_site = 0;
    			if( in_array($site_address_bucket, $site_address_bucket_none_value) != true  && $site_address_bucket != '' ) {
    				/* Check for banned site addresses */
    				if( in_array($site_address, $banned_site_address) != true ) {
    					$site_exists = domain_exists( $current_blog->domain, $current_site->path.sanitize_key( $_POST['site_complete_path'] ) );		
    				}
    				else {
    					$is_banned_site = 1;
    				}
    			}
    			else {
    				/* Check for banned root site addresses and banned site addresses */
    				if( in_array($site_address, $banned_root_site_address) != true && in_array($site_address, $banned_site_address) != true ) {
    					$site_exists = domain_exists( $current_blog->domain, $current_site->path.sanitize_key( $_POST['site_complete_path'] ) );		
    				}
    				else {
    					$is_banned_site = 1;
    				}
    			}
				if( $is_banned_site == 1 ) {
					echo '2';
				}
				else {
					if( $site_exists) {
						echo '1';
					}
					else {
						echo '0';
					}
				}
				/* Extra wp_die is to stop ajax call from appending extra 0 to the resposne */
				wp_die();
			}
			else {
				wp_die("Please use valid forms to send data.");
			}
		}

		/* Check if given admin email address is a registered user of the system */
		public function ssw_check_admin_email_exists() {
			if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
				global $wpdb;
				global $current_user;
				$current_user_id = $current_user->ID;
	    		$current_user_email = $current_user->user_email;
	    		/* sanitize_email sanitizes the value to allowed email address for passing in to a SQL query */
	    		$admin_email = sanitize_email( $_POST['admin_email'] );

				if( $admin_email == $current_user_email ) {
		            $admin_user_id = $current_user_id;
		        }
		        else {
		            /*  Find Admin's ID if current user is not going to be the admin of the site from wp_users table
		                to store since it will be used as a parameter in wpmu_create_blog function 
		            */
		            $admin_user_id = $wpdb->get_var( 'SELECT ID FROM '.$wpdb->base_prefix.'users WHERE user_email = \''.$admin_email.'\'' );
		        }
		        if( $admin_user_id != '' ) {
		        	echo $admin_user_id;
		        }
		        else {
		        	echo '0';
		        }
		        /* Extra wp_die is to stop ajax call from appending extra 0 to the resposne */
				wp_die();
			}
			else {
				wp_die("Please use valid forms to send data.");
			}
		}
		
		/*	SSW Create Site function which is the main function	*/
		public function ssw_create_site() {

			/* SSW Container for AJAX start */
			echo '<div id="ssw-container-for-ajax" name="ssw_container_for_ajax">';

				/* Double check security to not allow running this script if called from outside class */
				if ( !is_user_logged_in() ) {
					wp_die( 'You must be logged in to run this script.' );
				}
				/*	Currently this plugin only supports sub directory path hence unless it supports sub domain
					path value please do not allow users with sub domain to activate it. 
				*/
				/*	If you fix the sub domain path then remember to remove this check from the final step also 
					which calls wpmu_create_blog method to create new site 
				*/
				if( is_subdomain_install() ) {
					echo '<h2>This plugin only supports sub directory wordpress installation. Please switch 
							to sub directory installation or contact author.</h2>';
				}
			
			/* Fecth information of current user based on his role assigned on root site by switching to root site */
    		if ( get_current_blog_id() != 1 ) {
				switch_to_blog(1);
    		}			
    		global $wpdb;
		    /* Fetch details of current user in form of Array; wordpress global variable */
			global $current_user;
			/* Fetch details of current blog in form of Array; wordpress global variable */
    		global $current_blog;
    		global $current_site;

			$current_user_id = $current_user->ID;
    		$current_user_email = $current_user->user_email;
    		/* Identifing current domain and path on domain where wordpress is running from */
    		$current_site_root_address = $current_blog->domain.$current_site->path;
    		/* Identifying current user's role to restrict some content based on that */
    		$current_user_role_array = $current_user->roles;
    		$current_user_role = $current_user_role_array[0];
    		/* User with this property will be able to see complete SSW plugin */
    		/* Currently edit_post is a capability of all users above subscriber level. */
    		// $master_user = current_user_can('read');
    		$master_user = true;

    		/* Restore to original blog it came from before you switched to root site in case you did */
    		restore_current_blog();

			/* Site Setup Wizard implementation starts here */	
    		/* Fetch basic config options to control the work flow of the Site Setup Wizard */
    		$options = $this->ssw_fetch_config_options();
    			$site_address_bucket = $options['site_address_bucket'];
    			$site_address_bucket_none_value = $options['site_address_bucket_none_value'];
    			$template_type = $options['template_type'];
				$select_template = $options['select_template'];
				$hide_plugin_category = $options['hide_plugin_category'];
				$external_plugins = $options['external_plugins'];
				$restricted_user_roles = $options['restricted_user_roles'];
				$site_usage = $options['site_usage'];
				$site_usage_display_common = $options['site_usage_display_common'];
				$ssw_not_available = $options['ssw_not_available'];
				$terms_of_use = $options['terms_of_use'];
				$is_debug_mode = $options['debug_mode'];
				$is_privacy_selection = $options['privacy_selection'];

				/* Fetch values if the given external plugins are installed or not */
    			$wpmu_multisite_privacy_plugin = $external_plugins['wpmu_multisite_privacy_plugin'];
    			$wpmu_pretty_plugins = $external_plugins['wpmu_pretty_plugins'];
    			$wpmu_new_blog_template = $external_plugins['wpmu_new_blog_template'];

    		/* Fetch theme options to get list of all themes and their categories */
    		$theme_options = $this->ssw_fetch_theme_options();
    			$themes_categories = $theme_options['themes_categories'];
    			$themes_list = $theme_options['themes_list'];
			/* Fetch plugin options to get list of all plugins and their categories */
    		$plugin_options = $this->ssw_fetch_plugin_options();
    			$plugins_categories = $plugin_options['plugins_categories'];
				$plugins_list = $plugin_options['plugins_list'];

    		if ( $current_user_role == $ssw_not_available ) {
    			echo 'Apologies but Alumni\'s do not have access to create new sites using this service at NYU. 
    				If you believe this is by error, please contact askits@nyu.edu';
    		}
    		else {
	    		$ssw_main_table = $this->ssw_main_table();
				
				/* Cancel current site setup Wizard Process and restart it */
				if( $_REQUEST['ssw_cancel'] == true )
				{
					$wpdb->query( 'DELETE FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.' and wizard_completed = false' );
					// $wpdb->delete ($ssw_main_table, array('user_id'=>$current_user_id));
					echo 'Let\'s Create a new site again!';
				}

				/* Resume Site Setup Wizard from where left off before */
				if( $_POST['ssw_cancel'] != true ) {
					$ssw_next_stage = $wpdb->get_var( 
						'SELECT next_stage FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.' and wizard_completed = false'
					);
					/* Applying Hotfix to avoid displaying Step 3 for issue with wizard freezing on Step 2 */
					/*
					if($ssw_next_stage != 'ssw_step2') {
						$ssw_next_stage = '';
					}
					*/
				}
				/* Move to the next step using this POST variable "ssw_next_stage" */
				if( $_POST['ssw_next_stage'] != '' && $_POST['ssw_cancel'] != true ) {
					$ssw_next_stage = $_POST['ssw_next_stage'];
				}

				/* Display all forms based on the "ssw_next_stage" POST variable */
				echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST" id="ssw-steps" name="ssw-steps">';
	         
				if($ssw_next_stage == '' || $ssw_next_stage =='ssw_step1') {
					include(SSW_PLUGIN_DIR.'wizard/step1.php');
				}

				else if($ssw_next_stage =='ssw_step2') {
					/* Wordpress Security function wp_nonce to avoid execution of same function/orject multiple times */
					if (wp_verify_nonce($_POST['step1_nonce'], 'step1_action') ){
						/* update fields in the database only if POST values come from previous step */
						include(SSW_PLUGIN_DIR.'admin/step1_process.php');
				    }
					include(SSW_PLUGIN_DIR.'wizard/step2.php');
				}

				else if($ssw_next_stage =='ssw_step3') {
					/* Wordpress Security function wp_nonce to avoid execution of same function/orject multiple times */
					if (wp_verify_nonce($_POST['step2_nonce'], 'step2_action') ){
						/* update fields in the database only if POST values come from previous step */
						include(SSW_PLUGIN_DIR.'admin/step2_process.php');
				    }
					include(SSW_PLUGIN_DIR.'wizard/step3.php');
				}
				
				else if($ssw_next_stage =='ssw_step4') {
					/* Wordpress Security function wp_nonce to avoid execution of same function/orject multiple times */
					if (wp_verify_nonce($_POST['step2_nonce'], 'step2_action') ){
						/* update fields in the database only if POST values come from previous step */
						include(SSW_PLUGIN_DIR.'admin/step2_process.php');
						/* Create Actual new site based on information given */
						/* You can include this file at any step before which you want to create new site*/
						include(SSW_PLUGIN_DIR.'admin/create_new_site.php');
				    }
					/* Wordpress Security function wp_nonce to avoid execution of same function/orject multiple times */
					else if (wp_verify_nonce($_POST['step3_nonce'], 'step3_action') ){
						/* update fields in the database only if POST values come from previous step */
						include(SSW_PLUGIN_DIR.'admin/step3_process.php');
				    }
					include(SSW_PLUGIN_DIR.'wizard/step4.php');
				}
				
				else if($ssw_next_stage == 'ssw_finish') {
					/* Wordpress Security function wp_nonce to avoid execution of same function/orject multiple times */
					if (wp_verify_nonce($_POST['step4_nonce'], 'step4_action') ){
						/* update fields in the database only if POST values come from previous step */
						include(SSW_PLUGIN_DIR.'admin/step4_process.php');
				    }
					include(SSW_PLUGIN_DIR.'wizard/finish.php');
				}

				echo '</form>';
				echo '</div>';
				/* SSW Container for AJAX ends */
				if (wp_verify_nonce($_POST['ssw_ajax_nonce'], 'ssw_ajax_action') ){
					/* Extra wp_die is to stop ajax call from appending extra 0 to the resposne */
					wp_die();
				}
			}
		}
	}
}

if(class_exists('Site_Setup_Wizard_NSD')) {
	// instantiate the plugin class
	$site_setup_wizard_nsd = new Site_Setup_Wizard_NSD();
}

?>