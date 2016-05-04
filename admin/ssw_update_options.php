<?php

/**
* Update SSW options when fetched from Options Page 
*/
/* Get current options for use where required */
$options = $this->ssw_fetch_config_options();

    $ssw_site_type_array = stripslashes(wp_kses_post($_POST['ssw-site-type']));
    $ssw_site_type_array = explode(PHP_EOL, $ssw_site_type_array);
    echo ('<br/><br/>ssw_site_type_array: ');
    print_r($ssw_site_type_array);

$site_category_no_prefix = stripslashes(sanitize_text_field($_POST['ssw-site-category-no-prefix']));
$site_category_no_prefix = explode(' ', $site_category_no_prefix);
$ssw_user_role_selected = $this->ssw_sanitize_option('sanitize_field', $_POST['ssw-user-role-select']);
$ssw_user_role_array = $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-user-roles']);
$site_category_no_prefix = $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-site-category-no-prefix']);
$banned_site_address = $this->ssw_sanitize_option('to_array_on_comma', $_POST['ssw-banned-site-address']);

if($_POST['ssw-debug-mode'] == 'true') {
    $set_debug_mode = true;
}
else {
    $set_debug_mode = false;
}

/* Inserting all new values */
$ssw_config_options_nsd = array(
    'site_address_bucket' => array(
        'student' => array(
            'no_category' => 'No Category Selected',
            'personal' => 'Personal',
            'teaching_and_learning' => 'Teaching/Learning/Research',
            'abu_dhabi' => 'Abu Dhabi',
            'africahouse' => 'Africa House',
            'apa' => 'Apa',
            'as' => 'AS',
            'bursar' => 'Bursar',
            'campuscable' => 'Campus Cable',
            'campusmedia' => 'Campus Media',
            'careerdevelopment' => 'Career Development',
            'cas' => 'CAS',
            'ccpr' => 'CCPR',
            'chinahouse' => 'China House',
            'clubs' => 'Clubs',
            'cmep' => 'CMEP',
            'csals' => 'CSALS',
            'csgs' => 'CSGS',
            'cte' => 'CTE',
            'dental' => 'Dental',
            'deutscheshaus' => 'Deutscheshaus',
            'faculty' => 'Faculty',
            'facultyhousing' => 'Faculty Housing',
            'fas' => 'FAS',
            'financialaid' => 'Financial Aid',
            'financialservices' => 'Financial Services',
            'gallatin' => 'Gallatin',
            'giving' => 'Giving',
            'gls' => 'Global Liberal Studies',
            'greyart' => 'Greyart',
            'gsas' => 'GSAS',
            'hr' => 'Human Resource',
            'ir' => 'IR',
            'kimmelcenter' => 'Kimmel Center',
            'kjc' => 'KJC',
            'lgbtq' => 'LGBTQ',
            'library' => 'Library',
            'ls' => 'Liberal Studies',
            'nursing' => 'Nursing',
            'nyutv' => 'NYU TV',
            'ogca' => 'OGCA',
            'ogs' => 'OGS',
            'osp' => 'OSP',
            'publicaffairs' => 'Public Affairs',
            'registrar' => 'Registrar',
            'residentialeducation' => 'Residential Education',
            'shanghai' => 'Shanghai',
            'shc' => 'SHC',
            'socialwork' => 'Social Work',
            'sps' => 'SPS',
            'src' => 'SRC',
            'steinhardt' => 'Steinhardt',
            'studentaffairs' => 'Student Affairs',
            'stugov' => 'Stugov',
            'sustainability' => 'Sustainability',
            'tisch' => 'Tisch',
            'tvcenter' => 'TV Center',
            'tvmedia' => 'TV Media'
            ),
        'employee' => array(
            /* Sample Data */
            /*
            'no_category' => 'No Category Selected',
            'personal' => 'Personal',
            'teaching_and_learning' => 'Teaching/Learning/Research',
            'clubs' => 'Club'
            */
            )
        ),
    /* Sites with this category selected will not have any prefixes in it's site address */
    'site_address_bucket_none_value' => $site_category_no_prefix,
    'site_type' => array(
        'student' => array(
            'Personal', 
            'Teaching/Learning/Research', 
            'Administrative' 
            ),
        'employee' => array()
        ),
    'banned_site_address' => $banned_site_address,
    'terms_of_use' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-terms-of-use']),
    'plugins_page_txt' => $this->ssw_sanitize_option('allow_html', $_POST['ssw-plugins-page-txt']),
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
    /**
    * All contents will be displayed to users based on the mapped user roles
    * if user_role_restriction is set true 
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

/* END Default Content for config options  */

?>