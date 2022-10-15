<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Выбрать настройки для Ozon');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Main\Loader;
//$arrSetting=\Bitrix\Main\Config\Option::get('tg_ozon','');

$arrSetting=\Bitrix\Main\Config\Option::getForModule('tg_ozon');

if(!empty($_REQUEST['V']) || !empty($_REQUEST['IBLOCK_ID']) ||  !empty($_REQUEST['IBLOCK_TYPE_ID']) ){
	
	
	$arrayTest=[
		'IBLOCK_TYPE_ID' => $_REQUEST['IBLOCK_TYPE_ID'],
		'IBLOCK_ID' => $_REQUEST['IBLOCK_ID'],
		'V' => array_unique($_REQUEST['V']),
		'CAT_IDS' => array_unique($_REQUEST['cat_ids']),
	];
	
	if(!empty($arrayTest['CAT_IDS'])){
		//создаем объект
		$obOzonA = new \Kolchuga\Ozona();
		//устанавливаем для текущего объекта ключи API
		$obOzonA->setOption([
			'CURL'=>[
				'KEY'=>$arrSetting['token'],
				'CID'=>$arrSetting['client_id'],
			]
		]);
		
		foreach($arrayTest['CAT_IDS'] as $zn){
			$itogo=[];
			$arCI=explode('/',$zn);
			$itogo['category_id']=$arCI[0];
			$itogo['category_name']=$arCI[1];
			$ms=$obOzonA->getAttributeR([$arCI[0]])['result'][0]['attributes'];			
			
			
			foreach($ms as $art){
				$itogo['category_attribute_r'][$art['id']]=$art;
				if(intval($art['dictionary_id'])>0){
					$ms_val=$obOzonA->getAttributeDictonaryValue($itogo['category_id'],$art['id'],$last_value_id=0,$limit=5000)['result'];
					$itogo['category_attribute_r'][$art['id']]['dictionary_value']=$ms_val;
				}else{
					$itogo['category_attribute_r'][$art['id']]['dictionary_value']=[];
				}
			}
			$arrayTest['CAT_OZON_ATR'][$itogo['category_id']]=$itogo;
		}
	}
	
	$arrayFile = "<?php\r\n\r\n"
          ."return " . var_export($arrayTest, TRUE) . ";"
          ."\r\n?>";
		  
	if(empty($arrSetting['catalog_file'])){
		$arrSetting['catalog_file']=date("YmdHis");
		\Bitrix\Main\Config\Option::set("tg_ozon", 'catalog_file', $arrSetting['catalog_file']);		
	}
 
	/* перезаписываем массив в файле */
	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/api/ozon_id_'.$arrSetting['catalog_file'].'.php', $arrayFile);
}else{
	//echo "<pre>";print_r($_REQUEST);echo "</pre>";
	if(!empty($arrSetting['catalog_file'])){
		$arrCatalogSetting=include_once($_SERVER["DOCUMENT_ROOT"].'/api/ozon_id_'.$arrSetting['catalog_file'].'.php');
		//echo "<pre>";print_r($arrCatalogSetting);echo "</pre>";
		if(!empty($arrCatalogSetting)){
			foreach($arrCatalogSetting as $kl=>$arvl){
				$_REQUEST[$kl]=$arvl;
			}			
		}
	}
	if(!empty($_REQUEST['V']) || !empty($_REQUEST['IBLOCK_ID']) ||  !empty($_REQUEST['IBLOCK_TYPE_ID']) ){
		$V=$_REQUEST['V'];
		$IBLOCK_ID=$_REQUEST['IBLOCK_ID'];
		$IBLOCK_TYPE_ID=$_REQUEST['IBLOCK_TYPE_ID'];
		$CAT_IDS=$_REQUEST['CAT_IDS'];
		
	}
}
		
	
	//создаем объект
	$obOzon = new \Kolchuga\Ozona();
	//устанавливаем для текущего объекта ключи API
	$obOzon->setOption([
		'CURL'=>[
			'KEY'=>$arrSetting['token'],
			'CID'=>$arrSetting['client_id'],
		]
	]);
	
	
	/* $arParams=[
		'URI'=>'/v1/categories/tree',		
	];
	$otvet=$obOzon->sendOzon($arParams); */
	//17037060 Комплект одежды мужской
	//17032629 Комплект одежды женский
	
	
	
	//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);
	
	
	$massa=[];
	if(!empty($V)){
		$massa[]=['ID','Наименование', 'Бренд', 'Страна', 'Размер', 'Материал', 'Пол', 'Штрихкод', 'Цвет', 'Сезон', 'Цена', 'Доступно', 'Описание'];
		$ggg=[];
		
			
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $IBLOCK_ID, 'SECTION_ID'=>$V, 'ACTIVE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y', '>CATALOG_STORE_AMOUNT_306'=>0), false, false, Array('ID','IBLOCK_ID','CATALOG_GROUP_2','NAME','PROPERTY_CML2_BAR_CODE','PROPERTY_BREND','PROPERTY_STRANA','PROPERTY_RAZMER','PROPERTY_MATERIAL','PROPERTY_IDGLAVNOGO','PROPERTY_POL','PROPERTY_TSVET','PROPERTY_SEZON', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DETAIL_PICTURE','IBLOCK_SECTION_ID'));
		
			while($arEl = $dbEl->GetNext())	
			{	
				$iskl='N';
				//$massa[]=[$barcode ,$arEl['CATALOG_QUANTITY'],$arEl['ID'],$arEl['NAME'],$arEl['PROPERTY_CML2_BAR_CODE_VALUE']];
				//$massa[$barcode]['QUANTITY']=$arEl['CATALOG_QUANTITY'];
				//$massa[$barcode]['ID']=$arEl['ID'];
				//$massa[$barcode]['NAME']=$arEl['NAME'];
				//$massa[$barcode]['BAR']=$arEl['PROPERTY_CML2_BAR_CODE_VALUE'];
				//$massa[$barcode]=$arEl;
				if(empty($ggg[$arEl['ID']])){
					$arEl['PATH']=[];
					$db_old_groups = \CIBlockElement::GetElementGroups($arEl['ID'], true);
					while($ar_group = $db_old_groups->Fetch()){
						$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
						$realNavChain = array();
						$k=0;
						while ($arNav=$navChain->GetNext()){	
								if(in_array($arNav['ID'],[17907])){$iskl='Y'; break;}
								$realNavChain[]=['NAME'=>$arNav['NAME'],'ID'=>$arNav['ID'],'CODE'=>$arNav['CODE']];
						}
						$arEl['PATH'][]=$realNavChain;
					}
					if($iskl=='N'){
				$massa[$arEl['PROPERTY_POL_VALUE']][]=[
					$arEl['ID'],
					$arEl['NAME'],
					$arEl['PROPERTY_BREND_VALUE'],
					$arEl['PROPERTY_STRANA_VALUE'],
					$arEl['PROPERTY_RAZMER_VALUE'],
					$arEl['PROPERTY_MATERIAL_VALUE'],
					$arEl['PROPERTY_POL_VALUE'],
					$arEl['PROPERTY_CML2_BAR_CODE_VALUE'],
					$arEl['PROPERTY_TSVET_VALUE'],
					$arEl['PROPERTY_SEZON_VALUE'],
					$arEl['CATALOG_PRICE_2'],
					$arEl['CATALOG_QUANTITY'],
					//$arEl['PREVIEW_TEXT'],
					$arEl['DETAIL_TEXT'],
					$arEl['PATH'],
					\CFile::GetPath($arEl['DETAIL_PICTURE']),
					$arEl['PROPERTY_IDGLAVNOGO_VALUE'],
				];
				$ggg[$arEl['ID']]=$arEl['NAME'];
				}
				}
				//echo "<pre>";print_r($arEl);echo "</pre>";die;
			}
		
	}
	//\Kolchuga\Settings::xmp($massa,0, __FILE__.": ".__LINE__,true);
	//\Kolchuga\Settings::xmp($massa['Мужская'][0],0, __FILE__.": ".__LINE__,true);
	
	if(!empty($massa['Мужская'][0])){
		$arParams=[
			'URI'=>'/v2/product/import',		
			'BODY'=>[
				"items"=>[
					/* [
						"attributes"=> [							
							[
								"id" => 31, 
								"values" => [
									[
									"dictionary_value_id" => "5111285" ,
									//"value"=> $massa['Мужская'][0][2],
									] 
								] 
							], 
							[
								"id" => 4295, 
								"values" => [
									[
									"dictionary_value_id" => "35646" 
									] 
								] 
							], 
							[
								"id" => 4495, 
								"values" => [
									[
									"dictionary_value_id" => "30937" 
									] 
								] 
							], 
							[
								"id" => 8229, 
								"values" => [
									[
									"dictionary_value_id" => "93112" 
									] 
								] 
							], 
							[
								"id" => 9163, 
								"values" => [
									[
									"dictionary_value_id" => "22880" 
									] 
								] 
							],
							[
								"id" => 10096, 
								"values" => [
									[
									"dictionary_value_id" => "1494" ,
									//"value"=> $massa['Мужская'][0][8],
									] 
								] 
							], 
							/* [
								"id" => 8292, 
								"values" => [
									[
									"value"=> $massa['Мужская'][0][15],
									] 
								] 
							],  */
							/* [
								"id" => 12121, 
								"values" => [
									[
									"dictionary_value_id" => "76638426" 
									] 
								] 
							],   */
							/* "category" => [
								"id" => "17037060" 
							]  *//*
						],
						'barcode'=>$massa['Мужская'][0][7],
						'5111285'=>$massa['Мужская'][0][2],
						'1494'=>$massa['Мужская'][0][8],
						'category_id'=>17037060,
						'color'=>$massa['Мужская'][0][8],
						'price'=>$massa['Мужская'][0][10],
						'offer_id'=>$massa['Мужская'][0][0],
						'name'=>$massa['Мужская'][0][1],
						'primary_image'=>'https://kolchuga.ru'.$massa['Мужская'][0][14],
						'description'=>$massa['Мужская'][0][12],
						//'vendor'=>$massa['Мужская'][0][2],
						"vat"=> "20",
						"weight"=> 0,
						"weight_unit"=> "g",
						"width"=> 0,
						"depth"=> 0,
						"dimension_unit"=> "mm",
						"height"=> 0,
					],	 */		
					
					[
    'barcode'        => $massa['Мужская'][0][7],
    'description'    => $massa['Мужская'][0][12],
    'category_id'    => 17037060,
    'name'           => $massa['Мужская'][0][1],
    'offer_id'       => $massa['Мужская'][0][0],
    'price'          => $massa['Мужская'][0][10],
    'vat'            => '20',
    'vendor'         => $massa['Мужская'][0][2],    
    'height'         => 120,
    'depth'          => 120,
    'width'          => 120,
    'dimension_unit' => 'mm',
    'weight'         => 120,
    'weight_unit'    => 'g',
    'images'         => [
        [
            'file_name' => 'https://kolchuga.ru'.$massa['Мужская'][0][14],
            'default'   => true,
        ],        
    ],
    'attributes'     => [
        [
            'id'    => 31,
            'value' => $massa['Мужская'][0][2],   
        ],
        [
            'id'    => 4295,
            'value' => $massa['Мужская'][0][4],   
        ],
        /*[
            'id'    => 4495,
            'value' => 30937,   
        ],
		[
            'id'    => 8292,
            'value' => 93112,   
        ],

        [
            'id'         => 9163,
            'value' => 22880,
        ],
        [
            'id'         => 10096,
            'value' => 61574,
        ], */
		[
            'id'    => 4495,
            'value' => $massa['Мужская'][0][9],   
        ],
		[
            'id'    => 8292,
            'value' => $massa['Мужская'][0][15],   
        ],

        [
            'id'         => 9163,
            'value' => $massa['Мужская'][0][6],
        ],
        /* [
            'id'         => 10096,
            'value' => $massa['Мужская'][0][8],
        ], */ 
        
    ],
]
				]
			
			
    /* "items": [
        {
            "attributes": [
                {
                    "complex_id": 0,
                    "id": 0,
                    "values": [
                        {
                            "dictionary_value_id": 0,
                            "value": "string"
                        }
                    ]
                }
            ],
            "barcode": "string",
            "category_id": 0,
            "color_image": "string",
            "complex_attributes": [
                {
                    "attributes": [
                        {
                            "complex_id": 0,
                            "id": 0,
                            "values": [
                                {
                                    "dictionary_value_id": 0,
                                    "value": "string"
                                }
                            ]
                        }
                    ]
                }
            ],
            "depth": 0,
            "dimension_unit": "string",
            "height": 0,
            "images": [
                "string"
            ],
            "primary_image": "string",
            "images360": [
                "string"
            ],
            "name": "string",
            "offer_id": "string",
            "old_price": "string",
            "pdf_list": [
                {
                    "index": 0,
                    "name": "string",
                    "src_url": "string"
                }
            ],
            "premium_price": "string",
            "price": "string",
            "vat": "string",
            "weight": 0,
            "weight_unit": "string",
            "width": 0
        }
    ] */

			],		
		];
		
		
		$arParamstree=[
			'URI'=>'/v1/category/tree',		
			'BODY'=>[
				'language' => 'RU'				
			]
		];
		$arCategorys = $obOzon->sendOzon($arParamstree);
			
		function sort_cat($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
		$sortCategorys = array();
		if(!empty($arCategorys['result'])){
			foreach ($arCategorys['result'] as $sort) {
				$sortCategorys[$sort['category_id']] = $sort;
			}
			usort($sortCategorys, "sort_cat");
		}
		//\Kolchuga\Settings::xmp($arCategorys,0, __FILE__.": ".__LINE__,true);die;
		if (!function_exists('array_write')) {
			$arSections=array();
			if(!empty($CAT_IDS)){
				foreach($CAT_IDS as $zn){
					$arSections[]=explode('/',$zn)[0];
				}
			}
			function array_write($array, $i=0, $arSections)
			{
				foreach ($array as $key => $value) {

					if (count($value['children']) > 0) {
						if($key == 0) {$i++; $px= $i*20;}

						if($i == 2) echo '<div class="view-source">';
						if($i == 2)
							echo '<a href="javascript:void(0);" style="display:block; padding-left: '.$px.'px"><span> + </span>'.$value['title'].'</a>';
						if($i == 1)
							echo '<div style="display:block; padding-left: '.$px.'px">'.$value['title'].'</div>';

						if($i!=1)    echo '<div class="hide">';
						\array_write($value['children'], $i, $arSections);
						if($i!=1)    echo '</div>';

						if($i==2) echo '</div>';


					} else {
						$i=0;
						?>
						<div style="padding-left: 60px">
							<input type="checkbox" name="cat_ids[]" <?echo in_array($value['category_id'], $arSections)? 'checked' : ''?> id="id_<?=$value['category_id']?>" value="<?=$value['category_id'].'/'.$value['title']?>"><label for="id_<?=$value['category_id']?>"><?=$value['title'].' ('.$value['category_id'].')'?></label>
						</div>
						<?
					}
				}
			}
		}
		
		
		
		/* \Kolchuga\Settings::xmp(json_encode($arParams['BODY'], JSON_UNESCAPED_UNICODE),0, __FILE__.": ".__LINE__,true);die;
		$otvet=$obOzon->sendOzon($arParams);
		\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true); */
		
		if(!empty($CAT_IDS)){
			
		}
	}
	
?>


<div class="crm-admin-wrap">
<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<? CJSCore::Init(array("jquery"));?>
<style>
.hide{display:none;}
.nohide{display:block;}
.viboriblock{	
    padding: 1em;
    border: 1px dotted #3c0beb;
    margin: 10px 0;
}
#tree{
	padding: 1em 2em;
    border: 1px dotted #067c58;
    margin: 10px 0;
}
.viboriblockozon{
	padding: 1em 1.2em;
    border: 1px dotted #4bf50b;
    margin: 10px 0;
}
</style>
<script>
$(document).on('click','.view-source a', function(){
	var nextclass=$(this).next('div');
	if(nextclass.hasClass("hide")){
		nextclass.removeClass("hide");
		nextclass.addClass("nohide");
	}else{
		nextclass.removeClass("nohide");
		nextclass.addClass("hide");
	}
});
</script>

