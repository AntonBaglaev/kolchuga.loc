<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 20/10/15
 * Time: 16:15
 */

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if( !empty($_REQUEST['product'])  ){
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");



$cls= new \Kolchuga\StoreList();
$aa=$cls->getList();
$osn=$cls->getListByBasket([0=>['PRODUCT_ID'=>intval($_REQUEST['product'])]]);
//echo "<pre>";print_r($osn);echo "</pre>";


foreach($osn[0]['SET_SKLAD'] as $idstore=> $store){
	if($store['PRODUCT_ID'][$_REQUEST['product']]["AMOUNT"]>0 && $store["SHOW_IN_LIST_ID"]==298880){
		?><option value="<?=$store['NAME']?>"><?=$store['NAME']?></option><?
	}
}

$a116=[];
foreach($aa['STORE_LIST_ALL'] as $vl){
	if($vl['ID']==116){$a116=$vl;}
}
if($osn[0]['SET_SKLAD'][631125]['PRODUCT_ID'][$_REQUEST['product']]["AMOUNT"]>0  && empty($osn[0]['SET_SKLAD'][116]) && $a116['PROPERTY_SHOW_IN_LIST_ENUM_ID']==298880){
			?><option value="<?=$a116['NAME']?>(<?=$osn[0]['SET_SKLAD'][631125]['NAME']?>)"><?=$a116['NAME']?>(<?=$osn[0]['SET_SKLAD'][631125]['NAME']?>)</option><?
		}
}