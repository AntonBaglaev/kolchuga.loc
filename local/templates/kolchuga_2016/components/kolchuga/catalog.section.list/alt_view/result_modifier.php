<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//seo
$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"],$arResult['SECTION']['ID']);
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
}else{
	$APPLICATION->SetPageProperty("title", $arResult['SECTION']['NAME']);
	$APPLICATION->SetTitle($arResult['SECTION']['NAME']);
}



$arSelect = array("ID", "NAME", "DETAIL_PICTURE", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y");
$i=0;
foreach ($arResult['SECTIONS'] as $kSection => $vSection) {
    
    $arElements = $vSection['UF_BLOCK_ITEMS'];

    if(count($arElements) > 0){

        $items = array();
        $arFilter['ID'] = $arElements;
        $objElements = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize"=>3), $arSelect);
        while($element = $objElements->GetNext()){
            $items['NAME'] = $element['NAME'];
            $items['DETAIL_PAGE_URL'] = $element['DETAIL_PAGE_URL'];

            $items['DETAIL_PICTURE'] = '';
            if($element["DETAIL_PICTURE"]){
                $pic = CFile::ResizeImageGet($element["DETAIL_PICTURE"], array('width'=>200, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $items['DETAIL_PICTURE'] = $pic['src'];
            }

            //цена со скидкой
            $items['PRICE'] = '';
            $items['PRICE_FORMATTED'] = '';
            $rsPrices = CPrice::GetList(array(), array('PRODUCT_ID' => $element['ID'], 'CATALOG_GROUP_ID' => 2));
            if ($arPrice = $rsPrices->Fetch()) {
                $arDiscounts = CCatalogDiscount::GetDiscountByPrice(
                    $arPrice["ID"],
                    $USER->GetUserGroupArray(),
                    "N",
                    SITE_ID
                );
                $discountPrice = CCatalogProduct::CountPriceWithDiscount(
                    $arPrice["PRICE"],
                    'RUB',
                    $arDiscounts
                );              

                $items['PRICE'] = ceil(CCurrencyRates::ConvertCurrency($discountPrice,$arPrice["CURRENCY"],"RUB"));
                $items['PRICE_FORMATTED'] = CurrencyFormat($items['PRICE'], 'RUB');
                $items['OLD_PRICE'] = $arPrice['PRICE'];
                $items['OLD_PRICE_FORMATTED'] = CurrencyFormat($arPrice['PRICE'], 'RUB');
                $items['DIFF_PERCENT'] = round(($arPrice['PRICE'] - $discountPrice)*100/$arPrice['PRICE']);
            }            

            $arResult['SECTIONS'][$kSection]['ITEMS'][] = $items;
        }

        //популярные теги
        $tags = array();
        $arFilterTags = Array("IBLOCK_ID"=>48, "SECTION_ID"=>ID_POPULAR_TAGS, "INCLUDE_SUBSECTIONS"=>'Y', "ACTIVE"=>"Y", "!=PROPERTY_POSITION_BOTTOM_VALUE" => "Y", "PROPERTY_CSECTIONS"=>array($vSection['ID']));
        $objTags = CIBlockElement::GetList(array(), $arFilterTags, false, array("nPageSize"=>30), array("ID", "IBLOCK_ID", "NAME", "CODE"));
        while($tag = $objTags->GetNext()){
            $tags[$tag['ID']]['URL'] = $vSection['SECTION_PAGE_URL'].$tag['CODE'].'/';
            $tags[$tag['ID']]['NAME'] = $tag['NAME'];
        }
        $arResult['SECTIONS'][$kSection]['TAGS'] = $tags;

        //css класс для открытого\закрытого блока
        $arResult['SECTIONS'][$kSection]['BLOCK_CLASS'] = 'as_1';
        if($i > 2){
            $arResult['SECTIONS'][$kSection]['BLOCK_CLASS'] = 'as_0';
        }

        $i++;
    }
}
?>