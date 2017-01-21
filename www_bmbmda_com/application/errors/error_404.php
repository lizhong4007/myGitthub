<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
body{
    background: #0871C0;
}
*{
    margin:0 auto;
    padding: 0;
}
.error_404{
    margin-top: 100px;
    width: 900px;
    height: 500px;
}
.error_404 .error_title{
    height: 100px;
    text-align: center;
    width: 900px;
    line-height: 100px;
    color: #fff;
}
.error_404 .error_content{
    padding-left: 2em;
    background: #fff;
    width: 900px;
    height: 400px;
    border-radius: 25px;
}
.error_404 .error_content h3{
    padding-top: 30px;
    color: #0f5489;
    font-size: 2em;
}
.error_404 .error_content .error_content_1{
    margin-top: 20px;
    font-size: 1.5em;
    color: #333;
}
.error_404 .error_content .error_content_1 a{
    color: #0f5489;
    text-decoration: none;
    font-size: 1.5em;
}
.error_404 .error_content .error_content_1 a:hover{
    color: #f00;
}
</style>
</head>
<body>
    <div class="error_404">
        <div class="error_title">
            <h2>404 Page Not Found</h2>
        </div>
        <div class="error_content">
            <h3>Opps!</h3>
            <div class="error_content_1">The site you want to find losting ......</div>
            <div class="error_content_1">You may want to <a href="/">go home</a></div>
        
        </div>
    </div>
</body>
</html>