<table width="100%" height="100%" border="0" cellpadding="0"
	cellspacing="0">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	'enableAjaxValidation'=>false,
	)); ?>
	<tr>
		<td bgcolor="#e5f6cf">&nbsp;</td>
	</tr>
	<tr>
		<td height="608" background="/upload/login/login_03.gif">
		<table width="862" border="0" align="center" cellpadding="0"
			cellspacing="0">
			<tr>
				<td height="266" background="0/upload/login/register_04.gif">&nbsp;</td>
			</tr>
			<tr>
				<td height="95">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="424" height="95"
							background="0/upload/login/login_06.gif">&nbsp;</td>
						<td width="183" background="/upload/login/login_07.gif">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="21%" height="30">
								<div align="center"><span class="STYLE3"></span></div>
								</td>
								<td width="79%" height="30"><span>用户名:</span>
								<?php echo $form->textField($model,'username'); ?> <?php echo $form->error($model,'username'); ?></td>
							</tr>
							<tr>
								<td height="30">
								<div align="center"><span class="STYLE3"></span></div>
								</td>
								<td height="30"><span>密码：</span>
								<?php echo $form->passwordField($model,'password'); ?> <?php echo $form->error($model,'password'); ?></td>
							</tr>
							<tr>
								<td height="30">
								<div align="center"><span class="STYLE3"></span></div>
								</td>
								<td height="30"><span>重新输入密码：</span>
								<?php echo $form->passwordField($model,'re_password'); ?></td>
								<?php echo $form->error($model,'re_password'); ?>
								
							</tr>
							<tr>
								<td height="30">
								<div align="center"><span class="STYLE3"></span></div>
								</td>
								<td height="30"><span>邮箱：</span>
								<?php echo $form->textField($model,'email'); ?></td>
								<?php echo $form->error($model,'email'); ?>
								</td>
							</tr>
							<tr>
								<td height="30">&nbsp;</td>
								<td height="30"><?php echo CHtml::submitButton('提交'); ?></td>
								<td height="30"><a href="/admin.php/loign/index">登陆</a></td>
								
							</tr>
							<tr>
								<td height="30">&nbsp;</td>
								
							</tr>
						</table>
						</td>
						<td width="255" background="0/upload/login/login_08.gif">&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td height="247" valign="top"
					background="0/upload/login/login_09.gif">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="22%" height="30">&nbsp;</td>
						<td width="56%">&nbsp;</td>
						<td width="22%">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="30">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="44%" height="20">&nbsp;</td>
								<td width="56%" class="STYLE4">版本 2012V1.0</td>
							</tr>
						</table>
						</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#a2d962">&nbsp;</td>
	</tr>

</table>
								<?php $this->endWidget(); ?>

