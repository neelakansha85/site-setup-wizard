<?php

$finish = 'finish';

    echo '
        <div class="ssw-container">
            <div class="ssw-content">
                <div class="ssw-header-wrapper">
                     <h3>Done!</h3>
    ';
                    include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
    echo '
                    </div>
                <fieldset class="ssw-fieldset">
    ';

    /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
                    wp_nonce_field('finish_action','finish_nonce');
    echo '
                    <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step4"/>
                    <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_finish"/>
                    <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step1"/>
                    <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
    ';


    /* Fetch all data from the SSW Plugins's Main Table for current user to start creating site for him */
    $results = $wpdb->get_results( 
        'SELECT blog_id, theme, plugins_list, admin_email, admin_user_id, path, title FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.'
         and site_created = true and wizard_completed = false'
    );
    foreach( $results as $obj ) {
        $new_blog_id = $obj->blog_id;
        $theme = $obj->theme;
        $plugins_list = unserialize($obj->plugins_list);
        $admin_email = $obj->admin_email;
        $admin_user_id = $obj->admin_user_id;
        $path = $obj->path;
        $title = $obj->title;
    }

    /* Check if there is there is any valid data for the site to be updated */
    if($new_blog_id != '') {
        /* This check is to avoid creating new site if it is sub domain multisite installation 
        since it is not supported currently with the path variable */
        if( !is_subdomain_install() ) {
            
            /* Activate all plugins selected during the wizard for new site */
            /* Switching to newly created blog to activate plugins using wordpress sandbox activation method */
            switch_to_blog($new_blog_id);
            if($plugins_list != '') {
                foreach ($plugins_list as $key => $value){
                    $plugin_acivation = activate_plugin($value);
                    if( is_wp_error( $plugin_acivation ) ) {
                        echo '<br/>'.$value.' plugin failed to activate.';
                    }
                }
            }

            echo '<p>Your new site is now ready at <a href="'.$path.'">http://'.$current_blog->domain.$path.'</a></p>';
            /* Delete current site's details from the SSW_MAIN_TABLE to allow user create another site now. */
            //        $wpdb->query( 'DELETE FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id );

            /* Update current site's details as wizard_completed = true from the SSW_MAIN_TABLE to allow user create another site now. */
            $result = $wpdb->query(
                'UPDATE '.$ssw_main_table.' SET wizard_completed = '.true.' WHERE user_id = '.$current_user_id.' and wizard_completed = false'
            );
            
            $admin_first_name = get_user_meta( $admin_user_id, 'first_name', true );
            $admin_last_name = get_user_meta( $admin_user_id, 'last_name', true );
            $blog_details = get_blog_details($new_blog_id);

            /* Send notifications for the newly created site */
            include(SSW_PLUGIN_DIR.'admin/user_notification.php');
            /* Restore to original blog it came from before you switched to new blog site to update it's features */
            restore_current_blog();
        }
        else {
            echo '<p>This plugin supports only sub directory wordpress install. Please change your installation to sub directory installation.</p>';
        }
    }
    else {
        echo '<p>You don\'t seem to have any site created for adding features to it. Please create a new site first.</p>
                <p>If you think you have reached this page in error, please click 
                <a href="#" onclick="ssw_js_submit_form_cancel()" style="color:red;" value="Cancel" />Start Over</a> to begin creating sites again!</p>

        ';
    }
    echo '
                </fieldset>
            </div>
        </div>
                
    ';

?>