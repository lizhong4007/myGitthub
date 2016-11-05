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
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_BRAND')}</label>
                    <input type="hidden" name="data[brandid]" id="brandid" value="0" />
                    <div class="input-group col-sm-2">
                        <select class="form-control select2 brand">
                            <option value="0" selected="selected">{:L('PLEASE_SELECT')}</option>
                            <foreach name="brand" item="value">
                            <option value="{$value.brandid}">{$value.brand_name}</option>
                            </foreach>
                        </select>
                    </div>
                  </div>
                  <input type="hidden" id="please_select" value="{:L('PLEASE_SELECT')}"/>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('COMPANY')}</label>
                    <input type="hidden" name="data[companyid]" id="companyid" value="0" />
                    <div class="input-group col-sm-2">
                        <select class="form-control select2 company">
                            <option value="0" selected="selected">{:L('PLEASE_SELECT')}</option>
                            <foreach name="company" item="value">
                            <option value="{$value.companyid}">{$value.company_name}</option>
                            </foreach>
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_CAT')}</label>
                    <input type="hidden" id="catid" name="data[catid]" value="0" />
                    <input type="hidden" id="category_url"value="{:U("Series/getSubCategory")}" />
                    <div class="input-group col-sm-7">
                        <select class="form-control select2 category ">
                            <option value="0" selected="selected">{:L('PLEASE_SELECT')}</option>
                            <foreach name="top_category" item="value">
                            <option value="{$value.catid}">{$value.cat_name}</option>
                            </foreach>
                        </select>
                    </div>
                  </div>
                  <!-- 系列 -->
                   <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_SERIES')}{:L('ADMIN_NAME')}</label>
                    <input type="hidden" value="{:U('Model/getSeries')}" id="series_url" />
                    <input type="hidden" value="0" id="seriesid" />
                    <div class="input-group col-sm-7">
                        <select class="form-control select2 series" id="series_data" style="width: 30%;" name="data[seriesid]">
                            <option value="0" selected="selected">{:L('PLEASE_SELECT')}</option>
                        </select>
                    </div>
                  </div>
                  <!-- 型号 -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_MODEL')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" value="{$data.model_name}" type="text" title="{:L('ADMIN_TIPS')}" name="data['model_name']" id="model"  />
                    </div>
                  </div>
                  <!-- 图片 -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_IMAGE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[org_thumb]" value="" id="org_thumb" type="text" />
                          <span class="input-group-addon brand_input-group-addon">
                              <input type="hidden" value="goods" id="savedir" />
                              <span class="fileupload" data-callback="setImages" id="filepicker">
                              </span>
                          </span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('THUMBNAIL')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[thumb]" value="" id="thumb" type="text" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('OFFICIAL_WEBSITE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[official]" value="" id="official" type="text" />
                      </div>
                  </div>
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                  <div class="brand_img" >
                      <img id="series_logo" width="100" height="100" src="<if condition="$data['thumb'] neq ''">{$site_imagedomain}{$data.thumb}</if>" />
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
                <div class="input-group ">
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
     