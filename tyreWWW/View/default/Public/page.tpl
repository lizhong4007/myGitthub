<link rel="stylesheet" href="__STATIC__/css/page.min.css" />
<!-- page -->
<div class="container-fluid page">
    <div class="container ">
        <div class="page_part">
            <div class="page_num">
                <ul>
                    <if condition="$page['first'] neq ''">
                        <li class="pre">
                            <a href="/">{:L('ADMIN_FIRST')}</a>
                        </li>
                    </if>
                    <foreach name="page.page" key="key" item="pageurl">
                    <if condition="$key  eq '1'">
                        <if condition="$pageurl  eq 'current'">
                            <li class="num active">
                                <a >{$key}</a>
                            </li>
                        <else />
                            <li class="num ">
                                <a href="/">{$key}</a>
                            </li>
                        </if>
                    <else />
                        <if condition="$pageurl  eq 'current'">
                            <li class="num active">
                                <a >{$key}</a>
                            </li>
                        <else />
                            <li class="num ">
                                <a href="{$pageurl}">{$key}</a>
                            </li>
                        </if>
                    </if>
                    </foreach>
                   <if condition="$page['last'] neq ''">
                        <li class="next">
                            <a href="{$page.last}">{:L('ADMIN_LAST')}</a>
                        </li>
                    </if>
                    <if condition="count($page['page']) gt 7">
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
    </div>
</div><!-- //page -->
<script type="text/javascript">
$(".goto_page").on("click",function(){
    var p_value = $("#goto_page").val();
    var org_url = $("#org_url").val();
    p_value = parseInt(p_value);
    if(p_value > 1)
    {
        var parter = /\[PAGE\]/g;
        var url = org_url.replace(parter,p_value);
        window.location.href = url; 
    }
})
</script>