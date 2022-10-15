<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.js"></script> 
<script type="text/javascript" src="/js/jcarousellite_1.0.1.pack.js"></script> 

<script type="text/javascript">
	$(document).ready(function(){
		$(".fancybox").fancybox({
			'margin'		:	1, 
			'padding'		:	1, 
			'hideOnContentClick'	:	true
		});
		/**/
		$(".thumbs a:first").addClass('activ_thumbs');	
		$(".thumbs a").click(function(){	
			$('.thumbs a').removeClass('activ_thumbs');
			$(this).addClass('activ_thumbs');
			var largePath = $(this).attr("href");									
			var largeRel = $(this).attr("rel");									
			$("#largeImg").attr({ style: "background-image:url("+largePath+");",  href: largeRel});
			 return false;
		});
		/**/
		$(".gallery_good").jCarouselLite({
			btnNext: ".next",
			btnPrev: ".prev",
			circular: false
		});

	});
</script>
<div class="catalog-element">
	<div class="ov_hidden p">	
	<div class="catalog-element-inner">
		<?if(is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="good_block_photo">
				<?/*<h1 class="color_blue"><?=$arResult["NAME"]?></h1>*/?>
				<? 	$imgb = CFile::ResizeImageGet(
			            $arResult["DETAIL_PICTURE"],
			            array("width" => 380, "height" => 380),
			            BX_RESIZE_IMAGE_PROPORTIONAL,
			            true,
			            $arWaterMark
			        );
			        $imgb = $imgb['src'];
				?>
				<?
					$imgm = thumbnail($arResult["DETAIL_PICTURE"]['ID'], 90, 60, false, TRUE);
					
					$imgn = CFile::ResizeImageGet(
			            $arResult["DETAIL_PICTURE"],
			            array("width" => 2000, "height" => 1024),
			            BX_RESIZE_IMAGE_PROPORTIONAL,
			            true,
			            $arWaterMarkBig
			        );
			        $arResult['DETAIL_PICTURE']['SRC'] = $imgn['src'];	
				?>
				<div class="p">
					<a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img_block bdr dib fancybox" id="largeImg" style="background-image:url(<?=$imgb?>);"></a>
				</div>
				<div class="scroll_min_img bdr">
					<div class="gallery_good">
						<ul class="thumbs">
							<li>
								<a href="<?=$imgb?>" rel="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="imgm_block bdr dib" style="background-image:url(<?=$imgm?>);"></a>
							</li>
							<?
							// additional photos
							$LINE_ELEMENT_COUNT = 2; // number of elements in a row
							if(count($arResult["MORE_PHOTO"])>0):?>
								<?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>
									<li>
										<?
											/*echo"<pre>";
											print_r($PHOTO);
											echo"</pre>";*/
											$imgb2 = CFile::ResizeImageGet(
									           	$PHOTO['ID'],
									            array("width" => 380, "height" => 380),
									            BX_RESIZE_IMAGE_PROPORTIONAL,
									            true,
									            $arWaterMark
									        );
									        $imgb2 = $imgb2['src'];
										?>
										<?
											$imgm2 =thumbnail($PHOTO['ID'], 90, 60, false, TRUE);
											
											$imgn2 = CFile::ResizeImageGet(
									           	$PHOTO['ID'],
									            array("width" => 1024, "height" => 1024),
									            BX_RESIZE_IMAGE_PROPORTIONAL,
									            true,
									            $arWaterMarkBig
									        );
									        
									        $PHOTO['SRC'] = $imgn2['src'];
												
										?>
										<a href="<?=$imgb2?>" rel="<?=$PHOTO["SRC"]?>" class="imgm_block bdr dib" style="background-image:url(<?=$imgm2?>);"></a>
									</li>
								<?endforeach?>
							<?endif?>
							
						</ul>
					</div>
					<div class="prev"><span></span></div><div class="next"><span></span></div>
				</div>
			</div>
		<?else:?>
			<?/*<h1 class="color_blue"><?=$arResult["NAME"]?></h1>*/?>
		<?endif?>

		<div class="body_element_good">	

			<div class="good_wrapper">
				<div class="good_left"><?
					if($arResult["DISPLAY_PROPERTIES"])
					{
						?><div class="good_block">
							<div class="good_block_title">Характеристики</div>
							<div class="good_block_inner"><?
								foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty)
								{
									if($arProperty["NAME"] == 'Требуется лицензия')
									{

									}
									else
									{
										?><div class="list_quality">
											<p><?=$arProperty["NAME"]?></p>
											<b><?
												if(is_array($arProperty["DISPLAY_VALUE"])):
													echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
												elseif($pid=="MANUAL"):
													?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
												else:
													echo $arProperty["DISPLAY_VALUE"];?>
												<?endif?>
											</b>
										</div><?
									}
								}

							?></div>
						</div><?
					}
				?><div class="good_block">
						<div class="good_block_title">Наличие</div>
						<div class="good_block_inner"><?

						if($arResult['STORES'])
						{
							?><ul class="salon_yes"><?
								foreach($arResult['STORES'] as $store)
								{
									?><li class="yes"><span><?=$store?></span></li><?
								}
							?></ul><?
						}
						else
						{
							?><h2 class="color_gray">Нет в наличии</h2><?
						}
						?></div>
					</div>
					
				</div><?/* @end good_left */?>
				<div class="good_right"><?

					if($arResult["DISPLAY_PROPERTIES"]["TREBUETSYA_LITSENZIYA"]["VALUE"] != ''){
						echo '<div class="lisens"><span>Только <br />по лицензии</span></div>';
					}

					if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]))
					{

						foreach($arResult["OFFERS"] as $arOffer)
						{

							foreach($arParams["OFFERS_FIELD_CODE"] as $field_code)
							{
								?><small><?
									echo GetMessage("IBLOCK_FIELD_".$field_code)?>:&nbsp;<?
									echo $arOffer[$field_code];?></small><br /><?
							}
							?>
							<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
								<small><?=$arProperty["NAME"]?>:&nbsp;<?
									if(is_array($arProperty["DISPLAY_VALUE"]))
										echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
									else
										echo $arProperty["DISPLAY_VALUE"];?></small><br />
							<?endforeach?>
							<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<p><!-- <?=$arResult["CAT_PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp; -->
									<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
										<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
									<?else:?>
										<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?>.</span>
									<?endif?>
									</p>
								<?endif;?>
							<?endforeach;?>
							<div><?
								if($arParams["DISPLAY_COMPARE"])
								{
									?><noindex><a href="<?echo $arOffer["COMPARE_URL"]?>" rel="nofollow">
										<?echo GetMessage("CT_BCE_CATALOG_COMPARE")?>
									</a>&nbsp;</noindex><?
								}

								if($arOffer["CAN_BUY"])
								{
									if($arParams["USE_PRODUCT_QUANTITY"])
									{
										?><form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
											<table border="0" cellspacing="0" cellpadding="2">
												<tr valign="top">
													<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
													<td>
														<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5">
													</td>
												</tr>
											</table>
											<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
											<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
											<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?echo GetMessage("CATALOG_BUY")?>">
											<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CT_BCE_CATALOG_ADD")?>">
										</form><?
									}
									else
									{
										?><noindex>
										<a href="<?echo $arOffer["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
										&nbsp;
										<a href="<?echo $arOffer["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_ADD")?></a>
										</noindex><?
									}
								}
								elseif(count($arResult["CAT_PRICES"]) > 0)
								{
									?><?=GetMessage("CATALOG_NOT_AVAILABLE")?><?
								}
							?></div><?
						}

					}
					else
					{

						if(!$arResult['SKU'])
						{
							foreach($arResult["PRICES"] as $code=>$arPrice)
							{
								?><?if($arPrice["CAN_ACCESS"]):?>
									<!-- <?=$arResult["CAT_PRICES"][$code]["TITLE"];?>&nbsp;
									<?if($arParams["PRICE_VAT_SHOW_VALUE"] && ($arPrice["VATRATE_VALUE"] > 0)):?>
										<?if($arParams["PRICE_VAT_INCLUDE"]):?>
											(<?echo GetMessage("CATALOG_PRICE_VAT")?>)
										<?else:?>
											(<?echo GetMessage("CATALOG_PRICE_NOVAT")?>)
										<?endif?>
									<?endif;?>:&nbsp; -->
									<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
										<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?>.</span>
										<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
											<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["DISCOUNT_VATRATE_VALUE"] > 0 ? $arPrice["PRINT_DISCOUNT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
										<?endif;?>
									<?else:?>
										<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?>.</span>
										<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
											<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["VATRATE_VALUE"] > 0 ? $arPrice["PRINT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
										<?endif;?>
									<?endif?>
								<?endif;?><?
							}
						}

						if(is_array($arResult["PRICE_MATRIX"]))
						{
							?><table cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table">
								<thead>
									<tr>
										<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) >= 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
											<td><?= GetMessage("CATALOG_QUANTITY") ?></td>
										<?endif;?>
										<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
											<td><?= $arType["NAME_LANG"] ?></td>
										<?endforeach?>
									</tr>
								</thead>
								<?foreach ($arResult["PRICE_MATRIX"]["ROWS"] as $ind => $arQuantity):?>
									<tr>
										<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) > 1 || count($arResult["PRICE_MATRIX"]["ROWS"]) == 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
											<th nowrap>
												<?if(IntVal($arQuantity["QUANTITY_FROM"]) > 0 && IntVal($arQuantity["QUANTITY_TO"]) > 0)
													echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_FROM_TO")));
												elseif(IntVal($arQuantity["QUANTITY_FROM"]) > 0)
													echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], GetMessage("CATALOG_QUANTITY_FROM"));
												elseif(IntVal($arQuantity["QUANTITY_TO"]) > 0)
													echo str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_TO"));
												?>
											</th>
										<?endif;?>
										<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
											<td>
												<?if($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"] < $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"])
													echo '<s>'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"]).'</s> <span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
												else
													echo '<span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
												?>
											</td>
										<?endforeach?>
									</tr>
								<?endforeach?>
							</table>
							<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?>
								<?if($arParams["PRICE_VAT_INCLUDE"]):?>
									<small><?=GetMessage("CATALOG_VAT_INCLUDED")?></small>
								<?else:?>
									<small><?=GetMessage("CATALOG_VAT_NOT_INCLUDED")?></small>
								<?endif?>
							<?endif;?><br /><?
						}

						/* IF CAN BUY */
						if($arResult["CAN_BUY"])
						{
							if($arParams["USE_PRODUCT_QUANTITY"] || count($arResult["PRODUCT_PROPERTIES"]))
							{
								?><form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
									<table border="0" cellspacing="0" cellpadding="2">
										<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
											<tr valign="top">
												<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
												<td>
													<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5">
												</td>
											</tr>
										<?endif;?>
										<?foreach($arResult["PRODUCT_PROPERTIES"] as $pid => $product_property):?>
											<tr valign="top">
												<td><?echo $arResult["PROPERTIES"][$pid]["NAME"]?>:</td>
												<td>
												<?if(
													$arResult["PROPERTIES"][$pid]["PROPERTY_TYPE"] == "L"
													&& $arResult["PROPERTIES"][$pid]["LIST_TYPE"] == "C"
												):?>
													<?foreach($product_property["VALUES"] as $k => $v):?>
														<label><input type="radio" name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]" value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"checked"'?>><?echo $v?></label><br>
													<?endforeach;?>
												<?else:?>
													<select name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]">
														<?foreach($product_property["VALUES"] as $k => $v):?>
															<option value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"selected"'?>><?echo $v?></option>
														<?endforeach;?>
													</select>
												<?endif;?>
												</td>
											</tr>
										<?endforeach;?>
									</table>
									<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
									<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
									<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?echo GetMessage("CATALOG_BUY")?>">
									<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CATALOG_ADD_TO_BASKET")?>">
								</form><?
							}
							else
							{
								if($arResult["DISPLAY_PROPERTIES"]["TREBUETSYA_LITSENZIYA"]["VALUE"] == '')
								{
									?><div class="offers_table_wrapper">
										<?if($arResult['SKU']):?>
											<div class="table-responsive">
												<table id="" class="offers_table js-offers">
													<thead>
														<tr>
															<th>Цвет</th>
															<th>Размер</th>
															<th>Цена</th>
															<th>Кол-во</th>
														</tr>
													</thead>
													<tbody>
														<?foreach($arResult['SKU'] as $color_list):
															foreach($color_list as $key => $arItem):
																if(!$arItem['MIN_PRICE']['DISCOUNT_VALUE']) continue;
														?>
														<tr class="js-row" data-id="<?=$arItem['ID']?>">
															<td><?=$arItem['PROPERTY_TSVET_VALUE']?></td>
															<td><?=$arItem['PROPERTY_RAZMER_VALUE']?></td>
															<td><b><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></b></td>
															<td><input type="text" name="" class="input_inside js-q" value="" id=""maxlength="6"></td>
														</tr>
														<?endforeach;
															endforeach?>
													</tbody>
												</table>
											</div>
										<?endif?>
										<noindex>
											<div class="but_good text-center">
												<?/* <div class="button_blue">
													<a href="<?echo $arResult["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
												</div> */?>
												<div class="button_blue">
													<a class="js-buy-btn" href="#" data-id="<?=$arResult['ID']?>" rel="nofollow">Купить</a>
												</div>
												<div class="good_add_cart">
													<div class="wrap_good_add_cart">
														<div class="good_add_cart_img"></div>
														<div class="good_add_cart_right">
															<div><b>Товар добавлен в корзину</b></div>
															<div><a href="/internet_shop/basket/">Оформить заказ</a></div>
															<div><a href="">Продолжить покупки</a></div>
														</div>
													</div>
												</div>
											</div>
										</noindex>
									</div><?
								}
							}
						}
						elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"]))
						{
							?><?=GetMessage("CATALOG_NOT_AVAILABLE")?><?
						}

					}
					?>
				</div><?/* @end good_right */?>
			</div>
		
		

	
			<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>

			<?else:?>


				<!-- \\ if can buy // -->

			<?endif?>

		</div>
	</div>
	</div>
	<?if($arResult["DETAIL_TEXT"]):?>
		<div class="p"><?=$arResult["DETAIL_TEXT"]?></div>
	<?endif;?>
	
	<!--pre>
	 <?//echo print_r($arResult["PROPERTIES"]["WE_RECOMEND_WITH_IT"]);?>
	</pre-->
	
	<?if(!empty($arResult["PROPERTIES"]["WE_RECOMEND_WITH_IT"]["VALUE"])):?>
		<div class="block_complete">
			<h3><strong>С этим товаром покупают:</strong></h3>
			<div>
				<ul class="we_recommend_it">
				<?foreach($arResult['PROPERTIES']["WE_RECOMEND_WITH_IT"]["VALUE"] as $recomended_good_id):?>
					<li>
						<?
							$res = CIBlockElement::GetByID($recomended_good_id);
							$a_good = array();
							if($a_good = $res->GetNext()){
								unset($a_good['DETAIL_TEXT']);
								unset($a_good['~DETAIL_TEXT']);
								unset($a_good['SEARCHABLE_CONTENT']);
								unset($a_good['~SEARCHABLE_CONTENT']);
								if($a_good['DETAIL_PICTURE']){
									$a_good_dp_id = $a_good['DETAIL_PICTURE'];
									$a_good['DETAIL_PICTURE_SMALL'] = thumbnail($a_good_dp_id, 90, 60, false, TRUE);
								}
							}
