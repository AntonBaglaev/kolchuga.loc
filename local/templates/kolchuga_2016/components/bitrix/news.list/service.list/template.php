<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$arButon = [
    1  => 'Новости',
    10 => 'Обзоры',
    51 => 'События'
];
?>

<? foreach ($arResult["ITEMS"] as $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>

    <div class="container-fluid service_item__bordered">
        <div class="row">
            <div class="col-md-6 pr-md-0">
                <div class="row">
                    <? if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) { ?>
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                            <img class="preview_picture " border="0" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                 alt="<?= $arItem["NAME"] ?>" title="<?= $arItem["NAME"] ?>"/>
                        </a>
                    <? } ?>
                </div>
            </div>
            <div class="col-md-6">

                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10 service_item_opis h-100">

                            <a href="<?= $arItem['LIST_PAGE_URL'] ?>" class="d-inline-block service_item_text"
                               title="<?= $arButon[$arItem['IBLOCK_ID']] ?>"><?= $arButon[$arItem['IBLOCK_ID']] ?></a>

                            <br><br>
                            <h3><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= $arItem["NAME"] ?></a></h3>


                            <div class="minanons"><?= $arItem['DISPLAY_PROPERTIES']['ANONS']['~VALUE']['TEXT'] ?></div>

                            <br>
                            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                               class="btn-blue mx-0">Подробнее</a>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<? endforeach; ?>






