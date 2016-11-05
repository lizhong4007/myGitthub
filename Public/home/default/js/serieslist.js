function my_page(arr_page,currentpage)
{
	var prev_page = $('#prev_page').val();
	var next_page = $('#next_page').val();
	var p_total = $('#p_total').val();
	var d_page = $('#d_page').val();
	var str = '';
	str +='<div class="container-fluid page">';
	str +='<div class="container ">';
	str +='<div class="page_num">';
	str +='<ul>';
	//上一页
	if(arr_page[1] != 0)
	{
		str +='<li class="pre">';
		str +='<a href="javascript:;" class="new_page" data-index="'+arr_page[1]+'">';
		str += prev_page;
		str +='</a>';
		str +='</li>';
	}
	
	for (var i = 5; i < arr_page.length; i++) {
		if(currentpage == arr_page[i])
		{
			str += '<li class="num active">';
			str += '<a href="#">';
			str += arr_page[i];
			str += '</a>';
			str += '</li>';
		}else{
			str +='<li class="num ">';
			str +='<a href="javascript:;" class="new_page" data-index="'+arr_page[i]+'">';
			str += arr_page[i];
			str +='</a>';
			str +='</li>';
		}
	}
    //下一页
	if(arr_page[2] != 0)
	{
		str +='<li class="next">';
		str +='<a href="javascript:;" class="new_page" data-index="'+arr_page[2]+'">';
		str += next_page;
		str +='</a>';
		str +='</li>';
	}
	if(arr_page[4] > 1)
	{
		str +='<li class="total">';
		str += p_total+arr_page[4]+d_page;
		str +='</li>';
		str +='<li class="page_go">';
		str +='<div class="form-group">';
		str +='<div class="input-group">';
		str +='<input class="form-control" id="go_other_page"  value="" type="text">';
		str +='<span class="input-group-addon go_other_page">';
		str +='GO';
		str +='</span>';
		str +='</div>';
		str +='</div>';
		str +='</li>';
	}
	str +='</ul>';
	str +='</div>';
	str +='</div>';
	str +='</div>';
	return str;
}

$(function(){
	$(".t_selector_brand").hover(function(){
		var obj = $(this);
		obj.find(".t_selector_img").css({"display":"none"});
		obj.find(".t_selector_title").css({"display":"block"});

	},function(){
		var obj = $(this);
		obj.find(".t_selector_title").css({"display":"none"});
		obj.find(".t_selector_img").css({"display":"block"});
	});

	$(".t_selector_more").hover(function(){
		var obj = $(this);
		obj.find("i").removeClass("opened");
		obj.find("i").addClass("closed");
		obj.addClass("active");

	},function(){
		var obj = $(this);
		obj.find("i").removeClass("closed");
		obj.find("i").addClass("opened");
		obj.removeClass("active");
	});

	/*更多*/
	$(".t_selector_more").on("click",function(){
		var obj = $(this);
		var html = obj.find("a").html();
		var closed = $("#closed").val();
		var closeing = $("#closeing").val();
		var opened = $("#opened").val();
		if(closed == 0)
		{
			$("#closed").val("1");
			obj.find("a").html(closeing);
			obj.addClass("active");
			obj.find("i").removeClass("opened");
			obj.find("i").addClass("closeing");
			obj.find("a").addClass("a_color");
			obj.parent().find(".t_selector_r").css({"height":"auto"});
			obj.parent().find(".t_selector_brand").css({"margin-top":"10px"});
		}else{
			$("#closed").val("0");
			obj.find("a").html(opened);
			obj.removeClass("active");
			obj.find("i").removeClass("closeing");
			obj.find("i").addClass("opened");
			obj.find("a").removeClass("a_color");
			obj.parent().find(".t_selector_r").css({"height":"50px"});
			obj.parent().find(".t_selector_brand").css({"margin-top":"auto"});
		}
	});

});
/*筛选事件*/
$('.all_selector').on('click','.goods_filter',function(){
	$('#goodslist').html('');
	$('#page').html('');
	var obj = $(this);
    var vid_active = obj.find('input').val();
    obj.parent().parent().parent().find("input[name^='t_vid']").val(vid_active);
    obj.parent().siblings().find('.goods_filter').removeClass('active');
    obj.addClass('active');
    get_seriresdata(1);

});
/*分页事件*/
$('body').on('click','.new_page',function(){
	var obj = $(this);
	var current_page = obj.attr('data-index');
	get_seriresdata(current_page);

});

$('body').on('click','.go_other_page',function(){
	var current_page = $('#go_other_page').val();
	if(parseInt(current_page) > 0)
	{
		get_seriresdata(current_page);
	}
});

/*获取筛选数据*/
function get_seriresdata(currentpage)
{
	var $paraid = new Array();
    $.each( $("input[name^='paraid']"), function(i, n){
                $paraid.push($(n).val());
        });

    var $t_vid = new Array();
    $.each( $("input[name^='t_vid']"), function(i, n){
                $t_vid.push($(n).val());
        });

    var seriesid = $('#seriesid').val();
    var url = $('#filter_url').val();
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
          paraid:$paraid,
          t_vid:$t_vid,
          seriesid:seriesid,
          currentpage:currentpage,
        },
        url: url,
        success: function (json) {
        	var str = '';
        	var data = json.data;
        	for (var i = 0; i < data.length; i++) {
        		str += '<li class="col-xs-12 t_list_li">';
				str += '<div class="t_list_l col-xs-3">';
				str += '<a href="'+data[i].url+'" class="t_list_img" target="_blank">';
				str += '<img class="img-responsive" src="'+data[i].thumb+'" />';
				str += '</a>';
				str += '</div>';
				str += '<div class="t_list_c col-xs-8 row">';
				str += '<div class="t_list_title">';
				str += '<a href="'+data[i].url+'">';
				str += data[i].title;
				str += '</a>';
				str += '</div>';
				str += '<div class="t_list_spec">';
				str += '<ul class="col-xs-12 row">';
					str += '<li class="col-xs-6 row">';
					str += '<span>';
					str += data[i].brand_name+':';
					str += '</span>';
					str += data[i].brand;
					str += '</li>';
					str += '<li class="col-xs-6 row">';
					str += '<span>';
					str += data[i].model_name+':';
					str += '</span>';
					str += data[i].model;
					str += '</li>';
					for (var j = 0; j < data[i].param.length; j++) {
						str += '<li class="col-xs-6 row">';
						str += '<span>';
						str += data[i].param[j][0]+':';
						str += '</span>';
						str += data[i].param[j][1];
						str += '</li>';
					}
				str += '</ul>';
				str += '</div>';
				str += '</div>';
				str += '<div class="t_list_r col-xs-1 row">';
				str += '<div class="t_list_price">';
				str += data[i].price_str;
				str += '</div>';
				str += '</div>';
				str += '</li>';
        	}

        	if(str == '')
        	{
        		str = '<div style="color:red;margin-top:10px;">抱歉！没有搜索到您需要的商品</div>'

        	}

        	$('#goodslist').html(str);

        	//分页
        	var totalRows = json.totalrows;
        	var page = '' ;
        	if(totalRows > 1)
    		{
    			page = common_page(totalRows,currentpage);
    			var page_str;
	        	if(page)
	        	{
	        	   page_str = my_page(page,currentpage)
	        	   $('#page').html(page_str)
	        	}
    		}
    		$('#total_rows').html(totalRows);
          
        }
    });
}







