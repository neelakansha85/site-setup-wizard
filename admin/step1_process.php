<?php

/* Insert from Step 1 data into SSW's table in database */
if( $_POST['ssw_next_stage'] != '' ) {
		/*
		sanitize_title_for_query sanitizes the value to make it safe
		for passing in to a SQL query
		 */
		$site_type = $this->ssw_sanitize_option('sanitize_text_field', $_POST['ssw_site_type']);
		$this->ssw_debug_log('step1_process','site_type',$site_type);

		$next_stage = $this->ssw_sanitize_option('sanitize_key', $_POST['ssw_next_stage']);
		$this->ssw_debug_log('step1_process','next_stage',$next_stage);

		$starttime = current_time('mysql');
		$endtime = $starttime;

		$previously_inserted = $wpdb->get_var( 
			'SELECT COUNT(*) FROM '.$ssw_main_table.' WHERE user_id ='.$current_user_id.' and wizard_completed = false'
			);
		$this->ssw_log_sql_error($wpdb->last_error);
		$this->ssw_debug_log('step1_process','previously_inserted',$previously_inserted);

		if( $previously_inserted == 0 ) {
			$result = $wpdb->query(
				$wpdb->prepare(
					"Insert into $ssw_main_table (user_id, site_type, next_stage, starttime, endtime)
					Values (%d, %s, %s, %s, %s)",
					$current_user_id, $site_type, $next_stage, $starttime, $endtime
					)
				);
			$this->ssw_log_sql_error($wpdb->last_error);
			
			if( is_wp_error( $result ) ) {
				$error_string = 'Please select a proper use case for your site';
				echo '<div id="message" class="error"><p>'.$error_string.'</p></div>';
			}
		}
	}
	
	?>