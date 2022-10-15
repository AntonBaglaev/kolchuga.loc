<?
// Composer autoload script
include_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/vendor/autoload.php';
// Уведомление о регистрации
/*AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

function OnAfterUserRegisterHandler($arFields){

	$arEventFields= array(
			"LOGIN" => $arFields["LOGIN"],
			"NAME" => $arFields["NAME"],
			"PASSWORD" => $arFields["PASSWORD"],
			"EMAIL" => $arFields["EMAIL"],
			);
	     CEvent::Send("NEW_USER_CONFIRM", SITE_ID, $arEventFields, "N", 5);
}

AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler($arFields){

	$rsUsers = CUser::GetList($by="", $order="", array("=EMAIL" => $arFields["EMAIL"]));
		while ($arUser = $rsUsers->Fetch()) 
		{ 
		  	$userOk = $arUser; 
		} 

		AddMessage2Log(var_export($userOk["EMAIL"], true), "id_event");
		AddMessage2Log(var_export($arFields['EMAIL'], true), "id_event");
   if ($arFields['EMAIL'] == $userOk["EMAIL"]){
	   $GLOBALS['APPLICATION']->ThrowException('Пользователь с таким e-mail уже существует.');
   		return false;   
   }
   return true;
}*/
/*Проверка If-Modified-Since и вывод 304 Not Modified */
AddEventHandler('main', 'OnEpilog', array('CBDPEpilogHooks', 'CheckIfModifiedSince'));
class CBDPEpilogHooks
{
    function CheckIfModifiedSince()
    {
        GLOBAL $lastModified;
        
        if ($lastModified)
        {
            header("Cache-Control: public");
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) {
                $GLOBALS['APPLICATION']->RestartBuffer();
                exit();                
            }
        }
    }
}
/*end Проверка If-Modified-Since и вывод 304 Not Modified */


/* AddEventHandler("main", "OnEndBufferContent", "ChangeMyContentGooglespeed");
function ChangeMyContentGooglespeed(&$content)
{
	$pattern = '@<link(.*)>@U';
	preg_match_all($pattern, $content, $matches);
	foreach($matches[1] as $kl0=>$el0 ){
		$pos = strpos($el0,'rel=');
		$linnow='<link as="style"'.$el0.'>';
		if ($pos === false) {			
			$link='<link as="style" rel="preload"'.$el0.'>';
		}else{
			$pattern1 = '@rel="(.*)"@U';
			preg_match_all($pattern1, $el0, $matches1);
			if('stylesheet'==$matches1[1][0]){
				$link=str_replace($matches1[1][0],'preload',$linnow);
			}
		}

		//$content=str_replace($linnow,$link,$content);

	}   
} */


define(SITE_ADDRES, 'https://www.kolchuga.ru');
define(ID_POPULAR_TAGS, 18041);

// Уведомление о регистрации и запрет повторного уведомления при регистрации на существующий адрес
AddEventHandler('main', 'OnAfterUserRegister', array('RegisterUserOnSite', 'OnAfterUserRegisterHandler'));
AddEventHandler('main', 'OnBeforeUserRegister', array('RegisterUserOnSite', 'OnBeforeUserRegisterHandler'));
class RegisterUserOnSite {

   private static $newUser = false;

   public static function OnBeforeUserRegisterHandler($arFields){

		$rsUsers = CUser::GetList($by="", $order="", array("=EMAIL" => $arFields["EMAIL"]));
			while ($arUser = $rsUsers->Fetch()) 
			{ 
			  	$userOk = $arUser; 
			} 

	   if ($arFields['EMAIL'] == $userOk["EMAIL"]){
	   		$emailUserFields = $arFields["EMAIL"];
		   	$GLOBALS['APPLICATION']->ThrowException("Пользователь с таким e-mail ($emailUserFields) уже существует. <br> <a href='/personal/profile/?forgot_password=yes'>Восстановить пароль</a>");
		   	self::$newUser = true;
	   		return false;   
	   }
	   return true;
	}

