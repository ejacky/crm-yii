<div class="page_error" >
<p>您提交的信息中需要修正：</p>
<ul>
	<?php if (is_array($errorInfo)) : ?>
		<?php foreach ($errorInfo as $info): ?>
		<li><?php echo $info; ?></li>
		<?php endforeach; ?>
	<?php else: ?>
		<li><?php echo $errorInfo; ?></li>
	<?php endif; ?>
</ul>
</div>