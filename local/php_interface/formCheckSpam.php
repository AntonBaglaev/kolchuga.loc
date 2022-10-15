<?
if (!defined("B_PROLOG_INCLUDED") ||
		B_PROLOG_INCLUDED !== true)
{
	die();
}

AddEventhandler("form", "onBeforeResultAdd",  "cSpamOnBeforeResultAdd");
function cSpamOnBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES)
{
	if (isset($_REQUEST["CS_SESSION_FORM"]) &&
			$_REQUEST["CS_SESSION_FORM"] == "ExSess".$WEB_FORM_ID)
	{
		return true;
	}
	$GLOBALS['APPLICATION']->ThrowException('Вы не прошли проверку на робота'); 
	return false;
}
?>