<div id="AccountInfo">
<table>
<tr style="background:none repeat scroll 0 0 #EBEBED !important"><td>修改人</td><!-- <td>修改的公司名称</td> --> <td>修改的内容</td><td>修改日期</td></tr>
<?php foreach ($showEmployeesLogs as $showEmployeesLog) :?>
<tr>
<td><?php echo Staff::model()->findByPk($showEmployeesLog->staff_id)->username; ?></td>
<!--  <td width="20%"><?php //echo $showCompanyLog->company->name;?></td>-->
<td><?php echo $showEmployeesLog->diff; ?></td>
<td><?php echo $showEmployeesLog->date; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
