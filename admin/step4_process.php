<?php

/*
Insert from Step 4 data into SSW's table in database 
 */
if( $_POST['ssw_next_stage'] != '' ) {    
    $plugins_to_install_group = array();
    /* 
    plugins_to_install_group contains path of the plugins files to be 
    activated hence requires capital letters and forward slashes to be allowed 
     */
    if ( $_POST['plugins_to_install_group'] != '' ) {
        foreach ( $_POST['plugins_to_install_group'] as $selected_plugins )
        {
            $plugins_to_install_group[] = sanitize_text_field( $selected_plugins );
        }
    }
    $next_stage = $this->ssw_sanitize_option('sanitize_key', $_POST['ssw_next_stage']);
    $this->ssw_debug_log('step4_process', 'next_stage', $next_stage);
    
    $serialized_plugins_to_install_group = serialize( $plugins_to_install_group );
    $this->ssw_debug_log('step4_process', 'serialized_plugins_to_install_group', $serialized_plugins_to_install_group);
    
    $endtime = current_time('mysql');

    $result = $wpdb->update(
        $ssw_main_table,
        array(
            'plugins_list' => $serialized_plugins_to_install_group,
            'next_stage' => $next_stage,
            'endtime' => $endtime
        ),
        array(
            'user_id' => $current_user_id,
            'wizard_completed' => false
        )
    );

    $this->ssw_log_sql_error($wpdb->last_error);
    
    if ( is_wp_error( $result ) ) {
       $error_string = $result->get_error_message();
       echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
   }
}
?>