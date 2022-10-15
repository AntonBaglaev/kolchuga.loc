<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?$this->setFrameMode(true);?>
<div class="sec_pag">
<?/*<div style="text-align:center;font-weight:900;color:#ff0000;">Внимание! На сайте ведутся технические работы.<br> Уточняйте информацию о наличии товара и ценах у менеджеров салонов.</div>*/?>
  <div class="sec_pages">
    <div><span>Показать:</span></div>
    <? /*if($arParams['CHECK_ALT_VIEW']): ?>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=6", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 6 || !array_key_exists('PAGEN_SIZE', $_GET)) echo 'act';?>">6</a></div>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=24", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 24) echo 'act';?>">24</a></div>
    <? else:*/ ?>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=30", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 30 || !array_key_exists('PAGEN_SIZE', $_GET)) echo 'act';?>">30</a></div>
    <? //endif ?>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=60", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 60) echo 'act';?>">60</a></div>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=90", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 90) echo 'act';?>">90</a></div>
    <? /* ?>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=500", array("PAGEN_SIZE"))?>" class="all <?if($_GET['PAGEN_SIZE'] == 500) echo 'act';?>">все товары</a></div>
    <? */ ?>
  </div>
  <?= $arResult["NAV_STRING"] ?> 
  <div class="clearfix"></div>
