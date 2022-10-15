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
<h2>Меню:</h2>
<ul>
<li><a href="/bitrix/admin/tgarl_adminka_assist.php?lang=ru">Подтверждение заказа на Assist</a></li>
<li><a href="/bitrix/admin/tgarl_adminka_assist_orderlist.php?lang=ru">Список заказов в Assist</a></li>
<li><a href="/bitrix/admin/tgarl_adminka_assist_status.php?lang=ru">Статус заказа в Assist</a></li>
</ul>
<?

?>
<style>
.crm-admin-wrap li {line-height: 2em;
    font-size: 1.3em;}
</style>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>