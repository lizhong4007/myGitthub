<meta charset="utf-8"/>
<script type="text/javascript" src="__PUBLIC__/upload/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/upload/swfupload.js"></script>
<script type="text/javascript" src="__PUBLIC__/upload/hander.js"></script>
<script>
    $(function(){
	var url  = "{:C('UPLOAD_FILE_URL')}";
	var upload_button_path = window.location.host;
	var type = $('#savedir').val();
	var image= new Array();
	image[0] = "http://"+upload_button_path+"/Public/upload/swfupload.swf";
	image[1] = "http://"+upload_button_path+"/Public/upload/upload.png";
	image[2] = "{:L('UPLOAD_IMAGE')}";
	$(".fileupload").each(function(index, obj){
		var callback = $(obj).attr('data-callback');
		var id   = $(obj).attr('id');
		var data = {callback:callback,type:type};
		// var data = {callback:callback,thumb_width:thumb_width,thumb_height:thumb_height};
		uploadImages(url,data,id,image);
	});
});
</script>
<!-- 使用方法 -->
<!-- <input type="hidden" value="brand" id="savedir" />上传文件路径 -->
<!-- <span class="fileupload" data-callback="setgoodimg" id="filepicker"></span>
加载 include = fileupload.tpl -->