<?
  if (!defined("B_PROLOG_INCLUDED") ||
      B_PROLOG_INCLUDED !== true)
  {
    die();
  }

  $arTemplateParameters = array(
    "ELEMENT_ID" => array(
      "NAME" => GetMessage("CP_ELEMENT_ID"),
      "TYPE" => "STRING"
    ),
    "ELEMENT_CODE" => array(
      "NAME" => GetMessage("CP_ELEMENT_CODE"),
      "TYPE" => "STRING"
    ),
    "CATALOG_FILTER_NAME" => array(
      "NAME" => GetMessage("CP_FILTER_NAME"),
      "TYPE" => "STRING"
    )
  );
?>