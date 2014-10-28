$(function () {
        displayPostAttach(name);
});

function displayPostAttach(name) {
		alert(name);
	    $('#file_upload_' + name).uploadify({
			'swf'			 : '/uploadify/uploadify.swf',
			'uploader'		: '/index.php/CommonInterface/UploadAttach',
			'cancelImg'		  : '/uploadify/uploadify-cancel.png',
			'onUploadSuccess' : function(file, data, response) {
				$('#file_box_' + name).append( '<div class="uploadify-queue-item" ><div class="cancel"><a class="uploadify-queue" href="javascript:fileDelete(\''+data+'\')">X</a></div><span class="fileName">'+file.name+'</span><span class="data"> - 完成</span><input type="hidden" name="form['+data+'][id]" value="'+data+'"/><input type="hidden" name="form['+data+'][name]" value="'+file.name+'"/><input type="hidden" name="form['+data+'][ext]" value="'+file.type+'"/></div>' )
			}
		});
		$('#file_upload_' + name).uploadify('settings','buttonText','选择文件');
		$('.uploadify-queue').live('click',function(){
			$(this).closest('.uploadify-queue-item').remove()
		});
}