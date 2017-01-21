$(function(){
	$('#search_goods').on('click',function(){
	    $('#search_form').submit();
	});
	$('#search_key_value').on('focus',function(){
	    var obj = $(this);
	    obj.val('');

	});
	$(window).scroll(function(){
        if ($(window).scrollTop() > 150){
            $(".goto_top").fadeIn(1000);
        }
        else
        {
            $(".goto_top").fadeOut(1000);
        }
        var wScrollY = window.scrollY; // 当前滚动条位置    
        var wInnerH = window.innerHeight; // 设备窗口的高度（不会变）    
        var bScrollH = document.body.scrollHeight; // 滚动条总高度        
        if (wScrollY + wInnerH + 5 >= bScrollH) {            
            $(".goto_top").fadeOut(800);
        }   
        
    });
    $(".goto_top").on("click",function(){
        $("html,body").animate({scrollTop:0},800);
    })
    $(".header").on('click',".nav_icon",function(){
        var nav_status = $('#nav_status').val();
        nav_status = parseInt(nav_status);
        $('.search_nav').hide();
        if(nav_status == 0)
        {
            $('#nav_status').val(1)
            $(".nav").animate({'width':'70%',"height":"100%"});
            $(".header_title").addClass('header_title_active');
            $(".header_title").animate({'width':'30%'});
        }else{
            $('#nav_status').val(0)
            $(".nav").animate({'width':'0',"height":"100%"});
            $(".header_title").removeClass('header_title_active');
            $(".header_title").animate({'width':'100%','overflow':"hidden",'right':'0'});
        }
    });
    $(".header").on('click',".btn_search",function(){
        $('#nav_status').val(0)
        $('.nav').css({'width':'0','overflow':"hidden"});
        $(".header_title").css({'width':'100%'});
        $(".header_title").removeClass('header_title_active');
        $('.search_nav').slideToggle();
    });
    $('.main').on('click',function(){
        $('.search_nav').hide(300);
        $(".header_title").removeClass('header_title_active');
        $(".nav").animate({'width':'0',"height":"100%"});
        $(".header_title").animate({'width':'100%','overflow':"hidden",'right':'0'});
    });
    $('.home_main').on('click',function(){
        $('.search_nav').hide(300);
        $(".header_title").removeClass('header_title_active');
        $(".nav").animate({'width':'0',"height":"100%"});
        $(".header_title").animate({'width':'100%','overflow':"hidden",'right':'0'});
    });
    /*标题和关键词*/
    $('title').html($('#site_title').val());
    $("meta[name^='keywords']").attr('content',$('#site_keywords').val());
    $("meta[name^='description']").attr('content',$('#site_description').val());
    $("meta[rel^='canonical']").attr('href',$('#site_canonical').val());
});
window.onload = function(){
    $('#nav_status').val(0)
    $('.search_nav').hide();
};
/**
* 功能：js显示中间5页；
*适用范围，页面分页为js，点击分页后是ajax方式传递
*@param：totalRows 总的数据量
*@param：nowPage 当前页
*@param：limitrows 每页显示数量
*@param：rollPage 显示页数（默认中间5页，基数）
*@return：1页返回false ，
          多页返回数组：
          数组解释：
                坐标0，第一页，值为0，页面可以不展示
                坐标1，上一页，值为0，页面可以不展示
                坐标2，下一页，值为0，页面可以不展示
                坐标3，最后一页，值为0，页面可以不展示
                坐标4，总页数，
                其余的坐标为数字形式。
 */
function common_page(totalRows,nowPage,limitrows,rollPage)
{
    /*初始化*/
    if(rollPage == 0 || typeof(rollPage) == 'undefined')
    {
        rollPage = 5;
    }
    if(totalRows == 0 || typeof(totalRows) == 'undefined')
    {
        totalRows = 1;
    }
    if(nowPage == 0 || typeof(nowPage) == 'undefined')
    {
        nowPage = 1;
    }
    if(limitrows == 0 || typeof(limitrows) == 'undefined')
    {
        limitrows = 20;
    }

    /*//初始化*/
    var $data = new Array();//存储返回数据
    
    /* 计算分页信息 */
    var totalPages = Math.ceil(totalRows / limitrows); //总页数
    

    if(nowPage > totalPages) {
        nowPage = totalPages;
    }


    if(totalPages == 1)
    {
        return false;
    }

    //第一页
    var first_page = 1;
    $data.push(first_page);
    //上一页
    var prev_page  = nowPage - 1;
    if(prev_page < 0)
    {
        prev_page = 0
    }

    $data.push(prev_page);
    //下一页
    var next_page  = parseInt(nowPage) + 1;
    if( next_page > totalPages)
    {
        next_page = 0;
    }
    $data.push(next_page);
   
    //最后一页
    var last_page = totalPages;
    $data.push(last_page);

    //总页数
    $data.push(totalPages);
    


    var step_num = Math.floor(rollPage/2);
   
    /* 中间5页 */
    var $startpage;
    var $endpage;
    if(totalPages > rollPage)
    {
        if(nowPage < step_num )
        {
            $startpage = 1;
            $endpage = totalPages > rollPage ? rollPage : totalPages;
        }else{
            if(parseInt(nowPage) + parseInt(step_num) > totalPages)
            {
                $endpage = totalPages;
                $startpage = parseInt($endpage - rollPage) + 1;
            }else{
                $startpage = (nowPage - step_num > 0) ? (nowPage - step_num) : 1;
                $endpage = (parseInt(nowPage) + parseInt(step_num) > totalPages) ? totalPages : (parseInt(nowPage) + parseInt(step_num));
            }
        } 
        
    }else{
        $startpage = 1;
        $endpage = totalPages;
    }

    //数字连接
    for(var i = $startpage ; i <= $endpage ; i++)
    {
        if($startpage == $endpage) break;
        $data.push(i);
    }


    return $data;
}