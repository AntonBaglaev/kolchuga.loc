<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
use Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
use \Bitrix\Sale\Internals\CompanyTable;

Loader::includeModule("highloadblock");
Loader::includeModule("iblock");
Loader::includeModule("catalog");

$paramsCompany = array(
	'select' => array('ID','NAME'),
	
);
$dbResultListCompany = CompanyTable::getList($paramsCompany);
$name_company=[];
while ($resultCompany = $dbResultListCompany->Fetch()){
	$name_company[$resultCompany['ID']]=$resultCompany['NAME'];
}

$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)

$rsData = $entity_data_class::getList(array(
	"select" => array('*'), //выбираем все поля
	"filter" => array(
		">=UF_OPERATIONDATE" => date("d.m.Y H:i:s", mktime(0, 0, 0, date('m'), date('d')-10, date('Y'))), 
		'UF_ORDERSTATE'=>array('Approved','PartialDelayed')
	),
	"order" => array("ID" => "DESC"),
));

   $xml_data_arr=[];
$massa=[];
$podmena_guid=[];
while ($arItem = $rsData->Fetch()) {
	$orderN=(!empty($arItem['UF_ERROR_ORDER_NUM']) ? $arItem['UF_ERROR_ORDER_NUM']:$arItem['UF_ORDER_ID_SITE']);
	if(empty($orderN)){continue;}
	if(in_array($orderN,$massa)){continue;}
	
	
	$dataord=$arItem['UF_OPERATIONDATE']->format("Ymd");
	
	
	
	
	
	$massa[]=$orderN;
	$order = \Bitrix\Sale\Order::load($orderN);
	
	/* if(!empty($arItem['UF_COMPANY'])){
		$xml_data_arr[$dataord][$orderN]['company']=$arItem['UF_COMPANY'];
	}else{ */
		$company_id=$order->getField('COMPANY_ID');
		if(empty($company_id)){
			$arPaySys = \CSalePaySystem::GetByID($arItem['UF_PAYSYSTEMID']);
			$xml_data_arr[$dataord][$orderN]['company']=$arPaySys["PSA_NAME"];
		}else{
			
			$name_company=[
				1=>'Ассист - АО «Фирма «Кольчуга»',
				2=>'Ассист - ООО "Кольчуга"',
				3=>'Ассист - "Охотник -рыболов-турист"',
				4=>'Ассист - "Охотник на Тверской"',
				5=>'Ассист - ООО "Смарт Систем"',
			];
			$xml_data_arr[$dataord][$orderN]['company']=$name_company[$company_id];
		}
	//}
	
	$xml_data_arr[$dataord][$orderN]['card']=$arItem['UF_MEANNUMBER'];
	$xml_data_arr[$dataord][$orderN]['email']=$arItem['UF_EMAIL'];
	
	$xml_data_arr[$dataord][$orderN]['amount']=$order->getPrice();
	$xml_data_arr[$dataord][$orderN]['delivery_price']=$order->getDeliveryPrice();
	$xml_data_arr[$dataord][$orderN]['is_sert']='';
	$xml_data_arr[$dataord][$orderN]['type_pay']=$arItem['UF_ECOM_MPOS'];
	
		
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
		
			$res3 = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				array('IBLOCK_ID' => 40,'ID'=>$basketItem->getProductId()),				
				false,
				false,
				array('ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID')
			);

			while($sto = $res3->Fetch()){	
				if($sto["IBLOCK_SECTION_ID"]==18130){
					$xml_data_arr[$dataord][$orderN]['is_sert']='PS';
					$podmena_guid[$basketItem->getField('PRODUCT_XML_ID')]='38eacf05-b49d-11e3-9ed3-002590c1b0f4';
				}
			}

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
	$xml_data_arr[$dataord][$orderN]['items']=[];
		
	if(!empty($charge['chequeitem'])){
		
		foreach($charge['chequeitem'] as $vl){
			
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['product_id']=$vl['PRODUCT_ID'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['name']=$vl['NAME'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['price']=$vl['PRICE'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['quantity']=$vl['QUANTITY'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['amount']=$vl['AMOUNT'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['tax']=$vl['TAX'];
			$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['tax_price']=$vl['AMOUNT']*$vl['TAX']/120;
			
			if(!empty($vl['MARKING_CODE'])){
				//$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['marking_code']=$vl['MARKING_CODE'];
				$xml_data_arr[$dataord][$orderN]['items'][$vl['PRODUCT_GUID']]['gtin']=$vl['GS1CODE'];				
			}		
			
		}				
	}
		
	
	$propertyCollection = $order->getPropertyCollection();
	$ar = $propertyCollection->getArray();
	foreach($ar['properties'] as $vl){
		if($vl['CODE']=='FIO'){$xml_data_arr[$dataord][$orderN]['fio']=$vl['VALUE'][0];}
		if($vl['CODE']=='PHONE'){$xml_data_arr[$dataord][$orderN]['phone']=$vl['VALUE'][0];}		
	}
	$xml_data_arr[$dataord][$orderN]['user_id']=$order->getUserId();
	
}
unset($order);
//$xml.='</orders>';
//echo "<pre>";print_r($xml_data_arr);echo "</pre>";die;

foreach($xml_data_arr as $data=>$orders){
	$dom_xml = new DOMDocument('1.0', 'UTF-8');
	$root = $dom_xml->createElement('orders');
	$dom_xml->appendChild($root);

	foreach($orders as $order_id=>$order){
		$zakaz = $dom_xml->createElement('order');
		$root->appendChild($zakaz);
		
		$name = $dom_xml->createElement('number', $order_id);
		$zakaz->appendChild($name);
		
		foreach($order as $order_key=>$order_val){
			if($order_key!='items'){
				$name = $dom_xml->createElement($order_key, $order_val);
				$zakaz->appendChild($name);
			}else{
				$items = $dom_xml->createElement($order_key);
				$zakaz->appendChild($items);
				
				foreach($order_val as $guid=>$tovar){
					$item = $dom_xml->createElement('item');
					$items->appendChild($item);
					
					if(!empty($podmena_guid[$guid])){
						$name = $dom_xml->createElement('guid_old',$guid);
						$item->appendChild($name);
						$name = $dom_xml->createElement('guid',$podmena_guid[$guid]);
						$item->appendChild($name);
					}else{
						$name = $dom_xml->createElement('guid',$guid);
						$item->appendChild($name);
					}
					
					foreach($tovar as $tovar_key=>$tovar_val){
						$name = $dom_xml->createElement($tovar_key,$tovar_val);
						$item->appendChild($name);
					}
				}
			}
		}
	}
	$dom_xml->encoding = 'utf-8';
	$path=$_SERVER["DOCUMENT_ROOT"]."/upload/xml_order/".$data.".xml";
	$dom_xml->save($path);

}
echo 'файлы обновлены ';
echo time();