<form action='' method='get'>
<input type='hidden' name='lang' value='ru' >
<div class="viboriblock">
<script>
		function changeIblockSites(iblockId)
		{
			var iblockSites = <?=CUtil::PhpToJSObject($iblockSites); ?>,
				iblockMultiSites = <?=CUtil::PhpToJSObject($iblockMultiSites); ?>,
				tableRow = null,
				siteControl = null,
				i,
				currentSiteList;

			tableRow = BX('tr_SITE_ID');
			siteControl = BX('SITE_ID');
			if (!BX.type.isElementNode(tableRow) || !BX.type.isElementNode(siteControl))
				return;

			for (i = siteControl.length-1; i >= 0; i--)
				siteControl.remove(i);
			if (typeof(iblockSites[iblockId]) !== 'undefined')
			{
				currentSiteList = iblockSites[iblockId]['SITES'];
				for (i = 0; i < currentSiteList.length; i++)
				{
					siteControl.appendChild(BX.create(
						'option',
						{
							props: {value: BX.util.htmlspecialchars(currentSiteList[i].ID)},
							html: BX.util.htmlspecialchars('[' + currentSiteList[i].ID + '] ' + currentSiteList[i].NAME)
						}
					));
				}
			}
			if (siteControl.length > 0)
				siteControl.selectedIndex = 0;
			else
				siteControl.selectedIndex = -1;
			BX.style(tableRow, 'display', (siteControl.length > 1 ? 'table-row' : 'none'));
		}
		</script>
