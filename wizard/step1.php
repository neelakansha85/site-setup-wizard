<?php

$step1 = 'start';

?>
<div class="ssw-container">
    <div class="ssw-content">
       <div class="ssw-header-wrapper">
        <h3>Select a category that best fits your use</h3>
        <?php
            include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
        ?>
    </div>
    <fieldset class="ssw-fieldset">
        <?php
            /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
            wp_nonce_field('step1_action','step1_nonce');
        ?>
        <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step1"/>
        <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step1"/>
        <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step2"/>
        <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>

        <div class="ssw-selection">
            <?php
            if ( $is_master_user != true ) {
                foreach ( $site_type as $site_type_user => $site_type_user_details ) {
                    if ( $is_user_role_restriction != true ) {
                        foreach ( $site_type_user_details as $site_type_user_details_key => $site_type_user_details_value ) {
                            if($site_type_user_details_value!='') {
                                ?>
                                <input name="ssw_start_<?php _e($site_type_user_details_key); ?>" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step('<?php _e($site_type_user_details_value); ?>')" value="<?php _e($site_type_user_details_value); ?>" />
                                <?php
                            }
                        }
                    }
                    else {
                        foreach ( $user_role_mapping as $restricted_role_in_ssw => $restricted_role_in_wp ) {
                            if ( $current_user_role == $restricted_role_in_wp && $restricted_role_in_ssw == $site_type_user ) { 
                                foreach ( $site_type_user_details as $site_type_user_details_key => $site_type_user_details_value ) {
                                    if($site_type_user_details_value!='') {
                                        ?>
                                        <input name="ssw_start_<?php _e($site_type_user_details_key); ?>" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step('<?php _e($site_type_user_details_value); ?>')" value="<?php _e($site_type_user_details_value); ?>" />
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else {
                foreach ( $site_type as $site_type_user => $site_type_user_details ) {
                    foreach( $site_type_user_details as $site_type_user_details_key => $site_type_user_details_value ) {
                        if($site_type_user_details_value!='') {
                            ?>
                            <input name="ssw_start_<?php _e($site_type_user_details_key); ?>" class="ssw-start-btn" type="button" onclick="ssw_js_submit_first_step('<?php _e($site_type_user_details_value); ?>')" value="<?php _e($site_type_user_details_value); ?>" />
                            <?php
                        }
                    }
                }
            }
            ?>
        </div>                            
    </fieldset>
</div>
</div>