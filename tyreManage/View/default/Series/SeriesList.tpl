<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
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
            <li class="active">{:L('SERIES_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
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
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="fa-icons">
                    <section id="new">
                      <!-- <div class="col-xs-12"> -->
                      <div class="box">
                        <div class="box-header">
                            <div class="category">
                                <form action="{:U('Series/seriesList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('ADMIN_SERIES')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$seriesname}" name="seriesname"  />
                                        </li>
                                        <li>
                                            <input type="hidden" value="searched" name="searched" />
                                            <input type="submit" value="{:L('ADMIN_SEARCH')}" />
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                          <table id="example2" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>{:L('ADMIN_ID')}</th>
                                <th>{:L('ADMIN_IMAGE')}</th>
                                <th>{:L('ADMIN_SERIES')}</th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('FIRST_LETTER')}</th>
                                <th>linkurl</th>
                                <th>{:L('ADMIN_BRAND')}</th>
                                <th>{:L('ADMIN_CAT')}</th>
                                <th>{:L('COMPANY')}</th>
                                <th>{:L('ADMIN_MODEL')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr >
                                <td>{$value.seriesid}</td>
                                <td >
                                    <if condition="$value.thumb neq ''">
                                    <a href="{$site_imagedomain}{$value.thumb}">
                                    <img src="{$site_imagedomain}{$value.thumb}" width="100" height="60" />
                                    </a>
                                    </if>
                                </td>
                                <td >{$value.series_name}</td>
                                <td >{$value.series_alias}</td>
                                <td >{$value.letter}</td>
                                <td >{$value.linkurl}</td>
                                <td >{$value.brandid}</td>
                                <td >{$category[$value['catid']]['cat_name']}</td>
                                <td >{$value.companyids}</td>
                                <td >
                                 <a  href="{:U('Model/modelList',array('seriesid'=>$value['seriesid']))}" title="{:L('ADMIN_MODEL')}">
                                 {:L('ADMIN_CHECK')}
                                 </a>
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Series/updateSeries',array('seriesid'=>$value['seriesid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <a class="fa fa-plus text-navy" href="{:U('Series/addSeriesTread',array('seriesid'=>$value['seriesid']))}" title="{:L('ADMIN_ADD')}{:L('ADMIN_TREAD')}"></a>
                                </td>
                              </tr>
                              </foreach>
                            </tbody>
                          </table>
                        </div><!-- /.box-body -->
                          <include file="Public/page"/>
                      </div><!-- /.box -->
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div><!-- /.content-wrapper -->
<script src="__STATIC__/js/category.js"></script>
<script src="__STATIC__/js/jquery-confirm.js"></script>
<include file="Public/footer"/>