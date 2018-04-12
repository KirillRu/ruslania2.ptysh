<?php $this->widget('TopBar', array('breadcrumbs' => $this->breadcrumbs)); ?><div class="container content_books">
    <div class="row">
        <div class="span2">
            
			<?php if (!empty($categoryList)) : ?>
                <h2 class="cattitle">Категории:</h2>
                <ul class="left_list divider">
				
					<li><a href=""><b><?=((!$cid) ? Entity::GetTitle($entity) : $title_cat); ?></b></a></li>
				
                    <?php

                    function getSubCategoryes($entity, $cid, $lvl = 1) {

                        $rows = Category::exists_subcategoryes($entity, $cid);

                        if (count($rows)) {

                            echo '<ul style="margin-right: 20px;" class="subcat sc' . $cid . ' lvlcat'.$lvl.'" rel="' . $cid . '">';
                            foreach ($rows as $cat) :
                                echo '<li>';
                                if (count(Category::exists_subcategoryes($entity, $cat['id']))) {
                                    echo '<a href="javascript:;" class="open_subcat subcatlvl'.($lvl+1).'" onclick="show_sc($(\'ul.sc' . $cat['id'] . '\'), $(this), '.($lvl+1).')"></a>';
                                }
                                echo '<a href="' . Yii::app()->createUrl('entity/list', array('entity' => Entity::GetUrlKey($entity), 'cid' => $cat['id'], 'title' => ProductHelper::ToAscii($cat['title_en']))) . '">' . ProductHelper::GetTitle($cat) . '</a>';


								getSubCategoryes($entity, $cat['id'], $lvl + 1);
                                echo '</li>'; 
                                
                            endforeach;

                            echo '</ul>';
                        }
                    }

                    foreach ($categoryList as $cat) :
                        ?>
                        <li>
                            <? if (count(Category::exists_subcategoryes($entity, $cat['id']))) {?>
                            <a href="javascript:;" class="open_subcat subcatlvl1" onclick="show_sc($('ul.sc<?= $cat['id'] ?>'), $(this), 1)"></a>
                            <?} ?>
                            <a href="<?= Yii::app()->createUrl('entity/list', array('entity' => Entity::GetUrlKey($entity), 'cid' => $cat['id'], 'title' => ProductHelper::ToAscii($cat['title_en']))); ?>"><?= ProductHelper::GetTitle($cat); ?></a>



                            <!--                        (--><?//=$cat['items_count']; ?><!-- / --><?//=$cat['avail_items_count']; ?><!--)-->
							<?getSubCategoryes($entity, $cat['id'], 1);?>
                        </li>
                        
                    <?php endforeach; ?>
                </ul>
				
				<a href="<?=Yii::app()->createUrl('entity/categorylist', array('entity' => Entity::GetUrlKey($entity))); ?>" class="order_start" style="width: 100%"><?=$ui->item('A_NEW_VIEW_ALL_CATEGORY'); ?></a>
				
                <div style="height: 47px"></div>
            <?php endif; ?>
			

            <h2 class="filter"><?=$ui->item('A_NEW_SETTINGS_FILTER'); ?>:</h2>

            <form method="post" action="" class="filter">
			
                <input type="hidden" name="langsel" class="langsel" value="<?=$_GET['lang']; ?>"/>
                <input type="hidden" name="entity_val" class="entity_val" value="<?= $entity ?>"/>
                <input type="hidden" name="cid_val" class="cid_val" value="<?= $cid ?>"/>
                <input type="hidden" name="sort" class="sort" value="<?= ($_GET['sort']) ? $_GET['sort'] : 12 ?>"/>
                <div class="form-row">
                    <label class="title"><?=$ui->item('A_NEW_SEARCH_CAT'); ?></label>
                    <input type="text" class="search inp" placeholder="<?=$ui->item('A_NEW_NAME_ISBN'); ?>" name="name_search" onkeyup="if ($(this).val().length > 2) { show_result_count($(this)); } else { $('.box_select_result_count').hide(1); }"/>
                    <div class="box_select_result_count">
                        <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div> <?=$ui->item('A_NEW_FILTER_SELECT')?>:
                        <span class="res_count"></span>
                        <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                    </div>
                </div>
                <?php if (!empty($authors)) { ?>
                    <div class="form-row">
                        <div class="box_select_result_count">
                            <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                            <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                            <span class="res_count"></span>
                            <a href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                        </div>
                        <label class="title"><?=$ui->item('A_NEW_FILTER_AUTHOR'); ?></label>

                        <div class="dd_box_select" style="z-index: 9">

                            <div class="arrow_d" onclick="$('.list_dd', $(this).parent()).toggle()"></div>
                            <input type="hidden" name="author" value="0">
                            <div class="text" onclick="$('.list_dd', $(this).parent()).toggle()">
                                <span><?if ($filter_data['author'] == '' OR $filter_data['author'] == '0') { echo $ui->item('A_NEW_FILTER_ALL'); } else { $row = CommonAuthor::GetById($filter_data['author']); echo $row['title_' . Yii::app()->language]; }?></span> 
                            </div>
                            <div class="list_dd authors_dd">
                                <div class="items">
                                    <div class="rows">
                                        <div class="item" rel="0" onclick="select_item($(this), 'author')"><?=$ui->item('A_NEW_FILTER_ALL'); ?></div>
                                        <?php
                                        foreach ($authors as $author => $binfo) {
                                            $row = CommonAuthor::GetById($binfo['author_id']);
                                            if (!$row['id'] OR $row['id'] == '0')
                                                continue;
                                            $name_publ = $row['title_' . Yii::app()->language];
                                            if (!trim($name_publ))
                                                continue;
											
											$selact = ' selact';
											
											if ($row['id'] != $filter_data['author']) {
												$selact = '';
											}

                                            echo '<div class="item'.$selact.'" rel="' . $row['id'] . '" onclick="select_item($(this), \'author\')">' . $name_publ . '</div>';
                                        }
                                        ?>

                                    </div>
                                    <div class="load_items"></div>
                                </div>
                            </div>
                        </div>

                    </div> <?php } ?>
                <div class="form-row">
                    <div class="box_select_result_count">
                        <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                        <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                        <span class="res_count"></span>
                        <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                    </div>
                    <label class="title"><?=$ui->item('CART_COL_ITEM_AVAIBILITY')?></label>
                    <div class="dd_box_select" style="z-index: 8">

                        <div class="arrow_d" onclick="$('.list_dd', $(this).parent()).toggle()"></div>
                        <input type="hidden" name="avail" value="0">
                        <div class="text" onclick="$('.list_dd', $(this).parent()).toggle()"><span><?=(($filter_data['avail'] == 0) ? $ui->item('A_NEW_FILTER_ALL') : $ui->item('A_NEW_FILTER_AVAIL') ); ?></span></div>
                        <div class="list_dd">
                            <div class="items">
                                <div class="rows">
								
                                    <div class="item<?=(($filter_data['avail'] == 0) ? ' select' : '' ); ?>" rel="0" onclick="select_item($(this), 'avail')"><?=$ui->item('A_NEW_FILTER_ALL'); ?></div>
                                    <div class="item<?=(($filter_data['avail'] == 1) ? ' select' : '' ); ?>" rel="1" onclick="select_item($(this), 'avail')"><?=$ui->item('A_NEW_FILTER_AVAIL')?></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<? if ($langVideo) {?>
				
				<div class="form-row"><div class="box_select_result_count">
                        <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                        <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                        <span class="res_count"></span>
                        <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                    </div>
                    <label class="title">Язык звуковой дорожки</label>
                    <div class="dd_box_select" style="z-index: 8">

                        <div class="arrow_d" onclick="$('.list_dd', $(this).parent()).toggle()"></div>
                        <input type="hidden" name="langVideo" value="0">
                        <div class="text" onclick="$('.list_dd', $(this).parent()).toggle()"><span>Язык звуковой дорожки</span></div>
                        <div class="list_dd">
                            <div class="items">
                                <div class="rows">
									<div class="item" rel="0" onclick="select_item($(this), 'langVideo')"><?=$ui->item('A_NEW_FILTER_ALL'); ?></div>
									 <? foreach ($langVideo as $k => $lang) { ?>
									
                                    <div class="item" rel="<?=$lang['id']?>" onclick="select_item($(this), 'langVideo')"><?=ProductHelper::GetTitle($lang);?></div>
									
									 <? } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<? } ?>
				
				
				<? if ($filter_year[1]) : ?>
                <div class="form-row"><div class="box_select_result_count">
                        <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                        <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                        <span class="res_count"></span>
                        <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                    </div>
					
                    <label class="title"><?=$ui->item('A_NEW_FILTER_YEAR')?></label>
					
					<?
						$max_year = $filter_year[1];
						$min_year = $filter_year[0];
						
						
						
						if ($filter_data['ymin'] != '') {
							
							$filter_year[0] = $filter_data['ymin'];
							
						}
						
						
						if ($filter_data['ymax'] != '') {
							
							$filter_year[1] = $filter_data['ymax'];
							
						}
					?>
					
                    <input type="text" value="<?=($filter_year[1]-1)?>" class="inp_mini year_inp_mini inp" name="year_min"  onblur="show_result_count($(this))"/>-<input type="text" value="<?=$filter_year[1]?>" name="year_max" class="inp_max year_inp_max inp" onblur="show_result_count($(this))" />

                    <div id="slider_year"></div>
					
                    

                </div>
				<? endif;?>
                <?php if (!empty($pubs)) { ?>
                    <div class="form-row"><div class="box_select_result_count">
                            <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                            <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                            <span class="res_count"></span>
                            <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                        </div>
                        <label class="title"><?=$ui->item('A_NEW_FILTER_PUBLISHER')?></label>

                        <div class="dd_box_select" style="z-index: 7">

                            <div class="arrow_d" onclick="$('.list_dd', $(this).parent()).toggle()"></div>
                            <input type="hidden" name="izda" value="0">
                            <div class="text" onclick="$('.list_dd', $(this).parent()).toggle()">
                                <span><?if ($filter_data['izda'] == '' OR $filter_data['izda'] == '0') { echo $ui->item('A_NEW_FILTER_ALL'); } else { $row = Publisher::GetByID($entity, $filter_data['izda']); echo $row['title_' . Yii::app()->language]; }?></span> 
                            </div>
                            <div class="list_dd izda_dd">
                                <div class="items">
                                    <div class="rows">
                                        <div class="item" rel="0" onclick="select_item($(this), 'izda')"><?=$ui->item('A_NEW_FILTER_ALL'); ?></div>
                                        <?php
                                        foreach ($pubs as $pub => $binfo) {
                                            $row = Publisher::GetByID($entity, $binfo['publisher_id']);
                                            if (!$row['id'] OR $row['id'] == '0')
                                                continue;
                                            $name_publ = $row['title_' . Yii::app()->language];

                                            if (!$name_publ) {
                                                $name_publ = $row['title_en'];
                                            }
											
											$selact = ' selact';
											
											if ($row['id'] != $filter_data['izda']) {
												$selact = '';
											}

                                            echo '<div class="item'.$selact.'" rel="' . $row['id'] . '" onclick="select_item($(this), \'izda\')">' . $name_publ . '</div>';
                                        }
                                        ?>

                                    </div>
                                    <div class="load_items"></div>
                                </div>
                            </div>
                        </div>
                    </div> <?php }
                if (!empty($series)) { ?>

                    <div class="form-row"><div class="box_select_result_count">
                            <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                            <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                            <span class="res_count"></span>
                            <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                        </div>
                        <label class="title"><?=$ui->item('A_NEW_FILTER_SERIES')?></label>

                        <div class="dd_box_select" style="z-index: 6">

                            <div class="arrow_d" onclick="$('.list_dd', $(this).parent()).toggle()"></div>
                            <input type="hidden" name="seria" value="0">
                            <div class="text" onclick="$('.list_dd', $(this).parent()).toggle()">
                                <span><?if ($filter_data['seria'] == '' OR $filter_data['seria'] == '0') { echo $ui->item('A_NEW_FILTER_ALL'); } else { $row = Series::GetByIds($entity, array($entity, $filter_data['seria'])); echo $row[0]['title_' . Yii::app()->language]; }?></span> 
                            </div>
                            <div class="list_dd seria_dd">
                                <div class="items">
                                    <div class="rows filter-select">
                                        <div class="item" rel="0" onclick="select_item($(this), 'seria')"><?=$ui->item('A_NEW_FILTER_ALL'); ?></div>
                                        <?php
                                        foreach ($series as $seria => $binfo) {
                                            $row = Series::GetByIds($entity, array($binfo['series_id']));
                                            if (!$row[0]['id'] OR $row[0]['id'] == '0')
                                                continue;
                                            $name_publ = $row[0]['title_' . Yii::app()->language];

                                            if (!$name_publ) {
                                                $name_publ = $row[0]['title_en'];
                                            }

											$selact = ' selact';
											
											if ($row[0]['id'] != $filter_data['seria']) {
												$selact = '';
											}
											
                                            echo '<div class="item'.$selact.'" rel="' . $row[0]['id'] . '" onclick="select_item($(this), \'seria\')">' . $name_publ . '</div>';
                                        }
                                        ?>

                                    </div>
                                    <div class="load_items"></div>
                                </div>
                            </div>
                        </div>

                    </div> <?php } ?>
					
					<? if ($filter_year[3]) : ?>
					
					
                <div class="form-row"><div class="box_select_result_count">
                        <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div>
                        <div class="close" onclick="$(this).parent().hide()">x</div><?=$ui->item('A_NEW_FILTER_SELECT')?>:
                        <span class="res_count"></span>
                        <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                    </div>
                    <label class="title"><?=$ui->item('CART_COL_PRICE');?></label>
                    <input type="text" value="<?=$filter_year[2]?>" class="inp_mini cost_inp_mini inp" name="min_cost" onblur="show_result_count($(this))"/>-<input type="text" value="<?=$filter_year[3]?>" class="inp_max cost_inp_max inp" name="max_cost" onblur="show_result_count($(this))"/>
                    <div id="slider_cost"></div>

                   </div>
				<? endif; ?>
                <?php if (!empty($bgs)) { ?>
                    <div class="form-row bindings">
                        <div class="box_select_result_count">
                            <div class="arrow"><img src="/new_img/arrow_select.png" alt=""></div> 
                            <div class="close" onclick="$(this).parent().hide()">x</div> <?=$ui->item('A_NEW_FILTER_SELECT')?>:
                            <span class="res_count"></span>
                            <a  href="javascript:;" onclick="show_items()"><?=$ui->item('A_NEW_FILTER_VIEW')?></a>
                        </div>
                        <label class="title"><?
						if ($entity == 10 OR $entity == 15) {
							 echo $ui->item('A_NEW_FILTER_TYPE1');
						} else {
							echo $ui->item('A_NEW_FILTER_TYPE2');
						}
						
						?></label>


                    <label><input type="checkbox" class="" name="binding_id[]" value="0" onchange="change_all_binding(event, true);show_result_count($(this));" <?= ($filter_data['binding_id']) ? '' : 'checked'?>/> Все</label>

                        <?php
                        foreach ($bgs as $bg => $binfo) {
                            $row = Binding::GetBinding($entity, $binfo['binding_id']);
                            $title = 'title_' . Yii::app()->language;
                            if ($entity == 22 OR $entity == 24) {
                                $row = Media::GetMedia($entity, $binfo['media_id']);
                                $title = 'title';
                            }
                            if (!$row['id'])
                                continue;
							
							$sel = '';
							
							if (isset($filter_data['binding_id']) && in_array($row['id'], $filter_data['binding_id'])) {
								$sel = 'checked="checked"';
							}
							
                            echo '<label><input '.$sel.' type="checkbox" class="" name="binding_id[]" value="' . $row['id'] . '" onchange="change_all_binding(event);show_result_count($(this))"/> ' . str_replace('/', ' / ', $row[$title]) . '</label>';
                        }
                        ?>


                    </div><?php } ?>
            </form>
        
		
		
		</div>
        <div class="span10 listgoods">

            <h1 class="titlename"><?=$ui->item('A_NEW_GOODS_CAT_TITLE')?>: <?=((!$cid) ? Entity::GetTitle($entity) : $title_cat); ?></h1>  
			
			<? if ($entity == 100) : ?>
			Ведётся оптимизация раздела...
			<? else : ?>
			
            <div class="sortbox" style="float: right;">
                <form method="GET">
                    <?=$ui->item('A_NEW_FILTER_SORT_FOR')?> <?php $value = SortOptions::GetDefaultSort(@$_GET['sort']) ?>
                    <?= CHtml::dropDownList('sort', $value, SortOptions::GetSortData(), array('onchange' => '$(this).parent().submit()', 'style'=>'width: auto;')); ?>
					
					<? if ($_GET['lang']) : ?>
					
					<input type="hidden" name="lang" value="<?=$_GET['lang']?>"/>
					
					<? endif; ?>
					
                </form>
            </div>
			
			<div class="sortbox langsel">
                <form method="GET">
				
                    <select name="lang" onchange="$(this).parent().submit()"><option value=""><?=$ui->item('A_NEW_FILTER_TITLE_LANG')?><?=$ui->item('A_NEW_FILTER_ALL')?></option>
					
					<?
					
					
					
					$entities = Entity::GetEntitiesList();
					$tbl = $entities[$entity]['site_table'];
					
					$sql = 'SELECT ln.id as lnid, ln.title_'.Yii::app()->language.' AS lntitle FROM `all_items_languages` AS ail, `languages` AS ln, `'.$tbl.'` AS t WHERE ln.id = ail.language_id AND
					ail.entity = '.$entity.' AND
					ail.item_id = t.id';
					
					if ($cat_id) {
					
						$sql .= ' AND (t.code = '.$cat_id['id'].' OR t.subcode = '.$cat_id['id'].')';
					
					}
					
					$arrFirstLang = array(1,2,3,4);
					$arrMoreLang = array();
					$sql .= ' GROUP BY ln.id ORDER BY ln.title_'.Yii::app()->language.' ASC';
			 
					$rows = Yii::app()->db->createCommand($sql)->queryAll();
					
					foreach ($rows as $row)
					{
						$sel='';
						if ($_GET['lang'] == $row['lnid']) {
							$sel = ' selected="selected"';
						}
						
						switch ($row['lnid']) {
							
							case 7: $arrFirstLang[0] = '<option value="'.$row['lnid'].'"'.$sel.'>'.$ui->item('A_NEW_FILTER_TITLE_LANG').$row['lntitle'].'</option>'; break;
							case 14: $arrFirstLang[1] = '<option value="'.$row['lnid'].'"'.$sel.'>'.$ui->item('A_NEW_FILTER_TITLE_LANG').$row['lntitle'].'</option>'; break;
							case 9: $arrFirstLang[2] = '<option value="'.$row['lnid'].'"'.$sel.'>'.$ui->item('A_NEW_FILTER_TITLE_LANG').$row['lntitle'].'</option>'; break;
							case 8: $arrFirstLang[3] = '<option value="'.$row['lnid'].'"'.$sel.'>'.$ui->item('A_NEW_FILTER_TITLE_LANG').$row['lntitle'].'</option>'; break;
							default: 

							$arrMoreLang[] = '<option value="'.$row['lnid'].'"'.$sel.'>'.$ui->item('A_NEW_FILTER_TITLE_LANG').$row['lntitle'].'</option>';
							
							break;
						}
						
					}
					
					$arrlangs = array_merge($arrFirstLang, $arrMoreLang);
					
					echo implode("\n", $arrlangs);
					
					
					?>
					
					</select>
					
					<? if ($_GET['sort']) : ?>
					
					<input type="hidden" name="sort" value="<?=$_GET['sort']?>"/>
					
					<? endif; ?>
					
                </form>
            </div>
			<div style="margin: 5px 0 ;">
			<?//=sprintf($ui->item('X items here'), $total)?>
			</div>
            <ul class="items">
                <?php foreach ($items as $item) : ?>
                    <?php
                    $item['entity'] = $entity;
                    $key = 'itemlist_' . $entity . '_' . $item['id'];
                    ?>
                    <li>
                        <?php $this->renderPartial('_common_item_2', array('item' => $item, 'entity' => $entity, 'isList' => true)); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
		

            <?php if (count($items) > 0) $this->widget('SortAndPaging', array('paginatorInfo' => $paginatorInfo)); ?>
			
			<? endif; ?>
			
		</div>
    </div>
</div>