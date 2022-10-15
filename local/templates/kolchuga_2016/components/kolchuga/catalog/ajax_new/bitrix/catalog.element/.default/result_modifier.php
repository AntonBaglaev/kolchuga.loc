<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 18:06
 */
  
$arResult["CANONICAL_URL"] = $arResult["DETAIL_PAGE_URL"];

  
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
 

    foreach(array("PREVIEW_PICTURE", "DETAIL_PICTURE") as $code)
    {
      if (is_array($arResult[$code]))
      {
        foreach(array("ALT", "TITLE") as $tr)
        {
          if (isset($arResult["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr]) &&
              !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr]))
          {
             $arResult[$code][$tr] = $arResult["IPROPERTY_VALUES"]["ELEMENT_".$code."_FILE_".$tr];
          }
        }
      }
    }

$arResult["PROP_SIZES_VALUE"] = (( isset($arResult['PROPERTIES']['RAZMER']['VALUE']) &&
                                   !empty($arResult['PROPERTIES']['RAZMER']['VALUE']))? $arResult['PROPERTIES']['RAZMER']['VALUE'] : "");

if($arResult['PROPERTIES']['RAZMER']['VALUE']) {
	foreach($arResult['PROPERTIES']['RAZMER']['VALUE'] as $v){
	    $size = $v;
	    $l = -strlen($size);
	    if (substr($arResult['NAME'], $l) == $size){
	        $arResult['NAME'] = trim(substr($arResult['NAME'], 0, $l));
			$arResult['RAZMER_IS']=$size;
	        break;
	    }
	}
	/* ?><!--pre><?print_r($arResult['NAME']);?></pre--><?	
	?><!--pre><?print_r($arResult['~NAME']);?></pre--><? */	
    $cp = $this->__component; // объект компонента
    if (is_object($cp)) {
        // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
        $cp->arResult['TITLE'] = $arResult['NAME'];
        $cp->arResult['~NAME'] = $arResult['~NAME'];
        $cp->arResult['RAZMER_IS'] = $arResult['RAZMER_IS'];
        $cp->SetResultCacheKeys(array('TITLE','~NAME','RAZMER_IS'));
    }
	
}
$arResult['SETKA']=[];
	if(!empty($arResult['PROPERTIES']['RAZMER']['VALUE'])){
		$rs = \CIBlockElement::GetList (
			Array(),
			Array("IBLOCK_ID" => 67, "NAME" => $arResult['PROPERTIES']['BREND']['VALUE']),
			false,
			Array (),
			Array("ID", "IBLOCK_ID", "NAME", "DETAIL_TEXT")
		);
		while($ar_fields = $rs->GetNext()) {
			$arResult['SETKA']=$ar_fields;
		}
	}


if($arResult['PROPERTIES']['IDGLAVNOGO']['VALUE'] == $arResult['XML_ID']){

    require($_SERVER['DOCUMENT_ROOT'] . '/local/tools/getProducts.php');

    $filter = array('PROPERTY_IDGLAVNOGO' => $arResult['XML_ID'], '>CATALOG_QUANTITY' => 0);
    $arResult['SKU'] =
        getProducts(
            $arParam['IBLOCK_ID'],
            $filter,
            false,
            array('SORT' => 'ASC'),
            $arParams['PRICE_CODE'],
            false,
            false,
            array('ID', 'IBLOCK_ID', 'PROPERTY_TSVET', 'PROPERTY_RAZMER')
        );

}



if ($arResult['PROPERTIES']['IDKOMPLEKTA']['VALUE']) {
    $rs = CIBlockElement::GetList (
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
}/*elseif ($arResult['PROPERTIES']['IDGLAVNOGO']['VALUE']) {
    $rs = CIBlockElement::GetList (
        Array(),
        Array("IBLOCK_ID" => $arParam['IBLOCK_ID'], "PROPERTY_IDKOMPLEKTA" => $arResult['XML_ID']),
        false,
        Array (),
        Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE")
    );
    while($ar_fields = $rs->GetNext()) {
        $arResult['KOMPLEKT']['DISPLAY_NAME'] = $ar_fields["NAME"];
        $arResult['KOMPLEKT']['DISPLAY_URL'] = $ar_fields["DETAIL_PAGE_URL"];
        $arResult['KOMPLEKT']['DISPLAY_DETAIL_PICTURE'] = $ar_fields["DETAIL_PICTURE"];
    }
}*/

$arResult['SKU_COUNT'] = count($arResult['SKU']);

//get multiple prop sizes for item
foreach($arResult['SKU'] as $key => $item){
	if($item['ID'] == $arResult['ID'] && is_array($arResult['PROPERTIES']['RAZMER']['VALUE'])){
		$arResult['SKU'][$key]['PROPERTY_RAZMER_VALUE'] = reset($arResult['PROPERTIES']['RAZMER']['VALUE']);
		break;
	}
}


function SortOfferSize($a, $b){
	return intval($a['PROPERTY_RAZMER_VALUE']) - intval($b['PROPERTY_RAZMER_VALUE']);
}

$sku_raw = $arResult['SKU'];
$sizes_sort = array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL');
$sku_by_color = array();
$sku_by_size = array();

foreach($arResult['SKU'] as $key => $arItem){
	$clr_key = strlen($arItem['PROPERTY_TSVET_VALUE']) > 0 ? $arItem['PROPERTY_TSVET_VALUE'] : 'OTHER';
	
	$sku_by_color[$clr_key][$key] = $arItem; 
}

ksort($sku_by_color);

foreach($sku_by_color as $clr => $items){
	
		usort($items, 'SortOfferSize');
		
		$size_values = array();
		foreach($items as $i => $v){
			$pos = array_search($v['PROPERTY_RAZMER_VALUE'], $sizes_sort);
			if($pos === FALSE) continue;
			
			$size_values[$pos] = $v;
			unset($items[$i]); 
		}
		
		ksort($size_values);
		
		$items = array_merge($items, $size_values);
		
		$sku_by_color[$clr] = $items;

}

$arResult['SKU'] = $sku_by_color;

//$sorted = array_orderby($arResult['SKU'], 'PROPERTY_TSVET_VALUE', SORT_ASC);
//$arResult['SKU'] = $sorted;



//nah
$arSkuSizes = array();

//Count store amount
$sku_ids = array();

if($sku_raw){
    foreach($sku_raw as $item){
        $sku_ids[] = array('PRODUCT_ID' => $item['ID']);
        $arSkuSizes[$item['ID']] = $item['PROPERTY_RAZMER_VALUE'];
    }    
}else{
    $sku_ids[] = $arResult['ID'];
    
}



//filials
$f_res = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => 7),
    false,
    false,
    array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL')
);

