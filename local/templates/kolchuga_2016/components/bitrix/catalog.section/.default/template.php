<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if(empty($arResult["ITEMS"])):?>
	<?echo GetMessage("CT_BCSE_NOT_FOUND");?>
<?endif;?>
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
                                          array('width' => 200, 'height' => 200), 
                                          BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
        }
        ?>
        <div class="catalog__item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
			<div class="catalog__item-img">
			    <div class="stickers" style="display:none;">
    				<?if($arItem["DISPLAY_PROPERTIES"]['NOVINKA']){?>
    					<div class="new">Новинка</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['SALE']){?>
    					<div class="sale">Финальная цена</div>
    				<?}?>
    				<?if($arItem["DISPLAY_PROPERTIES"]['BESTPRICE']){?>
    					<div class="new">Лучшая цена</div>
    				<?}?>
    				
                    <? if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){ ?>
                          <?/*  if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){ ?>
                              <div class="sale">
                                  уценка + скидка <?= $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%
                              </div>
                          <? } else { */?>
                              <span class="old_price">
                                  <?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?>
                              </span>
                          <?// } ?>
                    <? } else if($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){ ?>
                      <div class="old_price">
                        <?= $arItem['MIN_PRICE']['PRINT_VALUE']?>
                      </div>
                    <? } ?>
                </div>
          
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
					<? if($arItem['PREVIEW_PICTURE']['SRC']):?>
						<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" title="<?= $arItem['PREVIEW_PICTURE']['TITLE'] ?>">
						<? else: ?>
						<div class="no-photo"></div>
					<? endif ?>
				</a>
			</div>
            <div class="catalog__item-info">
                <div class="catalog__item-title"><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['NAME'] ?></a>
                </div>
                <? if($arItem['MIN_PRICE']['VALUE'] > 0){?>
                    <div class="catalog__item-price">
						<?if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){?>
							<span class="old-price">
                                  <?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?>
                              </span>
						<?}elseif($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
							<span class="old-price">
                                  <?=$arItem['MIN_PRICE']['PRINT_VALUE'];?>
                              </span>
						<?}?>
                        <? /*if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']):?>
                            <span class="old-price"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span>
                        <? endif*/ ?>
                        <span class="price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                    </div>
                <? }elseif($arItem['ITEM_PRICES'][0]['PRICE'] > 0){ ?>
					<div class="catalog__item-price">   
						<?if (isset($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"])){?>
							<span class="old-price">
                                  <?=$arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];?>
                              </span>
						<?}elseif($arItem['MIN_PRICE']['VALUE'] > 0 && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']){?>
							<span class="old-price">
                                  <?=$arItem['MIN_PRICE']['PRINT_VALUE'];?>
                              </span>
						<?}?>					
                        <span class="price"><?= $arItem['ITEM_PRICES'][0]['PRINT_PRICE'] ?></span>
                    </div>
				<?}?>
				<?if(!empty($arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']])){?>
					<?
					$mmm=[];					
					foreach( $arResult['SKU2'][$arItem["PROPERTIES"]['IDGLAVNOGO']['VALUE']] as $el){
						if(!empty($el['RAZMER'])){
							$mmm[]=$el['RAZMER'];
						}					
					}
					if(!empty($mmm)){
						?><div class="">Размеры: <?=implode(' | ',$mmm)?></div><?
					}
				}?>
            </div>
        </div>
    <? endforeach; ?>
</div>
<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?><br/>
<? endif; ?>