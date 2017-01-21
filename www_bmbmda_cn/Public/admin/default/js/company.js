//表单提交
$("#btn_submit").on("click", function () {
    var form_data = $("#all_form");
    var url = form_data.attr('action');
    var title = $('#title_note').val();
    // $("#btn_submit").attr("disabled", true); 
    var company_url = $('#company_url').val(); 
    if (checkForm()) {
        $.ajax({
            type: "post",
            dataType: 'json',
            data: $('#all_form').serialize(),
            url: url,
            success: function (json) {
               alert_message(title,json.message);
                if(json.code == 0)
                {
                    $("#btn_submit").attr("disabled", false); 
                    return false;
                }else{
                    $("#submit_btn").attr("disabled", true);
                    window.location.href = company_url;
                }
         
            }
        })
    }else{
        $("#btn_submit").attr("disabled", false);
        return false; 
    }
});
function checkForm()
{
    var name = $('#name');
    var en_name = $('#en_name');
    var companysite = $('#companysite');
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
    if(companysite.val() == '')
    {
      companysite.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      return false;
    }
    var reg = /[https|http]:\/\//;
    var title = $('#title_note').val();
    var content = $('#content_note').val();
    if(!reg.test(companysite.val()))
    {  
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

//=======================地区开始=======================


/*=======增加地区联系人开始==========*/
$('.all_distributor').on('click','.add_telephone_block',function(){
    var obj = $(this);
    //地区id
    var region_id_v =  obj.parent().parent().parent().parent().find(".region_id").val();
    var region_id = parseInt(region_id_v);

    var telephone_name = obj.parent().find('.telephone').html();
    var contanct_name = obj.parent().find('.contanct').html();
    var new_telephone_block = '';
    new_telephone_block = '<div class="d_div ">';
    new_telephone_block += '<div class="d_telephone">';
    new_telephone_block += '<label class="control-label d_telephone_name telephone">';
    new_telephone_block += telephone_name+'</label>';
    //电话
    new_telephone_block += '<input class="form-control d_telephone_value" name="distributor['+region_id+'][telephone][]" type="text"  />';
    new_telephone_block += '</div>';
    //联系人
    new_telephone_block += '<div class="d_telephone">';
    new_telephone_block += '<label class="control-label d_telephone_name contanct" >';
    new_telephone_block += contanct_name+'</label>';
    new_telephone_block += '<input class="d_telephone_value form-control" name="distributor['+region_id+'][contacts][]" type="text"  />',
    new_telephone_block += '</div>';
    new_telephone_block += '<div class="span span_minus" title="delete">-</div>';
    new_telephone_block += '</div>';
    obj.parent().parent().append(new_telephone_block);
    // alert(new_telephone_block)

});
/*=======增加地区联系人结束==========*/

/*=======增加fax开始==========*/
$('.all_distributor').on('click','.add_fax_block',function(){
    var obj = $(this);
    //地区id
    var region_id_v =  obj.parent().parent().parent().parent().find(".region_id").val();
    var region_id = parseInt(region_id_v);

    var new_telephone_block = '';
    new_telephone_block += '<div class="d_div">';
    new_telephone_block += '<label class="d_name control-label">';
    new_telephone_block += 'fax</label>';
    new_telephone_block += '<input class="d_email form-control" name="distributor['+region_id+'][fax][]" type="text" />';
    new_telephone_block += '<div class="span span_minus" title="delete">-</div>';
    new_telephone_block += '</div>';
    obj.parent().parent().append(new_telephone_block);
});
/*=======增加fax结束==========*/

/*=======增加email开始==========*/
$('.all_distributor').on('click','.add_email_block',function(){
    var obj = $(this);
    //地区id
    var region_id_v =  obj.parent().parent().parent().parent().find(".region_id").val();
    var region_id = parseInt(region_id_v);

    var new_telephone_block = '';
    new_telephone_block += '<div class="d_div">';
    new_telephone_block += '<label class="d_name control-label">';
    new_telephone_block += 'email</label>';
    new_telephone_block += '<input class="d_email form-control" name="distributor['+region_id+'][email][]" type="text" />';
    new_telephone_block += '<div class="span span_minus" title="delete">-</div>';
    new_telephone_block += '</div>';
    obj.parent().parent().append(new_telephone_block);
});
/*=======增加email结束==========*/

/*=======增加经销商平台开始==========*/
$('.all_distributor').on('click','.add_platform_block',function(){
    var obj = $(this);
    //地区id
    var region_id_v =  obj.parent().parent().parent().parent().find(".region_id").val();
    var region_id = parseInt(region_id_v);

    var platform_name = obj.parent().parent().find('.platform').html();
    var account_name = obj.parent().parent().find('.account').html();
    var new_telephone_block = '';
    new_telephone_block += '<div class="d_div ">';
    new_telephone_block += '<div class="d_telephone">';
    new_telephone_block += '<label class="control-label d_telephone_name">';
    new_telephone_block += platform_name+'</label>';
    new_telephone_block += '<input class="form-control d_telephone_value" name="distributor['+region_id+'][platform][]" type="text"  />';
    new_telephone_block += '</div>';
    new_telephone_block += '<div class="d_telephone">';
    new_telephone_block += '<label class="control-label d_telephone_name" >';
    new_telephone_block += account_name+'</label>';
    new_telephone_block += '<input class="d_telephone_value form-control" name="distributor['+region_id+'][account][]" type="text"  />';
    new_telephone_block += '</div>';
    new_telephone_block += '<div class="span span_minus" title="delete">-</div>';
    new_telephone_block += '</div>';
    obj.parent().parent().append(new_telephone_block);
});
/*=======增加经销商平台end==========*/

//删除地区联系人
$('.all_distributor').on('click','.span_minus',function(){
    var obj = $(this);
    obj.parent().remove();
});

//删除整个地区模块
$('.all_distributor').on('click','.region_minus',function(){
    var obj = $(this);
    obj.parent().parent().parent().remove();
});
/*============添加整个地区模块开始==================*/
$('.all_distributor').on('click','.region_plus',function(){
  var obj = $(this);
  var please_select = $("#please_select").val();
  //地区id
  var all_distributor = $(".all_distributor");
  var region_id_v =  all_distributor.find(".part_region:last-child").find(".region_id").val();
  var region_id   = parseInt(region_id_v) + 1;
  var distributor_id =  1;//添加整个区域的时候，经销商id默认为0
  //标题
  var region_title = obj.parent().find('.distributor_title').html();
  var distributor_title = obj.parent().parent().parent().find('.distributor .distributor_title').html();
  var distributor_name  = obj.parent().parent().parent().find('.distributor_name').html();
  var distributor_region = obj.parent().parent().parent().find('.distributor_region').html();
  var distributor_detail_address = obj.parent().parent().parent().find('.distributor_detail_address').html();
  var telephone = obj.parent().parent().parent().find('.telephone').html();
  var account = obj.parent().parent().parent().find('.account').html();
  var platform = obj.parent().parent().parent().find('.platform').html();
  var contanct = obj.parent().parent().parent().find('.contanct').html();
  var distributor_site = obj.parent().parent().parent().find('.distributor_site').html();
  //获取第一个地区的第一个select选项框
  var select_option = obj.parent().parent().find(".d_select .d_select_block select").eq(0).html();
  //地区开始
  var new_block = '';
      new_block +=  '<div class="part_region">';
      new_block +=  '<input type="hidden"  class="region_id" value="'+region_id+'" />';
      new_block +=  '<div class="region">';
      new_block +=  '<label class="d_title d_title_r control-label">';
      new_block +=  '<span class="distributor_title">';
      new_block += region_title;
      new_block +=  '</span><span class="all_distributor_block region_minus">-';
      new_block +=  '</span></label>';
      new_block +=  '<div class="input-group d_select ">';
      new_block +=  '<label class="d_region control-label distributor_region">';
      new_block += distributor_region;
      new_block +=  '</label>';
      new_block +=  '<div class="d_select_block">';
      //select start
      new_block += '<select class="form-control select2 d_province" name="distributor['+region_id+'][countryid]">';
      new_block += select_option;
      new_block += '</select>';
      new_block += '<select class="form-control select2 d_city" name="distributor['+region_id+'][stateid]">';
      new_block += '<option value="0">'+please_select+'</option>';
      new_block += '</select>';
      new_block += '<select class="form-control select2" name="distributor['+region_id+'][cityid]">';
      new_block += '<option value="0">'+please_select+'</option>';
      new_block += '</select>';
      //select end
      new_block +=  '</div></div></div>';
      //地区end
      //经销商开始
      new_block +=  '<div class="distributor">';
      new_block +=  '<label class="d_title d_title_d control-label">';
      new_block +=  '<span class="distributor_title">'+distributor_title+'</span>';
      new_block +=  '</label>';
      new_block +=  '<div class="d_div">';
      new_block +=  '<label class="d_name control-label distributor_name ">'+distributor_name+'</label>';
      new_block +=  '<input class="d_name_input form-control" name="distributor['+region_id+'][distributor_name]" type="text" />';
      new_block +=  '</div>';
      new_block +=  '<div class="d_div">';
      new_block +=  '<label class="d_name control-label distributor_site ">'+distributor_site+'</label>';
      new_block +=  '<input class="d_name_input form-control" name="distributor['+region_id+'][site]"  type="text" />';
      new_block +=  '</div>';
      //详细地址
      new_block +=  '<div class="d_div">';
      new_block +=  '<label class="d_name control-label distributor_detail_address">';
      new_block += distributor_detail_address;
      new_block +=  '</label>';
      new_block +=  '<input class="d_detail form-control" name="distributor['+region_id+'][address]" type="text"  />';
      new_block +=  '</div>';
      new_block +=  '<div class="telephone_block">';
      new_block +=  '<div class="d_div ">';
      //电话
      new_block += '<div class="d_telephone">';
      new_block += '<label class="control-label d_telephone_name telephone">'+telephone+'</label>';
      new_block += '<input class="form-control d_telephone_value" name="distributor['+region_id+'][telephone][]" type="text"  />';
      new_block += '</div>';
      //联系人 
      new_block += '<div class="d_telephone">';
      new_block += '<label class="control-label d_telephone_name contanct" >'+contanct+'</label>';
      new_block += '<input class="d_telephone_value form-control" name="distributor['+region_id+'][contacts][]"  type="text"  />';
      new_block += '</div>';
      new_block += '<div class="span span_plus add_telephone_block" title="add">+</div>';
      new_block += '</div>';
      new_block += '</div>';
      //fax==================== 
      new_block += '<div class="fax_block">';
      new_block += '<div class="d_div">';
      new_block += '<label class="d_name control-label">';
      new_block += 'fax</label>';
      new_block += '<input class="d_email form-control" name="distributor['+region_id+'][fax][]"   type="text" />';
      new_block += '<div class="span span_plus add_fax_block" title="add">+</div>';
      new_block += '</div></div>';
     //邮箱==================== 
      new_block += '<div class="email_block">';
      new_block += '<div class="d_div">';
      new_block += '<label class="d_name control-label">email</label>';
      new_block += '<input class="d_email form-control" name="distributor['+region_id+'][email][]"   type="text" />';
      new_block += '<div class="span span_plus add_email_block" title="add">+</div>';
      new_block += '</div></div>';
     //平台和账号====================== 
      new_block += '<div class="platform_block">';
      new_block += '<div class="d_div ">';
      new_block += '<div class="d_telephone">';
      new_block += '<label class="control-label d_telephone_name platform">'+platform+'</label>';
      new_block += '<input class="form-control d_telephone_value" name="distributor['+region_id+'][platform][]"   type="text"  />';
      new_block += '</div><div class="d_telephone">';
      new_block += '<label class="control-label d_telephone_name account" >'+account+'</label>';
      new_block += '<input class="d_telephone_value form-control" name="distributor['+region_id+'][account][]"   type="text"  />';
      new_block += '</div>';
      new_block += '<div class="span span_plus add_platform_block" title="add">+</div>';
      new_block += '</div>';
      new_block += '</div>';
      new_block += '</div>';
      new_block += '</div>';
      obj.parent().parent().parent().parent().append(new_block);
});              
/*============添加整个地区模块结束==================*/

/*============品牌模块==================*/
$(".form-group").on("click",".brand .brand_letter ul li",function(){
    var obj = $(this);
    var index = obj.index();
    obj.siblings().removeClass("letter_current");
    obj.addClass("letter_current");
    $(".brand_name").find("ul li").eq(index).addClass("name_current").siblings().removeClass("name_current");
});
/*============品牌end==================*/

/*============地区联动start==================*/
$(".all_distributor").on("change","select",function(){
    var obj = $(this);
    var index_v = parseInt(obj.index())+1;
    var id_v =  '';
    id_v = obj.val();
    var class_v = obj.attr('class');
    var preg_p = /d_province/;
    var preg_c = /d_city/;
    var p_v = '';
    var please_select = $("#please_select").val();
    var str = '<option value="0">'+please_select+'</option>';
    if(preg_p.test(class_v)){
       p_v = 'p';
       obj.parent().find('select').eq(1).html(str);
       obj.parent().find('select').eq(2).html(str);
    }
    if(preg_c.test(class_v)){
       p_v = 'c';
       obj.parent().find('select').eq(2).html(str);
    }
    if(id_v <= 0 || p_v == '')
    {
      return false;
    }
    var url = $('#getarea').val();
    $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{ id:id_v,type:p_v },
        success:function(json)
        {
          var data = json.data;
          for (var i = 0; i < data.length; i++) {
            str += '<option value="'+data[i].id+'" title="'+data[i].en_name+'">'; 
            str += data[i].letter+':'+data[i].cn_name+data[i].en_name+"</option>"; 
          }
          obj.parent().find('select').eq(index_v).html(str); 
        }
    })
});
/*============地区联动end==================*/