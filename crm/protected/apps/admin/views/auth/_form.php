<?php $form=$this->beginWidget('CActiveForm',array(
    'id' => 'company-form',
)); ?>

<div id="tabs">
<ul>
<?php foreach ($groupList as $subList) : ?>
<li><a href="#<?php echo $subList->groupName;?>"><?php echo $subList->groupName;?></a></li>
<?php endforeach; ?>
</ul>
<?php echo $form->errorSummary($model); ?>
<?php foreach ($groupList as $subList) : ?>
 <div id="<?php echo $subList->groupName;?>">
<?php

$exValue = isset($exValue) ? $exValue : null;
$exKeyValue = isset($exKeyValue) ? $exKeyValue : null;
$formView = new FormView($model);
foreach ($model1 as $sub)
{
	echo "<div class='".$sub->name."'>";
    echo "<table>";
	switch ($sub->type)
	{
		case 'hideText':  echo $formView->hideText( $sub ) ;  break;
		case 'text':  echo $formView->getText( $sub ) ;  break;
		case 'select': echo $formView->getSelect( $sub ) ;  break;
		case 'textarea': echo $formView->getTextarea( $sub ) ; break;
		case 'exSelect': echo $formView->getexSelect( $sub, $exValue, 'Multi' ) ;  break;
		case 'checkbox': echo $formView->checkbox( $sub, $exKeyValue ) ;  break;
	}
    echo "</table>";
    echo "</div>";
}
?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" onclick="return false;"></td></tr></table>
</div>
<?php endforeach; ?>
</div>

<?php  $this->endWidget(); ?>
<form id="addOption"></form>
<div id="imageSelect"></div>

<span class="template optionModel">
	<input type="text" name="form[add]" value="" />&nbsp;&nbsp;<input type="text" name="form[add][sequence]" value="" />
	<input class="deleteOption" type="button" value="删除" /><br/>
</span>

<div class="template uploadPic">
	<h2>Upload Photo</h2>
	<form class="upload" name="photo" enctype="multipart/form-data" action="uploadPic" method="post">
	Photo <input type="file" name="file" /> <input type="submit" name="upload" value="Upload" onclick="return false;"/>
	</form>
</div>

<div class="template Thumbnail">
	<div align="center">
		<img alt="Create Thumbnail" class="thumbnail" style="float: left; margin-right: 10px;" src="">
		<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:100px; height:100px;">
			<img class="preview" alt="Thumbnail Preview" style="position: relative;" src="">
		</div>
		<br style="clear:both;">
		<form method="post" action="UploadAvatar" name="thumbnail">
			<input type="hidden" class="x" value="" name="x">
			<input type="hidden" class="y" value="" name="y">
			<input type="hidden" class="w" value="" name="w">
			<input type="hidden" class="h" value="" name="h">
			<input type="hidden" class="src" value="" name="pictureSrc">
			<input type="submit" class="save_thumb" value="Save Thumbnail" name="upload_thumbnail" onclick="return false">
		</form>
	</div>
</div>

<script>
$(function(){
	
    $("textarea[name='form[span-test1]']").blur(function() {
        alert($(this).text());
    });
    $('#tabs').tabs();  
    $('#saveForm').click(function () {
        var canSubmit;
        canSubmit = true;       
        $('input[type="text"]').each(function () {            
            inputValue = $(this).val();
            nameArray = $(this).attr('name');
            name = fetchName(nameArray, '[', ']');       
                  
            if ($('.span2-'+name).text() == '*') {
               
                if (inputValue == '') { 
                    canSubmit = false;
                    $('.span-'+name).text('不能为空！');
                    return ;
                } 
            }
        });

        if (canSubmit) {
            $('#company-form').submit();
        }
    });
});   


function fetchName(Str, mixValue, maxValue)
{
    $.each(Str, function(key, value) {
            if (value == mixValue) {
                minKey = key;
            }
            if (value == maxValue) {
                maxKey = key;
            }
        });
       
        var nameValue = new Array();
        
        for (i = maxKey-1;i > minKey; i--) {
            nameValue = Str[i] + nameValue;
        }
        
        return nameValue;
}
</script>