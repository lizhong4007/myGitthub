<div class="footer" >
	<div class="footer_content">
		Copyright © 2016 bmbmda.com - chongqing ICP prepared No.16011874
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/home/js/jQuery-2.1.4.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/home/slider/jquery.SuperSlide.2.1.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/home/js/jquery.lazyload.min.js');?>"></script>
<script type="text/javascript">
    $(function(){
    	//异步加载图片
	    $("img.lazy").lazyload({effect: "fadeIn",failurelimit:10});

	    var windowheight = $(window).height();
	    var main_minheight;
	    if(windowheight > 600)
	    {
	    	main_minheight = windowheight - 40-50-50-50;
	    }else{
	    	main_minheight = 700;
	    }
	    
	    $(".main").css({'min-height':main_minheight});
    });
	
</script>
<script type="text/javascript">
	jQuery(".slideBox").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        prevCell:".prev", 
        nextCell:".next", 
        // autoPlay:"auto",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false 
    });
</script>
<script type="text/javascript">
	jQuery(".model_resource").slide( { 
        mainCell:".bd ol", 
        prevCell:".prevx", 
        nextCell:".nextx", 
        effect:"fade",
        autoPlay:"auto",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false 
    });
</script>
</body>
</html>