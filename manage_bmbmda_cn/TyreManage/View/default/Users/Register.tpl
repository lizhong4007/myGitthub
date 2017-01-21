<include file="Public/header"/>
<link rel="stylesheet" href="__STATIC__/css/users.css">
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
            <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_MANAGERS')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" >
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
                  <div class="-box box-info">
                    <div class="register-box">
                        <div class="register-box-body">
                          <!-- <p class="login-box-msg">{:L('ADMIN_REGMEMBER')}</p> -->
                    <!-- form start -->
                          <form class="form-horizontal" action="{:U('Users/addUsers')}" method="post" onsubmit="return checkForm()">
                              <div class="box-body">
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label">{:L('ADMIN_NAME')}</label>
                                      <div class="input-group">
                                        <input class="form-control" name="data[name]" value="{$data.user_name}" id="name" type="text" title="{:L('ADMIN_TIPS')}" />
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                      </div>
                                    </div>
                                  <div class="form-group">
                                      <label  class="col-sm-3 control-label">{:L('ADMIN_PASSWORD')}</label>
                                      <div class="input-group">
                                        <if condition="$data['userid'] eq ''">
                                        <input class="form-control" type="password" name="data[password]" id="password"title="{:L('ADMIN_TIPS')}" />
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <else />
                                        <input class="form-control" type="password"id="resetpassword" name="data[password]" value="{$data.password}" disabled="true" />
                                        <span class="input-group-addon" id="reset">{:L('ADMIN_RESET')}</span>
                                        </if>
                                        
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-sm-3 control-label">{:L('ADMIN_GROUP')}</label>
                                      <div class="input-group col-sm-9">
                                          <select class="form-control" name="data[groupid]">
                                              <foreach name="group" key="key" item="value">
                                                  <option value="{$key}" >{$value.group_name}</option>
                                              </foreach>
                                          </select>
                                      </div>
                                  </div>
                            </div>
                            <div class="box-footer">
                              <div class="row">
                                <div class="col-xs-4" >
                                  <button type="reset" class="btn btn-primary btn-block btn-flat">{:L('ADMIN_RESET')}</button>
                                </div>
                                <div class="col-xs-4">
                                  <input type="hidden" value="register" name="register">
                                  <input type="hidden" value="{$data.userid}" name="data[mid]">
                                  <button type="submit" class="btn btn-primary btn-block btn-flat">{:L('ADMIN_REGISTER')}</button>
                                </div>
                              </div>
                            </div><!-- /.box-footer -->
                          </form>
                        </div>

                </div>
              </div>
            </div>
          </div>
        </section>
      </div><!-- /.content-wrapper -->
<script type="text/javascript">
$("#reset").on('click',function(){
  $("#resetpassword").attr('disabled',false);
  $("#resetpassword").val('a888888');
});
</script>
<script src="__STATIC__/js/user.js"></script>
<include file="Public/footer"/>
     