<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*<script>console.log(<?echo json_encode($_SERVER['HTTP_USER_AGENT'])?>);</script>
<script>console.log(<?echo json_encode($GLOBALS['check_modile'])?>);</script> 
*/?>
<? 
$UNDER_TEXT = "";
$sectionNames = '';
$sectionNamesPage = '';
$sectionNamesPageCountry = '';
$DESCRIPTION_PAGE = "";
$EX_SECTION_LIST = "";
$ExSectionAddSEO = "arAdditionlSSeoData";
$CHECK_ALT_VIEW = false;
$ALT_VIEW = "";

$CUR_URI = $APPLICATION->getCurPage(false);
$ARR_URI = explode('/', $CUR_URI);
$CNT_URI = count($ARR_URI);


if (isset($GLOBAS[$ExSectionAddSEO])){
	unset($GLOBAS[$ExSectionAddSEO]);
}


//section info
$arFilterSect = [
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
];

if (!empty($arResult["VARIABLES"]["SECTION_ID"])) {
    $arFilterSect["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
} elseif (!empty($arResult["VARIABLES"]["SECTION_CODE"])) {
    $arFilterSect["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
}

$obCache = new CPHPCache();
if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arFilterSect), "/iblock/catalog")) {
    $arCurSection = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arCurSection = [];

    \Bitrix\Main\Loader::includeModule("iblock");

    $dbRes = \CIBlockSection::GetList(
        [],
        $arFilterSect,
        false,
        [
            "ID",
            "CODE",
            "NAME",            
        ]
    );

    if (defined("BX_COMP_MANAGED_CACHE")) {
        global $CACHE_MANAGER;
        $CACHE_MANAGER->StartTagCache("/iblock/catalog");

        if (($arCurSection = $dbRes->Fetch()) !== false) {
            $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
        }
        $CACHE_MANAGER->EndTagCache();
    } else {
        if (!$arCurSection = $dbRes->Fetch()) {
            $arCurSection = [];
        }
    }
	
	$navChain = CIBlockSection::GetNavChain($arParams["IBLOCK_ID"], $arCurSection["ID"]);
		while ($arNav=$navChain->GetNext()){
				$realNavChain[$arNav['CODE']]=$arNav['ID'];					
		}
		$arCurSection['NAVCHAIN']=$realNavChain;			
	
    $obCache->EndDataCache($arCurSection);
}

if (!isset($arCurSection)) {
    $arCurSection = [];
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

      	$sectionNames = $item['NAME'];      	
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams['IBLOCK_ID'],$item["ID"]);				     
	    $item["IPROPERTY_VALUES"] = $ipropValues->getValues();
	    $sectionNamesPage = $item['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
	    
				
	}		
}


if($CNT_URI == 4 && $ALT_VIEW == '1'){
	$CHECK_ALT_VIEW = true;
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
//\Kolchuga\Settings::xmp($GLOBALS[$ExSectionAddSEO],11460, __FILE__.": ".__LINE__);

  $EX_SECTION_LIST2 = ob_get_clean();
  
  if(!empty($arResult["VARIABLES"]["EX_FILTER_ELEMENT_ID"]) && !empty($arResult["VARIABLES"]["EX_FILTER_ELEMENT_CODE"])){
	//  \Kolchuga\Settings::xmp($GLOBALS[$ExSectionAddSEO],11460, __FILE__.": ".__LINE__);
	//\Kolchuga\Settings::xmp($arResult["VARIABLES"],11460, __FILE__.": ".__LINE__);
	  if(empty($GLOBALS[$ExSectionAddSEO])){
		  $APPLICATION->SetPageProperty('title', "Страница не найдена");
		   \Bitrix\Iblock\Component\Tools::process404(
			   false, //Сообщение
			   true, // Нужно ли определять 404-ю константу
			   true, // Устанавливать ли статус
			   true, // Показывать ли 404-ю страницу
			   false // Ссылка на отличную от стандартной 404-ю
			);
	  }
  }
}  


if (isset($GLOBALS[$ExSectionAddSEO]) && array_key_exists("DESCRIPTION", $GLOBALS[$ExSectionAddSEO])){
	$DESCRIPTION_PAGE = $GLOBALS[$ExSectionAddSEO]["DESCRIPTION"];
}

?>   
    
	<div class="catalog">
			<?//banner or info-text?>
				<?
				global $banFilterInfopolosa;
				$banFilterInfopolosa['PROPERTY_WHERE_SECTION']=$arResult["VARIABLES"]["SECTION_ID"];
				$banFilterInfopolosa['!PROPERTY_INFOPOLOSA']=false;				
				?>
				<?$APPLICATION->IncludeComponent("bitrix:news.list","catalog_banner_polosa",Array(
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"AJAX_MODE" => "Y",
						"IBLOCK_TYPE" => 'banners',
						"IBLOCK_ID" => "73",
						"NEWS_COUNT" => "1",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "SORT",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "banFilterInfopolosa",
						"FIELD_CODE" => Array("DETAIL_PICTURE","DETAIL_TEXT"),
						"PROPERTY_CODE" => Array("LINK"),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"SET_TITLE" => "N",
						"SET_BROWSER_TITLE" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_LAST_MODIFIED" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "3600",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "Y",
						"DISPLAY_TOP_PAGER" => "Y",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "Новости",
						"PAGER_SHOW_ALWAYS" => "Y",
						"PAGER_TEMPLATE" => "",
						"PAGER_DESC_NUMBERING" => "Y",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "Y",
						"PAGER_BASE_LINK_ENABLE" => "Y",
						"SET_STATUS_404" => "N",
						"SHOW_404" => "N",
						"MESSAGE_404" => "",
						"PAGER_BASE_LINK" => "",
						"PAGER_PARAMS_NAME" => "arrPager",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => ""
					)
				);?>
	
	
		<aside class="sidebar__catalog">
			<div class="sidebar__block">
			
		
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "left4",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                    "TOP_DEPTH" => 2,
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                    "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                    "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            ); ?>
		

				<? if($GLOBALS['check_modile'] == false && $CHECK_ALT_VIEW == false): ?>				

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
		<?//\Kolchuga\Settings::xmp($arResult["VARIABLES"],11460, __FILE__.": ".__LINE__);
		if(in_array($arResult["VARIABLES"]['SECTION_ID'], [17827,17835,17828,17895,17900,17894,17858,17861,17841,17842,17843,17844,17845,17846,17851,17853,17854,17855,17857,18092])){
			$APPLICATION->IncludeFile('/include/wasbanner_catalog.php', array(), array());
		}
		?>
		<div class="catalog__wrapper pl-lg-5">
		
		<?//banner or info-text?>
				<?
				global $banFilter;
				$banFilter['PROPERTY_WHERE_SECTION']=$arResult["VARIABLES"]["SECTION_ID"];
				$banFilter['PROPERTY_INFOPOLOSA']=false;				
				?>
				<?$APPLICATION->IncludeComponent("bitrix:news.list","catalog_banner",Array(
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"AJAX_MODE" => "Y",
						"IBLOCK_TYPE" => 'banners',
						"IBLOCK_ID" => "73",
						"NEWS_COUNT" => "1",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "SORT",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "banFilter",
						"FIELD_CODE" => Array("DETAIL_PICTURE","DETAIL_TEXT"),
						"PROPERTY_CODE" => Array("LINK"),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"SET_TITLE" => "N",
						"SET_BROWSER_TITLE" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_LAST_MODIFIED" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "3600",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "Y",
						"DISPLAY_TOP_PAGER" => "Y",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "Новости",
						"PAGER_SHOW_ALWAYS" => "Y",
						"PAGER_TEMPLATE" => "",
						"PAGER_DESC_NUMBERING" => "Y",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "Y",
						"PAGER_BASE_LINK_ENABLE" => "Y",
						"SET_STATUS_404" => "N",
						"SHOW_404" => "N",
						"MESSAGE_404" => "",
						"PAGER_BASE_LINK" => "",
						"PAGER_PARAMS_NAME" => "arrPager",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => ""
					)
				);?>
		
		 
        <? $rrr=$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "root3",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                "TOP_DEPTH" => 2,
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                "ADD_SECTIONS_CHAIN" => 'N'
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        ); ?>
<?if (defined('NEWSHLIST') ) {?>
<? include_once('tovar.php'); ?>
<?}?>		

