<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->addExternalCss("/local/templates/kolchuga_2016/css/bootstrap.css");
$this->addExternalJS("/local/templates/kolchuga_2016/js/bootstrap.min.js");
$this->addExternalJS("/local/templates/kolchuga_2016/js/lazyload.min.js");
$this->addExternalJS("/local/templates/kolchuga_2016/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5");
$this->addExternalCss("/local/templates/kolchuga_2016/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5");
$this->addExternalJS($templateFolder."/script_add.js");
?>
<?//echo "<pre>";print_r($arResult[DISPLAY_PROPERTIES][NEXT_SERVICE]);echo "</pre>";?>
<?//echo "<pre>";print_r($arResult[IBLOCK]);echo "</pre>";?>
<div class="container-fluid pb-5 pl-0 pr-0">

	<?
	$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	
		<div class="row" id="<?=$this->GetEditAreaId($arResult['ID']);?>">
			<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<div class="container-fluid service_bread d-none d-md-block">
				<div class="row">
					<div class="col-2 bgbread">&nbsp;</div>
					<div class="col-8"><ul><li><a href="<?=$arResult['LIST_PAGE_URL']?>"><?=$arResult['IBLOCK']['NAME']?></a> </li><li>> </li><li><?=$arResult['NAME']?> </li></ul></div>
				</div>
			</div>
			<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
				<div><span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span></div>
			<?endif;?>
			
			  <h1><?=$arResult['NAME']?></h1><?if($arParams['SHOW_COUNTER']!='N' ){?><span class="news__views"><span class="fa fa-eye"></span> <?=intval($arResult['SHOW_COUNTER']);?></span><?}?>
			  <div class="osnanons">
			  
			<?if($arResult["PREVIEW_TEXT"]){ echo $arResult["PREVIEW_TEXT"]; }?>
			
			</div>
			</div>
			
			<div class="col-md-6 order-1 order-md-2">
                <? if ($arParams["DISPLAY_PICTURE"] != "N" && !empty($arResult["DETAIL_PICTURE"]) && empty($arResult['SLIDER_PHOTOS'])): ?>

                    <? /*if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?=$arResult["DETAIL_PAGE_URL"]?>">
							<img class="preview_picture " border="0" src="<?=$arResult["DETAIL_PICTURE"]['SRC']?>" width="100%"  alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
							</a>
						<?else:*/ ?>
                    <img class="preview_picture " border="0" src="<?= $arResult["DETAIL_PICTURE"]['SRC'] ?>"
                         width="100%" alt="<?= $arItem["NAME"] ?>" title="<?= $arItem["NAME"] ?>"/>
                    <? //endif;?>

                <? elseif (!empty($arResult['SLIDER_PHOTOS'])): ?>

                    <div class="flexslider flexslider--theme-2 slider__salon js_news_slider">
                        <ul class="slides">
                            <? foreach ($arResult['SLIDER_PHOTOS'] as $strPhoto): ?>
                                <li><img src="<?= $strPhoto ?>"/></li>
                            <? endforeach; ?>
                        </ul>
                    </div>

                    <script>
                        $(document).ready(function () {
                            $('.js_news_slider').flexslider({
                                animation: "fade",
                                slideshow: true,
                                slideshowSpeed: 4000,
                                animationSpeed: 700,
                                prevText: "",
                                nextText: "",
                            });
                        });
                    </script>

                <? endif ?>

			</div>
		</div>
		<div class="w-100 pb-5"><br></div>
		<div class="row">
			<div class="col-md-8 osntext pr-md-5">
				<?if(strlen($arResult["DETAIL_TEXT"])>0){ echo $arResult["DETAIL_TEXT"]; }?>
				<?if(isset($arResult["GALLERY"])){?>
					<?if(strlen($arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["~VALUE"])>0){?>   
						<div class="text-content mb-4">
							<h2><?=$arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["~VALUE"]?></h2>
						</div>   
					<?}?>

                    <div class="gallery-block gallery">
                        <div class="row">
                            <?foreach($arResult["GALLERY"] as $k => $arImage){?>
                                <div class="col-md-4 mb-5 col-sm-6">
                                    <a data-gallery="gallery-news-<?= $arResult["ID"] ?>"
                                       href="<?= $arImage["SRC_LG"] ?>" title="<?= $arImage["DESC"] ?>"
                                       class="cursor-loop fancybox"
                                       data-fancybox-group="gallery-news-<?= $arResult["ID"] ?>">
                                        <img src="<?= $arImage['SRC_XS'] ?>">
                                    </a>
                                </div>
                            <?}?>
                        </div>
                    </div>
				<?}?>
				<?if(!empty($arResult["PROPERTIES"]["BTN_END_NEWS"]["VALUE"])){?>
					<div align="center" class="knopka">
						<a href="<?=$arResult["PROPERTIES"]["BTN_END_NEWS"]["VALUE"]?>" ><?=$arResult["PROPERTIES"]["BTN_END_NEWS"]["DESCRIPTION"]?></a>
					</div>
				<?}?>
