<?
use Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог
Loader::includeModule("highloadblock");

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Список заказов на Assist');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
CJSCore::Init(array("jquery")); 

$hlblock = HL\HighloadBlockTable::getById(8)->fetch();//поля HL [ID], [NAME], [TABLE_NAME]
$entity = HL\HighloadBlockTable::compileEntity($hlblock);//объект содержимого HL
$entity_data_class = $entity->getDataClass();//класс работы с текущей сущностью(таблицей)
$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-notice");
$nav->allowAllRecords(true)
   ->setPageSize(15)
   ->initFromUri();
   
$filtr=array(">=UF_ORDERDATE" => date("d.m.Y H:i:s", mktime(0, 0, 0, date('m'), date('d')-30, date('Y'))),);  
if(intval($_REQUEST['UF_ORDER_ID_SITE'])>0){$filtr[]=["LOGIC"=>"OR",['UF_ORDER_ID_SITE'=>$_REQUEST['UF_ORDER_ID_SITE']],['UF_ERROR_ORDER_NUM'=>$_REQUEST['UF_ORDER_ID_SITE']]];} 
if(intval($_REQUEST['UF_ORDERNUMBER'])>0){$filtr[]=["LOGIC"=>"OR",['UF_ORDERNUMBER'=>$_REQUEST['UF_ORDERNUMBER']],['UF_ERROR_PAY_NUM'=>$_REQUEST['UF_ORDERNUMBER']]];} 

$rsData = $entity_data_class::getList(array(
	"select" => array('*'), //выбираем все поля
	"filter" => $filtr,
	"count_total" => true, //хз - читайте в документации
      "offset" => $nav->getOffset(), //из объекта пагинации добавляем смещение для HighloadBlock
      "limit" => $nav->getLimit(), //здесь лимит из Объекта пагинации
	  "order" => array("UF_ORDER_ID_SITE"=>"desc")
));
   
$nav->setRecordCount($rsData->getCount());

$rsData = new CDBResult($rsData, $sTableID);
$massa=[];


while ($arItem = $rsData->Fetch()) {
	$massa[]=$arItem;
}
?>


<div class="crm-admin-wrap">
<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />
<style>
.bx-gadgets-salenotsale .form-control {
    height: 34px !important;
    padding: 6px 12px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
}
* {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
}
.bx-gadgets-salenotsale input, .bx-gadgets-salenotsale div{
	-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
	
}
.btn-xs{font-size: 0.7rem;}
.deistv {width: 100px;
    float: right;
    font-size: 24px;
    display: flex;
    justify-content: space-around;}
	.filter{
		margin-bottom: 1em;
    border: 2px dotted #ccc;
    padding: 12px;
    display: inline-block;
	}
</style>
<div class="postdeckript"></div>
<div class="deistv">
<a href="javascript:void(0);" id='click_pvz'><i class="fa fa-download"></i></a>
<a href="/assist/list_order.php" target="_blank"><i class="fa fa-refresh"></i></a> 
</div>
<div class="filter">
<form action='' method='get'>
	Фильтр:<br>
	<input type='hidden' name='lang' value='ru' >
	<input type='text' name='UF_ORDER_ID_SITE' value='<?=$_REQUEST['UF_ORDER_ID_SITE']?>' placeholder='Введите номер заказа'> или <input type='text' name='UF_ORDERNUMBER' value='<?=$_REQUEST['UF_ORDERNUMBER']?>' placeholder='Введите номер оплаты'> <input type='submit' value='Найти'>
