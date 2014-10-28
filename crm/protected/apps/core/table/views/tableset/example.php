<?php echo CHTML::link('编辑', '/admin.php/tableSet/tableIndex?name='.$_GET['name']) ?>
<div style="overflow:auto;overflow-y:hidden;">
	<div id="tableContent"></div>
</div>
<script>
displayTable('<?php echo $name ?>');
</script>