<?php

    /* Include the Javascripts for the ssw plugin while trying to create a site */
    wp_enqueue_script( 'ssw-options-js' );
    /* Include CSS for Options Page */
    wp_enqueue_style( 'ssw-style-admin-css' );
    
    global $current_blog;
    global $current_site;
    
    /* Identifing current domain and path on domain where wordpress is running from */
    $current_site_root_address = $current_blog->domain.$current_site->path;

    /* Pass value of $options to ssw-options.js */
    $options = $this->ssw_fetch_config_options();
    wp_localize_script( 'ssw-options-js', 'options', $options );

?>


<div class="wrap">
    <h1><?php echo esc_html('Site Setup Wizard Settings') ?></h1>
    <form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>" novalidate="novalidate">
        <h3><?php echo esc_html('Basic Settings') ?></h3>
        <table class="form-table">
            <tbody><tr>
                <th scope="row"><label for="ssw-user-role"><?php echo esc_html('User Role') ?></label></th>
                <td>
                    <select id="ssw-user-role" class="regular-text ssw-select" onchange="ssw_user_role()">
                    </select>
                    <div class="ssw-add-new-input">
                        <input name="add-user-role-input" type="text" id="add-user-role-input" class="ssw-add-new-text" value="">
                        <img id="add-user-role-btn" src="<?php echo plugins_url(SSW_PLUGIN_FIXED_DIR.'/images/add_new_icon.png'); ?>" class="ssw-add-new-btn" alt="Add New" onclick="ssw_add_new_value('add-user-role-input', 'ssw-user-role')">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-usage"><?php echo esc_html('Site Usage') ?></label></th>
                <td>
                    <select id="ssw-site-usage" class="regular-text ssw-select" onchange="ssw_site_usage()">
                    </select>
                    <div class="ssw-add-new-input">
                        <input name="add-site-usage-input" type="text" id="add-site-usage-input" class="ssw-add-new-text" value="">
                        <img id="add-site-usage-btn" src="<?php echo plugins_url(SSW_PLUGIN_FIXED_DIR.'/images/add_new_icon.png'); ?>" class="ssw-add-new-btn" alt="Add New" onclick="ssw_add_new_value('add-site-usage-input', 'ssw-site-usage')">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html('Site Usage Restriction') ?></th>
                <td>
                    <label><input name="ssw-usage-restriction" type="checkbox" id="ssw-usage-restriction" value="" ><?php echo esc_html('Restrict Site Usage categories on Step 1 based on user role mapping with wordpress') ?></label>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category"><?php echo esc_html('Site Category') ?></label></th>
                <td>
                    <select id="ssw-site-category" class="regular-text ssw-select" aria-describedby="ssw-site-category-desc" onchange="ssw_site_category()">
                    </select>
                    <div class="ssw-add-new-input">
                        <input name="add-site-category-input" type="text" id="add-site-category-input" class="ssw-add-new-text" value="">
                        <img id="add-site-category-btn" src="<?php echo plugins_url(SSW_PLUGIN_FIXED_DIR.'/images/add_new_icon.png'); ?>" class="ssw-add-new-btn" alt="Add New" onclick="ssw_add_new_value('add-site-category-input', 'ssw-site-category')">
                    </div>
                    <p class="description" id="ssw-site-category-desc">
                        <?php _e( 'These categories will be used as prefixes to the site address (URL). The site url will be '.$current_site_root_address.'&lt;Site Category&gt;-&lt;Site Address&gt;'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category-none-prefix"><?php echo esc_html('Site Category with no Prefix') ?></label></th>
                <td>
                    <input name="ssw-site-category-none-prefix" type="text" id="ssw-site-category-none-prefix" aria-describedby="ssw-site-category-none-prefix-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-site-category-none-prefix-desc">
                        <?php _e( 'These categories will not have any prefixes in the site address i.e. blank &lt;Site Category&gt;. Separate names by spaces.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-banned-site-address"><?php echo esc_html('Banned Site Address') ?></label></th>
                <td>
                    <input name="ssw-banned-site-address" type="text" id="ssw-banned-site-address" aria-describedby="ssw-banned-site-address-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-banned-site-address-desc">
                        <?php _e( 'Users are not allowed to register these sites. Separate names by spaces.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-terms-of-use"><?php echo esc_html('Terms of Use') ?></label></th>
                <td>
                    <textarea name="ssw-terms-of-use" id="ssw-terms-of-use" aria-describedby="ssw-terms-of-use-desc" cols="45" rows="5"></textarea>
                    <p class="description" id="ssw-terms-of-use-desc">
                        <?php _e('Please enter the text you want to display next to Terms of Use checkbox.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html('Privacy Selection') ?></th>
                <td>
                    <label><input name="ssw-privacy-selection" type="checkbox" id="ssw-privacy-selection" value="" ><?php echo esc_html('Display privacy selection options on Step 2') ?></label>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-plugins-page-note"><?php echo esc_html('Plugins Page Note') ?></label></th>
                <td>
                    <textarea name="ssw-plugins-page-note" id="ssw-plugins-page-note" aria-describedby="ssw-plugins-page-note-desc" cols="45" rows="5"></textarea>
                    <p class="description" id="ssw-plugins-page-note-desc">
                        <?php _e('Please enter the text you want to display on Plugins Selection (Step 4) page.'); ?>
                    </p>
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Wizard Step Titles') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="ssw-step-1"><?php echo esc_html('Step 1') ?></label></th>
                <td>
                    <input name="ssw-step-1" type="text" id="ssw-step-1" class="regular-text" value="">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-step-2"><?php echo esc_html('Step 2') ?></label></th>
                <td>
                    <input name="ssw-step-2" type="text" id="ssw-step-2" class="regular-text" value="">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-step-3"><?php echo esc_html('Step 3') ?></label></th>
                <td>
                    <input name="ssw-step-3" type="text" id="ssw-step-3" class="regular-text" value="">
                </td>
            </tr>
            
            <tr>
                <th scope="row"><label for="ssw-step-4"><?php echo esc_html('Step 4') ?></label></th>
                <td>
                    <input name="ssw-step-4" type="text" id="ssw-step-4" class="regular-text" value="">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-finish"><?php echo esc_html('Finish') ?></label></th>
                <td>
                    <input name="ssw-finish" type="text" id="ssw-step-finish" class="regular-text" value="">
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Network Activated External Plugins') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php echo esc_html('External Plugins') ?></th>
                <td>
                    <label><input name="wpmu-multisite-privacy-plugin" type="checkbox" id="wpmu-multisite-privacy-plugin" value="" ><?php echo esc_html('WPMU Multisite Privacy Plugin') ?></label>
                    <br/>
                    <label><input name="wpmu-pretty-plugin" type="checkbox" id="wpmu-pretty-plugin" value="" ><?php echo esc_html('WPMU Pretty Plugin') ?></label>
                    <br/>
                    <label><input name="wpmu-multisite-theme-manager-plugin" type="checkbox" id="wpmu-multisite-theme-manager-plugin" value="" ><?php echo esc_html('WPMU Multisite Theme Manager Plugin') ?></label>
                    <br/>
                    <label><input name="wpmu-new-blog-template-plugin" type="checkbox" id="wpmu-new-blog-template-plugin" value="" ><?php echo esc_html('WPMU New Blog Template Plugin') ?></label>
                </td>
            </tr>
        </tbody></table>
        <h3><?php echo esc_html('Debug Settings') ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php echo esc_html('Debug Mode') ?></th>
                <td>
                    <fieldset>
                        <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-enable" value="enable" /><?php echo esc_html('Enable') ?></label>
                        <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-disable" value="disable" /><?php echo esc_html('Disable') ?></label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html('Activate Master User') ?></th>
                <td>
                    <label><input name="ssw-debug-master-user" type="checkbox" id="ssw-debug-master-user" value=""><?php echo esc_html('Please select this if you would like to display all options in the Wizard without discriminating based on User Role') ?> 
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
