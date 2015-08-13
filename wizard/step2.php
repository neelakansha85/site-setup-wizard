<?php

$skip = true;
$step2 = 'essential_options';

    echo '
        <div class="ssw-container">
            <div class="ssw-content">
    ';
                include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
    echo '
                <div class="ssw-header-wrapper">
                    <h3>Essential Settings (Step 2)</h3>
    ';
                    include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
    echo '
                    </div>
                <fieldset class="ssw-fieldset">

    ';

                    /* Debug Code */
                    if( $is_debug_mode == true ) {
                        echo '<br/>Debug Mode is ON';
                        echo '<br/>Current Site Root Address = '.$current_site_root_address;
                        echo '<br/>Current User Role = '.$current_user_role;
                        echo '<br/>Restricted User Roles = ';
                            print_r($restricted_user_roles);
                        echo '<br/><br/>';

                    }

                    /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
				    wp_nonce_field('step2_action','step2_nonce');
    echo '
                    <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step1"/>
                    <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step2"/>
                    <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step4"/>
                    <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>

                    <input id="ssw-current-site-root-address" name="current_site_root_address" type="hidden" value="'.$current_site_root_address.'"/>
                            
                        <div class="ssw-field">
                            <label for="ssw-admin-email" class="ssw-label ssw-required" title="Admin Email">Admin Email</label>
                            <input id="ssw-admin-email" class="ssw-subfield ssw-input" name="admin_email" type="text" value="'.$current_user_email.'" tabindex="1" onblur="ssw_js_validate_email()"/>
                        </div> 
                        <div class="ssw-error ssw-field" id="ssw-validate-email-error" name="ssw_validate_email_error">
                            <label class="ssw-validate-email-error-field-spacing ssw-label">&nbsp;</label>
                            <span id="ssw-validate-email-error-label" class="ssw-span">Please enter valid email address.</span>
                        </div>
                        <div class="ssw-field" id="ssw-site-address-display-field">
                            <label class="ssw-site-address-display-field-spacing ssw-label" id="ssw-site-address-display-field-spacing" >Your URL</label>
                            <span id="ssw-site-address-display">'.$current_site_root_address.'&lt;Site Category&gt;-&lt;Site Address&gt;</span>
                        </div>                 
                        <div class="ssw-field">
                            <label for="ssw-site-address-bucket" class="ssw-site-address ssw-required ssw-label" title="Site Category">Site Category</label>
                            <select id="ssw-site-address-bucket" class="ssw-subfield ssw-select" name="site_address_bucket" tabindex="2" onchange="ssw_js_site_address_display()" required >
    ';
                            foreach ( $site_address_bucket as $site_address_bucket_user => $site_address_bucket_user_value ) {
                                if ( $master_user == true ) {        
                                    foreach ( $site_address_bucket_user_value as $key => $value) {
                                        echo '
                                            <option value="'.$key.'">'.$value.'</option>
                                        ';
                                    }
                                }
                                else {
                                    foreach ( $restricted_user_roles as $restricted_role => $restricted_role_in_wp ) {
                                        if ( $current_user_role == $restricted_role_in_wp && $restricted_role == $site_address_bucket_user ) { 
                                            foreach ( $site_address_bucket_user_value as $key => $value) {
                                                echo '
                                                    <option value="'.$key.'">'.$value.'</option>
                                                ';
                                            }
                                        }
                                    }
                                }
                            }

    echo '
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
    ';
    echo '
                        <div class="ssw-field ssw-radio-field">
                            <label for="ssw-site-privacy" class="ssw-site-privacy-class ssw-required ssw-label">Site Access</label>
    ';
                            /* Check if Site Privacy options have to be displayed or not
                            */
                            if ($is_site_privacy == true) {
    echo '
                                <span class="ssw-radio-text strong">Public</span>
                                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="4" tabindex="5" onclick="ssw_js_validate_privacy()">Allow search engines to index this site</span>
                                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="3" tabindex="6" onclick="ssw_js_validate_privacy()">Not indexed in search engines but still available for public to view</span>
    ';
                                /*  Check from the SSW Options if WPMU Multisite Privacy plugin is installed or not and if yes then
                                    display following privacy options
                                */
                                /*  The values -3 to 1 are defined and being used by Multisite Privacy Plugin. Due to sanitization we add 3 to values and subtract 3
                                    on receiving it. SSW Plugin simply stores and puts this value in "blog_public" option in wp_options table for that particular site 
                                */
                                /* Triple equal can not be used here since this value is coming from database */

                                if ($wpmu_multisite_privacy_plugin == true) {
    echo '
                                    <label style="height:auto;" class="ssw-label">&nbsp;</label>
                                    <span class="ssw-radio-text strong">Private</span>
                                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="2" tabindex="7" onclick="ssw_js_validate_privacy()">Visible to all of NYU</span>
                                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="1" tabindex="8" onclick="ssw_js_validate_privacy()">Limited to only users who you specify in the "Users" settings (by adding their netid@nyu.edu and assigning them a role)</span>
                                    <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                    <span class="ssw-radio-text"><input type="radio" class="ssw-input" name="site_privacy" value="0" tabindex="9" onclick="ssw_js_validate_privacy()">Limited to only site administrators who you specify in the "Users" settings (good for preparing a site before making it visible to a larger audience)</span>
    ';
                                }
                            }
                            else {
    echo '
                                <span class="ssw-privacy-text strong">Please note that by default, your site privacy settings are set to "Public on the Web, but are not indexed by search engines".</span>
                                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                <span class="ssw-privacy-text">Once your site is created, please update your site privacy settings, by going to Settings (in the left menu) > Reading > Site visibility.</span>
                                <label class="ssw-radio-field-spacing ssw-label">&nbsp;</label>
                                <span class="ssw-privacy-text strong">More information can be found <a href="http://www.nyu.edu/servicelink/KB0012245" target="_blank" >here</a>.</span>
    ';
                            }                            
    echo '
                        </div>
                        <div class="ssw-error ssw-field" id="ssw-site-privacy-error" name="ssw_site_privacy_error">
                            <label class="ssw-site-privacy-error-field-spacing ssw-label">&nbsp;</label>
                            <span id="ssw-site-privacy-error-label" class="ssw-span"></span>
                        </div>
                        <div class="ssw-field">
                            <label class="ssw-site-terms-error-field-spacing ssw-label">&nbsp;</label>
                            <input id="ssw-site-terms-input" class="" name="site_terms" type="checkbox" tabindex="10" onchange="ssw_js_validate_terms()"/>'.$terms_of_use.' 
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
                            <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Create" onclick="ssw_js_submit_form_next()" tabindex="12" />
                        </div> 
                    </fieldset>
            </div>
        </div>
    ';

?>