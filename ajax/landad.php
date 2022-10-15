<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Main\Application,
	\Bitrix\Main,
    \Bitrix\Main\Localization\Loc as Loc,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Config\Option,
    \Bitrix\Sale\Delivery,
    \Bitrix\Sale\PaySystem,
    \Bitrix\Sale,
    \Bitrix\Sale\Order,
    \Bitrix\Sale\DiscountCouponsManager,
    \Bitrix\Main\Context;


$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
foreach($request as $key=>$vl){
	$requestArr[$key]=$vl;
}

if(!empty($requestArr['blockimetki']) && check_bitrix_sessid())
{
	//$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), 's1');
	$hash=[];
	foreach($requestArr['blockimetki'] as $itemBlock){
		foreach($itemBlock as $item){
			$fields = [
				'PRODUCT_ID' => $item, // ID товара, обязательно
				'QUANTITY' => 1, // количество, обязательно
				/* 'PROPS' => [
					['NAME' => 'Test prop', 'CODE' => 'TEST_PROP', 'VALUE' => 'test value'],
				], */

			];
			$r = \Bitrix\Catalog\Product\Basket::addProduct($fields);
			$hash[$item]='Y';
			if (!$r->isSuccess()) {
				$hash[$item]=$r->getErrorMessages();
				$hash_text[$item]=implode('<br>', $r->getErrorMessages());
			}
		}
	}
	//echo "<pre>";print_r($userId);echo "</pre>";	die;
	
}else{
	$hash_text='Ошибка добавления, попробуйте обновить страницу';
}	
	

	echo json_encode(array(
		//'listorder' => $requestArr,
		//'hash' => $hash,
		'error' => (empty($hash_text) ? 'N':'Y'),
		'error_text' => implode('<br>', $hash_text),
		'info' => 'Тавары добавлены в корзину'
		
	), JSON_UNESCAPED_UNICODE);
	die;
