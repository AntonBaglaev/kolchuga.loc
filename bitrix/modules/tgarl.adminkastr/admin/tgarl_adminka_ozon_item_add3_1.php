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

//$catalog_file_arr = include_once($_SERVER["DOCUMENT_ROOT"].'/api/ozon_id_'.$arrSetting['catalog_file'].'.php');

Loader::includeModule('iblock');



$items=[];
$res = CIBlockElement::GetList(
            ['CATALOG_PRICE_1' => 'desc'],
            [
                'IBLOCK_ID' => 76,
                'ACTIVE' => 'Y',
				'!PROPERTY_category_id'=>false,
				'PROPERTY_ozon_id'=>false,
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
			
			$attrebutJ=json_decode($fields['PREVIEW_TEXT'], true);
			//\Kolchuga\Settings::xmp($attrebutJ,0, __FILE__.": ".__LINE__,true);die; 
			
			$nextEl='Y';
			foreach($attrebutJ as $ktg_key=>$val_arr){
				foreach($val_arr as $ktg_key1=>$val_arr1){
					if(isset($val_arr1['value']) && empty($val_arr1['value'])){
						$nextEl='N';
					}elseif(isset($val_arr1['dictionary_value_id']) && empty($val_arr1['dictionary_value_id'])){
						$nextEl='N';
					}
				}
			}
			if($nextEl=='N'){continue;}
			
			$items[$fields['ID']] = [
                'ID' => $fields['ID'],
                'ACTIVE' => $fields['ACTIVE'],
                'NAME' => $fields['NAME'],
                'description' => $fields['DETAIL_TEXT'],
                'attr' => $attrebutJ,
            ];
			$ids[] = $fields['ID'];	
			$rprArr[$fields['ID']] = $fields['ID'];	
			$cena[$fields['NAME']]=$fields['ID'];
		}
		if(!empty($rprArr)){
			
			\CIBlockElement::GetPropertyValuesArray($rprArr, 76, array(
				//'ID' => array_keys($items),
				'ID' => $rprArr,
				'IBLOCK_ID' => 76,
			));
			foreach($rprArr as $kl=>$vl){
				$items[$kl]['PROPERTIES'] = $vl;
				
				$attributes=[];
				foreach($items[$kl]['attr'][$vl['category_id']['VALUE']] as $idAtr=>$zn){
					$qqq=[];
					$qqq['id']=$idAtr;
					if(!empty($zn['value'])){
						$qqq['values'][]=['value'=>$zn['value']];
					}else{
						$qqq['values'][]=['dictionary_value_id'=>$zn['dictionary_value_id']];
					}
					$attributes[]=$qqq;
				}
				
				if(!empty($items[$kl]['description'])){
					$qqq=[];
					$qqq['id']=4191;
					$qqq['values'][]=['value'=>$items[$kl]['description']];
					$attributes[]=$qqq;
				}
				
				$items[$kl]['PROPS'] = [
						'offer_id' => $vl['offer_id']['VALUE'],
						'name' => $vl['name']['VALUE'],
						'vendor' => $vl['vendor']['VALUE'],
						'barcode' => $vl['barcode']['VALUE'],
						'category_id' => intval($vl['category_id']['VALUE']),
						'primary_image' => $vl['primary_image']['VALUE'],
						"vat" => "0.2", //vat указывается в таком формате
						"height" => (!empty($vl['height']['VALUE']) ? $vl['height']['VALUE'] : 300 ),
						"depth" => (!empty($vl['depth']['VALUE']) ? $vl['depth']['VALUE'] : 300 ),
						"width" => (!empty($vl['width']['VALUE']) ? $vl['width']['VALUE'] : 300 ),
						"dimension_unit" =>  "mm",
						"weight" => (!empty($vl['weight']['VALUE']) ? $vl['weight']['VALUE'] : 300 ),
						"weight_unit" =>  "g",
						//'description' => $items[$kl]['description'],
						'attributes' => $attributes,
					];
				$inOzon[$kl]=$items[$kl]['PROPS'];
			}//attributes
			
			//$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'ID'=>array_keys($cena) ), false, false, Array('ID','IBLOCK_ID','CATALOG_GROUP_2','CATALOG_STORE_AMOUNT_306'));		
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'ID'=>array_keys($cena) ), false, false, Array('ID','IBLOCK_ID','CATALOG_GROUP_2'));		
			while($arEl = $dbEl->GetNext())	
			{
				$inOzon[$cena[$arEl['ID']]]['price']=$arEl['CATALOG_PRICE_2'];
			}
		}

$itogSends=[];
//\Kolchuga\Settings::xmp($inOzon,0, __FILE__.": ".__LINE__,true);die; 
if(!empty($_REQUEST['save'])){
	//создаем объект
	$obOzon = new \Kolchuga\Ozona();
	//устанавливаем для текущего объекта ключи API
	$obOzon->setOption([
		'CURL'=>[
			'KEY'=>$arrSetting['token'],
			'CID'=>$arrSetting['client_id'],
		]
	]);
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
	}
}


	

?>


<div class="crm-admin-wrap">


<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<? CJSCore::Init(array("jquery"));?>

<?if(!empty($itogSends)){
	\Kolchuga\Settings::xmp($itogSends,0, __FILE__.": ".__LINE__,true);
}else{?>
<?if(!empty($inOzon)){?>

<?//\Kolchuga\Settings::xmp($inOzon,0, __FILE__.": ".__LINE__,true);die;?>

<form action='' method='post'>
<input type='hidden' name='lang' value='ru' >
<table class="table table-striped">
	<thead>
		<tr>
		<th>№</th>
		<?
		$ddd=$inOzon;
		$fruit = array_shift($ddd);
		$yach=count($fruit);
		?>
		<?foreach($fruit as $kkl=>$vl){?>
			<th><?=$kkl?></th>
		<?}?>	     
		</tr>
	</thead>
	<tbody>
		<?$nb=1;
		foreach($inOzon as $pol=>$value){
			//if($nb<200){$nb++;continue;}
			?>
			<tr>
				<td><?=$nb?></td>
				<?$yach0=$yach;?>
				<?foreach($value as $kkl=>$val){?>	
					<td>
						<?if($kkl=='attributes'){?>
							<div style="text-overflow: ellipsis; white-space: nowrap; width: 200px; overflow: hidden;">
								<?foreach($val as $vl){?>
									<?
									echo 'id: '.$vl['id'].'<br>';
									echo 'value: '.(!empty($vl['values'][0]['dictionary_value_id']) ? $vl['values'][0]['dictionary_value_id'] : $vl['values'][0]['value']).'<br>';
									?>
									<br>
								<?}?>
							</div>
						<?}else{?>
							<?=$val?>
						<?}?>
					</td>
					<?
					$yach0--;
					?>
				<?}?>
				<?if($yach0>0){
					for ($i = 1; $i <= $yach0; $i++) {
						echo '<td>&nbsp;</td>';
					}
				}?>
			</tr>
		<?
		$nb++;
		}?>					
	</tbody>
	
</table>
	<input type='submit' name="save" value='Отправить на ОЗОН'>
</form>
<?}else{?>
<p>Нет товаров для загрузки на озон.</p>
<p>Либо все уже загружено, либо не подготовлены товары на предыдущем шаге</p>
<?}?>
<?}?>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>