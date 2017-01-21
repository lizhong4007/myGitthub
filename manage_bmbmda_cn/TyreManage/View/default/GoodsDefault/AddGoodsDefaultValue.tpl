<include file="Public/header"/>
 <link rel="stylesheet" href="__STATIC__/css/users.css">
 <link rel="stylesheet" href="__STATIC__/css/group.css">
 <link rel="stylesheet" href="__STATIC__/css/defaultparam.css">
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
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_PARAMETER')}{:L('ADMIN_VALUE')}</li>
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
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('AddGoodsDefaultValue')">class="active"</if>>
              <a href="{:U('GoodsDefault/GoodsDefaultParamList')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_PARAMETER')}{:L('ADMIN_VALUE')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('GoodsDefault/AddGoodsDefaultValue')}" method="post" id="form">
            <div class="tab-content">
            <input type="hidden" value="{:U('GoodsDefault/GoodsDefaultParamList')}" id="jump" />
            <input type="hidden" value="{:L('ADMIN_CHECK')}-{$param_data.param}({$param_data.en_param}/{$param_data.dparaid})" id="success_note" />
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_PARAMETER')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[param]" value="{$param_data.param}({$param_data.en_param})" type="text" title="{:L('ADMIN_TIPS')}" />
                      <input type="hidden" value="{$param_data.dparaid}" id="dparaid" />
                    </div>
                  </div>
                  <!-- 参数 -->
                  <div class="form-group">
                        <label class="col-sm-3 control-label">
                          
                        </label>
                        <div class="input-group col-sm-2">
                            <div class="model_spec">
                              <!-- <input class="form-control col-sm-2 param" name="dvid[]" type="hidden"/> -->
                              <input class="form-control param" value="{:L('ADMIN_PARAMETER')}{:L('ADMIN_VALUE')}" disabled="disabled"/>
                              <div class="fa fa-plus plus_para" ></div>
                            </div>
                        <foreach name="value_data" item="v">
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="dvid[]" type="hidden" value="{$v.dvid}" />
                              <input class="form-control col-sm-2 param" name="value[]" value="{$v.value}" type="text"/>
                              <!-- <div class="fa fa-close minus_para"></div> -->
                             </div>
                        </foreach>
                        </div>
                  </div><!-- //参数 -->
                  
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
                  <button type="button" id="btn_save_value" class="btn btn-primary" />{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script type="text/javascript"  src="__STATIC__/js/defaultparam.js"></script>
<include file="Public/footer"/>
     