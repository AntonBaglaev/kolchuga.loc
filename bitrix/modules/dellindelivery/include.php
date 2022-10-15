<?php

		
IncludeModuleLangFile(__FILE__);
$db_type = strtolower($GLOBALS['DB']->type);

CModule::AddAutoloadClasses(
	'dellindelivery',
	$a = array(
		'Dellin' => 'classes/'.$db_type.'/Dellin.php',
	)
);

/*данные для поключения к API*/
define("DELLIN_API_METOD", "POST");
define("DELLIN_API_CONTENT_TYPE", "application/json");

/*logo*/
define("DELLIN_LOGO", "/bitrix/modules/dellindelivery/dellin_logo.png");


Class DellinDelivery { 


/**
* Описние обработчика
*/
function Init()
{

//настройки
return array(
 
"SID"                   => "Dellin",
"NAME"                  => GetMessage('DELLIN_NAME'),
"DESCRIPTION"           => GetMessage('DELLIN_DESCRIPTION'),
"DESCRIPTION_INNER"     => GetMessage('DELLIN_DESCRIPTION_INNER'),
"BASE_CURRENCY"         => "RUR",
"HANDLER"                 => __FILE__,

/* Определение методов */
"DBGETSETTINGS"         => array("DellinDelivery", "GetSettings"),
"DBSETSETTINGS"         => array("DellinDelivery", "SetSettings"),
"GETCONFIG"             => array("DellinDelivery", "GetConfig"),

"COMPABILITY"           => array("DellinDelivery", "Compability"),
"CALCULATOR"            => array("DellinDelivery", "Calculate"),

"LOGOTIP"   => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].DELLIN_LOGO),
/* Список профилей */
"PROFILES" => array(
		"alldellin" => array(
		"TITLE" => GetMessage('DELLIN_TITLE'),
		"DESCRIPTION" => GetMessage('DELLIN_TITLE_DESCRIPTION'),

		"RESTRICTIONS_WEIGHT" => array(0),
		"RESTRICTIONS_SUM"    => array(0),
		),
)
);
}


