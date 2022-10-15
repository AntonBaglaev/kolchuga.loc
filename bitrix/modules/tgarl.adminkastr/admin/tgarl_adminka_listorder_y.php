<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle(GetMessage("NPC_TTTLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог


?>


<div class="crm-admin-wrap">

<?$sostav=[];

	//echo "<pre style='text-align:left;'>";print_r($_REQUEST);echo "</pre>";
	
	$myDate = new \Bitrix\Main\Type\Date();
	$myDate->add('-1Y');

	$parameters = [
	   'filter' => [
		   ">=DATE_INSERT" => $myDate
	   ],
	   'order' => ["DATE_INSERT" => "ASC"]
	];
	
    $dbRes = \Bitrix\Sale\Order::getList($parameters);
	$listUser=[];
	while ($order = $dbRes->fetch())
	{
		//echo "<pre style='text-align:left;'>";print_r($order);echo "</pre>";
		$listUser[]=$order['USER_ID'];
		$arrlistUser[$order['USER_ID']]['ID']=$order['USER_ID'];
		
		$orderObj = \Bitrix\Sale\Order::load($order['ID']);
		$basket = $orderObj->getBasket();
		
		$bsk=$basket->getBasketItems();
		foreach($bsk as $item){
			//echo "<pre style='text-align:left;'>";print_r($item);echo "</pre>";die;
			$order['basket'][$item->getProductId()]=$item->getField('NAME');
		}
		
		//$order['basket']=$basket->getBasketItems();
		
		$sostav[$order['USER_ID']][]=$order;
	}
	
	/* $data = \CUser::GetList(($by="ID"), ($order="ASC"),
            array(
                'ID' => implode(' | ', $listUser),                
            )
        );

	while($arUser = $data->Fetch()) {
		$fio=[];
		if(!empty($arUser['LAST_NAME'])){$fio[]=$arUser['LAST_NAME'];}
		if(!empty($arUser['NAME'])){$fio[]=$arUser['NAME'];}
		if(!empty($arUser['SECOND_NAME'])){$fio[]=$arUser['SECOND_NAME'];}		
		$arrlistUser[$arUser['ID']]['FIO']=implode(' ', $fio);
		$arrlistUser[$arUser['ID']]['EMAIL']=$arUser['EMAIL'];			
	}
	//echo "<pre style='text-align:left;'>";print_r($sostav);echo "</pre>";
	$statusResult = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
		'order' => array('STATUS.SORT'=>'ASC'),
		'filter' => array('STATUS.TYPE'=>'O','LID'=>LANGUAGE_ID),
		'select' => array('STATUS_ID','NAME','DESCRIPTION'),
	));
	$orderStatus=[];
	while($status=$statusResult->fetch())
	{
		$orderStatus[$status['STATUS_ID']]=$status;
	} */

?>

<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<style>
* {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
}
.group-input {
    height: 34px !important;
    padding: 6px 12px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
	min-width: 300px;
}
.crm-admin-wrap {
    font-family: Arial, sans-serif;
    font-size: 12px;
    padding: 15px;
    background: #fff;
    border: solid 1px #C5CECF;
    border-radius: 4px;
}


</style>



	
	<?if(!empty($sostav) && !empty($_REQUEST['download'])){?>
	<?php
	include_once $_SERVER["DOCUMENT_ROOT"].'/api/SimpleXLSXGen.php';
	$data=[];
	$data[]=['№ заказа','Дата заказа','Сумма','Пользователь' ];
	foreach($sostav as $userid=>$val0){
		foreach($val0 as $val){
			$data[]=[
				$val['ID'],
				"\0".$val['DATE_INSERT']->toString(),
				$val['PRICE'],				
				$val['USER_ID'],				
			];
		}
	}
	
	\SimpleXLSXGen::fromArray( $data )->download('datatypes.xlsx');
	?>
	<?}elseif(!empty($sostav)){?>
	
		<?foreach($sostav as $userid=>$val0){?>
			<br>
			<br>
			<table class="table table-striped">
			  <thead>
				<tr>				  
				  <th>№ заказа</th>
				  <th>Дата заказа</th>
				  <th>Сумма</th>				  
				  <th>Пользователь</th>            
				        
				</tr>
			  </thead>
			  <tbody>
			  <?foreach($val0 as $val){ ?>
				<tr class="stroka<?=$val['ID']?>">
				  <td><a href="/bitrix/admin/sale_order_view.php?lang=ru&ID=<?=$val['ID']?>" target="_blank"><?=$val['ID']?></a></td>
				  <td><?=$val['DATE_INSERT']->toString()?></td>
				  <td><?=$val['PRICE']?></td>				 
				  <td><?=$val['USER_ID']?></td>				  	 
				</tr>
			   <?}?>
			  </tbody>
			  
			</table>
		<?}?>
	<?}?>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>