<div id="container" style="min-width:50%; max-width: 90%; height:75%; margin: 0 auto"></div>
<script type="text/javascript">
	Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Stock Chart'
    },
    xAxis: {
    		
        categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        
    },
    yAxis: {
        min: 0,
        minRange: 10,
       	plotLines: [{
          color: 'red', // Color value
          dashStyle: 'Solid', // Style of the plot line. Default to solid
          value: 30, // Value of where the line will appear
          width: 2 // Width of the line    
  			}],
        title: {
            text: 'Total Item in Stock'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'John',
        data: [50, 30, 40, 70, 20]
    }, {
        name: 'Jane',
        data: [20, 20, 30, 20, 10]
    }]
});
$(".highcharts-credits").hide();
</script>