   	public static function OnAfterUserRegisterHandler($arFields){
	   	if (self::$newUser === false) {
		$arEventFields= array(
				"LOGIN" => $arFields["LOGIN"],
				"NAME" => $arFields["NAME"],
				"PASSWORD" => $arFields["PASSWORD"],
				"EMAIL" => $arFields["EMAIL"],
				);
		    CEvent::Send("NEW_USER_CONFIRM", SITE_ID, $arEventFields, "N", 5);
	   	}
	}
}


// Добавление пароля в письмо о регистрации после совершения заказа
AddEventHandler('main', 'OnBeforeEventAdd', array('CSendOrderPass', 'OnBeforeEventAddHandler'));
AddEventHandler('main', 'OnBeforeUserAdd', array('CSendOrderPass', 'OnBeforeUserAddHandler'));
class CSendOrderPass {

   private static $newUserPass = false;

   public static function OnBeforeUserAddHandler($arFields) {
      self::$newUserPass = $arFields['PASSWORD'];
   }

   public static function OnBeforeEventAddHandler(&$event, &$lid, &$arFields) {
      if (self::$newUserPass === false) {
         $arFields['PASSWORD'] = '';
      } else {
         $arFields['PASSWORD'] = self::$newUserPass;
      }
   }
}




class exCSite
{
  public function ShowH1()
  {
    $GLOBALS["APPLICATION"]->AddBufferContent(array("exCSite", "__ShowH1"));
  }
  
  public function __ShowH1()
  {
    global $APPLICATION;
    
    return $APPLICATION->GetPageProperty("h1", $APPLICATION->GetTitle());
  }
}

function getSearchSection(){
	$obCache = new CPHPCache();
	$cacheLifetime = 3600;
	$cacheID = 'iblock_40';
	$cachePath = '/searchSection/';
	$arSections = array();
		
	if($obCache->InitCache($cacheLifetime, $cacheID, $cachePath))
	{
		$arSections = $obCache->GetVars();
	}
	elseif($obCache->StartDataCache())
	{
		CModule::IncludeModule("iblock");
				
		global $CACHE_MANAGER;
		$CACHE_MANAGER->StartTagCache($cachePath);
			
		$rsSection = CIBlockSection::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>40,"ACTIVE"=>"Y","UF_SEARCH"=>1), false, array("ID", "NAME"));
		while($arSection = $rsSection->GetNext()){
			$arSections[$arSection["ID"]] = $arSection["NAME"];
		}
			
		$CACHE_MANAGER->RegisterTag("iblock_id_40");
		$CACHE_MANAGER->EndTagCache();
		$obCache->EndDataCache($arSections);	
	}
		
	return $arSections;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/order_events.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/user_events.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/mail_events.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/agents.php';


