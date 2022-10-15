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
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****requestArr******\n".print_r($requestArr, true), FILE_APPEND | LOCK_EX);
$arrayProp=[];
foreach($requestArr as $key=>$vl){
	if (strpos($key, "ORDER_PROP_") !== false){
		$idprop=str_replace('ORDER_PROP_','',$key);
		$arrayProp[$idprop]=$vl;
	}
}

function getPropertyByCode($propertyCollection, $code)  {
    foreach ($propertyCollection as $property)
    {
        if($property->getField('CODE') == $code)
            return $property;
    }
}
function generateUserData1($userProps = array())
	{
		global $USER;

		$userEmail = isset($userProps['EMAIL']) ? trim((string)$userProps['EMAIL']) : '';
		$newLogin = $userEmail;

		if (empty($userEmail))
		{
			$newEmail = false;
			$normalizedPhone = NormalizePhone((string)$userProps['PHONE'], 3);

			if (!empty($normalizedPhone))
			{
				$newLogin = $normalizedPhone;
			}
		}
		else
		{
			$newEmail = $userEmail;
		}

		if (empty($newLogin))
		{
			$newLogin = randString(5).mt_rand(0, 99999);
		}

		$pos = strpos($newLogin, '@');
		if ($pos !== false)
		{
			$newLogin = substr($newLogin, 0, $pos);
		}

		if (strlen($newLogin) > 47)
		{
			$newLogin = substr($newLogin, 0, 47);
		}

		$newLogin = str_pad($newLogin, 3, '_');

		$dbUserLogin = CUser::GetByLogin($newLogin);
		if ($userLoginResult = $dbUserLogin->Fetch())
		{
			do
			{
				$newLoginTmp = $newLogin.mt_rand(0, 99999);
				$dbUserLogin = CUser::GetByLogin($newLoginTmp);
			}
			while ($userLoginResult = $dbUserLogin->Fetch());

			$newLogin = $newLoginTmp;
		}

		$newName = '';
		$newLastName = '';
		$payerName = isset($userProps['PAYER']) ? trim((string)$userProps['PAYER']) : '';

		if (!empty($payerName))
		{
			$arNames = explode(' ', $payerName);

			if (isset($arNames[1]))
			{
				$newName = $arNames[1];
				$newLastName = $arNames[0];
			}
			else
			{
				$newName = $arNames[0];
			}
		}

		$groupIds = [];
		$defaultGroups = Option::get('main', 'new_user_registration_def_group', '');

		if (!empty($defaultGroups))
		{
			$groupIds = explode(',', $defaultGroups);
		}

		$arPolicy = $USER->GetGroupPolicy($groupIds);

		$passwordMinLength = (int)$arPolicy['PASSWORD_LENGTH'];
		if ($passwordMinLength <= 0)
		{
			$passwordMinLength = 6;
		}

		$passwordChars = array(
			'abcdefghijklnmopqrstuvwxyz',
			'ABCDEFGHIJKLNMOPQRSTUVWXYZ',
			'0123456789',
		);
		if ($arPolicy['PASSWORD_PUNCTUATION'] === 'Y')
		{
			$passwordChars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
		}

		$newPassword = $newPasswordConfirm = randString($passwordMinLength + 2, $passwordChars);

		return array(
			'NEW_EMAIL' => $newEmail,
			'NEW_LOGIN' => $newLogin,
			'NEW_NAME' => $newName,
			'NEW_LAST_NAME' => $newLastName,
			'NEW_PASSWORD' => $newPassword,
			'NEW_PASSWORD_CONFIRM' => $newPasswordConfirm,
			'GROUP_ID' => $groupIds
		);
	}

class ItemStore
{
	public $options = [
	    	
    ];
	
	function __construct($array=array())
    {
		\Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('catalog');
        		
        $this->respons = ['resonse'=>'error','info'=>'']; 
		$this->requestArr = $array;		
		$this->resultArr = [];		
    }
	
    public function getArray(){
        return $this->requestArr;
    }
	
	public function getResult(){
        return $this->resultArr;
    }
	