/* Запрос конфигурации службы доставки */
function GetConfig()
{
$arConfig = array(
"CONFIG_GROUPS" => array(

    "all1" => GetMessage('DELLIN_SETTINGS'),
),

"CONFIG" => array(
						 "henderAPI" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_CONFIG'),
                         "GROUP" => "all1"
                    ),
   "API_URL" => array(
                         "TYPE" => "TEXT",
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_API_URL'),
						 "DEFAULT" => "http://",
                         "GROUP" => "all1",
						  "SIZE" => "50"
						 
                    ),   
   "API_KEY" => array(
                         "TYPE" => "TEXT",
                         "TITLE" => "API KEY *",
						 "DEFAULT" => "",
                         "GROUP" => "all1",
						"SIZE" => "50"
						 
						 
                    ),
    "hender0" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_HEADER0'),
                         "GROUP" => "all1"
                    ),
   "KLADR_otn1" => array(
                         "TYPE" => "TEXT",
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_KLADR_otn1'),
						 "DEFAULT" => GetMessage('DELLIN_SETTINGS_DEFAULT_KLADR_otn1'),
                         "GROUP" => "all1",
						 "SIZE" => "30"
						 
						 
                    ),
	"hender_small_loads" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_SMALL_LOADS_TITLE'),
                         "GROUP" => "all1",
                         
                    ),
        "small_loads" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_SMALL_LOADS'),
                         "GROUP" => "all1"
                                         
                    ),
        "enabled_price_no_small_loads" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_ENABLED_PRICE_NO_SMALL_LOADS'),
                         "GROUP" => "all1"
                                         
                    ),
    "hender1" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_MARKUP'),
                         "GROUP" => "all1",
                         
                    ),
     "nachenka_abc" => array(
                         "TYPE" => "STRING",
                         "DEFAULT" => '0',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_MARKUP_ABSOLUTE'),
                         "GROUP" => "all1",
                         
                    ),
        "hender2" => array(
                        "TYPE" => 'SECTION',
                        "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_INSURANCE'),
                         "GROUP" => "all1"
                        
    
                    ),
        "not_insurance" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_UNINSURANCE_QUEST'),
                         "GROUP" => "all1"
                                         
                    ),        
        "ctracho" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_INSURANCE_QUEST'),
                         "GROUP" => "all1"
                                         
                    ),
					/*Погрузка\загрузка*/
         "hender3" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_SHIPMENT'),
                         "GROUP" => "all1",
                         
                    ),
        "pogruzka_zagruz" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_SHIPMENT_QUEST'),
                         "GROUP" => "all1",
                         'HIDE_BY_NAMES' => array('pogruzka_zagruz_type','pogruzka_zagruz_spez_treb','pogruzka_zagruz_dop_komplekt')                
                    ),
		"pogruzka_zagruz_type" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'pogruzka_zagruz_type_zad',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_SHIPMENT_TYPE'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'pogruzka_zagruz_type_zad' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_BACK'),
                                    'pogruzka_zagruz_type_bok' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_SIDE'),
		                            'pogruzka_zagruz_type_verch' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_UP'),
		                            ),                
                    ),
		"pogruzka_zagruz_spez_treb" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'pogruzka_zagruz_spez_treb_no',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_SHIPMENT_TYPE_SPECIAL'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'pogruzka_zagruz_spez_treb_no' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_SPECIAL_NO'),
                                    'pogruzka_zagruz_spez_treb_otr_mash' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_SPECIAL_OPEN'),
		                            'pogruzka_zagruz_spez_treb_rastent' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_SPECIAL_TENT')
                                    ),                
                    ),
		"pogruzka_zagruz_dop_komplekt" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'pogruzka_zagruz_dop_komplekt_no',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_SHIPMENT_TYPE_EXTRA'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'pogruzka_zagruz_dop_komplekt_no' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_EXTRA_NO'),
                                    'pogruzka_zagruz_dop_komplekt_gidro' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_EXTRA_NO_GIDRO'),
		                            'pogruzka_zagruz_dop_komplekt_mani' => GetMessage('DELLIN_SETTINGS_VALUES_SHIPMENT_TYPE_EXTRA_MANIPULATOR'),
		                            
                                    ),                
                    ),					
        

					
					
					
/*выгрузка\отвоз*/
	"hender4" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_LANDING'),
                         "GROUP" => "all1",
                         
                    ),			
        "vigruzka_otvoz" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_LANDING_QUEST'),
                         "GROUP" => "all1",
                         "HIDE_BY_NAMES" => array('vigruzka_otvoz_type','vigruzka_otvoz_spez_treb','vigruzka_otvoz_dop_komplekt')                 
                    ),
		"vigruzka_otvoz_type" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'vigruzka_otvoz_type_zad',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_LANDING_TYPE'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'vigruzka_otvoz_type_zad' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_BACK'),
                                    'vigruzka_otvoz_type_bok' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SIDE'),
		                            'vigruzka_otvoz_type_verch' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_UP'),
		                            ),                
                    ),
		"vigruzka_otvoz_spez_treb" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'vigruzka_otvoz_spez_treb_no',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_LANDING_TYPE_SPECIAL'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'vigruzka_otvoz_spez_treb_no' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_NO'),
                                    'vigruzka_otvoz_spez_treb_otr_mash' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_OPEN'),
		                            'vigruzka_otvoz_spez_treb_rastent' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_TENT')
                                    ),                
                    ),
		"vigruzka_otvoz_dop_komplekt" => array(
                         "TYPE" => "DROPDOWN",
                         "DEFAULT" => 'vigruzka_otvoz_dop_komplekt_no',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_LANDING_TYPE_SPECIAL_EXTRA'),
                         "GROUP" => "all1",
                         "VALUES" => array(
									'vigruzka_otvoz_dop_komplekt_no' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_EXTRA_NO'),
                                    'vigruzka_otvoz_dop_komplekt_gidro' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_EXTRA_GIRDO'),
		                            'vigruzka_otvoz_dop_komplekt_mani' => GetMessage('DELLIN_SETTINGS_VALUES_LANDING_TYPE_SPECIAL_EXTRA_MANIPULATOR')
		                            
                                    ),                
                    ),					       
 

					
					
					