/*Version 0.3 2011-04-25*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "DoIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "DoIBlockAfterSave");

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "ExplodeCaliberOnAddUpdate");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "ExplodeCaliberOnAddUpdate");

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate","DoNotUpdate");
function DoNotUpdate(&$arFields)
{
    if ($_REQUEST['mode']=='import')
    {
        if($arFields['IBLOCK_ID']==40){
			$arobdd=['ID' =>$arFields['ID'] , 'NAME' =>$arFields['NAME'] , 'CODE'=>$arFields['CODE'] ];
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/z_donotupdate.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."*****Vhod*****\n".print_r($arobdd, true), FILE_APPEND | LOCK_EX);
			$arobdd=[];
			$obdd=\CIBlockElement::GetList(Array(), array('IBLOCK_ID'=>$arFields['IBLOCK_ID'], 'ID'=>$arFields['ID']), false, false, array('IBLOCK_ID','ID','NAME','CODE')); 
			$code_now='';
			while($arobdd = $obdd->Fetch()){
				$code_now=$arobdd['CODE'];
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/z_donotupdate.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."*****Ishod*****\n".print_r($arobdd, true), FILE_APPEND | LOCK_EX);
			}
			if(!empty($code_now) && $code_now != $arFields['CODE']){
				file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/z_donotupdate.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."*****Podmena*****\n".print_r($arFields['CODE'].' -> '.$code_now, true), FILE_APPEND | LOCK_EX);
				$arFields['CODE']=$code_now;
			}
		}
    }
}

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
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testas.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arg1, true), FILE_APPEND | LOCK_EX);
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testas.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arg2, true), FILE_APPEND | LOCK_EX);
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
		
		$nunalicenzia=false;
		$arrSectLicens=[17828,17835,17841,17842,17851,17852,17853,17857,17859,17860,17861,18070];
		foreach($arg1["IBLOCK_SECTION"] as $sectId){
			if(in_array($sectId,$arrSectLicens)){$nunalicenzia=true; break;}
			$navChain = \CIBlockSection::GetNavChain($arg1["IBLOCK_ID"], $sectId);
			while ($arNav=$navChain->GetNext()){
				if(in_array($arNav['ID'],$arrSectLicens)){$nunalicenzia=true; break;}
			}
		}
		if($nunalicenzia){
			$setLicens=false;
			foreach($arg1['PROPERTY_VALUES'][216] as $kl=>$vl){
				if($vl['VALUE']=='ТребуетсяЛицензия'){$setLicens=true;}
			}
			
			if(!$setLicens){
				\CIBlockElement::SetPropertyValuesEx(
					$arg1["ID"],
					$arg1["IBLOCK_ID"],
					array(
						"TREBUETSYA_LITSENZIYA" => 'ТребуетсяЛицензия',						
					)
				);
			}
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
//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testasfq.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($f, true), FILE_APPEND | LOCK_EX);


	foreach($props as $prop){
		if(isset($f['PROPERTY_VALUES'][$prop]))
			$f['PROPERTY_VALUES'][$prop] = DIExplodePropHelper($f['PROPERTY_VALUES'][$prop]);
	}

	if(in_array('17859', $f['IBLOCK_SECTION'])){
		
		$massa246=[
			'.223'=>'.223 Rem',
			'.223 Rem'=>'.223 Rem',
			'9,3x62'=>'9,3x62',
			'9.3x62'=>'9,3x62',
			'8x68 S'=>'8x68 S',
			'8х68'=>'8x68 S',
			'.300'=>'.300 WM',
			'.300 WM'=>'.300 WM',
			'.300 Win Mag'=>'.300 WM',
			'.308'=>'.308 Win',
			'.308 Win'=>'.308 Win',
			'.308 W'=>'.308 Win',
			'.308 Win Mag'=>'.308 Win',
			'.338'=>'.338 Win Mag',
			'.338 Win Mag'=>'.338 Win Mag',
			'.338 Lapua M'=>'.338 Lapua Magnum',
			'.338 Lapua Mag'=>'.338 Lapua Magnum',
			'6.5'=>'6,5 Creedmoor',
			'6.5 creedmoor'=>'6,5 Creedmoor',
			'6.5 Creedmoor'=>'6,5 Creedmoor',
			'9,3x62'=>'9,3x62',
			'9.3x62'=>'9,3x62',
			'9.3x74 R'=>'9,3x74 R',
			'9.3x74'=>'9,3x74 R',
			'9mm Para'=>'9x19',
			'9x19'=>'9x19',
			'.222'=>'.222 Rem',
			'.222 Rem'=>'.222 Rem',
			'.243'=>'.243 Win',
			'.243 Win'=>'.243 Win',
			'.30-06'=>'.30-06',
			'.30-06 Spr'=>'.30-06',
			'.30-06 Sprg'=>'.30-06',
			'10.3х60 R'=>'10.3x60 R',
			'10.3x60 R'=>'10.3x60 R',
			'8x57 JS'=>'8х57 JS',
			'8х57 JS'=>'8х57 JS',
			'9.3x74 R'=>'9,3x74 R',
			'9.3х74 R'=>'9,3x74 R',
			'9x19'=>'9x19 Luger',
			'9x19 Luger'=>'9x19 Luger',
			
		];
		$massa246_1=[
			'.223'=>'.223 Rem',			
			'9.3x62'=>'9,3x62',			
			'8х68'=>'8x68 S',
			'.300'=>'.300 WM',
			'.300 Win Mag'=>'.300 WM',
			'.308'=>'.308 Win',
			'.308 W'=>'.308 Win',
			'.308 Win Mag'=>'.308 Win',
			'.338'=>'.338 Win Mag',
			'.338 Lapua M'=>'.338 Lapua Magnum',
			'.338 Lapua Mag'=>'.338 Lapua Magnum',
			'6.5'=>'6,5 Creedmoor',
			'6.5 creedmoor'=>'6,5 Creedmoor',
			'6.5 Creedmoor'=>'6,5 Creedmoor',		
			'9.3x62'=>'9,3x62',
			'9.3x74 R'=>'9,3x74 R',
			'9.3x74'=>'9,3x74 R',
			'9.3x74 R'=>'9,3x74 R',
			'9.3х74 R'=>'9,3x74 R',
			'9mm Para'=>'9x19',
			'.222'=>'.222 Rem',
			'.243'=>'.243 Win',
			'.30-06 Spr'=>'.30-06',
			'.30-06 Sprg'=>'.30-06',
			'10.3х60 R'=>'10.3x60 R',
			'8x57 JS'=>'8х57 JS',			
		];
		
		if(!empty($f['PROPERTY_VALUES'][246])){
			foreach($f['PROPERTY_VALUES'][246] as $key246=>$val246){
				if( !empty(trim($massa246_1[$val246['VALUE']])) ){
					$f['PROPERTY_VALUES'][246][$key246]['VALUE']=$massa246_1[$val246['VALUE']];
				}
			}
		}
		if(!empty($f['PROPERTY_VALUES']['KALIBR'])){
			foreach($f['PROPERTY_VALUES']['KALIBR'] as $key246=>$val246){
				if( !empty(trim($massa246_1[$val246['VALUE']])) ){
					$f['PROPERTY_VALUES']['KALIBR'][$key246]['VALUE']=$massa246_1[$val246['VALUE']];
				}
			}
		}
		
		
	}







	/*$f1=file($_SERVER["DOCUMENT_ROOT"].'/upload/ngsale.csv');
	foreach($f1 as $nm){
		if(trim($nm)==$f['NAME'] && !in_array(18376,$f["IBLOCK_SECTION"])){$f["IBLOCK_SECTION"][]=18376;}
	}*/
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testasf.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($f1, true), FILE_APPEND | LOCK_EX);
	/* if($f['ACTIVE'] == 'Y' && $f["IBLOCK_ID"]==40){
			$obuv=false;
			$obuvSection=[];
			$arrSectObuv=[18115,18108,18132,18147];
			
			foreach($f["IBLOCK_SECTION"] as $sectId){
				if(in_array($sectId,$arrSectObuv)){$obuv=true; $obuvSection[]=$sectId; break;}
				$navChain = \CIBlockSection::GetNavChain($f["IBLOCK_ID"], $sectId);
				while ($arNav=$navChain->GetNext()){
					if(in_array($arNav['ID'],$arrSectObuv)){$obuv=true; $obuvSection[]=$arNav['ID']; break;}
				}
			}
			
			if($obuv){
				//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/testasf.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($obuvSection, true), FILE_APPEND | LOCK_EX);
				$f['ACTIVE'] = 'N';
			}
		} */
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

