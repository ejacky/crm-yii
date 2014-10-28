<table>
	<tr><th>列名</th><th>标题</th><th>显示方式</th><th>是否可以排序</th><th>是否启用</th></tr>
	<?php
	// 将 TableDisplay 类中的方法提取出来作为“显示方式”列的选择项
	$classNames = get_class_methods('TableDisplay');
	foreach ($classNames as $name)
	{
		$displayMethod["TableDisplay::$name"] = "TableDisplay::$name";
	}

	$i = 0;
	while ($i < mysql_num_fields($result)) {
		$meta = mysql_fetch_field($result, $i);

		$index = $i;
		// 用户可能会调整SQL中选出来项的次序，所以这里要遍历匹配后显示
		foreach ($model as $key => $row)
		{
			
			if (isset($row->itemName) && $row->itemName == $meta->name)
			{
				$index = $key;
			}
		}
		?>
			<tr>
				<td><?php echo $meta->name ?><?php echo CHTML::hiddenField("item[{$meta->name}][name]", $meta->name)?></td>
				<td><?php echo CHTML::textField("item[{$meta->name}][title]", isset($model[$index]) ? $model[$index]->title : '', array('style' => 'width:60px')) ?></td>
				<td><?php echo CHTML::dropDownList("item[{$meta->name}][displayMethod]", isset($model[$index]) ? $model[$index]->itemDisplayMethod : '', $displayMethod) ?></td>
				<td><?php echo CHTML::dropDownList("item[{$meta->name}][order]", isset($model[$index]) ? $model[$index]->itemOrder : '', array('false' => 'false', 'true' => 'true')) ?></td>
				<td><?php echo CHTML::dropDownList("item[{$meta->name}][enable]", isset($model[$index]) ? $model[$index]->enable : '', array('1' => 'true', '0' => 'false')) ?></td>
			</tr>
	
	<?php
		
	$i++;
		}
	?>
	<tr>
		<td>operater<?php echo CHTML::hiddenField("item[operater][name]", 'operater')?></td>
		<td><?php echo CHTML::textField("item[operater][title]", '操作', array('style' => 'width:50px')) ?></td>
		<td colspan="2"><?php echo CHTML::textArea("item[operater][html]", (isset($model[$i]) && isset($model[$i]->html)) ? $model[$i]->html : '', array('style' => 'width:230px;height:100px')) ?></td>
		<td><?php echo CHTML::dropDownList("item[operater][enable]", isset($model[$i]) ? $model[$i]->enable : '', array('1' => 'true', '0' => 'false')) ?></td>
	</tr>
</table>