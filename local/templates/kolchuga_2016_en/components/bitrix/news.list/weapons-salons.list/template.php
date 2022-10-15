<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

?><div class="salon_list">
	<div class="table_salon_list"><?

$counter = 0;

foreach($arResult["ITEMS"] as $arItem)
{

	if(is_array($arItem))
	{
		if($arItem['PROPERTIES']['show_in_list']['VALUE_XML_ID'] != 'NO')
		{

			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			?><div class="table_salon_list_td" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="block_salonBody">
					<h2><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
					<div><?
						if(is_array($arItem["PREVIEW_PICTURE"]))
						{
							?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="bdr">
							</a><?
						}
					?></div>
					<div class="block_menu_salon"><?

						if ($arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"])
						{
							?><ul class="menu_salon"><?

								if ($arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["salon"]["VALUE"];?>">О салоне</a></li><?
								}

								if ($arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"];?>">Каталог товаров</a></li><?
								}

								if ($arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"];?>">Юридическая информация</a></li><?
								}

								if ($arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["about_director"]["VALUE"];?>">О руководителе</a></li><?
								}

								if ($arItem["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"];?>" target="_blank">3D-тур</a></li><?
								}

								if ($arItem["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"])
								{
									?><li><a href="<?=$arItem["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"];?>" target="_blank">Схема проезда</a></li><?
								}

							?></ul><?
						}

					?></div>
					<div class="ov_hidden"><?
						if ($arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"])
						{
							?><h2 class="fl_left">Адрес</h2><?
						}
						?><div class="address_info_right"><?
							if ($arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"])
							{
								?><p><?=$arItem["DISPLAY_PROPERTIES"]["address"]["VALUE"];?></p><?
							}

							if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"])
							{
								?><p <?if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_alex ||$arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_chinasity || $arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_lenpr):?>class="metro_orange"<?endif?><?if ($arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_tuch || $arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_kotel){

									?>class="metro_purple"<?
								}
									?>><i class="bdr">м</i><?=$arItem["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"];?></p><?
							}

							if ($arItem["DISPLAY_PROPERTIES"]["phones"]["VALUE"] || $arItem["DISPLAY_PROPERTIES"]["fax"]["VALUE"])
							{
								?><p>
									Телефон <?=$arItem["DISPLAY_PROPERTIES"]["phones"]["VALUE"];?> <br />
									Факс <?=$arItem["DISPLAY_PROPERTIES"]["fax"]["VALUE"];?><br />
									Часы работы: <?=$arItem["DISPLAY_PROPERTIES"]["clock"]["VALUE"];?><br /><?
							}

							if ($arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"])
							{
								?>e-mail <a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?>"><?=$arItem["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?></a><br/>
								Мастерская: <?=$arItem["DISPLAY_PROPERTIES"]["masterskaya"]["VALUE"];?>
								</p><?
							}

						?></div>
						<div><?=$arItem["PREVIEW_TEXT"]?></div>
					</div>
				</div>
			</div><?

			$counter++;
			if($counter % 2 == 0)
			{
				echo '<hr class="tr_border">';
			}

		}
	}
}

?></div>
</div>
