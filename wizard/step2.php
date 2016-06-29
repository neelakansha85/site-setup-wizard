<?php

$step2 = 'essential_options';

?>
<div class="ssw-container">
    <div class="ssw-content">
        <?php
        include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
        ?>
        <div class="ssw-header-wrapper">
            <h3><?php _e($steps_name['step2']); ?></h3>
            <?php
            include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
            ?>
        </div>
        <fieldset class="ssw-fieldset">
            <?php
            /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
            wp_nonce_field('step2_action','step2_nonce');
            ?>
            <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step1"/>
            <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step2"/>
            <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step3"/>
            <input id="is-privacy-selection" name="is_privacy_selection" type="hidden" value="<?php _e((int)$is_privacy_selection); ?>"/>
            <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>

            <input id="ssw-current-site-root-address" name="current_site_root_address" type="hidden" value="<?php _e($current_site_root_address) ?>"/>

            <div class="ssw-field">
                <label for="ssw-admin-email" class="ssw-label ssw-required" title="Admin Email">Admin Email</label>
                <input id="ssw-admin-email" class="ssw-subfield ssw-input" name="admin_email" type="text" value="<?php _e($current_user_email); ?>" tabindex="1" onblur="ssw_js_validate_email()"/>
            </div> 
            <div class="ssw-error ssw-field" id="ssw-validate-email-error" name="ssw_validate_email_error">
                <label class="ssw-validate-email-error-field-spacing ssw-label">&nbsp;</label>
                <span id="ssw-validate-email-error-label" class="ssw-span">Please enter valid email address.</span>
            </div>
            <div class="ssw-field" id="ssw-site-address-display-field">
                <label class="ssw-site-address-display-field-spacing ssw-label" id="ssw-site-address-display-field-spacing" >Your URL</label>
                <span id="ssw-site-address-display"><?php _e($current_site_root_address); ?>&lt;Site Category&gt;-&lt;Site Address&gt;</span>
            </div>                 
            <div class="ssw-field">
                <label for="ssw-site-category" class="ssw-site-address ssw-required ssw-label" title="Site Category">Site Category</label>
                <select id="ssw-site-category" class="ssw-subfield ssw-select" name="site_category" tabindex="2" onchange="ssw_js_site_address_display()" required >
                    <?php
                    foreach ( $site_user_category as $site_user => $site_category ) {
                        if ( $is_master_user != true ) {        
                            if ( $is_user_role_restriction != true ) {
                                foreach ( $site_category as $key => $value) {
                                    $key = $this->ssw_sanitize_option('sanitize_url', $value);

                                    if($key!='') {
                                        echo '
                                        <option value="'.$key.'">'.$value.'</option>
                                        ';
                                    }
                                }
                            }
                            else {
                                foreach ( $user_role_mapping as $restricted_role_in_ssw => $restricted_role_in_wp ) {
                                    if ( $current_user_role == $restricted_role_in_wp && $restricted_role_in_ssw == $site_user ) { 
                                        foreach ( $site_category as $key => $value) {
                                            $key = $this->ssw_sanitize_option('sanitize_url', $value);
                                            if($key!='') {
                                                echo '
                                                <option value="'.$key.'">'.$value.'</option>
                                                ';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            foreach ( $site_category as $key => $value) {
                                $key = $this->ssw_sanitize_option('sanitize_url', $value);
                                if($key!='') {
                                    echo '
                                    <option value="'.$key.'">'.$value.'</option>
                                    ';
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="ssw-field">
                <label for="ssw-site-address" class="ssw-label" title="Site Address">Site Address</label>
                <input id="ssw-site-address" class="ssw-subfield ssw-input" name="site_address" type="text" tabindex="3" oninput="ssw_js_validate_site_address(); ssw_js_site_address_display()" onblur="ssw_js_validate_site_address()"/>
            </div>
            <div class="ssw-error ssw-field" id="ssw-site-address-error" name="ssw_site_address_error">
                <label class="ssw-site-address-error-field-spacing ssw-label">&nbsp;</label>
                <span id="ssw-site-address-error-label" class="ssw-span"></span>
            </div>
            <div class="ssw-field">
                <label for="ssw-site-title" class="ssw-label" title="Site Title">Site Title</label>
                <input id="ssw-site-title" class="ssw-subfield ssw-input" name="site_title" type="text" tabindex="4" oninput="ssw_js_validate_title()" onblur="ssw_js_validate_title()"/>
            </div>
            <div class="ssw-error ssw-field" id="ssw-site-title-error" name="ssw_site_title_error">
                <label class="ssw-site-title-error-field-spacing ssw-label">&nbsp;</label>
                <span id="ssw-site-title-error-label" class="ssw-span" ></span>
            </div>
            <div class="ssw-field ssw-radio-field">
                <label for="ssw-site-privacy" class="ssw-site-privacy-class ssw-required ssw-label">Site Access</label>
            <?php
            /* Check if Site Privacy options have to be displayed or not
            */
            if ($is_privacy_selection == true) {
            ?>
                <span class="ssw-radio-text strong">Public</span>
                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="4" tabindex="5" onclick="ssw_js_validate_privacy()">Allow search engines to index this site</span>
                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="3" tabindex="6" onclick="ssw_js_validate_privacy()">Not indexed in search engines but still available for public to view</span>
                <?php
                /** 
                * Check from the SSW Options if WPMU Multisite Privacy 
                * plugin is installed or not and if yes then
                * display following privacy options
                */
                /** 
                * The values -3 to 1 are defined and being used by 
                * Multisite Privacy Plugin. Due to sanitization we add 
                * 3 to values and subtract 3 on receiving it. 
                * SSW Plugin simply stores and puts this value in 
                * "blog_public" option in wp_options table for that 
                * particular site 
                * Triple equal can not be used here since this value 
                * is coming from database 
                */

                if ($wpmu_multisite_privacy_plugin == true) {
                ?>
                    <label style="height:auto;" class="ssw-label">&nbsp;</label>
                    <span class="ssw-radio-text strong">Private</span>
                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="2" tabindex="7" onclick="ssw_js_validate_privacy()"><?php _e($private_network_users_txt); ?></span>
                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="1" tabindex="8" onclick="ssw_js_validate_privacy()"><?php _e($private_site_users_txt); ?></span>
                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="0" tabindex="9" onclick="ssw_js_validate_privacy()"><?php _e($private_administrator_txt); ?></span>
                <?php
                }
            }
            else {
                ?>
                <span class="ssw-privacy-text">
                    <?php _e($privacy_selection_txt); ?>
                </span>
                <?php
            }
            ?>
            </div>
            <div class="ssw-error ssw-field" id="ssw-site-privacy-error" name="ssw_site_privacy_error">
                <label class="ssw-site-privacy-error-field-spacing ssw-label">&nbsp;</label>
                <span id="ssw-site-privacy-error-label" class="ssw-span"></span>
            </div>
            <div class="ssw-field">
                <label class="ssw-site-terms-error-field-spacing ssw-label">&nbsp;</label>
                <input id="ssw-site-terms-input" class="" name="site_terms" type="checkbox" tabindex="10" onchange="ssw_js_validate_terms()"/><?php _e($terms_of_use); ?> 
            </div>
            <div class="ssw-error ssw-field" id="ssw-site-terms-error" name="ssw_site_terms_error">
                <label class="ssw-site-title-error-field-spacing ssw-label">&nbsp;</label>
                <span id="ssw-site-terms-error-label" class="ssw-span"></span>
            </div>
            <div class="ssw-processing ssw-field" id="ssw-site-processing" name="ssw_site_processing">
                <span id="ssw-site-processing-label" ></span>
            </div>

            <div class="ssw-proceed ssw-field">
                <input name="ssw_back_btn" class="ssw-primary-btn ssw-back-btn" type="button" onclick="ssw_js_submit_form_previous()" value="Back" tabindex="11" />
                <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Next" onclick="ssw_js_submit_form_next()" tabindex="12" />
            </div> 
        </fieldset>
    </div>
</div>