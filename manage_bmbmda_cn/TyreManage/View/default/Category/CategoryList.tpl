<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
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
            <li class="active">{:L('ADMIN_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('categorylist')">class="active"</if>>
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
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="fa-icons">
                    <section id="new">
                      <!-- <div class="col-xs-12"> -->
                      <div class="box">
                        <div class="box-header">
                            <div class="category">
                                <form action="{:U('Category/categoryList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('ADMIN_NAME')}
                                        </li>
                                        <li>
                                            <input type="text" value="{$categoryname}" name="categoryname"  />
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
                                <th>{:L('ADMIN_CAT')}{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('FIRST_LETTER')}</th>
                                <th>{:L('FRONT_PAGE_DISPLAYS')}</th>
                                <th>是否有商品</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <input type="hidden" value="{:U('Category/ajaxUpdate')}" id="category_url" />
                            <tbody>
                              <foreach name="data" item="value">
                              <tr class="{$value.level}" id="{$value.catid}" data="down" data-pid="{$value.parentid}">
                                <td style="text-indent:{$value.level}em;"  align="left">
                                  <i class="fa fa-minus dropdown text-navy"></i>
                                  {$value.cat_name}
                                </td>
                                <td >
                                {$value.cat_alias}
                                </td>
                                <td >
                                   {$value.letter}
                                </td>
                                <td class="show_state">
                                <if condition="$value['is_show'] eq '0'">
                                    <a href="javascript:;" class="fa  fa-close text-red is_show" data="0" data-cat="{$value.catid}" data-type="0"></a>
                                <else />
                                    <a href="javascript:;" class="fa  fa-check text-navy is_show" data="1" data-cat="{$value.catid}" data-type="0"></a>
                                </if>
                                </td>
                                <td class="show_state">
                                <if condition="$value['status'] eq '0'">
                                    <a href="javascript:;" class="fa  fa-close text-red is_show" data="0" data-cat="{$value.catid}" data-type="1"></a>
                                <else />
                                    <a href="javascript:;" class="fa  fa-check text-navy is_show" data="1" data-cat="{$value.catid}" data-type="1"></a>
                                </if>
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Category/addCategory',array('cat_id'=>$value['catid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['catid']}" value="{:U('Category/deleteCategory',array('cat_id'=>$value['catid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['catid']})" title="{:L('ADMIN_DELETE')}"></a>
                                  
                                  <a class="fa fa-plus text-navy" href="{:U('Category/addCategory',array('parent_id'=>$value['catid']))}" title="{:L('ADD_SUBCAT')}"></a>
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
<include file="Public/footer"/>