<?php

/* Insert from Step 3 data into SSW's table in database */
    if( $_POST['ssw_next_stage'] != '' ) {
        /* sanitize_title_for_query strips the content to make it safe for passing in to a SQL query */
        $theme = sanitize_title_for_query( $_POST['theme'] );
            $this->ssw_debug_log('step3_process', 'theme', $theme);
        
        $next_stage = sanitize_title_for_query( $_POST['ssw_next_stage'] );
            $this->ssw_debug_log('step3_process', 'next_stage', $next_stage);
        
        $endtime = current_time('mysql');
        $ssw_process_query = 'UPDATE '.$ssw_main_table.' SET theme = \''.$theme.'\', next_stage = \''.$next_stage.'\', 
			endtime = \''.$endtime.'\' WHERE user_id = '.$current_user_id.' and wizard_completed = false';
            $this->ssw_debug_log('step3_process', 'ssw_process_query', $ssw_process_query);
        
        $result = $wpdb->query( $ssw_process_query );
            $this->ssw_log_sql_error($wpdb->last_error);
	    
        if( is_wp_error( $result ) ) {
	        $error_string = 'Your have not selected a proper theme, please select again!';
	        echo '<div id="message" class="error"><p>'.$error_string.'</p></div>';
	    }    
    }

?>