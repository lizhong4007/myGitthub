        <!-- footer -->
        <div class="container-fluid ">
            <div class="container footer">
                <div class="footer_l col-xs-12">
                    <ul>
                        <li><a href="">联系我们</a></li>
                        <li><a href="">关于我们</a></li>
                        <li><a href="">友情链接</a></li>
                    </ul>
                </div>
                <div class="footer_r copyright col-xs-12 ">
                    Copyright © 2016.tyre
                </div>
            </div>
        </div><!-- //footer -->
        <div class="goto_top" title="go to top">
        </div> 
    <script type="text/javascript">
        $(function(){
            $(window).scroll(function(){
                if ($(window).scrollTop() > 200){
                    $(".goto_top").fadeIn(1000);
                }
                else
                {
                    $(".goto_top").fadeOut(1000);
                }
            });
            $(".goto_top").on("click",function(){
                $("html,body").animate({scrollTop:0},800);
            })
        })
    </script>  
    </body>
</html>