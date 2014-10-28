<?php $this->renderPartial('application.apps.core.form.components._dataFormUpdate', array(
	'fields' => $fields,
	'formFields' => $formFields,
	'model'=>$model
)); ?>
<script>
executeSql = function()
{
	//$('textarea').val('select * from pa_table'); // used for debug
       
	sql = $('textarea').val();
	$.post('/index.php/table/tableSet/executeSql', { 'sql': sql, 'name': name }, callbackFunction);
}

callbackFunction = function(data)
{
	$('#field_content_test').html(data);
}
	
$('textarea').parent().append('<input id="executeSqlButton" type="button" value="解析" onclick="executeSql()">');
name = '<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>';
if (name)
{
	$('#executeSqlButton').click();
}
</script>







