<?php

wp_enqueue_script( 'ssw-analytics-js' );
wp_enqueue_script( 'd3-min-js' );
wp_enqueue_script( 'nv-d3-min-js' );

wp_enqueue_style( 'bootstrap-min-css' );
wp_enqueue_style( 'nv-d3-min-css' );

global $wpdb;
$ssw_main_table = $this->ssw_main_table();
$options = $this->ssw_fetch_config_options();
$is_debug_mode = $options['debug_mode'];    

echo '<h3>Site Setup Wizard Analytics</h3>';

/* Fetch count of all sites created so far using Site Setup Wizard based on their cateogory selected */
$results = $wpdb->get_results( 
    'SELECT site_type, count(*) as number_of_sites FROM '.$ssw_main_table.' WHERE site_created = 1 AND site_type != '' group by site_type'
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

wp_localize_script( 'ssw-analytics-js', 'sswAnalytics', $results );

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <svg id="pie-site-type">
            </svg>
        </div>
    </div>
</div>