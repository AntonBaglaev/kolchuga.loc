<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? 
$UNDER_TEXT = "";
$DESCRIPTION_PAGE = "";
$EX_SECTION_LIST = "";
$ExSectionAddSEO = "arAdditionlSSeoData";
$ALT_VIEW = "";

if (isset($GLOBAS[$ExSectionAddSEO])){
	unset($GLOBAS[$ExSectionAddSEO]);
}


if(CModule::includeModule('iblock')){
	$res = CIBlockSection::GetList(
		array(), 
		array('ID' => $arResult['VARIABLES']['SECTION_ID'], 'IBLOCK_ID' => $arParams['IBLOCK_ID']), 
		false, 
		array("ID", 'IBLOCK_ID', 'NAME', 'DESCRIPTION', 'UF_UNDER_TEXT', 'UF_ALT_VIEW'));
		
	if($item = $res->GetNext()){
		if($item['~DESCRIPTION']){
          $DESCRIPTION_PAGE = $item['~DESCRIPTION'];
        }
      	$UNDER_TEXT = $item['~UF_UNDER_TEXT'];

      	$ALT_VIEW = $item['UF_ALT_VIEW'];
	}		
}


//запоминаем сортировку на 1ч
global $APPLICATION;
if($_REQUEST['sort_field'] && $_REQUEST['sort_order']){
	$cookTime = time()+60*60;
	$APPLICATION->set_cookie("cook_sort_field", $_REQUEST['sort_field'], $cookTime);
	$APPLICATION->set_cookie("cook_sort_order", $_REQUEST['sort_order'], $cookTime);
}else{
	if($cook_sort_field = $APPLICATION->get_cookie("cook_sort_field")){
		$_REQUEST['sort_field'] = $cook_sort_field;
	}
	if($cook_sort_order = $APPLICATION->get_cookie("cook_sort_order")){
		$_REQUEST['sort_order'] = $cook_sort_order;
	}
}
?>

	<?		      

	//if($ALT_VIEW !== '1'){
	if(1){

        if (intval($arParams["EX_FILTER_IBLOCK_ID"]) > 0 && intval($arResult["VARIABLES"]["SECTION_ID"]) > 0){
        	ob_start();
          $filterName = "arExSMFCatalog";
          $GLOBALS[$filterName] = array(
            "PROPERTY_CSECTIONS" => intval($arResult["VARIABLES"]["SECTION_ID"]),
            "!=PROPERTY_POSITION_BOTTOM_VALUE" => "Y"
          );
    
            $APPLICATION->IncludeComponent(
              "kolchuga:news.line", 
              "ks02", 
              array(
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["VARIABLES"]["SECTION_CODE_PATH"]."/#CODE#/",
                "FIELD_CODE" => array(
                  0 => "ID",
                  1 => "CODE",
                  2 => "NAME",
                  3 => "PROPERTY_FILTER",
                  4 => "PREVIEW_TEXT"
                ),
                "IBLOCKS" => array(
                  0 => intval($arParams["EX_FILTER_IBLOCK_ID"]),
                ),
                //"IBLOCK_TYPE" => "",
                "NEWS_COUNT" => "300",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "NAME",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "COMPONENT_TEMPLATE" => "ks01",
                "ELEMENT_ID" => $arResult["VARIABLES"]["EX_FILTER_ELEMENT_ID"],
                "ELEMENT_CODE" => $arResult["VARIABLES"]["EX_FILTER_ELEMENT_CODE"],
                "FILTER_NAME" => $filterName,
                "CATALOG_FILTER_NAME" => $arParams["FILTER_NAME"],
                "GLOBALS_EX_VAR" => $ExSectionAddSEO
              ),
              $component,
              array("HIDE_ICONS" => "Y")
            );            
    
          
        
          $EX_SECTION_LIST = ob_get_clean();
        
          ob_start();
        
            unset($GLOBALS[$filterName]["!=PROPERTY_POSITION_BOTTOM_VALUE"]);
            $GLOBALS[$filterName]["PROPERTY_POSITION_BOTTOM_VALUE"] = "Y";
        
            //внутри компонента в component_epilog.php происходит добавление доп. фильтра по тегам, сбор фильтров в result_modifier.php

            $APPLICATION->IncludeComponent(
              "kolchuga:news.line", 
              "ks01", 
              array(
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["VARIABLES"]["SECTION_CODE_PATH"]."/#CODE#/",
                "FIELD_CODE" => array(
                  0 => "ID",
                  1 => "CODE",
                  2 => "NAME",
                  3 => "PROPERTY_FILTER",
                  4 => "PREVIEW_TEXT",
                  5 => "PROPERTY_SELECT_SECTION",
                  6 => "PROPERTY_FILTER_OR",
                  7 => "PROPERTY_FILTER_OR_2",
                  8 => "PROPERTY_TAG_GROUP",
                ),
                "IBLOCKS" => array(
                  0 => intval($arParams["EX_FILTER_IBLOCK_ID"]),
                ),
                //"IBLOCK_TYPE" => "",
                "NEWS_COUNT" => "300",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "NAME",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "COMPONENT_TEMPLATE" => "ks01",
                "ELEMENT_ID" => $arResult["VARIABLES"]["EX_FILTER_ELEMENT_ID"],
                "ELEMENT_CODE" => $arResult["VARIABLES"]["EX_FILTER_ELEMENT_CODE"],
                "FILTER_NAME" => $filterName,
                "CATALOG_FILTER_NAME" => $arParams["FILTER_NAME"],
                "GLOBALS_EX_VAR" => $ExSectionAddSEO
              ),
              $component,
              array("HIDE_ICONS" => "Y")
            );           

          unset($GLOBALS[$filterName]);
        
        
          $EX_SECTION_LIST2 = ob_get_clean();
      	}  



      }


        
          if (isset($GLOBALS[$ExSectionAddSEO]) && array_key_exists("DESCRIPTION", $GLOBALS[$ExSectionAddSEO])){
             $DESCRIPTION_PAGE = $GLOBALS[$ExSectionAddSEO]["DESCRIPTION"];
          }
	?>   
    
	<div class="catalog">
		<aside class="sidebar__catalog">
			<div class="sidebar__block">
				<? $APPLICATION->IncludeComponent(
					"bitrix:catalog.section.list",
					"left",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"TOP_DEPTH" => 1,
						"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
						"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
						"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
						"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
					),
					$component,
					array("HIDE_ICONS" => "Y")
				); ?>


				<? if($GLOBALS['check_modile'] == false/* && $ALT_VIEW !== '1'*/): ?>				

					<?$APPLICATION->IncludeComponent(
						"kolchuga:catalog.smart.filter",
						"sidebar",
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

			</div>
		</aside>
		<div class="catalog__wrapper">

		<? include_once('title.php'); ?>

		 


		<? if($_GET['t'] == 'y'): ?>

			<? 
				$CUR_URI = $APPLICATION->getCurPage(false);
				$ARR_URI = explode('/', $CUR_URI);
				$CNT_URI = count($ARR_URI);
			?>
			<? if($CNT_URI == 4 && $ALT_VIEW == '1'): ?>

				<? if (!empty($UNDER_TEXT)): ?>
				    <div><?=$UNDER_TEXT;?></div> <br/>
				<? endif; ?>

				<?$APPLICATION->IncludeComponent(
				"kolchuga:catalog.section.list","alt_view",
				Array(
				        "VIEW_MODE" => "TEXT",
				        "SHOW_PARENT_NAME" => "Y",
				        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
				        "SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
				        "SECTION_CODE" => "",
				        "SECTION_URL" => "",
				        "COUNT_ELEMENTS" => "N",
				        "TOP_DEPTH" => "1",
				        "SECTION_FIELDS" => "",
				        "SECTION_USER_FIELDS" => array(
							0 => "UF_BLOCK_ITEMS",
							1 => "",
							2 => "",
						),
				        "ADD_SECTIONS_CHAIN" => "",
				        "CACHE_TYPE" => "A",
				        "CACHE_TIME" => "36000000",
				        "CACHE_NOTES" => "",
				        "CACHE_GROUPS" => "Y"
				    )		
				);?>		

				<? if ($DESCRIPTION_PAGE): ?>
				    <div><?=$DESCRIPTION_PAGE;?></div> <br/>
				<? endif; ?> 

			<? endif ?>


		<? else: ?>
		


    
			<? if($GLOBALS['check_modile'] == false): ?>
				<?
		        $sort = array(
		            'PROPERTY_NOVINKA' => 'Новизне',
		            'NAME' => 'Названию',
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
				                <select class="js-sort-sel sort_select" name="sort_field">
									<? foreach($sort as $key => $item): ?>
										<option
											<? if($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'asc'): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="asc"><?= $item ?> &uarr;</option>
										<option
											<? if(($_REQUEST['sort_field'] == $key && $_REQUEST['sort_order'] == 'desc') || ($selected_default && $key == 'PROPERTY_NOVINKA')): ?>selected<? endif ?>
											value="<?= $key ?>" data-order="desc"><?= $item ?> &darr;</option>
									<? endforeach ?>
								</select>
				                <input type="hidden" name="sort_order" value="<?= $_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc' ?>"></div>
				            </div>
				            <div class="filter_result_2"><input class="submit" type="submit" name="set_filter" value="Показать"></div>
				        </div>
				    </form>
				</div>
				<div class="clearfix"></div>
			<? endif ?>


		    <?
		      echo $EX_SECTION_LIST;
		    ?>

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
				$arParams['ELEMENT_SORT_FIELD2'] = $_REQUEST['sort_field'];
				$arParams['ELEMENT_SORT_ORDER2'] = $_REQUEST['sort_order'];
			} else {
				/*$arParams['ELEMENT_SORT_FIELD2'] = 'PROPERTY_NOVINKA';
				$arParams['ELEMENT_SORT_ORDER2'] = 'DESC';*/				

				$arParams['ELEMENT_SORT_FIELD2'] = 'created';
				$arParams['ELEMENT_SORT_ORDER2'] = 'desc';

			}

			if($_REQUEST['PAGEN_SIZE'] > 0 && $_REQUEST['PAGEN_SIZE'] <= 500){
				$arParams['PAGE_ELEMENT_COUNT'] = $_REQUEST['PAGEN_SIZE'];
			}

			//Photo filter
//			$GLOBALS[$arParams['FILTER_NAME']]['>DETAIL_PICTURE'] = 0;
//			if($_GET['NOT_PICTURE_ONLY'] == 1)
//				unset($GLOBALS[$arParams['FILTER_NAME']]['>DETAIL_PICTURE']);

			/*$arParams['ELEMENT_SORT_FIELD'] = 'HAS_DETAIL_PICTURE';
			$arParams['ELEMENT_SORT_ORDER'] = 'DESC';*/

			$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_NOVINKA';
			$arParams['ELEMENT_SORT_ORDER'] = 'desc';
      	
     		$exGSectVarNameProp = "exGSectVarNameProp";

     		//shopFilter
     		//var_dump($GLOBALS['shopFilter']);
     		/*array(
     			">CATALOG_PRICE_2"=> '', 
     			"=PROPERTY_IS_SKU_VALUE"=> "Нет" 
     			array( 
     				"LOGIC"=> "OR",
     				">CATALOG_QUANTITY"=> '',
     				">PROPERTY_SKU_QUANTITY"=> '',
     			),
     			"PROPERTY_KALIBR"=> array("20", "12", "12.") 
 			);*/
			?>

			<? 
			$sectionId = $arResult["VARIABLES"]["SECTION_ID"];
			$sectionCode = $arResult["VARIABLES"]["SECTION_CODE"];
			//nah - чистим секцию при наличии тегов-фильтров из других секций
			if($GLOBALS['remove_section']){
				$sectionId = '';
				$sectionCode = '';
			}
			
			?>

 			<? 
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
			?>

			<? /*if($_SERVER['REMOTE_ADDR'] == '37.235.221.171'): ?>

				<? 
				if($_GET['sort_field'] == 'PROPERTY_NOVINKA' && $_GET['sort_field']){
					global $shopFilter;
					//var_dump($shopFilter);
					$arSortSelect = array('ID', 'IBLOCK_ID', 'PROPERTY_NOVINKA', 'DETAIL_PICTURE', 'TIMESTAMP_X');
					//$arSortFilter = array('IBLOCK_ID'=> $arParams["IBLOCK_ID"], '=PROPERTY_IS_SKU_VALUE'=>'Нет');
					$arSortFilter = $shopFilter;
					$arSortFilter['IBLOCK_ID'] = $arParams["IBLOCK_ID"];
					$arSortFilter['ACTIVE'] = 'Y';
					$arSortFilter['SECTION_GLOBAL_ACTIVE'] = 'Y';
					$arSortFilter['INCLUDE_SUBSECTIONS'] = 'Y';
					if($sectionId){
						$arSortFilter['SECTION_ID'] = $sectionId;
					}
					
					$outSortElements = array();
					$objSortElements = CIBlockElement::GetList(array('timestamp_x'=>$_GET['sort_field']), $arSortFilter, false, false, $arSortSelect);
					while($dataSortElement = $objSortElements->GetNext()){
						$outSortElements[$dataSortElement['ID']] = $dataSortElement['ID'];
					}
					//var_dump(count($outSortElements));
					$shopFilter['ID'] = $outSortElements;
					var_dump($outSortElements);
				} 
				?>

			<? endif*/ ?>


			<? 
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
			<? endif; ?>


			<?$APPLICATION->IncludeComponent(
				"custom:catalog.section",
				"cat",
				Array(
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


			<? if ($DESCRIPTION_PAGE): ?>
			    <div><?=$DESCRIPTION_PAGE;?></div> <br/>
			<? endif; ?> 
			
        
			<? if (!empty($EX_SECTION_LIST2)): ?>
				<div class="exFilterListBottom">
					<?=$EX_SECTION_LIST2;?>
				</div>
			<? endif; ?>

		<? endif ?>
        
			<? 
			if($copySection == '18037'){
				$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"],$copySection);
		        $IPROPERTY  = $ipropValues->getValues();
		        if(count($IPROPERTY)>0){
		            if(array_key_exists('SECTION_META_TITLE', $IPROPERTY) && $IPROPERTY['SECTION_META_TITLE'] !== ''){
		                $APPLICATION->SetPageProperty("title", $IPROPERTY['SECTION_META_TITLE']);
		            }
		            if(array_key_exists('SECTION_PAGE_TITLE', $IPROPERTY) && $IPROPERTY['SECTION_PAGE_TITLE'] !== ''){
		                $APPLICATION->SetTitle($IPROPERTY['SECTION_PAGE_TITLE']);
		            }
		            if(array_key_exists('SECTION_META_DESCRIPTION', $IPROPERTY) && $IPROPERTY['SECTION_META_DESCRIPTION'] !== ''){
		                $APPLICATION->SetPageProperty("description", $IPROPERTY['SECTION_META_DESCRIPTION']);
		            }
		            if(array_key_exists('SECTION_META_KEYWORDS', $IPROPERTY) && $IPROPERTY['SECTION_META_KEYWORDS'] !== ''){
		                $APPLICATION->SetPageProperty("keywords", $IPROPERTY['SECTION_META_KEYWORDS']);
		            }
				}
			}
			?>

			<?
			  // SetMetaTag
			  if (is_array($GLOBALS[$exGSectVarNameProp]) && 
			      !empty($GLOBALS[$exGSectVarNameProp]))
			  {
			      $APPLICATION->SetPageProperty("title", $GLOBALS[$exGSectVarNameProp]["NAME"].GetMessage("CT_SET_META_SECTION_PAGE", array("#NUM#" => $GLOBALS[$exGSectVarNameProp]["PAGE"])));
			      $APPLICATION->SetPageProperty("description", $APPLICATION->GetPageProperty("description").GetMessage("CT_SET_META_SECTION_PAGE", array("#NUM#" => $GLOBALS[$exGSectVarNameProp]["PAGE"])));
			  }
			?>
		</div>
	</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
		"PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
		'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
		'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],

		'FILTER_NAME' => 'saleFilter'
	),
	$component
);?>
  
<?

  if (is_array($GLOBALS[$ExSectionAddSEO]))
  {
    foreach(array("ELEMENT_META_DESCRIPTION" => "description",
                  "ELEMENT_PAGE_TITLE" => "h1",
                  "ELEMENT_META_TITLE" => "title",
                  "ELEMENT_META_KEYWORDS" => "keywords") as $k=>$v)
    {
      if (array_key_exists($k, $GLOBALS[$ExSectionAddSEO]) &&
          !empty($GLOBALS[$ExSectionAddSEO][$k]))
      {
        $APPLICATION->SetPageProperty($v, $GLOBALS[$ExSectionAddSEO][$k]);
      }
    }
  
    if (is_array($GLOBALS[$ExSectionAddSEO]["CHAIN"]))
    {
      $APPLICATION->AddChainItem($GLOBALS[$ExSectionAddSEO]["CHAIN"]["TEXT"], 
                                 $GLOBALS[$ExSectionAddSEO]["CHAIN"]["LINK"]);
    }
      
  }
  
?>