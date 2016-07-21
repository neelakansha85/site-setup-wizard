(function( $ ) {
	'use strict';

	/**
	 * Load all graphs after the window is loaded
	 */
	$( window ).load(function() {

		loadGraphs();

		function loadGraphs() {

			var height = 400;
			var width = 400;

			nv.addGraph(function() {
				var chart = nv.models.pieChart()
				.x(function(d) { return d.site_type})
				.y(function(d) { return d.number_of_sites })
				.showTooltipPercent(true)
				.width(width)
				.height(height)
				.showLabels(true)
				.labelsOutside(false)
				.showLegend(true);

				d3.select("#pie-site-type")
				.datum(sswAnalytics.siteTypeResults)
				.attr('width', width)
				.attr('height', height)
				.attr('viewBox', '0 0 ' + width + ' ' + height)
				.transition().duration(500)
				.attr('perserveAspectRatio', 'xMinYMid')
				.call(chart);

				nv.utils.windowResize(chart.update);
				return chart;
			});
		}
	});
})( jQuery );

/**
 * Bootstrap Hack For D3 graphs
 *
 * @since 1.5.5
 */

/*

var bootstrapCss = 'bootstrapCss';
if (!document.getElementById(bootstrapCss))
{
    var head = document.getElementsByTagName('head')[0];
    var bootstrapWrapper = document.createElement('link');
    bootstrapWrapper.id = bootstrapCss;
    bootstrapWrapper.rel = 'stylesheet/less';
    bootstrapWrapper.type = 'text/css';
    bootstrapWrapper.href = '../css/bootstrap-wrapper.less';
    bootstrapWrapper.media = 'all';
    head.appendChild(bootstrapWrapper);
}
*/