/*упаковка*/					
             "hender5" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING'),
                         "GROUP" => "all1"
                         
                    ),
            "up_jest" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING_HARD'),
                         "GROUP" => "all1"
                                         
                    ),
    
    "up_dop" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING_EXTRA'),
                         "GROUP" => "all1"
                                         
                    ),
    
    "up_puz" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING_BUBBLE'),
                         "GROUP" => "all1"
                                         
                    ),
        
    "up_meshok" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING_BAG'),
                         "GROUP" => "all1"
                                         
                    ),
    
    "up_palbort" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_PACKING_PALLET'),
                         "GROUP" => "all1"
                                         
                    ),
/*внутригородская*/ 
            "hender6" => array(
                        "TYPE" => 'SECTION',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_INTRACITY'),
                         "GROUP" => "all1",
                         
                    ),
    
            
    "vnutr_gorod_dostavka" => array(
                         "TYPE" => "CHECKBOX",
                         "DEFAULT" => 'N',
                         "TITLE" => GetMessage('DELLIN_SETTINGS_TITLE_INTRACITY_HIDE'),
                         "GROUP" => "all1"
                                         
                    ),      
    
),
    
);
return $arConfig;
}

/* Установка параметров */
function SetSettings($arSettings)
{
	$arSettings[nachenka_abc] = (float)str_replace(",", ".", $arSettings[nachenka_abc]);
	$arSettings[KLADR_otn1] = preg_replace ("/[^\"0-9\s]/","",$arSettings[KLADR_otn1]);
	$arSettings[API_KEY] = trim($arSettings[API_KEY]);
	
return serialize($arSettings);
}

/* Запрос параметров */
function GetSettings($strSettings) {
	$strSettings = unserialize($strSettings);
	$strSettings[nachenka_abc]=(float)$strSettings[nachenka_abc];
	$strSettings[KLADR_otn1]=(string)$strSettings[KLADR_otn1];
	
return $strSettings;
}



/* Проверка соответствия профиля доставки заказу */
function Compability($arOrder, $arConfig){

	$Id = $arOrder['LOCATION_TO'];
	$infoCity = CSaleLocation::GetByID($Id);
	$country_id = $infoCity['COUNTRY_ID'];// страна

$apidata= self::apiDataDellin($arConfig,$arOrder);
	
	if($arConfig['vnutr_gorod_dostavka']['VALUE']=='Y' &&
            $apidata['INDEX_FROM']==$apidata['INDEX_ZIP']){
		return ;
		}

//16-03-2015: изменен  $country_id!= 4  =>  $country_id!= 1
    if(!$apidata['INDEX_ZIP']/* || !( $country_id ==1 || $country_id==4) */) {
	return ;
	};   

return array("alldellin");
}
  
 	private function GetDefaultPersonType() {
		$PERSON_TYPE_ID = '';
		$rsPT = CSalePersonType::GetList(Array('SORT' => 'ASC', 'NAME' => 'ASC'), Array('LID' => SITE_ID, 'ACTIVE' => 'Y'));
		if ($arPT = $rsPT->Fetch()) {
			$PERSON_TYPE_ID = $arPT['ID'];
		}
		return $PERSON_TYPE_ID;
	}  
 

function Klard($arConfig,$arOrder){

    $IdLocation = $arOrder['LOCATION_TO'];

//16-03-2015: изменен алгоритм получения $kladr

    $infoCity = CSaleLocation::GetByID($IdLocation);
    $city_id = $infoCity['CITY_ID'];
    $region_id = $infoCity['REGION_ID'];
    $ccode = $infoCity['CODE'];

//    $info = Dellin::SetKLADR($city_id,$region_id);  
//    $kladr = $info['code'];

    $kladr = Dellin::GetZIPbyIDlocation($IdLocation,$city_id,$region_id, $ccode);

	if(empty($kladr)){
		$kladr = false;
	}
	
	return $kladr;
}
 
 /*собираем данные для api*/   
 

