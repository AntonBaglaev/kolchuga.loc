<?php

if(strlen($arResult["DATE_ACTIVE_TO"]) > 0)
	$arResult["DISPLAY_DATE_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["DATE_ACTIVE_TO"], CSite::GetDateFormat()));
else
	$arResult["DISPLAY_DATE_ACTIVE_TO"] = "";