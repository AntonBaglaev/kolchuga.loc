<?php

namespace Kolchuga;

/**
 * Class StoreList
 * @package Kolchuga
 */
class StoreList
{
    public static $catalog_iblock = 7;
	
	function __construct($array=array())
    {
        $this->respons = ['resonse'=>'error','info'=>'']; 
		$this->requestArr = $array;		
    }
    function getArray(){
        return $this->requestArr;
    }
	
	function getList($no_object='N'){
		$result=[];
		
		$obCache = new \CPHPCache;
        $life_time = 12*3600; 
        $cache_id = self::$catalog_iblock . '_storelist';
        
        // если кеш есть и он ещё не истек, то
        if($obCache->InitCache($life_time, $cache_id, "/")) {
            $result = $obCache->GetVars();            
        } else {
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				array('IBLOCK_ID' => self::$catalog_iblock),
				false,
				false,
				array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_stores','PROPERTY_show_in_list','DETAIL_PAGE_URL','PROPERTY_clock','PROPERTY_masterskaya','PROPERTY_DOP_DESCRIPTION')
			);

			while($store = $res->GetNext()){

			    if ($store['ID'] == 705387) // Скрыл интернет-магазин
			        continue;

				if($store['PROPERTY_show_in_list_VALUE']=='Да'){
					$result['STORE_LIST'][] = $store;
				}
				$result['STORE_LIST_ALL'][] = $store;
			}
			$obCache->StartDataCache();
            $obCache->EndDataCache($result);
		}
		if($no_object=='N'){
			$this->requestArr['STORE']=$result;
		}
        return $result;
    }
	
	function getListSalonProp(){
		$result=[];
		
		$obCache = new \CPHPCache;
        $life_time = 12*3600; 
        $cache_id = self::$catalog_iblock . '_storelistsalonprop';
        
        // если кеш есть и он ещё не истек, то
        if($obCache->InitCache($life_time, $cache_id, "/")) {
            $result = $obCache->GetVars();            
        } else {
			$sect=[
				'ID', 'IBLOCK_ID', 'NAME', 'SORT', 'CODE',
				'PROPERTY_address','PROPERTY_metro_station','PROPERTY_phones',
				'PROPERTY_phones_service','PROPERTY_e_mail','PROPERTY_clock',
				'PROPERTY_masterskaya','PROPERTY_DOP_YANDEX','PROPERTY_DOP_NAME',
				'PROPERTY_WHATSAPP_PHONE',				
			];
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				array('IBLOCK_ID' => self::$catalog_iblock),
				false,
				false,
				$sect
			);

			while($store = $res->Fetch()){
				if(!empty($store['PROPERTY_PHONES_VALUE'])){
					$parsedPhone = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse($store['PROPERTY_PHONES_VALUE']);
					$store['NATIONAL_PHONE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::NATIONAL);
					$store['INTERNATIONAL_PHONE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::INTERNATIONAL);
					$store['E164_PHONE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::E164);					
				}
				if(!empty($store['PROPERTY_PHONES_SERVICE_VALUE'])){
					$no_dob=explode('доб',$store['PROPERTY_PHONES_SERVICE_VALUE']);
					$parsedPhone = \Bitrix\Main\PhoneNumber\Parser::getInstance()->parse($no_dob[0]);
					$store['NATIONAL_PHONE_SERVICE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::NATIONAL);
					$store['INTERNATIONAL_PHONE_SERVICE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::INTERNATIONAL);
					$store['E164_PHONE_SERVICE']=$parsedPhone->format(\Bitrix\Main\PhoneNumber\Format::E164);					
				}
				$result['STORE_LIST_ALL'][$store['ID']] = $store;
			}
			$obCache->StartDataCache();
            $obCache->EndDataCache($result);
		}
		if($no_object=='N'){
			$this->requestArr['STORE']=$result;
		}
        return $result;
    }
	
	function getListByBasket($basket_items=array()){
		if(empty($basket_items)){
			$basket_items=[];
			$key=0;
			$dbRes = \Bitrix\Sale\Basket::getList([
				'select' => ["*"],
				'filter' => [
					'=FUSER_ID' => \Bitrix\Sale\Fuser::getId(), 
					'=ORDER_ID' => null,
					'=LID' => 's1',
					'=CAN_BUY' => 'Y',
				]
			]);

			while ($arItem = $dbRes->fetch())
			{
				$basket_items[$key]=$arItem;
				$realNavChain = array();
				$db_old_groups = \CIBlockElement::GetElementGroups($arItem["PRODUCT_ID"], true);
				while($ar_group = $db_old_groups->Fetch()){
					$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
					while ($arNav=$navChain->GetNext()){
						$realNavChain[$arNav['ID']]=$arNav['NAME'];
					}			
				}
				$basket_items[$key]['SET_SECTION']=$realNavChain;
				
				$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
					'filter' => array('=PRODUCT_ID'=>$arItem['PRODUCT_ID'],'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
					'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
				));
				while($arStoreProduct=$rsStoreProduct->fetch())
				{
					$basket_items[$key]['STORES_PARAM'][]=$arStoreProduct;
					$basket_items[$key]['STORES_NAL'][$arStoreProduct['STORE_XML_ID']]=$arStoreProduct['AMOUNT'];
				}
				
				if(!empty($this->requestArr['STORE'])){
					
					foreach($this->requestArr['STORE']['STORE_LIST_ALL'] as $kl=>$ckld){
								$basket_items[$key]['SET_SKLAD'][$ckld['ID']]=[
									'ID'=>$ckld['ID'],
									'NAME'=>$ckld['NAME'],					
									'SHOW_IN_LIST_ID'=>$ckld['PROPERTY_SHOW_IN_LIST_ENUM_ID'],					
									'SHOW_IN_LIST_VALUE'=>$ckld['PROPERTY_SHOW_IN_LIST_VALUE'],					
								];
						foreach($ckld['PROPERTY_STORES_VALUE'] as $xml_ckld){
							if(!empty($basket_items[$key]['STORES_NAL'][$xml_ckld])){
								$basket_items[$key]['SET_SKLAD'][$ckld['ID']]['PRODUCT_ID'][$arItem['PRODUCT_ID']]+=$basket_items[$key]['STORES_NAL'][$xml_ckld];
							}
						}
					}
				}
				$key++;
			}			
			
		}else{
			foreach($basket_items as $key=>$arItem) {
				$realNavChain = array();
				$db_old_groups = \CIBlockElement::GetElementGroups($arItem["PRODUCT_ID"], true);
				while($ar_group = $db_old_groups->Fetch()){
					$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
					while ($arNav=$navChain->GetNext()){
						$realNavChain[$arNav['ID']]=$arNav['NAME'];
					}			
				}
				$basket_items[$key]['SET_SECTION']=$realNavChain;
				
				$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
					'filter' => array('=PRODUCT_ID'=>$arItem['PRODUCT_ID'],'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
					'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
				));
				while($arStoreProduct=$rsStoreProduct->fetch())
				{
					$basket_items[$key]['STORES_PARAM'][]=$arStoreProduct;
					$basket_items[$key]['STORES_NAL'][$arStoreProduct['STORE_XML_ID']]=$arStoreProduct['AMOUNT'];
				}
				
				if(!empty($this->requestArr['STORE'])){
					foreach($this->requestArr['STORE']['STORE_LIST_ALL'] as $kl=>$ckld){
								$basket_items[$key]['SET_SKLAD'][$ckld['ID']]=[
									'ID'=>$ckld['ID'],
									'NAME'=>$ckld['NAME'],
									'SHOW_IN_LIST_ID'=>$ckld['PROPERTY_SHOW_IN_LIST_ENUM_ID'],					
									'SHOW_IN_LIST_VALUE'=>$ckld['PROPERTY_SHOW_IN_LIST_VALUE'],
								];
					 
						foreach($ckld['PROPERTY_STORES_VALUE'] as $xml_ckld){
							if(!empty($basket_items[$key]['STORES_NAL'][$xml_ckld])){
								
								$basket_items[$key]['SET_SKLAD'][$ckld['ID']]['PRODUCT_ID'][$arItem['PRODUCT_ID']] += $basket_items[$key]['STORES_NAL'][$xml_ckld];
								
								
							}
						}
					}
					
				}				
			}
		}
		
		return $basket_items;
	}
	
	function BasketOnlyStore($basket_items=array()){
		$arResult['STORE_ONLY']='N';
		$arResult['STORE_YES']='N';
		if(empty($basket_items)){return $arResult;}
		
		foreach($basket_items as $key=>$arItem) {
			if(empty($arItem['SET_SKLAD'])){return $arResult;}
		}
		$arResult['STORE_ONLY']='Y';
		foreach($basket_items as $key=>$arItem) {
			if(
				!empty($arItem['SET_SKLAD'][112])
				|| !empty($arItem['SET_SKLAD'][114]) 
				|| !empty($arItem['SET_SKLAD'][115]) 
				|| !empty($arItem['SET_SKLAD'][116])
				|| !empty($arItem['SET_SKLAD'][699777])
			){
				$arResult['STORE_ONLY']='N';
			}
			if(	!empty($arItem['SET_SKLAD'][631125])){
				$arResult['STORE_YES']='Y';
			}			
		}
		return $arResult;
	}
	
	function BasketPsYes($basket_items=array()){
		$arResult['PS_ONLY']='N';
		$arResult['PS_YES']='N';
		if(empty($basket_items)){return $arResult;}
		
		foreach($basket_items as $key=>$arItem) {
			if(empty($arItem['SET_SKLAD'])){return $arResult;}			
			if( !empty($arItem['SET_SECTION'][18130]) ){	$arResult['PS_YES']='Y'; }
		}
		
		foreach($basket_items as $key=>$arItem) {
			if(empty($arItem['SET_SKLAD'])){return $arResult;}			
			if( empty($arItem['SET_SECTION'][18130]) ){	$arResult['PS_ONLY']='N';	break; 	}else{ $arResult['PS_ONLY']='Y'; }
		}
		return $arResult;
	}
	
	function itemRazmerDostupByArt($art_item='',$arParams=array()){
		if (empty($art_item) && empty($arParams['CML2_ARTICLE']) && empty($arParams['ID']) ){return false;}
		if(empty($arParams['IBLOCK_ID'])){return false;}
		
		$filtr=array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		
		if (!empty($art_item)){
			$filtr['PROPERTY_CML2_ARTICLE']=$art_item;
		}elseif(!empty($arParams['CML2_ARTICLE'])){
			$filtr['PROPERTY_CML2_ARTICLE']=$arParams['CML2_ARTICLE'];
		}else{
			$filtr0=$filtr;
			$filtr0['ID']=$arParams['ID'];
			$res = \CIBlockElement::GetList(
				array('name' => 'asc'),
				$filtr0,
				false,
				false,
				array('ID', 'IBLOCK_ID', 'PROPERTY_CML2_ARTICLE','PROPERTY_IDGLAVNOGO')
			);

			while($el = $res->Fetch()){
				if(!empty($el['PROPERTY_CML2_ARTICLE_VALUE']) && (empty($arParams['ONLY_ID']) || $arParams['ONLY_ID']=='N' ) ){
					$filtr['PROPERTY_CML2_ARTICLE']=$el['PROPERTY_CML2_ARTICLE_VALUE'];
				}elseif(!empty($el['PROPERTY_IDGLAVNOGO_VALUE']) && (empty($arParams['ONLY_ID']) || $arParams['ONLY_ID']=='N' ) ){
					$filtr['PROPERTY_IDGLAVNOGO']=$el['PROPERTY_IDGLAVNOGO_VALUE'];
				}else{
					$filtr['ID']=$el['ID'];
				}
			}
		}
		$filtr['ACTIVE']='Y';
		
		$arResult=[];
		$arResult['FILTER']=$filtr;
		$res = \CIBlockElement::GetList(
				array('name' => 'desc'),
				$filtr,
				false,
				false,
				array('ID','IBLOCK_ID','XML_ID','IBLOCK_EXTERNAL_ID','CATALOG_GROUP_2')
			);

			while($el = $res->GetNextElement()){
				$element=[];
				$oArr = $el->GetFields();
				$element['ID']=$oArr['ID'];
				$element['NAME']=$oArr['NAME'];
				$element['XML_ID']=$oArr['XML_ID'];
				$element['IBLOCK_EXTERNAL_ID']=$oArr['IBLOCK_EXTERNAL_ID'];
				$element['PRICE']=$oArr['CATALOG_PRICE_2'];
				$element['QUANTITY']=$oArr['CATALOG_QUANTITY'];
				$element['AVAILABLE']=$oArr['CATALOG_AVAILABLE'];
				$oArr['PROPERTIES']['RAZMER'] = $el->GetProperties(false,array('CODE'=>'RAZMER'))['RAZMER']; 
				$oArr['PROPERTIES']['IDGLAVNOGO'] = $el->GetProperties(false,array('CODE'=>'IDGLAVNOGO'))['IDGLAVNOGO']; 
				$element['RAZMER']=$oArr['PROPERTIES']['RAZMER']['VALUE'][0];
				$element['RAZMER_ALL']=$oArr['PROPERTIES']['RAZMER']['VALUE'];
				$element['IDGLAVNOGO']=$oArr['PROPERTIES']['IDGLAVNOGO']['VALUE'];
				$element['ARTICLE']=$filtr['PROPERTY_CML2_ARTICLE'];
				$arResult['ITEM_0'][]=$oArr;
				$arResult['ITEM'][]=$element;
			}
			
			$sizes_sort = array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '3XL', '3Xl', 'XXXXL', '4XL', '4Xl', 'XXXXXL', '5XL');
			usort($arResult['ITEM'], array("\Kolchuga\StoreList", "SortOfferSize"));
			$size_values = array();
			foreach($arResult['ITEM'] as $i => $v){
				$pos = array_search($v['RAZMER'], $sizes_sort);
				if($pos === FALSE) continue;
				
				$size_values[$pos] = $v;
				unset($arResult['ITEM'][$i]); 
			}
			
			ksort($size_values);
			
			$arResult['ITEM'] = array_merge($arResult['ITEM'], $size_values);
			
			$arResult['SKLD']=self::getList($no_object='Y');
			
			$arResult['SKU_COUNT_AMOUNT']=0;
			$arResult['SKU_AMOUNT']=[];
			
			foreach($arResult['ITEM'] as $key=>$vl){
				$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
					'filter' => array('=PRODUCT_ID'=>$vl['ID'],'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
					'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
				));
				while($arStoreProduct=$rsStoreProduct->fetch())
				{
					$arResult['ITEM'][$key]['STORES_PARAM'][]=$arStoreProduct;
					$arResult['ITEM'][$key]['STORES_NAL'][$arStoreProduct['STORE_XML_ID']]=$arStoreProduct['AMOUNT'];
					$arResult['SKU_COUNT_AMOUNT']+=$arStoreProduct['AMOUNT'];
				}
				
				if(!empty($arResult['SKLD'])){

					foreach($arResult['SKLD']['STORE_LIST_ALL'] as $kl=>$ckld){
						$arResult['ITEM'][$key]['SET_SKLAD'][$ckld['ID']]=[
									'ID'=>$ckld['ID'],
									'NAME'=>$ckld['NAME'],					
									'DETAIL_PAGE_URL'=>$ckld['DETAIL_PAGE_URL'],					
									'SHOW_IN_LIST_ID'=>$ckld['PROPERTY_SHOW_IN_LIST_ENUM_ID'],					
									'SHOW_IN_LIST_VALUE'=>$ckld['PROPERTY_SHOW_IN_LIST_VALUE'],					
								];
						
						foreach($ckld['PROPERTY_STORES_VALUE'] as $xml_ckld){								
							if(!empty($arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld])){
								$arResult['ITEM'][$key]['SET_SKLAD'][$ckld['ID']]['PRODUCT_ID'][$vl['ID']]+=$arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld];
								$arResult['ITEM'][$key]['SKU_AMOUNT']+=$arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld];
								if(!in_array($ckld['ID'], [116])){ //откуда не продаем
									$arResult['ITEM'][$key]['GET_BY_SKLAD'][]=$ckld['ID'];
								}
							}
						}
					}
					if(!empty($arResult['ITEM'][$key]['GET_BY_SKLAD'])){
						$arResult['ITEM'][$key]['GET_BY_SKLAD'] = array_unique($arResult['ITEM'][$key]['GET_BY_SKLAD']);
					}
				}
			}
		
		return $arResult;
	}
	function SortOfferSize($a, $b){
		return intval($a['RAZMER']) - intval($b['RAZMER']);
	}
	
	function getListOnSklad($item=array()){
		if(empty($item)){return $item;}
		$arResult=[];
			$arResult['ITEM']=$item;
			$arResult['SKLD']=self::getList($no_object='Y');
			
			$arResult['SKU_COUNT_AMOUNT']=0;
			$arResult['SKU_AMOUNT']=[];
			
			foreach($arResult['ITEM'] as $key=>$vl){
				$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
					'filter' => array('=PRODUCT_ID'=>$vl['ID'],'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
					'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
				));
				while($arStoreProduct=$rsStoreProduct->fetch())
				{
					$arResult['ITEM'][$key]['STORES_PARAM'][]=$arStoreProduct;
					$arResult['ITEM'][$key]['STORES_NAL'][$arStoreProduct['STORE_XML_ID']]=$arStoreProduct['AMOUNT'];
					$arResult['SKU_COUNT_AMOUNT']+=$arStoreProduct['AMOUNT'];
				}
				
				if(!empty($arResult['SKLD'])){

					foreach($arResult['SKLD']['STORE_LIST_ALL'] as $kl=>$ckld){
						$arResult['ITEM'][$key]['SET_SKLAD'][$ckld['ID']]=[
									'ID'=>$ckld['ID'],
									'NAME'=>$ckld['NAME'],	
									'DETAIL_PAGE_URL'=>$ckld['DETAIL_PAGE_URL'],
									'SHOW_IN_LIST_ID'=>$ckld['PROPERTY_SHOW_IN_LIST_ENUM_ID'],					
									'SHOW_IN_LIST_VALUE'=>$ckld['PROPERTY_SHOW_IN_LIST_VALUE'],					
								];
						
						foreach($ckld['PROPERTY_STORES_VALUE'] as $xml_ckld){								
							if(!empty($arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld])){
								$arResult['ITEM'][$key]['SET_SKLAD'][$ckld['ID']]['PRODUCT_ID'][$vl['ID']]+=$arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld];
								$arResult['ITEM'][$key]['SKU_AMOUNT']+=$arResult['ITEM'][$key]['STORES_NAL'][$xml_ckld];
								if(!in_array($ckld['ID'], [116])){ //откуда не продаем
									$arResult['ITEM'][$key]['GET_BY_SKLAD'][]=$ckld['ID'];
								}
							}
						}
					}
					if(!empty($arResult['ITEM'][$key]['GET_BY_SKLAD'])){
						$arResult['ITEM'][$key]['GET_BY_SKLAD'] = array_unique($arResult['ITEM'][$key]['GET_BY_SKLAD']);
					}
				}
			}
		return $arResult;
	}
}