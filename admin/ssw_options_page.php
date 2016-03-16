<?php

    /* Include the Javascripts for the ssw plugin while trying to create a site */
    wp_enqueue_script( 'ssw-options-js' );
    
    global $current_blog;
    global $current_site;
    
    /* Identifing current domain and path on domain where wordpress is running from */
    $current_site_root_address = $current_blog->domain.$current_site->path;

    $options = $this->ssw_fetch_config_options();
        $site_address_bucket = $options['site_address_bucket'];
        $site_address_bucket_none_value = $options['site_address_bucket_none_value'];
        $banned_site_address = $options['banned_site_address'];
        $template_type = $options['template_type'];
        $select_template = $options['select_template'];
        $hide_plugin_category = $options['hide_plugin_category'];
        $external_plugins = $options['external_plugins'];
        $restricted_user_roles = $options['restricted_user_roles'];
        $site_usage = $options['site_usage'];
        $is_site_usage_display_common = $options['site_usage_display_common'];
        $ssw_not_available = $options['ssw_not_available'];
        $terms_of_use = $options['terms_of_use'];
        $steps_name = isset($options['steps_name']) ? $options['steps_name'] : '';
        $is_privacy_selection = isset($options['privacy_selection']) ? $options['privacy_selection'] : false;
        $is_debug_mode = isset($options['debug_mode']) ? $options['debug_mode'] : false;
        $is_master_user = isset($options['master_user']) ? $options['master_user'] : false;

    /* Pass value of $options to ssw-options.js */
    wp_localize_script( 'ssw-options-js', 'options', $options );

/*
echo "<br/>Debug :";
    echo $is_debug_mode;
echo "<br/>Privacy mode:";
    echo $is_privacy_selection;
echo "<br/>";
echo "<br/>options :";
    print_r($options);
echo "<br/>";
*/

?>


<div class="wrap">
    <h1><?php echo esc_html('Site Setup Wizard Settings') ?></h1>
    <form method="post" action="settings.php" novalidate="novalidate">
        <h3><?php echo esc_html('Basic Settings') ?></h3>
        <table class="form-table">
            <tbody><tr>
                <th scope="row"><label for="ssw-user-role"><?php echo esc_html('User Role') ?></label></th>
                <td>
                    <select id="ssw-user-role" class="regular-text" onchange="ssw_user_role()">
                      <option value="select"><?php echo esc_html('--Select--') ?></option>
                      <?php                         
