<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_CARS')}{:L('ADMIN_MATCH')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Model/modelList')}"><i class="fa fa-th-large"></i> {:L('MODEL_MANAGE')}</a></li>
            <li><a href="{:U('ModelCars/modelCarsList')}">{:L('MODEL_CARS_LIST')}</a></li>
            <li class="active">{:L('MODEL_CARS_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('modelCarsList')">class="active"</if>>
                    <a href="{:U('ModelCars/modelCarsList')}">
                      {:L('MODEL_CARS_LIST')}
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
                                <form action="{:U('ModelCars/modelCarsList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('ADMIN_NAME')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$modelcarsname}" name="modelcarsname"  />
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
                                <th>{:L('ADMIN_SERIES')}</th>
                                <th>{:L('ADMIN_BRAND')}</th>
                                <th>{:L('COMPANY')}</th>
                                <th>carids</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr >
                                <td>{$value.id}</td>
                                <td >{$value.model_name}({$value.modelid})</td>
                                <td >{$value.series_name}({$value.seriesid})</td>
                                <td >{$value.brand_name}({$value.brandid})</td>
                                <td >{$value.company_name}({$value.companyid})</td>
                                <td >{$value.carsids}</td>
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