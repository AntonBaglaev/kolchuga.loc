<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="salon_list">
	<div class="table_salon_list"><?
		$counter = 0;
		foreach($arResult["ROWS"] as $arItems)
		{
			foreach($arItems as $arElement)
			{
				if(is_array($arElement))
				{
					if($arElement['PROPERTIES']['show_in_list']['VALUE_XML_ID'] != 'NO')
					{
						$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));

						?><div class="table_salon_list_td" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
							<div class="block_salonBody">
								<h2><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></h2>
								<div>
									<?if(is_array($arElement["PREVIEW_PICTURE"])):?>
										<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
											<img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" class="bdr" />
										</a>
									<?endif?>
								</div>
								<div class="block_menu_salon">
								<?if ($arElement["DISPLAY_PROPERTIES"]["salon"]["VALUE"] || $arElement["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"] || $arElement["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"] || $arElement["DISPLAY_PROPERTIES"]["about_director"]["VALUE"]):?>
									<ul class="menu_salon">
										<?if ($arElement["DISPLAY_PROPERTIES"]["salon"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["salon"]["VALUE"];?>">О салоне</a>
											</li>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["catalog_link"]["VALUE"];?>">Каталог товаров</a>
											</li>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["legal_information"]["VALUE"];?>">Юридическая информация</a>
											</li>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["about_director"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["about_director"]["VALUE"];?>">О руководителе</a>
											</li>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["tur3d"]["VALUE"];?>" target="_blank">3D-тур</a>
											</li>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"]):?>
											<li>
												<a href="<?=$arElement["DISPLAY_PROPERTIES"]["contact_link"]["VALUE"];?>" target="_blank">Схема проезда</a>
											</li>
										<?endif?>
									</ul>
								<?endif?>
								</div>
								<div class="ov_hidden">
									<?if ($arElement["DISPLAY_PROPERTIES"]["address"]["VALUE"]):?>
										<h2 class="fl_left">Адрес</h2>
									<?endif?>
									<div class="address_info_right">
										<?if ($arElement["DISPLAY_PROPERTIES"]["address"]["VALUE"]):?>
											<p>
												<?=$arElement["DISPLAY_PROPERTIES"]["address"]["VALUE"];?>
											</p>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"]):?>
											<p <?if ($arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_alex ||$arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_chinasity || $arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_lenpr):?>class="metro_orange"<?endif?><?if ($arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_tuch || $arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE_XML_ID"] == metro_kotel):?>class="metro_purple"<?endif?>>
												<i class="bdr">м</i><?=$arElement["DISPLAY_PROPERTIES"]["metro_station"]["VALUE"];?>
											</p>
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["phones"]["VALUE"] || $arElement["DISPLAY_PROPERTIES"]["fax"]["VALUE"]):?>
											<p>
												Телефон <?=$arElement["DISPLAY_PROPERTIES"]["phones"]["VALUE"];?> <br />
												Факс <?=$arElement["DISPLAY_PROPERTIES"]["fax"]["VALUE"];?><br />
											Часы работы: <?=$arElement["DISPLAY_PROPERTIES"]["clock"]["VALUE"];?><br />
											
										<?endif?>
										<?if ($arElement["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"]):?>
											e-mail <a href="mailto:<?=$arElement["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?>"><?=$arElement["DISPLAY_PROPERTIES"]["e_mail"]["VALUE"];?></a><br/>
											Мастерская: <?=$arElement["DISPLAY_PROPERTIES"]["masterskaya"]["VALUE"];?>
											</p>
										<?endif?>
										<!-- <?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
											<p>
											<?=$arProperty["NAME"]?>:&nbsp;<?
												if(is_array($arProperty["DISPLAY_VALUE"]))
													echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
												else
													echo $arProperty["DISPLAY_VALUE"];?>
											</p>
										<?endforeach?> -->
									</div>
									<div>
										<?=$arElement["PREVIEW_TEXT"]?>
									</div>
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
		}
	?></div>
</div>