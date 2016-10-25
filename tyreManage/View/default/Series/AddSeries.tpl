<include file="Public/header"/>
 <link rel="stylesheet" href="__STATIC__/css/users.css">
 <link rel="stylesheet" href="__STATIC__/css/group.css">
 <link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
 <link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
.category{
  width: 20% !important;
  margin-right: 5px;
}
</style>
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {:L('ADMIN_SERIES')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Model/modelList')}"><i class="fa fa-th-large"></i> {:L('MODEL_MANAGE')}</a></li>
      <li><a href="{:U('Series/seriesList')}">{:L('SERIES_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_SERIES')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('seriesList')">class="active"</if>>
              <a href="{:U('Series/seriesList')}">
                {:L('SERIES_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addSeries')">class="active"</if>>
              <a href="{:U('Brand/brandList')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_SERIES')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Series/addSeries')}" method="post" id="form">
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_BRAND')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" value="{$brand.brand_name}" type="text" title="{:L('ADMIN_TIPS')}" disabled />
                      <input id="brandid" name="data[brandid]" value="{$brand.brandid}" type="hidden"/>
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
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_SERIES')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[series_name]" value="" type="text" title="{:L('ADMIN_TIPS')}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_LANGUAGE_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[series_alias]" value=""type="text"  />
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_IMAGE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[org_thumb]" value="" id="image" type="text" readonly />
                          <span class="input-group-addon brand_input-group-addon">
                              <input type="hidden" value="series" id="savedir" />
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
                          <input class="form-control" name="data[thumb]" value="" id="thumb" type="text" readonly />
                      </div>
                  </div>
                  
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                  <div class="brand_img" >
                      <img id="series_logo" width="100" height="100" src="<if condition="$data['thumb'] neq ''">{:C('UPLOAD_FILE_URL')}{$data.thumb}</if>" />
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_DESCRIPTION')}
                      </label>
                      <div class="input-group col-sm-4 ">
                        <textarea class="form-control" name="data[content]" ></textarea>
                      </div>
                  </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save">
                  <input type="hidden" value="{$data.seriesid}" name="data[seriesid]">
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
<script type="text/javascript" src="__STATIC__/js/series.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     