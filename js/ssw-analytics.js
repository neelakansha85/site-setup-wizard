(function( $ ) {
	'use strict';

	/**
	 * Load all graphs after the window is loaded
	 */
	 $( window ).load(function() {

	 	loadSiteTypeInfo();

	 	loadAllSitesInfo();

	 });
})( jQuery );

/**
 * Display Line Chart based on allSitesInfo
 *
 * @since 1.5.5
 */
 function loadAllSitesInfo(newDateFormat) {
 	
	var dateFormat = newDateFormat || '%b %Y';
 	var parseDate = d3.time.format(dateFormat);
 	var total = 0;
 	var height = 400;
	//var width = 1100;

	var allSitesInfo = sswAnalytics.allSitesInfo || [];
	allSitesInfo.sort(function(a, b){ return d3.ascending(a.endtime, b.endtime); });

	allSitesInfo = d3.nest()
	.key(function (d) { return d.site_type; })
	.sortKeys(d3.ascending)
	.key(function (d) { return parseDate(new Date(d.endtime)); })
	.rollup(function (leaves) { return leaves.length; })
	.entries(allSitesInfo)
	;

	allSitesInfo.forEach( function (d) {
		d.values.forEach(function (g) {
			g.x = new Date(g.key);
			g.y = g.values;
			total = total + g.values;
			delete(g.values);
			delete(g.key);
		})
	})

	nv.addGraph(function() {
		var chart = nv.models.lineWithFocusChart()
		.color(d3.scale.category10().range())
		.margin({left: 100})
		.margin({right: 100})
	//.width(width)
	.height(height)
	;

	chart.xAxis
	.tickFormat(function(d) { return parseDate(new Date(d));})
	  //.rotateLabels(-45)
	  .axisLabel("Time");

	  chart.x2Axis.
	  tickFormat(function(d) { return parseDate(new Date(d));})
	  .axisLabel("Sites Created");

	  chart.yTickFormat(d3.format('d'));    
	  chart.yAxis.axisLabel('Number of Sites');    

	  chart.useInteractiveGuideline(true);

	  d3.select('#all-sites-info')
	  .datum(allSitesInfo)
	  .call(chart)
	  .attr('height', height)
	  ;

	  nv.utils.windowResize(chart.update);

	  return chart;
	});

	displayTotalSites(total);
 }

/**
 * Display pie chart based on siteTypeInfo
 *
 * @since 1.5.5
 */
 function loadSiteTypeInfo() {

 	var height = 400;
 	var width = 400;

 	var allSitesInfo = sswAnalytics.allSitesInfo || [];
	allSitesInfo.sort(function(a, b){ return d3.ascending(a.endtime, b.endtime); });

	var siteTypeInfo = d3.nest()
	.key(function (d) { return d.site_type; })
	.sortKeys(d3.ascending)
	.rollup(function (leaves) { return leaves.length; })
	.entries(allSitesInfo)
	;

 	nv.addGraph(function() {
 		var chart = nv.models.pieChart()
 		.x(function(d) { return d.key})
 		.y(function(d) { return d.values })
 		.showTooltipPercent(true)
 		.width(width)
 		.height(height)
 		.showLabels(true)
 		.labelsOutside(false)
 		.labelType(function(d, i, values) {
 			return values.key + ':' + values.value;
 		})
 		.showLegend(true)
 		;

 		d3.select("#site-type-info")
 		.datum(siteTypeInfo)
 		.attr('width', width)
 		.attr('height', height)
 		.attr('viewBox', '0 0 ' + width + ' ' + height)
 		.transition().duration(500)
 		.attr('perserveAspectRatio', 'xMinYMid')
 		.call(chart)
 		;

 		nv.utils.windowResize(chart.update);
 		return chart;
 	});
 }

function displayTotalSites(total) {
	var totalSitesId = document.getElementById('ssw-a-total-sites-value');

	totalSitesId.innerHTML = total;
}