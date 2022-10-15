<?
/*Version 0.3 2011-04-25*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "DoIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceUpdate", "DoIBlockAfterSave");
function DoIBlockAfterSave($arg1, $arg2 = false)
{
	$ELEMENT_ID = false;
	$IBLOCK_ID = false;
	$OFFERS_IBLOCK_ID = false;
	$OFFERS_PROPERTY_ID = false;
	if (CModule::IncludeModule('currency'))
		$strDefaultCurrency = CCurrency::GetBaseCurrency();
	
	//Check for catalog event
	if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0)
	{
		//Get iblock element
		$rsPriceElement = CIBlockElement::GetList(
			array(),
			array(
				"ID" => $arg2["PRODUCT_ID"],
			),
			false,
			false,
			array("ID", "IBLOCK_ID")
		);
		if($arPriceElement = $rsPriceElement->Fetch())
		{
			$arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
			if(is_array($arCatalog))
			{
				//Check if it is offers iblock
				if($arCatalog["OFFERS"] == "Y")
				{
					//Find product element
					$rsElement = CIBlockElement::GetProperty(
						$arPriceElement["IBLOCK_ID"],
						$arPriceElement["ID"],
						"sort",
						"asc",
						array("ID" => $arCatalog["SKU_PROPERTY_ID"])
					);
					$arElement = $rsElement->Fetch();
					if($arElement && $arElement["VALUE"] > 0)
					{
						$ELEMENT_ID = $arElement["VALUE"];
						$IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
						$OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
						$OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
					}
				}
				//or iblock which has offers
				elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
					$OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
				}
				//or it's regular catalog
				else
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = false;
					$OFFERS_PROPERTY_ID = false;
				}
			}
		}
	}
	//Check for iblock event
	elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
	{
		//Check if iblock has offers
		$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
		if(is_array($arOffers))
		{
			$ELEMENT_ID = $arg1["ID"];
			$IBLOCK_ID = $arg1["IBLOCK_ID"];
			$OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
			$OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
		}
	}

	if($ELEMENT_ID)
	{
		static $arPropCache = array();
		if(!array_key_exists($IBLOCK_ID, $arPropCache))
		{
			//Check for MINIMAL_PRICE property
			$rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
			$arProperty = $rsProperty->Fetch();
			if($arProperty)
				$arPropCache[$IBLOCK_ID] = $arProperty["ID"];
			else
				$arPropCache[$IBLOCK_ID] = false;
		}

		if($arPropCache[$IBLOCK_ID])
		{
			//Compose elements filter
			if($OFFERS_IBLOCK_ID)
			{
				$rsOffers = CIBlockElement::GetList(
					array(),
					array(
						"IBLOCK_ID" => $OFFERS_IBLOCK_ID,
						"PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
					),
					false,
					false,
					array("ID")
				);
				while($arOffer = $rsOffers->Fetch())
					$arProductID[] = $arOffer["ID"];
					
				if (!is_array($arProductID))
					$arProductID = array($ELEMENT_ID);
			}
			else
				$arProductID = array($ELEMENT_ID);

			$minPrice = false;
			$maxPrice = false;
			//Get prices
			$rsPrices = CPrice::GetList(
				array(),
				array(
					"PRODUCT_ID" => $arProductID,
				)
			);
			while($arPrice = $rsPrices->Fetch())
			{
				if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
					$arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);
				
				$PRICE = $arPrice["PRICE"];

				if($minPrice === false || $minPrice > $PRICE)
					$minPrice = $PRICE;

				if($maxPrice === false || $maxPrice < $PRICE)
					$maxPrice = $PRICE;
			}

			//Save found minimal price into property
			if($minPrice !== false)
			{
				CIBlockElement::SetPropertyValuesEx(
					$ELEMENT_ID,
					$IBLOCK_ID,
					array(
						"MINIMUM_PRICE" => $minPrice,
						"MAXIMUM_PRICE" => $maxPrice,
					)
				);
			}
		}
	}
}


/**
 * Функция генерации превью изображений с помощью phpthumb 3.x
 *
 * @param str|int $src относительный или абсолютный путь к картинке или id файла Битрикса
 * @param int $width ширина превью (0 - авто)
 * @param int $heigth высота превью (0 - авто)
 * @param bool $adaptive метод резайза adaptive/resize
 * @param bool $clear_cache разрешить пересоздавать превью при обновлении кеша страницы Битрикса ($_GET['clear_cache'])
 * @param int $lifetime время, в милисекундах, перегенерации превью
 * @return string|bool возвращает путь к превью и false при ошибке
 */