	public function getOption(){
        return $this->options;
    }
	public function setOption($array){
		if(empty($array)){return false;}
		if(!is_array($array)){
			$this->options[]=$array;
		}else{
			foreach($array as $key=>$val){
				$this->options[$key]=$val;
			}
		}        
    }
	
	public function getStoreList(){
		$iblock_store=$this->options['STORE_IBLOCK_ID'];
		if(empty($iblock_store)){$this->respons['info']='STORE_IBLOCK_ID is empty'; return $this->respons;}
		$res = \CIBlockElement::GetList(
			array('id' => 'asc'),
			array('IBLOCK_ID' => $iblock_store),
			false,
			false,
			array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_stores','PROPERTY_show_in_list')
		);

		while($store = $res->Fetch()){		
			$this->resultArr['STORE_LIST_ALL'][] = $store;
		}		
	}
	
	public function getStorebyProduct($PRODUCT_ID=0){
		if(intval($PRODUCT_ID)<1){$this->respons['info']='PRODUCT_ID is empty'; return $this->respons;}
		if(empty($this->resultArr['STORE_LIST_ALL'])){$this->respons['info']='STORE_LIST_ALL is empty'; return $this->respons;}
		
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$PRODUCT_ID,'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
			'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
		));
		while($arStoreProduct=$rsStoreProduct->fetch())
		{
			foreach($this->resultArr['STORE_LIST_ALL'] as $kl=>$ckld){								
				if(in_array($arStoreProduct['STORE_XML_ID'],$ckld['PROPERTY_STORES_VALUE'] )){					
					$this->resultArr['STORE_BY_PRODUCT'][$PRODUCT_ID][]=['ID'=>$ckld['ID'], 'NAME'=>$ckld['NAME'], 'ALL'=>$arStoreProduct];					
				}		
			}
		}
		
	}
	
}
if(!empty($requestArr['PERSON_TYPE']) && $requestArr['is_ajax_post']=='Y' && check_bitrix_sessid()){
	$listOrder=[];
	
	\Bitrix\Main\Loader::includeModule("iblock");
	\Bitrix\Main\Loader::includeModule("catalog");
	\Bitrix\Main\Loader::includeModule("sale");
	
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****itogo******\n".print_r($requestArr, true), FILE_APPEND | LOCK_EX);
	global $USER;
	if(!is_object($USER)){
		$USER = new CUser();
	}
	$userId=$USER->GetID();
	
	if($userId=='13635'){
				echo json_encode(array(
				'listorder' => 'error',
				'hash' => 'none',
				'redirect' => '/personal/cart/?order=error',
			), JSON_UNESCAPED_UNICODE);
			die;
		}
	
	if(empty($userId)){	
		$userProps = Sale\PropertyValue::getMeaningfulValues($requestArr['PERSON_TYPE'], $arrayProp);
		
		if($userProps['EMAIL']=='csemckina@yandex.ru'){
				echo json_encode(array(
				'listorder' => 'error',
				'hash' => 'none',
				'redirect' => '/personal/cart/?order=error',
			), JSON_UNESCAPED_UNICODE);
			die;
		}
		
		if ($userProps['EMAIL'] != '' || $userProps['PHONE'] != '')	{
			$existingUserId = 0;

				if ($userProps['EMAIL'] != '')
				{
					$res = Bitrix\Main\UserTable::getRow(array(
						'filter' => array(
							'=ACTIVE' => 'Y',
							'=EMAIL' => $userProps['EMAIL']
						),
						'select' => array('ID')
					));
					if (isset($res['ID']))
					{
						$existingUserId = (int)$res['ID'];
					}
				}

				if ($existingUserId == 0 && !empty($userProps['PHONE']))
				{
					$normalizedPhone = NormalizePhone((string)$userProps['PHONE'], 3);
					//$normalizedPhone = $this->getNormalizedPhone($userProps['PHONE']);

					if (!empty($normalizedPhone))
					{
						$res = Bitrix\Main\UserTable::getRow(array(
							'filter' => array(
								'ACTIVE' => 'Y',
								array(
									'LOGIC' => 'OR',
									'=PERSONAL_PHONE' => $normalizedPhone,
									'=PERSONAL_MOBILE' => $normalizedPhone
								)
							),
							'select' => array('ID')
						));
						if (isset($res['ID']))
						{
							$existingUserId = (int)$res['ID'];
						}
					}
				}

				if ($existingUserId > 0)
				{
					$userId = $existingUserId;				
				}
				else
				{
					//$userId = $this->registerAndLogIn($userProps);
					$userData = generateUserData1($userProps);
					$normalizedPhone = NormalizePhone((string)$userProps['PHONE'], 3);

						$fields = [
							'LOGIN' => $userData['NEW_LOGIN'],
							'NAME' => $userData['NEW_NAME'],
							'LAST_NAME' => $userData['NEW_LAST_NAME'],
							'PASSWORD' => $userData['NEW_PASSWORD'],
							'CONFIRM_PASSWORD' => $userData['NEW_PASSWORD_CONFIRM'],
							'EMAIL' => $userData['NEW_EMAIL'],
							'GROUP_ID' => $userData['GROUP_ID'],
							'ACTIVE' => 'Y',
							'LID' => 's1',
							'PERSONAL_PHONE' => isset($userProps['PHONE']) ? $normalizedPhone : '',
							'PERSONAL_ZIP' => isset($userProps['ZIP']) ? $userProps['ZIP'] : '',
							'PERSONAL_STREET' => isset($userProps['ADDRESS']) ? $userProps['ADDRESS'] : '',
						];

						$user = new CUser;
						$addResult = $user->Add($fields);
						$userId = intval($addResult);
						$USER->Authorize($addResult);

							
						
				}
		}
	}
	
	if($userId=='13635'){
				echo json_encode(array(
				'listorder' => 'error',
				'hash' => 'none',
				'redirect' => '/personal/cart/?order=error',
			), JSON_UNESCAPED_UNICODE);
			die;
		}
	
	if (empty($userId))
		{
			$userId = CSaleUser::GetAnonymousUserID();
		}
	//echo "<pre>";print_r($userId);echo "</pre>";	die;
	$fuser = \Bitrix\Sale\Fuser::getId();
	$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                $fuser,
                's1'
            );
	
	$basketItems = $basket->getBasketItems(); 
