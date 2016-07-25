(function( $ ) {
	'use strict';

	/**
	 * Load all graphs after the window is loaded
	 */
   $( window ).load(function() {

    loadTestLineChart();

    loadAllSitesInfo();

    loadSiteTypeInfo();

    console.log(sswAnalytics.allSitesInfo);

  });
 })( jQuery );

function loadAllSitesInfo() {

  var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
  var dateFormat = d3.time.format("%Y-%m-%d");
  var height = 400;
  //var width = 1100;


  var allData = d3.nest()
  .key(function (d) { return d.site_type; })
  .key(function (d) { return dateFormat(parseDate(d.endtime)); })
  .sortKeys()
  .rollup(function (leaves) { return leaves.length; })
  .entries(sswAnalytics.allSitesInfo)
  ;

  allData.forEach( function (d) {
    d.values.forEach(function (g) {
      g.x = new Date(g.key);
      g.y = g.values;
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
      .tickFormat(function(d) { return d3.time.format('%B %Y')(new Date(d));})
      .rotateLabels(-45)
      .axisLabel("Sites Created");
		
    chart.x2Axis.
      tickFormat(function(d) { return d3.time.format('%B %Y')(new Date(d));})
      .axisLabel("Sites Created");
    //chart.yTickFormat(d3.format(',.2f'));
    
    chart.yTickFormat(d3.format('d'));    
    chart.yAxis.axisLabel('Number of Sites');    
    
    chart.useInteractiveGuideline(true);
    chart.interpolate('basis');

    d3.select('#all-sites-info')
    .datum(allData)
    .call(chart)
    .attr('height', height)
    ;
    
    nv.utils.windowResize(chart.update);
    
    return chart;
  });
}


/**
 * Load Test Line Chart
 *
 * @since 1.5.5
 */
 function loadTestLineChart() {

   var height = 400;
   var width = 900;
   nv.addGraph(function() {  
   var chart = nv.models.lineChart();
  
  chart.xAxis
       .axisLabel('Date')
       .rotateLabels(-45)
       .tickFormat(function(d) { return d3.time.format('%b %d')(new Date(d)); });
 
   chart.yAxis
       .axisLabel('Activity')
       .tickFormat(d3.format('d'));
 
   d3.select('#test-data')
       .datum(fakeActivityByDate())
     .transition().duration(500)
       .call(chart);
 
   nv.utils.windowResize(function() { d3.select('#test-data').call(chart) });
 
   return chart;
 });

 }

function days(num) {
  return num*60*60*1000*24
}
 /**************************************
  * Simple test data generator
  */

function fakeActivityByDate() {
   var lineData = [];
   var y=0;
   var start_date = new Date() - days(365); // one year ago
   for (var i = 0; i < 100; i++) {
     lineData.push({x: new Date(start_date + days(i)), y: y});
     y=y+Math.floor((Math.random()*10)-3);
   }
   return [
     {
       values: lineData,
       key: 'Activity',
       color: '#ff7f0e'
     }
   ];
 }





/**
 * Display pie chart based on siteTypeInfo
 *
 * @since 1.5.5
 */
 function loadSiteTypeInfo() {

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
    .labelType(function(d, i, values) {
     return values.key + ':' + values.value;
   })
    .showLegend(true)
    ;

    d3.select("#site-type-info")
    .datum(sswAnalytics.siteTypeInfo)
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