<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('DISTRIBUTOR')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Company/companyList')}"><i class="fa fa-th-large"></i> {:L('COMPANY_MANAGE')}</a></li>
            <li><a href="{:U('CompanyDistributor/companyDistributorList')}">{:L('COMPANY_DISTRIBUTOR_LIST')}</a></li>
            <li class="active">{:L('COMPANY_DISTRIBUTOR_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('companyDistributorList')">class="active"</if>>
                    <a href="{:U('CompanyDistributor/companyDistributorList')}">
                      {:L('COMPANY_DISTRIBUTOR_LIST')}
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
                                <form action="{:U('CompanyDistributor/companyDistributorList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('DISTRIBUTOR')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$companyDistributorname}" name="companyDistributorname"  />
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
                                <th>{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_SITE')}</th>
                                <th>{:L('DEAIL_ADDRESS')}</th>
                                <th>{:L('ADMIN_TELEPHONE')}</th>
                                <th>{:L('ADMIN_CONTANCT')}</th>
                                <th>fax</th>
                                <th style="width:200px;">email</th>
                                <th>{:L('ADMIN_PLATFORM')}</th>
                                <th>{:L('ADMIN_ACCOUNT')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr >
                                <td>{$value.distributorid}</td>
                                <td >
                                    {$value.distributor_name}
                                </td>
                                <td >
                                    {$value.site}
                                </td>
                                <td >
                                   {:preg_replace('/,/','<br />',$value['address'])}
                                </td>
                                <td >{:preg_replace('/,/','<br />',$value['telephone'])}</td>
                                <td >{:preg_replace('/,/','<br />',$value['contacts'])}</td>
                                <td>{:preg_replace('/,/','<br />',$value['fax'])}</td>
                                <td>{:preg_replace('/,/','<br />',$value['email'])}</td>
                                <td>{:preg_replace('/,/','<br />',$value['platform'])}</td>
                                <td>{:preg_replace('/,/','<br />',$value['account'])}</td>
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