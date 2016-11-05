$(function(){    
    $(".form-group").on("change",".category",function(){
      var obj = $(this);
      var parent_catid = obj.val();
      $("#catid").val(parent_catid);
      obj.nextAll().remove();
      var url = $("#category_url").val();
      var please_select = $("#please_select").val();
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
        })
    });
    $(".form-group").on("change",".company",function(){
        var obj = $(this);
        $("#companyid").val(obj.val());
    });
    $("#save_data").on("click",function(){
        var url = $("#form").attr("action");
        var catid = $("#catid").val();
        var brandid = $("#brandid").val();
        var companyid = $("#companyid").val();
        var title = $('#title_note').val();
        var series_url = $('#series_url').val();
        $.ajax({
            type: "post",
            dataType: 'json',
            data: $("#form").serialize(),
            url: url,
            success: function (json) {
                alert_message(title,json.message);
                if(json.code == 1)
                {
                   window.location.href = series_url;
                }
            }
        })
    });
});
function setImages(json)
{
    if(json.flag == 1)
    { 
        var image_host = $("#image_site").val();
        $('#series_logo').attr('src',image_host+json.message);
        $('#image').val(json.message);
        $('#thumb').val(json.thumb);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}

function setTread0(json)
{
    if(json.flag == 1)
    { 
        $('#image0').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread1(json)
{
    if(json.flag == 1)
    { 
        $('#image1').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread2(json)
{
    if(json.flag == 1)
    { 
        $('#image2').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread3(json)
{
    if(json.flag == 1)
    { 
        $('#image3').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread4(json)
{
    if(json.flag == 1)
    { 
        $('#image4').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread5(json)
{
    if(json.flag == 1)
    { 
        $('#image5').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
function setTread6(json)
{
    if(json.flag == 1)
    { 
        $('#image6').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}