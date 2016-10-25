<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{:L('ADMIN_MANAGE_SYSTEM')} / {:L('ADMIN_MANAGE_LOGIN')}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="__STATIC__/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="__STATIC__/css/ionicons.min.css">
        <link rel="stylesheet" href="__STATIC__/css/font-awesome.min.css">
        <link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
        <!-- jQuery 2.1.4 -->
        <script src="__STATIC__/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    </head>
<style type="text/css">
.box-info{
  margin:17% auto;
  width: 30%;

}
.box{
  background: none;
  box-shadow:none;
}
.box.box-info {
  border-top: none;
  border:1px solid #d2d6de;
}
.box-footer {
  background: none;
}
.login-page{
background:#f4f4f4;

}
.alert{
  padding: 0px;
}
.tips{
  width:100px;
  height: 100px;
  text-align: center;
  vertical-align: middle;
  background: #f00;
  color: #fff;
  border-radius:100px; 
  margin: 0 auto;
  position: relative;
  right: -100px;
}
</style>
    <body class="hold-transition login-page">
        <div class="box box-info">
            <div class="login-logo">
                <a href="#"><b>{:L('ADMIN_MANAGE_SYSTEM')}</b></a>
            </div>
            <!-- form start -->
            <form class="form-horizontal" action="{:U('Login/Login')}" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">{:L('ADMIN_USERNAME')}</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="data[name]" id="name" value="{$data.name}" type="text" title="{:L('ADMIN_TIPS')}"  >
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">{:L('ADMIN_PASSWORD')}</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="password" name="data[password]" title="{:L('ADMIN_TIPS')}" >
                  </div>
                </div>
                
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-block btn-info  pull-right">{:L('ADMIN_MANAGE_LOGIN')}</button>
              </div><!-- /.box-footer -->
            </form>
            <if condition="$message neq ''">
                <div class="form-group" id="message" style="text-align:center;color:#f00;">
                  <i class="icon fa fa-ban"></i>{$message}
                </div>
            </if>

        </div>

        <script type="text/javascript">
              $('#name').focus(function(){
                 $('#message').hide();
              })
              $(function(){
                $('#name').focus();
              })
        </script>
        
    </body>
</html>
