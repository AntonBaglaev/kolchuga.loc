<?php

namespace Roztech\SaleDiscount;

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Sale;


class TwoForFifteen extends \CSaleActionCtrlBasketGroup
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetShowIn($arControls)
	{
		return array(\CSaleActionCtrlGroup::GetControlID());
	}

	public static function GetControlID()
	{
		return 'TovarCondGroup2';
	}

	public static function GetAtoms()
	{
		return static::GetAtomsEx(false, false);
	}

	public static function GetAtomsEx($strControlID = false, $boolEx = false)
	{
		$boolEx = (true === $boolEx ? true : false);
		$arAtomList = array(            
            'Cnt' => array(
                'JS' => array(
                    'id' => 'Cnt',
                    'name' => 'extra_coll',
                    'type' => 'select',
                    'values' => array(
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                    ),
                    "defaultText" => "...",
					"defaultValue" => "",
                    'first_option' => '...'
                ),
                'ATOM' => array(
                    'ID' => 'Cnt',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => 'list'
                )
            ),
            'Proc' => array(
                'JS' => array(
                    'id' => 'Proc',
                    'name' => 'extra_proc',
                    'type' => 'input'
                ),
                'ATOM' => array(
                    'ID' => 'Proc',
                    'FIELD_TYPE' => 'string',
                    'FIELD_LENGTH' => 255,
                    'MULTIPLE' => 'N',
                    'VALIDATE' => ''
                )
            ),
			'All' => array(
				'JS' => array(
					'id' => 'All',
					'name' => 'aggregator',
					'type' => 'select',
					'values' => array(
						'AND' => "все условия",
						'OR' => "любое из условий"
					),
					'defaultText' => "...",
					'defaultValue' => 'AND',
					'first_option' => '...'
				),
				'ATOM' => array(
					'ID' => 'All',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 255,
					'MULTIPLE' => 'N',
					'VALIDATE' => 'list'
				)
			),
			'True' => array(
				'JS' => array(
					'id' => 'True',
					'name' => 'value',
					'type' => 'select',
					'values' => array(
						'True' => "выполнено(ы)",
						'False' => "не выполнено(ы)"
					),
					'defaultText' => "...",
					'defaultValue' => 'True',
					'first_option' => '...'
				),
				'ATOM' => array(
					'ID' => 'True',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 255,
					'MULTIPLE' => 'N',
					'VALIDATE' => 'list'
				)
			)
        );

		if (!$boolEx) {
            foreach ($arAtomList as &$arOneAtom) {
                $arOneAtom = $arOneAtom['JS'];
            }
            if (isset($arOneAtom))
                unset($arOneAtom);
        }
 
        return $arAtomList;
	}

	public static function GetControlDescr() {
        $description = parent::GetControlDescr();
        $description['EXECUTE_MODULE'] = 'all';//Для сохранения в таблицу
        $description['SORT'] = 500;
 
        return $description;
    }

	public static function GetControlShow($arParams)
	{
		$arAtoms = static::GetAtomsEx(false, false);
		$arResult = array(
			'controlId' => static::GetControlID(),
			'group' => true,
			//'containsOneAction' => true,
			'label' => "2 товар за 15%",
			'defaultText' => 'n товар за m%',
			'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
			//'children' => array(),
			'visual' => static::GetVisual(),
			'control' => array(
				$arAtoms['Cnt'],
				" самый дешевый товар чека за ",
				$arAtoms['Proc'],
				"%",
				$arAtoms['All'],
				$arAtoms['True']
			),
			'mess' => array(
				'ADD_CONTROL' => "Добавить условие",
				'SELECT_CONTROL' => "Выбрать условие"
			)
		);
		
		return $arResult;
	}
	
