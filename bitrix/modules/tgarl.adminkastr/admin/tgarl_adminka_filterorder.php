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
if(!empty($_REQUEST['CODE'])){
	//echo "<pre style='text-align:left;'>";print_r($_REQUEST);echo "</pre>";
	
	$myDate = new \Bitrix\Main\Type\Date();
	$myDate->add('-1M');

	$parameters = [
	   'filter' => [
		   "USER_ID" => $USER->GetID(),
		   ">=DATE_INSERT" => $myDate
	   ],
	   'order' => ["DATE_INSERT" => "ASC"]
	];
	
	
	if($_REQUEST['VIBOR']=='ID'){
		
		$parameters = [
			'filter' => [
				'BASKET.PRODUCT_ID' => $_REQUEST['CODE']
			],
			'order' => ['ID' => 'DESC']
		];
	}elseif($_REQUEST['VIBOR']=='NAME'){
		$parameters = [
			'filter' => [
				'BASKET.NAME' => "%".$_REQUEST['CODE']."%"
			],
			'order' => ['ID' => 'DESC']
		];
	}elseif($_REQUEST['VIBOR']=='PROPERTY_BREND'){
		
		$db_enum_list = CIBlockProperty::GetPropertyEnum("BREND", Array('sort' => 'asc'), Array("IBLOCK_ID"=>40, 'VALUE'=>trim($_REQUEST['CODE']) ));
		while($ar_enum_list = $db_enum_list->GetNext())
		{$arrProp[]=$ar_enum_list;}
		//echo "<pre style='text-align:left;'>";print_r($arrProp);echo "</pre>";die;
		$parameters = [
			'filter' => [
				'PROPERTIES.IBLOCK_PROPERTY_ID' => 465, 
				'PROPERTIES.VALUE' => $arrProp[0]['ID']
			],
			'order' => ['ID' => 'DESC'],
			'runtime' => [
				new \Bitrix\Main\ORM\Fields\Relations\Reference(
				  'PROPERTIES', \Bitrix\Iblock\ElementPropertyTable::class,
				  \Bitrix\Main\ORM\Query\Join::on('this.BASKET.PRODUCT_ID', 'ref.IBLOCK_ELEMENT_ID')
				)
			  ]
		];
		
		
	}elseif($_REQUEST['VIBOR']=='PROPERTY_CML2_ARTICLE'){
		
		$parameters = [
			'filter' => [
				'PROPERTIES.IBLOCK_PROPERTY_ID' => 207, 
				'PROPERTIES.VALUE' => trim($_REQUEST['CODE'])
			],
			'order' => ['ID' => 'DESC'],
			'runtime' => [
				new \Bitrix\Main\ORM\Fields\Relations\Reference(
				  'PROPERTIES', \Bitrix\Iblock\ElementPropertyTable::class,
				  \Bitrix\Main\ORM\Query\Join::on('this.BASKET.PRODUCT_ID', 'ref.IBLOCK_ELEMENT_ID')
				)
			  ]
		];
		//echo "<pre style='text-align:left;'>";print_r($parameters);echo "</pre>";die;
		
	}elseif($_REQUEST['VIBOR']=='CODE'){
		$parameters = [
			'filter' => [
				'BASKET.DETAIL_PAGE_URL' => "%".$_REQUEST['CODE']."%"
			],
			'order' => ['ID' => 'DESC']
		];
	}
	
	if(!empty($_REQUEST['time_start']) ){
		$myDate = new \Bitrix\Main\Type\Date($_REQUEST['time_start']);
		$parameters['filter'][">=DATE_INSERT"] = $myDate;
	}
	if(!empty($_REQUEST['time_finish']) ){
		$myDate = new \Bitrix\Main\Type\Date($_REQUEST['time_finish']);
		$parameters['filter']["<=DATE_INSERT"] = $myDate;
	}
	
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
			if($_REQUEST['ISKL']=='Y'){
				if($_REQUEST['VIBOR']=='ID'){
					if($item->getProductId()!=$_REQUEST['CODE']){
						unset($order['basket'][$item->getProductId()]); 
						$order['PRICE']=$order['PRICE']-$item->getField('PRICE');
					}
				}elseif($_REQUEST['VIBOR']=='NAME'){
					
					$pos = strpos($item->getField('NAME'), $_REQUEST['CODE']);
					if ($pos === false) {
						unset($order['basket'][$item->getProductId()]); 
						$order['PRICE']=$order['PRICE']-$item->getField('PRICE');
					} else {
						
					}
					
				}elseif($_REQUEST['VIBOR']=='PROPERTY_BREND'){
					$res = CIBlockElement::GetList(Array("SORT"=>"ASC", ), array('ID'=>$item->getProductId()), false,false,array('ID','IBLOCK_ID','PROPERTY_BREND'));
					while($ar_fields = $res->GetNext())
					{
						if($arrProp[0]['ID']!=$ar_fields['PROPERTY_BREND_ENUM_ID']){
							unset($order['basket'][$item->getProductId()]); 
							$order['PRICE']=$order['PRICE']-$item->getField('PRICE');
						}
					 
					}
					
					
				}
			}
		}
		if($_REQUEST['ISKL']=='Y'){
			$order['PRICE']=$order['PRICE']-$order['PRICE_DELIVERY'];
		}
		
		//$order['basket']=$basket->getBasketItems();
		if(!empty($order)){
			$sostav[]=$order;
		}
	}
	
	$data = \CUser::GetList(($by="ID"), ($order="ASC"),
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
	}
}
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