//nah
$arResult['SKU_SIZES_IN_STORES'] = array();
$arResult['CHECK_ONLY_ONE_SIZE'] = 0;

while($ob = $f_res->GetNextElement()){

    $filial = $ob->GetFields();

    $store_list = $ob->GetProperties(array(), array('CODE' => 'stores'));
    $store_list = $store_list['stores']['VALUE'];

    if(!$store_list) continue;

    $res = CCatalogStore::GetList(array(), array('XML_ID' => $store_list), false, false, array('ID', 'XML_ID'));
    $store_ids = array();
    while($store = $res->fetch()){
        $store_ids[] = $store['ID'];
    }


    foreach($sku_ids as $product_id) {

        $filter = array(
            "ACTIVE" => "Y",
            "+SITE_ID" => SITE_ID,
            'STORE_ID' => $store_ids,
            'PRODUCT_ID' => $product_id,
        );


        $storeIterator = CCatalogStoreProduct::GetList(array(), $filter, false, false, array('*'));
        while ($store = $storeIterator->Fetch()) {
            $arResult['STORES'][$filial['ID']] = array('NAME' => $filial['NAME'], 'LINK' => $filial['DETAIL_PAGE_URL'], 'AMOUNT' => $store['AMOUNT']);

            //nah
            $arResult['SKU_SIZES_IN_STORES'][$filial['ID']]['STORE'] = $arResult['STORES'][$filial['ID']];

            if($store['AMOUNT'] > 0){
                $arResult['SKU_SIZES_IN_STORES'][$filial['ID']]['SIZES'][$arSkuSizes[$product_id['PRODUCT_ID']]] = $arSkuSizes[$product_id['PRODUCT_ID']];
                $arResult['CHECK_ONLY_ONE_SIZE']++;
                break;
            }
        }

    }


    // if($arResult['STORES'][$filial['ID']]) continue;

//        $storeIterator = CCatalogStoreProduct::GetList(array(), $filter, false, false, array('*'));
//
//        while ($store = $storeIterator->Fetch()) {
//            //if($store['PRODUCT_ID'] == 638189){
//                if(!$arResult['STORE_DEBUG'][$filial['ID']])
//                    $arResult['STORE_DEBUG'][$filial['ID']] = $filial;
//
//                $arResult['STORE_DEBUG'][$filial['ID']]['STORES'][] = $store;
//            //}
//        }

}
//var_dump($arResult['STORES']);

$this->__component->setResultCacheKeys(array("CANONICAL_URL", "IBLOCK_SECTION_ID", "PROP_SIZES_VALUE"));

//echo '<script>console.log('.json_encode($arResult).')</script>';

if(!$arResult['CAN_BUY'] && $arResult['SKU_COUNT'] > 0){
	
	foreach($arResult['SKU'] as $sku_type){
		foreach($sku_type as $sku){
			if($sku['CATALOG_QUANTITY'] > 0){
				$arResult['CAN_BUY'] = true;
				break 2;
			}
		}
	}
	
}


 //nah
$arResult['OLD_PRICE'] = 0;
if (isset($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"])){
  $arResult['OLD_PRICE'] = $arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"];
} else if($arResult['MIN_PRICE']['VALUE'] > 0 && $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE']){
  $arResult['OLD_PRICE'] = $arResult['MIN_PRICE']['PRINT_VALUE'];
}
if(!empty($arResult['OLD_PRICE'])){
	$pos = strpos($arResult['OLD_PRICE'], 'руб');
	if ($pos === false) {
		$arResult['OLD_PRICE'].=' руб';
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

    /*$db = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>$arResult['IBLOCK_ID'], 'ID'=>$arResult['ID']), false, false, array('SHOW_COUNTER'));
    if ($i = $db->Fetch()){

        var_dump($i['SHOW_COUNTER']);
    }*/
$arResult['ARDISCOUNTS'] = \CCatalogDiscount::GetDiscountByProduct(
        $arResult['ID'],
        $USER->GetUserGroupArray(),
        "N",
        2,
        SITE_ID
    );
/*?><!--pre><?print_r($arResult['SETKA']);?></pre--><?*/


$arResult['LIST_DOSTUPNOST_ITEM'] = \Kolchuga\StoreList::itemRazmerDostupByArt(
		$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'],
		array(
			'IBLOCK_ID'=>$arResult['IBLOCK_ID'],
			'CML2_ARTICLE'=>$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'],
			'ID'=>$arResult['ID']
		)
	)['ITEM'];
//\Kolchuga\Settings::xmp($arResult["LIST_DOSTUPNOST_ITEM"],11460, __FILE__.": ".__LINE__);
$cp = $this->__component; // объект компонента
if (is_object($cp)){
	
   $cp->SetResultCacheKeys(array('TIMESTAMP_X','~NAME'));
}