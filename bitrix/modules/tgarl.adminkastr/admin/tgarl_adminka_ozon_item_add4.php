<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Загрузить товары на Ozon');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Main\Loader;
//$arrSetting=\Bitrix\Main\Config\Option::get('tg_ozon','');

$arrSetting=\Bitrix\Main\Config\Option::getForModule('tg_ozon');
//создаем объект
	$obOzon = new \Kolchuga\Ozona();
	//устанавливаем для текущего объекта ключи API
	$obOzon->setOption([
		'CURL'=>[
			'KEY'=>$arrSetting['token'],
			'CID'=>$arrSetting['client_id'],
		]
	]);

//$catalog_file_arr = include_once($_SERVER["DOCUMENT_ROOT"].'/api/ozon_id_'.$arrSetting['catalog_file'].'.php');

Loader::includeModule('iblock');



$items=[];
$res = CIBlockElement::GetList(
            ['CATALOG_PRICE_1' => 'desc'],
            [
                'IBLOCK_ID' => 76,
                'ACTIVE' => 'Y',
				'!PROPERTY_category_id'=>false,
				'!PROPERTY_ozon_id'=>false,
            ],
            false,
            false,
            [
               'ID',
                'ACTIVE',
                'NAME',
                'PREVIEW_TEXT',
                'DETAIL_TEXT',                
            ]
        );
		$rprArr=[];
        while ($fields = $res->Fetch()) {
			$items[$fields['ID']] = [
                'ID' => $fields['ID'],
                'ACTIVE' => $fields['ACTIVE'],
                'NAME' => $fields['NAME'],                
            ];
			$ids[] = $fields['ID'];	
			$rprArr[$fields['ID']] = $fields['ID'];	
			$cena[$fields['NAME']]=$fields['ID'];
		}
		
		\CIBlockElement::GetPropertyValuesArray($rprArr, 76, array(
            //'ID' => array_keys($items),
            'ID' => $rprArr,
            'IBLOCK_ID' => 76,
        ));
		foreach($rprArr as $kl=>$vl){
			//$items[$kl]['PROPERTIES'] = $vl;			
			
			$items[$kl]['PROPS'] = [
					'ozon_id' => $vl['ozon_id']['VALUE'],
					'offer_id' => $vl['offer_id']['VALUE'],
					'name' => $vl['name']['VALUE'],
					'vendor' => $vl['vendor']['VALUE'],
					'barcode' => $vl['barcode']['VALUE'],
					'category_id' => intval($vl['category_id']['VALUE']),					
					'in_arhive' => intval($vl['in_arhive']['VALUE']),					
				];
			
		}
		
		/* $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'ID'=>array_keys($cena) ), false, false, Array('ID','IBLOCK_ID','CATALOG_GROUP_2','CATALOG_STORE_AMOUNT_306'));		
		while($arEl = $dbEl->GetNext())	
		{
			$items[$cena[$arEl['ID']]]['price']=$arEl['CATALOG_PRICE_2'];
			//$items[$cena[$arEl['ID']]]['quantity']=$arEl['CATALOG_QUANTITY'];
			
			$items[$cena[$arEl['ID']]]['quantity']=0;
			if($arEl['CATALOG_STORE_AMOUNT_306']>0){
				$items[$cena[$arEl['ID']]]['quantity']=$arEl['CATALOG_STORE_AMOUNT_306'];
				if($arEl['CATALOG_QUANTITY']<$arEl['CATALOG_STORE_AMOUNT_306']){
					$items[$cena[$arEl['ID']]]['quantity']=$arEl['CATALOG_QUANTITY'];
				}
			}
		} */
		
		
		
		
		$filterAr=array('IBLOCK_ID' => 40, 'ID'=>array_keys($cena) );