</div>
<div class="catalog__list">
    <? foreach($arResult["ITEMS"] as $key => $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

        if($arItem['DETAIL_PICTURE']['ID'] > 0)
        {
          if (empty($arItem['PREVIEW_PICTURE']) ||
              !is_array($arItem['PREVIEW_PICTURE']))
          {
            $arItem['PREVIEW_PICTURE'] = $arItem['DETAIL_PICTURE'];
          }
          
             $arItem['PREVIEW_PICTURE']['SRC'] =
                    CFile::ResizeImageGet($arItem['DETAIL_PICTURE']["ID"], 
                                          array('width' => 200, 'height' => 150), 
                                          BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70)['src'];
        }
        ?>
        <div class="catalog__item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
			<div class="catalog__item-img">
			    <div class="stickers">
    				<?/*if($arItem["DISPLAY_PROPERTIES"]['NOVINKA']){?>
    					<div class="new">Новинка</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['SALE']){?>
    					<div class="sale">SALE</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['SPECIAL_PRICE']){?>
    					<div class="new">Специальная цена</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']){?>
    					<div class="new">Лучшая цена</div>
    				<?}*/?>
                    <?if($arItem['CHECK_NOVINKA']){?>
                      <div class="new">Новинка</div>
                    <?}?>
                    <?/*if($arItem['CHECK_SALE']){?>
                      <div class="sale">SALE</div>
                    <?}*/?>
                    <?if($arItem['CHECK_SPECIAL_PRICE']){?>
                      <div class="new">Специальная цена</div>
                    <?}?>
                    <?if($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']){?>
                      <div class="new">Лучшая цена</div>
                    <?}?>
                    <?if($arItem["DISPLAY_PROPERTIES"]['SPECIAL_PRICE']){?>
                      <div class="new">Специальная цена</div>
                    <?}?>
    				

                    <? /* ?>

                        <? if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){ ?>
                              
                                  <span class="old_price">
                                      <?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?>
                                  </span>
                        <? } else if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){ ?>
                          <div class="old_price">
                            <?= $arItem['MIN_PRICE']['PRINT_VALUE']?>
                          </div>
                        <? } ?>
                        
                    <? */ ?>
                </div>
				
			<?/*	<!--pre><?print_r((preg_replace("/[^0-9.,]/", '', '63 750.3 руб')));?></pre-->
				<!--pre><?print_r($arItem['MIN_PRICE']);?></pre-->
          if(intval($arItem['OLD_PRICE'])>0){?><div class='procent_skidki_boll'>-<?=(round(100-(intval($arItem['MIN_PRICE']['DISCOUNT_VALUE'])*100/intval(preg_replace("/[^0-9.]/", '', $arItem['OLD_PRICE'])))))?>%</div><?}*/?>
          <?if ($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']>0){?>
				<div class='procent_skidki_boll'>-<?=$arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%</div>
				<?  
				//if($arItem['CHECK_SALE']){
					?><div class="procent_skidki_boll_bf_img"><img src="/images/icon_blacksale.png" width="100%" ></div><?
				//}
				 ?>
		  <?}elseif(intval($arItem['OLD_PRICE'])>0){?>
				<div class='procent_skidki_boll'>-<?=(round(100-(intval($arItem['MIN_PRICE']['DISCOUNT_VALUE'])*100/round(preg_replace("/[^0-9.]/", '', $arItem['OLD_PRICE'])))))?>%</div>
				<?  
				if($arItem['CHECK_SALE']){
					?><div class="procent_skidki_boll_bf_img"><img src="/images/icon_blacksale.png" width="100%" ></div><?
				}
				 ?>
			<?}?>
		  <?
			/* if(!empty($arItem['ARDISCOUNTS'])){
				foreach($arItem['ARDISCOUNTS'] as $skid){	
					if($skid['ID']==54 || $skid['ID']==55){
			  ?>
		  
					<div class='procent_skidki_boll_bf'>BF</div>
			
			<?
					break;
					}
				}
			} */
			?>
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" onclick="return true;">
					<? if($arItem['PREVIEW_PICTURE']['SRC']):?>
						<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" title="<?= $arItem['PREVIEW_PICTURE']['TITLE'] ?>">
						<? else: ?>
						<?/*<div class="no-photo"></div>*/?>
						<img src="/images/no_photo_kolchuga.jpg" >
					<? endif ?>
				</a>
			</div>
            <div class="catalog__item-info">
                <div class="catalog__item-title"><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" onclick="return true;"><?= $arItem['NAME'] ?></a>
                </div>
                <? if($arItem['MIN_PRICE']['VALUE'] > 0):?>
                    <div class="catalog__item-price">
                        <? /*if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']):?>
                            <span class="old-price"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span>
                        <? endif*/ ?>
                        <span class="price line_price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                        
						<?if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
							<span class="line_old_price"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span>
							<span class="line_diff_price">(-<?=$arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%)</span>
						<?}elseif($arItem['OLD_PRICE']){?>
							<span class="line_old_price"><?=$arItem['OLD_PRICE']?></span>
						<?}?>
						
						<?/* if ($arItem['OLD_PRICE']): ?>
                              <span class="line_old_price"><?=$arItem['OLD_PRICE']?></span>
                        <? endif ?>
                        <? if ($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']): ?>
                              <span class="line_diff_price">(-<?=$arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%)</span>
                        <? endif */?>
                    </div>
                <? endif ?>
				<?//if(!empty($arResult['SKU2'][$arItem['ID']])){?>
				<?//\Kolchuga\Settings::xmp($arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE'],11460, __FILE__.": ".__LINE__);?>
				<?if(!empty($arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']])){?>
				<?
				$mmm=[];
					/*?><!--pre>arItem <?print_r($arResult['SKU2'][$arItem['ID']]);?></pre--><?*/
				foreach( $arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']] as $el){
					if(!empty($el['RAZMER'])){
						$mmm[]=$el['RAZMER'];
					}
					
				}
				if(!empty($mmm)){
				?>
				<div class="">Размеры: <?=implode(' | ',$mmm)?></div>
				<?
				}
				}?>
            </div>
        </div>
    <? endforeach; ?>
</div>

<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
<div class="sec_pag">
  <div class="sec_pages">
    <div><span>Показать:</span></div>
    <? /*if($arParams['CHECK_ALT_VIEW']): ?>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=6", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 6 || !array_key_exists('PAGEN_SIZE', $_GET)) echo 'act';?>">6</a></div>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=24", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 24) echo 'act';?>">24</a></div>
    <? else:*/ ?>
      <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=30", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 30 || !array_key_exists('PAGEN_SIZE', $_GET)) echo 'act';?>">30</a></div>
    <? //endif ?>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=60", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 60) echo 'act';?>">60</a></div>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=90", array("PAGEN_SIZE"))?>" class="<?if($_GET['PAGEN_SIZE'] == 90) echo 'act';?>">90</a></div>
    <? /* ?>
    <div><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_SIZE=500", array("PAGEN_SIZE"))?>" class="all <?if($_GET['PAGEN_SIZE'] == 500) echo 'act';?>">все товары</a></div>
    <? */ ?>
  </div>
  <?= $arResult["NAV_STRING"] ?> 
  <div class="clearfix"></div>
</div>
<? endif; ?>