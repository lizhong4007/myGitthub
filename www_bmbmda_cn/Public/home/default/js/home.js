$(function(){
    $(".p_category").on("mouseover",function(){
        var obj = $(this);
        var index = obj.attr("data-index");
        $(".sub_category").css({"display":"none"});
        var li_arr = $("#sub_"+index).find("li");
        
        if(li_arr.length > 0)
        {
            $("#sub_"+index).css({"display":"block"});
            obj.css({"border-right":"none"});
            $("#slide_box").css({"display":"none"});
        }
    });
    $(".p_category").on("mouseout",function(){
        var obj = $(this);
        $("#slide_box").css({"display":"block"});
        $(".sub_category").css({"display":"none"});
        obj.css({"border-right":"1px solid #e7e7e7"});
    });
    $(".sub_category").on("mouseover",function(){
        var obj = $(this);
        var index = obj.attr("data-index");
        $("#slide_box").css({"display":"none"});
        obj.css({"display":"block"});
        $("#pcat_"+index).css({"border-right":"none"});

    });
    $(".sub_category").on("mouseout",function(){
        var obj = $(this);
        var index = obj.attr("data-index");
        $("#slide_box").css({"display":"block"});
        obj.css({"display":"none"});
        $("#pcat_"+index).css({"border-right":"1px solid #e7e7e7"});
    });
    jQuery(".slideBox").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        autoPlay:"auto",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:true 
    });
});