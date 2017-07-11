<?php

//create action for ssw_options_page_loaded
do_action('ssw_options_page_loaded');

/* Include the Javascripts for the ssw plugin while trying to create a site */
wp_enqueue_script( 'ssw-options-js' );
/* Include CSS for Options Page */
wp_enqueue_style( 'ssw-style-admin-css' );

if(isset($_POST['ssw-user-role-select'])) { 
    if ( !empty($_POST['ssw-user-role-select']) && check_admin_referer('submit_ssw_settings')){
        $this->ssw_save_options();
        //echo('Inside ssw_options_page Debug Mode: '.$_POST['ssw-debug-mode'].'<br/>');
    }else{
        wp_die('Please use valid forms to send data.'); 
    }
}

global $current_blog;
global $current_site;

/* Identifing current domain and path on domain where wordpress is running from */
$current_site_root_address = $current_blog->domain.$current_site->path;

/* Pass value of $options to ssw-options.js */
$options = $this->ssw_fetch_config_options();
wp_localize_script( 'ssw-options-js', 'sswOptions', $options );

?>


<div class="wrap">
    <h1><?php echo esc_html('Site Setup Wizard Settings') ?></h1>
    <form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>" novalidate="novalidate" name="ssw-options-page" id="ssw-options-page">
        <h3><?php echo esc_html('Basic Settings') ?></h3>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="ssw-user-role-select"><?php echo esc_html('User Role') ?></label></th>
                    <td>                   
                        <select name="ssw-user-role-select" id="ssw-user-role-select" class="regular-text ssw-select" aria-describedby="ssw-user-role-select-desc" >
                        </select>
                        <span id="remove-user-role-btn" class="dashicons dashicons-no ssw-remove-btn" onclick="removeSelectValue('ssw-user-role-select')"></span>
                        <div class="ssw-add-new-input">
                            <input name="add-user-role-input" type="text" id="add-user-role-input" class="ssw-add-new-text" placeholder="Add New Site User Role" value="">
                            <span id="add-user-role-btn" class="dashicons dashicons-plus-alt ssw-add-new-btn" onclick="addNewSelectValue('add-user-role-input', 'ssw-user-role-select')"></span>
                        </div>
                        <p class="description" id="ssw-user-role-select-desc">
                            <?php _e( 'Please Save Options after adding Site Type and Site Category information for a particular user role.'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ssw-site-type"><?php echo esc_html('Site Type') ?></label></th>
                    <td>
                    
                    <textarea name="ssw-site-type" id="ssw-site-type" aria-describedby="ssw-site-type-desc" cols="60" rows="5"></textarea>
                    <p class="description" id="ssw-site-type-desc">
                        <?php _e( 'These Site Type will be displayed for a user to choose from on first page of Site Setup Wizard (Step 1). Separate types by new line.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category"><?php echo esc_html('Site Category') ?></label></th>
                <td>
                    <textarea name="ssw-site-category" id="ssw-site-category" aria-describedby="ssw-site-category-desc" cols="60" rows="5"></textarea>
                    <p class="description" id="ssw-site-category-desc">
                        <?php _e( 'These categories will be used as prefixes to the site address (URL). The site url will be '.$current_site_root_address.'&lt;Site Category&gt;-&lt;Site Address&gt;<br/> Separate categories by new line.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-site-category-no-prefix"><?php echo esc_html('Site Category with no Prefix') ?></label></th>
                <td>
                    <input name="ssw-site-category-no-prefix" type="text" id="ssw-site-category-no-prefix" aria-describedby="ssw-site-category-no-prefix-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-site-category-no-prefix-desc">
                        <?php _e( 'These categories will not have any prefixes in the site address i.e. blank &lt;Site Category&gt;. Separate names by comma.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-banned-site-address"><?php echo esc_html('Banned Site Address') ?></label></th>
                <td>
                    <input name="ssw-banned-site-address" type="text" id="ssw-banned-site-address" aria-describedby="ssw-banned-site-address-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-banned-site-address-desc">
                        <?php _e( 'Users are not allowed to register these sites. Separate names by comma.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-terms-of-use"><?php echo esc_html('Terms of Use') ?></label></th>
                <td>
                    <textarea name="ssw-terms-of-use" id="ssw-terms-of-use" aria-describedby="ssw-terms-of-use-desc" cols="60" rows="5"></textarea>
                    <p class="description" id="ssw-terms-of-use-desc">
                        <?php _e('Please enter the text you want to display next to Terms of Use checkbox.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-hide-themes"><?php echo esc_html('Hide Themes') ?></label></th>
                <td>
                    <input name="ssw-hide-themes" type="text" id="ssw-hide-themes" aria-describedby="ssw-hide-themes-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-hide-themes-desc">
                        <?php _e( 'These themes will not be displayed on Themes selection page even if network enabled. Separate names by comma.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-hide-plugins"><?php echo esc_html('Hide plugins') ?></label></th>
                <td>
                    <input name="ssw-hide-plugins" type="text" id="ssw-hide-plugins" aria-describedby="ssw-hide-plugins-desc" class="large-text" value="" size="45" />
                    <p class="description" id="ssw-hide-plugins-desc">
                        <?php _e( 'These plugins will not be displayed on Plugins selection page. Separate names by comma.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-plugins-page-txt"><?php echo esc_html('Plugins Page Note') ?></label></th>
                <td>
                    <textarea name="ssw-plugins-page-txt" id="ssw-plugins-page-txt" aria-describedby="ssw-plugins-page-txt-desc" cols="60" rows="5"></textarea>
                    <p class="description" id="ssw-plugins-page-txt-desc">
                        <?php _e('Please enter the text you want to display on Plugins Selection (Step 4) page.'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="ssw-finish-page-txt"><?php echo esc_html('Finish Page Note') ?></label></th>
                <td>
                    <textarea name="ssw-finish-page-txt" id="ssw-finish-page-txt" aria-describedby="ssw-finish-page-txt-desc" cols="60" rows="5"></textarea>
                    <p class="description" id="ssw-finish-page-txt-desc">
                        <?php _e('Please enter the text you want to display on Finish page.'); ?>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
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
                        <label><input name="wpmu-multisite-privacy-plugin" type="checkbox" id="wpmu-multisite-privacy-plugin" value="true" ><?php echo esc_html('WPMU Multisite Privacy Plugin') ?></label>
                        <br/>
                        <label><input name="wpmu-pretty-plugin" type="checkbox" id="wpmu-pretty-plugin" value="true" ><?php echo esc_html('WPMU Pretty Plugin') ?></label>
                        <br/>
                        <label><input name="wpmu-multisite-theme-manager-plugin" type="checkbox" id="wpmu-multisite-theme-manager-plugin" value="true" ><?php echo esc_html('WPMU Multisite Theme Manager Plugin (Not yet Supported)') ?></label>
                        <br/>
                        <label><input name="wpmu-new-blog-template-plugin" type="checkbox" id="wpmu-new-blog-template-plugin" value="true" ><?php echo esc_html('WPMU New Blog Template Plugin (Not yet Supported)') ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php echo esc_html('Advanced Privacy Options') ?></h3>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php echo esc_html('Privacy Selection') ?></th>
                    <td>
                        <label><input name="ssw-privacy-selection" type="checkbox" id="ssw-privacy-selection" value="true" ><?php echo esc_html('Display privacy selection options on Step 2') ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="privacy-selection-txt"><?php echo esc_html('Pivacy Selection Text') ?></label></th>
                    <td>
                        <textarea name="privacy-selection-txt" id="privacy-selection-txt" aria-describedby="privacy-selection-txt-desc" cols="60" rows="5"></textarea>
                        <p class="description" id="privacy-selection-txt-desc">
                            <?php _e('Please enter the text you want to display if Privacy Selection is disabled on Step 2.'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="private-network-users-txt"><?php echo esc_html('Available to Network Users') ?></label></th>
                    <td>
                        <input name="private-network-users-txt" type="text" id="private-network-users-txt" class="large-text" value="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="private-site-users-txt"><?php echo esc_html('Available to Site Users') ?></label></th>
                    <td>
                        <input name="private-site-users-txt" type="text" id="private-site-users-txt" class="large-text" value="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="private-administrator-txt"><?php echo esc_html('Available to Site Admins') ?></label></th>
                    <td>
                        <input name="private-administrator-txt" type="text" id="private-administrator-txt" class="large-text" value="">
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php echo esc_html('User Role Restriction') ?></h3>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php echo esc_html('Site Type Restriction') ?></th>
                    <td>
                        <label><input name="user-role-restriction" type="checkbox" id="user-role-restriction" value="true" ><?php echo esc_html('Restrict Site Type on Step 1 based on user role mapping with wordpress') ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ssw-not-available"><?php echo esc_html('Restricted User Role') ?></label></th>
                    <td>
                        <input name="ssw-not-available" type="text" id="ssw-not-available" aria-describedby="ssw-not-available-desc" class="regular-text" value="">
                        <p class="description" id="ssw-not-available-desc">
                            <?php _e( 'User with this role in wordpress root site will not be allowed to access Site Setup Wizard.'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ssw-not-available-txt"><?php echo esc_html('Note to Restricted User') ?></label></th>
                    <td>
                        <textarea name="ssw-not-available-txt" id="ssw-not-available-txt" aria-describedby="ssw-not-available-txt-desc" cols="60" rows="5"></textarea>
                        <p class="description" id="ssw-not-available-txt-desc">
                            <?php _e('Please enter the text you want to display to the user who will not be able to access Site Setup Wizard.'); ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php echo esc_html('Debug Settings') ?></h3>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php echo esc_html('Debug Mode') ?></th>
                    <td>
                        <fieldset>
                            <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-enable" value="true" /><?php echo esc_html('Enable') ?></label>
                            <label><input name="ssw-debug-mode" type="radio" id="ssw-debug-mode-disable" value="false" /><?php echo esc_html('Disable') ?></label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Activate Master User') ?></th>
                    <td>
                        <label><input name="ssw-debug-master-user" type="checkbox" id="ssw-debug-master-user" value="true"><?php echo esc_html('Please select this if you would like to display all options in the Wizard without discriminating based on User Role') ?> 
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php wp_nonce_field('submit_ssw_settings'); ?>
            <input type="submit" name="submit" id="submit" class="ssw-options-submit button-primary" value="Save Changes" onclick="saveOptions()">
        </p>
    </form>

    <h3><?php echo esc_html('Export and Import') ?></h3>
    <form method="post">
        <table class="form-table">
            <tbody>
                <th scope="row"><label for="ssw-export-options"><?php _e('Export'); ?></label></th>
                <td>
                    <input type="hidden" name="ssw_action" value="export_options" />
                    <?php wp_nonce_field('ssw_export_nonce', 'ssw_export_nonce'); ?>
                    <?php submit_button( __('Download Export File'), 'secondary', 'submit', false); ?>
                    <p class="description" id="ssw-export-options-desc">
                        <?php _e( 'Export Site Setup Wizard settings as a .json file. This file can be used as a backup for your current settings.'); ?>
                    </p>
                </td>
            </tbody>
        </table>
    </form>
    <form method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tbody>
                <th scope="row"><label for="ssw-import-options"><?php _e('Import'); ?></label></th>
                <td>
                    <input type="hidden" name="ssw_action" value="import_options" />
                    <input type="file" name="import_file"/>
                    <div class="ssw-import-options-button">
                    <?php wp_nonce_field('ssw_import_nonce', 'ssw_import_nonce'); ?>
                    <?php submit_button( __('Import Settings'), 'secondary', 'submit', false); ?>
                    </div>
                    <p class="description" id="ssw-import-options-desc">
                        <?php _e( 'Import Site Setup Wizard configuration settings from a .json file.'); ?>
                    </p>
                </td>
            </tbody>
        </table>
    </form>
    <table class="form-table">
        <tbody>
            <th scope="row"><label for="ssw-set-default-settings"><?php _e('Reset'); ?></label></th>
            <td>
                <input type="hidden" name="ssw_action" value="set_default_settings" />
                <?php wp_nonce_field('ssw_set_default_nonce', 'ssw_set_default_nonce'); ?>
                <input type="button" name="default" id="default" class="ssw-options-default button-secondary" value="Reset all settings" onclick="setDefaultOptions()">
                <p class="description" id="ssw-set-default-settings-desc">
                    <?php _e( 'Reset all settings to their default.'); ?>
                </p>
            </td>
        </tbody>
    </table>
</div>
