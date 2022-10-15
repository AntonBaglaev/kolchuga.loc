<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!empty($templateData))
{
	if($templateData === "Max")
		$size = "max";
	else if($templateData === "Min")
		$size = "min";

	$APPLICATION->SetPageProperty("sizeTitle", $size);
}