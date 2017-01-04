<!-- <include file="Public/header"/> -->
<link rel="stylesheet" href="__STATIC__/css/users.css">
<link rel="stylesheet" href="__STATIC__/css/group.css">
<link rel="stylesheet" href="__STATIC__/css/company.css">
<link rel="stylesheet" href="__STATIC__/plugins/iCheck/all.css">
<link rel="stylesheet" href="__STATIC__/dist/css/skins/_all-skins.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {:L('COMPANY')}
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{:U('Company/companyList')}"><i class="fa fa-th-large"></i> {:L('COMPANY_MANAGE')}</a></li>
      <li><a href="{:U('Company/companyList')}">{:L('COMPANY_LIST')}</a></li>
      <li class="active">{:L('ADMIN_ADD')}{:L('COMPANY')}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="col-xs-12 row">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" >
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('companyList')">class="active"</if>>
              <a href="{:U('Company/companyList')}">
                {:L('COMPANY')}{:L('ADMIN_LIST')}
              </a>
            </li>
            <li <if condition="strtolower(ACTION_NAME) eq strtolower('addCompany')">class="active"</if>>
              <a href="{:U('Company/addCompany')}">
                {:L('ADMIN_ADD')}{:L('COMPANY')}
              </a>
            </li>
          </ul>
          <input type="hidden" value="{:U('Company/CompanyList')}" id="company_url" />
          <form class="form-horizontal" action="{:U('Company/addCompany')}" method="post" id="all_form">
            <div class="tab-content">
              <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('COMPANY')}{:L('ADMIN_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[company_name]" id="name" value="{$data.company_name}" type="text" title="{:L('ADMIN_TIPS')}" />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_LANGUAGE_NAME')}</label>
                    <div class="input-group col-sm-2">
                      <input class="form-control" name="data[company_alias]" value="{$data.company_alias}" id="en_name" type="text"  />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('ADMIN_SITE')}</label>
                    <div class="input-group col-sm-2">
                      <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                      <input type="hidden" value="{:L('CHECK_SITE')}" id="content_note" />
                      <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                      <input class="form-control" name="data[site]" value="{$data.site}"  type="text" id="companysite" />
                      <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{:L('MANAGEMENT_MODEL')}</label>
                    <div class="input-group -col-sm-2">
                      <ul class="checkbox_ul">
                            <foreach name="MANAGEMENT_MODEL" item="model">
                                <li >
                                    <input type="checkbox" name="model[]" value="{:strtolower($model)}" class="minimal" <if condition="in_array(strtolower($model),explode(',',$data['operation_mode']))">checked</if> />
                                    <label>{:L(strtoupper($model))}</label>
                                </li>
                            </foreach>
                        </ul>
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_IMAGE')}
                      </label>
                      <div class="input-group col-sm-2 ">
                          <input class="form-control" name="data[thumb]" value="{$data.thumb}" id="image" type="text"  />
                          <span class="input-group-addon input-group-addon_image" >
                              <input type="hidden" value="company" id="savedir" />
                              <span class="fileupload" data-callback="setImages" id="filepicker">
                              </span>
                          </span>
                      </div>
                  </div>
                  <!-- 图片 -->
                  <input type="hidden" value="{:L('ADMIN_NOTE')}" id="title_note" />
                  <input type="hidden" value="{:L('ADMIN_CONFIRM')}" id="note_sure" />
                  <div class="brand_img" >
                      <if condition="$data['thumb'] neq ''">
                      <img id="company_logo" width="100" height="100" src="{$site_imagedomain}{$data.thumb}" />
                      </if>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">
                         {:L('ADMIN_DESCRIPTION')}
                      </label>
                      <div class="input-group col-sm-4 ">
                        <textarea class="form-control" name="data[introduce]">{$data.introduce}</textarea>
                      </div>
                  </div>
                  <!-- 地区开始 -->
                  <input type="hidden" id="please_select" value="{:L('PLEASE_SELECT')}"/>
                  <input type="hidden" id="getarea" value="{:U('Company/getArea')}"/>
                  <!-- 地区模块============================== -->
                  <div class="form-group all_distributor">
                      <foreach name="distributor_data" key="key" item="distributor">
                        <div class="part_region">
                            <input type="hidden" value="{$distributor.distributorid}"  class="region_id" />
                            <!-- 地区开始 -->
                            <div class="region">
                                <label class="d_title d_title_r control-label"><span class="distributor_title">{:L('ADMIN_REGION')}</span>
                                <if condition="$key lt '1'">
                                <span class="all_distributor_block region_plus">+</span>
                                <else />
                                <span class="all_distributor_block region_minus">-</span>
                                </if>
                                </label>
                                <div class="input-group d_select ">
                                  <label class="d_region control-label distributor_region">
                                     {:L('ADMIN_REGION')}
                                   </label>
                                   <div class="d_select_block">
                                      <select class="form-control select2 d_province" name="distributor[{$distributor.distributorid}][countryid]">
                                        <option value="0" >{:L('PLEASE_SELECT')}</option>
                                        <foreach name="country" item="country_v">
                                        <option title="{$country_v.en_name}"  value="{$country_v.countryid}" <if condition="$distributor['countryid'] eq $country_v['countryid']">selected="selected"</if> >{$country_v.cn_name}</option>
                                        </foreach>
                                      </select>

                                      <select class="form-control select2 d_city" name="distributor[{$distributor.distributorid}][stateid]">
                                        <option value="0">{:L('PLEASE_SELECT')}</option>
                                        <foreach name="distributor.city_data" item="state">
                                        <option title="{$state.en_name}"  value="{$state.stateid}" <if condition="$distributor['stateid'] eq $state['stateid']">selected="selected"</if> >{$state.cn_name}</option>
                                        </foreach>
                                      </select>

                                      <select class="form-control select2" name="distributor[{$distributor.distributorid}][cityid]">
                                        <option value="0">{:L('PLEASE_SELECT')}</option>
                                        <foreach name="distributor.area_data" item="city">
                                        <option title="{$city.en_name}"  value="{$city.cityid}" <if condition="$distributor['cityid'] eq $city['cityid']">selected="selected"</if> >{$city.cn_name}</option>
                                        </foreach>
                                      </select>
                                  </div>
                                </div>
                            </div>
                                <!-- 地区end -->
                                <!-- 经销商开始 -->
                                <div class="distributor">
                                    <input type="hidden" value="{$distributor.distributorid}" class="distributor_id" />
                                    <label class="d_title d_title_d control-label"><span class="distributor_title">{:L('DISTRIBUTOR')}</span>
                                    </label>
                                    <div class="d_div">
                                        <label class="d_name control-label distributor_name ">{:L('ADMIN_NAME')}</label>
                                        <input class="d_name_input form-control" name="distributor[{$distributor.distributorid}][distributor_name]" value="{$distributor.distributor_name}"  type="text" />
                                    </div>
                                    <div class="d_div">
                                        <label class="d_name control-label distributor_site ">{:L('ADMIN_SITE')}</label>
                                        <input class="d_name_input form-control" name="distributor[{$distributor.distributorid}][site]" value="{$distributor.site}"  type="text" />
                                    </div>
                                    
                                    <div class="d_div">
                                       <label class="d_name control-label distributor_detail_address">
                                         {:L('DEAIL_ADDRESS')}
                                       </label>
                                       <input class="d_detail form-control" name="distributor[{$distributor.distributorid}][address]" value="{$distributor.address}"  type="text"  />
                                    </div>
                                    
                                        <foreach name="distributor.telephone" key="key" item="telephone">
                                        <div class="telephone_block">
                                        <div class="d_div ">
                                        <!-- //电话 -->
                                           <div class="d_telephone">
                                               <label class="control-label d_telephone_name telephone">{:L('ADMIN_TELEPHONE')}</label>
                                               <input class="form-control d_telephone_value" name="distributor[{$distributor.distributorid}][telephone][]" value="{$telephone}"type="text"  />
                                           </div>
                                           <!-- //联系人 -->
                                           <div class="d_telephone">
                                                <label class="control-label d_telephone_name contanct" >{:L('ADMIN_CONTANCT')}</label>
                                                <input class="d_telephone_value form-control" name="distributor[{$distributor.distributorid}][contacts][]" value="{$distributor['contacts'][$key]}" type="text"  />
                                           </div>
                                           <if condition="$key eq '0'">
                                           <div class="span span_plus add_telephone_block" title="{:L('ADMIN_ADD')}">+</div>
                                           <else />
                                           <div class="span span_minus" title="{:L('ADMIN_DELETE')}">-</div>
                                           </if>
                                       </div>
                                       
                                    </div></foreach>
                                    <!-- fax==================== -->
                                    <div class="fax_block">
                                    <foreach name="distributor.fax" key="key" item="fax">
                                        <div class="d_div">
                                           <label class="d_name control-label">
                                             fax
                                           </label>
                                           <input class="d_email form-control" name="distributor[{$distributor.distributorid}][fax][]" value="{$fax}"  type="text" />
                                           <if condition="$key eq '0'">
                                           <div class="span span_plus add_fax_block" title="{:L('ADMIN_ADD')}">+</div>
                                           <else />
                                           <div class="span span_minus" title="{:L('ADMIN_DELETE')}">-</div>
                                           </if>
                                        </div>
                                    </foreach>
                                    </div>
                                    <!-- 邮箱==================== -->
                                    <div class="email_block">
                                    <foreach name="distributor.email" key="key" item="email">
                                        <div class="d_div">
                                             <label class="d_name control-label">
                                             email
                                            </label>
                                            <input class="d_email form-control" name="distributor[{$distributor.distributorid}][email][]" value="{$email}"  type="text" />
                                            <if condition="$key eq '0'">
                                            <div class="span span_plus add_email_block" title="{:L('ADMIN_ADD')}">+</div>
                                            <else />
                                            <div class="span span_minus" title="{:L('ADMIN_DELETE')}">-</div>
                                            </if>
                                        </div>
                                      </foreach>
                                    </div>

                                    <!-- 平台和账号====================== -->
                                    <div class="platform_block">
                                        <foreach name="distributor.platform" key="key" item="platform">
                                        <div class="d_div ">
                                            <div class="d_telephone">
                                                <label class="control-label d_telephone_name platform">{:L('ADMIN_PLATFORM')}</label>
                                                <input class="form-control d_telephone_value" name="distributor[{$distributor.distributorid}][platform][]" value="{$platform}"  type="text"  />
                                            </div>
                                            <div class="d_telephone">
                                                <label class="control-label d_telephone_name account" >{:L('ADMIN_ACCOUNT')}</label>
                                                <input class="d_telephone_value form-control" name="distributor[{$distributor.distributorid}][account][]" value="{$distributor['account'][$key]}"  type="text"  />
                                            </div>
                                            <if condition="$key eq '0'">
                                            <div class="span span_plus add_platform_block" title="{:L('ADMIN_ADD')}">+</div>
                                            <else />
                                            <div class="span span_minus " title="{:L('ADMIN_DELETE')}">-</div>
                                            </if>
                                        </div>
                                        </foreach>
                                     </div><!-- 平台和账号end====================== -->
                                </div><!-- 经销商end -->
                        </div><!-- part_region end -->
                      </foreach>
                  </div>

              <!-- ============品牌开始======================= -->
               <div class="form-group brand_block">
                          <label class="d_title control-label"><span class="distributor_title">{:L('ADMIN_BRAND')}</label>
                          <div class="brand">
                              <div class="company_brand">
                                  <ul>
                                      <foreach name="brand.brand" item="value">
                                          <foreach name="value" key="k"  item="v">
                                              <if condition="in_array($v['brandid'],explode(',',$data['brandids']))">
                                                  <li >{$v.letter}-{$v.brand_name}({$v.brand_alias})
                                                  </li>
                                              </if>
                                          </foreach>
                                      </foreach>
                                  </ul>
                              </div>
                              <div class="brand_letter">
                                  <ul>
                                      <foreach name="brand.letter" item="value">
                                      <li <if condition="$value eq 'A'">class="letter_current"</if>>{$value}</li>
                                      </foreach>
                                  </ul>
                              </div>
                              <div class="brand_name">
                                  <ul>
                                      <foreach name="brand.brand" key="key" item="value">
                                          <li <if condition="$key eq 'A'"> class="name_current"</if>>
                                              <foreach name="value" key="k"  item="v">
                                              <span>
                                              <input type="checkbox" class="minimal" value="{$v.brandid}" name="brand[]" <if condition="in_array($v['brandid'],explode(',',$data['brandids']))">checked="checked"</if>/>{$v.brand_name}({$v.brand_alias})
                                              </span>
                                              </foreach>
                                          </li>
                                      </foreach>
                                  </ul>
                              </div>
                          </div>
              </div>
              <!-- ===========品牌end======================= -->

              </div>
            </div>
            <div class="box-footer">
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="input-group ">
                  <input type="hidden" value="save" name="save">
                  <input type="hidden" value="{$data.companyid}" name="data[companyid]">
                  <button type="button" id="btn_submit" class="btn btn-primary">{:L('ADMIN_SAVE')}</button>
                  <button type="reset" class="btn btn-primary">{:L('ADMIN_RESET')}</button>
                </div>
              </div>
            </div><!-- /.box-footer -->
          </form>
        </div>
    </div>
  </section>
</div><!-- /.content-wrapper -->
<script type="text/javascript">
function setImages(json)
{
    if(json.flag == 1)
    { 
        var image_host = "{:C('UPLOAD_FILE_URL')}";
        $('#company_logo').attr('src',image_host+json.message);
        $('#image').val(json.message);
    }else{
        var title = $('#title_note').val();
        alert_message(title,json.message);
    }
}
</script>
<script src="__STATIC__/js/company.js"></script>
<include file="Public/fileupload"/>
<include file="Public/footer"/>
     