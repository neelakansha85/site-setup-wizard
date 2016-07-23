(function( $ ) {
	'use strict';

	/**
	 * Load all graphs after the window is loaded
	 */
   $( window ).load(function() {

    //	loadAllSitesInfo();

    loadAllSitesInfo2();

    loadSiteTypeInfo();

    console.log(sswAnalytics.allSitesInfo);

  });
 })( jQuery );

//var myData = testData();

var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
var dateFormat = d3.time.format("%Y-%m-%d");

var allData = d3.nest()
.key(function (d) { return d.site_type; })
.key(function (d) { return dateFormat(parseDate(d.endtime)); })
.sortKeys()
.rollup(function (leaves) { return leaves.length; })
.entries(sswAnalytics.allSitesInfo)
;

allData.forEach( function (d) {
	d.values.forEach(function (g) {
    g.x = g.key;
    g.y = g.values;
    delete(g.values);
    delete(g.key);
    delete(g.series);
  })
  d.area = false;
  delete(d.seriesIndex);
})

myData = allData;


function loadAllSitesInfo2() {
	nv.addGraph(function() {
		var chart = nv.models.lineWithFocusChart();
		chart.brushExtent([10,90]);
		chart.xAxis.tickFormat(function(d) { return d3.time.format('%b %d')(new Date(d));}).axisLabel("Sites Created");
		chart.x2Axis.tickFormat(function(d) { return d3.time.format('%b %d')(new Date(d));}).axisLabel("Sites Created");
    //chart.x2Axis.tickFormat(d3.format(',r'));
    //chart.yTickFormat(d3.format(',.2f'));
    chart.yTickFormat(d3.format('d'));    
    chart.yAxis.axisLabel('Number of Sites');    
    chart.useInteractiveGuideline(true);
    //chart.interpolate('basis');

    d3.select('#all-sites-info')
    .datum(myData)
    .call(chart);
    nv.utils.windowResize(chart.update);
    return chart;
  });
}
/*
function testData() {
  return stream_layers(3,128,.1).map(function(data, i) {
    return {
      key: 'Stream' + i,
      area: i === 1,
      values: data
    };
  });
}


/* Inspired by Lee Byron's test data generator. */
/*
function stream_layers(n, m, o) {
  if (arguments.length < 3) o = 0;
  function bump(a) {
    var x = 1 / (.1 + Math.random()),
    y = 2 * Math.random() - .5,
    z = 10 / (.1 + Math.random());
    for (var i = 0; i < m; i++) {
      var w = (i / m - y) * z;
      a[i] += x * Math.exp(-w * w);
    }
  }
  return d3.range(n).map(function() {
    var a = [], i;
    for (i = 0; i < m; i++) a[i] = o + o * Math.random();
      for (i = 0; i < 5; i++) bump(a);
        return a.map(stream_index);
    });
}

/* Another layer generator using gamma distributions. */
/*
function stream_waves(n, m) {
  return d3.range(n).map(function(i) {
    return d3.range(m).map(function(j) {
      var x = 20 * j / m - i / 3;
      return 2 * x * Math.exp(-.5 * x);
    }).map(stream_index);
  });
}

function stream_index(d, i) {
  //return {x: i, y: Math.max(0, d)};
  return {x: i, y: Math.max(0, d)};
}



/**
 * Display line chart based on allSitesInfo
 *
 * @since 1.5.5
 */
/* function loadAllSitesInfo() {

   var height = 400;
   var width = 900;
   var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;

   nv.addGraph(function() {
/*
		var chart = nv.models.line()
		.x(function(d) { return d.endtime})
		.y(function(d) { return d })
		.useInteractiveGuideline(true)
		.showLegend(true)
		.showYAxis(true)
		.showXAxis(true)
		;

/*    chart.xAxis     //Chart x-axis settings
      .axisLabel('Time')
      .tickFormat(parseDate);

  	chart.yAxis     //Chart y-axis settings
      .axisLabel('Number of Sites')
      .tickFormat(d3.format(',r'));
      */

/*      var chart = nv.models.line()
      .width(width)
      .height(height)
      .margin({top: 20, right: 20, bottom: 20, left: 20});


			chart.xAxis     //Chart x-axis settings
      .axisLabel('Time (ms)')
      .tickFormat(d3.format(',r'));

  		chart.yAxis     //Chart y-axis settings
      .axisLabel('Voltage (v)')
      .tickFormat(d3.format('.02f'));

      
      console.log(myData);
      d3.select("#all-sites-info")
//		.datum(sswAnalytics.allSitesInfo)
.datum(myData)
.attr('width', width)
.attr('height', height)
.call(chart);

nv.utils.windowResize(chart.update);
return chart;
});


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
