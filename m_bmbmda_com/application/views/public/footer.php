    <!-- footer -->
    <div class="footer">
      <div class="copyright">Copyright © 2016 bmbmda.com
        <br>chongqing ICP prepared No.16011874</div></div>
  <script type="text/javascript" src="<?php echo base_url('public/home/js/jQuery-2.1.4.min.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/home/js/common.min.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/home/slider/jquery.SuperSlide.2.1.1.min.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/home/js/jquery.lazyload.min.js');?>"></script>
  <script type="text/javascript">
  jQuery(".modelresourceBox").slide({
      mainCell: ".bd ul",
      effect: "fade",
      trigger: "mouseover",
      easing: "swing",
      delayTime: 500,
      mouseOverStop: true,
      pnLoop: false,
    });
    jQuery(".seires_img").slide({
      mainCell: ".bd ul",
      effect: "fade",
      trigger: "mouseover",
      easing: "swing",
      delayTime: 500,
      mouseOverStop: true,
      pnLoop: false,
    });
    $(function() {
      //异步加载图片
      $("img.lazy").lazyload({
        effect: "fadeIn",
        failurelimit: 10
      });
    })
  </script>
</script>

  </body>
</html>