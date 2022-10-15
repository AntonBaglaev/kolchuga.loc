<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных
ini_set('memory_limit', '8192M');
$APPLICATION->SetTitle('Загрузить товары на Ozon');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Main\Loader;
//$arrSetting=\Bitrix\Main\Config\Option::get('tg_ozon','');

$arrSetting=\Bitrix\Main\Config\Option::getForModule('tg_ozon');

$catalog_file_arr = include_once($_SERVER["DOCUMENT_ROOT"].'/api/ozon_id_'.$arrSetting['catalog_file'].'.php');

Loader::includeModule('iblock');


$is_obnova='N';

if(!empty($_REQUEST['save'])){
//\Kolchuga\Settings::xmp($_REQUEST,0, __FILE__.": ".__LINE__,true);die; 

	$el = new \CIBlockElement;
	$setArray=$_REQUEST['set'];
	$logArr=[];
	$logAttr=[];
	foreach($setArray as $key=>$values){
		$ID=0;
		if(!empty($values['category_id']) && $values['active']=='Y'){
			$logArr0=[];
			$logArr0=$values;
			$arLoadProductArray = Array();
			$arLoadProductArray['IBLOCK_ID']=76;
			$arLoadProductArray['NAME']=$key;
			$arLoadProductArray['ACTIVE']='Y';
			$arLoadProductArray['DETAIL_TEXT']=$values['description'];
			$arLoadProductArray['PREVIEW_TEXT']=json_encode($values['attr'], JSON_UNESCAPED_UNICODE);			
			
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, '=NAME'=>$key), false, false, Array('ID'));
			while($obEl = $dbEl->GetNext()){
				$ID=$obEl['ID'];
			}
			
			if($ID>0){
				$el->Update($ID, $arLoadProductArray);
				
				$what['offer_id']=$values['offer_id'];
				$what['name']=$values['name'];
				$what['vendor']=$values['vendor'];
				$what['barcode']=$values['barcode'];
				$what['category_id']=$values['category_id'];
				$what['primary_image']=$values['primary_image'];
				$what['height']=$values['height'];
				$what['depth']=$values['depth'];
				$what['width']=$values['width'];
				$what['weight']=$values['weight'];
				\CIBlockElement::SetPropertyValuesEx($ID, false, $what);
				$is_obnova='Y';
				$logArr0['is_obnova']='Y';
			}
			$logArr[$key]=$logArr0;
			$logAttr[$key]=$logArr0['attr'];
		}
	}
	
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/ozon_log_2.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($logArr, true), FILE_APPEND | LOCK_EX);
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/ozon_log_2_attr.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($logAttr, true), FILE_APPEND | LOCK_EX);
	//\Kolchuga\Settings::xmp($_REQUEST,0, __FILE__.": ".__LINE__,true);die;
}




