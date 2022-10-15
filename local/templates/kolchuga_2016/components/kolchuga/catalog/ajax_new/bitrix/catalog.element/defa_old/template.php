<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$photo_ids = array();

$detPicAlt = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] : $arResult["NAME"]);

$detPicTitle = ((isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]))? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] : $arResult["NAME"]);

if($arResult['DETAIL_PICTURE']['ID'] > 0) $photo_ids[] = $arResult['DETAIL_PICTURE']['ID'];

if(is_array($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) $photo_ids = array_merge($photo_ids, $arResult['PROPERTIES']['MORE_PHOTO']['VALUE']);
?>
<div class="catalog__detail--item">
    <div class="catalog__detail--left">

        <div class="stickers" style="z-index: 10;">
			<?if($arResult["DISPLAY_PROPERTIES"]['NOVINKA']){?>
				<div class="new">Новинка</div>
			<?}?>
			<?if($arResult["DISPLAY_PROPERTIES"]['SALE']){?>
				<div class="sale">Финальная цена</div>
			<?}?>
			<?if($arResult["DISPLAY_PROPERTIES"]['BESTPRICE']){?>
				<div class="new">Лучшая цена</div>
			<?}?>			
        </div>

        <div class="catalog__gallery">
            <?if(count($photo_ids) > 0):?>
                <div class="catalog__gallery--big">
                    <div id="slider" class="flexslider">
                        <ul class="slides popup-gallery">
                            <?foreach($photo_ids as $i=>$id):
                                $orig =
                                    CFile::ResizeImageGet($id, array('width' => 1024, 'height' => 767), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 70)['src'];
                                $middle =
                                    CFile::ResizeImageGet($id, array('width' => 544, 'height' => 399), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src'];
                                ?>
                                <li<?if (!$i):?> class="flex-active-slide"<?endif;?>>
                                    <a href="javascript:void(0);" src-data="<?=$orig?>">
                                        <img src="<?=$middle;?>" alt="<?=($detPicAlt.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" title="<?=($detPicTitle.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>">
                                    </a>
                                </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                </div>
                <div class="catalog__gallery--thumb">
                    <div id="carousel" class="flexslider">
                        <div class="flex-viewport">
                            <ul class="slides">
                                <?foreach($photo_ids as $i=>$id):
                                    $thumb =
                                        CFile::ResizeImageGet($id, array('width' => 112, 'height' => 85), BX_RESIZE_IMAGE_EXACT_PROPORTIONAL, false, false, false, 70)['src']?>
                                    <li>
                                        <span><img src="<?= $thumb?>" alt="<?=($detPicAlt.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" title="<?=($detPicTitle.GetMessage('CT_ELEMENT_PICTURE_TMP', array('#N#' => ($i+1))));?>" ></span>
                                    </li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $.post('/bitrix/components/bitrix/catalog.element/ajax.php', {
                            AJAX: 'Y',
                            SITE_ID: '<?=SITE_ID?>',
                            PRODUCT_ID: '<?=$arResult['ID']?>',
                            PARENT_ID: 0
                        }, function(response){});
                        //$('.b-filter__name').click(function(){
                        //$.fn.matchHeight._update($('.js-mh'));
                        //});
                    });
                </script>
            <?else:?>
                <div class="no-photo"></div>
            <?endif?>
        </div>
        <?if ($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']) {?>
            <div class="catalog__param--title" style="margin-top: 15px;">Продается только в комплекте с:</div>
            <div class="catalog__item" id="" style="text-align: center; width:100%">
                <?if ($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_DETAIL_PICTURE']){?>
                    <div class="catalog__item-img">
                        <a href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>">
                            <img src="<?echo CFile::ResizeImageGet($arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src']?>" alt="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?>" title="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?>">
                        </a>
                    </div>
                <?}?>
                <div class="catalog__item-info">
                    <div class="catalog__item-title"><a href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>"><?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME']?></a></div>
                    <a class="btn btn-primary" href="<?=$arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL']?>" style="margin-top: 15px;">Выбрать</a>
                </div>
            </div>
        <?}?>

    </div>
    <div class="catalog__detail--right">
        <div class="catalog__param">
            <div class="catalog__param--left">
                <div class="catalog__param--title">Характеристики</div>
                <ul>
                    <?foreach($arResult['DISPLAY_PROPERTIES'] as $prop):
                        if(!$prop['DISPLAY_VALUE'] || $prop['CODE'] == 'TREBUETSYA_LITSENZIYA') continue?>
                        <li>
                            <em><?= $prop['NAME']?></em>
                            <b><?= is_array($prop['DISPLAY_VALUE']) ? implode(' / ', $prop['DISPLAY_VALUE']) : $prop['DISPLAY_VALUE']?></b>
                        </li>
                    <?endforeach;?>
                </ul>
            </div>
            <? //var_dump(count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'])); 1 - 0 ?>
            <? //var_dump($arResult['CHECK_ONLY_ONE_SIZE']); 4 - 1  ?>
            <? if (count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) == 0 || $arResult['CHECK_ONLY_ONE_SIZE'] == 1 || $arResult['CHECK_PAGE_SIZES'] == false): ?>
                <div class="catalog__param--right">
                    <div class="catalog__param--title"><?=GetMessage("CT_CATALOG_AVAILABLE_".(($arResult['CAN_BUY'])? "Y" : "N"));?></div>
                    <ul>
                        <?foreach($arResult['STORES'] as $store):?>
                            <li class="<?= $store['AMOUNT'] > 0 ? 'yes' : ''?>"><a href="<?= $store['LINK']?>"><?= $store['NAME']?></a></li>
                        <?endforeach;?>
                    </ul>
                </div>
            <? endif ?>
        </div>
