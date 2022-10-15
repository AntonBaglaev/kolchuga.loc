<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 17/06/16
 * Time: 14:16
 */
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//Foreach($_REQUEST as $zz=>$xx){echo '&'.$zz.'='.$xx;}

global $APPLICATION;
$APPLICATION->IncludeComponent("bitrix:form.result.new", "salon", Array(
    "SEF_MODE" => "N",
    "WEB_FORM_ID" => $_REQUEST['WEB_FORM_ID'],
    "LIST_URL" => "",
    "EDIT_URL" => "",
    "SUCCESS_URL" => "",
    "CHAIN_ITEM_TEXT" => "",
    "CHAIN_ITEM_LINK" => "",
    "IGNORE_CUSTOM_TEMPLATE" => "Y",
    "USE_EXTENDED_ERRORS" => "Y",
    "CACHE_TYPE" => "N",
    "CACHE_TIME" => "3600",
    "SEF_FOLDER" => "/",
    "VARIABLE_ALIASES" => Array()
));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>