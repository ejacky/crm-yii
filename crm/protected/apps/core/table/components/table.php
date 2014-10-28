<?php
//pa_table中的基本数据
$tableInfo = TableModel::model()->findByAttributes(array('name' => $name));
//pa_table_item中的数据
$itemModels = TableItemModel::model()->findAllByAttributes(array('table_name' => $tableInfo->name, 'enable' => 1));
//查询结果的字段集
//$fieldArray = TableHelper::getFieldArray($tableInfo->sql);
//处理分页的数据

$currentPage = $page;

$rowInPage = $tableInfo['numPerPage'];
$limitStart = ($currentPage - 1) * $rowInPage;

// 实现对总数的计算
$sql = $tableInfo->sql." LIMIT $limitStart, $rowInPage";
$sql = preg_replace('/^select/i', 'SELECT SQL_CALC_FOUND_ROWS', $sql);

// 实现对排序功能的自动处理
if ($orderBy)
{
	if (preg_match('/order by /i', $sql, $matchs))
	{
		$sql = preg_replace('/order *by *[a-zA-Z.]* *(asc|desc)/i', "ORDER BY $orderBy", $sql);
	}
	else
	{
		$sql = preg_replace('/( limit.*)?(;?)$/i', " ORDER BY $orderBy$0", $sql, 1);
	}
}

// 实现对where条件的判断
if ($condition)
{
	parse_str($condition, $conditions);
	
	$sql = preg_replace('/\{([^}]*)\}/e', '$conditions[\'$1\']', $sql);
	$sql = preg_replace('/\{([^}]*)\}/e', '1', $sql);
}

$resultInfo = TableHelper::getResultArray($sql);
$totalRows = TableHelper::getResultArray('SELECT FOUND_ROWS() as `total`');
$totalRows = $totalRows[0]['total'];

$pagerInfo = Tools::getPagerInfo($totalRows, $currentPage, $rowInPage, 8);

?>

<div class="grid-view" id="tableContent">
<div align="center"><?php echo $tableInfo['label'] ?></div><table class="items">
<thead>
<tr>
<?php foreach ($itemModels as $item): ?>
<th id="company-grid_c0" class="link-column">
	<?php if ($item['itemOrder'] == 'true') : ?>
	<?php
	if (preg_match('/desc$/i', $orderBy, $matchs))
	{
		$currentOrderWay = 'DESC';
		$newOrderWay = 'ASC';
	}
	else
	{
		$currentOrderWay = 'ASC';
		$newOrderWay = 'DESC';
	}
	?>
	
		<a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', <?php echo $currentPage ?>, '<?php echo $item['itemName']." $newOrderWay" ?>', '<?php echo $condition ? "$condition" : ''?>')"><?php echo $item['title'] ? $item['title'] : $item['itemName'] ?></a>
	<?php else: ?>
		<?php echo $item['title'] ? $item['title'] : $item['itemName'] ?>
	<?php endif; ?>
</th>
<?php endforeach; ?>
</thead>
<?php foreach ($resultInfo as $key => $row): ?>
<?php
$oddOrEven = ($key%2) ? 'odd' : 'even';
?>
<tr class="<?php echo $oddOrEven ?>">
	<?php foreach ($itemModels as $item) : ?>
	<?php if ($item['itemName'] == 'operater') : ?>
	<td><?php echo preg_replace('/\{([^}]*)\}/e', '$row[\'$1\']', $item['html']) ?></td>
	<?php else : ?>
		<td><?php echo call_user_func_array($item['itemDisplayMethod'], array($row[$item['itemName']], $row, $resultInfo)) ?></td>
	<?php endif; ?>

	<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table><div class="summary"> 共 <?php echo $totalRows ?> 条.</div>
<div class="pager">翻页: <ul class="yiiPager" id="yw0">
		<li class="first <?php echo 1 == $currentPage ? 'hidden' : '' ?>" style="display: none;"><a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', 1, '<?php echo $orderBy ? "$orderBy" : ''?>', '<?php echo $condition ? "$condition" : ''?>')">&lt;&lt; 首页</a></li>
