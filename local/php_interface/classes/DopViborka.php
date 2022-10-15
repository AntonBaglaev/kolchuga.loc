<?php

namespace Kolchuga;

/**
 * Class DopViborka
 * @package Kolchuga
 */
class DopViborka
{
    function __construct($array=array())
    {
        $this->respons = ['resonse'=>'error','info'=>'']; 
		$this->requestArr = $array;		
    }
    function getArray(){
        return $this->requestArr;
    }
	
	function getListIndexTovar($filterid='N', $npage=10){
		$result=[];
		$result2=[];
		
		$obCache = new \CPHPCache;
        $life_time = 12*3600; 
        $cache_id = 'getlistindextovar';
        $cache_id2 = 'getlistindextovar2'.$npage;
        
        // если кеш есть и он ещё не истек, то
        if($obCache->InitCache($life_time, $cache_id, "/indextovar")) {
            $result = $obCache->GetVars();            
        } else {
			$fltr=array('IBLOCK_ID' => 71,'ACTIVE'=>'Y');
			
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				$fltr,
				false,
				/*Array("nPageSize"=>$npage),*/
				false,
				array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_TOVAR')
			);

			while($sto = $res->Fetch()){
				$resActive = \CIBlockElement::GetList(
					array('sort' => 'asc'),
					array('IBLOCK_ID'=>40,'ID'=>$sto['PROPERTY_TOVAR_VALUE'],'ACTIVE'=>'Y', '>CATALOG_QUANTITY'=>0),
					false,
					false,
					array('ID')
				);
				if($resActive->SelectedRowsCount()>0){//проверяем на активные только товары					
					if($npage<1){continue;}
					$result[] = $sto;
					$npage--;
				}
			}
			
			$obCache->StartDataCache();
            $obCache->EndDataCache($result);
		}
		if($obCache->InitCache($life_time, $cache_id2, "/")) {
            $result2 = $obCache->GetVars();            
        } else {
			$fltr=array('IBLOCK_ID' => 40,'ACTIVE'=>'Y','SECTION_ID'=>18061,'INCLUDE_SUBSECTIONS'=>'Y', '=PROPERTY_IDGLAVNOGO'=>false, '>CATALOG_QUANTITY'=>0);
			
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				$fltr,
				false,
				Array("nPageSize"=>$npage),
				array('ID', 'IBLOCK_ID', 'NAME')
			);

