<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
    </head>
<body>

<style type="text/css">
	*{
		margin:  0 auto;
		padding: 0;
	}
	.series{
		width: 500px;
		margin-top: 50px;
		height: 500px;
	}
	.series input{
		height: 30px;
		width: 500px;
		margin-top: 5px;
	}
	.btn{
		width: 60px !important;
	}
</style>
<div class="series">
<form action="{:U('Egg/save_data')}" method="post">
	<div>
		<input type="text" name="post_url" value="" />
	</div>
	<div>
		<input type="text" name="catname" value="" />
	</div>
	<div>
		<input type="submit" class="btn"  value="提交" />
	</div>
</form>
</div>
</body>
</html>