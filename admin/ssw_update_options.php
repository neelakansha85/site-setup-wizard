<?php
	
	/* Please change values to update config settings */
	$ssw_config_options_nsd = array(
        'site_address_bucket' => array(
            'student' => array(
                ),
            'faculty' => array(
                ),
            'employee' => array(
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
            'affiliate' => array(
                ),
            ),
        'banned_root_site_address' => array( 'documentation', 'get-started', 'about-us', 'terms_of_use', 'contact', 'blog', 'create-new-site' , 'create' , 'z' ),
        'banned_site_address' => array( 'johnsexton', 'john_sexton', 'nyu', 'wp-admin', 'abusive' ),
        /* Sites with this category selected will not have any bucket in it's site address */
        'site_address_bucket_none_value' => array( 'personal', 'no_category', 'teaching_and_learning' ),
        'template_type' => array(
            'teaching_and_learning' => 'Teaching and Learning',
            'administrative' => 'Administrative',
            'personal' => 'Personal',
            'custom' => 'Custom'
            ),
        'select_template' => array(
            'dusk_to_dawn' => 'Dusk To Dawn',
            'sunspot' => 'Sunspot',
            'hueman' => 'Hueman',
            'writing1' => 'Writing 1',
            'writing2' => 'Writing 2',
            'portfolio1' => 'Portfolio 1',
            'portfolio2' => 'Portfolio 2',
            ),
        'hide_plugin_category' => 'other',
        'external_plugins' => array(
            'wpmu_multisite_privacy_plugin' => true,
            'wpmu_pretty_plugins' => false,
            'wpmu_multisite_theme_manager' => false,
            'wpmu_new_blog_template' => false
            ),
        'restricted_user_roles' => array(
            'student' => 'student_subscriber',
            'faculty' => 'faculty_subscriber',
            'employee' => 'staff_subscriber',
            'affiliate' => 'affiliate_subscriber'
            ),
        'site_usage' => array(
            'student' => array(
                'personal' => 'Personal Site',
                'clubs' => 'Club Site'
                ),
            'faculty' => array(
                'personal' => 'Personal Site',
                'teaching_learning_research' => 'Teaching/Learning/Research Site'
                ),
            'employee' => array(
                'personal' => 'Personal Site',
                'administrative' => 'Administrative'
                ),
            'common' => array(
                'personal' => 'Personal Site',
                'teaching_learning_research' => 'Teaching/Learning/Research Site',
                'administrative' => 'Administrative'
                ),
            ),
        'site_usage_display_common' => true,
        'ssw_not_available' => 'alumni_subscriber',
        'terms_of_use' => 'I accept the <a href="http://wp.nyu.edu/terms-of-use" target="_blank">Terms of Use</a>',
        'privacy_selection' => true,
        'debug_mode' => true
    );
	/* END config options  */

?>