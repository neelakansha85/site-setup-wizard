<?php

	if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) { 
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
	global $wpdb;
	delete_site_option( 'nsd_ssw_plugins_categories' );
	delete_site_option( 'nsd_ssw_plugins_list' );
	delete_site_option( 'nsd_ssw_themes_categories' );
	delete_site_option( 'nsd_ssw_themes_list' );
	delete_site_option( 'nsd_ssw_config_options' );
	$ssw_main_table = $wpdb->base_prefix.'nsd_site_setup_wizard';
	// Drop SSW Main Table
	$wpdb->query( 'DROP TABLE IF EXISTS '.$ssw_main_table );	

?>