<?if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){?>

<div class="next_salon">
			
			<h2><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['NAME']?></h2><br>
			<?foreach($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'] as $id){?>
				<div class='next_salon_item'>
				<strong><?if($id==699777){?>
						Сервисный центр БАРВИХА LUXURY VILLAGE<br>
					<?}else{?>
						Сервисный центр <?=($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['IN']=='MSK' ? 'на':'в')?> <?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_ADDRESS_SRC']?><br>
                    <?}?></strong>

                <? $arPhones = explode('доб.', $arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_SERVICE_VALUE']); ?>

				<a href="tel:<?= current($arPhones) ?>"><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_SERVICE_VALUE']?></a><br>
				Часы работы: <?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_MASTERSKAYA_VALUE']?>
				<?if (!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE'])){
					echo "<pre style='text-align:left;display:none;'>";print_r($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE']);echo "</pre>";
						?>
						<br><?=htmlspecialcharsBack($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE']['TEXT'])?>
						<?
					}?>
				</div>
			<?}?>
		
		
	
</div>

<?}?>

			</div>
			<div class="col-md-1 d-none d-md-block"></div>
			<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
			<?if(!empty($arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'])){?>
				<div class="next_recomend ">
					<div class="recomend_title"><?=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME']?></div>
					<div class="recomend_list">
					<ul>
					<?foreach($arResult['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'] as $idR=>$vlR){?>
					<li><a href="<?=$vlR['DETAIL_PAGE_URL']?>"><?=$vlR['NAME']?> >></a><br><span><?=$arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$idR]['DATA_FORMAT']?></span><span class="news__views_recomend"><span class="fa fa-eye"></span> <?=intval($arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$idR]['SHOW_COUNTER']);?></span>
					</li>
					<?}?>
					</ul>

                        <? if ($arParams['IBLOCK_ID'] == 82): ?>
                            <a href="/discount/" class='btn-blue'>Все акции</a>
                        <? else: ?>
                            <a href="/news/" class='btn-blue'>Все новости</a>
                        <? endif ?>

					<?if(!empty($arResult['RECOMEND_BLOCK_BANNER'])){?>
						<?foreach($arResult['RECOMEND_BLOCK_BANNER'] as $ban){?>
							<br>
							<?if(!empty($ban['PROPERTY_LINK_VALUE'])){?>
							<a target="_blank" href="<?=$ban['PROPERTY_LINK_VALUE']?>" >
							<?}?>
							<img src="<?=CFile::GetPath($ban["PREVIEW_PICTURE"])?>" width="100%" />
							<?if(!empty($ban['PROPERTY_LINK_VALUE'])){?>
								</a>
							<?}?>
						<?}?>
					<?}?>
					</div>
					
				</div>
			<?}?>
			</div>
		</div>
	

</div>

<?/*if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){?>
<div class="container-fluid">
<div class="row next_salon">
			<div class="">
			<h2><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['NAME']?></h2><br>
			<?foreach($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'] as $id){?>
				<div class='next_salon_item'>
				Сервисный центр <?=($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['IN']=='MSK' ? 'на':'в')?> <?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_ADDRESS_SRC']?><br>
				<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_VALUE']?><br>
				Часы работы: <?=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_MASTERSKAYA_VALUE']?>
				</div>
			<?}?>
		</div>
		
	
</div>
</div>
<?}*/?>

<?if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE'])){?>
<div class="container-fluid next_tovar pb-5">
	<div class="row">
	<div class="col-sm-12 pl-0 pr-0">
	<?/*<!--pre>NEXT_TOVAR <?print_r($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][652611]);?></pre-->*/?>
	<h2><?=(!empty($arResult['PROPERTIES']['NEXT_TOVAR_TITLE']['VALUE'])? $arResult['PROPERTIES']['NEXT_TOVAR_TITLE']['VALUE']: $arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['NAME'])?></h2><br>
	<div class="recommend__wrapper">
    <div class="recommend owl-carousel owl-theme js_recommend">
        <?foreach($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE'] as $id){?>
            <div class="recommend__item">
  
            
            <? /*if (isset($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"]) &&
                   !empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"])){ ?>
                <span class="old_price" >
                  <?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"];?>
                </span>
				   <? }*/ ?>
				   <? if (isset($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']) &&
                   !empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'])){ ?>
						<div class="procent_skidki_boll" style="z-index: 1;">-<?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']?>%</div>
				   <? } ?>
                <div class="recommend__img">
                    <a href="<?= $arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"] ?>">


                                 <?if($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['DETAIL_PICTURE']):?>
                                    <img src="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['DETAIL_PICTURE_SRC']?>" alt="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_ELEMENT_VALUE'][$id]['NAME']?>">
                                <?else:?>
                                    <div class="no-photo"></div>
                                <?endif?>



                    </a>
                </div>
                <div class="recommend__title">
                    <a href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>"><?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_ELEMENT_VALUE'][$id]['NAME']?></a>
                </div>
                <div class="recommend__price">
                    
                        <span><?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
						<? if (isset($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"]) &&
                   !empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"])){ ?>
                <del>
                  <?=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$id]["PROPERTY_OLD_PRICE_VALUE"];?>
                </del>
				   <? } ?>
                 
                </div>
				
            </div>
        <?}?>
    </div>
</div>
<div><?if(!empty($arResult['PROPERTIES']['NEXT_TOVAR_LINK']['VALUE'])){?><a target="_blank" href="<?=$arResult['PROPERTIES']['NEXT_TOVAR_LINK']['VALUE']?>" class='btn-blue'>Все товары</a><?}?></div>
	</div>
	</div>
</div>
<?}?>

<?if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'])){?>

<div class="container-fluid next_service pb-5">
	<div class="row">
		
			<?foreach($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'] as $id){
				if(empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$id])){continue;}
				?>
				<?/*<div class="col-md-6 service_item"  >
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6">
								
									<a href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>">
									<img class="preview_picture bdr" border="0" src="<?=\CFile::GetPath($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["PREVIEW_PICTURE"])?>" alt="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?>" title="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?>" />
									</a>
								
							</div>
							<div class="col-md-6">
								
									<h3><a href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>"><b><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?></b></a><br /></h3>
								
								<?if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$id]['PROPERTY_ANONS_VALUE'])):?>
									<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$id]['PROPERTY_ANONS_VALUE']['TEXT'];?>
								<?endif;?>
								<br>
								<a target="_blank" href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>" class='btn-blue mx-0'>Подробнее</a>
							</div>
						</div>
					</div>     
				</div>*/?>
				<div class="col-md-6 service_item"  >
					<div class="row">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6 pr-md-0">
								<div class="row">
									<a href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>">
									<img class="preview_picture " border="0" src="<?=\CFile::GetPath($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["PREVIEW_PICTURE"])?>" alt="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?>" title="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?>" />
									</a>
								</div>
								</div>
								<div class="col-md-6">
									
									<div class="container-fluid h-100">
										<div class="row h-100">
											<div class="col-md-2">
											</div>
											<div class="col-md-10 service_item_opis h-100">
												<h3><a href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>"><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["NAME"]?></a><br /></h3>
											
											<?if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$id]['PROPERTY_ANONS_VALUE'])):?>
												<div class="minanons"><?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$id]['~PROPERTY_ANONS_VALUE']['TEXT'];?></div>
											<?endif;?>
											<br>
											<a target="_blank" href="<?=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_ELEMENT_VALUE'][$id]["DETAIL_PAGE_URL"]?>" class='btn-blue mx-0'>Подробнее</a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>     
					</div>
					</div>
			<?}?>
		
	</div>
</div>
<?}?>





















<?/*



<div class="news-detail">
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<h4><span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span></h4>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<div class="ov_hidden">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
			<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
		<?endif?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
			<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
		<?endif;?>
		<?if($arResult["NAV_RESULT"]):?>
			<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
			<?echo $arResult["NAV_TEXT"];?>
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
		<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
			<?echo $arResult["DETAIL_TEXT"];?>
		<?else:?>
			<?echo $arResult["PREVIEW_TEXT"];?>
		<?endif?>
		<div style="clear:both"></div>
		<br />
		<?foreach($arResult["FIELDS"] as $code=>$value):?>
				<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
				<br />
		<?endforeach;?>
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			<br />
		<?endforeach;?>
		<?
		if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
		{
			?>
			<div class="news-detail-share">
				<noindex>
				<?
				$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
						"HANDLERS" => $arParams["SHARE_HANDLERS"],
						"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
						"PAGE_TITLE" => $arResult["~NAME"],
						"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
						"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
						"HIDE" => $arParams["SHARE_HIDE"],
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);
				?>
				</noindex>
			</div>
			<?
		}
		?>
	</div>
</div>
*/?>