function apiDataDellin($arConfig,$arOrder)
{

	$kladr = self::Klard($arConfig,$arOrder);

	$rezult['PRICE'] = $arOrder['PRICE']>0 ? number_format($arOrder['PRICE'], 2, '.', '') : '';   

    switch($arConfig['not_insurance']['VALUE'])
    {
        case 'Y':
            $rezult['statedValue'] = null;
        break;

        case 'N':
        DEFAULT:
            switch($arConfig['ctracho']['VALUE'])
            {
                case 'Y':
                     $rezult['statedValue'] = $rezult['PRICE'];
                break;

                case 'N':
                DEFAULT:
                    $rezult['statedValue'] = 0;
                break;  
            }
        break;
    }

    $weignt =  CSaleMeasure::Convert($arOrder["WEIGHT"], "G", "KG"); /*вес товара, кг*/
	$rezult['WEIGHT'] = ($weignt >= 0.01) ? $weignt : 0.01 ;   

	$rezult['INDEX_ZIP'] = $kladr;   /*КЛАДР места получения*/
	$rezult['INDEX_FROM'] = str_replace("\"", "", $arConfig['KLADR_otn1']['VALUE']);  /*КЛАДР магазина*/
	$rezult['OBEM'] = self::apiDataObem($arOrder['ITEMS']); /*объем всего товара, м3*/	
	/*малогабаритный груз*/
	$rezult['SMALL_LOADS'] = ($arConfig['small_loads']['VALUE']=='Y')?true:false;
	$rezult['enabled_price_no_small_loads'] = ($arConfig['enabled_price_no_small_loads']['VALUE']=='Y')?true:false;

/*упаковки*/ 
	if($arConfig['up_jest']['VALUE']=='Y'){$rezult['UPAKOV'][]='0x838FC70BAEB49B564426B45B1D216C15';}  /*жесткая упаковка*/
	if($arConfig['up_dop']['VALUE']=='Y'){$rezult['UPAKOV'][]='0x9A7F11408F4957D7494570820FCF4549';}  /*дополнительная упаковка*/
	if($arConfig['up_puz']['VALUE']=='Y'){$rezult['UPAKOV'][]='0xA8B42AC5EC921A4D43C0B702C3F1C109';}  /*пузырьковая упаковка*/
	if($arConfig['up_meshok']['VALUE']=='Y'){$rezult['UPAKOV'][]='0xAD22189D098FB9B84EEC0043196370D6'; }  /*упаковка в мешок*/
	if($arConfig['up_palbort']['VALUE']=='Y'){$rezult['UPAKOV'][]='0xBAA65B894F477A964D70A4D97EC280BE';}   /*паллетный борт */

	
/*Погрузка\загрузка*/	
if ($arConfig['pogruzka_zagruz']['VALUE']=='Y')
{
	$rezult['ZABOR_GR'] = true;
	
	/*доп услуги*/ 

	/*Тип загрузки*/
	switch ($arConfig['pogruzka_zagruz_type']['VALUE']) 
	{
    case 'pogruzka_zagruz_type_zad':
        break;
    case 'pogruzka_zagruz_type_bok':
        $rezult['DOP_USLUGI_POG'][]='0xb83b7589658a3851440a853325d1bf69';
		break;
    case 'pogruzka_zagruz_type_verch':
        $rezult['DOP_USLUGI_POG'][]='0xabb9c63c596b08f94c3664c930e77778';
		break;
	}
	/*Специальные требования к транспорту*/
	switch ($arConfig['pogruzka_zagruz_spez_treb']['VALUE']) 
	{
    case 'pogruzka_zagruz_spez_treb_no':
        break;
    case 'pogruzka_zagruz_spez_treb_otr_mash':
        $rezult['DOP_USLUGI_POG'][]='0x9951e0ff97188f6b4b1b153dfde3cfec';
		break;
    case 'pogruzka_zagruz_spez_treb_rastent':
        $rezult['DOP_USLUGI_POG'][]='0x818e8ff1eda1abc349318a478659af08';
		break;
	}
	/*Дополнительная комплектация*/
	switch ($arConfig['pogruzka_zagruz_dop_komplekt']['VALUE']) 
	{
    case 'pogruzka_zagruz_dop_komplekt_no':
        break;
    case 'pogruzka_zagruz_dop_komplekt_gidro':
        $rezult['DOP_USLUGI_POG'][]='0x92fce2284f000b0241dad7c2e88b1655';
		break;
    case 'pogruzka_zagruz_dop_komplekt_mani':
        $rezult['DOP_USLUGI_POG'][]='0x88f93a2c37f106d94ff9f7ada8efe886';
		break;
	}	

}
else
{
	$rezult['ZABOR_GR'] = false;
}

/*выгрузка\отвоз*/

if ($arConfig['vigruzka_otvoz']['VALUE'] == 'Y')
{
	
	$rezult['OTVOZ_GR'] = true;
/*доп услуги*/ 

	/*Тип загрузки*/
	switch ($arConfig['vigruzka_otvoz_type']['VALUE']) 
	{
    case 'vigruzka_otvoz_type_zad':
        break;
    case 'vigruzka_otvoz_type_bok':
        $rezult['DOP_USLUGI_VIG'][] = '0xb83b7589658a3851440a853325d1bf69';
		break;
    case 'vigruzka_otvoz_type_verch':
        $rezult['DOP_USLUGI_VIG'][] = '0xabb9c63c596b08f94c3664c930e77778';
		break;
	}
	/*Специальные требования к транспорту*/
	switch ($arConfig['vigruzka_otvoz_spez_treb']['VALUE']) 
	{
    case 'vigruzka_otvoz_spez_treb_no':
        break;
    case 'vigruzka_otvoz_spez_treb_otr_mash':
        $rezult['DOP_USLUGI_VIG'][] = '0x9951e0ff97188f6b4b1b153dfde3cfec';
		break;
    case 'vigruzka_otvoz_spez_treb_rastent':
        $rezult['DOP_USLUGI_VIG'][] = '0x818e8ff1eda1abc349318a478659af08';
		break;
	}
	/*Дополнительная комплектация*/
	switch ($arConfig['vigruzka_otvoz_dop_komplekt']['VALUE']) 
	{
    case 'vigruzka_otvoz_dop_komplekt_no':
        break;
    case 'vigruzka_otvoz_dop_komplekt_gidro':
        $rezult['DOP_USLUGI_VIG'][]='0x92fce2284f000b0241dad7c2e88b1655';
		break;
    case 'vigruzka_otvoz_dop_komplekt_mani':
        $rezult['DOP_USLUGI_VIG'][]='0x88f93a2c37f106d94ff9f7ada8efe886';
		break;
	}	

}
else
{
	$rezult['OTVOZ_GR'] = false;
}

/*наценка абсолютна*/

	$rezult['NACHENKA_ABC']=((int)$arConfig['nachenka_abc']['VALUE']>=0 )?$arConfig['nachenka_abc']['VALUE']:0 ;

return $rezult;  
}
  
 /*расчет объема товаров(всех в корзине) QUANTITY:кол-во товара*/   
