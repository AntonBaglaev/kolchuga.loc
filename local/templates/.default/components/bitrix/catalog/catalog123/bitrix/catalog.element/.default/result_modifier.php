<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 18:06
 */

if($arResult['PROPERTIES']['RAZMER']['VALUE']) {
	foreach($arResult['PROPERTIES']['RAZMER']['VALUE'] as $v){
	    $size = $v;
	    $l = -strlen($size);
	    if (substr($arResult['NAME'], $l) == $size){
	        $arResult['NAME'] = trim(substr($arResult['NAME'], 0, $l));
	        break;
	    }
	}
		
    $cp = $this->__component; // объект компонента
    if (is_object($cp)) {
        // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
        $cp->arResult['TITLE'] = $arResult['NAME'];
        $cp->SetResultCacheKeys(array('TITLE'));
    }
}


if($arResult['PROPERTIES']['IDGLAVNOGO']['VALUE'] == $arResult['XML_ID']){

    require($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/tools/getProducts.php');

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

    var_dump(count($arResult['SKU']));

}

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


//Count store amount
$sku_ids = array();

if($sku_raw)
    foreach($sku_raw as $item)
        $sku_ids[] = array('PRODUCT_ID' => $item['ID']);
else
    $sku_ids[] = $arResult['ID'];

//filials
$f_res = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => 7),
    false,
    false,
    array('ID', 'IBLOCK_ID', 'NAME')
);

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
            '>AMOUNT' => 0,
            'PRODUCT_ID' => $product_id
        );


        $storeIterator = CCatalogStoreProduct::GetList(array(), $filter, false, false, array('*'));
        if ($store = $storeIterator->Fetch()) {
            $arResult['STORES'][$filial['ID']] = $filial['NAME'];
            break;
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