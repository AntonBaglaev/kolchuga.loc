<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 26.12.15
 * Time: 18:25
 */

function getProducts(
    $iblock,
    $ext_filter = array(),
    $gl_filter = false,
    $sort = array(),
    $price_code,
    $one = false,
    $limit = false,
    $select = array()
){

    if(!CModule::IncludeModule('iblock'))
        return;
    if(!CModule::IncludeModule('catalog'))
        return;
    if(!CModule::IncludeModule('sale'))
        return;

    //Params for price get
    $arPrices = CIBlockPriceTools::GetCatalogPrices($iblock, $price_code);
    $arConvertParams = array('CURRENCY_ID' => 'RUB'); //hardcode
    $incl_vat = true; //hardcode

    //get price groups
    $select_groups = array();
    foreach($arPrices as $code => $params)
        $select_groups[] = $params['SELECT'];

    //default fields
    $arSelect = array(
        'IBLOCK_ID',
        'IBLOCK_SECTION_ID',
        'ID',
        'NAME',
        'DETAIL_PAGE_URL',
        'PREVIEW_PICTURE',
        'CATALOG_QUANTITY'
    );

    $arSelect = array_merge($arSelect, $select);

    $arSelect = array_merge($arSelect, $select_groups);


    //default filter
    $arFilter = array('IBLOCK_ID' => $iblock, 'INCLUDE_SUBSECTIONS' => 'Y');
    if($gl_filter){
        global ${$gl_filter};
        $arrFilter = ${$gl_filter};
        if(is_array($arrFilter))
            $arFilter = array_merge($arrFilter, $arFilter);
    }

    $arFilter = array_merge($arFilter, $ext_filter);

    if($limit)
        $limit = array(
            'nTopCount' => $limit
        );

    //Get elements
    $result = array();
    $res = CIBlockElement::GetList($sort, $arFilter, false, $limit, $arSelect);
    while($ob = $res->GetNextElement()){

        $item = $ob->GetFields();

        if($item['PREVIEW_PICTURE']) $item['PREVIEW_PICTURE'] = CFile::GetFileArray($item['PREVIEW_PICTURE']);
        else $item['PREVIEW_PICTURE'] = array('SRC' => SITE_TEMPLATE_PATH . '/img/no_photo.png');

        if($item['DETAIL_PICTURE']) $item['DETAIL_PICTURE'] = CFile::GetFileArray($item['DETAIL_PICTURE']);

        $item["PRICES"] = CIBlockPriceTools::GetItemPrices($iblock, $arPrices, $item, $incl_vat, $arConvertParams);

        if ($item["PRICES"])
        {
            foreach ($item['PRICES'] as &$arOnePrice)
            {
                if ('Y' == $arOnePrice['MIN_PRICE'])
                {
                    $item['MIN_PRICE'] = $arOnePrice;
                    break;
                }
            }
            unset($arOnePrice);
        }

        $result[$item['ID']] = $item;

        if($one) break;

    }

    if($one) return reset($result);
    else
        return $result;
}