<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php

use Bitrix\Main\Localization\Loc;

if ($ex = $APPLICATION->GetException()) {

    $message = new CAdminMessage([
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MOD_INST_ERR'),
        'DETAILS' => $ex->GetString(),
        'HTML' => true,
    ]);

    echo $message->Show();

} else {

    $message = new CAdminMessage([
        'TYPE' => 'OK',
        'MESSAGE' => Loc::getMessage('MOD_INST_OK'),
    ]);

    echo $message->Show();

}

?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
</form>
