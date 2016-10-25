<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_GROUP')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Users/usersList')}"><i class="fa fa-key"></i> {:L('ADMIN_PERMISSION_MANAGE')}</a></li>
            <li><a href="{:U('Groups/groupList')}">{:L('ADMIN_GROUP')}</a></li>
            <li class="active">{:L('ADMIN_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('groupList')">class="active"</if>>
                    <a href="{:U('Groups/groupList')}">
                      {:L('ADMIN_GROUP')}{:L('ADMIN_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addGroup')">class="active"</if>>
                    <a href="{:U('Groups/addGroup')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_GROUP')}
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="fa-icons">
                    <section id="new">
                      <!-- <div class="col-xs-12"> -->
                      <div class="box">
                        <!-- <div class="box-header">
                          <h3 class="box-title">Hover Data Table</h3>
                        </div> --><!-- /.box-header -->
                        <div class="box-body">
                          <table id="example2" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>{:L('ADMIN_GROUP')}{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_GROUP')}{:L('ADMIN_DESCRIPTION')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr>
                                <td>{$value.groupid}</td>
                                <td>{$value.group_name}</td>
                                <td>{$value.description}</td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Groups/addGroup',array('groupid'=>$value['groupid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['groupid']}" value="{:U('Groups/deleteGroup',array('groupid'=>$value['groupid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['groupid']})" title="{:L('ADMIN_DELETE')}"></a>
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