<?php

/* Insert from Step 1 data into SSW's table in database */
	if( $_POST['ssw_next_stage'] != '' ) {
		/* sanitize_title_for_query sanitizes the value to make it safe for passing in to a SQL query */
	    $site_usage = sanitize_title_for_query( $_POST['ssw_site_usage'] );
	    	$this->ssw_debug_log('step1_process','site_usage',$site_usage);

        $next_stage = sanitize_title_for_query( $_POST['ssw_next_stage'] );
	    	$this->ssw_debug_log('step1_process','next_stage',$next_stage);

        $starttime = current_time('mysql');
	    $endtime = $starttime;

	    $previously_inserted = $wpdb->get_var( $wpdb->prepare(
		'SELECT COUNT(*) FROM '.$ssw_main_table.' WHERE user_id = %d and wizard_completed = false', $current_user_id
		) );
	        $this->ssw_log_sql_error($wpdb->last_error);
	    	$this->ssw_debug_log('step1_process','previously_inserted',$previously_inserted);

	    if( $previously_inserted == 0 ) {
		$result = $wpdb->insert(
			$ssw_main_table,
			array(
				'user_id'    => $current_user_id,
				'site_usage' => $site_usage,
				'next_stage' => $next_stage,
				'starttime'  => $starttime,
				'endtime'    => $endtime,
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
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