<li class="previous <?php echo 1 == $currentPage ? 'hidden' : '' ?>"><a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', <?php echo $pagerInfo['pagePrevious'] ?>, '<?php echo $orderBy ? "$orderBy" : ''?>', '<?php echo $condition ? "$condition" : ''?>')">&lt; 前页</a></li>
<?php foreach ($pagerInfo['pageArea'] as $pageArea) : ?>
<li class="page <?php echo $pageArea == $currentPage ? 'selected' : '' ?>"><a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', <?php echo $pageArea ?>, '<?php echo $orderBy ? "$orderBy" : ''?>', '<?php echo $condition ? "$condition" : ''?>')"><?php echo $pageArea ?></a></li>
<?php endforeach; ?>
<li class="next <?php echo $pagerInfo['pageEnd'] == $currentPage ? 'hidden' : '' ?>"><a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', <?php echo $pagerInfo['pageNext'] ?>, '<?php echo $orderBy ? "$orderBy" : ''?>', '<?php echo $condition ? "$condition" : ''?>')">后页 &gt;</a></li>
<li class="last"><a href="javascript:void(0)" onclick="displayTable('<?php echo $name ?>', <?php echo $pagerInfo['pageEnd'] ?>, '<?php echo $orderBy ? "$orderBy" : ''?>', '<?php echo $condition ? "$condition" : ''?>')">末页 &gt;&gt;</a></li></ul>
</div>
</div>
<style>
.grid-view-loading
{
	background:url(/images/table/loading.gif) no-repeat;
}

.grid-view
{
	padding: 15px 0;
}

.grid-view table.items
{
	background: white;
	border-collapse: collapse;
	width: 100%;
	border: 1px #D0E3EF solid;
}

.grid-view table.items th, .grid-view table.items td
{
	border: 1px white solid;
	padding: 0.3em;
}

.grid-view table.items th
{
	color: white;
	background: url("/images/table/bg.gif") repeat-x scroll left top white;
	text-align: center;
}

.grid-view table.items th a
{
	color: #EEE;
	font-weight: bold;
	text-decoration: none;
}

.grid-view table.items th a:hover
{
	color: #FFF;
}

.grid-view table.items th a.asc
{
	background:url(/images/table/up.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items th a.desc
{
	background:url(/images/table/down.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items tr.even
{
	background: #F8F8F8;
}

.grid-view table.items tr.odd
{
	background: #E5F1F4;
}

.grid-view table.items tr.selected
{
	background: #BCE774;
}

.grid-view table.items tr:hover
{
	background: #ECFBD4;
}

.grid-view .link-column img
{
	border: 0;
}

.grid-view .button-column
{
	text-align: center;
	width: 60px;
}

.grid-view .button-column img
{
	border: 0;
}

.grid-view .checkbox-column
{
	width: 15px;
}

.grid-view .summary
{
	margin: 0 0 5px 0;
	text-align: right;
}

.grid-view .pager
{
	margin: 5px 0 0 0;
	text-align: right;
}

.grid-view .empty
{
	font-style: italic;
}

.grid-view .filters input,
.grid-view .filters select
{
	width: 100%;
	border: 1px solid #ccc;
}
ul.yiiPager
{
	font-size:11px;
	border:0;
	margin:0;
	padding:0;
	line-height:100%;
	display:inline;
}

ul.yiiPager li
{
	display:inline;
}

ul.yiiPager a:link,
ul.yiiPager a:visited
{
	border:solid 1px #9aafe5;
	font-weight:bold;
	color:#0e509e;
	padding:1px 6px;
	text-decoration:none;
}

ul.yiiPager .page a
{
	font-weight:normal;
}

ul.yiiPager a:hover
{
	border:solid 1px #0e509e;
}

ul.yiiPager .selected a
{
	background:#2e6ab1;
	color:#FFFFFF;
	font-weight:bold;
}

ul.yiiPager .hidden a
{
	border:solid 1px #DEDEDE;
	color:#888888;
}

/**
 * Hide first and last buttons by default.
 */
ul.yiiPager .first,
ul.yiiPager .last
{
	display:none;
}
</style>