    <?php

/* Insert from Step 4 data into SSW's table in database */
    if( $_POST['ssw_next_stage'] != '' ) {    
        $plugins_to_install_group = array();
        /*  plugins_to_install_group contains path of the plugins files to be 
            activated hence requires capital letters and forward slashes to be allowed 
        */
        if ( $_POST['plugins_to_install_group'] != '' ) {
            foreach ( $_POST['plugins_to_install_group'] as $selected_plugins )
            {
                $plugins_to_install_group[] = sanitize_text_field( $selected_plugins );
            }
        }
        /* sanitize_title_for_query sanitizes the value to make it safe for passing in to a SQL query */
        $next_stage = sanitize_title_for_query( $_POST['ssw_next_stage'] );
        $serialized_plugins_to_install_group = serialize( $plugins_to_install_group );
        $endtime = current_time('mysql');
        
        $result = $wpdb->query(
            'UPDATE '.$ssw_main_table.' SET plugins_list = \''.$serialized_plugins_to_install_group.'\', 
            next_stage = \''.$next_stage.'\', endtime = \''.$endtime.'\' WHERE user_id = '.$current_user_id.' and wizard_completed = false'
        );
        if ( is_wp_error( $result ) ) {
           $error_string = $result->get_error_message();
           echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

?>