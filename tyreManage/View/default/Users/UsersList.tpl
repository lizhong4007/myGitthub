<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_MANAGERS')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Users/usersList')}"><i class="fa fa-key"></i> {:L('ADMIN_PERMISSION_MANAGE')}</a></li>
            <li><a href="{:U('Users/usersList')}">{:L('ADMIN_MANAGERS')}</a></li>
            <li class="active">{:L('ADMIN_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('usersList')">class="active"</if>>
                    <a href="{:U('Users/usersList')}">
                      {:L('ADMIN_MANAGERS')}{:L('ADMIN_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addUsers')">class="active"</if>>
                    <a href="{:U('Users/addUsers')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_MANAGERS')}
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
                                <th>{:L('ADMIN_USERS')}{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_USERS')}{:L('ADMIN_GROUP')}</th>
                                <th>{:L('ADMIN_LASTREGTIME')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="data" item="value">
                              <tr>
                                <td>{$value.userid}</td>
                                <td>{$value.user_name}</td>
                                <td>
                                    <if condition="$value['groupid'] == 0">
                                    Administrator
                                    <else />
                                        {$group[$value['groupid']]['group_name']}
                                    </if>
                                </td>
                                <td>{:date('Y-m-d h:i:s',$value['log_last_time'])}</td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Users/addUsers',array('mid'=>$value['userid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['userid']}" value="{:U('Users/deleteUsers',array('mid'=>$value['userid']))}"/>
                                  <input type="hidden" id="note_title" value="{:L(ADMIN_TITLE)}" />
                                  <input type="hidden" id="note_content" value="{:L(ADMIN_DELETE_OR)}" />
                                  <input type="hidden" id="note_sure" value="{:L(ADMIN_CONFIRM)}" />
                                  <input type="hidden" id="note_cancel" value="{:L(ADMIN_CANCEL)}" />
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['userid']})" title="{:L('ADMIN_DELETE')}"></a>
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