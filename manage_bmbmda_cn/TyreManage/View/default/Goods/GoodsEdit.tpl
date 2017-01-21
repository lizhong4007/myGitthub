<include file="Public/header"/>
<link rel="stylesheet" href="__STATIC__/css/users.css">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_GOODS')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
            <li><a href="{:U('Goods/goodsList')}">{:L('ADMIN_GOODS')}</a></li>
            <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_GOODS')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" >
                  <li <if condition="ACTION_NAME eq 'Index'">class="active"</if>>
                    <a href="{:U('Goods/Index')}">
                      {:L('ADMIN_GOODS')}{:L('ADMIN_LIST')}
                    </a>
                  </li>
                  <li <if condition="ACTION_NAME eq 'Add'">class="active"</if>>
                    <a href="{:U('Goods/Add')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_GOODS')}
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
                          <form class="form-horizontal" action="{:U('Managers/Add')}" method="post" onsubmit="return checkForm()">
                              <div class="box-body">
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label">{:L('ADMIN_name')}</label>
                                      <div class="input-group">
                                        <input class="form-control" name="data[name]" value="{$data.name}" id="name" type="text" title="{:L('ADMIN_TIPS')}" />
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                      </div>
                                    </div>
                                  <div class="form-group">
                                      <label  class="col-sm-3 control-label">{:L('ADMIN_PASSWORD')}</label>
                                      <div class="input-group">
                                        <input class="form-control" type="password" name="data[password]" id="password"title="{:L('ADMIN_TIPS')}" />
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-sm-3 control-label">{:L('ADMIN_GROUP')}</label>
                                      <div class="input-group col-sm-9">
                                          <select class="form-control" name="data[groupid]">
                                              <foreach name="group" key="key" item="value">
                                                  <option value="{$key}" >{$value.name}</option>
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
                                  <input type="hidden" value="{$data.mid}" name="data[mid]">
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
  function checkForm()
  {
      var name = $('#name');
      var password = $('#password');
      var reg =  /^[^_]\w{5,15}$/;
      if(name.val() == '')
      {
        name.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
        return false;
      }
      // alert(reg.exec(password.val()));
      if(password.val() == '' || !reg.exec(password.val()))
      {
        password.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
        return false;
      }
      return true;
  }
</script>
<script type="text/javascript">
  $('#name').focus(function(){
    $('#name').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
  });

  $('#password').focus(function(){
    $('#password').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
  });
   $('#password').keyup(function(){
    var reg =  /^[^_]\w{5,15}$/;//字母，下划线，数字，不以下划线开始
    if(reg.exec($('#password').val()))
    {
      $('#password').next('.input-group-addon').html('<i class="fa  fa-check"></i>');
      return true;
    }else{
      if($('#password').val().length>5)
      {
        $('#password').next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      }else{
        $('#password').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
      }
    }

   });
</script>
<include file="Public/footer"/>
     