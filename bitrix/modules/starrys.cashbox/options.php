<?php

defined('MODULE_NAME') or define('MODULE_NAME', 'starrys.cashbox');
CModule::IncludeModule(MODULE_NAME);
CModule::IncludeModule("sale");

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Sale\Cashbox\Manager;


if (!$USER->isAdmin()) {
    $APPLICATION->authForm('Nope');
}


$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();
CJSCore::Init(array('ajax'));
$sidAjax = 'StarrysCashbox';
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
   $APPLICATION->RestartBuffer();
   $cashbox = Manager::getObjectById($_REQUEST['id']);
   $result = $cashbox->getState($id);
   echo CUtil::PhpToJSObject($result['MSG']);
   die();
}
?>
<script>
  function starrysCheckConnect(id, button) {
    button.disabled = true;
    BX.ajax.loadJSON(
      '<?=sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID)?>&ajax_form=<?=$sidAjax?>'+'&id='+id,
      function(result){
        button.disabled = false;
        alert(result);
      }
   );
    return false;
  }
</script>
<?php

Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);


$arAllOptions = Array(
  Array("log", Loc::getMessage("STARRYS.CASHBOX_OPTIONS_LOG"), Array("radio", ""), ""),
);


$tabControl = new CAdminTabControl("tabControl", array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_SET"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
    ),
));
$message = '';
if (strlen($Update.$Apply)>0 && $request->isPost() && check_bitrix_sessid()) {
  foreach($arAllOptions as $arOption) {
    if(in_array($name, array('cert_path','key_path')) && $val!=''){
      if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/'.trim($val," \t\n\r\0\x0B/"))) {
        $message = Loc::getMessage("STARRYS.CASHBOX_OPTIONS_ERROR_PATH", array('#PATH#'=>$val));
        CAdminMessage::ShowMessage($message );
      }
    }
    $name = $arOption[0];
    $val = $request->getPost($name);
    Option::set(MODULE_NAME, $name, $val);
  }
}

$tabControl->begin();
?>


<form method="post" id="form1" action="<?=sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID)?>"><?
$tabControl->beginNextTab();
?>
<tr>
<td colspan="2">
  <? echo Loc::getMessage('STARRYS.CASHBOX_OPTIONS_SETTINGS_IS_MOVING')?>
</td>
</tr>
<?  foreach($arAllOptions as $arOption):
    $val = Option::get(MODULE_NAME, $arOption[0]);
    $type = $arOption[2];
  ?>
    <tr>
      <td valign="top" width="50%"><?
              echo $arOption[1];?><br><small><?echo htmlspecialchars($arOption[3])?></small></td>
      <td valign="top" width="50%">
          <?if($type[0] == "text"):?>
            <input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialchars($val)?>" name="<?echo htmlspecialchars($arOption[0])?>">
          <?elseif($type[0] == "textarea"):?>
            <textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialchars($arOption[0])?>"><?echo htmlspecialchars($val)?></textarea>
          <?elseif($type[0] == "radio"):?>
            <input type="radio" value="1" name="<?echo htmlspecialchars($arOption[0])?>" <?if($val==1)echo 'checked="checked"'?>/> <?=Loc::getMessage('STARRYS.CASHBOX_OPTIONS_YES')?> <br/>
            <input type="radio" value="0" name="<?echo htmlspecialchars($arOption[0])?>" <?if($val==0)echo 'checked="checked"'?>/> <?=Loc::getMessage('STARRYS.CASHBOX_OPTIONS_NO')?>
          <?elseif($type[0] == "list"):?>
            <select name="<?echo htmlspecialchars($arOption[0])?>"> <?=Loc::getMessage('STARRYS.CASHBOX_OPTIONS_YES')?>
            <?foreach($type[1] as $key => $value):?>
              <option value="<?=$key?>"  <?if($val == $key)echo 'selected="selected"'?>><?=$value?></option>
            <?endforeach;?>
            </select>
          <?endif;?>
      </td>
    </tr>
  <?endforeach?>
  <?php
  $cashboxes = Starrys\Cashbox\CashboxStarrys::getStarrysCashboxes();
  foreach($cashboxes as $cashbox) {
    ?>
    <tr>
    <td colspan="2">
    <button type="button" class="adm-btn" onclick="starrysCheckConnect(<?php echo $cashbox['ID']?>, this)"><?=Loc::getMessage("STARRYS.CASHBOX_OPTIONS_CHECK_CONNECTION")?>"<?php echo $cashbox['NAME']?>"</button>
    </td>
    </tr>
    <?php
  }
  ?>
  <?php if(!function_exists("curl_init")):?>
  <tr>
  <td colspan="2"><span style="color:red"><?=Loc::getMessage("STARRYS.CASHBOX_OPTIONS_CURL_DEP")?></span></td>
  </tr>
<?php endif;?>
<?$tabControl->buttons();?>
  <input type="submit" name="Update" value="<?=Loc::getMessage("MAIN_SAVE")?>" title="<?=Loc::getMessage("MAIN_OPT_SAVE_TITLE")?>">
  <?if(strlen($_REQUEST["back_url_settings"])>0):?>
    <input type="button" name="Cancel" value="<?=Loc::getMessage("MAIN_OPT_CANCEL")?>" title="<?=Loc::getMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialchars(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
    <input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
  <?endif?>
  <?=bitrix_sessid_post();?>
<?$tabControl->end();?>
</form>