<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<?php if (!empty($_COOKIE['ajaxmsg'])) {  ?>
	<script type="text/javascript">
		history.go(-1);		
	</script>	
<?php }else{ ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{:L('ADMIN_JUMPCUE')}</title>
	<meta name="description" content="" />
	<link type="text/css" rel="stylesheet" href="/Public/common/css/jump.css" />
	<script type="text/javascript" src="/Public/common/js/jquery-1.4.2.min.js"></script>
	</head>
	<body>
	    <div id="wrapper">
	    	<?php if(isset($message)) {?>
		        <a href=""><img src="/Public/common/images/xiao.png"></a>
		        <div>
		            <h1><?php echo($message); ?></h1>
		            <p><?php echo($message); ?></p>
		        </div>
	        <?php }else{?>
				<a href=""><img src="/Public/common/images/ku.png"></a>
		        <div>
		            <p><?php echo($error); ?></p>
		        </div>
	        <?php }?>        
	        <a class="link" href="<?php echo($jumpUrl); ?>" ><span id="sec">4 </span> {:L('ADMIN_JUMPTIME')}</a>
			<br /><br /><br />
	    </div>
		<script type="text/javascript">
			$(document).ready(function(){
				if (!$.browser.msie){
					$("img").addClass('fade').delay(800).queue(function(next){
						$("h1, p").addClass("fade");
						$("a.link").css("opacity", 1);
						next();
					});
				}else{
					$("img, h1, p").addClass('fade');
					$('a.link').css('opacity', 1);
				}
			});
		</script>
		<script type="text/javascript">
			$(function () {
				setTimeout("lazyGo();", 1000);
			});
			function lazyGo() {
				var sec = $("#sec").text();
				var link = $(".link").attr("href");
				$("#sec").text(--sec);
				if (sec > 0)
					setTimeout("lazyGo();", 1000);
				else
					window.location.href = link;
			}
		</script>
	</body>
	</html>
<?php } ?>
