<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

if(!\Bitrix\Main\Loader::includeSharewareModule("redcode.mcorporate"))
	die("Module 'redcode.mcorporate' not installed");

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle(Loc::getMessage("REDCODE_OPTIONS_TITLE"));

$arSites = $arTabs = array();
$moduleClass = MODULE_CLASS;

$dbResult = \Bitrix\Main\SiteTable::getList(
	array(
		"filter" => array("ACTIVE" => "Y")
	)
);
while($result = $dbResult->fetch())
{
	$arSites[] = $result;
}

foreach($arSites as $key => $arSite)
{
	$parametrsFromAdmin = $moduleClass::getParametrsFromAdmin($arSite["LID"]);

	$arTabs[] = array(
		"DIV" => "edit".($key + 1),
		"TAB" => Loc::getMessage("REDCODE_OPTIONS_TAB", array("#SITE_NAME#" => $arSite["NAME"], "#SITE_ID#" => $arSite["LID"])),
		"TITLE" => Loc::getMessage("REDCODE_OPTIONS_TAB_TITLE"),
		"SITE_ID" => $arSite["LID"],
		"PARAMETRS" => $parametrsFromAdmin,
	);
}

$tabControl = new CAdminTabControl("tabControl", $arTabs);

if(check_bitrix_sessid() && $_SERVER["REQUEST_METHOD"] == "POST")
{
	foreach($arTabs as $key => $arTab)
	{
		foreach($moduleClass::$massivParameters as $sectionCode => $section)
		{
			foreach($section["OPTIONS"] as $elementCode => $element)
			{
				$value = $_REQUEST[$elementCode."_".$arTab["SITE_ID"]];
				
				if($element["TYPE"] == "checkbox")
				{
					if($value !== "Y" || empty($value))
						$value = "N";
				}
				if($elementCode === "COLOR" && $_REQUEST[$elementCode."_".$arTab["SITE_ID"]] === "CUSTOM")
				{
					setcookie("COLOR_CUSTOM_".$arTab["SITE_ID"], $_REQUEST["COLOR_CUSTOM_".$arTab["SITE_ID"]], time() + 60 * 60 * 24 * 30, "/");
				}

				$arTab["PARAMETRS"][$elementCode] = $value;
			}
		}
	
		Option::set(MODULE_ID, "NEW_PARAMETRS", serialize($arTab["PARAMETRS"]), $arTab["SITE_ID"]);
		$arTabs[$key] = $arTab;
	}
	
	$APPLICATION->RestartBuffer();
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$tabControl->Begin();

/***************************************************************************
							HTML
****************************************************************************/
?>

<form method="post" action="<?=$APPLICATION->GetCurPage();?>?lang=<?=LANGUAGE_ID?>">
	<?=bitrix_sessid_post();?>
	<?
	foreach($arTabs as $key => $arTab)
	{
		$tabControl->BeginNextTab();
		foreach($moduleClass::$massivParameters as $sectionCode => $section)
		{
			?>
			<tr class="heading">
				<td colspan="2"><?=$section["TITLE"]?></td>
			</tr>
			<?
			foreach($section["OPTIONS"] as $elementCode => $element)
			{
				if(isset($arTab["PARAMETRS"][$elementCode]))
				{
					$elementTitle = $element["TITLE"];
					$elementType = $element["TYPE"];
					$elementList = $element["LIST"];
					$elementSize = $element["SIZE"];
					$elementValue = $arTab["PARAMETRS"][$elementCode];
					$elementChecked = ($elementValue == "Y" ? "checked" : "");
				?>
					<tr>
						<td width="50%"><?=$elementTitle?></td>
						<td width="50%">
							<?if($elementType == "checkbox"):?>
								<input type="checkbox" name="<?=$elementCode."_".$arTab["SITE_ID"];?>" value="Y" <?=$elementChecked;?> />
							<?elseif($elementType == "text"):?>
								<input type="text" name="<?=$elementCode."_".$arTab["SITE_ID"];?>" value="<?=$elementValue;?>" maxlength="<?=$elementSize;?>" />
							<?elseif($elementType == "selectbox"):?>
								<select name="<?=$elementCode."_".$arTab["SITE_ID"];?>">
									<?foreach($elementList as $listCode => $listItem):?>
										<option value="<?=$listCode;?>" <?echo ($elementValue != $listCode ?: "selected");?>>
											<?=$listItem["TITLE"];?>
										</option>
									<?endforeach;?>
								</select>
							<?endif;?>
						</td>
					</tr>
				<?
				}
			}
		}
	}
	
	$tabControl->Buttons(array());
	?>
</form>

<?$tabControl->End();?>

<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>