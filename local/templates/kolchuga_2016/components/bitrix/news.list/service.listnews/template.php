<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="container-fluid pb-5 pl-0 pr-0">
<?//echo "<pre>";print_r($arResult["ITEMS"]);echo "</pre>";?>

<?if($arResult["ITEMS"][0]['SORT']==1){
$osnovnoy=$arResult["ITEMS"][0];
unset($arResult["ITEMS"][0]);
?>
	<?
	$this->AddEditAction($osnovnoy['ID'], $osnovnoy['EDIT_LINK'], CIBlock::GetArrayByID($osnovnoy["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($osnovnoy['ID'], $osnovnoy['DELETE_LINK'], CIBlock::GetArrayByID($osnovnoy["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="row">
	<div class="rowanons" id="<?=$this->GetEditAreaId($osnovnoy['ID']);?>">
		<div class="row">
			<div class="col-md-6 order-2">
			<div class="container-fluid service_bread d-none d-md-block">
				<div class="row">
					<div class="col-2 bgbread">&nbsp;</div>
                    <div class="col-8">
                        <ul>
                            <li class="bx-breadcrumb-item" id="bx_breadcrumb_0" itemscope=""
                                itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a href="/" title="Главная" itemprop="url">
                                    <span itemprop="title">Главная</span>
                                </a>
                            </li>
                            <li>&gt;</li>
                            <li>
                                <span><?= $arResult['NAME'] ?></span>
                            </li>
                        </ul>
                    </div>
				</div>
			</div>
			  <h1><?=$osnovnoy['NAME']?></h1><br>
			  <div class="osnanons">
			<?if($osnovnoy["PREVIEW_TEXT"]){ echo $osnovnoy["PREVIEW_TEXT"]; }?>
			</div>
			</div>
			
			<div class="col-md-6 order-1 order-md-2">
			 <?if($arParams["DISPLAY_PICTURE"]!="N" && !empty($arResult["DOPOLNITELNO"][$osnovnoy["ID"]]['DETAIL_PICTURE_SRC'])):?>
					
						<?/*if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($osnovnoy["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?=$osnovnoy["DETAIL_PAGE_URL"]?>">
							<img class="preview_picture " border="0" src="<?=$arResult["DOPOLNITELNO"][$osnovnoy["ID"]]['DETAIL_PICTURE_SRC']?>" width="100%"  alt="<?=$osnovnoy["NAME"]?>" title="<?=$osnovnoy["NAME"]?>" />
							</a>
						<?else:*/?>
							<img class="preview_picture " border="0" src="<?=$arResult["DOPOLNITELNO"][$osnovnoy["ID"]]['DETAIL_PICTURE_SRC']?>" width="100%"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
						<?//endif;?>
					
				<?endif?>
			</div>
		</div>
		<div class="w-100 pb-5"><br></div>
		<div class="row">
			<div class="col-md-8 osntext pr-md-5">
				<?if($osnovnoy["DETAIL_TEXT"]){ echo $osnovnoy["DETAIL_TEXT"]; }?>
				<?if(!empty($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){?>

	
		<div class="next_salon">
			<div class="">
				<h2><?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['NAME']?></h2><br>
				<?foreach($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'] as $id){?>
					<div class='next_salon_item'>
					Сервисный центр <?=($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['IN']=='MSK' ? 'на':'в')?> <?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_ADDRESS_SRC']?><br>
					<?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_SERVICE_VALUE']?><br>
					Часы работы: <?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_MASTERSKAYA_VALUE']?>
					<?if (!empty($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE'])){
						?>
						<br><?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_DOP_DESCRIPTION_VALUE']['TEXT']?>
						<?
					}?>
					</div>
				<?}?>
			</div>
			
		</div>
	
	<?}?>
			</div>
			<div class="col-md-1 d-none d-md-block"></div>
			<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
			<?if(!empty($osnovnoy['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'])){?>
				<div class="next_recomend ">
					<div class="recomend_title"><?=$osnovnoy['DISPLAY_PROPERTIES']['REKOMEND']['NAME']?></div>
					<div class="recomend_list">
					<ul>
					<?foreach($osnovnoy['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'] as $idR=>$vlR){?>
					<li><a href="<?=$vlR['DETAIL_PAGE_URL']?>"><?=$vlR['NAME']?> >></a><br><span><?=$osnovnoy['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$idR]['DATA_FORMAT']?></span>
					</li>
					<?}?>
					</ul>
					<a target="_blank" href="/news/" class='btn-blue'>Все новости</a>
					</div>
				</div>
			<?}?>
			</div>
		</div>
	</div>
	</div>

	
	<?/*if(!empty($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){?>

	
		<div class="row next_salon">
			<div class="">
				<h2><?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['NAME']?></h2><br>
				<?foreach($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'] as $id){?>
					<div class='next_salon_item'>
					Сервисный центр <?=($osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['IN']=='MSK' ? 'на':'в')?> <?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_ADDRESS_SRC']?><br>
					<?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_PHONES_VALUE']?><br>
					Часы работы: <?=$osnovnoy['DISPLAY_PROPERTIES']['NEXT_SALON']['DOPOLNITELNO'][$id]['PROPERTY_MASTERSKAYA_VALUE']?>
					</div>
				<?}?>
			</div>
			
		</div>
	
	<?}*/?>
	
<?
}
//echo "<pre>";print_r($arResult["ITEMS"][0]);echo "</pre>";
?>





<div class="w-100 pb-5"><br></div>



<div class="row list_service_container">

<?foreach($arResult["ITEMS"] as $arItem):?>

<?if(empty($arResult["DOPOLNITELNO"][$arItem["ID"]]['PROPERTY_ANONS_VALUE']) || empty($arItem["PREVIEW_PICTURE"])){continue;}?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	
	if(empty($arItem['PROPERTIES']['LINK']['VALUE'])){
		$arItem['PROPERTIES']['LINK']['VALUE']=$arItem['DETAIL_PAGE_URL'];
	}
	?>
	
	<div class="col-md-6 service_item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<div class="row">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 pr-md-0">
				<div class="row">
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
						<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>">
						<img class="preview_picture " border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
						</a>
					<?else:?>
						<img class="preview_picture " border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
					<?endif;?>
				</div>
				</div>
				<div class="col-md-6">
					
					<div class="container-fluid h-100">
						<div class="row h-100">
							<div class="col-md-2">
							</div>
							<div class="col-md-10 service_item_opis h-100">
							<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
								<h3>
									<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
										<a href="<?echo $arItem['PROPERTIES']['LINK']['VALUE']?>"><?echo $arItem["NAME"]?></a><br />
									<?else:?>
										<?echo $arItem["NAME"]?>
									<?endif;?>
								</h3>
							<?endif;?>
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && !empty($arResult["DOPOLNITELNO"][$arItem["ID"]]['PROPERTY_ANONS_VALUE'])):?>
								<div class="minanons"><?echo $arResult["DOPOLNITELNO"][$arItem["ID"]]['PROPERTY_ANONS_VALUE']['TEXT'];?></div>
							<?endif;?>
							<br>
							<a target="_blank" href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class='btn-blue mx-0'>Подробнее</a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>     
    </div>
    </div>
	
	
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>

</div>
</div>