<?php

$create_new_site = 'create_new_site';

/* Fetch basic data from the SSW Plugins's Main Table for current user to create a new site for him */
$results = $wpdb->get_results( 
    'SELECT admin_user_id, path, title, privacy FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.' and site_created = false' 
    );
if ( is_wp_error( $results ) ) {
    $error_string = $results->get_error_message();
    echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
}
foreach( $results as $obj ) {
    $admin_user_id = $obj->admin_user_id;
    $path = $obj->path;
    $title = $obj->title;
    $privacy = $obj->privacy;
}

/* Check if there is there is any valid data for the site to be created */
if( $path != '' ) {
    /* This check is to avoid creating new site if it is sub domain multisite installation 
    since it is not supported currently with the path variable */
    if( !is_subdomain_install() ) {
        $new_blog_id = wpmu_create_blog( $current_blog->domain, $path, $title, $admin_user_id );
        if( !is_wp_error( $new_blog_id ) && $is_privacy_selection == true ) {
            /* Set Privacy of the newly created blog to the privacy level selected durign the wizard */
            update_blog_option($new_blog_id, 'blog_public', $privacy);
        }
        $endtime = current_time('mysql');
        /* Update current site's details with the blog_id of the newly created blog in SSW_MAIN_TABLE */
        $result = $wpdb->query(
            'UPDATE '.$ssw_main_table.' SET site_created = true, blog_id = '.$new_blog_id.', endtime = \''.$endtime.'\' 
            WHERE user_id = '.$current_user_id.' and site_created = false and wizard_completed = false'
            );
        if ( is_wp_error( $result ) ) {
            $error_string = $result->get_error_message();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }
    else {
        echo '<p>This plugin supports only sub directory wordpress install. Please change your installation to sub directory installation.</p>';
    }
}
else {
    echo '<p>You don\'t seem to have the correct information filled for creating a site. Please create a site again!</p>';
}

?>
