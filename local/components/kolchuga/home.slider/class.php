<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CHomeSlider extends CBitrixComponent
{

    public function executeComponent()
    {

        if ($this->StartResultCache()) {

            if (!\Bitrix\Main\Loader::IncludeModule('iblock')) {
                $this->abortResultCache();
                return false;
            }

            $this->arResult['ITEMS'] = array();

            $arBannerLinks = [];

            $arBannerSelect = array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PREVIEW_TEXT");
            $arBannerFilter = array("IBLOCK_ID" => 57, "ACTIVE" => "Y",
                                    array(
                                        'LOGIC'              => 'OR',
                                        '<=DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
                                        'DATE_ACTIVE_FROM'   => false,
                                    ),
                                    array(
                                        'LOGIC'            => 'OR',
                                        '>=DATE_ACTIVE_TO' => date('d.m.Y H:i:s'),
                                        'DATE_ACTIVE_TO'   => false,
                                    ),
            ); // Баннеры - Слайдер на всю ширину

            $resBanner = CIBlockElement::GetList(array("ID" => "DESC", "SORT" => "ASC"), $arBannerFilter, false, array("nPageSize" => 15), $arBannerSelect);
            while ($obBanner = $resBanner->GetNextElement()) {
                $arFields = $obBanner->GetFields();
                $arProps = $obBanner->GetProperties();

                if (!$arFields['PREVIEW_PICTURE']) continue;

                $arBannerLinks[$arFields['ID']] = $arFields;
                $arBannerLinks[$arFields['ID']]['PROPS'] = $arProps;

                $arFile = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
                $arBannerLinks[$arFields['ID']]['PREVIEW_PICTURE'] = $arFile['SRC'];

                if ($arFile['CONTENT_TYPE'] != 'image/gif') {
                    $arWebpFile = \Kolchuga\Pict::getWebp($arFile, 60);
                    $arBannerLinks[$arFields['ID']]['PREVIEW_PICTURE_WEBP'] = $arWebpFile['WEBP_SRC'];
                } else {
                    $arBannerLinks[$arFields['ID']]['PREVIEW_PICTURE_WEBP'] = $arBannerLinks[$arFields['ID']]['PREVIEW_PICTURE'];
                }

                $arFile = CFile::GetFileArray($arFields['DETAIL_PICTURE']);
                $arBannerLinks[$arFields['ID']]['DETAIL_PICTURE'] = $arFile['SRC'];

                if ($arFile['CONTENT_TYPE'] != 'image/gif') {
                    $arWebpFileMobile = \Kolchuga\Pict::getWebp($arFile, 60);
                    $arBannerLinks[$arFields['ID']]['DETAIL_PICTURE_WEBP'] = $arWebpFileMobile['WEBP_SRC'];
                } else {
                    $arBannerLinks[$arFields['ID']]['DETAIL_PICTURE_WEBP'] = $arBannerLinks[$arFields['ID']]['DETAIL_PICTURE'];
                }

            }

            $this->arResult['ITEMS'] = $arBannerLinks;

            /**************************************/

            $this->arResult['SMALL_ITEMS'] = array();

            $arSmallBannerLinks = [];

            $arBannerSelect = array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE");
            $arBannerFilter = array("IBLOCK_ID" => 81, "ACTIVE" => "Y",
                                    array(
                                        'LOGIC'              => 'OR',
                                        '<=DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
                                        'DATE_ACTIVE_FROM'   => false,
                                    ),
                                    array(
                                        'LOGIC'            => 'OR',
                                        '>=DATE_ACTIVE_TO' => date('d.m.Y H:i:s'),
                                        'DATE_ACTIVE_TO'   => false,
                                    ),
            ); // Баннеры - Маленькие баннеры на главной

            $resBanner = CIBlockElement::GetList(array("SORT" => "ASC"), $arBannerFilter, false, array("nPageSize" => 2), $arBannerSelect);
            while ($obBanner = $resBanner->GetNextElement()) {
                $arFields = $obBanner->GetFields();
                $arProps = $obBanner->GetProperties();

                if (!$arFields['PREVIEW_PICTURE']) continue;

                $arSmallBannerLinks[$arFields['ID']] = $arFields;
                $arSmallBannerLinks[$arFields['ID']]['PROPS'] = $arProps;

                $arSmallBannerLinks[$arFields['ID']]['PREVIEW_PICTURE'] = (CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width' => 1000, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true))['src'];
                $arSmallBannerLinks[$arFields['ID']]['DETAIL_PICTURE'] = (CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width' => 1000, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true))['src'];
                $arSmallBannerLinks[$arFields['ID']]['PREVIEW_TEXT'] = $arFields['PREVIEW_TEXT'];


                $arSmallFile = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
                $arSmallFileMobile = CFile::GetFileArray($arFields['DETAIL_PICTURE']);

                if ($arSmallFile['CONTENT_TYPE'] != 'image/gif') {
                    $arWebpFile = \Kolchuga\Pict::getWebp($arSmallFile, 100);
                    $arSmallBannerLinks[$arFields['ID']]['PREVIEW_PICTURE_WEBP'] = $arWebpFile['WEBP_SRC'];
                } else {
                    $arSmallBannerLinks[$arFields['ID']]['PREVIEW_PICTURE_WEBP'] = $arSmallBannerLinks[$arFields['ID']]['PREVIEW_PICTURE'];
                }

                if ($arSmallFileMobile['CONTENT_TYPE'] != 'image/gif') {
                    $arWebpFileMobile = \Kolchuga\Pict::getWebp($arSmallFileMobile, 100);
                    $arSmallBannerLinks[$arFields['ID']]['DETAIL_PICTURE_WEBP'] = $arWebpFileMobile['WEBP_SRC'];
                } else {
                    $arSmallBannerLinks[$arFields['ID']]['DETAIL_PICTURE_WEBP'] = $arSmallBannerLinks[$arFields['ID']]['DETAIL_PICTURE'];
                }

            }

            $this->arResult['SMALL_ITEMS'] = $arSmallBannerLinks;

            $this->endResultCache();
        }

        $this->IncludeComponentTemplate();
    }

}