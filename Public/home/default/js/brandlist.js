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
$('.all_selector').on('click','.t_selector_brand',function(){
	$('#goodslist').html('');
	$('#page').html('');
	var obj = $(this);
    var brandid = obj.find('.brand_id').val();
    brandid = parseInt(brandid);
    $('#brandid_tmp').val(brandid);
    obj.siblings('.t_selector_brand').removeClass('active');
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
	var site_imagedomain = $('#site_imagedomain').val();
	var brandid = $('#brandid_tmp').val();
	var url = $('#brand_url').val();
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
          currentpage:currentpage,
          brandid:brandid,
        },
        url: url,
        success: function (json) {
        	var str = '';
        	var data = json.data;
        	for (var i = 0; i < data.length; i++) {
        		str += '<li class="width1200 brand_goods_li">';
				str += '<div class="brand_goods_l width300 fl">';
			    str += '<a href="'+data[i].goods_url+'" class="t_list_img" target="_blank">';
			    str += '<img title="'+data[i].title+'" alt="'+data[i].title+'"  class="img-responsive"  src="'+data[i].thumb+'" />';
			    str += '</a></div>';
				str += '<div class="brand_goods_c width600 fl ">';
				str += '<div class="brand_goods_title">';
				str += '<a title="'+data[i].title+'" href="">';
				str += data[i].title;
				str += '</a></div>';
				str += '<div class="brand_goods_spec">';
				str += '<ul class="width600 ">';
				str += '<li class="width300 ">';
			    str += '<span>品牌名称:</span>';
			    str += data[i].brand;
		        str += '</li>';
			    str += '<li class="width300 ">';
			    str += '<span>型号:</span>';
			    str += data[i].model;
		        str += '</li>';
		        str += data[i].param;
		        str += '</ul></div></div>';
				str += '<div class="brand_goods_r width300 fl">';
				str += '<div class="brand_goods_price">';
				str += data[i].minprice;
				str += '</div>';
				str += '</div>';
				str += '<div class="clear"></div>';
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







