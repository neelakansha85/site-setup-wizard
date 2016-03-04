<?php

$step1 = 'start';

    echo '
		<div class="ssw-container">
            <div class="ssw-content">
             <div class="ssw-header-wrapper">
                <h3>Select a category that best fits your use</h3>
    ';
                    include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
    echo '
            </div>
                <fieldset class="ssw-fieldset">
    ';
				    /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
				    wp_nonce_field('step1_action','step1_nonce');
    echo '
                    <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step1"/>
                    <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step1"/>
                    <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step2"/>
                    <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>

					<div class="ssw-selection">
    ';
                    if( $is_site_usage_display_common != true ) {
                        foreach ( $site_usage as $site_usage_user => $site_usage_user_details ) {
                            if ( $is_master_user == true ) {        
                                if ( $site_usage_user != 'common' ) {

                                    foreach ( $site_usage_user_details as $site_usage_user_details_key => $site_usage_user_details_value ) {
                                        echo '
                                            <input name="ssw_start'.$site_usage_user_details_key.'" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step(\''.$site_usage_user_details_key.'\')" value="'.$site_usage_user_details_value.'" />
                                        ';
                                    }
                                }
                            }
                            else {
                                foreach ( $restricted_user_roles as $restricted_role => $restricted_role_in_wp ) {
                                    if ( $current_user_role == $restricted_role_in_wp && $restricted_role == $site_usage_user ) { 
                                        foreach ( $site_usage_user_details as $site_usage_user_details_key => $site_usage_user_details_value ) {
                                            echo '
                                                <input name="ssw_start'.$site_usage_user_details_key.'" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step(\''.$site_usage_user_details_key.'\')" value="'.$site_usage_user_details_value.'" />
                                            ';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else {
                        foreach( $site_usage['common'] as $site_usage_user_details_key => $site_usage_user_details_value ) {
                            echo '
                                <input name="ssw_start'.$site_usage_user_details_key.'" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step(\''.$site_usage_user_details_key.'\')" value="'.$site_usage_user_details_value.'" />
                            ';
                        }
                    }
    
    echo '
                    </div>                            
                </fieldset>
            </div>
        </div>
    ';

?>
