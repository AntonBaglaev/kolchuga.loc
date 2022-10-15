<?	
	$module_id = 'star.comingsoon';

	if(COption::GetOptionString($module_id, "STAR_COMINGSOON_checkbox_".SITE_ID) == 'Y' || COption::GetOptionString('main', 'site_stopped') == 'Y') {
		if (php_sapi_name() != "cli") {
			global $USER; 
			if (!$USER->IsAdmin() && !(strstr($_SERVER["REQUEST_URI"], 'bitrix'))) {
				include($_SERVER["DOCUMENT_ROOT"]."/bitrix/themes/.default/".$module_id."/simple/".COption::GetOptionString($module_id, "selectbox_theme_".SITE_ID).".php");
				die();
			}
		}
	}
?>