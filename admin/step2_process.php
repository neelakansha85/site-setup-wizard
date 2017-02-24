<?php

/* Insert from Step 2 data into SSW's table in database */
if( $_POST['ssw_next_stage'] != '' && sanitize_key( $_POST['site_address'] ) != '' ) {
    /* sanitize_email sanitizes the value to allowed email address for passing in to a SQL query */
    $admin_email = $this->ssw_sanitize_option('sanitize_email', $_POST['admin_email']);
    $this->ssw_debug_log('step2_process', 'admin_email', $admin_email);

    /* sanitize_key performs strict sanitization on the value admin_user_id before passing in to a SQL query */
    $admin_user_id = $this->ssw_sanitize_option('sanitize_key', $_POST['admin_user_id']);
    $this->ssw_debug_log('step2_process', 'admin_user_id', $admin_user_id);

    $site_category_selected = $this->ssw_sanitize_option('sanitize_key', $_POST['site_category']);
    $this->ssw_debug_log('step2_process', 'site_category', $site_category_selected);

    $site_address = $this->ssw_sanitize_option('sanitize_url', $_POST['site_address']);
    $this->ssw_debug_log('step2_process', 'site_address', $site_address);

    /*
    Check if the site category selected is from the list of site_category_no_prefix
    and should be blank buckets 
     */
    for($i=0 ; $i<count($site_category_no_prefix); $i++) {
        $site_category_no_prefix[$i] = $this->ssw_sanitize_option('sanitize_url', $site_category_no_prefix[$i]);
    }
    if( in_array($site_category_selected, $site_category_no_prefix) != true && $site_category_selected != '' ) {
        $path = $site_category_selected.'-'.$site_address;
    }
    else {
        $path = $site_address ;
    }
    $is_banned_site = 0;
    if ( !is_super_admin() ) {
        foreach ( $site_user_category as $site_user => $site_category ) {
            foreach ( $site_category as $key => $value) {
                if( $path == $this->ssw_sanitize_option('sanitize_url', $value)) {
                    $is_banned_site = 1;
                }
            }
        }
    }

    /* Add wordpress path for storing in db */
    $path = $current_site->path.$path;
    

    /* sanitize_text_field sanitizes the value to make it safe for passing in to a SQL query */
    $title = $this->ssw_sanitize_option('sanitize_text_field', $_POST['site_title']);
    $this->ssw_debug_log('step2_process', 'title', $title);
    
    /* sanitize_key sanitizes the value to all right content required for the path for security */
    /* 
    Multisite Privacy Plugin uses value -1, -2 and -3 hence we add 3 
    and then subtract 3 after sending it to sanitize values
     */
    if( isset($_POST['site_privacy'] ) ) {
        $privacy = $this->ssw_sanitize_option('sanitize_key', $_POST['site_privacy']) - 3;
    }
    else {
        $privacy = '';
    }
    $next_stage = $this->ssw_sanitize_option('sanitize_key', $_POST['ssw_next_stage']);
    $this->ssw_debug_log('step2_process', 'next_stage', $next_stage);
    $endtime = current_time('mysql');

    /* Throw Error if site address is illegal */
    if( $is_banned_site == 1) {
        $result = new WP_Error( 'broke', __("This site address is not allowed. Please enter another one.", "Site Setup Wizard") );
    }
    else {
        $result = $wpdb->update(
            $ssw_main_table,
            array(
                'admin_email' => $admin_email,
                'admin_user_id' => $admin_user_id,
                'path' => $path,
                'title' => $title,
                'privacy' => $privacy,
                'next_stage' => $next_stage,
                'endtime' => $endtime
            ),
            array(
                'user_id' => $current_user_id,
                'site_created' => false,
                'wizard_completed' => false
            )
        );

        $this->ssw_log_sql_error($wpdb->last_error);
    }

    if ( is_wp_error( $result ) ) {
       $error_string = $result->get_error_message();
       echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
   }    
}
?>