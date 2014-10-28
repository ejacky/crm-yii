<div style="margin-left: 500px">
<form method="get" action="/index.php/file/index">
<input name="name" type="text"/><input type="submit" value="查询"/>
</form>
</div>

<div style="overflow:auto;overflow-y:hidden;">
	<div id="tableContent"></div>
</div>
<script>
displayTable('<?php echo $name ?>');
</script>