<?php

/* Insert from Step 3 data into SSW's table in database */
if( $_POST['ssw_next_stage'] != '' ) {
    /* sanitize_title_for_query strips the content to make it safe for passing in to a SQL query */
    $theme = $this->ssw_sanitize_option('sanitize_title_for_query', $_POST['select_theme']);
    $this->ssw_debug_log('step3_process', 'theme', $theme);
    
    $next_stage = $this->ssw_sanitize_option('sanitize_key', $_POST['ssw_next_stage']);
    $this->ssw_debug_log('step3_process', 'next_stage', $next_stage);
    
    $endtime = current_time('mysql');

    $result = $wpdb->update(
        $ssw_main_table,
        array(
            'theme' => $theme,
            'next_stage' => $next_stage,
            'endtime' => $endtime
        ),
        array(
            'user_id' => $current_user_id,
            'wizard_completed' => false
        )
    );

    $this->ssw_log_sql_error($wpdb->last_error);
    
    if( is_wp_error( $result ) ) {
       $error_string = 'Your have not selected a proper theme, please select again!';
       echo '<div id="message" class="error"><p>'.$error_string.'</p></div>';
   }    
}

?>