//							echo '<hr><pre>'.print_r($a_good).'</pre><hr>';
						?>
						<div class="content_section">
							<div class="p">
							<a href="<?=$a_good["DETAIL_PAGE_URL"]?>">
								<!-- <img src='<?=$a_good['DETAIL_PICTURE_SMALL']?>'> -->
								<!-- <?echo"<pre>";print_r($a_good);	echo"</pre>";?> -->
								<?
								 $imgb=thumbnail($a_good['DETAIL_PICTURE'], 200, 150, false, TRUE);
								?>
								<div class="img_section bdr" style="background:#fff url(<?=$imgb?>) center center no-repeat;"></div>
							</a>
							</div>
							<div class="info_section">
								<h3>
									<a href="<?=$a_good["DETAIL_PAGE_URL"]?>">
										<?=$a_good["NAME"]?>
									</a>
								</h3>
							</div>
						</div>
					</li>
				<?endforeach?>
				</ul>
			</div>
		</div>
	<?endif?>
	
	<?if(count($arResult["LINKED_ELEMENTS"])>0):?>
		<br /><b><?=$arResult["LINKED_ELEMENTS"][0]["IBLOCK_NAME"]?>:</b>
		<ul>
	<?foreach($arResult["LINKED_ELEMENTS"] as $arElement):?>
		<li><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
	<?endforeach;?>
		</ul>
	<?endif?>
	<!-- <?
	// additional photos
	$LINE_ELEMENT_COUNT = 2; // number of elements in a row
	if(count($arResult["MORE_PHOTO"])>0):?>
		<a name="more_photo"></a>
		<?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>
			<img border="0" src="<?=$PHOTO["SRC"]?>" width="<?=$PHOTO["WIDTH"]?>" height="<?=$PHOTO["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" /><br />
		<?endforeach?>
	<?endif?> -->
	<!-- <?if(is_array($arResult["SECTION"])):?>
		<br /><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=GetMessage("CATALOG_BACK")?></a>
	<?endif?> -->
	<div class="p">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "template20", Array(
			"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
			"PATH" => SITE_DIR."include/catalog_info.php",	// Путь к файлу области
			"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
			),
			false,
			array(
			"ACTIVE_COMPONENT" => "Y"
			)
		);?>
	</div>
	<div class="p">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "template20", Array(
			"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
			"PATH" => SITE_DIR."include/object.php",	// Путь к файлу области
			"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
			),
			false,
			array(
			"ACTIVE_COMPONENT" => "Y"
			)
		);?>
	</div>
</div>