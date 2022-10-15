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
					'in_arhive' => $vl['in_arhive']['VALUE'],					
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
$selectAr=Array('ID','IBLOCK_ID','NAME','ACTIVE','CATALOG_GROUP_2',);
$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filterAr, false, false, $selectAr );
while($fields = $dbEl->GetNext())	{	
	$items[$cena[$fields['ID']]]['price']=$fields['CATALOG_PRICE_2'];
}
		

	

$itogSends=[];

if(!empty($_REQUEST['save']) && !empty($_REQUEST['set'])){
	

		
	$setArray=$_REQUEST['set'];
	
	$kol=1;
	$el100=[];
	$i=0;
	$inarhive=[];
	$fromarhive=[];
	
	foreach($items as $key=>$values){
		if($setArray[$values['PROPS']['ozon_id']]!='Y'){continue;}
		//\Kolchuga\Settings::xmp($values,0, __FILE__.": ".__LINE__,true);
				
		if($kol==1000){$kol=1; $i++;}
		$values['price']=ceil($values['price']);
		$itemEl=[
			//"offer_id"=> $values['PROPS']['offer_id'],
			"product_id"=> intval($values['PROPS']['ozon_id']),
			"price"=> (string)$values['price'],
			"old_price"=> "0",			
		];
		$el100[$i][]= $itemEl;
		$kol++;
	}
	
	//\Kolchuga\Settings::xmp($el100,0, __FILE__.": ".__LINE__,true);
	if(!empty($el100)){
		foreach($el100 as $itemEl0){
			$otvet=$obOzon->setNewPrice($itemEl0);
			$itogSends[]=$otvet;
			//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);
		}
	}
	
	//die;
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

<form action='' method='post'>
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
	<input type='submit' name="save" value='Отправить цены на ОЗОН'>
</form>

<?}?>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>