<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_DEFAULT')}{:L('ADMIN_PARAMETER')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
            <li><a href="{:U('GoodsDefault/GoodsDefaultParamList')}">{:L('DEFAULT_PARAM_LIST')}</a></li>
            <li class="active">{:L('DEFAULT_PARAM_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('GoodsDefaultParamList')">class="active"</if>>
                    <a href="{:U('GoodsDefault/GoodsDefaultParamList')}">
                      {:L('DEFAULT_PARAM_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addBrand')">class="active"</if>>
                    <a href="{:U('GoodsDefault/AddGoodsDefaultParam')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_PARAMETER')}
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
                                <form action="{:U('GoodsDefault/GoodsDefaultParamList')}" method="post" >
                                    <ul>
                                        <li>
                                            {:L('ADMIN_PARAMETER')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$brandname}" name="brandname"  />
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
                                <th>{:L('ADMIN_PARAMETER')}</th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('ADMIN_CAT')}</th>
                                <th>{:L('ADMIN_PARAMETER')}{:L('ADMIN_VALUE')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <input type="hidden" value="{:U("Brand/ajaxUpdate")}" id="brand_url" />
                            <tbody>
                              <foreach name="data" item="value">
                              <tr >
                                <td>{$value.dparaid}</td>
                                <td >
                                    {$value.param}
                                </td>
                                <td >
                                    {$value.en_param}
                                </td>
                                <td >
                                    {$category[$value['catid']]['cat_name']}({$value.catid})
                                </td>
                                <td>
                                    <a href="{:U('GoodsDefault/AddGoodsDefaultValue',array('dparaid'=>$value['dparaid']))}">{:L('ADMIN_CHECK')}</a>
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('GoodsDefault/AddGoodsDefaultParam',array('dparaid'=>$value['dparaid']))}" title="{:L('ADMIN_EDIT')}"></a>
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
<script src="__STATIC__/js/brand.js"></script>
<script src="__STATIC__/js/jquery-confirm.js"></script>
<include file="Public/footer"/>