<?$siteList = array();
	$iterator = Main\SiteTable::getList(array(
		'select' => array('LID', 'NAME', 'SORT'),
		'filter' => array('=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC')
	));
	while ($row = $iterator->fetch())
		$siteList[$row['LID']] = $row['NAME'];
	unset($row, $iterator);
	$iblockIds = array();
	$iblockSites = array();
	$iblockMultiSites = array();
	$iterator = Catalog\CatalogIblockTable::getList(array(
		'select' => array(
			'IBLOCK_ID',
			'PRODUCT_IBLOCK_ID',
			'IBLOCK_ACTIVE' => 'IBLOCK.ACTIVE',
			'PRODUCT_IBLOCK_ACTIVE' => 'PRODUCT_IBLOCK.ACTIVE'
		),
		'filter' => array('')
	));
	while ($row = $iterator->fetch())
	{
		$row['PRODUCT_IBLOCK_ID'] = (int)$row['PRODUCT_IBLOCK_ID'];
		$row['IBLOCK_ID'] = (int)$row['IBLOCK_ID'];
		if ($row['PRODUCT_IBLOCK_ID'] > 0)
		{
			if ($row['PRODUCT_IBLOCK_ACTIVE'] == 'Y')
				$iblockIds[$row['PRODUCT_IBLOCK_ID']] = true;
		}
		else
		{
			if ($row['IBLOCK_ACTIVE'] == 'Y')
				$iblockIds[$row['IBLOCK_ID']] = true;
		}
	}
	unset($row, $iterator);
	if (!empty($iblockIds))
	{
		$activeIds = array();
		$iterator = Iblock\IblockSiteTable::getList(array(
			'select' => array('IBLOCK_ID', 'SITE_ID', 'SITE_SORT' => 'SITE.SORT'),
			'filter' => array('@IBLOCK_ID' => array_keys($iblockIds), '=SITE.ACTIVE' => 'Y'),
			'order' => array('IBLOCK_ID' => 'ASC', 'SITE_SORT' => 'ASC')
		));
		while ($row = $iterator->fetch())
		{
			$id = (int)$row['IBLOCK_ID'];

			if (!isset($iblockSites[$id]))
				$iblockSites[$id] = array(
					'ID' => $id,
					'SITES' => array()
				);
			$iblockSites[$id]['SITES'][] = array(
				'ID' => $row['SITE_ID'],
				'NAME' => $siteList[$row['SITE_ID']]
			);

			if (!isset($iblockMultiSites[$id]))
				$iblockMultiSites[$id] = false;
			else
				$iblockMultiSites[$id] = true;

			$activeIds[$id] = true;
		}
		unset($id, $row, $iterator);
		if (empty($activeIds))
		{
			$iblockIds = array();
			$iblockSites = array();
			$iblockMultiSites = array();
		}
		else
		{
			$iblockIds = array_intersect_key($iblockIds, $activeIds);
		}
		unset($activeIds);
	}
	if (empty($iblockIds))
	{

	}

	$currentList = array();
	if ($IBLOCK_ID > 0 && isset($iblockIds[$IBLOCK_ID]))
	{
		$currentList = $iblockSites[$IBLOCK_ID]['SITES'];
		if ($SITE_ID === '')
		{
			$firstSite = reset($currentList);
			$SITE_ID = $firstSite['ID'];
		}
	}
	echo GetIBlockDropDownListEx(
		$IBLOCK_ID, 'IBLOCK_TYPE_ID', 'IBLOCK_ID',
		array(
			'ID' => array_keys($iblockIds),
			'CHECK_PERMISSIONS' => 'Y',
			'MIN_PERMISSION' => 'U'
		),
		"ClearSelected(); changeIblockSites(0); BX('id_ifr').src='/api/ozon_util.php?IBLOCK_ID=0&'+'".bitrix_sessid_get()."';",
		"ClearSelected(); changeIblockSites(this[this.selectedIndex].value); BX('id_ifr').src='/api/ozon_util.php?IBLOCK_ID='+this[this.selectedIndex].value+'&'+'".bitrix_sessid_get()."';",
		'class="adm-detail-iblock-types"',
		'class="adm-detail-iblock-list"'
	);
	?>
		<script>
		var TreeSelected = [];
		<?
		$intCountSelected = 0;
		if (!empty($V) && is_array($V))
		{
			foreach ($V as $oneKey)
			{
				?>TreeSelected[<? echo $intCountSelected ?>] = <? echo (int)$oneKey; ?>;
				<?
				$intCountSelected++;
			}
		}
		?>
		function ClearSelected()
		{
			BX.showWait();
			TreeSelected = [];
		}
		</script>

