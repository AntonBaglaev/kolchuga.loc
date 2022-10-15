<?

set_time_limit(800);
ini_set('memory_limit', '12192M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
die;
$xml0 = '
<?xml version="1.0" encoding="UTF-8"?>
<order>
	<number>15797</number> - номер заказа
	<items>
		<item>
			<name>Сапоги Monte Sport 1550 ж 37</name> - наименование товара
			<guid>53b44550-fca3-11e1-be18-00025553e9f9</guid> - GUID товара
			<store>dslkfjasklfjsdlaf-sdafskadjlf-adslfkjdskl-dsaflf1</store> - склад
			<kizs>
				<kiz>30121212121212121212123</kiz> - маркировочные коды
				<kiz>200121212121212121212125</kiz>					
			</kizs>
		</item>
		<item>
			<name>ботинки 2</name>
			<guid>dslkfjasklfjsdlaf-sdafskadjlf-adslfkjdskl-dsaflf2</guid>
			<kizs>
				<kiz>00121212121212121212124</kiz>
				<kiz>200121212121212121212125</kiz>					
			</kizs>
		</item>
	</items>
</order>
';
$xml = '
<?xml version="1.0" encoding="UTF-8"?>
<order>
	<number>15798</number>
	<items>
		<item>
			<name>Сапоги Monte Sport 1550 ж 37</name>
			<guid>53b44550-fca3-11e1-be18-00025553e9f9</guid>
			<store>dslkfjasklfjsdlaf-sdafskadjlf-adslfkjdskl-dsaflf1</store>
			<kizs>
				<kiz>30121212121212121212123</kiz>
				<kiz>200121212121212121212125</kiz>			
			</kizs>
		</item>				
	</items>
</order>
';
// урл запроса https://www.kolchuga.ru/api/marker2.php

/*
// отправляем запрос - $responce сохраняет ответ
$response = http_post_curl('text/xml', $xml);

if($response === FALSE) {
    return FALSE;
}

function http_post_curl($content_type, $post_data)
{
    $url = 'https://www.kolchuga.ru/api/marker2.php';
    // init curl
    $curl = curl_init($url);
    if(!$curl) {
        $this->_add_error('Failed to init cURL');
        return FALSE;
    }
    
    // curl options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    
    $http_headers = array(
        'Content-type: ' . $content_type
        );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    
    $response = curl_exec($curl);
    if($response === FALSE) {
        return FALSE;
    }
    
    return $response;
}
*/
function ardt($massiv){
	
				$result=[];
				foreach($massiv['#'] as $key=>$value){
					if(empty($value[1])){
						if(!is_array($value[0]['#'])){
							$result[$key]=$value[0]['#'];
						}else{
							$result[$key]=ardt($value[0]);
						}
					}else{
						foreach($value as $key2=>$item){
							if(is_array($item['#'])){
								$result[$key][$key2]=ardt($item);
							}else{
								$result[$key][$key2]=$item['#'];
							}
						}
					}
					
				}
				
				return $result;
			}
			
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
			$objXML = new CDataXML();
			$objXML->LoadString($xml);
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($objXML, true), FILE_APPEND | LOCK_EX);
			$arData = $objXML->GetArray();
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arData, true), FILE_APPEND | LOCK_EX);
			
			$arResult=ardt($arData['order']);
			//echo "<pre>";print_r($arResult);echo "</pre>";
			
if($arResult['number']>0){
	array_map('CModule::IncludeModule', ['iblock', 'catalog', 'sale']); 
	
	$massa=[];
	foreach($arResult['items'] as $key=>$aritem){
		if(!empty($aritem[0])){			
			foreach($item as $val){
				echo "<pre>";print_r($val);echo "</pre>";
				/* $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('XML_ID' => $val['guid']), false, false, Array('IBLOCK_ID','ID'));
				$obEl = $dbEl->Fetch();
				echo "<pre>";print_r($obEl);echo "</pre>"; */
				
			if(is_array($val['kizs']['kiz'])){
				$massa[$val['guid']]=$val['kizs']['kiz'];
			}else{
				$massa[$val['guid']][]=$val['kizs']['kiz'];
			}
			}
		}else{
			echo "<pre>";print_r($aritem);echo "</pre>";
			/* $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('XML_ID' => $aritem['guid']), false, false, Array('IBLOCK_ID','ID'));
				$obEl = $dbEl->Fetch();
				echo "<pre>";print_r($obEl);echo "</pre>"; */
			if(is_array($aritem['kizs']['kiz'])){
				$massa[$aritem['guid']]=$aritem['kizs']['kiz'];
			}else{
				$massa[$aritem['guid']][]=$aritem['kizs']['kiz'];
			}
		}
	}
	echo "<pre>";print_r($massa);echo "</pre>";
	
	
	$order = \Bitrix\Sale\Order::load($arResult['number']);
	$shipmentCollection = $order->getShipmentCollection();
	$order_save='N';
	foreach($shipmentCollection as $shipment)
	{
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
		
			$tmp_row=[];
		
			$guidInBasket=$basketItem->getField('PRODUCT_XML_ID');
			
			if(!empty($massa[$guidInBasket])){
				$collection = $item->getShipmentItemStoreCollection();
				echo count($collection);
				if(count($collection)>0){
					foreach ($collection as $kluch=>$itemstore){
						//echo "<pre>";print_r($kluch);echo "</pre>";
						$tmp_row['marking_code']=$itemstore->getMarkingCode();
						//echo "<pre>";print_r($tmp_row);echo "</pre>";
						/* $tmp_row['gs1code']=base64_encode($tmp_row['marking_code']);//GS1 DataMatrix/"Честный Знак" код маркировки товара   */
						
						if(empty($tmp_row['marking_code'])){	
							echo "<pre>";print_r($massa[$guidInBasket][$kluch]);echo "</pre>";
							$itemstore->setFields([ 'MARKING_CODE' => $massa[$guidInBasket][$kluch] ]);
							$order_save='Y';
						}
					}
				}else{
					foreach($massa[$guidInBasket] as $elMarker){
						echo "<pre>";print_r($elMarker);echo "</pre>";
						$itemstore = $collection->createItem($item->getBasketItem());    
						$itemstore->setFields([ 'MARKING_CODE' => $elMarker, 'QUANTITY'=>1 ]);
						$order_save='Y';						
					}
				}
			}
		}
		
	}
	if($order_save=='Y'){
		$r = $order->save();
		if (!$r->isSuccess())
		{
			var_dump($r->getErrorMessages());
		}
	}else{
		echo 'order_save = '.$order_save;
	}
}			