<form action='' method='get'>
	<input type='hidden' name='lang' value='ru' >
	Фильтр по дате заказа:<br>
	<?$APPLICATION->IncludeComponent(
	   "bitrix:main.calendar",
	   "",
	   Array(
		  "SHOW_INPUT" => "Y",
		  "FORM_NAME" => "my_form",             // имя формы
		  "INPUT_NAME" => "time_start",         // time_start - имя первого поля для ввода даты-времени 
		  "INPUT_NAME_FINISH" => "time_finish", // time_finish - имя второго поля для ввода даты-времени
												// используются вместо тегов <input name="time_start"> ... </input>
												// и <input name="time_finish"> ... </input>
		  "INPUT_VALUE" => $_REQUEST['time_start'],                  // значение time_start по умолчанию
		  "INPUT_VALUE_FINISH" => $_REQUEST['time_finish'],           // значение time_finish по умолчанию
		  "SHOW_TIME" => "Y",                   // если время задавать не нужно поставить значение "N"
		  "HIDE_TIMEBAR" => "N"                 // если время задавать не нужно поставить значение "Y"
	   ),
	false
	);?><br><br>
	Фильтр по параметру:<br>
	<input type='text' name='CODE' value='' class='group-input' placeholder='Введите значение для фильтра'> 
	<select name='VIBOR' class="group-input">
		<option value='ID'>ID товара</option>
		<option value='NAME'>Наименование товара</option>
		<option value='PROPERTY_BREND'>Бренд товара</option>
		<option value='PROPERTY_CML2_ARTICLE'>Артикул</option>
		<option value='CODE'>Символьный код товара</option> 
	<select>
	<br><br>Исключить другие товары <input type='checkbox' name='ISKL' value='Y' > 
	<br><br>
	
	<input type='submit' value='Вперед'>
	</form>
	
	<?if(!empty($sostav) && !empty($_REQUEST['download'])){?>
	<?php
	include_once $_SERVER["DOCUMENT_ROOT"].'/api/SimpleXLSXGen.php';
	$data=[];
	$data[]=['№ заказа','Дата заказа','Сумма','Статус заказа','Статус оплаты','Пользователь','Состав заказа' ];
	foreach($sostav as $val){
		$data[]=[
			$val['ID'],
			"\0".$val['DATE_INSERT']->toString(),
			$val['PRICE'],
			$orderStatus[$val['STATUS_ID']]['NAME'],
			($val['PAYED']=='Y' ? 'Оплачен':'Не оплачен'),
			$arrlistUser[$val['USER_ID']]['FIO'],
			implode('; ',$val['basket']) 
		];
	}
	
	\SimpleXLSXGen::fromArray( $data )->download('datatypes.xlsx');
	?>
	<?}elseif(!empty($sostav)){?>
	<br>
	<br>
	<table class="table table-striped">
      <thead>
        <tr>
          <th>&nbsp;</th>
          <th>№ заказа</th>
          <th>Дата заказа</th>
          <th>Сумма</th>
          <th>Статус заказа</th>
          <th>Статус оплаты</th>
          <th>Пользователь</th>                    
          <th>Состав заказа</th>          
        </tr>
      </thead>
      <tbody>
	  <?foreach($sostav as $val){ ?>
        <tr class="stroka<?=$val['ID']?>">
          <td><?if ($val['PAYED']=='Y'){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
		  <td><a href="/bitrix/admin/sale_order_view.php?lang=ru&ID=<?=$val['ID']?>" target="_blank"><?=$val['ID']?></a></td>
		  <td><?=$val['DATE_INSERT']->toString()?></td>
		  <td><?=$val['PRICE']?></td>
		  <td><?=$orderStatus[$val['STATUS_ID']]['NAME']?></td>
		  <td><?=($val['PAYED']=='Y' ? 'Оплачен':'Не оплачен')?></td>
		  <td><?=$arrlistUser[$val['USER_ID']]['FIO']?></td>
		  <td><?=implode('<br>',$val['basket'])?></td>		 
        </tr>
       <?}?>
      </tbody>
	  <tfoot>
	  <tr><td colspan="8"><a href="<?=$APPLICATION->GetCurPageParam("download=Y", array("download"))?>" target="_blank">Скачать</a></td></tr>
	  </tfoot>
    </table>
	<?}?>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>