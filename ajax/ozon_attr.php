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

if(!empty($requestArr['query']))
{
	
$data_js=[];
$data_js[]=['value'=>'Не выбрано','id'=>0];
	Loader::includeModule('highloadblock');
			$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(9)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
			$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
			$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)
			
			if($requestArr['query']==='seeall'){
				$rsData = $entity_data_class::getList(array(
				
					"select" => array('UF_ID_VALUE','UF_VALUE'), //выбираем поля
					"filter" => array("UF_SECTION" => $requestArr['attr'], "UF_ID_SPRAVOCHIKA" => $requestArr['ida']),	
					"limit" =>5000
				));
			}else{
				$rsData = $entity_data_class::getList(array(
					
					"select" => array('UF_ID_VALUE','UF_VALUE'), //выбираем поля
					"filter" => array("UF_SECTION" => $requestArr['attr'], "UF_ID_SPRAVOCHIKA" => $requestArr['ida'], "UF_VALUE" => $requestArr['query']."%" ),				
				));
			}
			while($arData = $rsData->Fetch()){
				$data_js[]=['value'=>$arData['UF_VALUE'],'id'=>$arData['UF_ID_VALUE']];
			}
	
	
	echo json_encode(["suggestions"=>$data_js], JSON_UNESCAPED_UNICODE);	
}