<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>添加地区</title>
<meta name="robots" content="noindex,nofollow">
</head>

<body>
<p>系列表：</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">系列 seriesid</th>
        <th width="100">brandid</th>
        <th width="100">catid</th>
        <th width="100">资源id</th>
        <th>图片</th>
        <th>series_name</th>
        <th>图片3</th>
	</tr>
	<?php foreach ($series as $key=>$value):?>
	<tr>
	    <td><?=$value['seriesid']?></td>
	    <td><?=$value['brandid']?></td>
	    <td><?=$value['catid']?></td>
	    <td><?=$value['resids']?></td>
	    <td><img src="<?=$value['thumb']?>"></td>
	    <td><?=$value['series_name']?></td>
	</tr>
	<?php endforeach?>
</table>
<p></p>
<p></p>

<p></p>
<p></p>
<p></p>
<p>型号</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">型号modelid</th>
        <th width="100">系列 seriesid</th>
        <th width="">型号</th>
        <th width="">品牌id</th>
        <th width="">linkurl</th>
        <th width="">图片</th>
        <th width="">资源</th>
	</tr>
	<?php foreach ($model as $key=>$value):?>
	<tr>
	    <td><?=$value['modelid']?></td>
	    <td><?=$value['seriesid']?></td>
	    <td><?=$value['model']?></td>
	    <td><?=$value['brandid']?></td>
	    <td><?=$value['linkurl']?></td>
	    <td><?=$value['thumb']?></td>
	    <td><?=$value['resids']?></td>
	</tr>
	<?php endforeach?>
</table>

<p></p>
<p></p>
<p></p>
<p>型号参数</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">型号modelid</th>
        <th width="">参数名</th>
        <th width="">参数值</th>
	</tr>
	<?php foreach ($model_para as $key=>$value):?>
	<tr>
	    <td><?=$value['modelid']?></td>
	    <td><?=$value['param']?></td>
	    <td><?=$value['value']?></td>
	</tr>
	<?php endforeach?>
</table>

<p></p>
<p></p>
<p></p>
<p>goods表</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">itemid</th>
        <th width="">catid</th>
        <th width="">seriesid</th>
        <th width="">brandid</th>
        <th width="">modelid</th>
        <th width="">title</th>
        <th width="">introduce</th>
        <th width="">min_price</th>
        <th width="">max_price</th>
        <th width="">addtime</th>
        <th width="">thumb</th>
        <th width="">linkurl</th>
        <th width="">companyid</th>
	</tr>
	<?php foreach ($goods as $key=>$value):?>
	<tr>
	    <td><?=$value['goodsid']?></td>
	    <td><?=$value['catid']?></td>
	    <td><?=$value['seriesid']?></td>
	    <td><?=$value['brandid']?></td>
	    <td><?=$value['modelid']?></td>
	    <td><?=$value['title']?></td>
	    <td><?=$value['introduce']?></td>
	    <td><?=$value['min_price']?></td>
	    <td><?=$value['max_price']?></td>
	    <td><?=date('Y-m-d',$value['addtime'])?></td>
	    <td><img src="<?=$value['thumb']?>"></td>
	    <td><?=$value['linkurl']?></td>
	    <td><?=$value['companyid']?></td>
	</tr>
	<?php endforeach?>
</table>



<p></p>
<p></p>
<p></p>
<p>sell参数表</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">goodsid</th>
        <th width="">catid</th>
        <th width="">catids</th>
        <th width="">参数名</th>
        <th width="">参数值</th>
	</tr>
	<?php foreach ($category_option_para as $key=>$value):?>
	<tr>
	    <td><?=$value['goodsid']?></td>
	    <td><?=$value['catid']?></td>
	    <td><?=$value['catids']?></td>
	    <td><?=$value['param']?></td>
	    <td><?=$value['value']?></td>
	</tr>
	<?php endforeach?>
</table>


<p></p>
<p></p>
<p></p>
<p>资源表</p>
<table border="1px solid #ddd">
	<tr>
        <th width="100">resid</th>
        <th width="">res_type</th>
        <th width="">res_name</th>
        <th width="">resource</th>
        <th width="">remark</th>
	</tr>
	<?php foreach ($residsData as $key=>$value):?>
	<tr>
	    <td><?=$value['resid']?></td>
	    <td><?=$value['res_type']?></td>
	    <td><?=$value['res_name']?></td>
	    <td><?=$value['resource']?></td>
	    <td><?=$value['remark']?></td>
	</tr>
	<?php endforeach?>
</table>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p style="height:500px;"></p>
</body>
</html>