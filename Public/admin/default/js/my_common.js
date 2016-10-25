//是否删除
function delete_data(id)
{   
    var note_title = $('#note_title').val();
    var note_content = $('#note_content').val();
    var note_sure = $('#note_sure').val();
    var note_cancel = $('#note_cancel').val();
	$.confirm({
    title: note_title,
    content: note_content,
    confirmButton: note_sure,
    cancelButton: note_cancel,
    closeIcon: false,
    confirm: function(){
        var url = $('#delete_'+id).val();
    	if(url != 'undefined' && url != '')
    	{
           window.location.href = url;
    	}
    },
    cancel: function(){
    }
	});
}
//提示框
function alert_message(title,content)
{   
    var note_sure = $('#note_sure').val();
    $.alert({
    title: title,
    content: content,
    confirmButton: note_sure,
    });
}
