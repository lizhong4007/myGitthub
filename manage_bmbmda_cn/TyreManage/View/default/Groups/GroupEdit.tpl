<include file="Public/header"/>
 <link rel="stylesheet" href="__STATIC__/css/users.css">
 <link rel="stylesheet" href="__STATIC__/css/group.css">
 <link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
 <link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
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
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_GROUP')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
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
            <form class="form-horizontal" action="{:U('Groups/addGroup')}" method="post" onsubmit="return checkForm()">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[name]" id="name" value="{$data.group_name}" type="text" title="{:L('ADMIN_TIPS')}" />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_DESCRIPTION')}</label>
                    <div class="input-group col-sm-4">
                      <textarea class="form-control" name="data[description]">{$data.description}</textarea>
                      <script type="text/javascript">
                        $(function(){
                           CKEDITOR.replace("data[description]");
                        })
                      </script>
                    </div>
                  </div>

                  <div  class="form-group ">
                    <foreach name="navigation" item="nav">
                      <div class="col-sm-6">
                          <label class="control-label checkbox_title" >
                            {:L($nav['title'])}
                          </label><br />
                          <foreach name="nav['controller']" key="controller" item="action">
                            <div class="input-group  checkbox_little_title">
                                <div class="control-label col-sm-2 small_title">
                                  {:L($action['lists'])}:
                                </div>
                                <div class="col-sm-9">
                                  <ul class="checkbox_ul">
                                      <foreach name="action['action']" key="method" item="value">
                                          <li >
                                              <input type="checkbox" name="permission[]" value="{:strtolower($controller)}_{:strtolower($method)}" class="minimal" <if condition="in_array(strtolower($controller).'_'.strtolower($method),$data['permissions'])">checked</if>>
                                              <label>{:L($value)}</label>
                                          </li>
                                      </foreach>
                                  </ul>
                              </div>
                            </div>
                          </foreach>
                      </div>
                      </foreach>
                      <div class="col-sm-6 checkbox_under"></div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="input-group ">
                    <input type="hidden" value="save" name="save">
                    <input type="hidden" value="{$data.groupid}" name="data[groupid]">
                    <span><input class="minimal" type="checkbox" id="checkAlls"  />{:L('ADMIN_SELECTALL')}</span>
                    <button type="submit" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  </div>
                </div>
              </div><!-- /.box-footer -->
            </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script src="__STATIC__/js/group.js"></script>
<include file="Public/footer"/>
     