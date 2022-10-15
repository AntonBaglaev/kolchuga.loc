<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");


CModule::IncludeModule('iblock');

$ibIdVariants = 49;
$cache = new CPHPCache();
$cacheTime = 86400;
$cacheId = 'arVariantsList';
$cachePath = '/'.$cacheId.'/';
if ($cache->InitCache($cacheTime, $cacheId, $cachePath)){
    $VARIANTS = $cache->GetVars();
}elseif($cache->StartDataCache()){
    $VARIANTS = array();
    $arFilter = array('IBLOCK_ID' => $ibIdVariants, 'ACTIVE' => 'Y');
    $arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_VARIANTS');
    $resSect = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    while ($arVariant = $resSect->GetNext()){
    	if($arVariant['PROPERTY_VARIANTS_VALUE']){
        	$VARIANTS[strtolower($arVariant['PROPERTY_VARIANTS_VALUE'])] = strtolower($arVariant['NAME']);
    	}
    }
    $cache->EndDataCache($VARIANTS);
}

$ibID = 40;
$search = strtolower(trim($_GET['q']));

//проверяем совпадение запроса клиента и пресеты брендов. Если есть совпадение, то берем название бренда в качестве слова для поиска
if (array_key_exists($search, $VARIANTS)) {
	$search = $VARIANTS[$search];
	$_GET['q'] = $search;
	$_REQUEST['q'] = $search;
}


$GLOBALS['shopFilter'] = array(
	'>CATALOG_PRICE_2' => 0,
	'=PROPERTY_IS_SKU_VALUE' => 'Нет',
	'NAME' => '%'.$search.'%',
	array(
		'LOGIC' => 'OR',
		'>CATALOG_QUANTITY' => 0,
		'>PROPERTY_SKU_QUANTITY' => 0
	)
);

//вводим новый фильтр
function getidtovars($search){
	$arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_IS_SKU", "PROPERTY_IDGLAVNOGO");
	$arOrder = array('NAME'=>'ASC');
	$arFilter = array("IBLOCK_ID"=>$ibID, "ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y", "CATALOG_AVAILABLE" => "Y", '>CATALOG_PRICE_2' => 0);
	$line=explode(' ',$search);
	$line0 = array_pop($line);
	$arFilter['NAME'] = '%'.$search.'%';
	$arResult = array();
	//$res = \CIBlockElement::GetList($arOrder, $arFilter, false, array("nPageSize"=>60), $arSelect);
	$res = \CIBlockElement::GetList($arOrder, $arFilter, false, array("nPageSize"=>240), $arSelect);
	while($element = $res->GetNext()){

		$itemId = $element['ID'];
		//если товар псевдо sku, то берем главный товар
		if($element['PROPERTY_IS_SKU_VALUE'] == 'Да' && $element['PROPERTY_IDGLAVNOGO_VALUE']){
			$objMainItem = \CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$ibID, 'XML_ID'=>$element['PROPERTY_IDGLAVNOGO_VALUE']), false, array("nPageSize"=>30), $arSelect);
			if($mainItem = $objMainItem->GetNext()){
				$itemId = $mainItem['ID'];
				$element = $mainItem;
			}
		}
		$arResult[]=$itemId;
	}
	return $arResult;
}

$arResult=getidtovars($search);


if(empty($arResult)){
	$line=explode(' ',$search);
	if(count($line)>3){
		$line0 = array_pop($line);
		$search=implode(' ',$line);
		$arResult=getidtovars($search);
	}
}

if(!empty($arResult)){
	
	$GLOBALS['shopFilter'] = array(
		'>CATALOG_PRICE_2' => 0,	
		'ID' => array_unique($arResult),
		
	);
}
//конец


?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search",
	"",
	array(
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "40",
		"ELEMENT_SORT_FIELD" => "name",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "PROPERTY_NOVINKA",
		"ELEMENT_SORT_ORDER2" => "desc",
		"PAGE_ELEMENT_COUNT" => "24",
		"LINE_ELEMENT_COUNT" => 3,
		"PROPERTY_CODE" => array(
			0 => "SALE",
			1 => "BESTPRICE",
			2 => "NOVINKA",
			3 => "OLD_PRICE",
			4 => "",
		),
		"BASKET_URL" => "/internet_shop/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		'DISPLAY_COMPARE' => "N",
		"PRICE_CODE" => array(
			0 => "Розничная",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N",
		"CONVERT_CURRENCY" => "N",
		'HIDE_NOT_AVAILABLE' => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"FILTER_NAME" => "searchFilter",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(),
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"META_KEYWORDS" => "",
		"META_DESCRIPTION" => "",
		"BROWSER_TITLE" => "",
		"ADD_SECTIONS_CHAIN" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",

		"RESTART" => "N",
		"NO_WORD_LOGIC" => "Y",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "Y",

		'TEMPLATE_THEME' => '',
		'ADD_TO_BASKET_ACTION' => "",
	),
	false,
	array("HIDE_ICONS" => "Y")
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>