<?
$ar_rest=[];
if(empty($arResult['NEW_SECTIONS'])){$arResult['NEW_SECTIONS']=[];}
if(!empty($arResult['SECTIONS'])){
	
	$obCache = \Bitrix\Main\Application::getInstance()->getManagedCache();
	$cacheTtl = 3600 * 24; 
	$cacheId = 'root3_'.$arResult['SECTIONS'][0]['IBLOCK_SECTION_ID'];
	$cachePath = 'fromroot3_cache';
	if ($obCache->read($cacheTtl, $cacheId, $cachePath)) {
		$ar_rest = $obCache->get($cacheId); // достаем переменные из кеша
		?><script>console.log(<?echo json_encode($ar_rest)?>);</script><?
	} else {
	
		$rest = \CIBLockElement::GetList (Array('sort'=>'asc','id'=>'asc'), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '64', 'PROPERTY_IN_SECTION'=>$arResult['SECTIONS'][0]['IBLOCK_SECTION_ID']), false, false, Array('ID','NAME','DETAIL_PICTURE', 'PROPERTY_IN_SECTION', 'PROPERTY_RAZMER', 'PROPERTY_LINK_SECTION', 'PROPERTY_LINK'));
		while ($db_item = $rest->GetNext())
		{
			$db_item['SECTION_PAGE_URL']='';
			if(empty($db_item['SECTION_PAGE_URL'])){
				$db_item['SECTION_PAGE_URL']=$db_item['PROPERTY_LINK_VALUE'];
			}
			if(!empty($db_item['PROPERTY_LINK_SECTION_VALUE'])){
				foreach($arResult['SECTIONS'] as $key => $arSection){
					if($arSection['ID']!=$db_item['PROPERTY_LINK_SECTION_VALUE']){ continue;}
					$db_item['SECTION_PAGE_URL']=$arSection['SECTION_PAGE_URL'];				
				}
				if(empty($db_item['SECTION_PAGE_URL'])){
					$ar_result=\CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ID"=>$db_item['PROPERTY_LINK_SECTION_VALUE']),false, Array("ID", "SECTION_PAGE_URL"));
					while($res=$ar_result->GetNext()){
						$db_item['SECTION_PAGE_URL']=$res['SECTION_PAGE_URL'];
					}
				}
			}
			
			$db_item['DETAIL_PICTURE_SRC']=\CFile::GetPath($db_item["DETAIL_PICTURE"]);
			$ar_rest[] = $db_item;
			
		}
		$obCache->set($cacheId, $ar_rest); // записываем в кеш
	}
}
if(!empty($ar_rest)){
	$arResult['NEW_SECTIONS']=$ar_rest;
}

$cp = $this->__component; // объект компонента
        if (is_object($cp))
        {
            $cp->arResult['NEW_SECTIONS'] = $arResult['NEW_SECTIONS'];
            $cp->SetResultCacheKeys(array('NEW_SECTIONS'));            
        }

/*if ($USER->GetID()=="11460"){echo "<pre>";print_r($ar_rest);echo "</pre>";}
if ($USER->GetID()=="11460"){echo "<pre>";print_r($arResult['SECTIONS']);echo "</pre>";}

foreach($arResult['SECTIONS'] as $key => $arSection){
	if(!$arSection['PICTURE']['ID']) continue;
	
	$resized = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL);
	$arResult['SECTIONS'][$key]['PICTURE']['SRC'] = $resized['src'];
}*/
?>