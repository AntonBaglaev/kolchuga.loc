<?php

namespace Kolchuga;

class CustomElementProperty{
	function GetIBlockPropertyDescriptionSeveral()
    {
        return array(
            "PROPERTY_TYPE" => "E", // Прототип типа свойства - привязка к элементам
            "USER_TYPE" => "ElementWithDescriptionSeveral",
            "DESCRIPTION" => "Привязка к элементам с несколькими полями", //Название нового типа свойства
            'GetPropertyFieldHtml' => array(__CLASS__, 'GetPropertyFieldHtml'),
            "ConvertToDB" => array(__CLASS__,"ConvertToDB"),
            "ConvertFromDB" => array(__CLASS__,"ConvertFromDB"),
        );
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $value["DESCRIPTION"] = unserialize($value["DESCRIPTION"]);

        $arItem = Array(
            "ID" => 0,
            "IBLOCK_ID" => 0,
            "NAME" => ""
        );
        if(intval($value["VALUE"]) > 0)
        {
			\Bitrix\Main\Loader::includeModule('iblock');
            $arFilter = Array(
                "ID" => intval($value["VALUE"]),
            );
            $arItem = \CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "IBLOCK_ID", "NAME"))->Fetch();			
        }

        $html = '<input name="'.$strHTMLControlName["VALUE"].'" id="'.$strHTMLControlName["VALUE"].'" value="'.htmlspecialcharsex($value["VALUE"]).'" size="5" type="text">';
        $html .= ' <span id="sp_'.md5($strHTMLControlName["VALUE"]).'_'.$key.'">'.$arItem["NAME"].'</span>';
        $html .= '<input type="button" value="..." onclick="jsUtils.OpenWindow(\'/bitrix/admin/iblock_element_search.php?lang='.LANG.'&IBLOCK_ID='.$arProperty["LINK_IBLOCK_ID"].'&n='.$strHTMLControlName["VALUE"].'\', 600, 500);">';
        $html .= '<br><div style="margin-left:6em;"><div style="width: 80px;display: inline-block;">Столбцов:</div><input type="text" size="6" id="quan" name="'.$strHTMLControlName["DESCRIPTION"].'[0]" value="'.htmlspecialcharsex($value["DESCRIPTION"][0]).'"></div>';
        $html .= '<br><div style="margin-left:6em;"><div style="width: 80px;display: inline-block;">Метка:</div><input type="text" size="6" id="metka" name="'.$strHTMLControlName["DESCRIPTION"].'[1]" value="'.htmlspecialcharsex($value["DESCRIPTION"][1]).'"></div>';
        $html .= '<br><div style="margin-left:6em;"><div style="width: 80px;display: inline-block;">Группа:</div><input type="text" size="6" id="group" name="'.$strHTMLControlName["DESCRIPTION"].'[2]" value="'.htmlspecialcharsex($value["DESCRIPTION"][2]).'"></div>';
        return  $html;
    }

    function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName)
    {
        return;
    }

    function ConvertToDB($arProperty, $value)
    {
        $return = false;
        
        if( is_array($value) && array_key_exists("VALUE", $value) && ($value['VALUE'] > 0))
        {
            $return = array(
                "VALUE" => serialize($value["VALUE"]),
                "DESCRIPTION" => serialize($value["DESCRIPTION"]),
            );
        }    
        
        return $return; 
    }
        
    function ConvertFromDB($arProperty, $value)
    {
        $return = false;

        if(!is_array($value["VALUE"]))
        {
            $return = array(
                "VALUE" => unserialize($value["VALUE"]),
            );
        }
            
        if(!is_array($value["DESCRIPTION"]))
        {
            $return["DESCRIPTION"] = unserialize($value["DESCRIPTION"]);
        }

        if ($return['VALUE'] > 0):
            return $return;
        endif;
    }
}