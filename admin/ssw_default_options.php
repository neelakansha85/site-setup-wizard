<?php

/* 
Default Content for config options - Imp for
initializing all the options for SSW Plugin
 */

// Inserting all default Values
$ssw_default_options = array(
    'site_type' => array(
        'student' => array( 
            'Personal', 
            'Teaching/Learning/Research', 
            'Administrative' 
            ),
        'employee' => array(
            /* Sample Data */
            /*
            'Personal Site',
            'Club Site'
            */
            )
        ),
    'site_user_category' => array(
        'student' => array(
            'No Category Selected',
            'Personal',
            'Teaching/Learning/Research',
            'Faculty',
            'HR'
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
    // Sites with this category selected will not have any prefixes in it's site address
    'site_category_no_prefix' => array( 'No Category Selected', 'Personal', 'Teaching/Learning/Research' ),
    'banned_site_address' => array( 'wp-admin', 'about', 'contact', 'blog', 'create' ),
    'hide_themes' => array(''),
    'hide_plugins' => array(''),
    'terms_of_use' => 'I accept the <a href="#terms-of-use">Terms of Use</a>',
    'plugins_page_txt' => 'THIS STEP IS OPTIONAL! Select features to add functionality to your site. You can activate or deactivate these plugins as you need them from the admin\'s Plugins screen. Learn more about <a href="#available-plugins">available plugins here.</a>',
    'finish_page_txt' => '',
    'steps_name' => array(
        'step1' => 'Start',
        'step2' => 'Essential Settings',
        'step3' => 'Themes',
        'step4' => 'Features',
        'finish' => 'Done!'
        ),
    'external_plugins' => array(
        'wpmu_multisite_privacy_plugin' => false,
        'wpmu_pretty_plugins' => false,
        'wpmu_multisite_theme_manager' => false,
        'wpmu_new_blog_template' => false
        ),
    'advanced_privacy' => array(
        'privacy_selection_txt' => '<strong>Please note that by default, your site privacy settings are set to "Public on the Web, but are not indexed by search engines".</strong><br>Once your site is created, please update your site privacy settings, by going to Settings (in the left menu) &gt; Reading &gt; Site visibility.<br><strong>More information can be found <a href="https://codex.wordpress.org/Settings_Reading_Screen" target="_blank">here</a>.</strong>',
        'private_network_users_txt' => 'Visible to all users registered in network',
        'private_site_users_txt' => 'Limited to only users who you specify in the "Users" settings (by adding them to Users page of your site and assigning them a role)',
        'private_administrator_txt' => 'Limited to only site administrators who you specify in the "Users" settings (good for preparing a site before making it visible to a larger audience)'
        ),
    'hide_plugin_category' => 'other',
    /* 
    All contents will be displayed to users based on the 
    mapped user roles if user_role_restriction is set true 
     */
    'user_role_restriction' => false,
    'user_role_mapping' => array(
        'student' => 'subscriber',
        'employee' => 'contributor',
        ),
    // Map wordpress user role to which Site Setup Wizard should not be available
    'ssw_not_available' => '',
    'ssw_not_available_txt' => 'Apologies but you do not have access to create new sites using this service. If you believe this is by error, please contact your site\'s admin',
    'privacy_selection' => true,
    'debug_mode' => false,
    'master_user' => false
    );
// END Default Content for config options

?>