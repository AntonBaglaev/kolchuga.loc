<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

redcode::$massivParameters = array(
	"MAIN" => array(
		"TITLE" => GetMessage("REDCODE_MAIN_OPTIONS"),
		"OPTIONS" => array(
			"COLOR" => array(
				"TITLE" => Loc::getMessage("REDCODE_COLOR_TITLE"),
				"TITLE_FOR_SWITCH" => Loc::getMessage("REDCODE_COLOR_TITLE_FOR_SWITCH"),
				"TYPE" => "selectbox",
				"DEFAULT" => "1",
				"LIST" => array(
					"1" => array("COLOR" => "#EF6C00", "TITLE" => Loc::getMessage("REDCODE_COLOR_1")),
					"2" => array("COLOR" => "#F4511E", "TITLE" => Loc::getMessage("REDCODE_COLOR_2")),
					"3" => array("COLOR" => "#E53935", "TITLE" => Loc::getMessage("REDCODE_COLOR_3")),
					"4" => array("COLOR" => "#D81B60", "TITLE" => Loc::getMessage("REDCODE_COLOR_4")),
					"5" => array("COLOR" => "#7E57C2", "TITLE" => Loc::getMessage("REDCODE_COLOR_5")),
					"6" => array("COLOR" => "#3F51B5", "TITLE" => Loc::getMessage("REDCODE_COLOR_6")),
					"7" => array("COLOR" => "#107bb1", "TITLE" => Loc::getMessage("REDCODE_COLOR_7")),
					"8" => array("COLOR" => "#1E88E5", "TITLE" => Loc::getMessage("REDCODE_COLOR_8")),
					"9" => array("COLOR" => "#009688", "TITLE" => Loc::getMessage("REDCODE_COLOR_9")),
					"10" => array("COLOR" => "#43A047", "TITLE" => Loc::getMessage("REDCODE_COLOR_10")),
					"11" => array("COLOR" => "#689F38", "TITLE" => Loc::getMessage("REDCODE_COLOR_11")),
					"12" => array("COLOR" => "#546E7A", "TITLE" => Loc::getMessage("REDCODE_COLOR_12")),
					"CUSTOM" => array("COLOR" => "#EF6C00", "TITLE" => Loc::getMessage("REDCODE_COLOR_CUSTOM")),
				),
			),
			"COLOR_CUSTOM" => array(
				"TITLE" => Loc::getMessage("REDCODE_COLOR_CUSTOM_TITLE"),
				"TYPE" => "text",
				"SIZE" => "7",
				"DEFAULT" => "#EF6C00",
			),
			"PERSONAL_INFO" => array(
				"TITLE" => Loc::getMessage("REDCODE_PERSONAL_INFO_TITLE"),
				"TITLE_FOR_SWITCH" => Loc::getMessage("REDCODE_PERSONAL_INFO_TITLE_FOR_SWITCH"),
				"TEXT_ERROR" => Loc::getMessage("REDCODE_PERSONAL_INFO_TEXT_ERROR"),
				"TEXT_ONE" => Loc::getMessage("REDCODE_PERSONAL_INFO_TEXT_ONE"),
				"TEXT_SECOND" => Loc::getMessage("REDCODE_PERSONAL_INFO_TEXT_SECOND"),
				"TYPE" => "checkbox",
				"DEFAULT" => "Y",
			),
		)
	),
);