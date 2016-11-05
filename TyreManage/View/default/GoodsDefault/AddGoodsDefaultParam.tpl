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
      {:L('ADMIN_DEFAULT')}{:L('ADMIN_PARAMETER')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
      <li><a href="{:U('GoodsDefault/GoodsDefaultParamList')}">{:L('DEFAULT_PARAM_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_PARAMETER')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('GoodsDefaultParamList')">class="active"</if>>
              <a href="{:U('GoodsDefault/GoodsDefaultParamList')}">
                {:L('DEFAULT_PARAM_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('AddGoodsDefaultParam')">class="active"</if>>
              <a href="{:U('GoodsDefault/AddGoodsDefaultParam')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_PARAMETER')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('GoodsDefault/AddGoodsDefaultParam')}" method="post" id="form">
            <div class="tab-content">
            <input type="hidden" value="{:U('GoodsDefault/GoodsDefaultParamList')}" id="jump" />
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_CAT')}</label>
                    <div class="input-group col-sm-2">
                        <select class="form-control select2 category " id="category">
                            <option value="0">{:L('PLEASE_SELECT')}</option>
                            <foreach name="top_category" item="value">
                            <option <if condition="$data['catid'] eq $value['catid']">selected="selected"</if> value="{$value.catid}">{$value.cat_name}</option>
                            </foreach>
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_PARAMETER')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[param]" value="{$data.param}" type="text" title="{:L('ADMIN_TIPS')}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_LANGUAGE_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[en_param]" value="{$data.en_param}" type="text" title="{:L('ADMIN_TIPS')}" />
                    </div>
                  </div>
                  
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                 
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save" id="save" />
                  <input type="hidden" value="{$data.dparaid}" id="dparaid" />
                  <button type="button" id="btn_save" class="btn btn-primary" />{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script src="__STATIC__/js/defaultparam.js"></script>
<include file="Public/footer"/>
     