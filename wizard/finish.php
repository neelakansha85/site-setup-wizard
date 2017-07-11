<?php

$finish = 'finish';

?>
<div class="ssw-container">
    <div class="ssw-content">
        <div class="ssw-header-wrapper">
           <h3><?php _e($steps_name['finish']); ?></h3>
           <?php
           include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
           ?>
           <p class="ssw-header-note"><?php _e($finish_page_txt); ?></p>
        </div>
        <fieldset class="ssw-fieldset">        
        <?php
        wp_nonce_field('finish_action','finish_nonce');
        ?>
        <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step4"/>
        <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_finish"/>
        <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step1"/>
        <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
        <?php
        $results = $wpdb->get_results( 
            'SELECT blog_id, theme, plugins_list, admin_email, admin_user_id, path, title, site_type FROM '.$ssw_main_table.' WHERE user_id = '.$current_user_id.'
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
            $site_type = $obj->site_type;
        }

        // Get admin's user role on main site
        switch_to_blog(1);
        $admin_info = get_userdata($admin_user_id);
        restore_current_blog();

        // Check if there is there is any valid data for the site to be updated */
        if($new_blog_id != '') {
             
            // This check is to avoid creating new site if it is sub domain multisite 
            // installation since it is not supported currently with the path variable
            if( !is_subdomain_install() ) {
                // Activate all plugins selected during the wizard for new site
                switch_to_blog($new_blog_id);
                if($plugins_list != '') {
                    foreach ($plugins_list as $key => $value){
                        $plugin_acivation = activate_plugin($value);
                        if( is_wp_error( $plugin_acivation ) ) {
                            echo '<br/>'.$value.' plugin failed to activate.';
                        }
                    }
                }
                // Apply selected theme
                $theme = wp_get_theme($theme);
                if($theme->exists()) {
                    switch_theme($theme->get_stylesheet());
                }

                // Add new option for Site Type 
                update_option(SSW_SITE_TYPE_KEY, $site_type);

                //Add new option for saving User Role
                update_option(SSW_USER_ROLE_KEY, $admin_info->roles);

                // Restore to original blog it came from before switch_to_blog()
                restore_current_blog();

                echo '<p>Your new site is now ready at <a href="'.$path.'">http://'.$current_blog->domain.$path.'</a></p>';

                $ssw_process_query = 'UPDATE '.$ssw_main_table.' SET wizard_completed = '.true.' WHERE user_id = '.$current_user_id.' and wizard_completed = false';
                $this->ssw_debug_log('step4_process', 'ssw_process_query', $ssw_process_query);
                
                // Update current site's details as wizard_completed = true from 
                // the SSW_MAIN_TABLE to allow user create another site now.
                
                $result = $wpdb->query( $ssw_process_query );
                $this->ssw_log_sql_error($wpdb->last_error);

                // Send notifications for the newly created site
                include(SSW_PLUGIN_DIR.'admin/user_notification.php');
            }
            else {
                echo '<p>This plugin supports only sub directory wordpress install. Please change your installation to sub directory installation.</p>';
            }
        }
        else {
            echo '
                <p>You don\'t seem to have any site created for adding features to it. Please create a new site first.</p>
                <p>If you think you have reached this page in error, please click 
                <a href="#" onclick="ssw_js_submit_form_cancel()" style="color:red;" value="Cancel" />Start Over</a> to begin creating sites agaisn!</p>
            ';
        }
        ?>    
        </fieldset>
    </div>
</div>