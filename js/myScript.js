

$(document).ready(function(){
	var itemData = getItemData();
});

$("li[role=presentation]").click(function(){
	$("li[role=presentation]").not(this).removeClass('active');
	$(this).addClass('active');
	getContent($(this).attr('get-content'),itemData);
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
            		itemData = result;
            		getContent($("li[role=presentation][class=active]").attr('get-content'));
            	}else{
            		$(".content").html('Error !!');
            	}
            }
    }); 
}
function getContent(fileName){
	console.log(itemData);
	$.ajax({
            url: "ajaxData/"+fileName,
            async: true,
            dataType: "text",
            type: "post",
            data: {},
            beforeSend: function(){
            	$(".content").html('').isLoading({ text:"Loading",position:"overlay"});
            },
            success: function (result) {

            	$(".content").isLoading("hide").html(result);
            }
    }); 
}