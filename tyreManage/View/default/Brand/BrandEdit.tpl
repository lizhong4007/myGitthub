<include file="Public/header"/>
 <link rel="stylesheet" href="__STATIC__/css/users.css">
 <link rel="stylesheet" href="__STATIC__/css/group.css">
 <link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
 <link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {:L('ADMIN_BRAND')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
      <li><a href="{:U('Brand/brandList')}">{:L('BRANDS_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_BRAND')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('BrandList')">class="active"</if>>
              <a href="{:U('Brand/brandList')}">
                {:L('ADMIN_BRAND')}{:L('ADMIN_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('AddBrand')">class="active"</if>>
              <a href="{:U('Brand/addBrand')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_BRAND')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Brand/addBrand')}" method="post" onsubmit="return checkForm()">
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_BRAND')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[brand_name]" id="name" value="{$data.brand_name}" type="text" title="{:L('ADMIN_TIPS')}" />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_LANGUAGE_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[brand_alias]" value="{$data.brand_alias}" id="en_name" type="text"  />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_IMAGE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[thumb]" value="{$data.thumb}" id="image" type="text" readonly />
                          <span class="input-group-addon brand_input-group-addon">
                              <input type="hidden" value="brand" id="savedir" />
                              <span class="fileupload" data-callback="setImages" id="filepicker">
                              </span>
                          </span>
                      </div>
                  </div>
                  
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                  <div class="brand_img" >
                      <img id="brand_logo" width="100" height="100" src="<if condition="$data['thumb'] neq ''">{:C('UPLOAD_FILE_URL')}{$data.thumb} </if>" />
                  </div>
                  
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_DESCRIPTION')}
                      </label>
                      <div class="input-group col-sm-4 ">
                        <textarea class="form-control" name="data[content]" >{$data.content}</textarea>
                      </div>
                  </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save">
                  <input type="hidden" value="{$data.brandid}" name="data[brandid]">
                  <button type="submit" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script type="text/javascript">
function setImages(json)
{
    if(json.flag == 1)
    { 
        var image_host = "{:C('UPLOAD_FILE_URL')}";
        $('#brand_logo').attr('src',image_host+json.message);
        $('#image').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }

}
</script>
<script src="__STATIC__/js/brand.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     