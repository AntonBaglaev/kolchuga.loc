<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
use Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

Loader::includeModule("highloadblock");

//if($_REQUEST['sessid']==bitrix_sessid()){

$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)
//if($val['UF_ORDERSTATE']=='Approved'){echo 'Оплачен';}
$rsData = $entity_data_class::getList(array(
	"select" => array('*'), //выбираем все поля
	"filter" => array(
		">=UF_OPERATIONDATE" => date("d.m.Y H:i:s", mktime(0, 0, 0, date('m'), date('d')-10, date('Y'))), 
		'UF_ORDERSTATE'=>'Approved'
	),	
));
   $xml_data=[];
   $xml_data_arr=[];
$massa=[];
//$xml='<orders>'."\n";
while ($arItem = $rsData->Fetch()) {
	$orderN=(!empty($arItem['UF_ERROR_ORDER_NUM']) ? $arItem['UF_ERROR_ORDER_NUM']:$arItem['UF_ORDER_ID_SITE']);
	if(in_array($orderN,$massa)){continue;}
	
	
	$dataord=$arItem['UF_OPERATIONDATE']->format("Ymd");
	if(!isset($xml_data_arr[$dataord])){$xml_data_arr[$dataord]=[];}
	if(empty($xml_data[$dataord])){$xml_data[$dataord]='<orders>'."\n";}
	//echo "<pre>";print_r($arItem);echo "</pre>";die;
	
	$xml_data[$dataord].='<order>'."\n";
	//$massa[]=$arItem['UF_ORDER_ID_SITE'];
	
	
	$massa[]=$orderN;
	$xml_data[$dataord].='<number>';$xml_data[$dataord].=$orderN;	$xml_data[$dataord].='</number>'."\n";
	$xml_data[$dataord].='<company>';
	if(!empty($arItem['UF_COMPANY'])){
		$xml_data[$dataord].=$arItem['UF_COMPANY'];
	}else{
		$arPaySys = \CSalePaySystem::GetByID($arItem['UF_PAYSYSTEMID']);
		$xml_data[$dataord].=$arPaySys["PSA_NAME"];
	}
	$xml_data[$dataord].='</company>'."\n";
	
	$xml_data[$dataord].='<card>';$xml_data[$dataord].=$arItem['UF_MEANNUMBER'];$xml_data[$dataord].='</card>'."\n";
	$xml_data[$dataord].='<email>';$xml_data[$dataord].=$arItem['UF_EMAIL'];$xml_data[$dataord].='</email>'."\n";
		
	$order = \Bitrix\Sale\Order::load($orderN);
	
	$xml_data[$dataord].='<amount>';$xml_data[$dataord].=$order->getPrice();$xml_data[$dataord].='</amount>'."\n";
	$xml_data[$dataord].='<delivery_price>';$xml_data[$dataord].=$order->getDeliveryPrice();$xml_data[$dataord].='</delivery_price>'."\n";
	
	$charge=[];
	
	$shipmentCollection = $order->getShipmentCollection();
	foreach($shipmentCollection as $shipment)
	{
		$shipment_id = $shipment->getId();

		//пропускаем системные
		if ($shipment->isSystem())
		continue;

		//получаем Коллекцию Товаров в Корзине каждой Отгрузки
		$shipmentItemCollection = $shipment->getShipmentItemCollection();
		
		foreach($shipmentItemCollection as $item)
		{
			//объект Товара в корзине Отгрузки
			$basketItem = $item->getBasketItem();

			//не учитываем товары, которые нельзя купить или которые отложены
			if (!$basketItem->canBuy() || $basketItem->isDelay())
			continue;

			$tmp_row = [
				'PRODUCT_GUID'=> $basketItem->getField('PRODUCT_XML_ID'), //Код товара
				"PRODUCT_ID"=>$basketItem->getProductId(),
				"NAME"=>$basketItem->getField('NAME'), //Наименование
				"PRICE"=>$basketItem->getPrice(), //Цена
				"QUANTITY"=>$basketItem->getQuantity(), //Количество            
				"AMOUNT"=>$basketItem->getFinalPrice(), //сумма позиции = Количество * Цена
				"TAX"=>'20', //Налог   
				'MARKING_CODE_GROUP' => $basketItem->getMarkingCodeGroup(),              
			];
			
			if(!empty($tmp_row['MARKING_CODE_GROUP'])){
				//объект Складской инфы в корзине Отгрузки
				$collection = $item->getShipmentItemStoreCollection(); 
				foreach ($collection as $itemstore){
					$tmp_row['MARKING_CODE']=$itemstore->getMarkingCode();
					$tmp_row['GS1CODE']=base64_encode($tmp_row['MARKING_CODE']);//GS1 DataMatrix/"Честный Знак" код маркировки товара  
				}
			}			
			$charge['chequeitem'][] = $tmp_row;			
		}
	}
		$xml_data[$dataord].='<items>'."\n";
	if(!empty($charge['chequeitem'])){
		$xml_data[$dataord].='<item>'."\n";
		foreach($charge['chequeitem'] as $vl){
			$xml_data[$dataord].='<guid>';$xml_data[$dataord].=$vl['PRODUCT_GUID'];$xml_data[$dataord].='</guid>'."\n";
			$xml_data[$dataord].='<product_id>';$xml_data[$dataord].=$vl['PRODUCT_ID'];$xml_data[$dataord].='</product_id>'."\n";
			$xml_data[$dataord].='<name>';$xml_data[$dataord].=$vl['NAME'];$xml_data[$dataord].='</name>'."\n";
			$xml_data[$dataord].='<price>';$xml_data[$dataord].=$vl['PRICE'];$xml_data[$dataord].='</price>'."\n";
			$xml_data[$dataord].='<quantity>';$xml_data[$dataord].=$vl['QUANTITY'];$xml_data[$dataord].='</quantity>'."\n";
			$xml_data[$dataord].='<amount>';$xml_data[$dataord].=$vl['AMOUNT'];$xml_data[$dataord].='</amount>'."\n";
			$xml_data[$dataord].='<tax>';$xml_data[$dataord].=$vl['TAX'];$xml_data[$dataord].='</tax>'."\n";
			$xml_data[$dataord].='<tax_price>';$xml_data[$dataord].=$vl['AMOUNT']*$vl['TAX']/120;$xml_data[$dataord].='</tax_price>'."\n";
			if(!empty($vl['MARKING_CODE'])){
				$xml_data[$dataord].='<marking_code>';$xml_data[$dataord].=$vl['MARKING_CODE'];$xml_data[$dataord].='</marking_code>'."\n";
				$xml_data[$dataord].='<gtin>';$xml_data[$dataord].=$vl['GS1CODE'];$xml_data[$dataord].='</gtin>'."\n";
			}
			
		}
		
		$xml_data[$dataord].='</item>'."\n";
	}
		$xml_data[$dataord].='</items>'."\n";
	
	$propertyCollection = $order->getPropertyCollection();
	$ar = $propertyCollection->getArray();
	foreach($ar['properties'] as $vl){
		if($vl['CODE']=='FIO'){$xml_data[$dataord].='<fio>';$xml_data[$dataord].=$vl['VALUE'][0];$xml_data[$dataord].='</fio>'."\n";}
		if($vl['CODE']=='PHONE'){$xml_data[$dataord].='<phone>';$xml_data[$dataord].=$vl['VALUE'][0];$xml_data[$dataord].='</phone>'."\n";}
	}
	$xml_data[$dataord].='<user_id>';$xml_data[$dataord].=$order->getUserId();$xml_data[$dataord].='</user_id>'."\n";
	
	//echo "<pre>";print_r($ar);echo "</pre>";
	$xml_data[$dataord].='</order>'."\n";
}
//$xml.='</orders>';
//echo "<pre>";print_r($xml_data);echo "</pre>";die;

foreach($xml_data as $data=>$xml){
	$xml.='</orders>';
$dom_xml= new DomDocument('1.0', 'UTF-8');
$dom_xml->loadXML($xml);
$dom_xml->encoding = 'utf-8';
$path=$_SERVER["DOCUMENT_ROOT"]."/upload/xml_order/".$data.".xml";
$dom_xml->save($path);
}
echo 'файлы обновлены';
//echo 'файл обновлен <a href="/upload/xml_order/'.date('Ymd').'.xml" download>скачать</a>';
/* }else{
	echo 'error';
} */