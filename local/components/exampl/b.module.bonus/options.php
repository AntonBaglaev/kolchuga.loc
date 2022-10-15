<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\UserTable;

$MODULE_ID = 'bonus.program';
$MODULE_AGENT_FUNCTION = '\Bonus\Program\BonusChecker::checkBonusExpired();';

//Только для администратора
if ($USER->IsAdmin() || Loader::includeModule($MODULE_ID)) {

    Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/options.php");
    Loc::loadMessages(__FILE__);

    //Табы
    $arTabs = [
        [
            'DIV' => 'AgentOptions',
            'TAB' => 'Настройки бонусной программы',
            'ICON' => 'ib_agent_options',
            'TITLE' => 'Настройки бонусной программы',
        ],
    ];
    $tabControl = new CAdminTabControl("tabControl", $arTabs);

    //Настройки модуля
    $arOptions = [
        'AgentOptions' => [
            'BONUS_ACTIVE' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => 'N',
                'DESCRIPTION' => 'Включить бонусную программу:',
                'HINT' => '',
                'HEADING' => '',
            ],
            'AGENT_ACTIVE' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => 'N',
                'DESCRIPTION' => 'Включить проверку срока действия бонусных баллов:',
                'HINT' => '',
                'HEADING' => 'Срок действия бонусных баллов',
            ],
            'AGENT_INTERVAL' => [
                'TYPE' => 'text',
                'DEFAULT' => '1440',
                'DESCRIPTION' => 'Интервал проверки срока действия бонусных баллов (мин.):',
                'HINT' => '',
                'HEADING' => '',
            ],
            'BONUS_INTERVAL' => [
                'TYPE' => 'text',
                'DEFAULT' => '30',
                'DESCRIPTION' => 'Срок действия бонусных баллов (дней):',
                'HINT' => '',
                'HEADING' => '',
            ],
            'BONUS_NOTIFICATION' => [
                'TYPE' => 'text',
                'DEFAULT' => '2',
                'DESCRIPTION' => 'Укажите, за какое количество дней отправить уведомление пользователю об окончании срока действия бонусных баллов (дней):',
                'HINT' => '',
                'HEADING' => '',
            ],
            'BONUS_PERCENT' => [
                'TYPE' => 'text',
                'DEFAULT' => '2',
                'DESCRIPTION' => 'Сумма начисляемых бонусных баллов за заказ (процент от суммы заказа):',
                'HINT' => '',
                'HEADING' => 'Начисление бонусных баллов',
            ],
            'BONUS_PRODUCT' => [
                'TYPE' => 'checkbox',
                'DEFAULT' => 'N',
                'DESCRIPTION' => 'Дополнительно начислять бонусные баллы отдельно за каждый товар в заказе (если заполнено свойство товара "Бонусы"):',
                'HINT' => '',
                'HEADING' => '',
            ],

        ],
    ];

    //Вкадки и настройки модуля
    $arAllOptions = [];
    foreach ($arTabs AS $arTab) {

        $optName = $arTab['DIV'];
        $arAllOptions = array_merge($arAllOptions, $arOptions[$optName]);

    }

    //Сохранение параметров
    $request = Application::getInstance()->getContext()->getRequest();

    if ($request->isPost()) {

        if (!empty($request->getPost('save')) || !empty($request->getPost('restore'))) {

            //Установить значения по умолчанию
            if (!empty($request->getPost('restore'))) {

                Option::set($MODULE_ID, 'BONUS_ACTIVE', 'N');
                Option::set($MODULE_ID, 'AGENT_ACTIVE', 'N');
                Option::set($MODULE_ID, 'AGENT_INTERVAL', '1440');
                Option::set($MODULE_ID, 'BONUS_INTERVAL', '30');
                Option::set($MODULE_ID, 'BONUS_NOTIFICATION', '2');
                Option::set($MODULE_ID, 'BONUS_PERCENT', '2');
                Option::set($MODULE_ID, 'BONUS_PRODUCT', 'N');

                CAdminMessage::ShowMessage(['MESSAGE' => Loc::getMessage('MODULE_MESSAGE_DEFAULT_OK'), 'TYPE' => 'OK']);

            } else {

                foreach ($arAllOptions as $code => $v) {

                    if (empty($request->getPost($code))) {

                        //Значение по умолчанию
                        Option::set($MODULE_ID, $code, $v['DEFAULT']);

                    } else {

                        //Для checkbox
                        if ($v['TYPE'] == 'checkbox' && $request->getPost($code) <> 'Y') {

                            Option::set($MODULE_ID, $code, $v['DEFAULT']);
                            continue;

                        }

                        //Для остальных типов
                        Option::set($MODULE_ID, $code, $request->getPost($code));

                    }

                }

                CAdminMessage::ShowMessage(['MESSAGE' => Loc::getMessage('MODULE_MESSAGE_SAVE_OK'), 'TYPE' => 'OK']);

            }

            //Удаляем агента
            CAgent::RemoveModuleAgents($MODULE_ID);

            //Устанавливаем агента
            $dateStart = date('d.m.Y H:i:s', time() + (Option::get($MODULE_ID, 'AGENT_INTERVAL') * 60));
            CAgent::AddAgent($MODULE_AGENT_FUNCTION, $MODULE_ID, 'Y', (Option::get($MODULE_ID, 'AGENT_INTERVAL') * 60), '', Option::get($MODULE_ID, 'AGENT_ACTIVE'), $dateStart);

        }

    }

    $tabControl->Begin();

}

