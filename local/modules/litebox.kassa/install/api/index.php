<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 23.04.2018
 * Time: 12:12
 */

function isJson($string) { 
	
	if(!(is_string($string) && (is_object(json_decode($string)))))
	{
		$string = json_encode(array("error_json" => $string));
	}
	
	return $string;
}	
 
ob_start("isJson");
 
 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$resLoad = CModule::IncludeModule("litebox.kassa");

$APPLICATION->IncludeComponent(
    "litebox:kassa",
    "",
    [
        'SEF_MODE' => 'Y',
        'SEF_FOLDER' => '/api/',
    ]
);

ob_end_flush();