$selectAr=Array('ID','IBLOCK_ID','NAME','ACTIVE','CATALOG_GROUP_2','CATALOG_STORE_AMOUNT_306','CATALOG_STORE_AMOUNT_282','CATALOG_STORE_AMOUNT_322','CATALOG_STORE_AMOUNT_281','CATALOG_STORE_AMOUNT_321','CATALOG_STORE_AMOUNT_323','CATALOG_STORE_AMOUNT_320');
$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filterAr, false, false, $selectAr );
while($fields = $dbEl->GetNext())	{	
	$items[$cena[$fields['ID']]]['price']=$fields['CATALOG_PRICE_2'];
	$items[$cena[$fields['ID']]]['quantity']=0;		
		
		$onsklad = $fields['CATALOG_STORE_AMOUNT_306'] + $fields['CATALOG_STORE_AMOUNT_282'] + $fields['CATALOG_STORE_AMOUNT_322'] + $fields['CATALOG_STORE_AMOUNT_281'] + $fields['CATALOG_STORE_AMOUNT_321'] + $fields['CATALOG_STORE_AMOUNT_323'] + $fields['CATALOG_STORE_AMOUNT_320'];
		if(	$onsklad > 0 ){
			$items[$cena[$fields['ID']]]['quantity'] = $onsklad;
			
			if($fields['CATALOG_QUANTITY'] < $onsklad){
				$items[$cena[$fields['ID']]]['quantity'] = $fields['CATALOG_QUANTITY'];
			}
		}
		
		if($items[$cena[$fields['ID']]]['quantity'] > 0){
			
			$pos = strpos($fields['NAME'], 'Куртк');
			if ($pos === false) {
		
				$MarkingCodeGroup=$obOzon->isUfProductGroup($fields['ID']);
				if($MarkingCodeGroup>0){
					$items[$cena[$fields['ID']]]['quantity']=0;
				}else{
					$iskl='N';
						$fields['PATH']=[];
						$db_old_groups = \CIBlockElement::GetElementGroups($fields['ID'], true);
						while($ar_group = $db_old_groups->Fetch()){
							$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
							$realNavChain = array();
							$k=0;
							while ($arNav=$navChain->GetNext()){	
									if(in_array($arNav['ID'],[17907,18357])){$iskl='Y'; break;}									
							}							
						}
					if($iskl=='Y'){
						$items[$cena[$fields['ID']]]['quantity']=0;
					}
				}
			}else{
				$items[$cena[$fields['ID']]]['quantity']=0;
			}
		}		
}
		
		
		
		
		
		
		
		
		
		
/* 		//CModule::IncludeModule('catalog');
$arFilter = Array("PRODUCT_ID"=>array_keys($cena),"STORE_ID"=>306);
$res = \CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array());
if ($arRes = $res->GetNext()){
	if($arRes['AMOUNT']>0){
		$items[$cena[$arRes['PRODUCT_ID']]]['quantity']=$arRes['AMOUNT'];
	}
	//\Kolchuga\Settings::xmp($arRes,0, __FILE__.": ".__LINE__,true);die; 
} */
	

