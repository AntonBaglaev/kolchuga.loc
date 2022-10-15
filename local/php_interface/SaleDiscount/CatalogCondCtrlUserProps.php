<?php

namespace Roztech\SaleDiscount;

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Sale;


class CatalogCondCtrlUserProps extends \CCatalogCondCtrlComplex
{
    public static function GetClassName()
    {
        return __CLASS__;
    }
    /**
     * @return string|array
     */
    public static function GetControlID()
    {
        return array('CondUserGroupas');
    }


    /**
     * Функция добавляет категорию условий и добавляет в нее
     * сами условия описнные в функции GetControls()
     *
     * @param $arParams
     * @return array
     */
    public static function GetControlShow($arParams)
    {
        $arControls = static::GetControls();
        $arResult = array(
            'controlgroup' => true,
            'group' =>  false,
            'label' => 'Поля Пользователя',
            'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
            'children' => array()
        );
        foreach ($arControls as &$arOneControl)
        {
            $arResult['children'][] = array(
                'controlId' => $arOneControl['ID'],
                'group' => false,
                'label' => $arOneControl['LABEL'],
                'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
                'control' => array(
                    array(
                        'id' => 'prefix',
                        'type' => 'prefix',
                        'text' => $arOneControl['PREFIX']
                    ),
                    static::GetLogicAtom($arOneControl['LOGIC']),
                    static::GetValueAtom($arOneControl['JS_VALUE'])
                )
            );
        }
        if (isset($arOneControl))
            unset($arOneControl);

        return $arResult;
    }

    /**
     * Функция добавления условий
     *
     * @param bool|string $strControlID
     * @return bool|array
     */
    public static function GetControls($strControlID = false)
    {
        $arControlList = array(
            'CondUserGroupas' => array(
                'ID' => 'CondUserGroupas',
                'FIELD' => 'GROUP_ID',
                'FIELD_TYPE' => 'text',
                'LABEL' => 'ID группы Пользователя',
                'PREFIX' => 'поле ID группы Пользователя',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
			'CondPriceGroupas' => array(
                'ID' => 'CondPriceGroupas',
                'FIELD' => 'ITEM_PRICE',
                'FIELD_TYPE' => 'text',
                'LABEL' => 'Цена товара равно',
                'PREFIX' => 'поле Цена товара',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
			'CondPriceGroupasUp' => array(
                'ID' => 'CondPriceGroupasUp',
                'FIELD' => 'ITEM_PRICE_UP',
                'FIELD_TYPE' => 'text',
                'LABEL' => 'Цена товара больше',
                'PREFIX' => 'поле Цена товара больше',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
			'CondPriceGroupasDown' => array(
                'ID' => 'CondPriceGroupasDown',
                'FIELD' => 'ITEM_PRICE_DOWN',
                'FIELD_TYPE' => 'text',
                'LABEL' => 'Цена товара меньше',
                'PREFIX' => 'поле Цена товара меньше',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
        );

        foreach ($arControlList as &$control)
        {
            if (!isset($control['PARENT']))
                $control['PARENT'] = true;

            $control['MULTIPLE'] = 'N';
        }
        unset($control);

        if ($strControlID === false)
        {
            return $arControlList;
        }
        elseif (isset($arControlList[$strControlID]))
        {
            return $arControlList[$strControlID];
        }
        else
        {
            return false;
        }
    }

    /**
     * Функция подготавливает строчное представление метода проверки условий.
     * Эта строка запускается языковой конструкцией eval() в модуле скидок.
     *
     * @param $arOneCondition array Массив состояний
     * @param $arParams
     * @param $arControl
     * @param bool $arSubs
     * @return string
     */
    public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
    {
        if($arOneCondition['logic']=='Equal')
        {
            $logic='true';
        }
        else
        {
            $logic='false';
        }
		if (is_string($arControl))
        {
            $arControl = static::GetControls($arControl);
        }
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row arParams****\n".print_r($arParams, true), FILE_APPEND | LOCK_EX);
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row arParams****\n".print_r($arControl, true), FILE_APPEND | LOCK_EX);
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row arParams****\n".print_r($arOneCondition, true), FILE_APPEND | LOCK_EX);
		//$propa=var_export($arParams['FIELD']);
		
        $strResult  = "\\Roztech\SaleDiscount\CatalogCondCtrlUserProps::checkUserField('".$arControl['FIELD']."', '".$arOneCondition["value"]."', ".$arParams['FIELD'].")===".$logic;
        return  $strResult;

    }

    /**
     * Функция выполняющая проверку условия (если возвращает true условие считается выполненым)
     *
     * @param array|array
     * @return bool
     */
    public static function CityCheck($city, $targetCity)
    {
        $check = false;
        if ($city === $targetCity) {
            $check = true;
        }
        return $check;
    }
    public static function checkUserField($strUserField, $strValue,  $prow)
    {
        global $USER;
		
		if($strUserField=='GROUP_ID'){
			$arGroups = \CUser::GetUserGroup($USER->GetID());
			if (in_array($strValue,$arGroups)){
				return true;
			}
		}elseif($strUserField=='ITEM_PRICE'){
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row 1****\n".print_r($prow, true), FILE_APPEND | LOCK_EX);
			
			$price_result = \CPrice::GetList(
				array(),
				array(
				"PRODUCT_ID" => $prow["ID"], // $arFields2["ID"] - этой мой id товара, может быть и число например 12458
				"CATALOG_GROUP_ID" => 2 // это группа цены, у меня есть как оптовые так и розничная цена
				)
			);
			while ($arPrices = $price_result->Fetch())
			{
			$myPricesa = $arPrices["PRICE"]; // тут присваиваю значения переменной 
			}
			if($myPricesa==$strValue){
				return true;
			}


		}elseif($strUserField=='ITEM_PRICE_UP'){
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row 1****\n".print_r($prow, true), FILE_APPEND | LOCK_EX);
			
			$price_result = \CPrice::GetList(
				array(),
				array(
				"PRODUCT_ID" => $prow["ID"], // $arFields2["ID"] - этой мой id товара, может быть и число например 12458
				"CATALOG_GROUP_ID" => 2 // это группа цены, у меня есть как оптовые так и розничная цена
				)
			);
			while ($arPrices = $price_result->Fetch())
			{
			$myPricesa = $arPrices["PRICE"]; // тут присваиваю значения переменной 
			}
			if($myPricesa > $strValue){
				return true;
			}


		}elseif($strUserField=='ITEM_PRICE_DOWN'){
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event1.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **row 1****\n".print_r($prow, true), FILE_APPEND | LOCK_EX);
			
			$price_result = \CPrice::GetList(
				array(),
				array(
				"PRODUCT_ID" => $prow["ID"], // $arFields2["ID"] - этой мой id товара, может быть и число например 12458
				"CATALOG_GROUP_ID" => 2 // это группа цены, у меня есть как оптовые так и розничная цена
				)
			);
			while ($arPrices = $price_result->Fetch())
			{
			$myPricesa = $arPrices["PRICE"]; // тут присваиваю значения переменной 
			}
			if($myPricesa < $strValue){
				return true;
			}


		}
		
		return false;
    }    
}
?>