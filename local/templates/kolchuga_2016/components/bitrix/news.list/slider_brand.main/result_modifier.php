<?
$cp = $this->__component; // объект компонента
if (is_object($cp))
{
	// добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
	$cp->arResult['BRAND'] = $arResult['ITEMS'][0]['PROPERTIES']['SEE_IN_BRAND']['VALUE'];

	$cp->SetResultCacheKeys(array('BRAND'));
	// сохраним их в копии arResult, с которой работает шаблон
	$arResult['BRAND'] = $cp->arResult['BRAND'];
}
?>