?>

<form method="POST" action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&lang=<?= LANGUAGE_ID ?>">

    <?php

    //Подсказки и сообщения
    Extension::load('ui.hint');
    Extension::load('ui.alerts');

    foreach ($arTabs AS $arTab) {

        $optName = $arTab['DIV'];

        $tabControl->BeginNextTab();

        ?>

        <?php

        foreach ($arOptions[$optName] as $code => $v) { ?>

            <? if (!empty($v['HEADING'])): ?>

                <tr class="heading">
                    <td colspan="2"><?= $v['HEADING'] ?></td>
                </tr>

            <? endif; ?>

            <tr>
                <td width="40%">
                    <label for=""><?= $v['DESCRIPTION'] ?></label>
                </td>
                <td width="60%">

                    <? if ($v['TYPE'] == 'checkbox'): ?>

                        <input type="checkbox" name="<?= $code ?>" id="<?= $code ?>" value="Y"
                               <? if (Option::get($MODULE_ID, $code) == 'Y'): ?>checked<? endif; ?>>

                    <? else: ?>

                        <input type="<?= $v['TYPE'] ?>" size="35" name="<?= $code ?>" id="<?= $code ?>"
                               value="<?= Option::get($MODULE_ID, $code) ?>">

                    <? endif; ?>

                    <? if (!empty($v['HINT'])): ?>

                        <span data-hint="<?= $v['HINT'] ?>"></span>

                    <? endif; ?>

                </td>
            </tr>

            <?php

        }

    }

    ?>

    <? $tabControl->Buttons(); ?>
    <input type="submit" name="save" value="<?= GetMessage("MAIN_SAVE") ?>"
           title="<?= GetMessage("MAIN_OPT_SAVE_TITLE") ?>" class="adm-btn-save">
    <input type="button" name="cancel" value="<?= GetMessage("MAIN_OPT_CANCEL") ?>"
           title="<?= GetMessage("MAIN_OPT_CANCEL_TITLE") ?>" onclick="window.location=''">
    <input type="submit" name="restore" title="<?= GetMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
           OnClick="return confirm('<?= AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
           value="<?= GetMessage("MAIN_RESTORE_DEFAULTS") ?>">
    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>

</form>

<style>
    td.adm-detail-content-cell-r select {
        width: 285px;
    }
</style>