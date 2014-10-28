<div id="AccountInfo">
<table>
<tr style="background:none repeat scroll 0 0 #EBEBED !important"><td>所在公司</td><td>员工姓名</td><td>员工电话</td><td>员工Email</td></tr>
<?php foreach ($showEmployeesInfo as $showEmployeeInfo) :?>
<tr>
<td><?php echo $showEmployeeInfo->company->name;?></td>
<td width="20%"><a href="/admin.php/clientEmployees/view?employee_id=<?php echo $showEmployeeInfo->id; ?>"><?php echo $showEmployeeInfo->name;?></a></td>
<td><?php echo $showEmployeeInfo->phone; ?></td>
<td><?php echo $showEmployeeInfo->email; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
