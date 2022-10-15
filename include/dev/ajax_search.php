<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<? if ($_POST['search']): ?>
	<?
		CModule::IncludeModule('iblock');

		$ibIdVariants = 49;
		$cache = new CPHPCache();
		$cacheTime = 86400;
		$cacheId = 'arVariantsList';
		$cachePath = '/'.$cacheId.'/';
		if ($cache->InitCache($cacheTime, $cacheId, $cachePath)){
		    $VARIANTS = $cache->GetVars();
		}elseif($cache->StartDataCache()){
	        $VARIANTS = array();
	        $arFilter = array('IBLOCK_ID' => $ibIdVariants, 'ACTIVE' => 'Y');
	        $arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_VARIANTS');
	        $resSect = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	        while ($arVariant = $resSect->GetNext()){
	        	if($arVariant['PROPERTY_VARIANTS_VALUE']){
	            	$VARIANTS[strtolower($arVariant['PROPERTY_VARIANTS_VALUE'])] = strtolower($arVariant['NAME']);
	        	}
	        }
		    $cache->EndDataCache($VARIANTS);
		}

		$ibID = 40;
		$search = strtolower(trim($_POST['search']));
		$categoryId = trim($_POST['categoryId']);

		//проверяем совпадение запроса клиента и пресеты брендов. Если есть совпадение, то берем название бренда в качестве слова для поиска
		if (array_key_exists($search, $VARIANTS)) {
			$search = $VARIANTS[$search];
		}

		$arResult = array();
		$arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_IS_SKU", "PROPERTY_IDGLAVNOGO");
		$arOrder = array('NAME'=>'ASC');
		$arFilter = array("IBLOCK_ID"=>$ibID, "ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y", "CATALOG_AVAILABLE" => "Y", '>CATALOG_PRICE_2' => 0);

		if($categoryId != "0"){
			$arFilter['SECTION_ID'] = $categoryId;
			$arFilter['INCLUDE_SUBSECTIONS'] = 'Y';
		}

		$arFilter['NAME'] = '%'.$search.'%';

		$arResult['ITEMS'] = array();
		$res = CIBlockElement::GetList($arOrder, $arFilter, false, array("nPageSize"=>60), $arSelect);
		while($element = $res->GetNext()){

			$itemId = $element['ID'];
			//если товар псевдо sku, то берем главный товар
			if($element['PROPERTY_IS_SKU_VALUE'] == 'Да' && $element['PROPERTY_IDGLAVNOGO_VALUE']){
				$objMainItem = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$ibID, 'XML_ID'=>$element['PROPERTY_IDGLAVNOGO_VALUE']), false, array("nPageSize"=>60), $arSelect);
				if($mainItem = $objMainItem->GetNext()){
					$itemId = $mainItem['ID'];
					$element = $mainItem;
				}
			}


			$arResult['ITEMS'][$itemId] = $element;
		}



		/*$arResult = array();
		$arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL");
		$arOrder = array('NAME'=>'ASC');
		$arFilter = array("IBLOCK_ID"=>$ibID, "ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y", "CATALOG_AVAILABLE" => "Y", '>CATALOG_PRICE_2' => 0, "=PROPERTY_IS_SKU_VALUE"=>"Нет");

		if($categoryId != "0"){
			$arFilter['SECTION_ID'] = $categoryId;
			$arFilter['INCLUDE_SUBSECTIONS'] = 'Y';
		}

		$arFilter['NAME'] = '%'.$search.'%';

		$arResult['ITEMS'] = array();
		$res = CIBlockElement::GetList($arOrder, $arFilter, false, array("nPageSize"=>30), $arSelect);
		while($element = $res->GetNext()){
			$arResult['ITEMS'][] = $element;
		}*/


	?>
	<? if(count($arResult) > 0): ?>
		<? if(count($arResult['ITEMS']) > 0): ?>
			<ul>
				<? foreach($arResult['ITEMS'] as $item): ?>
					<li><a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></li>
				<? endforeach;?>
			</ul>
		<? endif ?>
	<? endif ?>
<? endif ?>
<? if (count($arResult['ITEMS']) == 0) {
	echo "false";
} ?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>