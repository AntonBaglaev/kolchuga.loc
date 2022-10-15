<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Подтверждение заказа на Assist');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог


?>


<div class="crm-admin-wrap">

<?if(!empty($_REQUEST['CODE'])){
	?><p style="font-size:1.2em;line-height:1.5em;"><?
	$APPLICATION->IncludeFile('/local/tools/assist_ok.php', $_REQUEST);
	?></p><?
}?>

<form action='' method='get'>
	<input type='hidden' name='lang' value='ru' >
	<input type='text' name='CODE' value='<?=$_REQUEST['CODE']?>' placeholder='Введите номер заказа'><br><br>
	<input type='submit' value='Подтвердить'>
</form>
<style>
blockquote {
padding: 10px 20px;
    margin: 0 0 20px;
    border-left: 5px solid #585F6B;
    background-color: #CCD7DB;
}
</style>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>