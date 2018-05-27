<?php
$this->widget('TopBar', array('breadcrumbs' => $this->breadcrumbs)); ?>

<?php if (!empty($list)): ?>
<div class="container view_product">
	<div class="row">
        <div class="span10">
            <div class="text">
                <ul class="list" id="al">
                    <?php foreach($list as $item) :
	                    $url = Yii::app()->createUrl('/entity/bysubtitle', array('entity' => Entity::GetUrlKey($entity), 'sid' => $item['id'], 'title' => ProductHelper::ToAscii($item['title']))); ?>
                        <li style="margin-bottom: 10px; margin-right: 20px; width: 150px; float: left;"><a href="<?= $url ?>" title="<?= htmlspecialchars($item['title']) ?>"><?= $item['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
				<div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
