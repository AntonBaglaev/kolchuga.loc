<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(!defined("WIZARD_THEME_ID"))
	return;

use \Bitrix\Main\Config\Option;

$wizard =& $this->GetWizard();

if(\Bitrix\Main\Loader::includeSharewareModule("redcode.mcorporate"))
{
	$parametrsFromAdmin = redcode::getParametrsFromAdmin($wizard->GetVar("siteID"));

	if(!empty($parametrsFromAdmin) && is_array($parametrsFromAdmin))
	{
		foreach(redcode::$massivParameters as $sectionCode => $section)
		{
			foreach($section["OPTIONS"] as $elementCode => $element)
			{
				$value = $parametrsFromAdmin[$elementCode];
				
				if($elementCode === "COLOR")
					$value = WIZARD_THEME_ID;
				
				$newParametrsFromAdmin[$elementCode] = $value;
			}
		}
	}

	Option::set("redcode.mcorporate", "NEW_PARAMETRS", serialize($newParametrsFromAdmin), $wizard->GetVar("siteID"));
}