<?if (!defined('NEWSHLIST')) {?>

		<? include_once('title.php'); ?>

    
<?/* if ($USER->GetID()=="11460"){
	?>
	<div style="display:none;">
	<?
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 46, 'ID' => 699912, 'ACTIVE'=>'Y', '!PROPERTY_NO_SEE'=>false, 'PROPERTY_BANNER_IN_SECTION'=>$arResult["VARIABLES"]['SECTION_ID']), false, false, Array('ID','NAME','DETAIL_PAGE_URL','PREVIEW_PICTURE'));
		if($dbEl->SelectedRowsCount()>0){
			$itog_ms=[];
			while($obEl = $dbEl->Fetch()){
				$itog_ms[$obEl['ID']]=$obEl;
			}			
		}
	if(!empty($itog_ms)){
	?>
		<div class="section_brand container-fluid0 mb-5">
			<div class="row setslick">
				<?foreach ($itog_ms as $ElID=>$el){?>
					<div class="col-12 col-md-2 mb-5 mlh pl5 pr0">									
						<div class="separator"><a href="<?=$el['DETAIL_PAGE_URL']?>"><?=$el['NAME']?></a></div>
						<a href="<?=$el['DETAIL_PAGE_URL']?>">
						<?$arFile = \Kolchuga\Pict::getWebpImgSrc( \CFile::GetPath($el['PREVIEW_PICTURE']), $intQuality = 80);?>
						<picture>
							<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
								<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
							<?endif;?>
							<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" class=" img-0" />
						</picture>
						</a>
					</div>
				<?}?>
			</div>
		</div>
		<link rel="stylesheet" type="text/css" href="/local/templates/kolchuga_2016/plugins/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="/local/templates/kolchuga_2016/plugins/slick/slick-theme.css">
		<script src="/local/templates/kolchuga_2016/plugins/slick/slick.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		$(document).on('ready', function() {
			$(window).on('load resize', function() {
				if ($(window).width() < 640) {
					$('.setslick').slick({
					  infinite: true,
					  dots: true,
					  arrows: false,
					  slidesToShow: 2,
					  slidesToScroll: 2
					});
				} else {
					$(".setslick").slick("unslick");
				  }
			});
		});
		</script>
		<style>
		.section_brand .img-0{  min-width: 100%; min-height: 100%; flex-shrink: 0;object-fit: contain;transition: all 1s ease-out;}
		@media (min-width: 600px){ .section_brand .img-0:hover{  transform: scale(0.9);} }
		.section_brand .pl10{padding-left:10px;}
		.section_brand .pr0{padding-right:0;}
		.section_brand .separator, .osnblok .separator {display: flex;align-items: center;text-align: center;height: 50px;text-transform: uppercase;font-family: 'PT Sans';	color: #5c5c5c;	}
		.section_brand .separator, .osnblok .separator{height:20px;}
		.section_brand .separator{text-transform: none;font-weight: 600;}
		.section_brand .separator a, .osnblok .separator a{color: #5c5c5c;text-decoration:none; line-height: 12px;}
		.section_brand .separator.active, .section_brand .separator.active a, .osnblok .separator.active, .osnblok .separator.active a {color: #21385e;font-weight: 600;}
		.section_brand .separator::before, .section_brand  .separator::after, .osnblok .separator::before, .osnblok  .separator::after {content: '';flex: 1;border-bottom: 1px solid #c5c5c5;min-width: 15px;}
		.section_brand .separator::before, .osnblok .separator::before {margin-right: .25em;}
		.section_brand .separator::after, .osnblok .separator::after {margin-left: .25em;}
		</style>
	<?}?>
	</div>
	<?
} */?>

			<? if($CHECK_ALT_VIEW): ?>

				<? if (!empty($UNDER_TEXT)): ?>
				    <div><?=$UNDER_TEXT?></div> <br/>
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

				<div class="alt_view_all" id="alt_view_all">
			<? endif ?>

			<? if($CHECK_ALT_VIEW): ?><div class="as_title_not_arrow">Все товары</div><? endif ?>

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
				$arParams['ELEMENT_SORT_FIELD2'] = 'PROPERTY_OLD_PRICE';
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
    // популярные страны для гладкоствольного оружия
    if($sectionId == 17835){

        $allIds = array();
        //выбираем все подразделы 17835
        $sql_section = \CIBlockSection::GetList(Array(), Array('IBLOCK_ID'=>'40', 'ACTIVE'=>'Y', 'SECTION_ID'=>'17835'), false, Array('ID'));
        while($m = $sql_section->GetNext())
        {
            $allIds[] = $m['ID'];
        }
        ?>
        <div class="exFilterList">
            <div class="fName">
                Популярные страны:
            </div>
            <ul>
                <?
                $allCountries = array();
                $r = \CIBLockElement::GetList (Array(), Array('IBLOCK_SECTION_ID'=>$allIds, 'ACTIVE'=>'Y', 'IBLOCK_ID' => '40'), false, false, Array('ID','PROPERTY_STRANA'));
                while ($db_item = $r->Fetch())
                {
					$strana=mb_strtoupper($db_item['PROPERTY_STRANA_VALUE']);
                    if((!in_array($strana, $allCountries))and($strana!='')){
						$allCountries[]=$strana;
					}
                }
				$r2 = \CIBLockElement::GetList (Array(), Array('NAME' => $allCountries, 'ACTIVE'=>'Y', 'IBLOCK_ID' => '66'), false, false, Array('ID','XML_ID','PREVIEW_PICTURE','NAME',));
				while ($db_item2 = $r2->Fetch())
				{
					echo '<li><a style="background-color:white;color:black;" onclick="return true;" href="/internet_shop/oruzhie/gladkostvolnoe_oruzhie/'.$db_item2["XML_ID"].'/"><img width="30px" src="'.\CFile::GetPath($db_item2["PREVIEW_PICTURE"]).'"> '.$db_item2["NAME"].'</a></li>';
				}				
                ?>
            </ul>
        </div>
        <?

    }
    //oruzhie_vtorichnogo_rynka
    /*if($_SERVER['REMOTE_ADDR'] == '91.219.103.184'){
        var_dump($CHECK_ALT_VIEW);
    }*/

	if(!empty($arCurSection["NAVCHAIN"]['tovary_vtorichnogo_rynka'])){
		$GLOBALS[$arParams['FILTER_NAME']]['!NAME'] = "%уценка%";
	}
	
	if($GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DULNAYA_ENERGIYA'][0]=='от 3 до 7,5 Дж'){
		unset($GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_DULNAYA_ENERGIYA']);
		$arParams['ELEMENT_SORT_FIELD2']='sort';
		$arParams['ELEMENT_SORT_ORDER2']='asc';
	}
 ?>
<?//\Kolchuga\Settings::xmp($arCurSection,11460, __FILE__.": ".__LINE__);?>
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

			<? if($CHECK_ALT_VIEW): ?></div><? endif ?>

			<?$explodedUrl = explode('/', $APPLICATION->GetCurDir());
			$newSeoh1 = '';	
			if(strpos($explodedUrl[4], 'rujie')==true){?>
			<?}else{?>
				<? if ($DESCRIPTION_PAGE): ?>
					<div><?=$DESCRIPTION_PAGE;?></div> <br/>
				<? endif; ?> 
			<?}?>
			
        
			<? if (!empty($EX_SECTION_LIST2)): ?>
				<div class="exFilterListBottom">
					<?=$EX_SECTION_LIST2;?>
				</div>
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
				  //\Kolchuga\Settings::xmp($APPLICATION->GetPageProperty("description"),11460, __FILE__.": ".__LINE__);
			      $APPLICATION->SetPageProperty("title", $GLOBALS[$exGSectVarNameProp]["NAME"].GetMessage("CT_SET_META_SECTION_PAGE", array("#NUM#" => $GLOBALS[$exGSectVarNameProp]["PAGE"])));
			      $APPLICATION->SetPageProperty("description", $APPLICATION->GetPageProperty("description").GetMessage("CT_SET_META_SECTION_PAGE", array("#NUM#" => $GLOBALS[$exGSectVarNameProp]["PAGE"])));
			  }
			?>
<?}?>
		</div>
	</div>

