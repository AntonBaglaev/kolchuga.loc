<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "Адреса оружейных салонов в Москве Кольчуга");
$APPLICATION->SetPageProperty("description", "Оружейные салоны \"Кольчуга\", охотничьи магазины в Москве");
$APPLICATION->SetPageProperty("title", "Оружейные салоны Кольчуга в Москве");
$APPLICATION->SetTitle("Оружейные салоны");
?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"weapons-salons2.list", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "weapons-salons.list",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "weapons_salons",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "address",
			1 => "metro_station",
			2 => "phones",
			3 => "e_mail",
			4 => "salon",
			5 => "catalog_link",
			6 => "legal_information",
			7 => "about_director",
			8 => "address_link",
			9 => "contact_link",
			10 => "clock",
			11 => "masterskaya",
			12 => "show_in_list",
			13 => "stores",
			14 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>
<a name="product"></a>
<?
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
foreach($request as $key=>$vl){
	$requestArr[$key]=$vl;
}
?>

<?if(!empty($requestArr['salonfilter'])){?>
<? global  $salonfilters;
		 $property_enums = \CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>40, "XML_ID"=>$requestArr['salonfilter']));
			$enum_fields = $property_enums->GetNext();
		$salonfilters['INCLUDE_SUBSECTIONS']='Y';
		$salonfilters['PROPERTY_ON_SKLAD']=$enum_fields["ID"];
		?>
		
<?
$obCache = new CPHPCache;
        $life_time = 12*3600; 
        $cache_id = 'salon-'.$requestArr['salonfilter'];
		if($obCache->InitCache($life_time, $cache_id, "/salon_sidebar_menus")) {
			$razdel_0 = $obCache->GetVars();
		} else {			
			$razdel_m=[];
			$filyael=[];
			$filyael["IBLOCK_ID"]=40;
			$filyael["IBLOCK_TYPE"]='1c_catalog';
			$filyael["ACTIVE"]='Y';
			$filyael["PROPERTY_ON_SKLAD"]=$enum_fields["ID"];
			$filyael["INCLUDE_SUBSECTIONS"]='Y';
			$filyael["!PROPERTY_253"]='298882';
			$filyael[">CATALOG_PRICE_2"]='0';
			if(!empty($requestArr['salonfilter465'])){
				$filyael["PROPERTY_465"]=$requestArr['salonfilter465'];
			}
			$filyael[]=array(
				'LOGIC' => 'OR',
				'>CATALOG_QUANTITY' => 0,
				'>PROPERTY_SKU_QUANTITY' => 0
			);
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filyael, false, false, Array('ID','IBLOCK_SECTION_ID'));
			$razdel=[];
			while($obEl = $dbEl->Fetch()){
				$razdel[$obEl['IBLOCK_SECTION_ID']]['ID'][]=$obEl['ID'];
				
			}
			foreach($razdel as $SectionID=>$el){
				$navChain = \CIBlockSection::GetNavChain(40, $SectionID); 
				while ($arNav=$navChain->GetNext()){
					$razdel[$SectionID]['SECTION'][]=$arNav;
					$razdel_m[$arNav['DEPTH_LEVEL']][$arNav['ID']]=$arNav['NAME'];
				}
			}
			$razdel_0=[$razdel,$razdel_m];
			 $obCache->StartDataCache();
            $obCache->EndDataCache($razdel_0);
        }
if(!empty($requestArr['sfilter'])){
	$salonfilters['SECTION_ID']=$requestArr['sfilter'];
		$salonfilters['INCLUDE_SUBSECTIONS']='Y';
}
$setSection='';
?>

<div class="container-fluid">
		<div class="row">	
		  <div class="rowanons col-sm-3 sidebar__menu">
		  <ul>
			<?
			if(count($razdel_0[1][1])>1){
			  foreach($razdel_0[1][1] as $SectionID=>$el){
				  if(!empty($requestArr['sfilter']) && $requestArr['sfilter']==$SectionID){						
						$setSection.=$el;					  
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","PAGEN_1"))?>#product"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  $setSection0.=$el;
					?><li><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","PAGEN_1"))?>#product"><?=$setSection0?></a></li><?
				  }
			  }
		  }else{
			  foreach($razdel_0[1][2] as $SectionID=>$el){
				  if(!empty($requestArr['sfilter']) && $requestArr['sfilter']==$SectionID){						
						$setSection.=$el;					  
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","PAGEN_1"))?>#product"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  $setSection0.=$el;
					?><li><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","PAGEN_1"))?>#product"><?=$setSection0?></a></li><?
				  }
			  }
		  }
		  ?>
		  <li <?=(empty($setSection) ? 'class="active"' : '')?>><a href="<?=$APPLICATION->GetCurPageParam("", array("sfilter","PAGEN_1"))?>#product">Все товары</a></li>
		  </ul>
		  </div>
		  <div class="rowanons col-sm-9">
		  <h3>Товары доступные в салоне <?=$enum_fields["VALUE"]?></h3>
		  
		 <div class='sec_pag'>
		 <?//763119
		 $custfltr="{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:40:253\",\"DATA\":{\"logic\":\"Not\",\"value\":298882}}]}";
		 if(!empty($requestArr['salonfilter465'])){
				$custfltr="{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:40:253\",\"DATA\":{\"logic\":\"Not\",\"value\":298882}},{\"CLASS_ID\":\"CondIBProp:40:465\",\"DATA\":{\"logic\":\"Equal\",\"value\":".$requestArr['salonfilter465']."}}]}";
			}
		$sort='sort';
		$sortby='asc';
		if(!empty($requestArr['salonfilter465'])){
			$sort='catalog_PRICE_2';
			$sortby='desc';
		}
		 ?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	".default", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "N",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => $custfltr,		
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $sort,
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => $sortby,
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILE_404" => "",
		"FILTER_NAME" => "salonfilters",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "A",
		"LABEL_PROP" => "",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "24",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "Розничная",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "BREND_STRANITSA_BRENDA",
			1 => "BRAND_REF",
			2 => "ARTNUMBER",
			3 => "",
		),
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $requestArr["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $requestArr["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
</div>
</div>
</div>
</div>

	<?}?>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>