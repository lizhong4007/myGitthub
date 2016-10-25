function checkForm()
{
    var name = $('#name');
    var en_name = $('#en_name');
    var brand_img = $('#image');
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
    if(brand_img.val() == '')
    {
        var title = $('#title_note').val();
        var content = $('#content_note').val();
        alert_message(title,content)
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
/*详细页是否推荐*/
$('.recommend_state').click(function(){
    var obj = $(this); 
    var brand_id = obj.find("a").attr('data-brand');
    var state = obj.find("a").attr('data');
    var url = $("#brand_url").val();
    $.ajax({
      url:url,
      type:'post',
      dataType:'json',
      data:{brand_id:brand_id,state:state},
      success:function(data){
        if(data.code == 1)
        {
          obj.attr('data',data.state); 
          if(data.state == 1)
          {
              obj.html('<a href="javascript:;" data="1" data-brand="'+brand_id+'" class="fa fa-check text-navy"></a>');
          }else{
              obj.html('<a href="javascript:;" data="0" data-brand="'+brand_id+'" class="fa fa-close text-red"></a>');
          }
        }

      }
    });
  
})