<?/*$APPLICATION->IncludeComponent(
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
);*/?>

<?/*$APPLICATION->IncludeComponent(
	"bitrix:sale.bestsellers",
	"defa",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_40" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"BY" => "AMOUNT",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_3" => array("CORNER"),
		"CART_PROPERTIES_4" => array(),
		"CART_PROPERTIES_40" => array("",""),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "N",
		"FILTER" => array("PU", "N", "A", "F", "S"),
		"HIDE_NOT_AVAILABLE" => "N",
		"LABEL_PROP_3" => "SPECIALOFFER",
		"LABEL_PROP_40" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFER_TREE_PROPS_4" => array("-"),
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PERIOD" => "30",
		"PRICE_CODE" => array("Розничная"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_3" => array("MANUFACTURER","MATERIAL"),
		"PROPERTY_CODE_4" => array("COLOR"),
		"PROPERTY_CODE_40" => array("",""),
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_3" => "Y",
		"SHOW_PRODUCTS_40" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);*/?>
  <? //снова меняем условия отображения товаров

    /*$obCache = new CPHPCache(); 
    $cacheLifetime = 3600 * 4; 
    $cacheID = 'arrFilterShowTop'; 
    $cachePath = '/arrfiltershowtop_cache'; 
    

    if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath))// Если кэш валиден 
    { 
        $cache_vars = $obCache->GetVars(); 
        
    } elseif ($obCache->StartDataCache()) { 
		$fil = array(
			"IBLOCK_ID"=>40,
			"ACTIVE"=>"Y",
			'>CATALOG_PRICE_2' => 0,
			'=PROPERTY_IS_SKU_VALUE' => 'Нет',
			'SECTION_ID'=>18105,
			array(
				'LOGIC' => 'OR',
				'>CATALOG_QUANTITY' => 0,
				'>PROPERTY_SKU_QUANTITY' => 0
			)
		);

		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18144;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18107;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18122;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18146;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=17858;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$fil['SECTION_ID']=18118;
		$res = \CIBlockElement::GetList( array("SHOW_COUNTER"=>"DESC"), $fil, false, array("nTopCount"=>2), array("ID") ); 
		while($ar = $res->fetch()) { $cache_vars['ID'][]=$ar['ID']; }
		$cache_vars=[];
		$cache_vars['PROPERTY_AKTSIYA_VALUE'] = 'Да';
		$obCache->EndDataCache($cache_vars); 
    }*/
	
$cache_vars=[];
$cache_vars['PROPERTY_AKTSIYA_VALUE'] = 'Да';
$GLOBALS['arrFilterShowTop']=	$cache_vars;

?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"catalog_sale2", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"BRAND_PROPERTY" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_PATH" => "",
		"COMPATIBLE_MODE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		//"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DATA_LAYER_NAME" => "dataLayer",
		"DETAIL_URL" => "",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "9",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "L",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LINE_ELEMENT_COUNT" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_RELATIVE_QUANTITY_FEW" => "мало",
		"MESS_RELATIVE_QUANTITY_MANY" => "много",
		"MESS_SHOW_MAX_QUANTITY" => "Наличие",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "COLOR_REF",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SIZES_SHOES",
			1 => "SIZES_CLOTHES",
			2 => "MORE_PHOTO",
			3 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "COLOR_REF",
			1 => "SIZES_SHOES",
		),
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "Розничная",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RELATIVE_QUANTITY_FACTOR" => "5",
		"ROTATE_TIMER" => "30",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SEF_RULE" => "",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PAGINATION" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SLIDER",
		"COMPONENT_TEMPLATE" => "catalog_sale2"
	),
	false
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

