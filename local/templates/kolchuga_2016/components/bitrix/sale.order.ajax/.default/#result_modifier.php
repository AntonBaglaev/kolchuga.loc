<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 23.12.15
 * Time: 23:19
 */

if(CModule::IncludeModule("iblock")){

    $arResult['STORE_LIST'] = array();
    $arResult['STORE_LIST_ALL'] = array();

    $res = CIBlockElement::GetList(
        array('sort' => 'asc'),
        //array('IBLOCK_ID' => 7, '=PROPERTY_show_in_list_VALUE' => 'Да'),
        array('IBLOCK_ID' => 7),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_stores','PROPERTY_show_in_list')
    );

    while($store = $res->Fetch()){
		if($store['PROPERTY_show_in_list_VALUE']=='Да'){
        $arResult['STORE_LIST'][] = $store;
		}
        $arResult['STORE_LIST_ALL'][] = $store;
    }

    $arResult['HAS_UNAVAILABLE'] = false;
    $countUnavailable = 0;
    foreach($arResult['BASKET_ITEMS'] as $key => $item){
        $db_props = CIBlockElement::GetProperty(
            40,
            $item['PRODUCT_ID'],
            array("sort" => "asc"),
            Array("CODE" => 'DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY')
        );

        $arResult['BASKET_ITEMS'][$key]['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] = $db_props->Fetch()['VALUE_XML_ID'];

        if($arResult['BASKET_ITEMS'][$key]['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] !== 'true'){

            $arResult['HAS_UNAVAILABLE'] = true;
            $countUnavailable++;

        }

    }

    if(count($arResult['BASKET_ITEMS']) == $countUnavailable){

        foreach($arResult['PAY_SYSTEM'] as $key => $paysystem){
            if((int)$paysystem['ID'] == 3){

                if($paysystem['CHECKED'] == 'Y'){
                    $arResult['PAY_SYSTEM'][0]['CHECKED'] = 'Y';
                }

                unset($arResult['PAY_SYSTEM'][$key]);
            }
        }
    }

}
if($arResult['ORDER_TOTAL_PRICE']<1000 && empty($_REQUEST['ORDER_ID'])){header("Location: /personal/cart/");}
/*?><!--pre><?print_r($arResult['BASKET_ITEMS']);?></pre--><?*/
//if($USER->IsAdmin()){ 	echo "<pre>";print_r($arResult[ORDER_TOTAL_PRICE]);echo "</pre>"; }
foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {
	$realNavChain = array();
	$db_old_groups = \CIBlockElement::GetElementGroups($arItem["PRODUCT_ID"], true);
	while($ar_group = $db_old_groups->Fetch()){
		$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
		while ($arNav=$navChain->GetNext()){
			$realNavChain[$arNav['ID']]=$arNav['NAME'];
		}			
	}
	$arResult['BASKET_ITEMS'][$key]['SET_SECTION']=$realNavChain;
	
	$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
		'filter' => array('=PRODUCT_ID'=>$arItem['PRODUCT_ID'],'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
		'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
	));
	while($arStoreProduct=$rsStoreProduct->fetch())
	{
		$arResult['BASKET_ITEMS'][$key]['STORES_PARAM'][]=$arStoreProduct;
		$arResult['BASKET_ITEMS'][$key]['STORES_NAL'][$arStoreProduct['STORE_XML_ID']]=$arStoreProduct['AMOUNT'];
	}
	foreach($arResult['STORE_LIST_ALL'] as $kl=>$ckld){
		foreach($ckld['PROPERTY_STORES_VALUE'] as $xml_ckld){
			if(!empty($arResult['BASKET_ITEMS'][$key]['STORES_NAL'][$xml_ckld])){
				$arResult['BASKET_ITEMS'][$key]['SET_SKLAD'][$ckld['ID']]=[
					'ID'=>$ckld['ID'],
					'NAME'=>$ckld['NAME']					
				];
				$arResult['BASKET_ITEMS'][$key]['SET_SKLAD'][$ckld['ID']]['PRODUCT_ID'][$arItem['PRODUCT_ID']]=$arResult['BASKET_ITEMS'][$key]['STORES_NAL'][$xml_ckld];
			}
		}
	}
	
}

$arResult['ONLY_SKLAD']='Y';
foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {
	
		if(
			!empty($arItem['SET_SKLAD'][112])
			|| !empty($arItem['SET_SKLAD'][114]) 
			|| !empty($arItem['SET_SKLAD'][115]) 
			|| !empty($arItem['SET_SKLAD'][116])
		){
			$arResult['ONLY_SKLAD']='N';
		}
	
}

//Разрешаем оформление ПС
$arResult['PS_ONLY']='N';
$arResult['PS_YES']='N';
foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {
	if( empty($arItem['SET_SECTION'][18130]) ){	$arResult['PS_ONLY']='N';	break; 	}else{ $arResult['PS_ONLY']='Y'; }
}



$arResult['RAZRESHIT_DOSTAVKI']='';
$arResult['OPLATA']=[];
$arResult['OPLATA_BANK']=17; // AO
foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {
	/* 
	//товар лежит разделе одежда-> куртки
	if(!empty($arItem['SET_SECTION'][17907]) )  {
		$arResult['RAZRESHIT_DOSTAVKI']='N';
		$arResult['OPLATA'][]=9;
	} */
	/*if(!empty($arItem['SET_SECTION'][17906]) || !empty($arItem['SET_SECTION'][18114]) )  {
		if(
			empty($arItem['SET_SKLAD'][112])
			&& empty($arItem['SET_SKLAD'][631125])
			&& (empty($arItem['SET_SKLAD'][114]) || $arItem['SET_SKLAD'][114]['PRODUCT_ID'][$arItem['PRODUCT_ID']]<2)
			&& (empty($arItem['SET_SKLAD'][115]) || $arItem['SET_SKLAD'][115]['PRODUCT_ID'][$arItem['PRODUCT_ID']]<2)
			&& (empty($arItem['SET_SKLAD'][116]) || $arItem['SET_SKLAD'][116]['PRODUCT_ID'][$arItem['PRODUCT_ID']]<2)		
		){
			$arResult['RAZRESHIT_DOSTAVKI']='N';
		}
	}*/
	/*if( empty($arItem['SET_SKLAD'][631125]) ){
			$arResult['RAZRESHIT_DOSTAVKI']='N';
			$arResult['OPLATA'][]=9;
		}*/
		
		/*if( !empty($arItem['SET_SKLAD'][112]) || !empty($arItem['SET_SKLAD'][114]) || !empty($arItem['SET_SKLAD'][115]) || !empty($arItem['SET_SKLAD'][116]) || !empty($arItem['SET_SECTION'][18130])){
			$arResult['OPLATA_BANK']=17;
		}*/
		
		//запрещаем покупку онлайн если товар есть где-то кроме на складе "Склад"
		/*if( !empty($arItem['SET_SKLAD'][112]) || !empty($arItem['SET_SKLAD'][114]) || !empty($arItem['SET_SKLAD'][115]) || !empty($arItem['SET_SKLAD'][116]) || !empty($arItem['SET_SECTION'][18130])){
			$arResult['RAZRESHIT_DOSTAVKI']='N';
			$arResult['OPLATA'][]=9;
		}*/
		
		
		//Если товар ПЛ , то должно быть АО Кольчуга; 
		if( !empty($arItem['SET_SECTION'][18130]) ){
			$arResult['OPLATA_BANK']=17;
			$arResult['PS_YES']='Y';
		}
		
	/*$db_props = \CIBlockElement::GetProperty(
            40,
            $arItem['PRODUCT_ID'],
            array("sort" => "asc"),
            Array("CODE" => 'SECT_ELEMENT')
        );

        $obub_val=$db_props->Fetch()['VALUE'];
		if($obub_val=='Обувь'){
			$arResult['RAZRESHIT_DOSTAVKI']='N';
			$arResult['OPLATA'][]=9;
		}
		*/
	//если сумма меньше 25000 и товара нет на складе: склад	, и это не подарочный сертификат
	/*if($arResult['ORDER_TOTAL_PRICE']<25000 && empty($arItem['SET_SKLAD'][631125]) && empty($arItem['SET_SECTION'][18130])){
		$arResult['RAZRESHIT_DOSTAVKI']='N';
			$arResult['OPLATA'][]=9;
	}*/
	
}
$arResult['OPLATA_BANK']=17; // AO

$kolskl=count($arResult['BASKET_ITEMS']);
if($kolskl==1){
	foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {	
		//Если товар есть на складе "Склад", то должно быть ООО Кольчуга; 
		if( !empty($arItem['SET_SKLAD'][631125]) && empty($arItem['SET_SECTION'][18130])){
			$arResult['OPLATA_BANK']=3;
		}
	}
}elseif($kolskl>1){
	$msk=['skl'=>0,'other'=>0];
	foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {	
		//Если товар есть на складе "Склад", то должно быть ООО Кольчуга; 
		if( !empty($arItem['SET_SECTION'][18130])){
			$arResult['OPLATA_BANK']=17;
			break;
		}
		if(!empty($arItem['SET_SKLAD'][631125])){$msk['skl']++;}
		if( !empty($arItem['SET_SKLAD'][112]) || !empty($arItem['SET_SKLAD'][114]) || !empty($arItem['SET_SKLAD'][115]) || !empty($arItem['SET_SKLAD'][116]) ){
			$msk['other']++;
		}
	}
	if($msk['skl']>=$msk['other'] ){$arResult['OPLATA_BANK']=3;}
}
//При наличии ПС всегда переводим оплату на АО
if($arResult['PS_YES']=='Y'){$arResult['OPLATA_BANK']=17;}

if($arResult['OPLATA_BANK']==3){
	foreach($arResult['PAY_SYSTEM'] as $k=>$paysystem){
		if($paysystem['ID']==17){
			unset($arResult['PAY_SYSTEM'][$k]);
		}
	}	
}elseif($arResult['OPLATA_BANK']==17){
	foreach($arResult['PAY_SYSTEM'] as $k=>$paysystem){
		if($paysystem['ID']==3){
			unset($arResult['PAY_SYSTEM'][$k]);
		}
	}	
}
$checke=[];
foreach($arResult['PAY_SYSTEM'] as $k=>$paysystem){
	if($paysystem['CHECKED']=='Y'){
		$checke['Y'][]=$k;
	}else{
		$checke['N'][]=$k;
	}
}
if(empty($checke['Y'])){
	$arResult['PAY_SYSTEM'][$checke['N'][0]]['CHECKED']='Y';
}





/*
if(!empty($realNavChain[18115]) || !empty($realNavChain[18108]) || !empty($realNavChain[18132]) || !empty($realNavChain[18147])  ){
	foreach($arResult['PAY_SYSTEM'] as $key=>$paysystem){
		if(in_array($paysystem['ID'],array(1,7,9,11))){unset($arResult['PAY_SYSTEM'][$key]);}
	}
}*/
/*?><!--pre>PC <?print_r($arResult['PS_ONLY']);?></pre--><?
?><!--pre>PC <?print_r($arResult['OPLATA_BANK']);?></pre--><?*/

/* ?><!--pre>PCPCPC <?print_r($arResult['RAZRESHIT_DOSTAVKI']);?></pre--><? */

$obj = new \Kolchuga\StoreList();
$obj->getList();
$basket=$obj->getListByBasket($arResult["BASKET_ITEMS"]);
/*?><!--pre>basket <?print_r($basket);?></pre--><?*/

	$sortingS=[	631125, 112, 114, 115, 116];
	$sort = array_flip($sortingS);
	$arResult['KORZINA']=[];
foreach($basket as $item){	
	$massa=[];
	$mass0=[];
	foreach($item['SET_SKLAD'] as $skladId=>$el){
		if($skladId==631125){
			$mass0[]=['ID'=>$skladId,'AMOUNT'=>$el['PRODUCT_ID'][$item['PRODUCT_ID']]];
		}else{
			$massa[]=['ID'=>$skladId,'AMOUNT'=>$el['PRODUCT_ID'][$item['PRODUCT_ID']]];
		}
	}	
	
	usort($massa, function($a,$b) use($sort){
		if($a['AMOUNT']==$b['AMOUNT']){
			return $sort[$a['ID']] - $sort[$b['ID']];
		}else{			
			if($b['ID']==116){
				return -1;
			}			
			return ($a['AMOUNT'] < $b['AMOUNT']) ? 1 : -1;
		}
		return 0;
	});
	foreach($massa as $zn){$mass0[]=$zn;}
	unset($massa);
	$massa=$mass0;
	
	$arResult['KORZINA'][$massa[0]['ID']][]=$item['PRODUCT_ID'];
	$arResult['KORZINA2'][$item['PRODUCT_ID']]=$item['SET_SKLAD'][$massa[0]['ID']]['NAME'];
	
	
}
$arResult["BASKET_ITEMS"]=$basket;
if(!empty($arResult['KORZINA'][116]) )  {
		$arResult['RAZRESHIT_DOSTAVKI']='N';
		$arResult['OPLATA'][]=9;
	}
	if(!empty($arResult['OPLATA'])){
	foreach($arResult['PAY_SYSTEM'] as $k=>$paysystem){
		unset($arResult['PAY_SYSTEM'][$k]['CHECKED']);
		if($paysystem['ID']==$arResult['OPLATA'][0]){$arResult['PAY_SYSTEM'][$k]['CHECKED']='Y';}
	}
}else{
	foreach($arResult['PAY_SYSTEM'] as $k=>$paysystem){
		$arResult['OPLATA'][]=$paysystem['ID'];
	}
}
?>