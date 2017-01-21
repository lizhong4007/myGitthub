<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
<link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
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
            <li class="active">{:L('ADMIN_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq 'goodslist'">class="active"</if>>
                    <a href="{:U('Goods/goodsList')}">
                      {:L('ADMIN_GOODS')}{:L('ADMIN_LIST')}
                    </a>
                  </li>
                  <!-- <li <if condition="strtolower(ACTION_NAME) eq 'addgoods'">class="active"</if>>
                    <a href="{:U('Goods/addGoods')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_GOODS')}
                    </a>
                  </li> -->
                </ul>
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="fa-icons">
                    <section id="new">
                      <!-- <div class="col-xs-12"> -->
                      <div class="box">
                          <div class="box-header">
                                <div class="category">
                                    <form action="{:U('Goods/goodsList')}" method="post">
                                        <ul>
                                            <li>
                                                {:L('ADMIN_NAME')}
                                            </li>
                                            <li>
                                                <input type="text" value="{$goodsname}" name="goodsname"  />
                                            </li>
                                            <li>
                                                <input type="hidden" value="searched" name="searched" />
                                                <input type="submit" value="{:L('ADMIN_SEARCH')}" />
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div><!-- /.box-header -->
                        <!-- <div class="box-header">
                          <h3 class="box-title">Hover Data Table</h3>
                        </div> --><!-- /.box-header -->
                        <div class="box-body">
                          <table id="example2" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>{:L('ADMIN_DATE')}</th>
                                <!-- <th>
                                    <div class="form-group">
                                      <div class="input-group ">
                                      <span><input class="minimal" type="checkbox" id="checkAlls"  />{:L('ADMIN_SELECTALL')}</span>
                                    </div>
                                    </div>
                                </th> -->
                                <th>{:L('ADMIN_IMAGE')}</th>
                                <th>{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('ADMIN_BRAND')}</th>
                                <th>{:L('ADMIN_MODEL')}</th>
                                <th width="300">{:L('ADMIN_SPEC')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <tbody>
                              <foreach name="goods" item="value">
                              <tr>
                                <!-- <td>
                                   <div class="form-group">
                                      <div class="input-group ">
                                      <input class="minimal" type="checkbox" id="checkAlls" value="{$value.goodsid}"  />
                                    </div>
                                    </div>
                                </td> -->
                                <td>{$value.goodsid}</td>
                                 <td>{:date('Y-m-d',$value['addtime'])}</td>
                                <td>
                                  <a href="{$site_imagedomain}{$value.thumb}" target="_blank">
                                    <img src="{$site_imagedomain}{$value.thumb}" width="100px" height="60px" />
                                  </a>
                                </td>
                                <td>
                                    <a href="{$default_site}{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" target="_blank">
                                      {$value.title}
                                    </a>
                                </td>
                                <td>
                                    <a href="" target="_blank">
                                      {$value.en_title}
                                    </a>
                                </td>
                                <td>{$value.brand}</td>
                                <td>{$value.model}</td>
                                <td>
                                    <ul>
                                      <foreach name="value.param" key="k" item="v">
                                          <li class="param">
                                              <strong>{$v['param']}:</strong>{$v['value']}<br />
                                          </li>
                                      </foreach>
                                    </ul>
                                </td>
                                <td>
                                <!-- <a class="fa fa-edit text-navy" href="{:U('Goods/addGoods',array('goodsid'=>$value['goodsid']))}" title="{:L('ADMIN_EDIT')}"></a> -->
                                  <input type="hidden" id="delete_{$value['goodsid']}" value="{:U('Goods/deleteGoods',array('Goods'=>$value['goodsid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['goodsid']})" title="{:L('ADMIN_DELETE')}"></a>
                                </td>
                              </tr>
                              </foreach>
                            </tbody>
                            <input type="hidden" id="note_title" value="{:L(ADMIN_TITLE)}" />
                              <input type="hidden" id="note_content" value="{:L(ADMIN_DELETE_OR)}" />
                              <input type="hidden" id="note_sure" value="{:L(ADMIN_CONFIRM)}" />
                              <input type="hidden" id="note_cancel" value="{:L(ADMIN_CANCEL)}" />
                          </table>
                        </div><!-- /.box-body -->
                          <include file="Public/page"/>
                          <!-- 批量操作 -->
                        <!-- <div>
                            <div>
                            </div>
                            <div class="form-group batch ">
                                <div  class="col-sm-3 control-label">{:L('BATCH_PROCESSING')}:</div>
                                <div class="input-group col-sm-9">
                                    <select class="form-control col-sm-9" name="data[groupid]"   >
                                        <option value="0" >{:L('PLEASE_SELECT')}</option>
                                        <option value="1" >{:L('ADMIN_DELETE')}</option>
                                    </select>
                                    <button class="col-sm-3 btn btn-primary" id="batch_deal" >{:L('ADMIN_CONFIRM')}</button>
                                </div>
                            </div>
                        </div> -->
                      </div><!-- /.box -->
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div><!-- /.content-wrapper -->
<script type="text/javascript">
  //check All
$("#checkAlls").on('ifChecked',function () {
 if ($(this).is(':checked') == true) { 
    $(":checkbox").each(function () {
        $(this).prop("checked", true);
        $(this).parent("div").addClass("checked");
        });
    }
});
//not check All
$("#checkAlls").on('ifUnchecked',function () {
   if ($(this).is(':checked') == false) { 
       $(":checkbox").each(function () {
           $(this).prop("checked", false);
           $(this).parent("div").removeClass("checked");
           });
        }
});
$("#batch_deal").on("click",function(){
   var obj = $(this);
   var selected = obj.parent().find("select").val();
   selected = parseInt(selected);
   if(selected <= 0)
   {
    return false;
   }
   if(selected == 1)
   {
      var note_title = $('#note_title').val();
      var note_content = $('#note_content').val();
      var note_sure = $('#note_sure').val();
      var note_cancel = $('#note_cancel').val();
      $.confirm({
        title: note_title,
        content: note_content,
        confirmButton: note_sure,
        cancelButton: note_cancel,
        closeIcon: false,
        confirm: function(){
            var url = $('#delete_'+id).val();
          if(url != 'undefined' && url != '')
          {
               window.location.href = url;
          }
        },
        cancel: function(){
        }
      });
   }
})
</script>
<include file="Public/footer"/>