/*                        foreach($site_address_bucket as $site_address_bucket_user => $site_address_bucket_user_value){ 
                      ?> 
                            <option value="<?php echo $site_address_bucket_user?>"><?php echo $site_address_bucket_user?></option>
                      <?php
                        }
*/                      ?>
                      <option value="add_new"><?php echo esc_html('--Add New--') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-usage"><?php echo esc_html('Site Usage') ?></label></th>
                <td>
                    <select id="ssw-site-usage" class="regular-text">
                      <option value="select"><?php echo esc_html('--Select--') ?></option>
                      <?php                         
                        foreach($site_usage as $site_usage_user => $site_usage_user_value){ 
                            /*
                            ** TODO: Add ajax rule to check the selected user in the above select box and pass that value here 
                            */
                            $selected_site_usage_user = 'employee';
                            if($site_usage_user == $selected_site_usage_user){
                                foreach ( $site_usage_user_value as $key => $value){                            
                      ?> 
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                      <?php
                                }
                            }
                        }
                      ?>
                      <option value="add_new"><?php echo esc_html('--Add New--') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category"><?php echo esc_html('Site Category') ?></label></th>
                <td>
                    <select id="ssw-site-category" class="regular-text" aria-describedby="ssw-site-category-desc" onchange="ssw_site_category()">
                      <option value="select"><?php echo esc_html('--Select--') ?></option>
                      <?php                         
                        foreach($site_address_bucket as $site_address_bucket_user => $site_address_bucket_user_value){ 
                            /*
                            ** TODO: Add ajax rule to check the selected user in the above select box and pass that value here 
                            */
                            $selected_site_address_bucket_user = 'employee';
                            if($site_address_bucket_user == $selected_site_address_bucket_user){
                                foreach ( $site_address_bucket_user_value as $key => $value){                            
                      ?> 
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                      <?php
                                }
                            }
                        }
                      ?>
                      <option value="add_new"><?php echo esc_html('--Add New--') ?></option>
                    </select>
                    <p class="description" id="ssw-site-category-desc">
                        <?php _e( 'These categories will be used as prefixes to the site address (URL). The site url will be '.$current_site_root_address.'&lt;Site Category&gt;-&lt;Site Address&gt;'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category-none-prefix"><?php echo esc_html('Site Category with no Prefix') ?></label></th>
                <td>
                    <input name="ssw-site-category-none-prefix" type="text" id="ssw-site-category-none-prefix" aria-describedby="ssw-site-category-none-prefix-desc" class="large-text" value="<?php echo esc_attr( $site_address_bucket_none_value == '' ? '' : implode( " ", $site_address_bucket_none_value ) ) ?>" size="45" />
                    <p class="description" id="ssw-site-category-none-prefix-desc">
                        <?php _e( 'These categories will not have any prefixes in the site address i.e. blank &lt;Site Category&gt;. Separate names by spaces.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-type"><?php echo esc_html('Site Type') ?></label></th>
                <td>
                    <select id="ssw-site-type" class="regular-text" onchange="ssw_site_type()">
                      <option value="select"><?php echo esc_html('--Select--') ?></option>
                      <option value="add_new"><?php echo esc_html('--Add New--') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-select-template"><?php echo esc_html('Select Template') ?></label></th>
                <td>
                    <select id="ssw-select-template" class="regular-text" onchange="ssw_select_template()">
                      <option value="select"><?php echo esc_html('--Select--') ?></option>
                      <option value="add_new"><?php echo esc_html('--Add New--') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-banned-site-address"><?php echo esc_html('Banned Site Address') ?></label></th>
                <td>
                    <input name="ssw-banned-site-address" type="text" id="ssw-banned-site-address" aria-describedby="ssw-banned-site-address-desc" class="large-text" value="<?php echo esc_attr( $banned_site_address == '' ? '' : implode( " ", $banned_site_address ) ) ?>" size="45" />
                    <p class="description" id="ssw-banned-site-address-desc">
                        <?php _e( 'Users are not allowed to register these sites. Separate names by spaces.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-terms-of-use"><?php echo esc_html('Terms of Use') ?> </label></th>
                <td>
                    <textarea name="ssw-terms-of-use" id="ssw-terms-of-use" aria-describedby="ssw-terms-of-use-desc" cols="45" rows="5"><?php echo $options['terms_of_use'] ?></textarea>
                    <p class="description" id="ssw-terms-of-use-desc">
                        <?php _e('Please enter the text you want to display next to Terms of Use checkbox.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html('Privacy Selection') ?> </th>
                <td>
                    <label><input name="ssw-privacy-selection" type="checkbox" id="ssw-privacy-selection" value="true" <?php if ($is_privacy_selection == true) echo "checked"; ?> ><?php echo esc_html('Display privacy selection options on Step 2') ?> </label>
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Wizard Step Titles') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="ssw-step-1"><?php echo esc_html('Step 1') ?> </label></th>
                <td>
                    <input name="ssw-step-1" type="text" id="ssw-step-1" class="regular-text" value="<?php echo esc_attr($steps_name['step1']) ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-step-2"><?php echo esc_html('Step 2') ?> </label></th>
                <td>
                    <input name="ssw-step-2" type="text" id="ssw-step-2" class="regular-text" value="<?php echo esc_attr($steps_name['step2']) ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-step-3"><?php echo esc_html('Step 3') ?> </label></th>
                <td>
                    <input name="ssw-step-3" type="text" id="ssw-step-3" class="regular-text" value="<?php echo esc_attr($steps_name['step3']) ?>">
                </td>
            </tr>
            
            <tr>
                <th scope="row"><label for="ssw-step-4"><?php echo esc_html('Step 4') ?> </label></th>
                <td>
                    <input name="ssw-step-4" type="text" id="ssw-step-4" class="regular-text" value="<?php echo esc_attr($steps_name['step4']) ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-finish"><?php echo esc_html('Finish') ?> </label></th>
                <td>
                    <input name="ssw-finish" type="text" id="ssw-finish" class="regular-text" value="<?php echo esc_attr($steps_name['finish']) ?>">
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Network Activated External Plugins') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php echo esc_html('External Plugins') ?> </th>
                <td>
                    <label><input name="wpmu-multisite-privacy-plugin" type="checkbox" id="wpmu-multisite-privacy-plugin" value="true" <?php if ($external_plugins['wpmu_multisite_privacy_plugin'] == true) echo "checked"; ?> ><?php echo esc_html('WPMU Multisite Privacy Plugin') ?> </label>
                    <br/>
                    <label><input name="wpmu-pretty-plugin" type="checkbox" id="wpmu-pretty-plugin" value="true" <?php if ($external_plugins['wpmu_pretty_plugins'] == true) echo "checked"; ?> ><?php echo esc_html('WPMU Pretty Plugin') ?> </label>
                    <br/>
                    <label><input name="wpmu-multisite-theme-manager-plugin" type="checkbox" id="wpmu-multisite-theme-manager-plugin" value="true" <?php if ($external_plugins['wpmu_multisite_theme_manager'] == true) echo "checked"; ?> ><?php echo esc_html('WPMU Multisite Theme Manager Plugin') ?> </label>
                    <br/>
                    <label><input name="wpmu-new-blog-template-plugin" type="checkbox" id="wpmu-multisite-new-blog-template-plugin" value="true" <?php if ($external_plugins['wpmu_new_blog_template'] == true) echo "checked"; ?> ><?php echo esc_html('WPMU New Blog Template Plugin') ?> </label>
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Debug Settings') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php echo esc_html('Debug Mode') ?> </th>
                <td>
                    <fieldset>
                        <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-enable" value="enable" <?php if ($is_debug_mode == true) echo "checked"; ?> /><?php echo esc_html(' Enable') ?> </label>
                        <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-disable" value="disable" <?php if ($is_debug_mode != true) echo "checked"; ?> /><?php echo esc_html(' Disable') ?> </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html('Activate Master User') ?> </th>
                <td>
                    <label><input name="ssw-debug-master-user" type="checkbox" id="ssw-debug-master-user" value="true" <?php if ($is_master_user == true) echo "checked"; ?> ><?php echo esc_html('Please select this if you would like to display all options in the Wizard without discriminating based on User Role') ?> 
                    </label>
                </td>
            </tr>
        </tbody></table>
        <p class="submit">
            <?php wp_nonce_field('submit_ssw_settings'); ?>
            <input type="submit" name="submit" id="submit" class="ssw-options-submit button-primary" value="Save Changes">
        </p>
    </form>
</div>
