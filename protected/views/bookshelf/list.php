<table width="100%" cellspacing="0" cellpadding="0" border="0" style="vertical-align:top">
    <tr>
        <td class="leftmnu" width="20%" valign="top">
            <?php $this->renderPartial('/entity/_left_text'); ?>
            <?php $this->renderPartial('/site/login_form', array('model' => new User)); ?>
        </td>
        <td valign="top" style="padding: 5px;">
            <!-- content -->
            <?php $this->widget('TopBar', array('breadcrumbs' => $this->breadcrumbs)); ?>
            <!-- /content -->

            <h3 style="font-size: 18px; margin-left: 10px;"><?=$ui->item('BOOKSHELF_LIST'); ?>:</h3>
            <?php

            $models = $dp->getData();
            if(!empty($models)) : ?>
                <table class="table table-triped">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model) : ?>
                        <tr>
                        <td><?=Yii::app()->dateFormatter->format('dd MMM yyyy', $model['date_of']); ?></td>
                        <td><a href="<?=Yii::app()->createUrl('/bookshelf/view', array('id' => $model['bookshelf_id'])); ?>"><?=CHtml::encode($model['title']); ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?php $this->widget('MyLinkPager', array('pages' => $dp->getPagination(),
                    'header' => sprintf(Yii::app()->ui->item('PAGES'), ''),
                    'nextPageLabel' => '',
                    'prevPageLabel' => '',
                    'firstPageLabel' => '',
                    'lastPageLabel' => '',
                    'separator' => '<span class="mainpg2"> | </span>',
                    'htmlOptions' => array('class' => 'pager')));

                ?>

            <?php else : ?>

            <p>No data</p>

            <?php endif; ?>
        </td>
        <td width="220" valign="top" style="padding-left: 10px; padding-right: 10px; padding-top: 10px;">
            <?php $this->widget('Banners', array('entity' => 'index')); ?>
        </td>
    </tr>

</table>