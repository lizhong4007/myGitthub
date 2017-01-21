<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('NAVIGATION')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Navigation/navigationList')}"><i class="fa fa-th-large"></i> {:L('SET_MANAGE')}</a></li>
            <li><a href="{:U('Navigation/navigationList')}">{:L('NAVIGATION_LIST')}</a></li>
            <li class="active">{:L('NAVIGATION_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('navigationList')">class="active"</if>>
                    <a href="{:U('Navigation/navigationList')}">
                      {:L('NAVIGATION_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addNavigation')">class="active"</if>>
                    <a href="{:U('Navigation/addNavigation')}">
                      {:L('ADMIN_ADD')}{:L('NAVIGATION')}
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
                                <form action="{:U('Navigation/navigationList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('NAVIGATION')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$nav_name}" name="nav_name"  />
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
                                <th>{:L('NAVIGATION')}{:L('ADMIN_NAME')}</th>
                                <th>controller</th>
                                <th>action</th>
                                <th>{:L('ADMIN_SHOW')}</th>
                                <th>{:L('ADMIN_SORT')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <input type="hidden" value="{:U("Navigation/ajaxUpdate")}" id="nav_url" />
                            <tbody>
                              <foreach name="data" item="value">
                              <tr class="{$value.level}" id="{$value.catid}" data="down" data-pid="{$value.parentid}">
                                <td>{$value.navid}</td>
                               
                                <td >
                                    {:L(strtoupper($value['nav_name']))}
                                </td>
                                <td >
                                    {$value.controller}
                                </td>
                                <td>
                                    {$value.action}
                                </td>
                                <td class="show_state">
                                    <if condition="$value['is_show'] eq '0'">
                                        <a href="javascript:;" class="fa  fa-close text-red is_show" data="0" data-nav="{$value.navid}"></a>
                                    <else />
                                        <a href="javascript:;" class="fa  fa-check text-navy is_show" data="1" data-nav="{$value.navid}"></a>
                                    </if>
                                </td>
                                <td>
                                    {$value.nav_order}
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Navigation/addNavigation',array('navid'=>$value['navid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['navid']}" value="{:U('Navigation/deleteNavigation',array('navid'=>$value['navid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['navid']})" title="{:L('ADMIN_DELETE')}"></a>
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
<script src="__STATIC__/js/navigation.js"></script>
<script src="__STATIC__/js/jquery-confirm.js"></script>
<include file="Public/footer"/>