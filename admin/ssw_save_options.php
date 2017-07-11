<?php

// Update SSW options when fetched from Options Page 
// Get current options for use where required
$options = $this->ssw_fetch_config_options();

$ssw_user_role_selected = $this->ssw_sanitize_option('sanitize_key', $_POST['ssw-user-role-select']);
if($ssw_user_role_selected == 'add_new' && $this->ssw_sanitize_option('sanitize_key', $_POST['add-user-role-input'])!= '') {
    $ssw_user_role_selected = $this->ssw_sanitize_option('sanitize_key', $_POST['add-user-role-input']);
}
$ssw_site_type_array = $this->ssw_sanitize_option('to_array_on_eol', $_POST['ssw-site-type']);
$ssw_site_category_array = $this->ssw_sanitize_option('to_array_on_eol', $_POST['ssw-site-category']);

$site_type = $options['site_type'];
$site_user_category = $options['site_user_category'];

/* Do not add user role if it's value is null or add_new */
if($ssw_user_role_selected != 'add_new') {
    $site_type[$ssw_user_role_selected] = $ssw_site_type_array;
    $site_user_category[$ssw_user_role_selected] = $ssw_site_category_array;
}

if($_POST['ssw-debug-mode'] == 'true') {
    $set_debug_mode = true;
}
else {
    $set_debug_mode = false;
}

/* Inserting all new values */
$new_ssw_config_options = array(
    'site_type' => $site_type,
    'site_user_category' => $site_user_category,
    /* Sites with this category selected will not have any prefixes in it's site address */
    'site_category_no_prefix' => $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-site-category-no-prefix']),
    'banned_site_address' => $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-banned-site-address']),
    'terms_of_use' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-terms-of-use']),
    'hide_themes' => $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-hide-themes']),
    'hide_plugins' => $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-hide-plugins']),
    'plugins_page_txt' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-plugins-page-txt']),
    'finish_page_txt' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-finish-page-txt']),
    'steps_name' => array(
        'step1' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-step-1']),
        'step2' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-step-2']),
        'step3' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-step-3']),
        'step4' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-step-4']),
        'finish' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-finish'])
        ),
    'external_plugins' => array(
        'wpmu_multisite_privacy_plugin' => isset($_POST['wpmu-multisite-privacy-plugin']) ? true : false,
        'wpmu_pretty_plugins' => isset($_POST['wpmu-pretty-plugin']) ? true : false,
        'wpmu_multisite_theme_manager' => isset($_POST['wpmu-multisite-theme-manager-plugin']) ? true : false,
        'wpmu_new_blog_template' => isset($_POST['wpmu-new-blog-template-plugin']) ? true : false
        ),
    'advanced_privacy' => array(
        'privacy_selection_txt' => $this->ssw_sanitize_option('allow_html', $_POST['privacy-selection-txt']),
        'private_network_users_txt' => $this->ssw_sanitize_option('allow_html', $_POST['private-network-users-txt']),
        'private_site_users_txt' => $this->ssw_sanitize_option('allow_html', $_POST['private-site-users-txt']),
        'private_administrator_txt' => $this->ssw_sanitize_option('allow_html', $_POST['private-administrator-txt'])
        ),
    'hide_plugin_category' => 'other',
    /*
    All contents will be displayed to users based on the mapped user roles
    if user_role_restriction is set true 
     */
    'user_role_restriction' => isset($_POST['user-role-restriction']) ? true : false,
    'user_role_mapping' => array(
        'student' => 'subscriber',
        'employee' => 'administrator',
        ),
    /* Map wordpress user role to which Site Setup Wizard should not be available */
    'ssw_not_available' => $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-not-available']),
    'ssw_not_available_txt' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-not-available-txt']),
    'privacy_selection' => isset($_POST['ssw-privacy-selection']) ? true : false,
    'debug_mode' => $set_debug_mode,
    'master_user' => isset($_POST['ssw-debug-master-user']) ? true : false
    );

/* END Default Content for config options */

?>