<?
IncludeModuleLangFile(__FILE__);

	$aMenu = array(
		"parent_menu" => "global_menu_tgarl",
		"section" => "tgarl_baza",
		"sort" => 5001,
		"text" => GetMessage("TGARL_ADMINKA_CONTROL"),
		"title" => GetMessage("TGARL_ADMINKA_MENU_TITLE"),
		"icon" => "tgarl_baza_menu_icon",
		"page_icon" => "tgarl_baza_page_icon",
		"items_id" => "menu_tgarl_baza",
		"url" => "tgarl_adminkastr.php?lang=".LANG,
		"items" => array(
			[
                'text' => GetMessage('TGARL_ADMINKA_PUNCT_1'),
                'title' => GetMessage('TGARL_ADMINKA_PUNCT_1'),
                "url" => "tgarl_adminka_assist.php?lang=".LANGUAGE_ID,
            ],
		)
	);
	return $aMenu;

?>