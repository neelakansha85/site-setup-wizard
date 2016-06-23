<?php

global $wpdb;
/* Table name to store on going site setup wizard */
$ssw_main_table = $this->ssw_main_table();

$sql_ssw_main_table = "CREATE TABLE ".$ssw_main_table." (
	ssw_id bigint(20) AUTO_INCREMENT,
	user_id bigint(20) NOT NULL,
	admin_email varchar(100) DEFAULT NULL,
	admin_user_id bigint(20) NOT NULL,
	path varchar(100) DEFAULT NULL, 
	title varchar(255) DEFAULT NULL, 
	privacy varchar(100) DEFAULT NULL,
	template varchar(100) DEFAULT NULL,
	theme varchar(100) DEFAULT NULL,
	plugins_group longtext DEFAULT NULL,
	plugins_list longtext DEFAULT NULL,
	new_users longtext DEFAULT NULL,
	new_users_role varchar(255) DEFAULT NULL,
	next_stage varchar(50) DEFAULT NULL,
	site_type varchar(100) DEFAULT NULL,
	blog_id bigint(20) DEFAULT NULL,
	ssw_main_meta longtext DEFAULT NULL,
	site_created boolean NOT NULL DEFAULT '0',
	wizard_completed boolean NOT NULL DEFAULT '0',
	starttime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	endtime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY  (ssw_id)
	)
;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql_ssw_main_table );
?>