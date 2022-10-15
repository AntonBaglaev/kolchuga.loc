<?
namespace Intervolga\ConversionPro\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);


class PRODUCTLIST extends \CBitrixComponent
{
    const MODULE_ID = 'intervolga.conversionpro';

    public function onPrepareComponentParams($arParams)
    {
        if (!is_array($arParams['ID'])) {
            $arParams['ID'] = array();
        }

        if (!is_array($arParams['NAME'])) {
            $arParams['NAME'] = array();
        }

        if (!is_array($arParams['PRICE'])) {
            $arParams['PRICE'] = array();
        }

        if (!is_array($arParams['CURRENCY'])) {
            $arParams['CURRENCY'] = array();
        }

        return $arParams;
    }

    public function executeComponent()
    {
        if (!Loader::includeModule(self::MODULE_ID)) {
            $this->__ShowError(Loc::getMessage('INTERVOLGA_CONVERSIONPRO_PRODUCTLIST_MODULE_ERROR', array(
                '#MODULE_ID#' => self::MODULE_ID
            )));

            return;
        }

        $productIds = $this->prepareResult();
        $this->includeComponentTemplate();

        return $productIds;
    }

    protected function prepareResult()
    {
        $this->arResult['PRODUCTS'] = false;
        $this->arResult['PRODUCTS_JS'] = false;

        if (!count($this->arParams['ID'])) {
            return;
        }

        $products = array();
        foreach (array_keys($this->arParams['ID']) as $i) {
            $id = (int)$this->arParams['ID'][$i];
            if (0 === $id) {
                continue;
            }

            $name = null;
            if (array_key_exists($i, $this->arParams['NAME']) &&
                '' !== (string)$this->arParams['NAME'][$i]
            ) {
                $name = (string)$this->arParams['NAME'][$i];
            }

            $price = null;
            if (array_key_exists($i, $this->arParams['PRICE']) &&
                0 < (float)$this->arParams['PRICE'][$i]
            ) {
                $price = (float)$this->arParams['PRICE'][$i];
            }

            $currency = null;
            if (array_key_exists($i, $this->arParams['CURRENCY']) &&
                '' !== (string)$this->arParams['CURRENCY'][$i]
            ) {
                $currency = (string)$this->arParams['CURRENCY'][$i];
            }

            $products[$id] = array(
                'ID' => $id,
                'NAME' => $name,
                'PRICE' => $price,
                'CURRENCY' => $currency
            );
        }


        $products = \IntervolgaConversionProConverter::catalogElementsToProducts($products);
        if (!count($products)) {
            return;
        }

        $this->arResult['PRODUCTS'] = $products;
        $this->arResult['PRODUCTS_JS'] = \CUtil::PhpToJSObject($products, false, false, true);


        return ivcp_array_column($products, 'id');
    }
}

