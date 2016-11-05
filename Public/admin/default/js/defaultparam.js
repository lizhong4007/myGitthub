$('#btn_save').on('click',function(){
  var url = $('#form').attr('action');
  var param_name = $('input[name^="data[param]"]').val();
  var en_name = $('input[name^="data[en_param]"]').val();
  var category = $('#category').val();
  var dparaid = $('#dparaid').val();
  var title = $('#title_note').val();
  var save = $('#save').val();
  var jump = $('#jump').val();
  $.ajax({
      url:url,
      type:'post',
      dataType:'json',
      data:{
          param:param_name,
          en_param:en_name,
          catid:category,
          dparaid:dparaid,
          save:save,
      },
      success:function(json){
        alert_message(title,json.message);
        if(json.code == 1)
        {
          window.location.href = jump;
        }else{
          $("#btn_submit").attr("disabled", false); 
          return false;
        }
      }
    });
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

$(function(){
    $(".form-group").on("click",".plus_para",function(){
        var obj = $(this);
        var str = '<div class="model_spec">';
        str += '<input class="form-control col-sm-2 param" name="dvid[]" type="hidden"/>';
        str += '<input class="form-control col-sm-2 param" name="value[]" placeholder="value" type="text"/>';
        str += '<div class="fa fa-close minus_para"></div>';
        str += '</div>';
        obj.parent().parent().append(str);
    });
    $(".form-group").on("click",".minus_para",function(){
        var obj = $(this);
        obj.parent().remove();
    });
    //参数值表单提交
    $(".form-group").on("click","#btn_save_value",function(){
        var url = $('#form').attr('action');
        var title = $('#title_note').val();
        var $dvid = new Array();
        $.each( $("input[name^='dvid']"), function(i, n){
                    $dvid.push($(n).val());
            });
        var $param_value = new Array();
        $.each( $("input[name^='value']"), function(i, n){
                    $param_value.push($(n).val());
            });
        var dparaid = $('#dparaid').val();
        var save_data = $('#save').val();
        var jump = $('#jump').val();
        var success_note = $('#success_note').val();
        var note = "please "+success_note;
        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
              value:$param_value,
              save:save_data,
              dvid:$dvid,
              dparaid:dparaid,
            },
            url: url,
            success: function (json) {
                alert_message(title,note);
                window.location.href = jump;
               
            }
        });
    });
});