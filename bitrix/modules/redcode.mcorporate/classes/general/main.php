<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

require_once(__DIR__."/../../default_option.php");

use \Bitrix\Main\Config\Option;

class redcode
{
	static $massivParameters;

	function arPrint($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	
	function getParametrsFromAdmin($siteID)
	{
		$defaultOptions = $newOptions = array();
		
		if(!empty(self::$massivParameters) && is_array(self::$massivParameters))
		{
			foreach(self::$massivParameters as $sectionCode => $section)
			{
				foreach($section["OPTIONS"] as $elementCode => $element)
				{
					$defaultOptions[$elementCode] = $element["DEFAULT"];
				}
			}
		}
		
		$newOptions = unserialize(Option::getRealValue(MODULE_ID, "NEW_PARAMETRS", $siteID));
		
		if(!empty($newOptions) && is_array($newOptions))
		{
			foreach($newOptions as $elementCode => $element)
			{
				if(!isset($defaultOptions[$elementCode]))
				{
					unset($newOptions[$elementCode]);
				}
			}
		}
		
		if(!empty($defaultOptions) && is_array($defaultOptions))
		{
			foreach($defaultOptions as $elementCode => $element)
			{
				if(!isset($newOptions[$elementCode]))
				{
					$newOptions[$elementCode] = $element;
				}
			}
		}
		
		return $newOptions;
	}
	
	function updateThemes($colorCustom, $siteID)
	{
		$lastCustomColor = Option::get(MODULE_ID, "lastCustomColor", "", $siteID);

		if($lastCustomColor != $colorCustom && defined("SITE_TEMPLATE_PATH") && !empty($colorCustom))
		{
			if(!class_exists("lessc"))
				require_once("lessc.inc.php");

			$less = new lessc;

			try
			{
				$themeDirPath = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/themes/custom/";	
				
				if(!is_dir($themeDirPath))
					mkdir($themeDirPath, 0755, true);		

				$less->setVariables(array("mainColor" => $colorCustom));
				$newColor = $less->compileFile(__DIR__."/../../css/style.less", $themeDirPath."/style.css");
				
				if($newColor)
					Option::set(MODULE_ID, "lastCustomColor", $colorCustom, $siteID);
			}
			catch(exception $e)
			{
				echo "Fatal error: ".$e->getMessage();
				die();
			}
		}
	}
}