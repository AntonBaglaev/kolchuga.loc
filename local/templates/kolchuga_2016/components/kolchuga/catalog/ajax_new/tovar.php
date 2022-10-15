<div class="alt_view_all" id="alt_view_all" style='border-top: 1px dotted #ababab;padding-top: 20px;'>
<div class="as_title_not_arrow" style="float: left;padding-top: 5px;font-size: 1.2em;">Все товары</div>
<? if($GLOBALS['check_modile'] == false): ?>
				<?
		        $sort = array(
		            //'PROPERTY_NOVINKA' => 'Новизне',
		            //'NAME' => 'Названию',
		            'SHOW_COUNTER' => 'Популярности     ',
		            'CATALOG_PRICE_2' => 'Цене',
		        );

		        $selected_default = false;
		        if(!$_REQUEST['sort_field']){
		            $selected_default = true;
		        }
		        ?>	        

				<div class="sort_catalog" class="clearfix">
					<form method="post" action="<?=$APPLICATION->GetCurUri()?>" class="c_sort_form">
						<div class="b-filter__row filter_result b-ffr">
				            <div class="filter_result_1 b-filter__item_nob">
				                <div class="sort-item"><span>Сортировка по:</span>
				                <select class="js-sort-sel sort_select_ajax" name="sort_field">
									<? foreach($sort as $key => $item): ?>
										<?if($key=='CATALOG_PRICE_2'){?>
											<option
											<? if($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'asc'): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="asc">Возрастанию цен</option>
										<option
											<? if(($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'desc') || ($selected_default && $key == 'PROPERTY_NOVINKA')): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="desc">Убыванию цен</option>
										<?}else{?>
										<?/*<option
											<? if($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'asc'): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="asc"><?= $item ?> &uarr;</option>
										<option <? if(($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'desc') || ($selected_default && $key == 'PROPERTY_NOVINKA')){?> selected <? } ?> value="<?= $key ?>" data-order="desc"><?= $item ?> &darr;</option>*/?>
											
											<option
											<? if(($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'desc') || ($selected_default && $key == 'SHOW_COUNTER')): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="desc"><?= $item ?></option>
											
										<?}?>
									<? endforeach ?>
								</select>
				                <input type="hidden" name="sort_order" value="<?= $_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc' ?>"></div>
				            </div>
				            <div class="filter_result_2"><input class="submit" type="submit" name="set_filter" id="ajax_submit_sort" value="Показать"></div>
				        </div>
				    </form>
				</div>
				<div class="clearfix"></div>
				<script>
					function ajaxFilterUpdate(selector){
			            $('html').addClass('disabled-filter');
			            if (selector !== false) $(selector).click();

			        }
					$('.sort_select_ajax').change(function(){
			            $('input[name="sort_order"]').val($(this).find('option:selected').data('order'));
			            ajaxFilterUpdate('#ajax_submit_sort');
			        });
			        BX.addCustomEvent('onAjaxSuccess', function(){
			            $('select').selectric({
			                arrowButtonMarkup:'<b class="icon-arrow-down"></b>',
			                disableOnMobile:false,
			                maxHeight:'200'
			            });
			        });
				</script>
			<? endif ?>	
			<? if($GLOBALS['check_modile']): ?>
				<?$APPLICATION->IncludeComponent(
					"kolchuga:catalog.smart.filter",
					"",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SAVE_IN_SESSION" => "N",
						"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
						"XML_EXPORT" => "Y",
						"SECTION_TITLE" => "NAME",
						"SECTION_DESCRIPTION" => "DESCRIPTION",
						'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						"SEF_MODE" => $arParams["SEF_MODE"],
						"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
						"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
						"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);?>
			<? endif ?>
			<?

			if($_REQUEST['sort_field'] && $_REQUEST['sort_order']){
				$arParams['ELEMENT_SORT_FIELD2'] = $arParams['ELEMENT_SORT_FIELD'];
				$arParams['ELEMENT_SORT_ORDER2'] = $arParams['ELEMENT_SORT_ORDER'];
				$arParams['ELEMENT_SORT_FIELD'] = $_REQUEST['sort_field'];
				$arParams['ELEMENT_SORT_ORDER'] = $_REQUEST['sort_order'];
			} else {
				/*$arParams['ELEMENT_SORT_FIELD2'] = 'PROPERTY_NOVINKA';
				$arParams['ELEMENT_SORT_ORDER2'] = 'DESC';*/				

				$arParams['ELEMENT_SORT_FIELD2'] = 'created';
				$arParams['ELEMENT_SORT_ORDER2'] = 'desc';

			}

			//if($CHECK_ALT_VIEW) $arParams['PAGE_ELEMENT_COUNT'] = 6;

			if($_REQUEST['PAGEN_SIZE'] > 0 && $_REQUEST['PAGEN_SIZE'] <= 500){
				$arParams['PAGE_ELEMENT_COUNT'] = $_REQUEST['PAGEN_SIZE'];
			}

			if(empty($_REQUEST['sort_field'])){
				$arParams['ELEMENT_SORT_FIELD2'] = 'PROPERTY_NOVINKA';
				$arParams['ELEMENT_SORT_FIELD2'] = 'SHOW_COUNTER';
				$arParams['ELEMENT_SORT_ORDER2'] = 'desc';
				$arParams['ELEMENT_SORT_FIELD'] = 'HAS_DETAIL_PICTURE';
				$arParams['ELEMENT_SORT_ORDER'] = 'desc,nulls';
			}
      	
     		$exGSectVarNameProp = "exGSectVarNameProp";
			?>

			<? 
			$sectionId = $arResult["VARIABLES"]["SECTION_ID"];
			$sectionCode = $arResult["VARIABLES"]["SECTION_CODE"];
			//nah - чистим секцию при наличии тегов-фильтров из других секций
			if($GLOBALS['remove_section']){
				$sectionId = '';
				$sectionCode = '';
			}


			//nah - костыль для раздела /internet_shop/odezhda/odezhda-dlya-bolshikh-okhotnikov_2/
			$copySection = $sectionId;
 			if($sectionId == '18037'){
 				//делаем выборку из родительского раздела, по большим размерам
 				global $shopFilter;
				$shopFilter['PROPERTY_RAZMER'] = array('XXL', 'XXXL', 'XXXXL', 'XXXXXL', '58', '60', '62', '64', '66', '68', '70');				
				$sectionId = '17906';
				$sectionCode = 'odezhda';
			}
			//после компонента костыль для мета тегов


			if($_GET['sort_field'] == 'PROPERTY_NOVINKA' && $_GET['sort_order']){
				$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_NOVINKA';
				$arParams['ELEMENT_SORT_ORDER'] = $_GET['sort_order'];
				/*$arParams['ELEMENT_SORT_FIELD'] = 'HAS_DETAIL_PICTURE';
				$arParams['ELEMENT_SORT_ORDER'] = 'desc,nulls';*/

				$arParams['ELEMENT_SORT_FIELD2'] = 'created';
				$arParams['ELEMENT_SORT_ORDER2'] = $_GET['sort_order'];

			} 
			?>

			<? if (!empty($UNDER_TEXT)): ?>
			    <div><?=$UNDER_TEXT;?></div> <br/>
			<? endif ?>
			<?
			if(!empty($arCurSection["NAVCHAIN"]['tovary_vtorichnogo_rynka'])){
				$GLOBALS[$arParams['FILTER_NAME']]['!NAME'] = "%уценка%";
			}
			
			if($GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DULNAYA_ENERGIYA'][0]=='от 3 до 7,5 Дж'){
				unset($GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DULNAYA_ENERGIYA']);
				$arParams['ELEMENT_SORT_FIELD2']='sort';
				$arParams['ELEMENT_SORT_ORDER2']='asc';
			}?>
			<?//\Kolchuga\Settings::xmp($GLOBALS[$arParams["FILTER_NAME"]],11460, __FILE__.": ".__LINE__);?>
			<?$APPLICATION->IncludeComponent(
				"custom:catalog.section",
				"cat",
				Array(
					//"CHECK_ALT_VIEW" => $CHECK_ALT_VIEW,
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],					
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],

					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

					"SECTION_ID" => $sectionId,
					"SECTION_CODE" => $sectionCode,
					"SECTION_URL" => '',//$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => "",//$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
          			'GSetSectMetaProp' => $exGSectVarNameProp,
          			'SHOW_ALL_WO_SECTION' => 'Y' 
				),
				$component
			);
			?>
			</div>