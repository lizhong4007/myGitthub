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
      {:L('GOODS_CATEGORY')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
      <li><a href="{:U('Category/categoryList')}">{:L('ADMIN_CAT')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('ADMIN_CAT')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('categoryList')">class="active"</if>>
              <a href="{:U('Category/categoryList')}">
                {:L('ADMIN_CAT')}{:L('ADMIN_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addCategory')">class="active"</if>>
              <a href="{:U('Category/addCategory')}">
                {:L('ADMIN_ADD')}{:L('ADMIN_CAT')}
              </a>
            </li>
          </ul>
          <form class="form-horizontal" action="{:U('Category/addCategory')}" method="post" onsubmit="return checkForm()">
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_CAT')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[cat_name]" id="name" value="{$data.cat_name}" type="text" title="{:L('ADMIN_TIPS')}" />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_LANGUAGE_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[cat_alias]" value="{$data.cat_alias}" id="en_name" type="text"  />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save">
                  <input type="hidden" value="{$data.catid}" name="data[cat_id]">
                  <input type="hidden" value="{$parentid}" name="data[parent_id]">
                  <button type="submit" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script src="__STATIC__/js/category.js"></script>
<include file="Public/footer"/>
     