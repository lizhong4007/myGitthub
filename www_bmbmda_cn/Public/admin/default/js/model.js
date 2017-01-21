$(function(){    
    $(".form-group").on("change",".category",function(){
      var please_select = $("#please_select").val();
      var title = $('#title_note').val();
      var brandid = $('#brandid').val();
      brandid = parseInt(brandid);
      if(brandid <= 0)
      {
         alert_message(title,please_select+'brand');
         return false;
      }
      var obj = $(this);
      var parent_catid = obj.val();
      $("#catid").val(parent_catid);
      parent_catid = parseInt(parent_catid);
      if(parent_catid <= 0)
      {
         alert_message(title,please_select+'category');
         return false;
      }
      obj.nextAll().remove();
      var url = $("#category_url").val();
      $.ajax({
            type: "post",
            dataType: 'json',
            data: {parent_catid:parent_catid},
            url: url,
            success: function (json) {
                if(json.code == 1)
                {
                    var data = json.sub_category;
                    var str = '';
                    str += '<select class="form-control select2 category">';
                    str += '<option value="0">'+please_select;
                    str += '</option>';
                    for (var i = 0; i < data.length; i++) {
                       str += '<option value="'+data[i].catid+'">';
                       str += data[i].cat_name;
                       str += '</option>';
                    }
                    str += '</select>';
                    obj.parent().append(str);
                }
            }
        });
        /*系列*/
        var series_url = $('#series_url').val();
        $.ajax({
            type: "post",
            dataType: 'json',
            data: {parent_catid:parent_catid,brandid:brandid},
            url: series_url,
            success: function (json) {
                if(json.code == 1)
                {
                    var data = json.data;
                    var str = '';
                    str += '<select class="form-control select2 category">';
                    str += '<option value="0">'+please_select;
                    str += '</option>';
                    for (var i = 0; i < data.length; i++) {
                       str += '<option value="'+data[i].seriesid+'">';
                       str += data[i].series_name;
                       str += '</option>';
                    }
                    str += '</select>';
                    $('#series_data').html(str);
                }
            }
        });
    });
    
    $(".form-group").on("click",".plus_para",function(){
        var obj = $(this);
        var str = '<div class="model_spec">';
        str += '<input class="form-control col-sm-2 param" name="param[]" placeholder="parameter"  type="text"/>';
        str += '<input class="form-control col-sm-2 param" name="value[]" placeholder="value" type="text"/>';
        str += '<div class="fa fa-close minus_para"></div>';
        str += '</div>';
        obj.parent().parent().append(str);
    });
    $(".form-group").on("click",".minus_para",function(){
        var obj = $(this);
        obj.parent().remove();
    });

    $(".form-group").on("change",".brand",function(){
        var obj = $(this);
        var brandid = obj.val();
        $('#brandid').val(brandid);
    });
    $(".form-group").on("change",".company",function(){
        var obj = $(this);
        $("#companyid").val(obj.val());
    });
    $(".form-group").on("change",".series",function(){
        var obj = $(this);
        $("#seriesid").val(obj.val());
    });
    //表单提交
    $(".form-group").on("click","#save_data",function(){
        var url = $('#form').attr('action');
        var title = $('#title_note').val();
        var $param = new Array();
        $.each( $("input[name^='param']"), function(i, n){
                    $param.push($(n).val());
            });
        var $param_value = new Array();
        $.each( $("input[name^='value']"), function(i, n){
                    $param_value.push($(n).val());
            });
        var brandid = $('#brandid').val();
        var companyid = $('#companyid').val();
        var catid = $('#catid').val();
        var seriesid = $('#seriesid').val();
        var thumb = $('#thumb').val();
        var org_thumb = $('#org_thumb').val();
        var model = $('#model').val();
        var save_data = $('#save').val();
        var modelid = $('#modelid').val();
        var official = $('#official').val();
        var is_import = $('#is_import input:radio:checked').val();
        var is_enhance = $('#is_enhance input:radio:checked').val();
        var model_url = $('#model_url').val();
        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
              brandid:brandid,
              companyid:companyid,
              catid:catid,
              seriesid:seriesid,
              thumb:thumb,
              org_thumb:org_thumb,
              param:$param,
              value:$param_value,
              model:model,
              official:official,
              save:save_data,
              modelid:modelid,
              is_import:is_import,
              is_enhance:is_enhance,
            },
            url: url,
            success: function (json) {
                if(json.code == 1)
                {
                   window.location.href = model_url;
                }else{
                   alert_message(title,json.message);
                   return false;
                }
            }
        });
    });

});
function setImages(json)
{
    if(json.flag == 1)
    { 
        var image_host = $("#image_site").val();
        $('#series_logo').attr('src',image_host+json.message);
        $('#org_thumb').val(json.message);
        $('#thumb').val(json.thumb);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}