//$orderBasket = $basket->getOrderableItems();	
	$basketArr=[];
	foreach ($basket as $basketItem) {
		$dostup=$basketItem->canBuy();        // true, если доступно для покупки
		$otlog=$basketItem->isDelay();
		if($dostup==false || $otlog==true){continue;}
		 $id = $basketItem->getProductId();
		 $quantity = $basketItem->getQuantity();
		 $basketArr[$id]=$quantity;
		 /* $obj = new ItemStore();
		$obj->setOption(['STORE_IBLOCK_ID'=>7]);

		$obj->getStoreList();
		$obj->getStorebyProduct($id);
		$listHL=$obj->getResult();
		$arResult['STORE_LIST_ALL'] = $listHL['STORE_LIST_ALL'];
		$arResult['STORE_ITEM'][$id] = $listHL['STORE_BY_PRODUCT'][$id]; */
		
		$a = \Kolchuga\StoreList::itemRazmerDostupByArt(false, array( 'IBLOCK_ID'=>40, 'ID'=>$id ,'ONLY_ID'=>'Y') );
		$arResult['STORE_ITEM'][$id]=$a['ITEM'];		
	  }
	  $basket->refreshData(array('PRICE', 'COUPONS'));
		$discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
		$discounts->calculate();
		$result = $discounts->getApplyResult(true);
		$prices0 = $result['PRICES']['BASKET'];
	
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****STORE_ITEM******\n".print_r($arResult['STORE_ITEM'], true), FILE_APPEND | LOCK_EX);
		
	
	$sortingS=[	631125, 112, 115, 114,116,699777];
	$sort = array_flip($sortingS);
	
	$arResult['KORZINA']=[];
	/* foreach($arResult['STORE_ITEM'] as $itemId=>$sklads ){
		$massa=[];
		$br='N';
		$mass0=[];
		foreach($sklads as $el){
			if($el['ID']==631125){$arResult['KORZINA'][631125][]=$itemId;	$br='Y'; }
			$massa[]=['ID'=>$el['ID'],'AMOUNT'=>$el['ALL']['AMOUNT']];
		}
		if($br=='Y'){continue;}
		
		
		foreach($sklads as $el){
			$massa[]=['ID'=>$el['ID'],'AMOUNT'=>$el['ALL']['AMOUNT']];
		}
			usort($massa, function($a,$b) use($sort){
				if($a['AMOUNT']==$b['AMOUNT']){
					return $sort[$a['ID']] - $sort[$b['ID']];
				}else{
					if($b['ID']==116){
						return -1;
					}
					if($b['ID']==114){
						return -1;
					}
					return ($a['AMOUNT'] < $b['AMOUNT']) ? 1 : -1;
				}
				return 0;
			});
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($massa, true), FILE_APPEND | LOCK_EX);
		$arResult['KORZINA'][$massa[0]['ID']][]=$itemId;
			
	} */
	/* foreach($arResult['STORE_ITEM'] as $itemId=>$item ){
		$massa=[];
		$mass0=[];
		foreach($item[0]['SET_SKLAD'] as $skladId=>$el){
			if(!empty($el['PRODUCT_ID'])){
				if($skladId==631125){
					$mass0[]=['ID'=>$skladId,'AMOUNT'=>$el['PRODUCT_ID'][$item[0]['ID']]];
				}else{
					$massa[]=['ID'=>$skladId,'AMOUNT'=>$el['PRODUCT_ID'][$item[0]['ID']]];
				}
			}
		}	
		
		usort($massa, function($a,$b) use($sort){
			if($a['AMOUNT']==$b['AMOUNT']){
				return $sort[$a['ID']] - $sort[$b['ID']];
			}else{			
				if($b['ID']==116){
					return -1;
				}
				if($b['ID']==114){
					return -1;
				}			
				return ($a['AMOUNT'] < $b['AMOUNT']) ? 1 : -1;
			}
			return 0;
		});
		foreach($massa as $zn){$mass0[]=$zn;}
		unset($massa);
		$massa=$mass0;
		
		$arResult['KORZINA'][$massa[0]['ID']][]=$item[0]['ID'];
	}  */
	foreach($arResult['STORE_ITEM'] as $itemId=>$item ){
		$massa=\Kolchuga\DopViborka::sortSalonArr($item[0]['ID'], $item[0]['SET_SKLAD']);
		$arResult['KORZINA'][$massa[0]['ID']][]=$item[0]['ID'];
	}
	
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."****KORZINA******\n".print_r($arResult['KORZINA'], true), FILE_APPEND | LOCK_EX);
	
	
	
	
	
	$TovarP='N';
	foreach($arResult['KORZINA'] as $sklad=>$itemArr){
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($itemArr, true), FILE_APPEND | LOCK_EX);
		//удаляем если что-то есть в корзине
		//\CSaleBasket::DeleteAll($fuser,false);
		$resdelete = \CSaleBasket::GetList(array(), array(
                              'FUSER_ID' => $fuser,
                              'LID' => 's1',
                              'ORDER_ID' => 'null',
                              'DELAY' => 'N',
                              //'CAN_BUY' => 'Y'
							  ));
		while ($rowdelete = $resdelete->fetch()) {
		   \CSaleBasket::Delete($rowdelete['ID']);
		}
		
		
		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                $fuser,
                's1'
            )->getOrderableItems();
		foreach($itemArr as $iditem){
			
			$arParams=[];			
			
			$res = \CIBlockElement::GetList(null, Array('IBLOCK_ID' => '40', 'ID' => $iditem), false , false,array('ID','XML_ID','IBLOCK_EXTERNAL_ID'));
			if ($row = $res->fetch()) {
				
				$arParams['CATALOG_XML_ID']=array(
					'NAME' => 'Catalog XML_ID',
					'CODE' => 'CATALOG.XML_ID',
					'VALUE' => $row['IBLOCK_EXTERNAL_ID']
				);
				$arParams['PRODUCT_XML_ID']=array(
					"NAME" => "Product XML_ID",
					"CODE" => "PRODUCT.XML_ID",
					"VALUE" => $row['XML_ID']
				);				
			 
				if ($item = $basket->getExistsItem('catalog', $iditem, $arParams)){
					   //Обновление товара в корзине, на всякий случай
					   $item->setField('QUANTITY', $basketArr[$iditem]);
				}else{
						$item = $basket->createItem('catalog', $iditem); //создаём новый товар в корзине
						$item->setFields(array(
							'QUANTITY' => $basketArr[$iditem],
							'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
							'LID' => 's1',
							'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
							"CATALOG_XML_ID" => $row['IBLOCK_EXTERNAL_ID'],
							"PRODUCT_XML_ID" => $row['XML_ID'],						
						));						
						$item->getPropertyCollection()->setProperty($arParams);
				}			 
			 
			 }		 
			 
			 file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arParams, true), FILE_APPEND | LOCK_EX);
		}
		
		//Закинули
		//Сохранение изменений корзины
		$basket->save();
		$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                $fuser,
                's1'
            );
		$basket->refreshData(array('PRICE', 'COUPONS'));
		$discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
		$discounts->calculate();
		$result = $discounts->getApplyResult(true);
		$prices = $result['PRICES']['BASKET'];
		$basket->applyDiscount($prices);
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_by_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($basket->getListOfFormatText(), true), FILE_APPEND | LOCK_EX);
		DiscountCouponsManager::init();
			
			//создаем заказ с нашей корзиной
			$order = Order::create('s1', $userId);
			$order->setPersonTypeId(1);
			
			$order->setBasket($basket);
			//echo "<pre>";print_r($TovarP);echo "</pre>";
			//отгрузка, доставка
			if($TovarP=='Y'){//без доставки
				$deliv=20;
			}else{
				$deliv=$requestArr['DELIVERY_ID'];
			}
			//echo "<pre>";print_r($deliv);echo "</pre>";
			$shipmentCollection = $order->getShipmentCollection();
			$shipment = $shipmentCollection->createItem();
			$service = Delivery\Services\Manager::getById($deliv);
			$shipment->setFields(array(
				'DELIVERY_ID' => $service['ID'],
				'DELIVERY_NAME' => $service['NAME'],
			));
			$shipmentItemCollection = $shipment->getShipmentItemCollection();
			foreach ($basket as $basketItem)
			{
				$item = $shipmentItemCollection->createItem($basketItem);
				$item->setQuantity($basketItem->getQuantity());
			}
			
			//оплата
			$paymentCollection = $order->getPaymentCollection();
			$payment = $paymentCollection->createItem();
						
			$payid=$requestArr["PAY_SYSTEM_ID"];
			if($payid==22){
				if($sklad==631125){ //ООО "Кольчуга" - склад
					$payid=21;
				}elseif($sklad==112){//АО «Фирма «Кольчуга»  - варварка
					$payid=18;
				}elseif($sklad==114){//"Охотник -рыболов-турист" - Ленинский проспект
					$payid=19;
				}elseif($sklad==115){//ООО "Охотник на Тверской" - Волоколамское шоссе
					$payid=20;
				}elseif($sklad==699777){//ООО "Смарт Систем" - Барвиха
					$payid=23;
				}
			}else{
				if($sklad==114){//"Охотник -рыболов-турист" - Ленинский проспект
					$payid=19;
				}elseif($sklad==115){//ООО "Охотник на Тверской" - Волоколамское шоссе
					$payid=20;
				}elseif($sklad==699777){//ООО "Смарт Систем" - Барвиха
					$payid=23;
				}
			}
			$paySystemService = PaySystem\Manager::getObjectById($payid);
			$payment->setFields(array(
				'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
				'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
				'SUM' => $order->getPrice(),
				'CURRENCY' => $order->getCurrency(),
			));
			
			//заполнение свойств
			$order->doFinalAction(true);
			$propertyCollection = $order->getPropertyCollection();
			
			foreach($arrayProp as $orderPropertyId=>$vl){				
				$somePropValue = $propertyCollection->getItemByOrderPropertyId($orderPropertyId);
				$somePropValue->setValue($vl);
			}
			
			$order->setField('CURRENCY', $order->getCurrency());
				if($sklad==631125){ //ООО "Кольчуга" - склад
					$order->setField('COMPANY_ID', 2);
				}elseif($sklad==112){//АО «Фирма «Кольчуга»  - варварка
					$order->setField('COMPANY_ID', 1);
				}elseif($sklad==114){//"Охотник -рыболов-турист" - Ленинский проспект
					$order->setField('COMPANY_ID', 3);
				}elseif($sklad==115){//ООО "Охотник на Тверской" - Волоколамское шоссе
					$order->setField('COMPANY_ID', 4);
				}elseif($sklad==699777){//ООО "Смарт Систем" - Барвиха
					$order->setField('COMPANY_ID', 5);
				}
			
			$order->setField('USER_DESCRIPTION', $requestArr["ORDER_DESCRIPTION"]);
			$commentarii='Внимание!!! Этот заказ составляет 1/'.count($arResult['KORZINA']).' из того, что хотел клиент.';
			$order->setField('COMMENTS', $commentarii);
			
			$result = $order->save();
			$orderId = $order->GetId();
			$listOrder[]=$orderId;
			$TovarP='Y';
			unset($order);
	}
	$listOrderImp=implode('; ',$listOrder);
	$hash = md5($listOrderImp.$arrayProp['3'].$arrayProp['2']);
	foreach($listOrder as $vl){
		if ($arOrderProps = \CSaleOrderProps::GetByID(31)) {
			$db_vals = \CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $vl, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
			if ($arVals = $db_vals->Fetch()) {
				 \CSaleOrderPropsValue::Update($arVals['ID'], array(
					'NAME' => $arVals['NAME'],
					'CODE' => $arVals['CODE'],
					'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
					'ORDER_ID' => $arVals['ORDER_ID'],
					'VALUE' => $listOrderImp,
				));
			} else {
				 \CSaleOrderPropsValue::Add(array(
					'NAME' => $arOrderProps['NAME'],
					'CODE' => $arOrderProps['CODE'],
					'ORDER_PROPS_ID' => $arOrderProps['ID'],
					'ORDER_ID' => $vl,
					'VALUE' => $listOrderImp,
				));
			}
		}
		if ($arOrderProps = \CSaleOrderProps::GetByID(32)) {
			$db_vals = \CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $vl, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
			if ($arVals = $db_vals->Fetch()) {
				 \CSaleOrderPropsValue::Update($arVals['ID'], array(
					'NAME' => $arVals['NAME'],
					'CODE' => $arVals['CODE'],
					'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
					'ORDER_ID' => $arVals['ORDER_ID'],
					'VALUE' => $hash,
				));
			} else {
				 \CSaleOrderPropsValue::Add(array(
					'NAME' => $arOrderProps['NAME'],
					'CODE' => $arOrderProps['CODE'],
					'ORDER_PROPS_ID' => $arOrderProps['ID'],
					'ORDER_ID' => $vl,
					'VALUE' => $hash,
				));
			}
		}
	}
	//echo "<pre>";print_r($listOrder);echo "</pre>";
	
	/*header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);
	print(CUtil::PhpToJSObject(array(
		'listorder' => $listOrder,
		'hash' => $hash,
		'redirect' => '/personal/order/make/byhash.php?each_order_hash='.$hash,
	), false, false, true));*/
	echo json_encode(array(
		'listorder' => $listOrder,
		'hash' => $hash,
		'redirect' => '/personal/order/make/byhash.php?each_order_hash='.$hash,
	), JSON_UNESCAPED_UNICODE);
	die;
}