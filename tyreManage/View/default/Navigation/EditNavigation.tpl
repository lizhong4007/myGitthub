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
      {:L('NAVIGATION')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Navigation/navigationList')}"><i class="fa fa-th-large"></i> {:L('SET_MANAGE')}</a></li>
      <li><a href="{:U('Navigation/navigationList')}">{:L('NAVIGATION_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('NAVIGATION')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('navigationList')">class="active"</if>>
              <a href="{:U('Navigation/navigationList')}">
                {:L('NAVIGATION')}{:L('ADMIN_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addNavigation')">class="active"</if>>
              <a href="{:U('Navigation/addNavigation')}">
                {:L('ADMIN_ADD')}{:L('NAVIGATION')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Navigation/addNavigation')}" method="post" id="form">
          <input type="hidden" value="{:U('Navigation/navigationList')}" id="nav_list" />
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('NAVIGATION')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="nav_name" id="name" value="{$data.nav_name}" type="text" title="{:L('ADMIN_TIPS')}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">controller</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[controller]" value="{$data.controller}" type="text"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">action</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[action]" value="{$data.action}" type="text"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_SORT')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" style="width:40%;" name="data[nav_order]" value="{$data.nav_order}" type="text"  />
                    </div>
                  </div>
                  <!-- <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_IMAGE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[thumb]" value="{$data.thumb}" id="image" type="text" readonly />
                          <span class="input-group-addon brand_input-group-addon">
                              <input type="hidden" value="Navigation" id="savedir" />
                              <span class="fileupload" data-callback="setImages" id="filepicker">
                              </span>
                          </span>
                      </div>
                  </div>
                  
                  图片
                  
                  <div class="brand_img" >
                      <img id="nav_logo" width="100" height="100" src="<if condition="$data['thumb'] neq ''">{:C('UPLOAD_FILE_URL')}{$data.thumb} </if>" />
                  </div> -->
                <!-- 弹框提示 -->
                <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save" id="save">
                  <input type="hidden" value="{$data.navid}" id="navid" name="data[navid]">
                  <button type="button" id="btn_save" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script src="__STATIC__/js/navigation.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     