<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Ozon Настройки');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог

//$arrSetting=\Bitrix\Main\Config\Option::get('tg_ozon','');

if(!empty($_REQUEST['set'])){
	foreach($_REQUEST['set'] as $key=>$vl){
		\Bitrix\Main\Config\Option::set("tg_ozon", $key, $vl);
	}
	if(empty($_REQUEST['set']['active'])){\Bitrix\Main\Config\Option::set("tg_ozon", 'active', 'N');}
	$arrSetting=$_REQUEST['set'];
}

$arrSetting=\Bitrix\Main\Config\Option::getForModule('tg_ozon');

?>


<div class="crm-admin-wrap">
<link href="/bitrix/css/main/font-awesome.css" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/local/templates/kolchuga_2016/css/bootstrap.css" type="text/css"  data-template-style="true" rel="stylesheet" />

<form action='' method='get'>
<input type='hidden' name='lang' value='ru' >
<table class="table table-striped">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Наименование</th>
			<th>Выбор</th>
			<th>Дополнительно</th>          
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?if (!empty($arrSetting['active']) && $arrSetting['active']=='Y'){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td>Active</td>
			<td><input type='checkbox' name='set[active]' value='Y' <?if (!empty($arrSetting['active']) && $arrSetting['active']=='Y'){?>checked<?}?>></td>
			<td></td>
		</tr>
		<tr>
			<td><?if (!empty($arrSetting['client_id'])){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td>Client Id</td>
			<td><input type='text' name='set[client_id]' value='<?=$arrSetting['client_id']?>' placeholder='Введите Client Id'></td>
			<td></td>
		</tr>
		<tr>
			<td><?if (!empty($arrSetting['token'])){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td>Token</td>
			<td><input type='text' name='set[token]' value='<?=$arrSetting['token']?>' placeholder='Введите Token'></td>
			<td></td>
		</tr>
		<tr>
			<td><?if (!empty($arrSetting['host'])){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td>Host</td>
			<td><input type='text' name='set[host]' value='<?=$arrSetting['host']?>' placeholder='Введите Host'></td>
			<td></td>
		</tr>
		<tr>
			<td><?if (!empty($arrSetting['catalog_file'])){?><img src="/bitrix/images/sale/green.gif" ><?}else{?><img src="/bitrix/images/sale/red.gif" ><?}?></td>
			<td>ИД настроек</td>
			<td><input type='text' name='set[catalog_file]' value='<?=$arrSetting['catalog_file']?>' placeholder='Введите ключ натроек'></td>
			<td><p>Придумайте или введите известный идентификатор файла натроек. Будет создан файл с таким ключом для сохранения списка разделов которые необходимо будет выгружать/обновлять.</p></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"><input type='submit' value='Сохранить'></td>
		</tr>
	</tfoot>
</table>
</form>

</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>