if($is_obnova=='N'){
	
	$itemlist=[];
	$itemlist_cid=[];
	$listItemFromS=[];
	foreach($catalog_file_arr['CAT_OZON_LIST'] as $cid=>$idname){
		foreach($idname as $nameid){
			$itemlist[]=$nameid;
		}	
		$itemlist_cid[]=$cid;
	}
	
	//if ($USER->GetID()=="11460"){$itemlist_cid[]=17034563;$itemlist[]='1';}
	
	if(!empty($itemlist)){
		
		
			$categor_name=[];
			foreach($catalog_file_arr['CAT_IDS'] as $zn){				
				$arCI=explode('/',$zn);
				$categor_name[$arCI[0]]=$arCI[1];
			}
			
			Loader::includeModule('highloadblock');
			$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(9)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
			$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
			$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)
			
			$rsData = $entity_data_class::getList(array(
				//"select" => array('*'), //выбираем все поля
				"select" => array('UF_SECTION','UF_ID_SPRAVOCHIKA','UF_NAME_ATTR','UF_CODE_VALUE',), //выбираем все поля
				"filter" => array("@UF_SECTION" => $itemlist_cid),				
			));
			while($arData = $rsData->Fetch()){
							   
			   $catalog_file_arr['CAT_OZON_ATR'][$arData['UF_SECTION']][$arData['UF_ID_SPRAVOCHIKA']]['NAME']=$arData['UF_NAME_ATTR'];
			   $catalog_file_arr['CAT_OZON_ATR'][$arData['UF_SECTION']][$arData['UF_ID_SPRAVOCHIKA']]['CODE']=$arData['UF_CODE_VALUE'];
			   //$catalog_file_arr['CAT_OZON_ATR'][$arData['UF_SECTION']][$arData['UF_ID_SPRAVOCHIKA']]['ATTR'][]=['id'=>$arData['UF_ID_VALUE'],'value'=>$arData['UF_VALUE']];
			   
			}
			  // \Kolchuga\Settings::xmp($catalog_file_arr,0, __FILE__.": ".__LINE__,true); //die;
			   
			   $res = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, 'NAME'=>$itemlist, 'PROPERTY_ozon_id'=>false), false, array("nPageSize" => 10), [ 'ID','IBLOCK_ID', 'ACTIVE', 'NAME', 'PREVIEW_TEXT' ] );
			$res->NavStart(0);
			$navob=$res;
			$rprArr0=[];
			$ids0=[];
			$items0=[];
			$itemlist_nav=[];
			while ($fields = $res->GetNext()) {					
					$items0[$fields['ID']] = [
						'ID' => $fields['ID'],
						'ACTIVE' => $fields['ACTIVE'],
						'NAME' => $fields['NAME'],
						'PREVIEW_TEXT' => json_decode($arEl['~PREVIEW_TEXT'], true),						
					];					
					$ids0[] = $fields['ID'];	
					$rprArr0[$fields['ID']] = $fields['ID'];
					$itemlist_nav[]=$fields['NAME'];
			}		
			
			\CIBlockElement::GetPropertyValuesArray($rprArr0, 76, array(
				'ID' => $rprArr0,
				'IBLOCK_ID' => 76,
			));
			
			foreach($rprArr0 as $kl=>$vl){
				$items0[$kl]['PROPERTIES'] = $vl;								
				$listItemFromS[$items0[$kl]['NAME']]=$items0[$kl];
			}
			unset($items0);
			unset($rprArr0);
			unset($ids0);
			unset($fields);
			  // \Kolchuga\Settings::xmp($listItemFromS,0, __FILE__.": ".__LINE__,true); die;
		
			
	}
	
	
	$massa=[];

	if(!empty($itemlist)){
		//создаем объект
		$obOzonA = new \Kolchuga\Ozona();
		//устанавливаем для текущего объекта ключи API
		$obOzonA->setOption([
			'CURL'=>[
				'KEY'=>$arrSetting['token'],
				'CID'=>$arrSetting['client_id'],
			]
		]);
		

		
			
			$filterAr=array('IBLOCK_ID' => $catalog_file_arr['IBLOCK_ID'], 'ID'=>$itemlist_nav);
			$items=[];
			$res = \CIBlockElement::GetList(array('sort' => 'asc'), $filterAr, false, false, [ 'ID','IBLOCK_ID', 'ACTIVE', 'NAME', 'DETAIL_TEXT', 'DETAIL_PICTURE','CATALOG_GROUP_2','DETAIL_PAGE_URL' ] );
			$rprArr=[];
			$uriArr=[];
			while ($fields = $res->GetNext()) {
				
				$MarkingCodeGroup=$obOzonA->isUfProductGroup($fields['ID']);
				if($MarkingCodeGroup>0){
					continue;
				}
				
				$iskl='N';
				$fields['PATH']=[];
				$db_old_groups = \CIBlockElement::GetElementGroups($fields['ID'], true);
				while($ar_group = $db_old_groups->Fetch()){
					$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
					$realNavChain = array();
					$k=0;
					while ($arNav=$navChain->GetNext()){	
							if(in_array($arNav['ID'],[17907,18357])){$iskl='Y'; break;}
							$realNavChain[]=['NAME'=>$arNav['NAME'],'ID'=>$arNav['ID'],'CODE'=>$arNav['CODE']];
					}
					$fields['PATH'][]=$realNavChain;
				}
				
				if($iskl=='N'){				
					$items[$fields['ID']] = [
						'ID' => $fields['ID'],
						'ACTIVE' => $fields['ACTIVE'],
						'NAME' => $fields['NAME'],
						'SRC' => \CFile::GetPath($fields['DETAIL_PICTURE']),
						'DETAIL_TEXT' => $fields['DETAIL_TEXT'],
						'PRICE' => $fields['CATALOG_PRICE_2'],
						'QUANTITY' => $fields['CATALOG_QUANTITY'],
						'PATH' => $fields['PATH'],
						'URL' => $fields['DETAIL_PAGE_URL'],
					];
					
					$ids[] = $fields['ID'];	
					$rprArr[$fields['ID']] = $fields['ID'];	
					$uriArr[$fields['ID']]=$fields['DETAIL_PAGE_URL'];
				}
			}
		
			\CIBlockElement::GetPropertyValuesArray($rprArr, $catalog_file_arr['IBLOCK_ID'], array(
				'ID' => $rprArr,
				'IBLOCK_ID' => $catalog_file_arr['IBLOCK_ID'],
			));
			
			foreach($rprArr as $kl=>$vl){
				
				$massa[$vl['POL']['VALUE']][]=[
					$kl,
					$items[$kl]['NAME'],
					$vl['BREND']['VALUE'],
					$vl['STRANA']['VALUE'],
					$vl['RAZMER']['VALUE'],
					$vl['MATERIAL']['VALUE'],
					$vl['POL']['VALUE'],
					$vl['CML2_BAR_CODE']['VALUE'],
					$vl['TSVET']['VALUE'],
					$vl['SEZON']['VALUE'],
					$items[$kl]['PRICE'],
					$items[$kl]['QUANTITY'],
					$items[$kl]['DETAIL_TEXT'],
					$items[$kl]['PATH'],
					$items[$kl]['SRC'],
					$vl['IDGLAVNOGO']['VALUE'],
					$items[$kl]['ACTIVE'],
					
				];				
			}
			unset($items);
			unset($rprArr);
			unset($ids);
			unset($fields);
		
	}
	//\Kolchuga\Settings::xmp($massa,0, __FILE__.": ".__LINE__,true);die;
	
}
?>


