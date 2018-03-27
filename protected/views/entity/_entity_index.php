<?php $eUrl = Yii::app()->createUrl('entity/list', array('entity' => Entity::GetUrlKey($entity))); ?>

<div class="news_box nb<?= $entity ?>">
    <div class="container">
        <div class="title">
            <?= $ui->item("A_NEW_NEW_CATEGORY"); ?> <a href="<?= $eUrl; ?>" id="enity<?= $entity ?>"><b><?= Entity::GetTitle($entity); ?></b></a>        
            <div class="pult">
                <a href="javascript:;" onclick="$('.nb<?= $entity ?> .btn_left.slick-arrow').click()" class="btn_left"><img src="/new_img/btn_left_news.png" alt=""/></a>
                <a href="javascript:;" onclick="$('.nb<?= $entity ?> .btn_right.slick-arrow').click()" class="btn_right"><img src="/new_img/btn_right_news.png" alt=""/></a>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.cnt<?= $entity ?> ul').slick({
                lazyLoad: 'ondemand',
                slidesToShow: 6,
                slidesToScroll: 6
            });
        });
    </script>

    <div class="container cnt<?= $entity ?>">
        <ul class="books">
            <?php
            //for ($i = 0; $i < 2; $i++) {
                foreach ($group as $item) :
                    ?>
                    <?php $item['status'] = Product::GetStatusProduct($entity, $item['id']);?>
                    <li>
        <?php $this->renderPartial('/entity/_render_index_item', array('item' => $item)); ?>
                    </li>

    <?php endforeach;
//} ?>	
        </ul>
    </div>
</div>