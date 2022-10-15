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
        return array('CondUser', 'CondUserDestinationStore','CondUserGroupas');
    }

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
     * @param bool|string $strControlID
     * @return bool|array
     */
    public static function GetControls($strControlID = false)
    {
        $arControlList = array(
            'CondUser' => array(
                'ID' => 'CondUser',
                'FIELD' => 'ID',
                'FIELD_TYPE' => 'int',
                'LABEL' => 'ID Пользователя',
                'PREFIX' => 'поле ID Пользователя',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
			'CondUserGroupas' => array(
                'ID' => 'CondUserGroupas',
                'FIELD' => 'GROUP_ID',
                'FIELD_TYPE' => 'string',
                'LABEL' => 'ID группы Пользователя',
                'PREFIX' => 'поле ID группы Пользователя',
                'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
                'JS_VALUE' => array(
                    'type' => 'input'
                ),
                'PHP_VALUE' => ''
            ),
            'CondUserDestinationStore' => array(
                'ID' => 'CondUserDestinationStore',
                'FIELD' => 'UF_USER_FIELD',
                'FIELD_TYPE' => 'string',
                'LABEL' => 'UF_USER_FIELD Пользователя',
                'PREFIX' => 'поле UF_USER_FIELD Пользователя',
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

            $control['EXIST_HANDLER'] = 'Y';

            $control['MODULE_ID'] = 'mymodule';

            $control['MULTIPLE'] = 'N';
            $control['GROUP'] = 'N';
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
    
    public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
    {
        $strResult = '';
        $resultValues = array();
        $arValues = false;

        if (is_string($arControl))
        {
            $arControl = static::GetControls($arControl);
        }
        $boolError = !is_array($arControl);

        if (!$boolError)
        {
            $arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
            $boolError = ($arValues === false);
        }
        if (!$boolError)
        {
            $boolError = !isset($arControl['MULTIPLE']);
        }

        if (!$boolError)
        {
			
            $arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
            if (!isset($arLogic['OP'][$arControl['MULTIPLE']]) || empty($arLogic['OP'][$arControl['MULTIPLE']]))
            {
                $boolError = true;
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testchhh.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r('160', true), FILE_APPEND | LOCK_EX);
            }
            else
            {
                //$strField = "\\Roztech\SaleDiscount\CatalogCondCtrlUserProps::checkUserField('{$arControl['FIELD']}', '{$arLogic['OP'][$arControl['MULTIPLE']]}', '{$arValues['value']}')";
                $strField = "\\Roztech\SaleDiscount\CatalogCondCtrlUserProps::checkUserField('{$arControl['FIELD']}', '{$arLogic['VALUE']}', '{$arValues['value']}')";
				
                switch ($arControl['FIELD_TYPE'])
                {
                    case 'int':
                    case 'double':
                        if (is_array($arValues['value']))
                        {
                            if (!isset($arLogic['MULTI_SEP']))
                            {
                                $boolError = true;
                            }
                            else
                            {
                                foreach ($arValues['value'] as &$value)
                                {
                                    $resultValues[] = str_replace(
                                        array('#FIELD#', '#VALUE#'),
                                        array($strField, $value),
                                        $arLogic['OP'][$arControl['MULTIPLE']]
                                    );
                                }
                                unset($value);
                                $strResult = '('.implode($arLogic['MULTI_SEP'], $resultValues).')';
                                unset($resultValues);
                            }
                        }
                        else
                        {
                            $strResult = str_replace(
                                array('#FIELD#', '#VALUE#'),
                                array($strField, $arValues['value']),
                                $arLogic['OP'][$arControl['MULTIPLE']]
                            );
                        }
                        break;
                    case 'char':
                    case 'string':
                    case 'text':
                        if (is_array($arValues['value']))
                        {
                            $boolError = true;
                        }
                        else
                        {
//                            $strResult = str_replace(
//                                array('#FIELD#', '#VALUE#'),
//                                array($strField, '"'.EscapePHPString($arValues['value']).'"'),
//                                $arLogic['OP'][$arControl['MULTIPLE']]
//                            );
                            $strResult = $strField;
                        }
                        break;
                    case 'date':
                    case 'datetime':
                        if (is_array($arValues['value']))
                        {
                            $boolError = true;
                        }
                        else
                        {
                            $strResult = str_replace(
                                array('#FIELD#', '#VALUE#'),
                                array($strField, $arValues['value']),
                                $arLogic['OP'][$arControl['MULTIPLE']]
                            );
                        }
                        break;
                }
            }
        }
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testchhh.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arLogic, true), FILE_APPEND | LOCK_EX);
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testchhh.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arControl, true), FILE_APPEND | LOCK_EX);
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testchhh.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($strResult, true), FILE_APPEND | LOCK_EX);
        return (!$boolError ? $strResult : false);
    }

    public static function checkUserField($strUserField, $strCond, $strValue)
    {
        global $USER;
		
		if($strUserField=='GROUP_ID'){
			$arGroups = \CUser::GetUserGroup($USER->GetID());
			if (in_array($strValue,$arGroups)){
				$field=$strValue;
			}else{
				$field=0;
			}
		}else{
			$arUser = $USER->GetByID($USER->GetID())->Fetch();

			$field = $arUser[$strUserField];
			
		}
		if($strCond=='Not'){
			if($field != $strValue){return true;}else{return false;}
		}elseif($strCond=='Equal'){
			if($field == $strValue){return true;}else{return false;}
		}
		
		$arFields=str_replace(array('#FIELD#', '#VALUE#'), array($field, $strValue), $strCond);
		/* if($arFields===true){
			return true;
		}else{
			return false;
		} */
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testchhh.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arFields, true), FILE_APPEND | LOCK_EX);
        return $arFields;
    }    
}
?>