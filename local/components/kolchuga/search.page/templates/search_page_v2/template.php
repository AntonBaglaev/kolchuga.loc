<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (count($arResult["SEARCH"]) == 1)
    if (current($arResult["SEARCH"])['URL_WO_PARAMS'])
        LocalRedirect(current($arResult["SEARCH"])['URL_WO_PARAMS']);
?>

<div class="title-page">
    <h1 class="js-page-title">Результаты поиска</h1>
</div>

<?/* if (count($arResult["SEARCH"]) > 0): ?>
    Найдено: <?= count($arResult["SEARCH"]) >= 250 ? 'больше ' : '' ?><?= count($arResult["SEARCH"]) ?>
<? else: ?>
    <? // ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND")); ?>
<? endif; */?>
