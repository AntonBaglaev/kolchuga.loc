<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Скидочные карты");
?><?$APPLICATION->IncludeComponent(
	'datainlife:coupon.register',
	'',
	array(
		'IBLOCK_ID' => 44,
		'EVENT' => 'SET_COUPON_STATUS'
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>