//обработка события смены статуса формы резерва чтобы остылать полноценное письмо с параметрами
function my_onAfterResultStatusChange($WEB_FORM_ID, $RESULT_ID, $NEW_STATUS_ID, $CHECK_RIGHTS)
{
	// действие обработчика распространяется только на форму с ID=1
	if ($WEB_FORM_ID == 1){
		// 2 - статус "обработано"
		if ($NEW_STATUS_ID == 2) {
			//получаем свойства формы и поля 
			$arAnswer = CFormResult::GetDataByID(
				$RESULT_ID,
				array(),
				$arResult,
				$arAnswer2);
			//создаем массив нужных нам полей для письма
			$arEventFields = array(
				"C_EMAIL" => $arAnswer['C_EMAIL']['0']['USER_TEXT'],
				"ORDERID" => $arAnswer['ORDERID']['0']['USER_TEXT'],
				"PRODUCT_URL" => $arAnswer['PRODUCT_URL']['0']['USER_TEXT'],
				"ORDER_NAME" => $arAnswer['ORDER_NAME']['0']['USER_TEXT'],
				"ORDER_SUM" => $arAnswer['ORDER_SUM']['0']['USER_TEXT'],
				"TIMESTAMP_X" => $arResult['TIMESTAMP_X']
			);
			//PROFIT!
			CEvent::Send("FORM_STATUS_CHANGE_APPROVED", s1, $arEventFields);
		}
	}

	if ($WEB_FORM_ID == 2){
		// 8 - статус "обработано"
		if ($NEW_STATUS_ID == 8) {
			//получаем свойства формы и поля 
			$arAnswer = CFormResult::GetDataByID(
				$RESULT_ID,
				array(),
				$arResult,
				$arAnswer2);
			//создаем массив нужных нам полей для письма
			$arEventFields = array(
				"C_EMAIL" => $arAnswer['C_EMAIL']['0']['USER_TEXT'],
				"C_PHONE" => $arAnswer['C_PHONE']['0']['USER_TEXT'],
				"C_MESSAGE" => $arAnswer['C_MESSAGE']['0']['USER_TEXT'],
				"MANAGER_COMMENT" => $arAnswer['MANAGER_COMMENT']['0']['USER_TEXT'],
				"ANSWER_RESULT_ID_LINK" => 'http://www.kolchuga.ru/bitrix/admin/form_result_edit.php?lang=ru&WEB_FORM_ID='.$WEB_FORM_ID.'&RESULT_ID='.$RESULT_ID.'&WEB_FORM_NAME=CONSULTANT_FORM',
				"ANSWER_RESULT_ID" => $RESULT_ID
			);

			//PROFIT!
			//CEvent::Send("FORM_STATUS_CHANGE_APPROVED", s1, $arEventFields);
			CEvent::SendImmediate("FORM_STATUS_CHANGE_APPROVED", s1, $arEventFields, false, 102);
		}
	}
}
// зарегистрируем функцию как обработчик события
AddEventHandler('form', 'onAfterResultStatusChange', 'my_onAfterResultStatusChange');
#C_EMAIL# - Ваш e-mail
#ORDERID# - Номер заказа
#PRODUCT_URL# - Ссылка на товар
#ORDER_NAME# - Наименование
#ORDER_SUM# - Сумма заказа
#TIMESTAMP_X# - Дата одобрения заказа

