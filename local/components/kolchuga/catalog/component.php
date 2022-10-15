<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["USE_FILTER"]) && $arParams["USE_FILTER"]=="Y")
{
	$arParams["FILTER_NAME"] = trim($arParams["FILTER_NAME"]);
	if ($arParams["FILTER_NAME"] === '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
		$arParams["FILTER_NAME"] = "arrFilter";
}
else
	$arParams["FILTER_NAME"] = "";

//default gifts
if(empty($arParams['USE_GIFTS_SECTION']))
{
	$arParams['USE_GIFTS_SECTION'] = 'Y';
}
if(empty($arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT'] = 3;
}
if(empty($arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'] = 3;
}
if(empty($arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'] = 3;
}


$smartBase = ($arParams["SEF_URL_TEMPLATES"]["section"]? $arParams["SEF_URL_TEMPLATES"]["section"]: "#SECTION_ID#/");
$arDefaultUrlTemplates404 = array(
	"sections" => "",
	"section" => "#SECTION_ID#/",
	"element" => "#SECTION_ID#/#ELEMENT_ID#/",
	"compare" => "compare.php?action=COMPARE",
	"smart_filter" => $smartBase."filter/#SMART_FILTER_PATH#/apply/"
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
	"SECTION_ID",
	"SECTION_CODE",
	"ELEMENT_ID",
	"ELEMENT_CODE",
	"action",
);

if($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();

	$engine = new CComponentEngine($this);
	if (\Bitrix\Main\Loader::includeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->addGreedyPart("#SMART_FILTER_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}
	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_FOLDER"],
		$arUrlTemplates,
		$arVariables
	);

	if ($componentPage === "smart_filter")
		$componentPage = "section";

	if(!$componentPage && isset($_REQUEST["q"]))
		$componentPage = "search";

	$b404 = false;
	if(!$componentPage)
	{
		$componentPage = "sections";
		$b404 = true;
	}

	if($componentPage == "section")
	{
		if (isset($arVariables["SECTION_ID"]))
			$b404 |= (intval($arVariables["SECTION_ID"])."" !== $arVariables["SECTION_ID"]);
		else
			$b404 |= !isset($arVariables["SECTION_CODE"]);
	}

	//проверка чпу урлов для страниц гладкоствольного оружия
	$explodedUrl = explode('/', $arVariables["SECTION_CODE_PATH"]);
	if(strpos($explodedUrl[2], 'rujie')==true){

        $b404 = 0;
        $componentPage = 'section';
        $arVariables["SECTION_CODE_PATH"] = 'oruzhie/gladkostvolnoe_oruzhie';
        $arVariables["SECTION_ID"] = '17835';
        $arVariables["SECTION_CODE"] = 'gladkostvolnoe_oruzhie';

	}

  if($b404 && CModule::IncludeModule('iblock'))
	{
		$folder404 = str_replace("\\", "/", $arParams["SEF_FOLDER"]);
		if ($folder404 != "/")
			$folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
		if (substr($folder404, -1) == "/")
			$folder404 .= "index.php";

    
		if ($folder404 != $APPLICATION->GetCurPage(true))
		{
    
      if (intval($arParams["EX_FILTER_IBLOCK_ID"]) > 0 &&
          !empty($arVariables["SECTION_CODE_PATH"]) &&
          substr_count($arVariables["SECTION_CODE_PATH"], "/") > 0)
      {  
        
        $oPage = $APPLICATION->GetCurPage();
        $APPLICATION->SetCurPage(preg_replace('/([^\/]+)\/$/i', '', $APPLICATION->GetCurDir())."index.php");
 
        $engine->guessComponentPath(
          $arParams["SEF_FOLDER"],
          $arUrlTemplates,
          $arVariables,
          $APPLICATION->GetCurPage(true)
        );
        
        $APPLICATION->SetCurPage($oPage);

        
        if (intval($arVariables["SECTION_ID"]) > 0)
        {
           $arUrlTemplates["element"] = $arVariables["SECTION_CODE_PATH"]."/#EX_FILTER_ELEMENT#/";
           $engine->guessComponentPath(
             $arParams["SEF_FOLDER"],
             $arUrlTemplates,
             $arVariables
           );
        
           if (isset($arVariables["EX_FILTER_ELEMENT"]) &&
               !empty($arVariables["EX_FILTER_ELEMENT"]))
           {
             $arFF = array("ACTIVE" => "Y",
                           "ACTIVE_DATE" => "Y",
                           "SECTION_GLOBAL_ACTIVE" => "Y",
                           "IBLOCK_ID" => intval($arParams["EX_FILTER_IBLOCK_ID"]),
                           "PROPERTY_CSECTIONS" => $arVariables["SECTION_ID"]);
             
             $arFF[((is_numeric($arVariables["EX_FILTER_ELEMENT"]))? "ID" : "CODE")] = $arVariables["EX_FILTER_ELEMENT"];
            
             if (is_array($exEl = CIBlockElement::GetList(array(),
                                                          $arFF,
                                                          false,
                                                          array("nTopCount" => 1),
                                                          array("ID", "CODE"))->Fetch()))
             {
               $arVariables["EX_FILTER_ELEMENT_ID"] = $exEl["ID"];
               $arVariables["EX_FILTER_ELEMENT_CODE"] = $exEl["CODE"];
               $b404 = false;
               $componentPage = "section";
             }
           }
        }
      }
      
      if ($b404)
      {
        \Bitrix\Iblock\Component\Tools::process404(
          ""
          ,($arParams["SET_STATUS_404"] === "Y")
          ,($arParams["SET_STATUS_404"] === "Y")
          ,($arParams["SHOW_404"] === "Y")
          ,$arParams["FILE_404"]
        );
      }
      
		}
	}

	CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates,
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
}
else
{
	$arVariables = array();

	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	$arCompareCommands = array(
		"COMPARE",
		"DELETE_FEATURE",
		"ADD_FEATURE",
		"DELETE_FROM_COMPARE_RESULT",
		"ADD_TO_COMPARE_RESULT",
		"COMPARE_BUY",
		"COMPARE_ADD2BASKET",
	);

	if(isset($arVariables["action"]) && in_array($arVariables["action"], $arCompareCommands))
		$componentPage = "compare";
	elseif(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["SECTION_ID"]) && intval($arVariables["SECTION_ID"]) > 0)
		$componentPage = "section";
	elseif(isset($arVariables["SECTION_CODE"]) && strlen($arVariables["SECTION_CODE"]) > 0)
		$componentPage = "section";
	elseif(isset($_REQUEST["q"]))
		$componentPage = "search";
	else
		$componentPage = "sections";

	$arResult = array(
		"FOLDER" => "",
		"URL_TEMPLATES" => Array(
			"section" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["SECTION_ID"]."=#SECTION_ID#",
			"element" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["SECTION_ID"]."=#SECTION_ID#"."&".$arVariableAliases["ELEMENT_ID"]."=#ELEMENT_ID#",
			"compare" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["action"]."=COMPARE",
		),
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
}

$this->IncludeComponentTemplate($componentPage);
?>