<div>
<?$APPLICATION->IncludeComponent(
	"arturgolubev:yandex.share", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"VISUAL_STYLE" => "counters",
		"SERVISE_LIST" => array(
			0 => "vkontakte",
			1 => "facebook",
			2 => "odnoklassniki",
			//3 => "moimir",
			//4 => "twitter",
			//5 => "linkedin",
			//6 => "lj",
			//7 => "tumblr",
			8 => "viber",
			9 => "whatsapp",
			10 => "telegram",
		),
		"TEXT_ALIGN" => "ar_al_left",
		"TEXT_BEFORE" => "Поделиться:",
		"DATA_TITLE" => "",
		"DATA_RESCRIPTION" => "",
		"DATA_IMAGE" => "",
		"DATA_URL" => "",
		"COUNT_FOR_SMALL" => "3"
	),
	false
);?>
</div>
        <? if ($arResult['CHECK_PAGE_SIZES'] || count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 1): ?>
        
            <div class="link_uncertainty">
                <a class="popup-modal" href="#modal-sizeuncertainty">Не уверены в размере?</a>
            </div>

            <? if(count($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE']) > 0 && $arResult['CHECK_ONLY_ONE_SIZE'] > 1): ?>
                <div class="table_sizes_avail">
                    <table>
                        <tr class="t_title">
                            <td>В наличии</td>
                            <? foreach($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'] as $availSize): ?>
                                <td><?=$availSize?></td>
                            <? endforeach ?>
                        </tr>
                        <?foreach($arResult['SKU_SIZES_IN_STORES'] as $store):?>
                            <tr>
                                <td><?=$store['STORE']['NAME']?></td>
                                <? foreach($arResult['DISPLAY_PROPERTIES']['RAZMER']['VALUE'] as $availSize): ?>
                                    <td>
                                        <? if(in_array($availSize, $store["SIZES"])): ?>
                                            <!-- <input type="checkbox" checked="checked" disabled="disabled" /> -->
                                            <div class="check_size"></div>
                                        <? endif ?>
                                    </td>
                                <? endforeach ?>
                            </tr>
                        <?endforeach;?>
                    </table>
                </div>
            <? endif ?>

        <? endif ?>

        <div class="catalog__option-list">
            <?/* Colors sku was canseled by client */
            /*if(count($arResult['SKU']) < 2):?>
                <div class="catalog__option-list__item"><?//?><div>
            <?else:?>
            <div class="catalog__option-list__item">
                <select name="SKU_COLOR" id="">
                    <option value="">Выбрать цвет</option>
                    <?foreach($arResult['SKU'] as $code => $items):?>
                    <option value="<?=$code?>"><?=$code?></option>
                    <?endforeach;?>
                </select>
            </div>
            <?endif;*/
            /* check sizes */
            $check_sizes = array();
            foreach(reset($arResult['SKU']) as $item){
                $check_sizes[] = $item['PROPERTY_RAZMER_VALUE'];
            }
            $check_sizes = array_unique($check_sizes);
            if(count($check_sizes) == 1 && $check_sizes[0] == ''){
                $arResult['SKU'] = false;

            }
            $sku_id = 0;
            if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0):?>
                <div class="catalog__option-list__item">
				<?if($arResult['PROPERTIES']['SECT_ELEMENT']['VALUE']!='Обувь'){?>
                    <select name="SKU_SIZE"<?=$arResult['SKU_COUNT'] > 1 ? '' : ' disabled'?>>
                        <?if($arResult['SKU_COUNT'] > 1):?>
                            <option value="">Выбрать размер</option>
                        <?endif;
						if($arResult['PROPERTIES']['SECT_ELEMENT']['VALUE']=='Обувь'){
							/*  //решили не резервировать, а информировать, что доступно только самовывозом
							foreach(reset($arResult['SKU']) as $code => $item):?>
								<option value="<?= $item['ID']?>"
										<?if(!empty($arResult['RAZMER_IS']) && $arResult['RAZMER_IS']==$item['PROPERTY_RAZMER_VALUE']){echo ' selected';}?>
										data-price="<?=$item['MIN_PRICE']['PRINT_VALUE']?>"
										data-discount="<?=$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>"
										data-percent="<?=$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>"
										data-uri="<?=$item['DETAIL_PAGE_URL']?>"
										data-max="<?=$item['CATALOG_QUANTITY']?>"><?= $item['PROPERTY_RAZMER_VALUE']?><?=$item['CATALOG_QUANTITY'] == 1
										? ' (Только 1 в наличии)' : '';?></option>
								<?$sku_id = $item['ID'];
							endforeach; */?>

						<?}else{
							foreach(reset($arResult['SKU']) as $code => $item):?>
								<option value="<?= $item['ID']?>"
										data-price="<?=$item['MIN_PRICE']['PRINT_VALUE']?>"
										data-discount="<?=$item['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>"
										data-percent="<?=$item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>"
										data-max="<?=$item['CATALOG_QUANTITY']?>"><?= $item['PROPERTY_RAZMER_VALUE']?><?=$item['CATALOG_QUANTITY'] == 1
										? ' (Только 1 в наличии)' : '';?></option>
								<?$sku_id = $item['ID'];
							endforeach;?>
						<?}?>
                    </select>
				<?}?>
                </div>
                <?$arResult['MIN_PRICE'] = reset($arResult['SKU'])[0]['MIN_PRICE'];
            endif;?>
        </div>

        <input class="jq-q" type="hidden" value="1">

        <?/*<div class="catalog_el_available<?=(($arResult['CAN_BUY'])? "" : " noAvailable");?>"><?=GetMessage("CT_CATALOG_AVAILABLE_".(($arResult['CAN_BUY'])? "Y" : "N"));?></div>*/?>

        <div class="catalog__option-list__price">
            <div class="price__block js-price-block">
                <?/*if (isset($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"])){?>
                    <span class="old-price discount"><?=$arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"];?></span><br />
                <?} else if($arResult['MIN_PRICE']['VALUE'] > $arResult['MIN_PRICE']['DISCOUNT_VALUE']){?>
                    <span class="old-price discount"><?= $arResult['MIN_PRICE']['PRINT_VALUE']?></span><br />
                <?}*/?>
				<?if(!$arResult['CAN_BUY']){?>
										
									<?}else{?>
                <span class="price js-price"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
                <? if ($arResult['OLD_PRICE']): ?>
                      <span class="line_old_price"><?=$arResult['OLD_PRICE']?></span>
                <? endif ?>
                <? if ($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']): ?>
                      <span class="line_diff_price">(-<?=$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%)</span>
                <? endif ?>
				
									<?}?>

                <? /*if($_GET['ttt'] !== 'y'): ?>
                <br />
                <div class="catalog__license__item">

                        <span>
                            <? if (isset($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"])){ ?>
                                Акция
                                <?if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0){ ?>
                                        + скидка <?= $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%
                                <? } ?>
                            <? } else if($arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0){ ?>
                                    <?=GetMessage("CT_CLB_SALE");?> <?= $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%
                            <? } ?>
                        </span>
                </div>
                <? endif*/ ?>                    
            </div>
        </div>
        <div class="catalog__btn text-center">
            <noindex>
			<?/*<div style="padding: 10px 0;color:#ff0000;">Внимание!<br> На сайте ведутся технические работы.<br> Уточняйте информацию о наличии товара и ценах у менеджеров салонов.</div>*/?>
                <?
                $buy_id = $arResult['SKU_COUNT'] <= 1 && $sku_id > 0 ? $sku_id : $arResult['ID'];

                if($arResult['SKU'] && $arResult['SKU_COUNT'] > 1){
                    $buy_id = 0; /* client side must select offer */
                }
				/*$arRazdels=['odezhda','obuv','aksessuary'];
                $razdel='N';
                foreach($arResult['SECTION']['PATH'] as $vl){
                    foreach($arRazdels as $findme){
                        $pos2 = strpos($vl['CODE'], $findme);
                        if ($pos2 !== false) {
                            $razdel='Y';
                        }
                    }                    
                }

                if ($arResult['CATALOG_QUANTITY']==1 || $arResult['SKU_COUNT']==1 && $razdel=='Y') {?>
                    <noindex><a class="btn btn-primary popup-modal" href="#modal-buyoneclick" rel="nofollow" rel_mc="rezerv">Зарезервировать</a></noindex>
                <div class="catalog__license">
                        <div class="catalog__license__item">
                            <span>Покупка данного товара доступна только в оружейном салоне</span>
                        </div>
                    </div>
                <?}else?><!--pre><?print_r($arResult['IBLOCK_SECTION_ID']);?></pre--><?*/
				
				
				//if($arResult['IBLOCK_SECTION_ID']!=18130){ //podarochni_sertifikat
				
				
						if(!$arResult['PROPERTIES']['TREBUETSYA_LITSENZIYA']['VALUE']){?>
							<div class="alert-size">
								<div class="alert alert-warning">Выберите размер</div>
							</div>
								<?if($arResult['KOMPLEKT']['DISPLAY_NAME']):?>
								<?if(1==2){?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?}else{?>
									<a class="js-buy-btn btn btn-primary popup-modal2" href="#modal-komplekt" style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" data-id="<?=$buy_id?>" rel_mc="kupit" rel="nofollow">Купить</a>
									<a class="popup-modal2" href="#modal-komplekt" style="display: none" rel="nofollow" rel_mc="kupit">Купить</a>
									<?}?>
								<?else:?>
									<?if($arResult['PROPERTIES']['SECT_ELEMENT']['VALUE']=='Обувь'){?>
										<?/* if ($arResult['CATALOG_QUANTITY']>0){?>
											<noindex><a class="btn btn-primary popup-modal js-btn-rezerv" href="#modal-buyoneclick" rel="nofollow" rel_mc="rezerv" data-id="<?=$buy_id?>">Зарезервировать</a></noindex>
										<?}else{?>
											<noindex><a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Размера нет в наличии</a></noindex>
										<?} */?>
										<noindex><a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Доступно только к самовывозу</a></noindex>
									<?}else{?>
									<?if(1==2){?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?}else{?>
									<?if(!$arResult['CAN_BUY']){?>
										<a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">В ожидании поступления</a>
									<?}else{?>
										<a class="js-buy-btn btn btn-primary " style="<?=$arResult['CAN_BUY'] ? '' : 'display: none'?>" href="#" data-id="<?=$buy_id?>" rel="nofollow" rel_mc="kupit">Купить</a>
										<?}?>
										<?}?>
									<?}?>
								<?endif;?>
						<?}else{?>
							<?if($arResult["CATALOG_QUANTITY"]>0):?>
								<noindex><a class="btn btn-primary popup-modal" href="#modal-buyoneclick" rel="nofollow" rel_mc="rezerv">Зарезервировать</a></noindex>

							<?else:?>
								<noindex><a class="btn btn-primary" href="#" aria-disabled="true" disabled rel="nofollow">Нет в наличии</a></noindex>
							<?endif;?>


							<div class="catalog__license">
								<div class="catalog__license__item">
									<span>Только по документам<br/><a href="/information/rezerv-grazhdanskogo-oruzhiya-i-patronov.php"><ins>Правила резерва гражданского оружия и патронов</ins></a></span>
								</div>
							</div>

						<?}?>
				<?/*}else{?>
				 <a class="btn btn-primary popup-modal" href="#modal-psert" rel="nofollow" >Зарезервировать</a>
				<?}*/?>
            </noindex>

            <div class="add-cart" style="display:none">
                <div class="add-cart__inner">
                    <div class="add-cart__img"></div>
                    <div class="add-cart__body">
                        <div><b>Товар добавлен в корзину</b></div>
                        <div><a href="/personal/cart/">Оформить заказ</a></div>
                        <div><a class="hide-success" href="#">Продолжить покупки</a></div>
                    </div>
                </div>
            </div>
            <?if($arResult['KOMPLEKT']['DISPLAY_NAME']):?>
            <div id="modal-komplekt" class="mfp-modal mfp-hide">
                <div class="mfp-modal-header">
                    Продается только в комплекте с:
                </div>
                <div class="mfp-modal-content js-modal-reserve">
                    <div class="catalog__item" id="" style="text-align: center; width:100%">
                        <?if ($arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE']){?>
                            <div class="catalog__item-img">
                                <a href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>">
                                    <img src="<?echo CFile::ResizeImageGet($arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60)['src']?>" alt="<?=$arResult['KOMPLEKT']['DISPLAY_NAME']?>" title="<?=$arResult['KOMPLEKT']['DISPLAY_NAME']?>">
                                </a>
                            </div>
                        <?}?>
                        <div class="catalog__item-info">
                            <div class="catalog__item-title"><a href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>"><?=$arResult['KOMPLEKT']['DISPLAY_NAME']?></a></div>
                            <a class="btn btn-primary" href="<?=$arResult['KOMPLEKT']['DISPLAY_URL']?>" style="margin-top: 15px;">Выбрать</a>
                        </div>
                    </div>
                </div>
            </div>
            <?endif;?>

        </div>
    </div>
</div>

<div class="catalog__detail--desc">
    <?= $arResult['DETAIL_TEXT']?>
</div>
<?$APPLICATION->IncludeComponent("intervolga:conversionpro.productdetail", ".default", array(
	"COMPONENT_TEMPLATE" => ".default",
		"ID" => $arResult["ID"],
		"NAME" => $arResult["NAME"],
		"PRICE" => $arResult["MIN_PRICE"]["DISCOUNT_VALUE"],
		"CURRENCY" => $arResult["MIN_PRICE"]["CURRENCY"]
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
