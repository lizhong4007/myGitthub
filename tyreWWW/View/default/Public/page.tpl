<link rel="stylesheet" href="__STATIC__/css/page.css" />
<!-- page -->
<div class="container-fluid page">
    <div class="container ">
        <div class="page_num">
            <ul>
                <if condition="$page['prev'] neq ''">
                    <li class="pre">
                        <a href="{$page.prev}">{:L('ADMIN_PREV')}</a>
                    </li>
                </if>
                <foreach name="page.page" key="key" item="pageurl">
                <if condition="$pageurl  eq 'current'">
                    <li class="num active">
                        <a href="#">{$key}</a>
                    </li>
                <else />
                    <li class="num ">
                        <a href="{$pageurl}">{$key}</a>
                    </li>
                </if>
                </foreach>
               <if condition="$page['next'] neq ''">
                    <li class="next">
                        <a href="{$page.next}">{:L('ADMIN_NEXT')}</a>
                    </li>
                </if>
                <if condition="count($page['page']) gt 1">
                <li class="total">
                    {:L('ADMIN_TOTAL')}{$page.totalPages}{:L('ADMIN_PAGE')}
                </li>
                <li class="page_go">
                    <div class="form-group">
                        <div class="input-group">
                        <input class="form-control" id="goto_page"  value="" type="text">
                        <input type="hidden" value="{$page.org_url}" id="org_url" />
                        <span class="input-group-addon goto_page">
                        GO
                        </span>
                        </div>
                    </div>
                </li>
                </if>
            </ul>
        </div>
    </div>
</div><!-- //page -->
<script type="text/javascript">
$(".goto_page").on("click",function(){
    var p_value = $("#goto_page").val();
    var org_url = $("#org_url").val();
    p_value = parseInt(p_value);
    if(p_value > 0)
    {
        var parter = /\[PAGE\]/g;
        var url = org_url.replace(parter,p_value);
        window.location.href = url; 
    }
})
</script>