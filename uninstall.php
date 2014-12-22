<?php
/*
Site Setup Wizard Uninstall File
*/

/*	Unistall the plugin	*/ 
	global $wpdb;

	if ( !defined('WP_UNINSTALL_PLUGIN') ) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
	}

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

?>