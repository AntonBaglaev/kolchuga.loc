<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 23.04.2018
 * Time: 13:06
 */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if(!check_bitrix_sessid()){

	return;
}

if($errorException = $APPLICATION->GetException()){

	echo(CAdminMessage::ShowMessage($errorException->GetString()));
}else{

	echo(CAdminMessage::ShowNote(Loc::getMessage("RITG_SYNC_STEP_BEFORE")." ".Loc::getMessage("RITG_SYNC_STEP_AFTER")));
}
?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>">
	<input type="hidden" name="lang" value="<? echo(LANG); ?>" />
	<input type="submit" value="<? echo(Loc::getMessage("RITG_SYNC_STEP_SUBMIT_BACK")); ?>">
</form>