if ( ! function_exists('thumbnail')) {
   
    function thumbnail($src, $width = 0, $height = 0, $adaptive = TRUE, $clear_cache = TRUE, $lifetime = 2592000) {
        global $APPLICATION, $USER;
//	echo'//';var_dump($src);echo'//';

        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/phpthumb/ThumbLib.inc.php')) {
            $APPLICATION->ThrowException('Can`t find phpthumb library.');
            return FALSE;
        }

        if(!$src) {
            $APPLICATION->ThrowException('Wrong filename.');
            return FALSE;
        }

        $width = intval($width);
        $height = intval($height);

        if ($USER->IsAdmin() && $_GET['clear_cache']) {
            $lifetime = 0;
        }

        if (is_numeric($src) && $src > 0) {
            $src = $_SERVER['DOCUMENT_ROOT'].CFile::GetPath($src);
        } elseif (!strstr($src, $_SERVER['DOCUMENT_ROOT'])) {
            $src = $_SERVER['DOCUMENT_ROOT'].$src;
        }

        $info = pathinfo($src);
        $thumb = $info['dirname'].'/'.$info['filename'].'_thumb_'.$width.'x'.$height.'.'.$info['extension'];

        if (!file_exists($thumb) OR (filemtime($thumb) + $lifetime) < time()) {
            require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/phpthumb/ThumbLib.inc.php');

            @unlink($thumb);
            $phpthumb = PhpThumbFactory::create($src);
           
            if($adaptive) {
                $phpthumb->adaptiveResize($width, $height);
            } else {
                $phpthumb->resize($width, $height);
            }

            RewriteFile($thumb, $phpthumb->getImageAsString());
        }

        return substr($thumb, strlen($_SERVER['DOCUMENT_ROOT']));
    }
}


/*/ чтоб группы при импорте из 1С не двигались
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate","SaveMySection");


function SaveMySection(&$arFields){
	if (@$_REQUEST['type']=='catalog'){ //импорт из 1с?
		unset($arFields['IBLOCK_SECTION']);
	}
}
*/

/**
#	обработчик события окончания обмена с 1с
#	подсчитывает количество элементов в псевдо-торговых предложениях и записывает в свойство "главного" товара
*/
function UpdateSKURestsAfter1cImport(){
	\Bitrix\Main\Loader::includeModule('iblock');
	$iblock_id = 40;
	$sku_prop_code = 'SKU_QUANTITY';
	$link_prop_code = 'IDGLAVNOGO';
	$is_sku_prop_code = 'IS_SKU';
	$res = \CIBlockElement::getList(
		array('ID'=>'ASC'), 
		array(
			'IBLOCK_ID'=>$iblock_id,
			'!PROPERTY_' . $link_prop_code => false
		),
		false,
		false,
		array('ID', 'IBLOCK_ID', 'XML_ID', 'PROPERTY_'.$link_prop_code, 'CATALOG_QUANTITY', 'NAME')
	);
	$sets = array();
	while($i = $res->fetch()){
		// print_r($i);
		$lp = $i['PROPERTY_'.$link_prop_code.'_VALUE'];
		if(!$lp) continue;
		if(!isset($sets[$lp]))
			$sets[$lp] = array('QUANTITY' => 0);

		if($lp == $i['XML_ID']){
			$sets[$lp]['MAIN_ID'] = $i['ID'];
			$sets[$lp]['MAIN_NAME'] = $i['NAME']; // for debugging
			\CIBlockElement::SetPropertyValues(
				$i['ID'],
				$iblock_id,
				298883,
				$is_sku_prop_code
			);
		} else {
			\CIBlockElement::SetPropertyValues(
				$i['ID'],
				$iblock_id,
				298882,
				$is_sku_prop_code
			);
		}
		if($i['CATALOG_QUANTITY'] > 0)
			$sets[$lp]['QUANTITY'] += $i['CATALOG_QUANTITY'];
	}

	// print_r($sets);

	foreach ($sets as $xml_id => $set) {
		if((int)$set['MAIN_ID'] < 1) continue;
		if(!$set['QUANTITY'] || (int)$set['QUANTITY'] < 1) $set['QUANTITY'] = 0;
		\CIBlockElement::SetPropertyValues(
			$set['MAIN_ID'],
			$iblock_id,
			$set['QUANTITY'],
			$sku_prop_code
		);
	}
	return;
}
AddEventHandler("catalog", "OnSuccessCatalogImport1C", "UpdateSKURestsAfter1cImport");


/**
	Обработчик события изменения/добавления элемента инфоблока для изменения свойства Калибр
	UPD: добавлена обработка свойства Размер
*/
function ExplodeCaliberOnAddUpdate(&$f){
	$props = array(246, 'KALIBR', 302, 'RAZMER');

	foreach($props as $prop){
		if(isset($f['PROPERTY_VALUES'][$prop]))
			$f['PROPERTY_VALUES'][$prop] = DIExplodePropHelper($f['PROPERTY_VALUES'][$prop]);
	}

}
function DIExplodePropHelper($prop){
	if(!is_array($prop)) return $prop;
	$res = array();
	foreach($prop as $val_key=>$val){
		$val = $val['VALUE'];
		if(!$val) continue;
		$e_vals = explode('|', $val);
		$res = array_merge($res, $e_vals);
	}
	
	$res = array_unique($res);
	foreach($res as &$r){
		$r = array('VALUE' => $r);
	}

/*	$n = 0;
	foreach($prop as $val_key=>$val){
		$val = $val['VALUE'];
		if(!$val) continue;
		$e_vals = explode('|', $val);

		$i = 0;
		foreach($e_vals as $e_val){
			if($i==0 && is_int($val_key))
				$res[$val_key] = $e_val;
			else
				$res['n'.$n] = $e_val;

			$i++;
		}
	}*/

	if(empty($res))
		return $prop;
	else
		return $res;

}
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "ExplodeCaliberOnAddUpdate");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "ExplodeCaliberOnAddUpdate");
?>