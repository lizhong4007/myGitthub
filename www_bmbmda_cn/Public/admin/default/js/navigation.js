/*添加数据*/
$('#btn_save').on('click',function(){
	var url = $('#form').attr('action');
	var nav_name = $('input[name^="nav_name"]').val();
	var controller = $('input[name^="data[controller]"]').val();
	var action = $('input[name^="data[action]"]').val();
	var navid = $('input[name^="data[navid]"]').val();
	var nav_list = $('#nav_list').val();
    var title = $('#title_note').val();
    var save = $('#save').val();

	$.ajax({
      url:url,
      type:'post',
      dataType:'json',
      data:{
      	nav_name:nav_name,
      	controller:controller,
      	action:action,
      	navid:navid,
      	save:save,
      },
      success:function(json){
      	alert_message(title,json.message);
        if(json.code == 1)
        {
          window.location.href = nav_list;
        }else{
          $("#btn_submit").attr("disabled", false); 
          return false;
        }
      }
    });
});
/*导航是否显示*/
$('.show_state').click(function(){
    var obj = $(this); 
    var navid = obj.find("a").attr('data-nav');
    var state = obj.find("a").attr('data');
    var url = $("#nav_url").val();
    $.ajax({
      url:url,
      type:'post',
      dataType:'json',
      data:{navid:navid,state:state},
      success:function(json){
        if(json.code == 1)
        {
          obj.attr('data',json.state); 
          if(json.state == 1)
          {
              obj.html('<a href="javascript:;" data="1" data-nav="'+navid+'" class="fa fa-check text-navy"></a>');
          }else{
              obj.html('<a href="javascript:;" data="0" data-nav="'+navid+'" class="fa fa-close text-red"></a>');
          }
        }

      }
    });
  
})
function setImages(json)
{
    if(json.flag == 1)
    { 
        var image_host = "{:C('UPLOAD_FILE_URL')}";
        $('#Navigation_logo').attr('src',image_host+json.message);
        $('#image').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }

}