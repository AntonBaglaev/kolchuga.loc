<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CNewsStockList extends CBitrixComponent
{

    var $arFilter = array(
        '=ACTIVE'           => 'Y',
        'ACTIVE_DATE'       => 'Y',
        '!=PREVIEW_PICTURE' => false,
        '!=DETAIL_PICTURE'  => false,
    );

    var $arSelect = array(
        'ID',
        'NAME',
        'CODE',
        'IBLOCK_ID',
        'PREVIEW_TEXT',
        'PREVIEW_PICTURE',
        'DETAIL_PICTURE',
        'DETAIL_PAGE_URL',
    );

    public function executeComponent()
    {

        global $APPLICATION;

        if ($this->StartResultCache()) {

            if (!\Bitrix\Main\Loader::IncludeModule('iblock')) {
                $this->abortResultCache();
                return false;
            }

            $arFilter = $this->arFilter;
//			$arFilter['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];

            $this->arResult['ITEMS'] = array();

            $arVKLinks = [];

            $arVKSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_VK_LINK");
            $arVKFilter = array("IBLOCK_ID" => 56, "ACTIVE_DATE" => "Y", "!PROPERTY_VK_LINK" => false); // Из инфоблока Пост из VK
            $resVK = CIBlockElement::GetList(array("ID" => "DESC"), $arVKFilter, false, array("nPageSize" => 15), $arVKSelect);
            while ($obVK = $resVK->GetNextElement()) {
                $arFields = $obVK->GetFields();

                if ($arFields['PROPERTY_VK_LINK_VALUE']) {
                    $arVKLinks[] = str_replace('https://vk.com/wall-', '', $arFields['PROPERTY_VK_LINK_VALUE']);
                }
            }

            if (!$arVKLinks) {
                $this->abortResultCache();
                return false;
            }

        }
        $this->endResultCache();

        $this->IncludeComponentTemplate();

    }

}