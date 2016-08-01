<?php

$step3 = 'themes';

?> 
<div class="ssw-container">
    <div class="ssw-content">
        <?php
        include(SSW_PLUGIN_DIR.'admin/ssw_cancel_skip_button.php');
        ?>
        <div class="ssw-header-wrapper">
            <h3><?php _e($steps_name['step3']); ?></h3>
            <?php
            include(SSW_PLUGIN_DIR.'admin/ssw_breadcrumb_text.php');
            ?>
        </div>
        <fieldset class="ssw-fieldset">
            <?php
            /* Wordpress Security function wp_nonce to avoid execution of same function/object multiple times */
            wp_nonce_field('step3_action','step3_nonce');
            ?>
            <input id="ssw-previous-stage" name="ssw_previous_stage" type="hidden" value="ssw_step2"/>
            <input id="ssw-current-stage" name="ssw_current_stage" type="hidden" value="ssw_step3"/>
            <input id="ssw-next-stage" name="ssw_next_stage" type="hidden" value="ssw_step4"/>
            <input id="ssw-cancel" name="ssw_cancel" type="hidden" value=""/>
            <input id="action" name="action" type="hidden" value="ssw_submit_form_next"/>
            
            <div class="ssw-field">    
                <?php
                $themes = wp_get_themes();
                foreach ( $themes as $theme ) {
                    if($theme->is_allowed('network')) {
                        if( !in_array($theme->title, $hide_themes) ) {
                        ?>
                            <div class="ssw-themes-categories-col">
                                <label for="ssw-themes-<?php echo esc_attr( $theme->get_stylesheet() ); ?>">
                                    <img class="ssw-themes-screenshot" src="<?php echo esc_url($theme->get_screenshot()); ?>">
                                    <div class="ssw-themes-radio">
                                        <input type="radio" name="select_theme" id="ssw-themes-<?php echo esc_attr( $theme->get_stylesheet() ); ?>" value="<?php echo esc_attr( $theme->get_stylesheet() ); ?>" tabindex="5">
                                        <span class="ssw-themes-title"><?php echo $theme->title; ?></span>
                                    </div>
                                </label>
                            </div>
                        <?php
                        }
                    }
                }
                ?>
                <div class="ssw-error ssw-field" id="ssw-themes-error" name="ssw-themes-error">
                    <label class="ssw-site-title-error-field-spacing ssw-label">&nbsp;</label>
                    <span id="ssw-themes-error-label" class="ssw-span"></span>
                </div>
                <div class="ssw-proceed ssw-field">
                    <input name="ssw_next_btn" class="ssw-primary-btn ssw-front-btn" type="button" value="Next" onclick="ssw_js_submit_form_next()" tabindex="11" />
                </div>
            </div>
        </fieldset>
    </div>
</div>