<?
if (!defined("B_PROLOG_INCLUDED") ||
    B_PROLOG_INCLUDED !== true)
{
  die();
}

  //nah 
  $GLOBALS['remove_section'] = false;

  //значения поля "Группировка тегов"
  $arTagGroup = array();
  $objProp = CIBlockPropertyEnum::GetList(array(), array("IBLOCK_ID"=>$arParams['IBLOCKS'][0], "PROPERTY_ID"=>337));
  while($dataProp = $objProp->GetNext()){
    $arTagGroup['VALUE'] = $dataProp['XML_ID'];
  }


    $arResult["SECTION_GROUP"] = 
    $arResult["SEO_DATA"] = 
    $arResult["SET_FILTER"] = array();

  if (is_array($arResult["ITEMS"]) &&
      !empty($arResult["ITEMS"]))
  {
    $secGroup = 
    $ibList = array();
    
    foreach($arResult["ITEMS"] as &$arItem)
    {
      if (intval($arItem["IBLOCK_SECTION_ID"]) > 0)
      {
        if (!in_array($arItem["IBLOCK_ID"], $ibList))
        {
          $ibList[] = $arItem["IBLOCK_ID"];
        }
       
        if (intval($arParams["ELEMENT_ID"]) > 0)
        {
          $arItem["SELECTED"] = (bool)($arItem["ID"] == $arParams["ELEMENT_ID"]);
        }
        elseif (!empty($arParams["ELEMENT_CODE"]))
        {
          $arItem["SELECTED"] = (bool)($arItem["CODE"] == $arParams["ELEMENT_CODE"]);
        }
        
        $secGroup[intval($arItem["IBLOCK_SECTION_ID"])]["ITEMS"][] = &$arItem;
        
        if ($arItem["SELECTED"])
        {
          $arResult["SEO_DATA"] = array("DESCRIPTION" => ((isset($arItem["~PREVIEW_TEXT"]))? $arItem["~PREVIEW_TEXT"] : ""),
                                        "CHAIN" => array(
                                          "TEXT" => $arItem["NAME"],
                                          "LINK" => $arItem["DETAIL_PAGE_URL"]
                                        ));
          if (is_array($arItem["IPROPERTY_VALUES"]) &&
              !empty($arItem["IPROPERTY_VALUES"]))
          {
            $arResult["SEO_DATA"] = array_merge($arResult["SEO_DATA"], $arItem["IPROPERTY_VALUES"]);
          }
        }
       
        if ($arItem["SELECTED"] &&
            !empty($arItem["PROPERTY_FILTER_VALUE"]) &&
            !empty($arItem["PROPERTY_FILTER_DESCRIPTION"]))
        { 
          foreach($arItem["~PROPERTY_FILTER_VALUE"] as $k=>$CODE)
          { 
            $CODE = trim($CODE);
            $value = trim($arItem["~PROPERTY_FILTER_DESCRIPTION"][$k]);
            $value = explode(";", $value);
            if (count($value) > 0)
            {
              foreach($value as &$x)
              {
                $x = trim($x);
                if ($x == "false")
                {
                  $x = false;
                }
              }
              unset($x);
            }
            else
            {
              $value = $value[0];
            }
            
            if ($value == "false")
            {
              $value = false;
            }
            
            if (!isset($arResult["SET_FILTER"][strtoupper($CODE)]))
            {
              $arResult["SET_FILTER"][strtoupper($CODE)] = $value;
            }
            else
            {
              if (!is_array($value))
              {
                $value = array($value);
              }
              
              if (!is_array($arResult["SET_FILTER"][strtoupper($CODE)]))
              {
                $arResult["SET_FILTER"][strtoupper($CODE)] = array($arResult["SET_FILTER"][strtoupper($CODE)]);
              }
              
              $arResult["SET_FILTER"][strtoupper($CODE)] = array_merge($arResult["SET_FILTER"][strtoupper($CODE)], $value);
            }
          }
         
        }


        //nah - добавляем обработку фильтра: выбор товаров из других категорий
        if ($arItem["SELECTED"] && count($arItem["PROPERTY_SELECT_SECTION_VALUE"]) > 0){
          
          //указываем компоненту catalog.section брать товары без секции
          $GLOBALS['remove_section'] = true;

          $selectElements = array();

          $arSelect = Array("ID", "IBLOCK_ID");
          $arFilter = Array("IBLOCK_ID"=>40, "ACTIVE"=>"Y", 'INCLUDE_SUBSECTIONS'=>"Y");
          if(count($arItem["PROPERTY_SELECT_SECTION_VALUE"]) > 1){
            $filterSections = $arItem["PROPERTY_SELECT_SECTION_VALUE"];
          }else{
            $filterSections = $arItem["PROPERTY_SELECT_SECTION_VALUE"][0];
          }
          $arFilter['SECTION_ID'] = $filterSections;
          if(count($arResult["SET_FILTER"]) > 0){
            $arFilter = array_merge($arFilter, $arResult["SET_FILTER"]);
          }

          $objData = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
          while($data = $objData->GetNext()){
            $selectElements[$data['ID']] = $data['ID'];
          }

          $arResult["SET_FILTER"]['ID'] = $selectElements;
          
        }

        //nah - добавляем обработку фильтра доп. фильтра OR 1
        if ($arItem["SELECTED"] && count($arItem["PROPERTY_FILTER_OR_VALUE"]) > 0){
          $addFilterOr = array();
          $addFilterOr['LOGIC'] = 'OR';
          foreach ($arItem["PROPERTY_FILTER_OR_VALUE"] as $kFilter => $vFilter) {
            $addFilterOr[] = array($vFilter=>$arItem["PROPERTY_FILTER_OR_DESCRIPTION"][$kFilter]);
          }
       
          if(count($addFilterOr) > 1){
            $arResult["SET_FILTER"][] = $addFilterOr;
          }
        }

        //nah - добавляем обработку фильтра доп. фильтра OR 2
        /*if ($arItem["SELECTED"] && count($arItem["PROPERTY_FILTER_OR_2_VALUE"]) > 0){
          $addFilterOr = array();
          $addFilterOr['LOGIC'] = 'AND';
          foreach ($arItem["PROPERTY_FILTER_OR_2_VALUE"] as $kFilter => $vFilter) {
            $addFilterOr[] = array($vFilter=>$arItem["PROPERTY_FILTER_OR_2_DESCRIPTION"][$kFilter]);
          }

          if(count($addFilterOr) > 1){
            $arResult["SET_FILTER"][] = $addFilterOr;
          }
        }*/

        if($_GET['t'] == 'y'){
          //var_dump($arItem["PROPERTY_TAG_GROUP_VALUE"]);

        }



      }
    }
    unset($arItem);

    if (!empty($secGroup))
    {
      $objSec = CIBlockSection::GetList(array("SORT" => "ASC",
                                              "NAME" => "ASC"),
                                        array("ACTIVE" => "Y",
                                              "GLOBAL_ACTIVE" => "Y",
                                              "ID" => array_keys($secGroup),
                                              "IBLOCK_ID" => $ibList),
                                        false,
                                        array("ID", "NAME"));
      while($arSec = $objSec->Fetch())
      {
        if (is_array($secGroup[$arSec["ID"]]))
        {
          $arResult["SECTION_GROUP"][$arSec["ID"]] = array_merge($arSec, $secGroup[$arSec["ID"]]);
        }
      }
    }
    
    $this->__component->setResultCacheKeys(array("SET_FILTER", "SEO_DATA"));
  }
?>