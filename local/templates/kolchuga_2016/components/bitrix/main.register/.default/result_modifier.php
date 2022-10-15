<?
foreach ($arResult['SHOW_FIELDS'] as $k=>$fld) {
    if ($fld == 'LOGIN') unset($arResult['SHOW_FIELDS'][$k]);
//мы уничтожаем штатное поле LOGIN чтобы заменить его нашим скрытым полем, которое будет с помощью jquery заполняться из поля e-mail
    if ($fld == 'AGREE') unset($arResult['SHOW_FIELDS'][$k]);
//уничтожаем поле input AGREE для замены его кастомным чекбоксом
}

if ($_GET['dev']==1) {
	/*echo "<pre>";
	var_dump($arResult['SHOW_FIELDS']);
	echo "</pre>";*/
}
?>