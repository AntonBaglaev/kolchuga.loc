<?php
use \Bitrix\Main\Localization;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Config\Option;
Loc::loadMessages($_SERVER["DOCUMENT_ROOT"].BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);
$module_id = "litebox.kassa";
$RIGHT = $APPLICATION->GetGroupRight($module_id);

if ($RIGHT >= "R") :
    $aTabs = [
        ["DIV" => "edit1", "TAB" => 'Документация', "ICON" => "perfmon_settings", "TITLE" => 'Документация'],
        ["DIV" => "edit2", "TAB" => 'Настройки', "ICON" => "perfmon_settings", "TITLE" => 'Настройки'],
    ];
    $tabControl = new CAdminTabControl("tabControl", $aTabs);
    Loader::includeModule($module_id);
    $module_path = '/upload/litebox/';
    ?>
    <form method="post" enctype="multipart/form-data" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($module_id)?>&amp;lang=<?=LANGUAGE_ID?>">
        <?php
        $tabControl->Begin();
        $tabControl->BeginNextTab(); ?>
        <h2>Модуль реализации API для обмена с системой LiteBox.</h2>
        <p>
            В состав модуля входит комплексный компонент, который содержит в себе роутинг по api и библиотеки скриптов.<br>
            Типизация данных происходит под формат json<br>
            После установки модуля будет скопирована папка в корень проекта /api/ с подключением компонента<br>
            API поддерживает версионность<br>
            Для корректной работоспособности необходима лиценция Управление сайтом - **Бизнес**<br>
            Проверка работоспособности:  domain/api/v1/token - ответ json с токеном
        </p>

        <? $tabControl->BeginNextTab(); ?>
        <? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php"); ?>
        <? $tabControl->Buttons(); ?>
        <input <? if ($RIGHT<"W") echo "disabled" ?> type="submit" name="Update" value="<?= Loc::getMessage("MAIN_SAVE") ?>" title="<?= Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>" class="adm-btn-save">
        <input <? if ($RIGHT<"W") echo "disabled" ?> type="submit" name="Apply" value="<?= Loc::getMessage("MAIN_OPT_APPLY") ?>" title="<?= Loc::getMessage("MAIN_OPT_APPLY_TITLE") ?>">
        <? if (strlen($_REQUEST["back_url_settings"]) > 0):?>
            <input <?if ($RIGHT<"W") echo "disabled" ?> type="button" name="Cancel" value="<?= Loc::getMessage("MAIN_OPT_CANCEL") ?>" title="<?= Loc::getMessage("MAIN_OPT_CANCEL_TITLE") ?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
            <input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>">
        <? endif ?>
        <input type="submit" name="RestoreDefaults" title="<?= Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>" OnClick="confirm('<?= Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING") ?>')" value="<?= Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>">
        <?= bitrix_sessid_post(); ?>
        <? $tabControl->End();?>
    </form>
    <?
    if (!empty($arNotes)) {
        echo BeginNote();
        foreach($arNotes as $i => $str)
        {
            ?><span class="required"><sup><?echo $i+1?></sup></span><?echo $str?><br><?
        }
        echo EndNote();
    }
    ?>
<?endif;?>