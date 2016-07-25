<?php

wp_enqueue_script( 'd3-min-js' );
wp_enqueue_script( 'nv-d3-min-js' );
wp_enqueue_script( 'ssw-analytics-js' );

wp_enqueue_style( 'bootstrap-min-css' );
wp_enqueue_style( 'nv-d3-min-css' );
wp_enqueue_style( 'ssw-style-admin-css' );

global $wpdb;
$ssw_main_table = $this->ssw_main_table();
$options = $this->ssw_fetch_config_options();
$is_debug_mode = $options['debug_mode'];    

$ssw_analytics = new stdClass();

/* Get all sites created using Site Setup Wizard */
$results = $wpdb->get_results(
	"SELECT site_type, blog_id, endtime FROM {$ssw_main_table} WHERE site_created = 1 AND blog_id <> '' AND blog_id IS NOT NULL"
	);
$ssw_analytics->allSitesInfo = $results;

wp_localize_script( 'ssw-analytics-js', 'sswAnalytics', $ssw_analytics );

?>
<div class="wrap">
	<h1><?php echo esc_html('Site Setup Wizard Analytics') ?></h1>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 id="ssw-a-total-sites"><?php echo esc_html('Total number of sites created = ') ?><span id="ssw-a-total-sites-value"></span></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4><?php echo esc_html('Number of Sites Created') ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-sm btn-primary" name="Based on Month" value="Based on Month" onclick="loadAllSitesInfo('%b %Y')" > <?php echo esc_html('Based on Month') ?>
				</button>
				<button type="button" class="btn btn-sm btn-primary" name="Based on Date" value="Based on Date" onclick="loadAllSitesInfo('%d %b %Y')" > <?php echo esc_html('Based on Date') ?>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<svg id="all-sites-info">
				</svg>
			</div>
		</div>
		<div class="row top-buffer">
			<div class="col-md-4">
				<h4><?php echo esc_html('Types of Sites') ?></h4>
				<svg id="site-type-info">
				</svg>
			</div>
		</div>
	</div>
</div>