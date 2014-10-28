<?php

class formTemplate
{
	public static $allTemplate = '
<div id="addOption"></div>

<div id="imageSelect"></div>

<span class="template optionModel">
	<input type="text" disabled="disabled" name="form[add][key]" value="" />&nbsp;
	<input type="text" disabled="disabled" name="form[add][value]" value="" />&nbsp;
	<input type="text" disabled="disabled" name="form[add][sequence]" value="" /><input class="deleteOption" type="button" value="删除" /><br/>
</span>

<div class="template uploadPic">
	<h2>Upload Photo</h2>
	<form class="upload" name="photo" enctype="multipart/form-data" action="/index.php/CommonInterface/uploadPic" method="post">
	Photo <input type="file" name="file" onChange="UploadFile()"/>
	</form>
</div>

<div class="template templateThumbnail">
	<div align="center">
		<img alt="Create Thumbnail" style="float: left; margin-right: 10px;" src="">
		<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:100px; height:100px;">
			<img alt="Thumbnail Preview" style="position: relative;" src="">
		</div>
		<br style="clear:both;">
		<form method="post" action="/index.php/CommonInterface/UploadAvatar" name="thumbnail">
			<input type="hidden" class="x" value="" name="x">
			<input type="hidden" class="y" value="" name="y">
			<input type="hidden" class="w" value="" name="w">
			<input type="hidden" class="h" value="" name="h">
			<input type="hidden" class="src" value="" name="pictureSrc">
			<input type="submit" class="save_thumb" value="Save Thumbnail" name="upload_thumbnail" onclick="return false">
		</form>
	</div>
</div>';

}