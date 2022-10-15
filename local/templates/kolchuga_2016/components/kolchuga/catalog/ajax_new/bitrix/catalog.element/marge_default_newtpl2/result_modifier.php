<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 18:06
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
$arResult["CANONICAL_URL"] = $arResult["DETAIL_PAGE_URL"];
 
 $stoka=explode('?',$arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE']);
  if($stoka[0] !== $arResult['DETAIL_PAGE_URL']){
	  $APPLICATION->SetPageProperty('title', "Страница не найдена");
	   \Bitrix\Iblock\Component\Tools::process404(
		   false, //Сообщение
		   true, // Нужно ли определять 404-ю константу
		   true, // Устанавливать ли статус
		   true, // Показывать ли 404-ю страницу
		   false // Ссылка на отличную от стандартной 404-ю
		); 
	}

if ($arResult['PROPERTIES']['IDKOMPLEKTA']['VALUE']) {
    $rs = \CIBlockElement::GetList (
        Array(),
        Array("IBLOCK_ID" => $arParam['IBLOCK_ID'], "XML_ID" => $arResult['PROPERTIES']['IDKOMPLEKTA']['VALUE']),
        false,
        Array (),
        Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE")
    );
    while($ar_fields = $rs->GetNext()) {
        $arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_NAME'] = $ar_fields["NAME"];
        $arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_URL'] = $ar_fields["DETAIL_PAGE_URL"];
        $arResult['PROPERTIES']['IDKOMPLEKTA']['DISPLAY_DETAIL_PICTURE'] = $ar_fields["DETAIL_PICTURE"];

        $arResult['KOMPLEKT']['DISPLAY_NAME'] = $ar_fields["NAME"];
        $arResult['KOMPLEKT']['DISPLAY_URL'] = $ar_fields["DETAIL_PAGE_URL"];
        $arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE'] = $ar_fields["DETAIL_PICTURE"];
    }
}

if(!empty($arResult['PROPERTIES']['IDGLAVNOGO']['VALUE'])){
	$tempaA = \Kolchuga\DopViborka::getItemSku(
		array(
			'IBLOCK_ID'=>40,
			'TYPE_PRICE'=>'Розничная',
			'FILTER'=>['PROPERTY_IDGLAVNOGO'=>$arResult['PROPERTIES']['IDGLAVNOGO']['VALUE']],
			'SELECT'=>['ID','NAME','PROPERTY_RAZMER','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','PROPERTY_TSVET', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE','PROPERTY_IDGLAVNOGO']
		),
		array(),
		array(),
		'Y'
	);
	
	$arResult['SKU']=$tempaA['DOPOLNITELNO']['ITEM'];
	$arResult['DOPOLNITELNO']=$tempaA['DOPOLNITELNO'];
	unset($tempaA);
	 /* ?><!--pre>arResultaaaIa <?print_r($arResult['SKU']);?></pre--><?  */
}else{
	$tempaA = \Kolchuga\StoreList::itemRazmerDostupByArt(
		$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'],
		array(
			'IBLOCK_ID'=>$arResult['IBLOCK_ID'],
			'CML2_ARTICLE'=>$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'],
			'ID'=>$arResult['ID']
		)
	);
	$arResult['LIST_DOSTUPNOST_ITEM'] = $tempaA['ITEM'];
	//$arResult['LIST_DOSTUPNOST'] = $tempaA;
	unset($tempaA);
}

$arTemp=$arResult['SKU'];
if(is_array($arTemp)){ $arFtemp=reset($arTemp); }
if(is_array($arFtemp)){ $arResult['SKU_COUNT'] = count($arFtemp); }
$arResult['SKU_ARR'] = $arFtemp;
unset($arTemp);
unset($arFtemp);
if(!$arResult['CAN_BUY'] && $arResult['SKU_COUNT'] > 0){
	foreach($arResult['SKU_ARR'] as $sku){
		if($sku['CATALOG_QUANTITY'] > 0){
			$arResult['CAN_BUY'] = true;
			break;
		}
	}
}

if(!empty($arResult['SKU_ARR'])){
	$tableA=[];
	$tableAOne=[];
	foreach($arResult['SKU_ARR'] as $trA){
		foreach($trA['SET_SKLAD'] as $tdA){
			$tableA[$tdA['NAME']][$trA['RAZMER_CURRENT']]=[
				'sklad_id'=>$tdA['ID'],
				'getbysklad'=>$trA['GET_BY_SKLAD'],
				'razmer'=>$trA['RAZMER_CURRENT'],
				'on_sklad'=>(!empty($tdA['PRODUCT_ID'][$trA['ID']]) ? $tdA['PRODUCT_ID'][$trA['ID']]:0),
				'tovar'=>$trA['ID'],
				'price'=>$trA['MIN_PRICE']['PRINT_VALUE'],
				'discount'=>$trA['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
				'percent'=>$trA['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'],
				'max'=>$trA['CATALOG_QUANTITY'],
			];
			$tableAOne[$trA['RAZMER_CURRENT']]+=$tdA['PRODUCT_ID'][$trA['ID']];
		}
	}
	$arResult['TABLE_RAZMER_ARR']['SKU']=$tableA;
	$arResult['TABLE_RAZMER_ARR']['ONE']=$tableAOne;
	foreach($tableAOne as $vl){
		if($vl=='1'){$arResult['TABLE_RAZMER_ARR']['SET_ONE']='Y';} 
	}
	unset($tableA);
	unset($tableAOne);	
}

$arResult['SETKA']=[];
$arResult["PROP_SIZES_VALUE"] = (( isset($arResult['PROPERTIES']['RAZMER']['VALUE']) && !empty($arResult['PROPERTIES']['RAZMER']['VALUE'])) ? $arResult['PROPERTIES']['RAZMER']['VALUE'] : "");	
if(!empty($arResult["PROP_SIZES_VALUE"])) {	
	$a=Array("IBLOCK_ID" => 67, "NAME" => $arResult['PROPERTIES']['BREND']['VALUE'], 'ACTIVE'=>'Y');
	$b=Array("ID", "IBLOCK_ID", "NAME", "DETAIL_TEXT", 'PROPERTY_FILTER_PROP', 'PROPERTY_FILTER_SECTION');
	$arResult['SETKA']=\Kolchuga\DopViborka::getTablesSize($a, $b, $arResult); //Таблица размеров
		
	foreach($arResult['PROPERTIES']['RAZMER']['VALUE'] as $v){
	    $size = $v;
	    $l = -strlen($size);
	    if (substr($arResult['NAME'], $l) == $size){
	        $arResult['NAME'] = trim(substr($arResult['NAME'], 0, $l));
			$arResult['RAZMER_IS']=$size;
	        break;
	    }
	}
}	
	
//вывод ссылки на форму уточнения размера
$arResult['CHECK_PAGE_SIZES'] = false;
$arPageSizes = array(
    '/internet_shop/odezhda/',
    '/internet_shop/obuv/'
);
$curUri = $APPLICATION->GetCurPage(false);
foreach ($arPageSizes as $uri) {
    if(strpos($curUri, $uri) !== false){
        $arResult['CHECK_PAGE_SIZES'] = true;
        break;
    }
}

$arResult['ARDISCOUNTS'] = \CCatalogDiscount::GetDiscountByProduct($arResult['ID'], $USER->GetUserGroupArray(), "N", 2, SITE_ID );
	
if(!empty($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['VALUE'])){
	$arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']= \Kolchuga\DopViborka::getPageHl(array('XML_ID'=>$arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['VALUE']));
}

if (!$arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['IBLOCK_13']['SRC'])
    $arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['IBLOCK_13']['SRC'] =
        CFile::ResizeImageGet($arResult['PROPERTIES']['BREND_STRANITSA_BRENDA']['MASSA']['UF_FILE'],
            array('width'=>200, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

$arResult['OLD_PRICE'] = 0;
if($arResult['SKU'] && $arResult['SKU_COUNT'] > 0){
	$mpriceId=$arResult['SKU_ARR'][0]['PRICE_MIN_ID'];
	foreach($arResult['SKU_ARR'] as $code => $item){
		if($item['ID']==$mpriceId){
			$arResult['MIN_PRICE'] = $item['MIN_PRICE'];
			if($item['PRICE_MIN']!=$item['PRICE_MAX']){$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE_OT']='от '.$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];}
		}
	}		
}
if($arResult['MIN_PRICE']['VALUE'] > 0 && $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE']){
	$arResult['OLD_PRICE'] = $arResult['MIN_PRICE']['PRINT_VALUE'];
}elseif (isset($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"])){
	$arResult['OLD_PRICE'] = $arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"];
}
if(!empty($arResult['OLD_PRICE'])){
	$pos = strpos($arResult['OLD_PRICE'], 'руб');
	if ($pos === false) {
		$arResult['OLD_PRICE'].=' руб';
	}
}
	/* ?><!--pre>arResultaaaI <?print_r($arResult['SKU']);?></pre--><? */
	
$cp = $this->__component; // объект компонента
if (is_object($cp)){
	$cp->arResult['TITLE'] = $arResult['NAME'];
    $cp->arResult['~NAME'] = $arResult['~NAME'];
    $cp->arResult['RAZMER_IS'] = $arResult['RAZMER_IS'];
	$cp->SetResultCacheKeys(array('TIMESTAMP_X','~NAME','TITLE','RAZMER_IS',"CANONICAL_URL", "IBLOCK_SECTION_ID", "PROP_SIZES_VALUE"));
}