<?php

foreach($arResult["ITEMS"] as $key => $arItem)
{
	if(strlen($arItem["DATE_ACTIVE_TO"]) > 0)
		$arResult["ITEMS"][$key]["DISPLAY_DATE_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["DATE_ACTIVE_TO"], CSite::GetDateFormat()));
	else
		$arResult["ITEMS"][$key]["DISPLAY_DATE_ACTIVE_TO"] = "";
}