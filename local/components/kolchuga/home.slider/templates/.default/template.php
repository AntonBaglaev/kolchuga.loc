<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if ($arResult['ITEMS']) {
    ?>
    <div class="home-slider-container">
        <div class="home-slider-carousel-wrapper d-none d-md-block">
            <div class="home-slider-carousel owl-carousel owl-theme">
                <? foreach ($arResult['ITEMS'] as $arItem):
                    if (!$arItem['PREVIEW_PICTURE']) continue;
                    ?>
                    <div class="item"
                         style="background-image: url('<?= $arItem['PREVIEW_PICTURE_WEBP'] ?>');"
                         data-bg="<?= $arItem['PREVIEW_PICTURE'] ?>"
                         data-bg-webp="<?= $arItem['PREVIEW_PICTURE_WEBP'] ?>"
                         title="<?= $arItem['NAME'] ?>"
                    >

                        <a href="<?= $arItem['PROPS']['LINK']['VALUE'] ?>" class="home-slider-text">
                            <div class="home-slider-text-header"><?= $arItem['PROPS']['NAME_HTML']['VALUE'] ? html_entity_decode($arItem['PROPS']['NAME_HTML']['VALUE']) : $arItem['NAME'] ?></div>

                            <div class="home-slider-text-sub">
                                <?= $arItem['PREVIEW_TEXT'] ?>
                            </div>
                        </a>

                        <div class="home-slider-links">
                            <a class="home-slider-link"
                               style="<?= $arItem['PROPS']['BUTTON_COLOR']['VALUE'] ? 'color:' . $arItem['PROPS']['BUTTON_COLOR']['VALUE'] . ';' : '' ?><?= $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] . ';' : '' ?>"
                               href="<?= $arItem['PROPS']['LINK']['VALUE'] ?>"><?= $arItem['PROPS']['LINK_TITLE']['VALUE'] ? $arItem['PROPS']['LINK_TITLE']['VALUE'] : 'Подробнее' ?></a>

                            <? if ($arItem['PROPS']['LINK2']['VALUE']): ?>
                                <a class="home-slider-link"
                                   style="<?= $arItem['PROPS']['BUTTON_COLOR']['VALUE'] ? 'color:' . $arItem['PROPS']['BUTTON_COLOR']['VALUE'] . ';' : '' ?><?= $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] . ';' : '' ?>"
                                   href="<?= $arItem['PROPS']['LINK2']['VALUE'] ?>"><?= $arItem['PROPS']['LINK_TITLE2']['VALUE'] ? $arItem['PROPS']['LINK_TITLE2']['VALUE'] : 'Подробнее' ?></a>
                            <? endif ?>
                        </div>

                    </div>
                <? endforeach ?>
            </div>
        </div>
        <div class="home-slider-carousel-wrapper d-block d-md-none">
            <div class="home-slider-carousel owl-carousel owl-theme">
                <? foreach ($arResult['ITEMS'] as $arItem):
                    if (!$arItem['PREVIEW_PICTURE']) continue;
                    ?>
                    <div class="item"
                         style="background-image: url('<?= $arItem['DETAIL_PICTURE_WEBP'] ?>');"
                         data-bg="<?= $arItem['DETAIL_PICTURE'] ?>"
                         data-bg-webp="<?= $arItem['DETAIL_PICTURE_WEBP'] ?>"
                         title="<?= $arItem['NAME'] ?>"
                    >

                        <a href="<?= $arItem['PROPS']['LINK']['VALUE'] ?>" class="home-slider-text">
                            <div class="home-slider-text-header"><?= $arItem['PROPS']['NAME_HTML_MOB']['VALUE'] ? html_entity_decode($arItem['PROPS']['NAME_HTML_MOB']['VALUE']) : $arItem['NAME'] ?></div>

                            <div class="home-slider-text-sub">
                                <?= $arItem['PREVIEW_TEXT'] ?>
                            </div>
                        </a>

                        <div class="home-slider-links">
                            <a class="home-slider-link"
                               style="<?= $arItem['PROPS']['BUTTON_COLOR']['VALUE'] ? 'color:' . $arItem['PROPS']['BUTTON_COLOR']['VALUE'] . ';' : '' ?><?= $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] . ';' : '' ?>"
                               href="<?= $arItem['PROPS']['LINK']['VALUE'] ?>"><?= $arItem['PROPS']['LINK_TITLE']['VALUE'] ? $arItem['PROPS']['LINK_TITLE']['VALUE'] : 'Подробнее' ?></a>

                            <? if ($arItem['PROPS']['LINK2']['VALUE']): ?>
                                <a class="home-slider-link"
                                   style="<?= $arItem['PROPS']['BUTTON_COLOR']['VALUE'] ? 'color:' . $arItem['PROPS']['BUTTON_COLOR']['VALUE'] . ';' : '' ?><?= $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] ? 'background-color:' . $arItem['PROPS']['BUTTON_BG_COLOR']['VALUE'] . ';' : '' ?>"
                                   href="<?= $arItem['PROPS']['LINK2']['VALUE'] ?>"><?= $arItem['PROPS']['LINK_TITLE2']['VALUE'] ? $arItem['PROPS']['LINK_TITLE2']['VALUE'] : 'Подробнее' ?></a>
                            <? endif ?>

                        </div>

                    </div>
                <? endforeach ?>
            </div>
        </div>
        <div class="home-slider-child">
            <? foreach ($arResult['SMALL_ITEMS'] as $arSmallBanner): ?>

                <div class="home-slider-child-block <?= $arSmallBanner['DETAIL_PICTURE'] ? '__display-xl-block' : '' ?>"
                     style="background-image: url('<?= $arSmallBanner['PREVIEW_PICTURE_WEBP'] ?>');"
                     data-bg="<?= $arSmallBanner['PREVIEW_PICTURE'] ?>"
                     data-bg-webp="<?= $arSmallBanner['PREVIEW_PICTURE_WEBP'] ?>"
                     title="<?= $arSmallBanner['PROPS']['DESCRIPTION']['VALUE'] ?>"
                     onclick="instantLocation('<?= $arSmallBanner['PROPS']['LINK']['VALUE'] ?>')"
                >
                    <? if ($arSmallBanner['PREVIEW_TEXT']): ?>
                        <div class="home-slider-child-bigtext"><?= html_entity_decode($arSmallBanner['PREVIEW_TEXT']) ?></div>
                    <? endif ?>

                    <div class="home-slider-child-text <?= $arSmallBanner['PREVIEW_TEXT'] ? 'home-slider-child-text-hidden' : '' ?>"><?= $arSmallBanner['PROPS']['DESCRIPTION']['VALUE'] ?></div>

                </div>

                <? if ($arSmallBanner['DETAIL_PICTURE']): ?>

                    <div class="home-slider-child-block __display-sm-block"
                         style="background-image: url('<?= $arSmallBanner['PREVIEW_PICTURE_WEBP'] ?>');"
                         data-bg="<?= $arSmallBanner['DETAIL_PICTURE'] ?>"
                         data-bg-webp="<?= $arSmallBanner['DETAIL_PICTURE_WEBP'] ?>"
                         title="<?= $arSmallBanner['PROPS']['DESCRIPTION']['VALUE'] ?>"
                         onclick="instantLocation('<?= $arSmallBanner['PROPS']['LINK']['VALUE'] ?>')"
                    >
                        <? if ($arSmallBanner['PREVIEW_TEXT']): ?>
                            <div class="home-slider-child-bigtext"><?= html_entity_decode($arSmallBanner['PREVIEW_TEXT']) ?></div>
                        <? endif ?>

                        <div class="home-slider-child-text <?= $arSmallBanner['PREVIEW_TEXT'] ? 'home-slider-child-text-hidden' : '' ?>"><?= $arSmallBanner['PROPS']['DESCRIPTION']['VALUE'] ?></div>

                    </div>
                <? endif ?>

            <div class="home-slider-child-divider"></div>

            <? endforeach ?>

        </div>

    </div>
    <?
}