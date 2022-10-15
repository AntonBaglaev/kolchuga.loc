<?
if ($_SERVER['REMOTE_ADDR']=="91.219.103.184") {
	/*var_dump($arResult['ERROR_MESSAGE']["MESSAGE"]);*/
	$arResult['ERROR_MESSAGE']["MESSAGE"] = str_replace("логин", "E-mail", $arResult['ERROR_MESSAGE']["MESSAGE"]);
}
?>