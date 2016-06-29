<?php

global $wpdb;
$ssw_main_table = $this->ssw_main_table();
$options = $this->ssw_fetch_config_options();
$is_debug_mode = $options['debug_mode'];    

echo '<h3>Site Setup Wizard Analytics</h3>';

echo '<p>This page will be having all the available reports from the Site Setup Wizard Plugin</p>';

/* Fetch count of all sites created so far using Site Setup Wizard based on their cateogory selected */
$results = $wpdb->get_results( 
    'SELECT site_type, count(*) as number_of_sites FROM '.$ssw_main_table.' WHERE site_created = 1 group by site_type'
    );

echo '<h4>Number of Sites created using Site Setup Wizard</h4>';
echo '<p>';
foreach( $results as $obj ) {
    $site_type = $obj->site_type;
    $number_of_sites = $obj->number_of_sites;
    if($site_type!='') {
        echo $site_type.' - '.$number_of_sites.'<br/>';
    }
}
echo '</p>';

/* Fetch count of all sites created and all steps of wizard completed so far using Site Setup Wizard based on their cateogory selected */
$results2 = $wpdb->get_results( 
    'SELECT site_type, count(*) as number_of_sites FROM '.$ssw_main_table.' WHERE wizard_completed = 1 group by site_type'
    );

echo '<h4>Number of Sites created using Site Setup Wizard and all steps of wizard were completed by user</h4>';
echo '<p>';
foreach( $results2 as $obj ) {
    $site_type = $obj->site_type;
    $number_of_sites = $obj->number_of_sites;
    if($site_type!='') {
        echo $site_type.' - '.$number_of_sites.'<br/>';
    }
}

?>