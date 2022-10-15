<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="container-fluid">

    <div class="row list_service_container news_list_wrapper">

        <? foreach ($arResult["ITEMS"] as $arItem): ?>

            <? if (empty($arItem["PREVIEW_PICTURE"]))
                continue; ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="col-md-6 service_item news_list-item" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">

                <div class="row g-0 overflow-hidden flex-md-row news_list-row">
                    <div class="col d-lg-block news_list-image">
                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                <img border="0" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                     alt="<?= $arItem["NAME"] ?>" title="<?= $arItem["NAME"] ?>"/>
                            </a>
                        <? else: ?>
                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>"
                                 title="<?= $arItem["NAME"] ?>"/>
                        <? endif; ?>
                    </div>
                    <div class="col d-flex flex-column position-static news_list-description">
                        <strong class="d-inline-block mb-2 text-primary news_list-section">
                            <? if ($arItem['IBLOCK_ID'] == 1): ?><a href="/news/">Новости</a><? endif ?>
                            <? if ($arItem['IBLOCK_ID'] == 10): ?><a href="/articles/">Обзоры</a><? endif ?>
                        </strong>

                        <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                            <h3 class="mb-0 news_list_title">
                                <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a><br/>
                                <? else: ?>
                                    <? echo $arItem["NAME"] ?>
                                <? endif; ?>
                            </h3>
                        <? endif; ?>

                        <? if (!$arItem['PROPERTY_ANONS_VALUE']['TEXT'] && $arItem['PROPERTIES']['ANONS']['VALUE']['TEXT'])
                            $arItem['PROPERTY_ANONS_VALUE']['TEXT'] = $arItem['PROPERTIES']['ANONS']['VALUE']['TEXT'];
                        ?>

                        <p class="card-text mb-auto news_list-subtext"><?= $arItem['PROPERTY_ANONS_VALUE']['TEXT'] ? html_entity_decode($arItem['PROPERTY_ANONS_VALUE']['TEXT']) : '' ?></p>

                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="news_list-link">Подробнее</a>
                    </div>
                </div>
            </div>

        <? endforeach; ?>

    </div>
</div>