<? if($CHECK_ALT_VIEW): ?>
	<script type="text/javascript">
		BX.addCustomEvent('onAjaxSuccess', function(){
	    	if($('#alt_view_all').length > 0){
		    	var toHeight = $('#alt_view_all').offset().top;
	        	$("html, body").animate({scrollTop:toHeight},1);
	    	}
		});
	</script>
<? endif ?>

<?//генерация description для разделов					
	$arFilterOdBolId = $arResult['VARIABLES']['SECTION_ID'];
	$arFilterTeg = '';
	$arFilterOdBolPol = '';
	if($arResult['VARIABLES']['SECTION_ID'] == '18037'){
		//делаем выборку из родительского раздела, по большим размерам
		$arFilterOdBolId = 17906;
		$arFilterOdBolPol = array(
	         "LOGIC" => "OR",
	         array("PROPERTY_RAZMER" => "XXL"),
	         array("PROPERTY_RAZMER" => "XXXL"),
	         array("PROPERTY_RAZMER" => "XXXXL"),
	         array("PROPERTY_RAZMER" => "XXXXXL"),
	         array("PROPERTY_RAZMER" => "58"),
	         array("PROPERTY_RAZMER" => "60"),
	         array("PROPERTY_RAZMER" => "62"),
	         array("PROPERTY_RAZMER" => "64"),
	         array("PROPERTY_RAZMER" => "66"),
	         array("PROPERTY_RAZMER" => "68"),
	         array("PROPERTY_RAZMER" => "70")
	    );	
	}
	//\Kolchuga\Settings::xmp($arResult['VARIABLES'],11460, __FILE__.": ".__LINE__);
	if ($arResult['VARIABLES']["EX_FILTER_ELEMENT_ID"]){
		
	    $arSelectFilter = Array("ID","NAME", "PROPERTY_*");
	    $arFilterFil = Array("IBLOCK_ID" => 48, 'ID'=>$arResult['VARIABLES']["EX_FILTER_ELEMENT_ID"]);	 
	    $resFilter =  CIBlockElement::GetList(Array(), $arFilterFil, false, false, $arSelectFilter);	 
	    while($obFilter = $resFilter->GetNextElement()){
	        $arFieldsFilter = $obFilter->GetFields();
	    }
	    $sectionNamesPageCountry = $arFieldsFilter['PROPERTY_346'];
	    $tmpFilterTag = array();
	    foreach ($arFieldsFilter['PROPERTY_330'] as $key=>$value) {		    
		   $arFilterTag = array($value => $arFieldsFilter['DESCRIPTION_330'][$key]);		   
		   $tmpFilterTag[$value][] = $arFieldsFilter['DESCRIPTION_330'][$key];					    
		}
		
	    $ipropValuesTegName = new \Bitrix\Iblock\InheritedProperty\ElementValues(48, $arResult['VARIABLES']["EX_FILTER_ELEMENT_ID"]); 
		$arElementTegName["IPROPERTY_VALUES"] = $ipropValuesTegName->getValues();
		$sectionNamesPage = $arElementTegName["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"];

	}
	/* //скроываю запросы так как там где они использовались уже было закоментировано, нафига нагружать лишним сайт22,08,20
	//получение минимальной цены
	$resPrice = CIBlockElement::GetList(
		Array("CATALOG_PRICE_2"=>"ASC"), 
		Array("SECTION_ID"=>$arFilterOdBolId, $arFilterOdBolPol, $tmpFilterTag, "ACTIVE"=>"Y", ">CATALOG_PRICE_2"=>"0", "INCLUDE_SUBSECTIONS"=>"Y",'=PROPERTY_IS_SKU_VALUE' => 'Нет', array(
			'LOGIC' => 'OR',
			array("CATALOG_AVAILABLE"=>"Y"),
			array("CATALOG_AVAILABLE"=>"N", '>PROPERTY_SKU_QUANTITY' => 0)
		)),
		false,
		array('nTopCount' => '1'),					
		Array('ID', 'NAME', 'CATALOG_PRICE_2'));
	
	$sectionsIds = 0;
	while($obPrice = $resPrice->fetch())
	{
	 $obPrice[] = $obPrice;				 
	 $sectionsIds = $obPrice['ID'];						  
	}
	$price = CCatalogProduct::GetOptimalPrice($sectionsIds, 1, $USER->GetUserGroupArray(), 'N');	
	//количество товаров
	$resCount = CIBlockElement::GetList(
		Array(), 
		Array("SECTION_ID"=>$arFilterOdBolId, $arFilterOdBolPol, $tmpFilterTag, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS"=>"Y", '>CATALOG_PRICE_2' => 0,'=PROPERTY_IS_SKU_VALUE' => 'Нет', array(
			'LOGIC' => 'OR',
			array("CATALOG_AVAILABLE"=>"Y"),
			array("CATALOG_AVAILABLE"=>"N", '>PROPERTY_SKU_QUANTITY' => 0)
		)),
		array(),
		array(),					
		array());	*/					
	
	/*$pageForNewDescr = $APPLICATION->GetCurPage(false);
    $arSearchNewDescr = array(    
	    '/internet_shop/aksessuary/'=>'/internet_shop/aksessuary/',
		'/internet_shop/aksessuary/prochie-chekhly/'=>'/internet_shop/aksessuary/prochie-chekhly/',
		'/internet_shop/aktsii/belye-hanro/'=>'/internet_shop/aktsii/belye-hanro/',
		'/internet_shop/aktsii/benelli-executive/'=>'/internet_shop/aktsii/benelli-executive/',
		'/internet_shop/aktsii/odezhda-browning/'=>'/internet_shop/aktsii/odezhda-browning/', 
		'/internet_shop/aktsii/pritsely-steiner/'=>'/internet_shop/aktsii/pritsely-steiner/',
		'/internet_shop/nozhi/topory-lopaty-pily/'=>'/internet_shop/nozhi/topory-lopaty-pily/',
		'/internet_shop/odezhda/drugoe_1/'=>'/internet_shop/odezhda/drugoe_1/',
		'/internet_shop/odezhda/odezhda-dlya-bolshikh-okhotnikov_2/'=>'/internet_shop/odezhda/odezhda-dlya-bolshikh-okhotnikov_2/',
		'/internet_shop/odezhda/tovary-dlya-safari/'=>'/internet_shop/odezhda/tovary-dlya-safari/',
		'/internet_shop/odezhda/tovary-dlya-safari/italyanskie-s/'=>'/internet_shop/odezhda/tovary-dlya-safari/italyanskie-s/',
		'/internet_shop/odezhda/tovary-dlya-safari/nemetskie-s/'=>'/internet_shop/odezhda/tovary-dlya-safari/nemetskie-s/',
		'/internet_shop/odezhda/tovary-dlya-safari/sa-beretta/'=>'/internet_shop/odezhda/tovary-dlya-safari/sa-beretta/',
		'/internet_shop/odezhda/tovary-dlya-safari/sa-blaser/'=>'/internet_shop/odezhda/tovary-dlya-safari/sa-blaser/',
		'/internet_shop/odezhda/tovary-dlya-safari/sa-james-purdey/'=>'/internet_shop/odezhda/tovary-dlya-safari/sa-james-purdey/',
		'/internet_shop/odezhda/tovary-dlya-safari/sa-jumfil/'=>'/internet_shop/odezhda/tovary-dlya-safari/sa-jumfil/', 
		'/internet_shop/optika/aksessuary-dlya-optiki/'=>'/internet_shop/optika/aksessuary-dlya-optiki/',
		'/internet_shop/optika/aksessuary-dlya-optiki/adaptery-i-perekhodniki/'=>'/internet_shop/optika/aksessuary-dlya-optiki/adaptery-i-perekhodniki/',
		'/internet_shop/optika/aksessuary-dlya-optiki/kryshki-na-optiku/'=>'/internet_shop/optika/aksessuary-dlya-optiki/kryshki-na-optiku/',
		'/internet_shop/optika/aksessuary-dlya-optiki/okulyary/'=>'/internet_shop/optika/aksessuary-dlya-optiki/okulyary/',
		'/internet_shop/optika/aksessuary-dlya-optiki/prochie-aksessuary/'=>'/internet_shop/optika/aksessuary-dlya-optiki/prochie-aksessuary/',
		'/internet_shop/optika/kamery/'=>'/internet_shop/optika/kamery/',
		'/internet_shop/optika/optika-po-luchshim-tsenam/'=>'/internet_shop/optika/optika-po-luchshim-tsenam/',
		'/internet_shop/oruzheynye-aksessuary/'=>'/internet_shop/oruzheynye-aksessuary/',
		'/internet_shop/oruzheynye-aksessuary/antabki/'=>'/internet_shop/oruzheynye-aksessuary/antabki/',
		'/internet_shop/oruzheynye-aksessuary/drugoe/'=>'/internet_shop/oruzheynye-aksessuary/drugoe/',
		'/internet_shop/oruzheynye-aksessuary/falshpatrony/'=>'/internet_shop/oruzheynye-aksessuary/falshpatrony/',
		'/internet_shop/oruzheynye-aksessuary/kik-stopy/'=>'/internet_shop/oruzheynye-aksessuary/kik-stopy/',
		'/internet_shop/oruzheynye-aksessuary/krepleniya/'=>'/internet_shop/oruzheynye-aksessuary/krepleniya/',
		'/internet_shop/optika/aimpoint-opt/'=>'/internet_shop/optika/aimpoint-opt/', 
		'/internet_shop/optika/bsa-opt/'=>'/internet_shop/optika/bsa-opt/',
		'/internet_shop/optika/burris-opt/'=>'/internet_shop/optika/burris-opt/',
		'/internet_shop/optika/bushnell-opt/'=>'/internet_shop/optika/bushnell-opt/',
		'/internet_shop/optika/dedal-opt/'=>'/internet_shop/optika/dedal-opt/',
		'/internet_shop/optika/leica-opt/'=>'/internet_shop/optika/leica-opt/',
		'/internet_shop/optika/nightforce-opt/'=>'/internet_shop/optika/nightforce-opt/',
		'/internet_shop/optika/steiner-opt/'=>'/internet_shop/optika/steiner-opt/',
		'/internet_shop/optika/stoeger-opt/'=>'/internet_shop/optika/stoeger-opt/',
		'/internet_shop/optika/swarovski-opt/'=>'/internet_shop/optika/swarovski-opt/',
		'/internet_shop/optika/tasco-opt/'=>'/internet_shop/optika/tasco-opt/',
		'/internet_shop/optika/zeiss-opt/'=>'/internet_shop/optika/zeiss-opt/',
		'/internet_shop/aksessuary/baron-aks/'=>'/internet_shop/aksessuary/baron-aks/',
		'/internet_shop/aksessuary/benelli-aks/'=>'/internet_shop/aksessuary/benelli-aks/',
		'/internet_shop/aksessuary/beretta-akse/'=>'/internet_shop/aksessuary/beretta-akse/',
		'/internet_shop/aksessuary/blaser-akse/'=>'/internet_shop/aksessuary/blaser-akse/',
		'/internet_shop/aksessuary/browning-akse/'=>'/internet_shop/aksessuary/browning-akse/',
		'/internet_shop/aksessuary/swarovski-akse/'=>'/internet_shop/aksessuary/swarovski-akse/',
		'/internet_shop/aksessuary/vektor-akse/'=>'/internet_shop/aksessuary/vektor-akse/',
		'/internet_shop/aksessuary/allen-akse/'=>'/internet_shop/aksessuary/allen-akse/',
		'/internet_shop/aksessuary/niggeloh-akse/'=>'/internet_shop/aksessuary/niggeloh-akse/',
		'/internet_shop/aksessuary/mauesr-akse/'=>'/internet_shop/aksessuary/mauesr-akse/',
		'/internet_shop/aksessuary/sauer-akse/'=>'/internet_shop/aksessuary/sauer-akse/',
		'/internet_shop/aksessuary/emmebi-akse/'=>'/internet_shop/aksessuary/emmebi-akse/',
		'/internet_shop/aksessuary/glock-akse/'=>'/internet_shop/aksessuary/glock-akse/',
		'/internet_shop/seyfy/browning-seyf/'=>'/internet_shop/seyfy/browning-seyf/',
		'/internet_shop/seyfy/metalk-seyf/'=>'/internet_shop/seyfy/metalk-seyf/',
		'/internet_shop/seyfy/usilennyy/'=>'/internet_shop/seyfy/usilennyy/',
		'/internet_shop/sale/alexandre-mareuil-sal/'=>'/internet_shop/sale/alexandre-mareuil-sal/',
		'/internet_shop/sale/beretta-sal/'=>'/internet_shop/sale/beretta-sal/',
		'/internet_shop/sale/blaser-sal/'=>'/internet_shop/sale/blaser-sal/',
		'/internet_shop/sale/boker-sal/'=>'/internet_shop/sale/boker-sal/',
		'/internet_shop/sale/choice-alpaca-products-sal/'=>'/internet_shop/sale/choice-alpaca-products-sal/',
		'/internet_shop/sale/exo-2-sal/'=>'/internet_shop/sale/exo-2-sal/',
		'/internet_shop/sale/graff-sal/'=>'/internet_shop/sale/graff-sal/',
		'/internet_shop/sale/hansen-jacob-sal/'=>'/internet_shop/sale/hansen-jacob-sal/',
		'/internet_shop/sale/henschel-sal/'=>'/internet_shop/sale/henschel-sal/',
		'/internet_shop/sale/hubertus-sal/'=>'/internet_shop/sale/hubertus-sal/',
		'/internet_shop/sale/jagdhund-sal/'=>'/internet_shop/sale/jagdhund-sal/',
		'/internet_shop/sale/jumfil-sal/'=>'/internet_shop/sale/jumfil-sal/',
		'/internet_shop/sale/laksen-sal/'=>'/internet_shop/sale/laksen-sal/',
		'/internet_shop/sale/leder-weiss-sal/'=>'/internet_shop/sale/leder-weiss-sal/',
		'/internet_shop/sale/leguano-sal/'=>'/internet_shop/sale/leguano-sal/',
		'/internet_shop/sale/lundhags-sal/'=>'/internet_shop/sale/lundhags-sal/',
		'/internet_shop/sale/monte-sport-sal/'=>'/internet_shop/sale/monte-sport-sal/',
		'/internet_shop/sale/pure-styles-sal/'=>'/internet_shop/sale/pure-styles-sal/',
		'/internet_shop/sale/rascher-sal/'=>'/internet_shop/sale/rascher-sal/',
		'/internet_shop/sale/riserva-sal/'=>'/internet_shop/sale/riserva-sal/',
		'/internet_shop/sale/russell-outdoors-sal/'=>'/internet_shop/sale/russell-outdoors-sal/',
		'/internet_shop/sale/she-sal/'=>'/internet_shop/sale/she-sal/',
		'/internet_shop/sale/sealskinz-sal/'=>'/internet_shop/sale/sealskinz-sal/',
		'/internet_shop/sale/sportchief-sal/'=>'/internet_shop/sale/sportchief-sal/',
		'/internet_shop/sale/swedteam-sal/'=>'/internet_shop/sale/swedteam-sal/',
		'/internet_shop/sale/termoswed-sal/'=>'/internet_shop/sale/termoswed-sal/',
		'/internet_shop/sale/unisport-sal/'=>'/internet_shop/sale/unisport-sal/',
		'/internet_shop/sale/x-jagd-sal/'=>'/internet_shop/sale/x-jagd-sal/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/cz-spr/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/cz-spr/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/glock-spr/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/glock-spr/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/smith-wesson-spr/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/smith-wesson-spr/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-40/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-40/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-44/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-44/',
		'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-45/'=>'/internet_shop/oruzhie/sportivnoe-oruzhie/kalibr-45/',
		'/internet_shop/patrony/pulki-i-shariki/kalibr-4-5/'=>'/internet_shop/patrony/pulki-i-shariki/kalibr-4-5/',
		'/internet_shop/patrony/pulki-i-shariki/kalibr-5-5/'=>'/internet_shop/patrony/pulki-i-shariki/kalibr-5-5/',
		'/internet_shop/patrony/pulki-i-shariki/metallicheskiy/'=>'/internet_shop/patrony/pulki-i-shariki/metallicheskiy/',
		'/internet_shop/patrony/pulki-i-shariki/gamo-pulk/'=>'/internet_shop/patrony/pulki-i-shariki/gamo-pulk/',
		'/internet_shop/patrony/pulki-i-shariki/bsa-pulk/'=>'/internet_shop/patrony/pulki-i-shariki/bsa-pulk/',
		'/internet_shop/optika/binokli/blaser-bin/'=>'/internet_shop/optika/binokli/blaser-bin/',
		'/internet_shop/optika/binokli/burris-bin/'=>'/internet_shop/optika/binokli/burris-bin/',
		'/internet_shop/optika/binokli/bushnell-bin/'=>'/internet_shop/optika/binokli/bushnell-bin/',
		'/internet_shop/optika/binokli/leica-bin/'=>'/internet_shop/optika/binokli/leica-bin/',
		'/internet_shop/optika/binokli/steiner-bin/'=>'/internet_shop/optika/binokli/steiner-bin/',
		'/internet_shop/optika/binokli/swarovski-bin/'=>'/internet_shop/optika/binokli/swarovski-bin/',
		'/internet_shop/optika/binokli/zeiss-bin/'=>'/internet_shop/optika/binokli/zeiss-bin/',
		'/internet_shop/optika/binokli/8-30/'=>'/internet_shop/optika/binokli/8-30/',
		'/internet_shop/optika/binokli/10-30/'=>'/internet_shop/optika/binokli/10-30/',
		'/internet_shop/optika/binokli/8-40/'=>'/internet_shop/optika/binokli/8-40/',
		'/internet_shop/optika/binokli/8-32/'=>'/internet_shop/optika/binokli/8-32/',
		'/internet_shop/optika/binokli/8-42/'=>'/internet_shop/optika/binokli/8-42/',
		'/internet_shop/optika/dalnomery/bushnell-dal/'=>'/internet_shop/optika/dalnomery/bushnell-dal/',
		'/internet_shop/optika/dalnomery/dedal-dal/'=>'/internet_shop/optika/dalnomery/dedal-dal/',
		'/internet_shop/optika/dalnomery/leica-dal/'=>'/internet_shop/optika/dalnomery/leica-dal/',
		'/internet_shop/optika/dalnomery/swarovski-dal/'=>'/internet_shop/optika/dalnomery/swarovski-dal/',
		'/internet_shop/optika/dalnomery/zeiss-dal/'=>'/internet_shop/optika/dalnomery/zeiss-dal/',
		'/internet_shop/optika/aksessuary-dlya-optiki/aimpoint-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/aimpoint-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/bushnell-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/bushnell-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/dedal-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/dedal-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/eaw-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/eaw-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/nightforce-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/nightforce-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/swarovski-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/swarovski-aop/',
		'/internet_shop/optika/aksessuary-dlya-optiki/zeiss-aop/'=>'/internet_shop/optika/aksessuary-dlya-optiki/zeiss-aop/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/benelli-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/benelli-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/beretta-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/beretta-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/blaser-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/blaser-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/browning-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/browning-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/butler-creek-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/butler-creek-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/fabarm-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/fabarm-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/franchi-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/franchi-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/jakele-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/jakele-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/sauer-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/sauer-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/stoeger-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/stoeger-z/',
		'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/zoli-z/'=>'/internet_shop/oruzheynye-aksessuary/zatylniki-grebni/zoli-z/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/armsan-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/armsan-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/benelli-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/benelli-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/blaser-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/blaser-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/browning-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/browning-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/cz-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/cz-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/colt-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/colt-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/fabarm-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/fabarm-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/franchi-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/franchi-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/gletcher-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/gletcher-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/glock-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/glock-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/mannlicher-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/mannlicher-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/merkel-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/merkel-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/remington-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/remington-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/sako-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/sako-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/sauer-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/sauer-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/tikka-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/tikka-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/walther-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/walther-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/sayga-mag/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/sayga-mag/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/vintovka/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/vintovka/',
		'/internet_shop/oruzheynye-aksessuary/magaziny/pistolet/'=>'/internet_shop/oruzheynye-aksessuary/magaziny/pistolet/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/armsan-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/armsan-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/benelli-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/benelli-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/beretta-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/beretta-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/blaser-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/blaser-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/browning-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/browning-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/cz-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/cz-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/cosmi-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/cosmi-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/fabarm-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/fabarm-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/franchi-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/franchi-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/merkel-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/merkel-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/remington-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/remington-nas/',
		'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/zoli-nas/'=>'/internet_shop/oruzheynye-aksessuary/nasadki-i-choki/zoli-nas/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/anschutz-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/anschutz-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/armsan-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/armsan-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/benelli-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/benelli-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/beretta-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/beretta-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/blaser-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/blaser-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/browning-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/browning-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/cz-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/cz-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/diana-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/diana-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/fab-defense-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/fab-defense-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/fabarm-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/fabarm-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/franchi-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/franchi-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/gamo-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/gamo-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/krieghoff-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/krieghoff-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/remington-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/remington-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/sauer-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/sauer-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/stoeger-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/stoeger-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/winchester-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/winchester-pk/',
		'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/zoli-pk/'=>'/internet_shop/oruzheynye-aksessuary/priklady-i-tsevya/zoli-pk/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/allen-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/allen-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/beretta-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/beretta-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/blaser-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/blaser-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/emmebi-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/emmebi-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/neverlost-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/neverlost-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/niggeloh-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/niggeloh-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/sauer-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/sauer-rem/',
		'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/vektor-rem/'=>'/internet_shop/oruzheynye-aksessuary/remni-dlya-ruzhey/vektor-rem/',
		'/internet_shop/aksessuary/ryukzaki/alexandre-ry/'=>'/internet_shop/aksessuary/ryukzaki/alexandre-ry/',
		'/internet_shop/aksessuary/ryukzaki/allen-ry/'=>'/internet_shop/aksessuary/ryukzaki/allen-ry/',
		'/internet_shop/aksessuary/ryukzaki/baron-ry/'=>'/internet_shop/aksessuary/ryukzaki/baron-ry/',
		'/internet_shop/aksessuary/ryukzaki/beretta-ry/'=>'/internet_shop/aksessuary/ryukzaki/beretta-ry/',
		'/internet_shop/aksessuary/ryukzaki/blaser-ry/'=>'/internet_shop/aksessuary/ryukzaki/blaser-ry/',
		'/internet_shop/aksessuary/ryukzaki/neverlost-ry/'=>'/internet_shop/aksessuary/ryukzaki/neverlost-ry/',
		'/internet_shop/aksessuary/ryukzaki/sportchief-ry/'=>'/internet_shop/aksessuary/ryukzaki/sportchief-ry/',
		'/internet_shop/aksessuary/ryukzaki/swedteam-ry/'=>'/internet_shop/aksessuary/ryukzaki/swedteam-ry/',
		'/internet_shop/aksessuary/ryukzaki/unisport-ry/'=>'/internet_shop/aksessuary/ryukzaki/unisport-ry/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/allen-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/allen-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/baron-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/baron-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/beretta-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/beretta-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/jakele-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/jakele-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/niggeloh-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/niggeloh-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/swarovski-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/swarovski-och/',
		'/internet_shop/aksessuary/chekhly-dlya-optiki/zeiss-och/'=>'/internet_shop/aksessuary/chekhly-dlya-optiki/zeiss-och/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/alexandre-mareuil-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/alexandre-mareuil-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/allen-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/allen-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/baron-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/baron-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/benelli-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/benelli-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/beretta-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/beretta-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/blaser-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/blaser-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/browning-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/browning-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/diana-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/diana-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/emmebi-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/emmebi-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/gamo-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/gamo-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/mauser-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/mauser-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/niggeloh-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/niggeloh-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/unisport-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/unisport-chor/',
		'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/vektor-chor/'=>'/internet_shop/aksessuary/chekhly-dlya-oruzhiya/vektor-chor/',
		'/internet_shop/aksessuary/kobury/front-line-kob/'=>'/internet_shop/aksessuary/kobury/front-line-kob/',
		'/internet_shop/aksessuary/kobury/glock-kob/'=>'/internet_shop/aksessuary/kobury/glock-kob/',
		'/internet_shop/aksessuary/kobury/jakele-kob/'=>'/internet_shop/aksessuary/kobury/jakele-kob/',
		'/internet_shop/aksessuary/kobury/walther-kob/'=>'/internet_shop/aksessuary/kobury/walther-kob/',
		'/internet_shop/aksessuary/kobury/vektor-kob/'=>'/internet_shop/aksessuary/kobury/vektor-kob/',
		'/internet_shop/aksessuary/keysy/armsan-key/'=>'/internet_shop/aksessuary/keysy/armsan-key/',
		'/internet_shop/aksessuary/keysy/baron-key/'=>'/internet_shop/aksessuary/keysy/baron-key/',
		'/internet_shop/aksessuary/keysy/beretta-key/'=>'/internet_shop/aksessuary/keysy/beretta-key/',
		'/internet_shop/aksessuary/keysy/blaser-key/'=>'/internet_shop/aksessuary/keysy/blaser-key/',
		'/internet_shop/aksessuary/keysy/eisele-key/'=>'/internet_shop/aksessuary/keysy/eisele-key/',
		'/internet_shop/aksessuary/keysy/sauer-key/'=>'/internet_shop/aksessuary/keysy/sauer-key/',
		'/internet_shop/aksessuary/keysy/walther-key/'=>'/internet_shop/aksessuary/keysy/walther-key/',
		'/internet_shop/aksessuary/keysy/plastikovyj/'=>'/internet_shop/aksessuary/keysy/plastikovyj/',
		'/internet_shop/aksessuary/keysy/metallicheskij/'=>'/internet_shop/aksessuary/keysy/metallicheskij/',
		'/internet_shop/aksessuary/patrontashi/alexandre-mareuil-pa/'=>'/internet_shop/aksessuary/patrontashi/alexandre-mareuil-pa/',
		'/internet_shop/aksessuary/patrontashi/allen-pa/'=>'/internet_shop/aksessuary/patrontashi/allen-pa/',
		'/internet_shop/aksessuary/patrontashi/beretta-pa/'=>'/internet_shop/aksessuary/patrontashi/beretta-pa/',
		'/internet_shop/aksessuary/patrontashi/vektor-pa/'=>'/internet_shop/aksessuary/patrontashi/vektor-pa/',
		'/internet_shop/aksessuary/patrontashi/kozhannyj/'=>'/internet_shop/aksessuary/patrontashi/kozhannyj/',
		'/internet_shop/aksessuary/patrontashi/brezentovyj/'=>'/internet_shop/aksessuary/patrontashi/brezentovyj/',
		'/internet_shop/suveniry/tovary-dlya-doma/beretta-dom/'=>'/internet_shop/suveniry/tovary-dlya-doma/beretta-dom/',
		'/internet_shop/suveniry/tovary-dlya-doma/james-purdey-dom/'=>'/internet_shop/suveniry/tovary-dlya-doma/james-purdey-dom/',
		'/internet_shop/suveniry/tovary-dlya-doma/romeo-miracoli-dom/'=>'/internet_shop/suveniry/tovary-dlya-doma/romeo-miracoli-dom/',
		'/internet_shop/suveniry/tovary-dlya-doma/wutschka-dom/'=>'/internet_shop/suveniry/tovary-dlya-doma/wutschka-dom/',
		'/internet_shop/seyfy/drugie-seyfy/metalk-sef/'=>'/internet_shop/seyfy/drugie-seyfy/metalk-sef/',
		'/internet_shop/seyfy/drugie-seyfy/sft-sef/'=>'/internet_shop/seyfy/drugie-seyfy/sft-sef/',
		

    );  
	if (array_key_exists($pageForNewDescr, $arSearchNewDescr)) {
	    $APPLICATION->SetPageProperty("description", ($sectionNamesPage?$sectionNamesPage:$sectionNames).': продажа в каталоге оружейного магазина Kolchuga.ru по цене от '.$price['RESULT_PRICE']['DISCOUNT_PRICE'].' руб. '.($sectionNamesPage?$sectionNamesPage:$sectionNames).' - в наличии '.$resCount.' товаров. Кольчуга - самый крупный продавец гражданского оружия на российском рынке.');
	}*/
	/*filter country*/
	/*$arSearchNewDescrCountry = array(
		'/internet_shop/optika/japan-opt/'=>'/internet_shop/optika/japan-opt/',
		'/internet_shop/optika/germany-opt/'=>'/internet_shop/optika/germany-opt/',
		'/internet_shop/optika/sweden-opt/'=>'/internet_shop/optika/sweden-opt/',
		'/internet_shop/optika/russia-opt/'=>'/internet_shop/optika/russia-opt/',
		'/internet_shop/optika/austria-opt/'=>'/internet_shop/optika/austria-opt/',
		'/internet_shop/optika/usa-opt/'=>'/internet_shop/optika/usa-opt/',
		'/internet_shop/optika/england-opt/'=>'/internet_shop/optika/england-opt/',
		'/internet_shop/sale/italy-sal/'=>'/internet_shop/sale/italy-sal/',
		'/internet_shop/sale/denmark-sal/'=>'/internet_shop/sale/denmark-sal/',
		'/internet_shop/sale/sweden-sal/'=>'/internet_shop/sale/sweden-sal/',
		'/internet_shop/sale/germany-sal/'=>'/internet_shop/sale/germany-sal/',
		'/internet_shop/optika/binokli/germany-bin/'=>'/internet_shop/optika/binokli/germany-bin/',
		'/internet_shop/optika/binokli/england-bin/'=>'/internet_shop/optika/binokli/england-bin/',
		'/internet_shop/optika/binokli/usa-bin/'=>'/internet_shop/optika/binokli/usa-bin/',
		'/internet_shop/optika/binokli/austria-bin/'=>'/internet_shop/optika/binokli/austria-bin/',
		'/internet_shop/optika/dalnomery/germany-dal/'=>'/internet_shop/optika/dalnomery/germany-dal/',
		'/internet_shop/optika/dalnomery/austria-dal/'=>'/internet_shop/optika/dalnomery/austria-dal/',
		'/internet_shop/optika/dalnomery/russia-dal/'=>'/internet_shop/optika/dalnomery/russia-dal/',
		'/internet_shop/optika/dalnomery/usa-dal/'=>'/internet_shop/optika/dalnomery/usa-dal/',

    );
    if (array_key_exists($pageForNewDescr, $arSearchNewDescrCountry)) {
	    $APPLICATION->SetPageProperty("description", ($sectionNamesPageCountry?$sectionNamesPageCountry:$sectionNamesPage).': продажа в каталоге оружейного магазина Kolchuga.ru по цене от '.$price['RESULT_PRICE']['DISCOUNT_PRICE'].' руб. '.($sectionNamesPage?$sectionNamesPage:$sectionNames).' - в наличии '.$resCount.' товаров. Кольчуга - самый крупный продавец гражданского оружия на российском рынке.');
	}  	*/
	$pagetext='.';
	if (is_array($GLOBALS[$exGSectVarNameProp]) && !empty($GLOBALS[$exGSectVarNameProp])){
		$pagetext=GetMessage("CT_SET_META_SECTION_PAGE", array("#NUM#" => $GLOBALS[$exGSectVarNameProp]["PAGE"]));
	}
	//\Kolchuga\Settings::xmp($arFilterOdBolId,11460, __FILE__.": ".__LINE__);
	//\Kolchuga\Settings::xmp($arElementTegName['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'],11460, __FILE__.": ".__LINE__);
	//\Kolchuga\Settings::xmp($arResult,11460, __FILE__.": ".__LINE__);
	//\Kolchuga\Settings::xmp($arCurSection,11460, __FILE__.": ".__LINE__);
	
	if(in_array($arFilterOdBolId,[17907, 17909]) && !empty($arElementTegName['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'])){
		$APPLICATION->SetPageProperty("description", ($arElementTegName['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']).$pagetext);
	}else{
		if(
			in_array($arFilterOdBolId,[17885]) 
			|| in_array(17977,$arCurSection['NAVCHAIN'])
			|| in_array(17879,$arCurSection['NAVCHAIN'])
			|| in_array(17989,$arCurSection['NAVCHAIN'])
			|| in_array(17894,$arCurSection['NAVCHAIN'])
			|| in_array(18357,$arCurSection['NAVCHAIN'])
			|| in_array(17858,$arCurSection['NAVCHAIN'])
			|| in_array(17863,$arCurSection['NAVCHAIN'])
			|| in_array(17828,$arCurSection['NAVCHAIN'])
			|| in_array(17835,$arCurSection['NAVCHAIN'])
			|| in_array(17827,$arCurSection['NAVCHAIN'])
		){
			//tot chto v adminke
		}else{
		$APPLICATION->SetPageProperty("description", ($sectionNamesPage?$sectionNamesPage:$sectionNames).'. Продажа товаров для охоты и активного отдыха в оружейных салонах Кольчуга'.$pagetext);
		}
	}
?>