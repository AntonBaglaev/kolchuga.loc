<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 08/06/16
 * Time: 10:26
 */
if(empty($arResult['SECTIONS']) && $arResult['SECTION']['IBLOCK_SECTION_ID'] > 0){

    $parent = $arResult['SECTION']['IBLOCK_SECTION_ID'];

    $res = CIBlockSection::GetList(
        array('left_margin' => 'asc'),
        array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $parent, "ACTIVE"=>"Y"),
        false,
        array('ID', 'IBLOCK_ID', 'SECTION_PAGE_URL', 'NAME')
    );

    while($section = $res->GetNext()){

        if($section['ID'] == $arResult['SECTION']['ID']){
            $section['CURRENT'] = true;
        }

        $arResult['SECTIONS'][] = $section;
    }

}