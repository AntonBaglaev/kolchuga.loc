<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Список товаров на Ozon');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Main\Loader;
//$arrSetting=\Bitrix\Main\Config\Option::get('tg_ozon','');

$arrSetting=\Bitrix\Main\Config\Option::getForModule('tg_ozon');
	$filtr=[];
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, 'PROPERTY_ozon_id'=>false, 'ACTIVE'=>'Y'), false, false, Array('ID','PROPERTY_offer_id'));
			if($dbEl->SelectedRowsCount()>0){
				while($obEl = $dbEl->GetNext()){					
					$filtr[]=$obEl['PROPERTY_OFFER_ID_VALUE'];					
				}
			}
	
	//\Kolchuga\Settings::xmp($filtr,0, __FILE__.": ".__LINE__,true);die;
	//создаем объект
	$obOzon = new \Kolchuga\Ozona();
	//устанавливаем для текущего объекта ключи API
	$obOzon->setOption([
		'CURL'=>[
			'KEY'=>$arrSetting['token'],
			'CID'=>$arrSetting['client_id'],
		]
	]);
	

	//делаем запрос для получения общего количества товаров на озон
	$arParams=[
		'URI'=>'/v1/product/list',
		'BODY'=>["page"=>"0","page_size"=>"1", "filter"=>[ "offer_id"=>$filtr, "visibility"=>"ALL" ]],
	];
	
		
	$otvet=$obOzon->sendOzon($arParams);	
	$countItemAll=$otvet['result']['total'];
	//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);die;
	
	$countItem=10;
	$pageU = preg_replace("/[^0-9]/", '', $_REQUEST['page-link']);
	$pageN=(empty($pageU) ? 0 : $pageU );
	
	//получаем полный список товаров
	$arParams=[
		'URI'=>'/v1/product/list',
		'BODY'=>["page"=>$pageN,"page_size"=>$countItem, "filter"=>[ "offer_id"=>$filtr, "visibility"=>"ALL" ]],
	];
	$otvet=$obOzon->sendOzon($arParams);
	$ozonItem=$otvet['result']['items'];
	
	//по каждому товару получим информацию что это такое
	foreach($ozonItem as $rl=>$val){
		$arParams=[
			'URI'=>'/v2/product/info',
			'BODY'=>["product_id"=>$val['product_id']],
		];
		$otvet=$obOzon->sendOzon($arParams);
		//\Kolchuga\Settings::xmp($otvet,0, __FILE__.": ".__LINE__,true);die;
		$ozonItem[$rl]['info']=[
			'ID'=>$otvet['result']['id'],
			'NAME'=>$otvet['result']['name'],
			'OFFER_ID'=>$otvet['result']['offer_id'],
			'BARCODE'=>$otvet['result']['barcode'],
			'CATEGORY_ID'=>$otvet['result']['category_id'],
			'PRICE'=>$otvet['result']['price'],
			'STATUS'=>$otvet['result']['status'],			
			'STOCKS'=>$otvet['result']['stocks'],			
		];
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 76, 'PROPERTY_offer_id'=>$val['offer_id']), false, false, Array('ID','PROPERTY_ozon_id'));
			if($dbEl->SelectedRowsCount()>0){
				while($obEl = $dbEl->GetNext()){
					
					$ozonItem[$rl]['info']['ITEM']['ID']=$obEl['ID'];
					$ozonItem[$rl]['info']['ITEM']['OZON_ID']=$obEl['PROPERTY_OZON_ID_VALUE'];
				}
			}else{
				$ozonItem[$rl]['info']['ITEM']['ID']=0;
				$ozonItem[$rl]['info']['ITEM']['OZON_ID']=0;
			}
	}
	
if(!empty($_REQUEST['save'])){
	$setArray=$_REQUEST['set'];
	foreach($ozonItem as $rl=>$val){
		if(!empty($setArray[$val['product_id']])){
			
			if($val['info']['ITEM']['ID']>0){
				if($val['info']['ITEM']['OZON_ID']<1){
					$what['ozon_id']=$val['product_id'];
					\CIBlockElement::SetPropertyValuesEx($val['info']['ITEM']['ID'], false, $what);
				}				
			}else{
				$el = new \CIBlockElement;
				$PROP = array();
				$PROP[632] = $val['info']['BARCODE'];  // свойству с кодом 12 присваиваем значение "Белый"
				$PROP[634] = $val['info']['CATEGORY_ID'];  // свойству с кодом 12 присваиваем значение "Белый"
				$PROP[630] = $val['info']['NAME'];  // свойству с кодом 12 присваиваем значение "Белый"
				$PROP[629] = $val['info']['OFFER_ID'];  // свойству с кодом 12 присваиваем значение "Белый"
				$PROP[635] = $val['product_id'];        // свойству с кодом 3 присваиваем значение 38
 
				$arLoadProductArray = Array(
				  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
				  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
				  "IBLOCK_ID"      => 76,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $val['offer_id'],
				  "ACTIVE"         => "Y",            // активен				  
				  ); 
				  $el->Add($arLoadProductArray);
			}
						
		}
	}	
}	
	
	
	
?>


<div class="crm-admin-wrap">
<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />

<form action='' method='get'>
<input type='hidden' name='lang' value='ru' >
<input type='hidden' name='page-link' value='<?=$_REQUEST['page-link']?>' >
	
	

<?if(!empty($what)){?>
<p style="color:green">Товары обновлены</p>
<?}?>


<?if(!empty($ozonItem)){?>

<br>
<br>
<table class="table table-striped">
	<thead>
		<tr>
			
			<th>&nbsp;</th>			         
			<th>SAVE</th>			         
			<th>ozon_id</th>			         
			<th>offer_id</th>			         
			<th>NAME</th>			         
			<th>BARCODE</th>			         
			<th>CATEGORY_ID</th>			         
		
		
		</tr>
	</thead>
	<tbody>
	<?foreach($ozonItem as $kl=>$vl){?>		
				         
		<tr>
					
			<td><input type='checkbox' name='set[<?=$vl['product_id']?>]' value='Y' ></td>
			<td><?if ($vl['info']['ITEM']['OZON_ID']>0){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td><?=$vl['product_id']?></td>			         
			<td><?=$vl['offer_id']?></td>			         
			<td><?=$vl['info']['NAME']?></td>			         
			<td><?=$vl['info']['BARCODE']?></td>			         
			<td><?=$vl['info']['CATEGORY_ID']?></td>			         
					         
		
		</tr>
		<?}?>
		</tbody>
	<tfoot>
		<tr>
			<td colspan="6">
			
	  </td>
		</tr>
	</tfoot>
</table>

<?}?>
<input type='submit' name="save" value='Обновить идентификатор товара'>
</form>
<?
/* $nav = new \Bitrix\Main\UI\ReversePageNavigation("page-link", $countItemAll+1);
$nav->allowAllRecords(true)
   ->setPageSize(10)
   ->initFromUri(); */
   
$nav = new \Bitrix\Main\UI\PageNavigation("page-link");
$nav->allowAllRecords(true)
   ->setPageSize(10)
   ->initFromUri();
$nav->setRecordCount($countItemAll);
?>
<?
$APPLICATION->IncludeComponent(
   "bitrix:main.pagenavigation",
   "",
   array(
      "NAV_OBJECT" => $nav,
      "SEF_MODE" => "N",
   ),
   false
);
?>

</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>