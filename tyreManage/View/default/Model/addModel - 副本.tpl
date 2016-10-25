<include file="Public/header"/>
 <link rel="stylesheet" href="__STATIC__/css/users.css">
 <link rel="stylesheet" href="__STATIC__/css/group.css">
 <link rel="stylesheet" href="__STATIC__/css/model.css">
 <link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
 <link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {:L('ADMIN_MODEL')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Model/modelList')}"><i class="fa fa-th-large"></i> {:L('MODEL_MANAGE')}</a></li>
      <li><a href="{:U('Model/modelList')}">{:L('MODEL_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_MODEL')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('modelList')">class="active"</if>>
              <a href="{:U('Model/modelList')}">
                {:L('MODEL_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addModel')">class="active"</if>>
              <a href="{:U('Model/addModel')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_MODEL')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Model/addModel')}" method="post" id="form">
            <div class="tab-content">
              <div class="box-body">
                
                  <!-- 型号 -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_MODEL')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" value="{$data.model_name}" type="text" title="{:L('ADMIN_TIPS')}" name="data['model_name']" id="model"  />
                    </div>
                  </div>
                 
                  
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         
                      </label>
                      <div class="input-group col-sm-2 " id="is_import">
                          <input class="minimal" name="is_import" value="1" checked="checked" type="radio" /><span class="native">{:L('MADE_IN_CHINA')}</span>
                          <input class="minimal" name="is_import" value="2" type="radio" /><span class="native">{:L('ADMIN_IMPORT')}</span>
                          <input class="minimal" name="is_import" value="0" type="radio" /><span class="native">others</span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ENHANCE')}
                      </label>
                      <div class="input-group col-sm-2 " id="is_enhance">
                          <input class="minimal" name="is_enhance" value="1"  type="radio" /><span class="native">XL</span>
                          <input class="minimal" name="is_enhance" value="2" type="radio" /><span class="native">EL</span>
                          <input class="minimal" name="is_enhance" value="0" type="radio" checked="checked"/><span class="native">others</span>
                      </div>
                  </div>
                  <!-- 参数 -->
                  <div class="form-group">
                        <label class="col-sm-3 control-label">
                        	{:L('ADMIN_SPEC')}
                        </label>
                        <div class="input-group col-sm-3">
              							<div class="model_spec">
              								<input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="最大直径" />
              								<input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
              								<div class="fa fa-plus plus_para" ></div>
              							</div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="扁平率"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
                            </div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="负重指数"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
                            </div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="速度级别符号"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" value="W"/>
                            </div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="轮胎外径"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
                            </div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="断面宽度"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
                            </div>
                            <div class="model_spec">
                              <input class="form-control col-sm-2 param" name="param[]" placeholder="parameter" value="标准轮辋"/>
                              <input class="form-control col-sm-2 param" name="value[]" placeholder="value" />
                            </div>
                            
	                      </div>
                  </div><!-- //参数 -->

              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group " style="padding-bottom: 500px;">
                  <input type="hidden" value="save" name="save" id="save">
                  <input type="hidden" value="{$data.modelid}" id="modelid" name="data[modelid]">
                  <button type="button" id="save_data" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script type="text/javascript" src="__STATIC__/js/model.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     