function my_onAfterResultAddUpdate($WEB_FORM_ID, $RESULT_ID)
{
    // действие обработчика распространяется только на форму с ID=1
    if ($WEB_FORM_ID == 1)
    {
        $arAnswer = CFormResult::GetDataByID(
            $RESULT_ID,
            array(),
            $arResult,
            $arAnswer2);
        //создаем массив нужных нам полей для письма
        $arEventFields = array(
            "C_EMAIL" => $arAnswer['C_EMAIL']['0']['USER_TEXT'],
            "ORDERID" => $arAnswer['ORDERID']['0']['USER_TEXT'],
            "PRODUCT_URL" => $arAnswer['PRODUCT_URL']['0']['USER_TEXT'],
            "ORDER_NAME" => $arAnswer['ORDER_NAME']['0']['USER_TEXT'],
            "ORDER_SUM" => $arAnswer['ORDER_SUM']['0']['USER_TEXT'],
            "TIMESTAMP_X" => $arResult['TIMESTAMP_X'],
        );
        $rsResult = CFormResult::GetByID($RESULT_ID);
        $arResult = $rsResult->Fetch();
        $arEventFields["STATUS_TITLE"] = $arResult["STATUS_TITLE"];
        $arEventFields["STATUS_DESCRIPTION"] = $arResult["STATUS_DESCRIPTION"];

        CModule::IncludeModule("iblock");

        $res = CIBlockElement::GetList(
            array('sort' => 'asc'),
            array('IBLOCK_ID' => 7, 'NAME' => $arAnswer['STORE_LIST']['0']['USER_TEXT']),
            false,
            false,
            array('ID', 'IBLOCK_ID', 'NAME')
        );

        while($ob = $res->GetNextElement()){
            $store_email = $ob->GetProperties(array(), array('CODE' => 'email_reserve'));
            $store_email = $store_email['email_reserve']['VALUE'];
            $arEventFields["STORE_EMAIL"] = $store_email;
        }

        //PROFIT!
        CEvent::Send("FORM_ADD_RESERVE", s1, $arEventFields);

    }
}

