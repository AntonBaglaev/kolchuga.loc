<?
IncludeModuleLangFile(__FILE__);
Class intervolga_conversion extends CModule
{
	const MODULE_ID = 'intervolga.conversion';
	var $MODULE_ID = 'intervolga.conversion'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("intervolga.conversion_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("intervolga.conversion_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("intervolga.conversion_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("intervolga.conversion_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
        // set exclude mask
        if (CModule::IncludeModule('security'))
        {
            $rs = CSecurityAntiVirus::GetWhiteList();
            $myMask = 'window.eshopOrder=';

            $bMaskSet = false;
            $arWhiteMask = array();
            while($f = $rs->Fetch())
            {
                if ($f['WHITE_SUBSTR'] == $myMask)
                    $bMaskSet = true;

                $arWhiteMask[] = $f['WHITE_SUBSTR'];
            }

            if (!$bMaskSet)
            {
                $arWhiteMask[] = $myMask;
                CSecurityAntiVirus::UpdateWhiteList($arWhiteMask);
            }
        }

        RegisterModuleDependences("main", "OnAfterUserAuthorize", self::MODULE_ID, "CIntervolgaConversion", "OnAfterUserAuthorize");
        RegisterModuleDependences("main", "OnEpilog", self::MODULE_ID, "CIntervolgaConversion", "OnEpilog");
		RegisterModuleDependences("main", "OnProlog", self::MODULE_ID, "CIntervolgaConversion", "OnProlog");
        RegisterModuleDependences('sale', 'OnBasketAdd', self::MODULE_ID, 'CIntervolgaConversion', 'OnBasketAdd');
        RegisterModuleDependences('sale', 'OnOrderAdd', self::MODULE_ID, 'CIntervolgaConversion', 'OnOrderAdd');
		return true;
	}

	function UnInstallDB($arParams = array())
	{
        // unset exclude mask
        if (CModule::IncludeModule('security'))
        {
            $rs = CSecurityAntiVirus::GetWhiteList();
            $myMask = 'window.eshopOrder=';

            $bMaskSet = false;
            $arWhiteMask = array();
            while($f = $rs->Fetch())
            {
                if ($f['WHITE_SUBSTR'] == $myMask)
                    $bMaskSet = true;
                else
                    $arWhiteMask[] = $f['WHITE_SUBSTR'];
            }

            if ($bMaskSet)
            {
                CSecurityAntiVirus::UpdateWhiteList($arWhiteMask);
            }
        }

        UnRegisterModuleDependences('sale', 'OnOrderAdd', self::MODULE_ID, 'CIntervolgaConversion', 'OnOrderAdd');
        UnRegisterModuleDependences('sale', 'OnBasketAdd', self::MODULE_ID, 'CIntervolgaConversion', 'OnBasketAdd');
		UnRegisterModuleDependences("main", "OnProlog", self::MODULE_ID, "CIntervolgaConversion", "OnProlog");
        UnRegisterModuleDependences("main", "OnEpilog", self::MODULE_ID, "CIntervolgaConversion", "OnEpilog");
        UnRegisterModuleDependences("main", "OnAfterUserAuthorize", self::MODULE_ID, "CIntervolgaConversion", "OnAfterUserAuthorize");
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intervolga.conversion/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/intervolga.conversion", true, true);

		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item,
					'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.self::MODULE_ID.'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
        $public_order = '/bitrix/admin/'.self::MODULE_ID.'_order.php';
        if (file_exists($_SERVER["DOCUMENT_ROOT"].$public_order))
            $GLOBALS["APPLICATION"]->SetFileAccessPermission($public_order, array("*" => "R"));
		return true;
	}

	function UnInstallFiles()
	{
        DeleteDirFilesEx("/bitrix/js/intervolga.conversion");

		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