$itogSends=[];
//\Kolchuga\Settings::xmp($items,0, __FILE__.": ".__LINE__,true);die; 
if(!empty($_REQUEST['save']) && !empty($_REQUEST['set'])){
	
//\Kolchuga\Settings::xmp($arrSetting,0, __FILE__.": ".__LINE__,true);die;
	$skladArr=$obOzon->getWareHouse();
	$warehouse_id=$skladArr['result'][0]['warehouse_id'];	
	
	if(empty($warehouse_id)){$warehouse_id=17427940973000;}
	
	
	$setArray=$_REQUEST['set'];
	//\Kolchuga\Settings::xmp($setArray,0, __FILE__.": ".__LINE__,true);
	//\Kolchuga\Settings::xmp($items,0, __FILE__.": ".__LINE__,true);
	$kol=1;
	$el100=[];
	$i=0;
	$inarhive=[];
	$fromarhive=[];
	
	foreach($items as $key=>$values){
		if($setArray[$values['PROPS']['ozon_id']]!='Y'){continue;}
		
		if(intval($values['quantity']) < 1){			
			if($values['PROPS']['in_arhive']!=='Y'){			
				$inarhive[$values['PROPS']['offer_id']]=$values['PROPS']['ozon_id'];
			}else{
				continue;				
			}
		}
		
		if(intval($values['quantity']) > 0 && $values['PROPS']['in_arhive']=='Y'){
			$fromarhive[$values['PROPS']['offer_id']]=$values['PROPS']['ozon_id'];			
		}
		
		if($kol==100){$kol=1; $i++;}
		$itemEl=[
			"offer_id"=> $values['PROPS']['offer_id'],
			"product_id"=> intval($values['PROPS']['ozon_id']),
			"stock"=> intval($values['quantity']),
			"warehouse_id"=> intval($warehouse_id),
		];
		$el100[$i][]= $itemEl;
		$kol++;
	}
	//\Kolchuga\Settings::xmp($fromarhive,0, __FILE__.": ".__LINE__,true);
	if(!empty($fromarhive)){
		$otvet=$obOzon->setItemFromArhive($fromarhive);
		if($otvet['result']){
			foreach($fromarhive as $of_id=>$oz_id){
				$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, 'PROPERTY_offer_id'=>$of_id), false, false, Array('ID'));
				if($dbEl->SelectedRowsCount()>0){
					while($obEl = $dbEl->GetNext()){
						$what['in_arhive']='N';
						\CIBlockElement::SetPropertyValuesEx($obEl['ID'], false, $what);
					}
				}
			}
		}
	}
	//\Kolchuga\Settings::xmp($el100,0, __FILE__.": ".__LINE__,true);die;
	if(!empty($el100)){
		foreach($el100 as $itemEl0){
			$arParams=[
				'URI'=>'/v2/products/stocks',
				'BODY'=>[
					"stocks"=>$itemEl0
				]
			];
			//\Kolchuga\Settings::xmp($arParams,0, __FILE__.": ".__LINE__,true);//die; 
			$otvet=$obOzon->sendOzon($arParams);
			//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);
		}
	}
	//\Kolchuga\Settings::xmp($inarhive,0, __FILE__.": ".__LINE__,true);die;
	if(!empty($inarhive)){
		$otvet=$obOzon->setItemArhive($inarhive);
		\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);
		if($otvet['result']){
			foreach($inarhive as $of_id=>$oz_id){
				$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, 'PROPERTY_offer_id'=>$of_id), false, false, Array('ID'));
				if($dbEl->SelectedRowsCount()>0){
					while($obEl = $dbEl->GetNext()){
						$what['in_arhive']='Y';
						\CIBlockElement::SetPropertyValuesEx($obEl['ID'], false, $what);
					}
				}
			}
		}
	}
	
	/* 
	function setWareHouseStock($offer_id,$product_id=0,$stock=0,$warehouse_id=0){
		$arParams=[
			'URI'=>'/v2/products/stocks',		
			'BODY'=>[
				"stocks"=> [
					[
						"offer_id"=> $offer_id,
						"product_id"=> intval($product_id),
						"stock"=> intval($stock),
						"warehouse_id"=> intval($warehouse_id),
					]
				]
			]
		];
		
		$otvet=self::sendOzon($arParams);
		
		return $otvet;
	}
	
	
	$kol=1;
	$el100=[];
	$i=0;
	foreach($inOzon as $itemEl){
		if($kol==100){$kol=1; $i++;}
		$el100[$i][]= $itemEl;
		$kol++;
	}
	
	foreach($el100 as $itemEl){
		$arParams=[
			'URI'=>'/v2/product/import',
			'BODY'=>[
				"items"=>$itemEl
			]
		];
		//$arParamsJ=json_encode($arParams['BODY'], JSON_UNESCAPED_UNICODE);
		//\Kolchuga\Settings::xmp($arParamsJ,0, __FILE__.": ".__LINE__,true);die;
		$otvet=$obOzon->sendOzon($arParams);
		//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);die;
		$itogSends[]=$otvet;
	} */
}


	

?>


<div class="crm-admin-wrap">


<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<? CJSCore::Init(array("jquery"));?>

<?if(!empty($itogSends)){
	\Kolchuga\Settings::xmp($itogSends,0, __FILE__.": ".__LINE__,true);
}else{?>

<script  type="text/javascript">
  <!-- 
 $(function () {
     $("#selall").click(function  () {
         if  (!$("#selall").is(":checked")){ // если нет выделения 
              $(".withch .inputche").removeAttr("checked"); //то снять с дочерних
        }
        else{
             $(".withch .inputche").attr("checked","checked"); //иначе выделить дочерние
       }

     });
});

//-->
</script> 

<form action='/bitrix/admin/tgarl_adminka_ozon_item_add4.php?lang=ru' method='post'>
<input type='hidden' name='lang' value='ru' >
<table class="table table-striped">
	<thead>
		<tr>
		<th><input type='checkbox' name='selall' id='selall' value='Y' ></th>
		<?
		$ddd=$items;
		$fruit = array_shift($ddd);?>
		<?foreach($fruit as $kkl=>$vl){?>
			<th><?=$kkl?></th>
		<?}?>	     
		</tr>
	</thead>
	<tbody class="withch">
		<?//\Kolchuga\Settings::xmp($items,0, __FILE__.": ".__LINE__,true);
		foreach($items as $pol=>$value){?>
			<tr>
			<td><input type='checkbox' name='set[<?=$value['PROPS']['ozon_id']?>]' value='Y' class="inputche"></td>
				<?foreach($value as $kkl=>$val){?>
				
					<td><?if($kkl=='PROPS'){?>
							<?foreach($val as $attt=>$vl){?>
								<?echo $attt.': '.$vl.'<br>';?>								
							<?}?>
						<?}else{?>
							<?=$val?>
						<?}?></td>
				<?}?>
			</tr>
		<?}?>					
	</tbody>
	
</table>
	<input type='submit' name="save" value='Отправить остатки на ОЗОН'>
</form>

<?}?>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>