// зарегистрируем функцию как обработчик двух событий
AddEventHandler('form', 'onAfterResultAdd', 'my_onAfterResultAddUpdate');
AddEventHandler('form', 'onAfterResultUpdate', 'my_onAfterResultAddUpdate');


//проверка мобильных устройств
$GLOBALS['check_modile'] = false;
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$GLOBALS['check_modile'] = true;
}


$incFile = dirname(__FILE__)."/formCheckSpam.php";
if (file_exists($incFile))
{
	require($incFile);
}
unset($incFile);


AddEventHandler("main", "OnEndBufferContent", "deleteKernelJs");
AddEventHandler("main", "OnEndBufferContent", "deleteKernelCss");
AddEventHandler("main", "OnEndBufferContent", "setpreload");
AddEventHandler("main", "OnEndBufferContent", "custom_delete_tagpage");

function custom_delete_tagpage(&$content) {
$content = str_replace('<h1 class="js-page-title"></h1>', '', $content); 
}
function setpreload(&$content) {
   global $USER, $APPLICATION;
   $result_links = array();
			
				// Обработка только раздела head
				preg_match("#<head(\s+[^>]*)?>(?<inner_head>.+)</head>#is", $content, $match_head);
				$proccess_content = $match_head["inner_head"];
			/* } else {
				$proccess_content = $content;
			} */
			// Обрабатываем существующие preload (для совместимости с Safari)
			$exception_links = array();
			preg_match_all("/<link[^>]*\s*?rel\s*?=\s*?[\"']preload[\"'][^>]*?>/i", $proccess_content, $match_links);
			foreach ($match_links[0] as $link) {
				preg_match_all("#\s*?(?<key>[^\s]+?)\s*?=\s*?[\"'](?<val>.+?)[\"']#", $link, $match_attrs, PREG_SET_ORDER);
				foreach ($match_attrs as $attr){
					if(strcasecmp($attr['key'], "href") == 0){
						$exception_links[] = $attr["val"];
					}
				}
			}
			// Обрабатываем CSS
			preg_match_all("/<link[^>]*\s*?rel\s*?=\s*?[\"']stylesheet[\"'][^>]*?>/i", $proccess_content, $match_links);
			foreach ($match_links[0] as $link) {
				preg_match_all("#\s*?(?<key>[^\s]+?)\s*?=\s*?[\"'](?<val>.+?)[\"']#", $link, $match_attrs, PREG_SET_ORDER);
				foreach ($match_attrs as $attr){
					if((strcasecmp($attr['key'], "href") == 0) AND (!in_array($attr["val"], $exception_links))){
						$result_links[] = '<link href="'.$attr["val"].'" rel="preload" as="style">';
					}
				}
			}
			// Обрабатываем JS
			preg_match_all("/<script[^>]*src\s*?=\s*?[\"'](?<link>.+?)[\"']/i", $proccess_content, $match_links);
			foreach ($match_links["link"] as $link) {
				if(!in_array($link, $exception_links)){
					$result_links[] = '<link href="'.$link.'" rel="preload" as="script">';
				}
			}
			
			if(!empty($result_links)){
				$result_links_str = implode("\n", $result_links);
				$content = preg_replace('/(<head.*>)/i', '$0'.$result_links_str, $content, 1);
			}
}

