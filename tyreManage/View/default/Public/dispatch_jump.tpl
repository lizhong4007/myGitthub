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
<include file="Public/header"/>
<link type="text/css" rel="stylesheet" href="/Public/common/css/jump.css" />
	<div class="content-wrapper" >
		<section class="content">
		 <div class="row">
		 <div class="col-xs-12">
		<?php if(isset($message)) {?>
			        <a href=""><img src="/Public/common/images/xiao.png"></a>
			        <div>
			            <h1><?php echo($message); ?></h1>
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
				</div>
		</section>
	</div>
	<script type="text/javascript">
		$(function () {
			setTimeout("Go();", 1000);
		});
		function Go() {
			var sec = $("#sec").html();
			var link = $(".link").attr("href");
			$("#sec").html(--sec);
			if (sec > 0)
				setTimeout("Go();", 1000);
			else
				window.location.href = link;
		}
	</script>

<include file="Public/footer"/>
	
<?php } ?>
