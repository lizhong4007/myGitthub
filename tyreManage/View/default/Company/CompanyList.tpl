<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('COMPANY')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Company/companyList')}"><i class="fa fa-th-large"></i> {:L('COMPANY_MANAGE')}</a></li>
            <li><a href="{:U('Company/companyList')}">{:L('COMPANY_LIST')}</a></li>
            <li class="active">{:L('COMPANY_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('companyList')">class="active"</if>>
                    <a href="{:U('Company/companyList')}">
                      {:L('COMPANY_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addCompany')">class="active"</if>>
                    <a href="{:U('Company/addCompany')}">
                      {:L('ADMIN_ADD')}{:L('COMPANY')}
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
                                <form action="{:U('Company/companyList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('COMPANY')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$companyname}" name="companyname"  />
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
                                <th>{:L('COMPANY')}{:L('ADMIN_NAME')}
                                </th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('MANAGEMENT_MODEL')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr class="{$value.level}" id="{$value.catid}" data="down" data-pid="{$value.parentid}">
                                <td>{$value.companyid}</td>
                                <td>
                                    <if condition="$value.thumb neq ''">
                                    <a href="{$value.thumb}">
                                    <img src="{$value.thumb}" width="100" height="60" />
                                    </a>
                                    </if>
                                </td>
                                <td >
                                    {$value.company_name}
                                </td>
                                <td >
                                    {$value.company_alias}
                                </td>
                                <td >
                                    <foreach name="MANAGEMENT_MODEL" item="model">
                                        <if condition="in_array(strtolower($model),explode(',',$value['operation_mode']))">
                                        {:L(strtoupper($model))},
                                        </if>
                                    </foreach>
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Company/addCompany',array('company_id'=>$value['companyid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['companyid']}" value="{:U('Company/deleteCompany',array('company_id'=>$value['companyid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['companyid']})" title="{:L('ADMIN_DELETE')}"></a>
                                </td>
                              </tr>
                              </foreach>
                              <input type="hidden" id="note_title" value="{:L(ADMIN_TITLE)}" />
                              <input type="hidden" id="note_content" value="{:L(ADMIN_DELETE_OR)}" />
                              <input type="hidden" id="note_sure" value="{:L(ADMIN_CONFIRM)}" />
                              <input type="hidden" id="note_cancel" value="{:L(ADMIN_CANCEL)}" />
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