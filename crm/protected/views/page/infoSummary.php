<div class="page_info" >
<ul>
	<?php if (is_array($pageInfo)) : ?>
		<?php foreach ($pageInfo as $info): ?>
		<li><?php echo $info; ?></li>
		<?php endforeach; ?>
	<?php else: ?>
		<li><?php echo $pageInfo; ?></li>
	<?php endif; ?>
</ul>
</div>