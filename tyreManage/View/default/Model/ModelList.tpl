<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
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
            <li class="active">{:L('MODEL_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
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
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="fa-icons">
                    <section id="new">
                      <!-- <div class="col-xs-12"> -->
                      <div class="box">
                        <div class="box-header">
                            <div class="category">
                                <form action="{:U('Model/modelList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('ADMIN_MODEL')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$modelname}" name="modelname"  />
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
                                <th>{:L('ADMIN_MODEL')}</th>
                                <th>{:L('ADMIN_IMAGE')}</th>
                                <th>linkurl</th>
                                <th>{:L('ADMIN_BRAND')}</th>
                                <th>{:L('ADMIN_CAT')}</th>
                                <th>{:L('ADMIN_SERIES')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr >
                                <td>{$value.modelid}</td>
                                <td >
                                    {$value.model_name}
                                </td>
                                <td >
                                    <if condition="$value.thumb neq ''">
                                    <a href="{$site_imagedomain}{$value.thumb}">
                                    <img src="{$site_imagedomain}{$value.thumb}" width="100" height="60" />
                                    </a>
                                    </if>
                                </td>
                                <td >{$value.linkurl}</td>
                                <td >{$value.brandid}</td>
                                <td >{$value.catid}</td>
                                <td >{$value.seriesid}</td>
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