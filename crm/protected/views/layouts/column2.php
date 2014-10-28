<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div>
</div>
<div class="span-5 last" style="float: right;">
    <div id="sidebar">
        <?php
        
		$siderMenu = SideMenu::getSideMenu();
        
        foreach ($siderMenu as $key => $items) {
            foreach ($items['subitem'] as $subKey => $item) {
                if ($item['flag'] == $this->action->id) {
                    $siderMenu[$key]['subitem'][$subKey]['class'] = 'on';
                }
            }
        }
	?>
        <div id="sidemenu">
            <ul>
                <?php foreach ($siderMenu as $items) : ?>
                    <li><a class="sidemenu" href="javascript:void(0)" id=""><?php echo $items['name'] ?>
                        </a>
                        <ul>
                            <?php foreach ($items['subitem'] as $item) : ?>
                                <li><a class="sub_sidemenu<?php if (@$item['class'] == 'on') { echo " on"; } ?>" href="<?php echo $item['href'] ?>"
                                       id="<?php if ($item['name'] == '上传文件') echo 'upload'; ?>"><?php echo $item['name'] ?>
                                    </a>
                                </li>
                    		<?php endforeach; ?>
                        </ul>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
