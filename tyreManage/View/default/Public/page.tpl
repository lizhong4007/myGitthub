<div class="row" style="padding:0px 15px 0px 15px;">
  <div class="col-sm-5">
    <!-- <div aria-live="polite" role="status" id="example2_info" class="dataTables_info">
      Showing {$page.firstRow} to {$page.lastRow} of {$page.totalRows} entries
    </div> -->
  </div>
  <div class="col-sm-12">
      <div  class="dataTables_paginate paging_simple_numbers">
          <ul class="pagination">
            <if condition="$page.page neq ''">
                <li class="paginate_button previous ">
                      <a>total:{$page.totalRows}</a>
                </li>
                <li class="paginate_button previous <if condition="$page.first eq ''">disabled</if>">
                    <a href="{$page.first}">
                      {:L('ADMIN_HOME')}
                    </a>
                </li>
                <li class="paginate_button previous <if condition="$page.prev eq ''">disabled</if>">
                    <a href="{$page.prev}">
                      {:L('ADMIN_PREV')}
                    </a>
                </li>
                <foreach name="page.page" key='key' item="value">
                    <if condition="$value eq 'current'">
                        <li class="paginate_button active">
                          <a >
                            {$key}
                          </a>
                        </li>
                    <else />
                        <li class="paginate_button ">
                          <a href="{$value}">
                            {$key}
                          </a>
                        </li>
                    </if>
                </foreach>
                <li class="paginate_button next <if condition="$page.next eq ''">disabled</if>">
                    <a  href="{$page.next}">
                      {:L('ADMIN_NEXT')}
                    </a>
                </li>
                <li class="paginate_button previous <if condition="$page.last eq ''">disabled</if>">
                    <a href="{$page.last}">
                      {:L('ADMIN_LAST')}
                    </a>
                </li>
            </if>
        </ul>
    </div>
  </div>
</div>