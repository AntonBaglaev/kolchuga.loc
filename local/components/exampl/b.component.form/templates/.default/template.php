<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;

CJSCore::Init(['jquery']);

$pathToAjax = $component->getPath() . '/ajax.php';

//Телефонная маска
$this->addExternalJS($templateFolder . '/js/jquery.maskedinput.js');

?>

<div class="simple-form <?= $arParams['FORM_ID'] ?>">

    <? if (!empty($arParams['IBLOCK_ID']) && !empty($arParams['MESSAGE_ID']) && !empty($arParams['FORM_ID']) &&
        !empty($arParams['PROPERTY_NAME_ID']) && !empty($arParams['PROPERTY_PHONE_ID']) && !empty($arParams['PROPERTY_EMAIL_ID']) &&
        !empty($arParams['PROPERTY_MESSAGE_ID']) && !empty($arParams['PROPERTY_FILE_ID']) && !empty($arParams['PROPERTY_FILE_MAX_SIZE'])): ?>

        <form action="<?= POST_FORM_ACTION_URI ?>" method="POST" enctype="multipart/form-data" id="simple-form">

            <input type="hidden" name="AJAX_MODE" value="<?= $arParams['FORM_AJAX_MODE'] ?>">
            <input type="hidden" name="PATH_TO_AJAX" value="<?= $pathToAjax ?>">
            <input type="hidden" name="IBLOCK_ID" value="<?= $arParams['IBLOCK_ID'] ?>">
            <input type="hidden" name="MESSAGE_ID" value="<?= $arParams['MESSAGE_ID'] ?>">
            <input type="hidden" name="FORM_ID" value="<?= $arParams['FORM_ID'] ?>">

            <input type="hidden" name="PROPERTY_NAME_ID" value="<?= $arParams['PROPERTY_NAME_ID'] ?>">
            <input type="hidden" name="PROPERTY_NAME_REQUREARED" value="<?= $arParams['PROPERTY_NAME_REQUREARED'] ?>">
            <input type="hidden" name="PROPERTY_PHONE_ID" value="<?= $arParams['PROPERTY_PHONE_ID'] ?>">
            <input type="hidden" name="PROPERTY_PHONE_REQUREARED" value="<?= $arParams['PROPERTY_PHONE_REQUREARED'] ?>">
            <input type="hidden" name="PROPERTY_EMAIL_ID" value="<?= $arParams['PROPERTY_EMAIL_ID'] ?>">
            <input type="hidden" name="PROPERTY_EMAIL_REQUREARED" value="<?= $arParams['PROPERTY_EMAIL_REQUREARED'] ?>">
            <input type="hidden" name="PROPERTY_MESSAGE_ID" value="<?= $arParams['PROPERTY_MESSAGE_ID'] ?>">
            <input type="hidden" name="PROPERTY_MESSAGE_REQUREARED" value="<?= $arParams['PROPERTY_MESSAGE_REQUREARED'] ?>">
            <input type="hidden" name="PROPERTY_FILE_ID" value="<?= $arParams['PROPERTY_FILE_ID'] ?>">
            <input type="hidden" name="PROPERTY_FILE_REQUREARED" value="<?= $arParams['PROPERTY_FILE_REQUREARED'] ?>">
            <input type="hidden" name="PROPERTY_FILE_MAX_SIZE" value="<?= $arParams['PROPERTY_FILE_MAX_SIZE'] ?>">

            <!-- Название и описание формы -->

            <div class="form-title">
                <?= $arParams['FORM_TITLE_TEXT'] ?>
            </div>

            <div class="form-subtitle">
                <?= $arParams['FORM_SUBTITLE_TEXT'] ?>
            </div>

            <!-- /Название и описание формы -->

            <? if (!empty($arResult['successes']['result'])): ?>
                <div class="text-success">
                    <?= $arParams['FORM_SUCCESS_TEXT'] ?>
                </div>
            <? endif; ?>

            <? if (!empty($arResult['errors']['system'])): ?>
                <div class="text-error">
                    <?= $arParams['FORM_ERROR_TEXT'] ?><br /><br />
                    <?= $arResult['errors']['system'] ?>
                </div>
            <? endif; ?>

            <? if ((!empty($arResult['successes']['result']) || !empty($arResult['errors']['system'])) && $arParams['FORM_AJAX_MODE'] == 'Y'): ?>

            <? else: ?>

                <!-- Поля формы -->

                <? if ($arParams['PROPERTY_NAME_HIDE'] != 'Y' || $arParams['PROPERTY_NAME_REQUREARED'] == 'Y'): ?>
                    <div class="mf-name">
                        <div class="mf-text">
                            <?= $arParams['PROPERTY_NAME_TITLE'] ?>:
                            <? if ($arParams['PROPERTY_NAME_REQUREARED'] == 'Y'): ?>
                                <span class="mf-req">*</span>
                            <? endif; ?>
                        </div>
                        <div class="mf-error name <?= ($arResult['errors']['name']) ? 'active' : '' ?>"><?= Loc::getMessage("SIMPLE_FORM_MF_ERROR1") ?></div>
                        <input type="text" name="name"
                               value="<?= ($arResult['successes']['result']) ? '' : $arResult['fields']['name'] ?>"
                               id="name"
                               class="<?= ($arResult['errors']['name']) ? 'error' : '' ?>"
                               placeholder="<?= $arParams['PROPERTY_NAME_TITLE'] ?>" <?= ($arParams['PROPERTY_NAME_REQUREARED'] == 'Y') ? 'required' : '' ?>>
                    </div>
                <? endif; ?>

                <? if ($arParams['PROPERTY_EMAIL_HIDE'] != 'Y' || $arParams['PROPERTY_EMAIL_REQUREARED'] == 'Y'): ?>
                    <div class="mf-email">
                        <div class="mf-text">
                            <?= $arParams['PROPERTY_EMAIL_TITLE'] ?>:
                            <? if ($arParams['PROPERTY_EMAIL_REQUREARED'] == 'Y'): ?>
                                <span class="mf-req">*</span>
                            <? endif; ?>
                        </div>
                        <div class="mf-error email <?= ($arResult['errors']['email']) ? 'active' : '' ?>"><?= Loc::getMessage("SIMPLE_FORM_MF_ERROR2") ?></div>
                        <input type="text" name="email"
                               value="<?= ($arResult['successes']['result']) ? '' : $arResult['fields']['email'] ?>"
                               id="email"
                               class="<?= ($arResult['errors']['email']) ? 'error' : '' ?>"
                               placeholder="<?= $arParams['PROPERTY_EMAIL_TITLE'] ?>" <?= ($arParams['PROPERTY_EMAIL_REQUREARED'] == 'Y') ? 'required' : '' ?>>
                    </div>
                <? endif; ?>

                <? if ($arParams['PROPERTY_PHONE_HIDE'] != 'Y' || $arParams['PROPERTY_PHONE_REQUREARED'] == 'Y'): ?>
                    <div class="mf-phone">
                        <div class="mf-text">
                            <?= $arParams['PROPERTY_PHONE_TITLE'] ?>:
                            <? if ($arParams['PROPERTY_PHONE_REQUREARED'] == 'Y'): ?>
                                <span class="mf-req">*</span>
                            <? endif; ?>
                        </div>
                        <div class="mf-error phone <?= ($arResult['errors']['phone']) ? 'active' : '' ?>"><?= Loc::getMessage("SIMPLE_FORM_MF_ERROR2") ?></div>
                        <input type="text" name="phone"
                               value="<?= ($arResult['successes']['result']) ? '' : $arResult['fields']['phone'] ?>"
                               id="phone"
                               class="<?= ($arResult['errors']['phone']) ? 'error' : '' ?>"
                               data-mask="<?= ($arParams['PROPERTY_PHONE_MASK'] == 'Y') ? $arParams['PROPERTY_PHONE_MASK_CODE'] : '' ?>"
                               placeholder="<?= $arParams['PROPERTY_PHONE_TITLE'] ?>" <?= ($arParams['PROPERTY_PHONE_REQUREARED'] == 'Y') ? 'required' : '' ?>>
                    </div>
                <? endif; ?>

                <? if ($arParams['PROPERTY_MESSAGE_HIDE'] != 'Y' || $arParams['PROPERTY_MESSAGE_REQUREARED'] == 'Y'): ?>
                    <div class="mf-message">
                        <div class="mf-text">
                            <?= $arParams['PROPERTY_MESSAGE_TITLE'] ?>:
                            <? if ($arParams['PROPERTY_MESSAGE_REQUREARED'] == 'Y'): ?>
                                <span class="mf-req">*</span>
                            <? endif; ?>
                        </div>
                        <div class="mf-error message <?= ($arResult['errors']['message']) ? 'active' : '' ?>"><?= Loc::getMessage("SIMPLE_FORM_MF_ERROR1") ?></div>
                        <textarea name="message" id="message"
                                  class="<?= ($arResult['errors']['message']) ? 'error' : '' ?>"
                                  placeholder="<?= $arParams['PROPERTY_MESSAGE_TITLE'] ?>" <?= ($arParams['PROPERTY_MESSAGE_REQUREARED'] == 'Y') ? 'required' : '' ?>><?= ($arResult['successes']['result']) ? '' : $arResult['fields']['message'] ?></textarea>
                    </div>
                <? endif; ?>

                <? if ($arParams['PROPERTY_FILE_HIDE'] != 'Y' || $arParams['PROPERTY_FILE_REQUREARED'] == 'Y'): ?>
                    <div class="mf-file">
                        <div class="mf-text">
                            <?= $arParams['PROPERTY_FILE_TITLE'] ?>:
                            <? if ($arParams['PROPERTY_FILE_REQUREARED'] == 'Y'): ?>
                                <span class="mf-req">*</span>
                            <? endif; ?>
                        </div>
                        <div class="mf-error file <?= ($arResult['errors']['file']) ? 'active' : '' ?>"><?= Loc::getMessage("SIMPLE_FORM_MF_ERROR3") ?></div>
                        <input type="file" name="file" id="file"
                               class="<?= ($arResult['errors']['file']) ? 'error' : '' ?>"
                               placeholder="<?= $arParams['PROPERTY_FILE_TITLE'] ?>" <?= ($arParams['PROPERTY_FILE_REQUREARED'] == 'Y') ? 'required' : '' ?>>
                    </div>
                <? endif; ?>

                <div class="mf-submit">
                    <button type="submit" class="submit"><?= $arParams['FORM_BUTTON_TEXT'] ?></button>
                </div>

                <!-- /Поля формы -->

            <? endif; ?>

        </form>

        <div id="loader">
            <img src="<?= $templateFolder ?>/img/loader.svg">
        </div>

    <? else: ?>

        <div class="component-error"><?= Loc::getMessage("COMPONENT_ERROR") ?></div>

    <? endif; ?>

</div>