function deleteKernelJs(&$content) {
   global $USER, $APPLICATION;
   if((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/")!==false) return;
   if($APPLICATION->GetProperty("save_kernel") == "Y") return;

	$arPatternsToRemove = Array(
		'/<script.+?src=".+?kernel_main\/kernel_main\.js\?\d+"><\/script\>/',
		//'/<script.+?src=".+?bitrix\/js\/main\/core\/core[^"]+"><\/script\>/',
		'/<script.+?>BX\.(setCSSList|setJSList)\(\[.+?\]\).*?<\/script>/',
		'/<script.+?>if\(\!window\.BX\)window\.BX.+?<\/script>/',
		'/<script[^>]+?>\(window\.BX\|\|top\.BX\)\.message[^<]+<\/script>/',
		'/<script.+?src=".+?bitrix\/js\/main\/loadext\/loadext[^"]+"><\/script\>/',
		'/<script.+?src=".+?bitrix\/js\/main\/loadext\/extension[^"]+"><\/script\>/', 
	);

   $content = preg_replace($arPatternsToRemove, "", $content);
   $content = preg_replace("/\n{2,}/", "\n\n", $content);
}

function deleteKernelCss(&$content) {
   global $USER, $APPLICATION;
   if((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/")!==false) return;
   if($APPLICATION->GetProperty("save_kernel") == "Y") return;

   $arPatternsToRemove = Array(
      '/<link.+?href=".+?kernel_main\/kernel_main\.css\?\d+"[^>]+>/',
      //'/<link.+?href=".+?bitrix\/js\/main\/core\/css\/core[^"]+"[^>]+>/',
      '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/styles.css[^"]+"[^>]+>/',
      '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/template_styles.css[^"]+"[^>]+>/', 
   );

   $content = preg_replace($arPatternsToRemove, "", $content);
   $content = preg_replace("/\n{2,}/", "\n\n", $content);
}/*  */


CModule::AddAutoloadClasses(
        '', // не указываем имя модуля
        array(
           // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
                '\Roztech\SaleDiscount\Actions2' => '/local/php_interface/SaleDiscount/Actions2.php',
                '\Roztech\SaleDiscount\TwoForFifteen' => '/local/php_interface/SaleDiscount/TwoForFifteen.php',
                '\Roztech\SaleDiscount\CatalogCondCtrlUserProps' => '/local/php_interface/SaleDiscount/CatalogCondCtrlUserProps.php',
                '\Roztech\Tools\SomeTabset' => '/local/php_interface/Tools/SomeTabset.php',
                '\Roztech\Tools\ItemStore' => '/local/php_interface/Tools/ItemStore.php',
                '\Tgarl\Tools\MenuAdminkastr' => '/local/php_interface/Tools/MenuAdminkastr.php',
                
        )
);
AddEventHandler("sale", "OnCondSaleActionsControlBuildList", Array("\Roztech\SaleDiscount\TwoForFifteen", "GetControlDescr"));
AddEventHandler( 'main', 'OnAdminIBlockElementEdit',  ['\Roztech\Tools\SomeTabset', 'getTab']);
AddEventHandler("main", "OnBuildGlobalMenu", ['\Tgarl\Tools\MenuAdminkastr', 'ModifiAdminMenu']);
AddEventHandler("catalog", "OnCondCatControlBuildList", Array("\Roztech\SaleDiscount\CatalogCondCtrlUserProps", "GetControlDescr"));
AddEventHandler('iblock', 'OnIBlockPropertyBuildList', ['\Kolchuga\CustomElementProperty', 'GetIBlockPropertyDescriptionSeveral']);
?>