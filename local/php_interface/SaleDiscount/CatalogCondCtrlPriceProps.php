<?php

namespace Roztech\SaleDiscount;

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Sale;


class CatalogCondCtrlPriceProps extends \CCatalogCondCtrlComplex
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
        return array('CondPriceGroupas');
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
            'CondPriceGroupas' => array(
                'ID' => 'CondPriceGroupas',
                'FIELD' => 'GROUP_ID',
                'FIELD_TYPE' => 'text',
                'LABEL' => 'Цена товара',
                'PREFIX' => 'поле Цена товара',
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
		
        $strResult  = "\\Roztech\SaleDiscount\CatalogCondCtrlPriceProps::checkField('".$arControl['FIELD']."', '".$arOneCondition["value"]."')===".$logic;
        return  $strResult;

    }

    /**
     * Функция выполняющая проверку условия (если возвращает true условие считается выполненым)
     *
     * @param array|array
     * @return bool
     */
    
    public static function checkField($strUserField, $strValue)
    {
        global $USER;
		
		if($strUserField=='GROUP_ID'){
			$arGroups = \CUser::GetUserGroup($USER->GetID());
			if (in_array($strValue,$arGroups)){
				return true;
			}
		}
		
		return false;
    }    
}
?>