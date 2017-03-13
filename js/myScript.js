$(document).ready(function(){
	var itemData_store = getItemData();
});

$("li[role=presentation]").click(function(){
	$("li[role=presentation]").not(this).removeClass('active');
	$(this).addClass('active');
	getContent($(this).attr('get-content'),itemData_store);
});

function getItemData(){
	$.ajax({
            url: "ajaxData/getItem.php",
            async: true,
            dataType: "json",
            type: "post",
            data: {},
            beforeSend: function(){
            	$.isLoading({ text:"Loading Item Data",position:"overlay"});
            },
            success: function (result) {
            	//console.log(result);
            	$.isLoading("hide");
            	if(result!=null&&result[0]==true){
            		itemData_store = result[1];
            		getContent($("li[role=presentation][class=active]").attr('get-content'),itemData_store);
            	}else{
            		$(".content").html('Error !!');
            	}
            }
    }); 
}
function getContent(fileName,itemData){
	if(fileName=="getGraph"){
            get_graph(itemData);
      }else{
            $.ajax({
                  url: "ajaxData/"+fileName+".php",
                  async: true,
                  dataType: "text",
                  type: "post",
                  data: {'itemData':itemData},
                  beforeSend: function(){
                        $(".content").html('').isLoading({ text:"Loading",position:"overlay"});
                  },
                  success: function (result) {

                        $(".content").isLoading("hide").html(result);
                  }
            }); 
      }
}

function get_graph(itemData){
    $(".content").html('<div id="graph_container" style="min-width:50%; max-width: 90%; min-height:100%; margin: 0 auto"></div>');
     
    Highcharts.chart('graph_container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Stock Chart'
    },
    xAxis: {
            
        categories: get_itemcode_array(itemData)
        
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
        data: [50, 30, 40, 70, 20,50, 30, 40, 70, 20]
    }, {
        name: 'Jane',
        data: [20, 20, 30, 20, 10,50, 30, 40, 70, 20]
    }]
});
$(".highcharts-credits").hide();
}

function get_itemcode_array(itemData){
      var arr_item_all = [];
      itemData.forEach(function(element, index, array) {
            arr_item_all.push(element['Itemcode']);
      });
      return arr_item_all;
}
function get_plot_data_array(div,itemData){
      
}