public static function GetVisual()
	{
		return array(
			'controls' => array(
				'All',
				'True'
			),
			'values' => array(
				array(
					'All' => 'AND',
					'True' => 'True'
				),
				array(
					'All' => 'AND',
					'True' => 'False'
				),
				array(
					'All' => 'OR',
					'True' => 'True'
				),
				array(
					'All' => 'OR',
					'True' => 'False'
				),
			),
			'logic' => array(
				array(
					'style' => 'condition-logic-and',
					'message' => "И"
				),
				array(
					'style' => 'condition-logic-and',
					'message' => "И НЕ"
				),
				array(
					'style' => 'condition-logic-or',
					'message' => "ИЛИ"
				),
				array(
					'style' => 'condition-logic-or',
					'message' => "ИЛИ НЕ"
				)
			)
		);
	}
	/*public static function Parse($arOneCondition)
	{
		return array(
			'All' => 'AND'
		);
		
		
	}*/

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		//I have to notice current method can work only with Gifter's. For example, it is CCatalogGifterProduct.
		//Probably in future we'll add another gifter's and create interface or class, which will tell about attitude to CSaleActionGiftCtrlGroup.
		$mxResult = '';
		$boolError = false;
//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/event50.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **arParams****\n".print_r($arParams, true), FILE_APPEND | LOCK_EX);
		
		/*if (is_string($arControl)) {
            if ($arControl == static::GetControlID()) {
                $arControl = array(
                    'ID' => static::GetControlID(),
                    'ATOMS' => static::GetAtoms()
                );
            }
        }
        $boolError = !is_array($arControl);*/
		
		
            $actionParams = array(
                'CNT' => $arOneCondition['Cnt'],
                'PROC' => $arOneCondition['Proc']
            );
            
			
			//$discountParams = '\Roztech\SaleDiscount\ThreeForFifth::applyThreeForFifth(' . $arParams['ORDER'] . ');';
			if (!empty($arSubs))
			{
				$filter = '$saleact'.$arParams['FUNC_ID'];

				if ($arOneCondition['All'] == 'AND')
				{
					$prefix = '';
					$logic = ' && ';
					$itemPrefix = ($arOneCondition['True'] == 'True' ? '' : '!');
					
				}
				else
				{
					$itemPrefix = '';
					if ($arOneCondition['True'] == 'True')
					{
						$prefix = '';
						$logic = ' || ';
					}
					else
					{
						$prefix = '!';
						$logic = ' && ';
					}
				}
				
				$prefix = '';
				$logic = ' && ';					
				$itemPrefix = '';

				$commandLine = $itemPrefix.implode($logic.$itemPrefix, $arSubs);
				if ($prefix != '')
					$commandLine = $prefix.'('.$commandLine.')';

				$discountParams = array ( 'VALUE' => -15.0, 'UNIT' => 'P', 'LIMIT_VALUE' => 0, 'dopparam'=>$actionParams);
				$mxResult = $filter.'=function($row){';
				$mxResult .= 'return ('.$commandLine.');';
				$mxResult .= '};';
				$mxResult .= '\Roztech\SaleDiscount\Actions2::applyToBasket('.$arParams['ORDER'].', '.var_export($discountParams, true).', '.$filter.');';
				unset($filter);
			}
			else
			{
			$discountParams = array ( 'VALUE' => -15.0, 'UNIT' => 'P', 'LIMIT_VALUE' => 0, 'dopparam'=>$actionParams);
			$mxResult = '\Roztech\SaleDiscount\Actions2::applyToBasket('.$arParams['ORDER'].', '.var_export($discountParams, true).', "");';
			}
		
		return $mxResult;
	}

	public static function applyThreeForFifth($row)
    {
			//file_put_contents("/var/www/stage/www/stage.wildorchid.ru/event50.txt", "\n\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****E **arFields****\n".print_r($row, true), FILE_APPEND | LOCK_EX);
		//return array (  );
		return array ( 'VALUE' => '-15.0', 'UNIT' => 'P', 'LIMIT_VALUE' => 0 );
	}
	

	
}
?>