<div class="crm-admin-wrap">
<?if($is_obnova=='N'){?>

<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />

<link href="/local/templates/kolchuga_2016/plugins/autocomplete/jquery.styles.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<script type="text/javascript" src="/local/templates/kolchuga_2016/plugins/autocomplete/jquery.autocomplete.min.js"></script>
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
.autocomplete-list.show {
    z-index: 1;
	border-color: darkblue;   
    padding-top: 5px;
    padding-bottom: 5px;
}
</style>


<form action='' method='post'>
<input type='hidden' name='lang' value='ru' >
<table class="table table-striped">
	<thead>
		<tr>
			<th>Грузим</th>
			
			<th>offer_id</th>
			<th>name</th>
			<th>vendor</th>
			<th>barcode</th>          
			<th>price</th>          
			<th>description</th>          
			<th>primary_image</th>          
			<th>category_id</th>
			<th>razmer_box</th>
			
		</tr>
	</thead>
	<tbody>
		<?foreach($massa as $pol=>$value){?>
			<?foreach($value as $val){
				$saveProp=$listItemFromS[$val['0']]['PROPERTIES'];
				?>		
				<tr>
					<td><input type='checkbox' name='set[<?=$val['0']?>][active]' value='Y' ></td>
					<td>
						<input type='text' name='set[<?=$val['0']?>][offer_id]' value='<?=$val['0']?>' ><br>
						<br>
						<p>Ссылки:</p>
						<a href="<?=$uriArr[$val['0']]?>" target="_blank" onclick="window.open('<?=$uriArr[$val['0']]?>','','width=1024,height=555,scrollbars=no,resizable=no,status=no'); return false;">На Сайте</a><br>
						<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=40&type=1c_catalog&ID=<?=$val['0']?>&lang=ru" target="_blank" onclick="window.open('/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=40&type=1c_catalog&ID=<?=$val['0']?>&lang=ru','','width=auto,height=555,scrollbars=no,resizable=no,status=no'); return false;">В админке</a><br>
						
					</td>
					<td>
						<input type='text' name='set[<?=$val['0']?>][name]' value='<?=(!empty($saveProp['name']['VALUE']) ? $saveProp['name']['VALUE'] : $val['1'])?>' ><br>
						<p>Характеристики:</p>
						<?$sss=['Страна: '.$val['3'],'Размер: '.$val['4'],'Материал: '.$val['5'],'Пол: '.$val['6'],'Цвет: '.$val['8'],'Сезон: '.$val['9'],'Кол-во: '.$val['11']];?>
						<p><?=implode('<br>',$sss);?></p>					
					</td>
					<td><input type='text' name='set[<?=$val['0']?>][vendor]' value='<?=(!empty($saveProp['vendor']['VALUE']) ? $saveProp['vendor']['VALUE'] : $val['2'])?>' ></td>
					<td><input type='text' name='set[<?=$val['0']?>][barcode]' value='<?=(!empty($saveProp['barcode']['VALUE']) ? $saveProp['barcode']['VALUE'] : $val['7'])?>' ></td>
					<td><input type='text' name='set[<?=$val['0']?>][price]' value='<?=$val['10']?>' ></td>
					<td><textarea name='set[<?=$val['0']?>][description]' style=" height: 250px;"><?=(!empty($listItemFromS[$val['0']]['DETAIL_TEXT']) ? HTMLToTxt($listItemFromS[$val['0']]['~DETAIL_TEXT']) : HTMLToTxt($val['12']) )?></textarea></td>
					<td><input type='text' name='set[<?=$val['0']?>][primary_image]' value='<?=(!empty($saveProp['primary_image']['VALUE']) ? $saveProp['primary_image']['VALUE'] : 'https://www.kolchuga.ru'.$val['14'])?>' ></td>
					<td>
					
					
						<?
						$i=0;
						foreach($catalog_file_arr['CAT_OZON_ATR'] as $ids=>$mass_val){?>
							<?if($i>0){?><br><br><div class="">ИЛИ</div><br><?}?>
							<input type='radio' name='set[<?=$val['0']?>][category_id]' value='<?=$ids?>' <?=($saveProp['barcode']['VALUE']==$ids ? 'checked':'')?>> <span style="font-size:0.85em;"><?=$ids?> / <?=$categor_name[$ids]?></span><br><br>
							<?foreach($mass_val as $idatr=>$paramatr){?>
								<div class="" style="padding:5px 0">
									<div class="">
										<?=$paramatr['NAME']?>										
									</div>
									<div class="">
									<?if(empty($paramatr['CODE'])){?>
										<input type='text' name='set[<?=$val['0']?>][attr][<?=$ids?>][<?=$idatr?>][value]' value='' >
									<?}else{?>										
										<? $varhash= 'atrib'.$val['0'].$ids.$idatr;?>
										<input type="text" class="autocompletes form-control" placeholder="from dictionary (seeall)" name="set[<?=$val['0']?>][attr][<?=$ids?>][<?=$idatr?>][dictionary_value]" id="<?=$varhash?>" value="" />
										<input type="hidden" class="" placeholder="from dictionary (seeall)" name="set[<?=$val['0']?>][attr][<?=$ids?>][<?=$idatr?>][dictionary_value_id]" id="id<?=$varhash?>" value="" />
										<script>
											$(document).ready(function () {
												$('#<?=$varhash?>').autocomplete({
														serviceUrl: '/ajax/ozon_attr.php',
														params: {cat:<?=$val['0']?>,attr:<?=$ids?>,ida:<?=$idatr?>},
														onSelect: function (suggestion) {
															console.log(suggestion);
															$('#<?=$varhash?>').val(suggestion.value);
															$('#id<?=$varhash?>').val(suggestion.id);
														}
											        });
											});
											</script>
									<?}?>
									</div>
								</div>
							<?}?>
						<?
						$i++;
						}?>
					
					
					
					
					
					
					</td>
					<td>
					Высота: <input type='text' name='set[<?=$val['0']?>][height]' value='300' ><br><br>
					Глубина: <input type='text' name='set[<?=$val['0']?>][depth]' value='300' ><br><br>
					Ширина: <input type='text' name='set[<?=$val['0']?>][width]' value='300' ><br><br>
					Вес: <input type='text' name='set[<?=$val['0']?>][weight]' value='300' ><br><br>				
					</td>
				</tr>
			<?}?>
		<?}?>
	</tbody>
	
</table>
	<input type='submit' name="save" value='Сохранить'>
</form>
<?
$APPLICATION->IncludeComponent('bitrix:system.pagenavigation', '', array(
    'NAV_RESULT' => $navob,
));
?>
<?}else{?>
<p>Данные обновлены</p>
<?}?>

</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>