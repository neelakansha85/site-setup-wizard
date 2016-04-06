<?php

$can_skip = true;
$step3 = 'themes';

echo '  
<div class="ssw-container">
    <div class="ssw-content">
        ';
        include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
        echo '
        <div class="ssw-header-wrapper">
            <h3>Themes (Step 3)</h3>
            ';
            include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
            echo '
        </div>
        
        <fieldset class="ssw-fieldset">
            ';
            /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
            wp_nonce_field('step3_action','step3_nonce');
            echo '            
            <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step2"/>
            <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step3"/>
            <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step4"/>
            <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
            <input id="action" name="action" type="hidden" value="ssw_submit_form_next"/>
            
            <div class="ssw-field">
                <div class="ssw-themes-categories-col ssw-themes-border">
                    <div class="ssw-element" id="width-double">
                        <div class="ssw-element-inner">
                            <a href="../wp-content/themes/twentyfourteen/screenshot.png" alt="screenshot of theme" class="thumb-wrap  mfp-image">
                                <img src="../wp-content/themes/twentyfourteen/screenshot.png">
                                <div class="thumb-overlay" style="display: none;">
                                    <div class="thumb-bg" style="background-color:rgba(255,165,0,0.85);">
                                        <div class="thumb-title fadeInLeft animated">Twenty Fourteen (theme name)</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="ssw-themes-radio">
                        <input type="radio" name="select_theme" value="Twenty Fourteen (theme name)" tabindex="5">Select this theme
                    </div>
                </div>
            </div>
            <div class="ssw-proceed ssw-field">
                <input name="ssw_back_btn" class="ssw-primary-btn ssw-back-btn" type="button" onclick="ssw_js_submit_form_previous()" value="Back" tabindex="10" />
                <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Next" onclick="ssw_js_submit_form_next()" tabindex="11" />
            </div> 
        </fieldset>
    </div>
</div>
';
?>