</form>
</div>
<table class="table table-striped">
      <thead>
        <tr>
          <th>&nbsp;</th>
          <th>№ заказа</th>
          <th>№ оплаты</th>
          <th>№ Ассист</th>
          <th>Сумма</th>
          <th>Компания</th>
          <th>Пользователь</th>
          <th>Оплата</th>          
          <th>Дополнительно</th>          
        </tr>
      </thead>
      <tbody>
	  <?foreach($massa as $val){
		  $orderSite=$val['UF_ORDER_ID_SITE'];
		  $orderSiteError=$val['UF_ERROR_ORDER_NUM'];
		  $paySite=$val['UF_ORDERNUMBER'];
		  $paySiteError=$val['UF_ERROR_PAY_NUM'];
		  ?>
        <tr class="stroka<?=$val['ID']?>">
          <td><?if ($val['UF_ORDERSTATE']=='Approved'){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
		  <td><a href="/bitrix/admin/sale_order_view.php?lang=ru&ID=<?=(!empty($orderSiteError) ? $orderSiteError:$orderSite)?>"><?=(!empty($orderSiteError) ? $orderSiteError:$orderSite)?></a></td>
          <td><a href="/bitrix/admin/sale_order_payment_edit.php?lang=ru&order_id=<?=(!empty($orderSiteError) ? $orderSiteError:$orderSite)?>&payment_id=<?=(!empty($paySiteError) ? $paySiteError:$paySite)?>"><?=$val['UF_ORDERNUMBER']?></a></td>
          <td><?=$val['UF_BILLNUMBER']?></td>
          <td><?=$val['UF_ORDERAMOUNT']?></td>
          <td><?=$val['UF_COMPANY']?></td>
          <td>
		  Имя: <?=$val['UF_FIRSTNAME']?><br>
		  Фамилия: <?=$val['UF_LASTNAME']?><br>
		  Email: <?=$val['UF_EMAIL']?><br>
		  IP: <?=$val['UF_CLIENTIP']?><br>
		  </td>
          <td rel="<?=$val['UF_BILLNUMBER']?>">
		  <?
		  if($val['UF_ORDERSTATE']=='Approved'){echo 'Оплачен';}
		  elseif($val['UF_ORDERSTATE']=='Delayed'){echo 'Ожидает подтверждения<br><br><a href="/bitrix/admin/tgarl_adminka_assist.php?lang=ru&CODE='.(!empty($orderSiteError) ? $orderSiteError:$orderSite).'&payment_id='.$val['UF_ORDERNUMBER'].'" target="_blank" class="btn btn-info btn-xs">Подтвердить</a>'; echo '<a href="javascript:void(0);" id="click_refresh"  rel="'.$val['UF_BILLNUMBER'].'" style="margin-left: 1em;font-size: 16px;"><i class="fa fa-refresh"></i></a>'; }
		  elseif($val['UF_ORDERSTATE']=='PartialDelayed'){echo 'Подтвержден частично';}
		  elseif($val['UF_ORDERSTATE']=='Timeout'){echo 'Клиент перешел на оплату, но не оплатил';}
		  else{echo $val['UF_MESSAGE'];}
		  ?>
		  </td>
          <td><?
		  if(!empty($val['UF_MEANNUMBER'])){
			  ?>
			  Данные карты:<br>
			  <ul>
			  <li>Тип: <?=$val['UF_MEANTYPENAME']?></li>
			  <li>Номер: <?=$val['UF_MEANNUMBER']?></li>
			  <li>Держатель: <?=$val['UF_CARDHOLDER']?></li>
			  <li>Банк: <?=$val['UF_ISSUEBANK']?></li>
			  </ul>
			  <?			  
		  }
		  ?></td>
        </tr>
       <?}?>
      </tbody>
	  <tfoot>
	  <tr><td colspan="9"><?$APPLICATION->IncludeComponent("bitrix:main.pagenavigation", "", Array(
	"NAV_OBJECT" => $nav,
		"SEF_MODE" => "N"
	),
	false
);?></td></tr>
	  </tfoot>
    </table>
<?

?>
</div>

<script>
$(document).on('click', '#click_pvz', function(){
	$.get("/ajax/assist_orderlist_export.php", {sessid: "<?=bitrix_sessid()?>"},function(data) {
			  if(data=='error'){alert('Возникла ошибка!!!');}else{
				  $('.postdeckript').html(data);
			  }
	});
});

$(document).on('click', '#click_refresh', function(){
	var rell=$(this).attr('rel');
	console.log(rell);
	$.get("/ajax/assist_orderlist_status.php", {sessid: "<?=bitrix_sessid()?>", rell:rell},function(data) {
			  if(data=='error'){alert('Возникла ошибка!!!');}else{
				  $('td[rel="'+rell+'"]').html(data);
			  }
	});
});
</script>

<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
<?/*
<td>
				<?foreach($val['PREVIEW_TEXT'] as $item){ if(empty($item)) continue; echo $item."<br>"; }?>
				<br><a href="/bitrix/admin/sale_order_create.php?USER_ID=<?=$val['NAME']?>&SITE_ID=s1&lang=ru" target="_blank" class="btn btn-success btn-xs">К созданию заказа</a>
		  </td>		  
          <td>
				<?$fio='';
				$link=false;
				if(!empty($massaUserArr[$val['NAME']]['LAST_NAME'])) $fio.=$massaUserArr[$val['NAME']]['LAST_NAME'];
				if(!empty($massaUserArr[$val['NAME']]['NAME'])) $fio.=' '.$massaUserArr[$val['NAME']]['NAME'];
				if(!empty($massaUserArr[$val['NAME']]['SECOND_NAME'])) $fio.=' '.$massaUserArr[$val['NAME']]['SECOND_NAME'];				
				?>
				<?if(!empty($fio)){?>
					ФИО: <a href="/bitrix/admin/user_edit.php?lang=ru&ID=<?=$val['NAME']?>" target="_blank"><?=$fio?></a><br>
				<?$link=true;}?>
				<?if(!empty($massaUserArr[$val['NAME']]['EMAIL'])){?>
					Email: 
					<?if(!$link){?><a href="/bitrix/admin/user_edit.php?lang=ru&ID=<?=$val['NAME']?>" target="_blank"><?}?>
						<?=$massaUserArr[$val['NAME']]['EMAIL']?>
					<?if(!$link){?></a><?}?><br> 
				<?$link=true;}?>
				<?if(!empty($massaUserArr[$val['NAME']]['PERSONAL_PHONE'])){?>	
					Телефон: 
						<?if(!$link){?><a href="/bitrix/admin/user_edit.php?lang=ru&ID=<?=$val['NAME']?>" target="_blank"><?}?>
							<?=$massaUserArr[$val['NAME']]['PERSONAL_PHONE']?>
						<?if(!$link){?></a><?}?><br>  
				<?$link=true;}?>
				<?if(!empty($val['IP'])){?>
					<br>Ip: <?=$val['IP']['ip']?><br>
					Страна: <?=$val['IP']['countryName']?><br>
					<?if($val['IP']['regionName']!=$val['IP']['cityName']){?>Регион: <?=$val['IP']['regionName']?><br><?}?>
					Город: <?=$val['IP']['cityName']?><br>
				<?}?>
			<br><a href="/bitrix/admin/sale_buyers_profile.php?USER_ID=<?=$val['NAME']?>&lang=ru&buyers-subscription-list=page-1-size-20" target="_blank" class="btn btn-info btn-xs">В профиль</a>
		  </td>
          <td class="text-center"><?=$val['DETAIL_TEXT']['step']?></td>
          <td class="text-center"><a href="javascript:void(0);" onclick="$('.descript<?=$val['ID']?>').toggle();"><i class="fa fa-pencil" aria-hidden="true"></i></a>
			<div class="descript<?=$val['ID']?>" style="display:none;">
				<input type="text" value="<?=$val['CODE']?>" name="descript"> 
				<br><a href="javascript:void(0);" class="btn btn-warning btn-sm mt15" onclick="savet('<?=$val['ID']?>')"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
			</div>
			<br><div class="datacomment<?=$val['ID']?>"><?=$val['ACTIVE_TO']?></div>
			<br><div class="postdeckript<?=$val['ID']?>"><?=$val['CODE']?></div>
		  </td>
          <td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="delet('<?=$val['ID']?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
*/?>