<?
	if ($intCountSelected)
	{
		foreach ($V as $oneKey)
		{
			$oneKey = (int)$oneKey;
			?><input type="hidden" value="<? echo $oneKey; ?>" name="V[]" id="oldV<? echo $oneKey; ?>"><?
		}
		unset($oneKey);
	}
	?>
	</div>
	<div id="tree"></div>
	<script>
	BX.showWait();
	clevel = 0;

	function delOldV(obj)
	{
		if (!!obj)
		{
			var intSelKey = BX.util.array_search(obj.value, TreeSelected);
			if (obj.checked == false)
			{
				if (-1 < intSelKey)
				{
					TreeSelected = BX.util.deleteFromArray(TreeSelected, intSelKey);
				}

				var objOldVal = BX('oldV'+obj.value);
				if (!!objOldVal)
				{
					objOldVal.parentNode.removeChild(objOldVal);
					objOldVal = null;
				}
			}
			else
			{
				if (-1 == intSelKey)
				{
					TreeSelected[TreeSelected.length] = obj.value;
				}
			}
		}
	}

	function buildNoMenu()
	{
		var buffer;
		buffer = '<?echo GetMessageJS("CET_FIRST_SELECT_IBLOCK");?>';
		BX('tree', true).innerHTML = buffer;
		BX.closeWait();
	}

	function buildMenu()
	{
		var i,
			buffer,
			imgSpace,
			space;

		buffer = '<table border="0" cellspacing="0" cellpadding="0">';
		buffer += '<tr>';
		buffer += '<td colspan="2" valign="top" align="left"><input type="checkbox" name="V[]" value="0" id="v0"'+(BX.util.in_array(0,TreeSelected) ? ' checked' : '')+' onclick="delOldV(this);"><label for="v0"><font class="text"><b><?echo CUtil::JSEscape(GetMessage("CET_ALL_GROUPS"));?></b></font></label></td>';
		buffer += '</tr>';

		for (i in Tree[0])
		{
			if (!Tree[0][i])
			{
				space = '<input type="checkbox" name="V[]" value="'+i+'" id="V'+i+'"'+(BX.util.in_array(i,TreeSelected) ? ' checked' : '')+' onclick="delOldV(this);"><label for="V'+i+'"><span class="text">' + Tree[0][i][0] + '</span></label>';
				imgSpace = '';
			}
			else
			{
				space = '<input type="checkbox" name="V[]" value="'+i+'"'+(BX.util.in_array(i,TreeSelected) ? ' checked' : '')+' onclick="delOldV(this);"><a href="javascript: collapse(' + i + ')"><span class="text"><b>' + Tree[0][i][0] + '</b></span></a>';
				imgSpace = '<img src="/bitrix/images/catalog/load/plus.gif" width="13" height="13" id="img_' + i + '" OnClick="collapse(' + i + ')">';
			}

			buffer += '<tr>';
			buffer += '<td width="20" valign="top" align="center">' + imgSpace + '</td>';
			buffer += '<td id="node_' + i + '">' + space + '</td>';
			buffer += '</tr>';
		}

		buffer += '</table>';

		BX('tree', true).innerHTML = buffer;
		BX.adminPanel.modifyFormElements('yandex_setup_form');
		BX.closeWait();
	}

	function collapse(node)
	{
		if (!BX('table_' + node))
		{
			var i,
				buffer,
				imgSpace,
				space;

			buffer = '<table border="0" id="table_' + node + '" cellspacing="0" cellpadding="0">';

			for (i in Tree[node])
			{
				if (!Tree[node][i])
				{
					space = '<input type="checkbox" name="V[]" value="'+i+'" id="V'+i+'"'+(BX.util.in_array(i,TreeSelected) ? ' checked' : '')+' onclick="delOldV(this);"><label for="V'+i+'"><font class="text">' + Tree[node][i][0] + '</font></label>';
					imgSpace = '';
				}
				else
				{
					space = '<input type="checkbox" name="V[]" value="'+i+'"'+(BX.util.in_array(i,TreeSelected) ? ' checked' : '')+' onclick="delOldV(this);"><a href="javascript: collapse(' + i + ')"><font class="text"><b>' + Tree[node][i][0] + '</b></font></a>';
					imgSpace = '<img src="/bitrix/images/catalog/load/plus.gif" width="13" height="13" id="img_' + i + '" OnClick="collapse(' + i + ')">';
				}

				buffer += '<tr>';
				buffer += '<td width="20" align="center" valign="top">' + imgSpace + '</td>';
				buffer += '<td id="node_' + i + '">' + space + '</td>';
				buffer += '</tr>';
			}

			buffer += '</table>';

			BX('node_' + node).innerHTML += buffer;
			BX('img_' + node).src = '/bitrix/images/catalog/load/minus.gif';
		}
		else
		{
			var tbl = BX('table_' + node);
			tbl.parentNode.removeChild(tbl);
			BX('img_' + node).src = '/bitrix/images/catalog/load/plus.gif';
		}
		BX.adminPanel.modifyFormElements('yandex_setup_form');
	}
	</script>
	<iframe src="/api/ozon_util.php?IBLOCK_ID=<?=intval($IBLOCK_ID)?>&<? echo bitrix_sessid_get(); ?>" id="id_ifr" name="ifr" style="display:none"></iframe>
	<div class="viboriblockozon">
	<?\array_write($sortCategorys, 0, $arSections);?></div>
	<input type='submit' value='Сохранить'>
</form>


</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>