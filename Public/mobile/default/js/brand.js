$(function(){
	$(".brand_series").on('click','.brand_category_name',function(){
		var obj = $(this);
		var status = obj.attr('data');

		status = parseInt(status);
		obj.parent().siblings().find(".brand_series_content").each(function(n){
				$(this).hide();
		});
		obj.parent().siblings().find(".brand_category_name").each(function(n){
			var sub_obj = $(this);
			sub_obj.find("i").attr('class','fa fa-angle-right');
			sub_obj.attr('data','0');
		});
		if(status == 0)
		{
			obj.attr('data','1');
			obj.find('i').removeClass('fa-angle-right');
			obj.find('i').addClass('fa-angle-down');
			obj.parent().find(".brand_series_content").slideDown(300);
		}else{
			obj.attr('data','0');
			obj.find('i').addClass('fa-angle-right');
			obj.find('i').removeClass('fa-angle-down');
			obj.parent().find(".brand_series_content").slideUp("slow");
		}
	});
});