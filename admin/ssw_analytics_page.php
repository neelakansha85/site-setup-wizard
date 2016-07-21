<?php

wp_enqueue_script( 'ssw-analytics-js' );
wp_enqueue_script( 'd3-min-js' );
wp_enqueue_script( 'nv-d3-min-js' );

wp_enqueue_style( 'bootstrap-min-css' );
wp_enqueue_style( 'nv-d3-min-css' );
wp_enqueue_style( 'ssw-style-admin-css' );

global $wpdb;
$ssw_main_table = $this->ssw_main_table();
$options = $this->ssw_fetch_config_options();
$is_debug_mode = $options['debug_mode'];    

$ssw_analytics = new stdClass();

/* Get count of all sites created based on cateogory selected on Step 1 */
$results = $wpdb->get_results( 
    "SELECT site_type, COUNT(*) as number_of_sites FROM {$ssw_main_table} WHERE site_created = 1 AND site_type <> '' AND site_type IS NOT NULL GROUP BY site_type"
    );

$ssw_analytics->siteTypeResults = $results;

wp_localize_script( 'ssw-analytics-js', 'sswAnalytics', $ssw_analytics );

?>
<div class="wrap">
    <h1><?php echo esc_html('Site Setup Wizard Analytics') ?></h1>
    <h4><?php echo esc_html('Sites created based on their Type') ?></h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <svg id="pie-site-type">
                </svg>
            </div>
        </div>
    </div>
</div>