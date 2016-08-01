<?php

$step4 = 'features';

?>
<div class="ssw-container">
    <div class="ssw-content">
        <?php
        include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
        ?>
        <div class="ssw-header-wrapper">
            <h3><?php _e($steps_name['step4']); ?></h3>
            <?php
            include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
            ?>
            <p class="ssw-header-note"><?php _e($plugins_page_txt); ?></p>
        </div>
        <fieldset class="ssw-fieldset">
        <?php
        /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
        wp_nonce_field('step4_action','step4_nonce');
        ?>
        <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step3"/>
        <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step4"/>
        <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_finish"/>
        <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
        <input id="action" name="action" type="hidden" value="ssw_submit_form_next"/>
        <?php
        if ($wpmu_pretty_plugins == true) {

            $this->ssw_debug_log('Step4', 'plugins_categories', $plugins_categories);
            $this->ssw_debug_log('Step4', 'plugins_list', $plugins_list);

            /**
            * Fetch Plugins default data for finding names if not present in Pretty Plugins data 
            */
            $plugins_default_data =  apply_filters('all_plugins', get_plugins());

            foreach ($plugins_categories as $category_system_name => $category_name) {
                if ($category_name != $hide_plugin_category) {
                ?>
                    <div class="ssw-plugins-categories-col">
                        <div class="ssw-plugins-categories-title">
                            <h4 class="ssw-h4"><?php _e($category_name); ?></h4>
                        </div>
                        <div class="ssw-plugins-list">
                            <?php
                            foreach($plugins_list as $plugin_path => $plugin_details) {
                                $this->ssw_debug_log('Step4', 'plugin_details', $plugin_details);
                                if( isset($plugin_details['Categories']) ) {
                                    foreach ($plugin_details['Categories'] as $category_count => $category_system_name_in_details) {
                                        if($category_system_name == $category_system_name_in_details) {
                                            if(isset($plugin_details['Name'])) {
                                                if( !in_array($plugin_details['Name'], $hide_plugins) ) {
                                                    echo '<input type="checkbox" id='.sanitize_html_class($plugin_details['Name']).' name="plugins_to_install_group[]" value="'.esc_attr($plugin_path).'" />'; 
                                                    echo '<label for='.sanitize_html_class($plugin_details['Name']).'>'.esc_attr($plugin_details['Name']).'</label><br/>';
                                                }
                                            }
                                            else {
                                                $plugin_details = $plugins_default_data[$plugin_path];;
                                                if(isset($plugin_details['Name'])) {
                                                    if( !in_array($plugin_details['Name'], $hide_plugins) ) {
                                                        echo '<input type="checkbox" id='.sanitize_html_class($plugin_details['Name']).' name="plugins_to_install_group[]" value="'.esc_attr($plugin_path).'" />'; 
                                                        echo '<label for='.sanitize_html_class($plugin_details['Name']).'>'.esc_attr($plugin_details['Name']).'</label><br/>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
            }
        }
        else {
            foreach ($plugins_list as $plugin_path => $plugin_details){
                if(isset($plugin_details['Name'])) {
                    if( !in_array($plugin_details['Name'], $hide_plugins) ) {
                        echo '
                        <div class="ssw-plugins-categories-col">
                            <input type="checkbox" id='.sanitize_html_class($plugin_details['Name']).' name="plugins_to_install_group[]" value="'.esc_attr($plugin_path).'" /> <label for='.sanitize_html_class($plugin_details['Name']).'>'.esc_attr($plugin_details['Name']).'</label>
                        </div>';
                    }
                }
            }
        }
        ?>    
            
            <div class="ssw-processing ssw-field" id="ssw-site-processing" name="ssw_site_processing">
                <span id="ssw-site-processing-label" ></span>
            </div>
            <div class="ssw-proceed ssw-field">
                <input name="ssw_back_btn" class="ssw-primary-btn ssw-back-btn" type="button" onclick="ssw_js_submit_form_previous()" value="Back" tabindex="10" />
                <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Finish" onclick="ssw_js_submit_form_next()" tabindex="11" />
            </div> 
        </fieldset>
    </div>
</div>