			while($sto = $res->Fetch()){
				$result2[] = $sto;
			}
			$obCache->StartDataCache();
            $obCache->EndDataCache($result2);
		}
		
		
		if($filterid=='Y' && !empty($result)){
			$arFilter=['CATALOG_AVAILABLE'=>'Y'];
			$arFilter['ID'][]=0;
			foreach($result as $el){
				$arFilter['ID'][]=$el['PROPERTY_TOVAR_VALUE'];
			}
			return $arFilter;
		}elseif($filterid=='Y'){
			$arFilter=['CATALOG_AVAILABLE'=>'Y'];
			
			foreach($result2 as $el){
				$arFilter['ID'][]=$el['ID'];
			}
			$arFilter['ID'][]=0;
			return $arFilter;
		}
		return $result;
    }
	
	function getListIndexTovarPop($filterid='N', $npage=10){
		$result=[];
		$result2=[];
		
		$obCache = new \CPHPCache;
        $life_time = 12*3600; 
        $cache_id = 'getlistindextovarpop';
        $cache_id2 = 'getlistindextovarpop2'.$npage;
        
        // если кеш есть и он ещё не истек, то
        if($obCache->InitCache($life_time, $cache_id, "/indextovar")) {
            $result = $obCache->GetVars();            
        } else {
			$fltr=array('IBLOCK_ID' => 80,'ACTIVE'=>'Y');
			
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				$fltr,
				false,
				/*Array("nPageSize"=>$npage),*/
				false,
				array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_TOVAR')
			);

			while($sto = $res->Fetch()){
				$resActive = \CIBlockElement::GetList(
					array('sort' => 'asc'),
					array('IBLOCK_ID'=>40,'ID'=>$sto['PROPERTY_TOVAR_VALUE'],'ACTIVE'=>'Y', '>CATALOG_QUANTITY'=>0),
					false,
					false,
					array('ID')
				);
				if($resActive->SelectedRowsCount()>0){//проверяем на активные только товары					
					if($npage<1){continue;}
					$result[] = $sto;
					$npage--;
				}
			}
			
			$obCache->StartDataCache();
            $obCache->EndDataCache($result);
		}
		if($obCache->InitCache($life_time, $cache_id2, "/")) {
            $result2 = $obCache->GetVars();            
        } else {
			$fltr=array('IBLOCK_ID' => 40,'ACTIVE'=>'Y','INCLUDE_SUBSECTIONS'=>'Y', '=PROPERTY_IDGLAVNOGO'=>false, '>CATALOG_QUANTITY'=>0);
			
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				$fltr,
				false,
				Array("nPageSize"=>$npage),
				array('ID', 'IBLOCK_ID', 'NAME')
			);

			while($sto = $res->Fetch()){
				$result2[] = $sto;
			}
			$obCache->StartDataCache();
            $obCache->EndDataCache($result2);
		}
		
		
		if($filterid=='Y' && !empty($result)){
			$arFilter=['CATALOG_AVAILABLE'=>'Y'];
			$arFilter['ID'][]=0;
			foreach($result as $el){
				$arFilter['ID'][]=$el['PROPERTY_TOVAR_VALUE'];
			}
			return $arFilter;
		}elseif($filterid=='Y'){
			$arFilter=['CATALOG_AVAILABLE'=>'Y'];
			
			foreach($result2 as $el){
				$arFilter['ID'][]=$el['ID'];
			}
			$arFilter['ID'][]=0;
			return $arFilter;
		}
		return $result;
    }
	
	function getListModelRyadAkses($filterid=array(),$npage=10){
		if(empty($filterid) || empty($filterid['CODE'])){return array();}
		$result=[];
		$result2=[];
		
		$obCache = new \CPHPCache;
        $life_time = 1*3600; 
        $cache_id = 'getlistmodelryad'.$filterid['CODE'];
        
        
        // если кеш есть и он ещё не истек, то
        if($obCache->InitCache($life_time, $cache_id, "/modelryad")) {
            $result = $obCache->GetVars();            
        } else {
			$fltr=array('IBLOCK_ID' => 72,'ACTIVE'=>'Y');
			$fltr = array_merge ($fltr, $filterid);
			$res = \CIBlockElement::GetList(
				array('sort' => 'asc'),
				$fltr,
				false,
				/*Array("nPageSize"=>$npage),*/
				false,
				array('ID', 'IBLOCK_ID', 'PROPERTY_AKSESUAR_FOR_MODEL')
			);

			while($sto = $res->Fetch()){
				$sto['PROPERTY_AKSESUAR_FOR_MODEL_VALUE'][]=0;
				$resActive = \CIBlockElement::GetList(
					array('sort' => 'asc'),
					array('IBLOCK_ID'=>40,'ID'=>$sto['PROPERTY_AKSESUAR_FOR_MODEL_VALUE'],'ACTIVE'=>'Y','CATALOG_AVAILABLE'=>'Y'),
					false,
					false,
					array('ID')
				);
						
					while($sto2 = $resActive->Fetch()){
						
						if($npage<1){continue;}
						$result[] = $sto2['ID'];
						$npage--;
					}
					
					
					
				
			}
			
			$obCache->StartDataCache();
            $obCache->EndDataCache($result);
		}
		
		
		$arFilter=['CATALOG_AVAILABLE'=>'Y'];
		$arFilter['ID'][]=0;
		foreach($result as $el){
				$arFilter['ID'][]=$el;
			}
			return $arFilter;
		
		
    }
	
	function sortSalonArr($itemId=0, $set_sklad=array(), $sortingS=array(631125, 112, 115, 114,699777, 116), $sortA=array('631125'=>9999, '699777' => -2, '116' => -3)){
		$massa=[];
		if(!empty($set_sklad) && !empty($sortingS) && intval($itemId)>0){
			$sortS = array_flip($sortingS);
			
			foreach($set_sklad as $skladId=>$el){
				if(!empty($el['PRODUCT_ID'])){
					$massa[]=['ID'=>$skladId,'AMOUNT'=>$el['PRODUCT_ID'][$itemId]];					
				}
			}
			
			$by = 'AMOUNT';
			$by2 = 'ID';
			usort(
				$massa,
				function($a, $b) use ($by, $by2, $sortS, $sortA) {
					if (!empty($sortA[$a[$by2]])) {
						$a[$by] = $sortA[$a[$by2]];
					}
					if (!empty($sortA[$b[$by2]])) {
						$b[$by] = $sortA[$b[$by2]];
					}

					if ($a[$by] == $b[$by]) {
						return $sortS[$a[$by2]] - $sortS[$b[$by2]];
					} else {
						return ($a[$by] < $b[$by]) ? 1 : -1;
					}
					return 1;
				}
			);			
		}		
		
		return $massa;
	}
	function getPageHl($array=array()){
		$massa=[];
		if(empty($array)){return $massa;}
		
		\CModule::IncludeModule("highloadblock");
		$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(6)->fetch();
		$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();
		$entity_table_name = $hlblock['TABLE_NAME'];
		$sTableID = 'tbl_'.$entity_table_name;
		
		if(!empty($array['XML_ID'])){			
			$rsData = $entity_data_class::getList(array(
				"select" => array('*'), //выбираем все поля
				"filter" => array("UF_XML_ID" => $array['XML_ID']),
				"order" => array() // сортировка по полю UF_SORT, будет работать только, если вы завели такое поле в hl'блоке
			));
			
		}elseif(!empty($array['ID'])){
			$rsData = $entity_data_class::getList(array(
				"select" => array('*'), //выбираем все поля
				"filter" => array("ID" => $array['ID']),
				"order" => array() // сортировка по полю UF_SORT, будет работать только, если вы завели такое поле в hl'блоке
			));
		}else{
			return $massa;
		}
			$rsData = new \CDBResult($rsData, $sTableID);
			if($rsData->SelectedRowsCount()>0){
				$massa=$rsData->Fetch();
				
				if(!empty($massa['UF_LINK'])){
					$resActive = \CIBlockElement::GetList(
						array('sort' => 'asc'),
						array('IBLOCK_ID'=>13,'IBLOCK_SECTION_ID'=>'45','PROPERTY_email'=>"%/".$massa['UF_LINK']."%"),
						false,
						false,
						array('ID','PROPERTY_email','PREVIEW_PICTURE')
					);
					$massa['IBLOCK_13'] = $resActive->Fetch();
					if(!empty($massa['IBLOCK_13']['PREVIEW_PICTURE'])){
						$massa['IBLOCK_13']['SRC']=\CFile::GetPath($massa['IBLOCK_13']["PREVIEW_PICTURE"]);
					}
				}
				
			}
		
		return $massa;
	}
	
	//Настройки отображения разделов в брендах
	function getSeeSectionInBrand($seeslider=false){
		$arResult=[];
		
		$obCache = new \CPHPCache;
        $life_time = 24*3600; 
        $cache_id = 'iblock75_'.$life_time;
        
        
        if($obCache->InitCache($life_time, $cache_id, "/iblock75")) {
            $arResult = $obCache->GetVars();            
        } else {	
		
			$fltr=[
				'IBLOCK_ID'=>75,
				'ACTIVE'=>'Y'
			];
			
			$arrProp=[];
			$db_enum_list = \CIBlockProperty::GetPropertyEnum("RAZMER", Array('sort' => 'asc'), Array("IBLOCK_ID"=>$fltr["IBLOCK_ID"]));
			while($ar_enum_list = $db_enum_list->GetNext())
			{$arrProp[$ar_enum_list['ID']]=$ar_enum_list;}
			
			$res = \CIBlockElement::GetList(
					array('sort' => 'asc'),
					$fltr,
					false,
					false,
					array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_RAZMER', 'PREVIEW_PICTURE')
				);

			while($sto = $res->Fetch()){
				
				$razmer=[
					6=>'col-12 col-md-6',
					4=>'col-6 col-md-4',
					3=>'col-6 col-md-3',
					2=>'col-6 col-md-2',
				];
				if($seeslider){
					$razmer=[
						6=>'col-12 col-md-6',
						4=>'col-12 col-md-4',
						3=>'col-12 col-md-3',
						2=>'col-12 col-md-2',
					];
				}
				
				$arResult[$sto['CODE']]=[
					'ID'=>$sto['ID'],
					'NAME'=>$sto['NAME'],
					'IBLOCK_ID'=>$sto['IBLOCK_ID'],
					'RAZMER'=>$sto['PROPERTY_RAZMER_VALUE'],
					'RAZMER_ID'=>$sto['PROPERTY_RAZMER_ENUM_ID'],
					'RAZMER_XML_ID'=>$arrProp[$sto['PROPERTY_RAZMER_ENUM_ID']]['XML_ID'],
					'PICTURE'=> (!empty($sto['PREVIEW_PICTURE']) ? \CFile::GetPath($sto['PREVIEW_PICTURE']) : '/images/no_photo_kolchuga.jpg' ),
					'CLASS'=>$razmer[$arrProp[$sto['PROPERTY_RAZMER_ENUM_ID']]['XML_ID']],
				];
			}
		
			$obCache->StartDataCache();
            $obCache->EndDataCache($arResult);
		}
		
		return $arResult;
	}
	
	/* 
	* по умолчанию передается массив XML полученный из свойства PROPERTY_IDGLAVNOGO
	*
	* @param array $item 
	* @access public
	* @return array
	*/
	function getItemRazmerSku($item=array()){
		if(empty($item)){return $item;}
		$arResult=[];
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID'=>40, 'PROPERTY_IDGLAVNOGO' => $item, '>CATALOG_QUANTITY' => 0), false, false, Array('ID','CATALOG_QUANTITY','PROPERTY_IDGLAVNOGO'));
		while($obEl = $dbEl->Fetch()){
			$arResult[$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['QUANTITY']=$obEl['CATALOG_QUANTITY'];
			$VALUES = array();
			$res = \CIBlockElement::GetProperty(40, $obEl['ID'], Array("sort"=>"asc"), array("CODE" => "RAZMER"));
			while ($ob = $res->GetNext()){			
				$VALUES[] = $ob['VALUE'];
			}		
			$arResult[$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['RAZMER']=$VALUES[0];
		}
		return $arResult;
	}
	
	/* 
	* по умолчанию передается массив XML полученный из свойства PROPERTY_IDGLAVNOGO
	*
	* @param array $item 	массив ИД товаров
	* @param array $param:
	* 	int		IBLOCK_ID 	ИД Инфоблока
	*	array	TYPE_PRICE	типы цен
	*	array	SELECT		массив параметров для выборки
	*	array	FILTER		массив фильтров для выборки
	* @param array $dop:
	*	string	ARXMLIDGL	если равно Y формируем дополнительный массив ID=>XML_ID
	*	string	NOPRICE		если равно Y Получение цен не будет
	* @access public
	* @return array
	*/
	function getItemInDopolnitelno($param=array(),$item=array(), $dop=array()){
		if(empty($item)){return $item;}
		$arResult=[];
		
		$arConvertParams=array();
		\CModule::IncludeModule('catalog');
		
		if(empty($dop['NOPRICE']) || $dop['NOPRICE']!='Y'){
			$res = \CIBlockPriceTools::GetCatalogPrices($param['IBLOCK_ID'], $param['TYPE_PRICE']);
		}
		$filter=[];
		if(!empty($param['FILTER'])){
			$filter=$param['FILTER'];
		}
		$filter['ID']=$item;
		if(!empty($param['IBLOCK_ID'])){$filter['IBLOCK_ID']=$param['IBLOCK_ID'];}
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filter, false, false, $param['SELECT']);		
		if($dop['ARXMLIDGL']=='Y'){ $arXmlIDGl=[]; }
		while($arEl = $dbEl->GetNext())	
		{
			if(empty($dop['NOPRICE']) || $dop['NOPRICE']!='Y'){
				$arEl["PRICES"] = array();
				$arEl["PRICE_MATRIX"] = false;
				$arEl['MIN_PRICE'] = false;		
				$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($param['IBLOCK_ID'], $res, $arEl);
				if (!empty($arEl['PRICES']))
					$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);		

				if(!empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
					$pos = strpos($arEl['PROPERTY_OLD_PRICE_VALUE'], 'руб');
					if ($pos === false) {
						$arEl['PROPERTY_OLD_PRICE_VALUE'].=' руб';
					}
				}
				
				if($arEl['MIN_PRICE']['VALUE'] > 0 && $arEl['MIN_PRICE']['DISCOUNT_VALUE'] < $arEl['MIN_PRICE']['VALUE'] && empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
				  $arEl['PROPERTY_OLD_PRICE_VALUE'] = $arEl['MIN_PRICE']['PRINT_VALUE'];			  
				}
			}
			
			if(!empty($arEl['DETAIL_PICTURE'])){
				$arEl['DETAIL_PICTURE_SRC_ORIG'] = \CFile::GetPath($arEl["DETAIL_PICTURE"]);
				$arEl['DETAIL_PICTURE_SRC'] = \CFile::ResizeImageGet(
												$arEl['DETAIL_PICTURE'],
												array('width' => 300, 'height' => 300),
												BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60
											)['src'];
			}
			
			if($dop['ARXMLIDGL']=='Y'){ $arXmlIDGl[$arEl['ID']]=$arEl['XML_ID']; }
			$arResult["DOPOLNITELNO"][$arEl['ID']]=$arEl;
		}
		
		if($dop['ARXMLIDGL']=='Y'){ $arResult["ARXML"]=$arXmlIDGl; }
		
		return $arResult;
	}
	
	
	/* 
	* по умолчанию передается массив XML полученный из свойства PROPERTY_IDGLAVNOGO
	*
	* @param array $item 	массив ИД товаров
	* @param array $param:
	* 	int		IBLOCK_ID 	ИД Инфоблока
	*	array	TYPE_PRICE	типы цен
	*	array	SELECT		массив параметров для выборки
	*	array	FILTER		массив фильтров для выборки
	* @param array $dop:
	*	string	ARXMLIDGL	если равно Y формируем дополнительный массив ID=>XML_ID
	*	string	NOPRICE		если равно Y Получение цен не будет
	* @access public
	* @return array
	*/
	function getItemSku($param=array(),$item=array(), $dop=array(), $sklad='N'){
		
		$arResult=[];
		
		/* $obCache = new \CPHPCache;
        $life_time = 1*3600; 
        $cache_id = 'iblock_calc_'.$life_time.'_'.md5(array( $param,$item, $dop, $sklad));       
        
        if($obCache->InitCache($life_time, $cache_id, "/getitemsku")) {
            $arResult = $obCache->GetVars();            
        } else { */
		
			$arConvertParams=array();
			\CModule::IncludeModule('catalog');
			\CModule::IncludeModule('sale');
			
			if(!empty($param['TYPE_PRICE'])){
				$res = \CIBlockPriceTools::GetCatalogPrices($param['IBLOCK_ID'], array($param['TYPE_PRICE']));			
			}
			
			$filter=[];
			if(!empty($param['FILTER'])){
				$filter=$param['FILTER'];
			}
			$arProper=[];
			$cProper='N';
			 foreach($param['SELECT'] as $zn_s){
				 $isProper=explode('PROPERTY_',$zn_s)[1];
				 if(!empty($isProper)){
					$arProper[$isProper]=[]; 
					$cProper='Y';
				 }
			 }
			 
					 
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filter, false, false, $param['SELECT']);		
			//while($arEl = $dbEl->GetNext())	
			while($arEl0 = $dbEl->GetNextElement())	
			{
				 $arEl = $arEl0->GetFields();
				 if($cProper=='Y'){
					$p_list = $arEl0->GetProperties();
					 foreach($arProper as $kod=>$vv){
						 if($kod =='RAZMER'){
							 $p_list[$kod]['CURRENT']=$p_list[$kod]['VALUE'][0];
							 $arEl['RAZMER_CURRENT']=$p_list[$kod]['VALUE'][0];
						 }
						$arProper[$kod]=$p_list[$kod];
					 }
					
					$arEl['PROPERTIES']=$arProper; 
					
				 }
				 
				if(!empty($param['TYPE_PRICE'])){
					$arEl["PRICES"] = array();
					$arEl["PRICE_MATRIX"] = false;
					$arEl['MIN_PRICE'] = false;		
					$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($param['IBLOCK_ID'], $res, $arEl);
					if (!empty($arEl['PRICES']))
						$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);		

					if(!empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
						$pos = strpos($arEl['PROPERTY_OLD_PRICE_VALUE'], 'руб');
						if ($pos === false) {
							$arEl['PROPERTY_OLD_PRICE_VALUE'].=' руб';
						}
					}
					
					if($arEl['MIN_PRICE']['VALUE'] > 0 && $arEl['MIN_PRICE']['DISCOUNT_VALUE'] < $arEl['MIN_PRICE']['VALUE'] && empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
					  $arEl['PROPERTY_OLD_PRICE_VALUE'] = $arEl['MIN_PRICE']['PRINT_VALUE'];			  
					}
				}
				
				if($arEl['PREVIEW_PICTURE']) $arEl['PREVIEW_PICTURE'] = \CFile::GetFileArray($arEl['PREVIEW_PICTURE']);
				else $arEl['PREVIEW_PICTURE'] = array('SRC' => SITE_TEMPLATE_PATH . '/img/no_photo.png');

				if($arEl['DETAIL_PICTURE']) $arEl['DETAIL_PICTURE'] = \CFile::GetFileArray($arEl['DETAIL_PICTURE']);
				
				if(!empty($arEl['DETAIL_PICTURE'])){
					$arEl['DETAIL_PICTURE_SRC_ORIG'] = \CFile::GetPath($arEl["DETAIL_PICTURE"]);
					$arEl['DETAIL_PICTURE_SRC'] = \CFile::ResizeImageGet(
													$arEl['DETAIL_PICTURE'],
													array('width' => 300, 'height' => 300),
													BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60
												)['src'];
				}
				
				$arResult["DOPOLNITELNO"][$arEl['ID']]=$arEl;
			}
			
			if($sklad=='Y'){
				//$arResult['SKLD']=\Kolchuga\StoreList::getList();
				$tmpA=\Kolchuga\StoreList::getListOnSklad($arResult["DOPOLNITELNO"]);
				$arResult["DOPOLNITELNO"]=$tmpA;
				$arResult["DOPOLNITELNO"]['ITEM']=self::getItemSkuMinMaxPrice($arResult["DOPOLNITELNO"]['ITEM']);
			}else{
				$tmpA=self::getItemSkuMinMaxPrice($arResult["DOPOLNITELNO"]);
				unset($arResult["DOPOLNITELNO"]);
				$arResult["DOPOLNITELNO"]['ITEM']=$tmpA;
			}
			unset($tmpA);
			$arResult["DOPOLNITELNO"]['ITEM']=self::getItemSkuSort($arResult["DOPOLNITELNO"]['ITEM']);
			
			/* $obCache->StartDataCache();
            $obCache->EndDataCache($arResult);
		} */
		return $arResult;
	}
	
	function getItemSkuMinMaxPrice($item=array()){
		if(empty($item)){return array();}
		$minPrice=9999999999999999999999999999;
		$minPriceId=0;
		$maxPrice=0;
		$maxPriceId=0;
		foreach($item as $id=>$el){
			if($minPrice > $el['MIN_PRICE']['DISCOUNT_VALUE'] && $el['CATALOG_QUANTITY']>0){$minPrice=$el['MIN_PRICE']['DISCOUNT_VALUE'];$minPriceId=$el['ID'];}
			if($maxPrice < $el['MIN_PRICE']['DISCOUNT_VALUE'] && $el['CATALOG_QUANTITY']>0){$maxPrice=$el['MIN_PRICE']['DISCOUNT_VALUE'];$maxPriceId=$el['ID'];}
		}
		foreach($item as $id=>$el){
			$item[$id]['PRICE_MIN']=$minPrice;
			$item[$id]['PRICE_MAX']=$maxPrice;
			$item[$id]['PRICE_MIN_ID']=$minPriceId;
			$item[$id]['PRICE_MAX_ID']=$maxPriceId;
		}
		return $item;
	}
	
	function getItemSkuMinMaxPrice2($item=array()){
		if(empty($item)){return array();}
		$minPrice=9999999999999999999999999999;
		$minPriceId=0;
		$maxPrice=0;
		$maxPriceId=0;
		foreach($item as $id=>$el){
			if($minPrice > $el['MIN_PRICE']['DISCOUNT_VALUE']){$minPrice=$el['MIN_PRICE']['DISCOUNT_VALUE'];$minPriceId=$el['ID'];}
			if($maxPrice < $el['MIN_PRICE']['DISCOUNT_VALUE']){$maxPrice=$el['MIN_PRICE']['DISCOUNT_VALUE'];$maxPriceId=$el['ID'];}
		}
		foreach($item as $id=>$el){
			$item[$id]['PRICE_MIN']=$minPrice;
			$item[$id]['PRICE_MAX']=$maxPrice;
			$item[$id]['PRICE_MIN_ID']=$minPriceId;
			$item[$id]['PRICE_MAX_ID']=$maxPriceId;
		}
		return $item;
	}
	
	function getItemSkuSort($item=array()){
		
		$sizes_sort = array('XS', 'S', 'M', 'L', 'XL', 'XXL', '2XL', 'XXXL', '3XL', 'XXXXL', '4XL', 'XXXXXL', '5XL');
		$sku_by_color = array();
		foreach($item as $key => $arItem){
			//$clr_key = strlen($arItem['PROPERTY_TSVET_VALUE']) > 0 ? $arItem['PROPERTY_TSVET_VALUE'] : 'OTHER';	
			$clr_key = $arItem['PROPERTY_IDGLAVNOGO_VALUE'];
			$sku_by_color[$clr_key][$key] = $arItem; 
		}
		ksort($sku_by_color);
		
		foreach($sku_by_color as $clr => $items){
	
			usort($items, array("\Kolchuga\DopViborka", "getSortOfferSize"));
			
			$size_values = array();
			foreach($items as $i => $v){
				$pos = array_search($v['RAZMER_CURRENT'], $sizes_sort);
				if($pos === FALSE) continue;
				
				$size_values[$pos] = $v;
				unset($items[$i]); 
			}
			
			ksort($size_values);
			
			$items = array_merge($items, $size_values);
			
			$sku_by_color[$clr] = $items;

		}
		
		return $sku_by_color;
	}
	function getSortOfferSize($a, $b){
		return intval($a['RAZMER_CURRENT']) - intval($b['RAZMER_CURRENT']);
	}
	
	//tables razmer
	function getTablesSize($filter=[], $select=[], $section=[]){
		
		$obCache = new \CPHPCache(); 
		$cacheLifetime = 86400 * 7; 
		$cacheID = 'tablessize'.$section['ID'].$section['IBLOCK_ID']; 
		$cachePath = '/get_tables_size'; 
		
		if ($obCache->InitCache($cacheLifetime, $cacheID, $cachePath)){ // Если кэш валиден 
			$arResult = $obCache->GetVars(); 			 
		}elseif ($obCache->StartDataCache()) {  
			//\CModule::IncludeModule("iblock");
			$arResult=[];			
			$rs = \CIBlockElement::GetList(Array(), $filter, false, false, $select);
			$sectar=[];
			$sectar[]=$section['SECTION']['ID'];
			foreach($section['SECTION']['PATH'] as $vvl){
				$sectar[]=$vvl['ID'];
			}			
			while($ar_fields = $rs->GetNext()) {
				if(!empty($ar_fields['PROPERTY_FILTER_PROP_VALUE']) || !empty($ar_fields['PROPERTY_FILTER_SECTION_VALUE'])){
					
					if(!empty($ar_fields['PROPERTY_FILTER_SECTION_VALUE'])){
						$result_intersect = array_intersect($ar_fields['PROPERTY_FILTER_SECTION_VALUE'], $sectar);
						if(empty($result_intersect)){continue;}
					}				
					$filtersetka=["IBLOCK_ID" => $section['IBLOCK_ID'], 'ID'=>$section['ID']];
					foreach($ar_fields['PROPERTY_FILTER_PROP_VALUE'] as $kil_key=>$fil_set){
						$filtersetka[$fil_set]=$ar_fields['PROPERTY_FILTER_PROP_DESCRIPTION'][$kil_key];
					}
					$rs0 = \CIBlockElement::GetList(Array(), $filtersetka, false, false, Array("ID") );
					if($rs0->SelectedRowsCount()>0){
						$arResult['SETKA']=$ar_fields;
					}
				}else{
					$arResult['SETKA']=$ar_fields;
				}
			}
			
			$obCache->EndDataCache(array('SETKA' => $arResult['SETKA']));
		}
		
		return $arResult['SETKA'];
	}
}