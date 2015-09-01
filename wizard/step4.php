<?php

/* Update the list of available plugins for the Wizard Plugins page */
//$this->ssw_find_plugins();

$skip = true;
$step4 = 'features';

    echo '
        <div class="ssw-container">
            <div class="ssw-content">
    ';
                    include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
    echo '
                <div class="ssw-header-wrapper">
                     <h3>Features (Step 3)</h3>
    ';
                    include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
    echo '
                    <p class="ssw-header-note">
                        THIS STEP IS OPTIONAL! Select features to add functionality to your site. You can activate
                         or deactivate these plugins as you need them from the admin\'s Plugins screen. Learn more
                         about <a href="http://www.nyu.edu/servicelink/KB0012644" target="_blank">available plugins here.</a>
                    </p>
                </div>
                <fieldset class="ssw-fieldset">
	';
                    /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
				    wp_nonce_field('step4_action','step4_nonce');
    echo '
                    <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step2"/>
                    <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step4"/>
                    <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_finish"/>
                    <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
                    <input id="action" name="action" type="hidden" value="ssw_submit_form_next"/>
                        ';

                            if ($wpmu_pretty_plugins == true) {
                                
                                foreach ($plugins_categories as $category_system_name => $category_name) {
                                    if ($category_name != $hide_plugin_category) {
                                        echo '
                                                <div class="ssw-plugins-categories-col">
                                                    <div class="ssw-plugins-categories-title">
                                                        <h4 class="ssw-h4">'.$category_name.'</h4>
                                                    </div>
                                                    <div class="ssw-plugins-list">
    ';
                                        foreach($plugins_list as $plugin_path => $plugin_details) {
                                            if( $plugin_details['Categories'] && $plugin_details['Name']) {
                                                foreach ($plugin_details['Categories'] as $category_count => $category_system_name_in_details) {
                                                    if($category_system_name == $category_system_name_in_details) {
    echo '
                                                            <input type="checkbox" name="plugins_to_install_group[]" value="'.$plugin_path.'" />'.$plugin_details['Name'].'<br/>

    ';
                                                    }
                                                }
                                            }
                                        }

    echo '
                                                    </div>
                                                </div>
    ';
                                    }
                                }
                            }
                            else {
                                foreach ($plugins_list as $plugin_path => $plugin_details){
                                    if(isset($plugin_details['Name'])) {    
    echo '
                                        	<div class="ssw-plugins-categories-col">
                                            <input type="checkbox" name="plugins_to_install_group[]" value="'.$plugin_path.'" />'.$plugin_details['Name'].'</div>';
                                    }
                                }
                            }    
    echo '
                    <div class="ssw-processing ssw-field" id="ssw-site-processing" name="ssw_site_processing">
                        <span id="ssw-site-processing-label" ></span>
                    </div>
                    <div class="ssw-proceed ssw-field">
                            <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Finish" onclick="ssw_js_submit_form_next()" tabindex="11" />
                    </div> 
                </fieldset>
            </div>
        </div>
                
    ';
?>