<?php
if(!empty($arResult['PROPERTIES']['TOVAR']['VALUE'])){
	$filyael=[];
	$filyael["IBLOCK_ID"]=40;
	$filyael["ID"]=$arResult['PROPERTIES']['TOVAR']['VALUE'];
	
	$iskluch=['MORE_PHOTO','BREND','TREBUETSYA_LITSENZIYA','CML2_BAR_CODE','CML2_ARTICLE','CML2_ATTRIBUTES','CML2_TRAITS','CML2_BASE_UNIT','CML2_TAXES','FILES','MODEL','BREND_STRANITSA_BRENDA','IS_SKU','FOTO_BERETTA','TEXT_BERETTA','ON_SKLAD','NEAKTSIYA','STRANA','KOLICHESTVO_STVOLOV','KOLICHESTVO_STVOLOV_RASPOLOZHENIE_STVOLOV','V_KOMPLEKTE_POSTAVKI','MATERIAL_LOZHA','TIP_ORUZHIYA_PRINTSIP_DEYSTVIYA','DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY','TIP_MAGAZINA','AKTSIYA','IDSAYTA','GUID'];
	
	$selec=Array('IBLOCK_ID','ID','NAME','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL');
	$res = \CIBlockPriceTools::GetCatalogPrices(40, array('Розничная', ));
	$dbEl = \CIBlockElement::GetList(array('CATALOG_AVAILABLE' => 'desc','CATALOG_PRICE_2' => 'asc'), $filyael, false, false, $selec);
	$arResult['ROW']=[];	
	while($arEl0 = $dbEl->GetNextElement())	
	{
		$arEl=$arEl0->GetFields();
		$arEl['PROP'] = $arEl0->GetProperties(); 
		/*$arEl['PROP']['KALIBR'] = $arEl0->GetProperties(array(), array("CODE" => "KALIBR"))['KALIBR']; 
		$arEl['PROP']['DLINA_STVOLA'] = $arEl0->GetProperties(array(), array("CODE" => "DLINA_STVOLA"))['DLINA_STVOLA']; 
		$arEl['PROP']['EMKOST_MAGAZINA'] = $arEl0->GetProperties(array(), array("CODE" => "EMKOST_MAGAZINA"))['EMKOST_MAGAZINA']; 
		$arEl['PROP']['DULNYE_NASADKI'] = $arEl0->GetProperties(array(), array("CODE" => "DULNYE_NASADKI"))['DULNYE_NASADKI']; */
		
		foreach($arEl['PROP'] as $vl){
			if(in_array($vl['CODE'],$iskluch)){continue;}
			if(!empty($vl['VALUE']) && empty($arResult['ROW'][$vl['CODE']])){
				if($vl['CODE']=='POD_LEVUYU_RUKU_POD_PRAVUYU_RUKU'){$vl['NAME']='LH / RH';}
				$arResult['ROW'][$vl['CODE']]=$vl['NAME'];
			}
		}
		/*$arEl['PROP']['MORE_PHOTO'] = $arEl0->GetProperties(array(), array("CODE" => "MORE_PHOTO"))['MORE_PHOTO'];*/
		$arEl["PRICES"] = array();
		$arEl["PRICE_MATRIX"] = false;
		$arEl['MIN_PRICE'] = false;		
		$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arEl['IBLOCK_ID'], $res, $arEl);
		if (!empty($arEl['PRICES']))
			$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);
		
		$arResult['PROPERTIES']['TOVAR']['INFO'][$arEl['ID']]=$arEl;
				
	}
	
}
$cp = $this->__component; // объект компонента
if (is_object($cp))
        {
            // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
            $cp->arResult['DOWNLOAD_FILE'] = $arResult['PROPERTIES']['DOWNLOAD_FILE']['VALUE'];

            $cp->SetResultCacheKeys(array('DOWNLOAD_FILE'));
            // сохраним их в копии arResult, с которой работает шаблон
            $arResult['DOWNLOAD_FILE'] = $cp->arResult['DOWNLOAD_FILE'];
        }