function apiDataObem($obemData)
{
	foreach ($obemData as $value)
	{
		$rezult+=
		$value['QUANTITY']*
		$value['DIMENSIONS'][WIDTH]*
		$value['DIMENSIONS'][HEIGHT]*
		$value['DIMENSIONS'][LENGTH] ;
	}
	$rezult = $rezult/(1000*1000*1000); /*объем из мм^3 в м^3*/
	
	
return ($rezult >= 0.01) ? $rezult : 0.01 ; 
}    
 /*конец расчет объема товаров(всех в корзине)*/ 

    

    

/* Калькуляция стоимости доставки*/
function Calculate($profile, $arConfig, $arOrder, $STEP, $TEMP = false)
{

	$apidata= self::apiDataDellin($arConfig,$arOrder);
    
	$API_KEY = $arConfig['API_KEY']['VALUE']; //ключь
		
$post_data =array(
	'appKey' => $API_KEY,
	'derivalPoint' => $apidata['INDEX_FROM'],//'7800000000000000000000000',  /*КЛАДР места отправки*/
	'arrivalPoint' => $apidata['INDEX_ZIP'], /*КЛАДР места получения*/
	'derivalDoor' => $apidata['ZABOR_GR'],   /*забор от двери 'True':'False'*/
	'arrivalDoor' => $apidata['OTVOZ_GR'],   /*отвоз до двери 'True':'False'*/ 
	'sizedVolume' => $apidata['OBEM'], /*объем товара m^3*/
	'sizedWeight' => $apidata['WEIGHT'],   /*вес товара кг*/
	'statedValue' => $apidata['statedValue'], /*страховка*/
	'packages' => $apidata['UPAKOV'], /*упаковка*/
	'derivalServices' => $apidata['DOP_USLUGI_POG'] , /*дополнительные услуги погрузки\отправка*/
	'arrivalServices' => $apidata['DOP_USLUGI_VIG'] /*дополнительные услуги выгрузка\получение*/
	);
			
/* Удаляем пустые элементы массива (упаковки,доп услуги): */
	$post_data = array_diff($post_data, array(''));
	/**/
if(!isset($post_data['derivalDoor'])) { $post_data['derivalDoor'] = false ;}
if(!isset($post_data['arrivalDoor'])) { $post_data['arrivalDoor'] = false ;}

	
    	$dataJSON = json_encode($post_data); 
		$urlAPI = parse_url($arConfig['API_URL']['VALUE']);
		$host = isset($urlAPI['host']) ? $urlAPI['host'] : '';
		$port = isset($urlAPI['port']) ? $urlAPI['port'] : 80;
		$path = isset($urlAPI['path']) ? $urlAPI['path'] : ''; 


 		$cache = new CPHPCache;
		$cache_time = 3600;
		$cache_id = serialize($post_data).'|'.serialize($arConfig);
		if ($cache->InitCache($cache_time, $cache_id)) {
			$arVars = $cache->GetVars();
			$strQueryText = $arVars['DATA'];
			unset($arVars);
		} else {
			$cache->StartDataCache($cache_time, $cache_id);
			/*запрос к API*/
				$strQueryText = QueryGetData(
				$host, 
				$port, 
				$path,
				$dataJSON,
				$error_number, 
				$error_text,
				DELLIN_API_METOD,"",
				DELLIN_API_CONTENT_TYPE
			); 

			if (!empty($strQueryText)) {
				$cache->EndDataCache(array('DATA' => $strQueryText));
			}
		}
	
	if(!$error_number)
	{	
		$strQueryText = json_decode($strQueryText,TRUE);

		if ($strQueryText["price"]){
			/*малогабаритный груз*/
			if((int)$apidata['SMALL_LOADS'] == 1){
			/*если возможен расчет малогабаритного груза*/
				if((float)$strQueryText["small"]["price"] != 0){ 
					$price = $strQueryText["small"]["price"];
			/*если невозможен расчет и включена замена на нормальную цену*/
				}elseif((int)$apidata['enabled_price_no_small_loads'] == 1){ 
					$price = $strQueryText["price"];
				}else{
					$rezult = GetMessage('DELLIN_ERROR');
					return array(
						"RESULT" => 'ERROR',
						"TEXT" => $rezult
							); 
				}

			}else{ /*нормальная цена при выключенном негабаритном*/
				$price = $strQueryText["price"];
			}
		
			$rezult = $price*1 + $apidata['NACHENKA_ABC'];
			$trans = $strQueryText["time"]['value']	;		
			
			
			return array(
				"RESULT" => "OK",
				"VALUE" => $rezult,
				'TRANSIT' => $trans
				);
				
		}else{
			$rezult = GetMessage('DELLIN_ERROR');

			return array(
				"RESULT" => 'ERROR',
				"TEXT" => $rezult
					); 
 		}
	}//end no error 
	else
	{
		return array(
			"RESULT" => 'ERROR',
			"TEXT" => GetMessage('DELLIN_CONNECT_ERROR')
			); 

	}
   
   
   
   

}


}//end class DellinDelivery
