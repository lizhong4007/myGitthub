function checkForm()
{
    var name = $('#name');
    var en_name = $('#en_name');
    if(name.val() == '')
    {
      name.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      return false;
    }
    if(en_name.val() == '')
    {
      en_name.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      return false;
    }
    return true;
}
$('#name').focus(function(){
  $('#name').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
});
$('#en_name').focus(function(){
  $('#en_name').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
});
$('.dropdown').click(function(){
   obj = $(this);
   cur_tr = obj.parent('td').parent('tr');// 找到父级tr
   cur_level = parseInt(cur_tr.attr('class'));//当前父级tr 的级别
   cur_show_hide = cur_tr.attr('data');//当前状态：隐藏or显示
   cur_id = cur_tr.attr('id');//当前id
   if(cur_show_hide == 'up')
   {
       cur_tr.attr('data','down');
       obj.removeClass('fa-plus');
       obj.addClass('fa-minus');
   }else{
       cur_tr.attr('data','up');
       obj.removeClass('fa-minus');
       obj.addClass('fa-plus');
   }
   $('tr').each(function(){
        any_tr = $(this);//其他tr
        any_level = parseInt(any_tr.attr('class'));//tr级别
        any_pid = parseInt(any_tr.attr('data-pid'));//pid 与cat_id 对应
        if(any_level > cur_level)
        {
            parent_id = $('#'+any_pid);//分类中父级pid所在tr
            parent_id_data = parent_id.attr('data');
            if(parent_id_data == 'up')
            {
                any_tr.attr('data','up');
                any_tr.hide();
            }else{
                any_tr.attr('data','down');
                any_tr.show();
                any_tr.find('.dropdown').removeClass('fa-plus');
                any_tr.find('.dropdown').addClass('fa-minus');
            }
        }
   });
})
$('.show_state').click(function(){
    var obj = $(this); 
    var cat_id = obj.find("a").attr('data-cat');
    var state = obj.find("a").attr('data');
    var type = obj.find("a").attr('data-type');
    var url = $("#category_url").val();
    $.ajax({
      url:url,
      type:'post',
      dataType:'json',
      data:{cat_id:cat_id,state:state,type:type},
      success:function(data){
        if(data.code == 1)
        {
          obj.attr('data',data.state); 
          if(data.state == 1)
          {
              obj.html('<a href="javascript:;" data="1" data-type="'+type+'" data-cat="'+cat_id+'" class="fa fa-check text-navy"></a>');
          }else{
              obj.html('<a href="javascript:;" data="0" data-type="'+type+'" data-cat="'+cat_id+'" class="fa fa-close text-red"></a>');
          }
        }

      }
    });
  
})



