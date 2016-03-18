<?php

	/* Default Content for config options - Imp for initializing all the options for SSW Plugin */
	
	/* Inserting all default Values */
	$ssw_config_options_nsd = array(
        'site_address_bucket' => array(
            'student' => array(
                'no_category' => 'No Category Selected',
                'personal' => 'Personal',
                'teaching_and_learning' => 'Teaching/Learning/Research',
                'hr' => 'Human Resource',
                'bursar' => 'Bursar',
                'abu_dhabi' => 'Abu Dhabi',
                'apa' => 'Apa',
                'africahouse' => 'Africa House',
                'campuscable' => 'Campus Cable',
                'campusmedia' => 'Campus Media',
                'careerdevelopment' => 'Career Development',
                'ccpr' => 'CCPR',
                'chinahouse' => 'China House',
                'clubs' => 'Clubs',
                'cmep' => 'CMEP',
                'csals' => 'CSALS',
                'csgs' => 'CSGS',
                'cte' => 'CTE',
                'deutscheshaus' => 'Deutscheshaus',
                'faculty' => 'Faculty',
                'facultyhousing' => 'Faculty Housing',
                'financialaid' => 'Financial Aid',
                'financialservices' => 'Financial Services',
                'giving' => 'Giving',
                'greyart' => 'Greyart',
                'ir' => 'IR',
                'kimmelcenter' => 'Kimmel Center',
                'kjc' => 'KJC',
                'lgbtq' => 'LGBTQ',
                'library' => 'Library',
                'nyutv' => 'NYU TV',
                'ogca' => 'OGCA',
                'ogs' => 'OGS',
                'osp' => 'OSP',
                'publicaffairs' => 'Public Affairs',
                'registrar' => 'Registrar',
                'residentialeducation' => 'Residential Education',
                'shc' => 'SHC',
                'sps' => 'SPS',
                'src' => 'SRC',
                'studentaffairs' => 'Student Affairs',
                'stugov' => 'Stugov',
                'sustainability' => 'Sustainability',
                'tvmedia' => 'TV Media',
                'tvcenter' => 'TV Center',
                'tisch' => 'Tisch',
                'socialwork' => 'Social Work',
                'steinhardt' => 'Steinhardt',
                'nursing' => 'Nursing',
                'gsas' => 'GSAS',
                'gallatin' => 'Gallatin',
                'dental' => 'Dental',
                'fas' => 'FAS',
                'cas' => 'CAS',
                'as' => 'AS',
                'shanghai' => 'Shanghai',
                'ls' => 'Liberal Studies',
                'gls' => 'Global Liberal Studies'
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
        'banned_site_address' => array( 'andrewhamilton', 'andrew_hamilton', 'johnsexton', 'john_sexton', 'nyu', 'wp-admin', 'abusive', 'documentation', 'get-started', 'about-us', 'terms_of_use', 'contact', 'blog', 'create-new-site' , 'create' , 'z' ),
        /* Sites with this category selected will not have any prefixes in it's site address */
        'site_address_bucket_none_value' => array( 'personal', 'no_category', 'teaching_and_learning' ),
        'hide_plugin_category' => 'other',
        'external_plugins' => array(
            'wpmu_multisite_privacy_plugin' => true,
            'wpmu_pretty_plugins' => true,
            'wpmu_multisite_theme_manager' => false,
            'wpmu_new_blog_template' => false
            ),
        /* In progress */
        'restricted_user_roles' => array(
            'student' => 'student_subscriber',
            'employee' => 'staff_subscriber',
            ),
        'site_usage' => array(
            'student' => array(
                'personal' => 'Personal Site',
                'teaching_learning_research' => 'Teaching/Learning/Research Site',
                'administrative' => 'Administrative'
                ),
            'employee' => array(
                /* Sample Data */
                /*
                'personal' => 'Personal Site',
                'clubs' => 'Club Site'
                */
                )
            ),
        'site_usage_display_common' => false,
        'steps_name' => array(
            'step1' => 'Start',
            'step2' => 'Essential Settings',
            'step3' => 'Themes',
            'step4' => 'Features',
            'finish' => 'Done!'
            ),
        /* Map wordpress user role to which Site Setup Wizard should not be available */
        'ssw_not_available' => 'alumni_subscriber',
        'terms_of_use' => 'I accept the <a href="http://wp.nyu.edu/terms-of-use" target="_blank">Terms of Use</a>',
        'plugins_page_note' => 'THIS STEP IS OPTIONAL! Select features to add functionality to your site. You can activate or deactivate these plugins as you need them from the admin\'s Plugins screen. Learn more about <a href="http://www.nyu.edu/servicelink/KB0012644" target="_blank">available plugins here.</a>',
        'privacy_selection' => true,
        'debug_mode' => false,
        'master_user' => false
    );
	/* END Default Content for config options  */

?>