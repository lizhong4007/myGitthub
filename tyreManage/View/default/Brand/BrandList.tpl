<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/category.css">
<link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery-confirm.css"/> 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {:L('ADMIN_BRAND')}
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{:U('Goods/goodsList')}"><i class="fa fa-th-large"></i> {:L('ADMIN_GOODS_MANAGE')}</a></li>
            <li><a href="{:U('Brand/brandList')}">{:L('BRANDS_LIST')}</a></li>
            <li class="active">{:L('BRANDS_LIST')}</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('BrandList')">class="active"</if>>
                    <a href="{:U('Brand/brandList')}">
                      {:L('BRANDS_LIST')}
                    </a>
                  </li>
                  <li <if condition="strtolower(ACTION_NAME) eq strtolower('addBrand')">class="active"</if>>
                    <a href="{:U('Brand/addBrand')}">
                      {:L('ADMIN_ADD')}{:L('ADMIN_BRAND')}
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
                                <form action="{:U('Brand/brandList')}" method="post">
                                    <ul>
                                        <li>
                                            {:L('ADMIN_BRAND')}
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
                                <th>{:L('ADMIN_IMAGE')}</th>
                                <th>{:L('ADMIN_BRAND')}{:L('ADMIN_NAME')}</th>
                                <th>{:L('ADMIN_LANGUAGE_NAME')}</th>
                                <th>{:L('FIRST_LETTER')}</th>
                                <th>{:L('RECOMMEND')}</th>
                                <th>{:L('ADMIN_SERIES')}</th>
                                <th>{:L('ADMIN_HANDLE')}</th>
                              </tr>
                            </thead>
                            <input type="hidden" value="{:U("Brand/ajaxUpdate")}" id="brand_url" />
                            <tbody>
                              <foreach name="data" item="value">
                              <tr class="{$value.level}" id="{$value.catid}" data="down" data-pid="{$value.parentid}">
                                <td>{$value.brandid}</td>
                                <td>
                                    <if condition="$value.thumb neq ''">
                                    <div style="width:100px;height:60px;">
                                    <a href="{$value.thumb}" target="_blank">
                                    <img src="{$value.thumb}" width="100%" height="100%" />
                                    </a>
                                    </div>
                                    </if>
                                </td>
                                <td >
                                    {$value.brand_name}
                                </td>
                                <td >
                                    {$value.brand_alias}
                                </td>
                                <td>
                                    {$value.letter}
                                </td>
                                <td class="recommend_state">
                                    <if condition="$value['is_recommend'] eq '0'">
                                        <a href="javascript:;" class="fa  fa-close text-red is_recommend" data="0" data-brand="{$value.brandid}"></a>
                                    <else />
                                        <a href="javascript:;" class="fa  fa-check text-navy is_recommend" data="1" data-brand="{$value.brandid}"></a>
                                    </if>
                                </td>
                                <td>
                                    <a href="{:U('Series/addSeries',array('brandid'=>$value['brandid']))}">{:L('ADMIN_ADD')}{:L('ADMIN_SERIES')}</a>
                                </td>
                                <td>
                                  <a class="fa fa-edit text-navy" href="{:U('Brand/addBrand',array('brand_id'=>$value['brandid']))}" title="{:L('ADMIN_EDIT')}"></a>
                                  <input type="hidden" id="delete_{$value['brandid']}" value="{:U('Brand/deleteBrand',array('brand_id'=>$value['brandid']))}"/>
                                  <a class="fa fa-remove text-navy" href="javascript:;" onclick="delete_data({$value['brandid']})" title="{:L('ADMIN_DELETE')}"></a>
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