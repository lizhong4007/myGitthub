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
.series_tread{
  margin-bottom: 10px;
}
.series_tread_l{
  width: 20%;
  float: left;
}
.series_tread_c{
  float: left;
  width: 100px;
}
.series_tread .series_tread_r{
  width: 20%;
  float: left;
  margin-left: 10px;
}
.series_tread .fa{
  cursor: pointer;
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
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_TREAD')}</li>
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
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addSeriesTread')">class="active"</if>>
              <a href="#">
                {:L('ADMIN_ADD')}{:L('ADMIN_TREAD')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Series/addSeriesTread')}" method="post">
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_SERIES')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" value="{$series.series_name}" type="text" title="{:L('ADMIN_TIPS')}" disabled />
                    </div>
                  </div>
                  
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('IMAGE_SELECT')}" id="content_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_TREAD')}
                      </label>
                      <div class="input-group col-sm-9 ">
                          <div class="col-sm-12 row">
                              <input type="hidden" value="resource" id="savedir" />
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image0" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread0" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image1" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread1" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image2" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread2" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image3" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread3" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image4" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread4" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image5" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread5" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>
                              <div class="input-group col-sm-12 series_tread">
                                  <div class="series_tread_l">
                                  <!-- 图片 -->
                                  <input class="form-control"  name="thumb[]" value="" id="image6" type="text" />
                                  </div>
                                  <div class="series_tread_c">
                                  <span class="input-group-addon brand_input-group-addon" >
                                      <span class="fileupload" data-callback="setTread6" id="filepicker">
                                      </span>
                                  </span>
                                  </div>
                                  <!-- 内容 -->
                                  <div class="series_tread_r">
                                  <textarea name="content[]" title="{:L('ADMIN_CONTENT')}" rows="1"></textarea>
                                  </div>
                              </div>

                              <!-- //花纹 -->
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save">
                  <input type="hidden" value="{$series.seriesid}" name="series_id">
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


<script type="text/javascript" src="__STATIC__/js/series.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     