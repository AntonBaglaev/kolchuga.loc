<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SLIDER_SPEED" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_SPEED"),
		"TYPE" => "STRING",
		"DEFAULT" => "200",
	),
	"SHOW_DOTS" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_SHOW_DOTS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SHOW_NAV" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_SHOW_NAV"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"MOUSE_DRAG" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_MOUSE_DRAG"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"AUTOPLAY" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_AUTOPLAY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"AUTOPLAY_SPEED" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_AUTOPLAY_SPEED"),
		"TYPE" => "STRING",
		"DEFAULT" => "600",
	),
	"AUTOPLAY_HOVER_PAUSE" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_AUTOPLAY_HOVER_PAUSE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"LOOP" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_SLIDER_LOOP"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"ANIMATION_SLIDER" => array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("IL_ANIMATION_SLIDER"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"fadeOut" => "fadeOut",
			"bounceOut" => "bounceOut",
			"slideOutDown" => "slideOutDown",
			"rollOut" => "rollOut",
			"hinge" => "hinge",
		),
		"DEFAULT" => "fadeOut",
	),

	"PAGER_SHOW_ALWAYS" => array(
		"HIDDEN" => "Y",
	),
	"PARENT_SECTION_CODE" => array(
		"HIDDEN" => "Y",
	),
	"PARENT_SECTION" => array(
		"HIDDEN" => "Y",
	),
	"INCLUDE_SUBSECTIONS" => array(
		"HIDDEN" => "Y",
	),
	"STRICT_SECTION_CHECK" => array(
		"HIDDEN" => "Y",
	),
	"DETAIL_URL" => array(
		"HIDDEN" => "Y",
	),
	"FILTER_NAME" => array(
		"HIDDEN" => "Y",
	),
	"SET_LAST_MODIFIED" => array(
		"HIDDEN" => "Y",
	),
	"ADD_SECTIONS_CHAIN" => array(
		"HIDDEN" => "Y",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => array(
		"HIDDEN" => "Y",
	),
	"INCLUDE_IBLOCK_INTO_CHAIN" => array(
		"HIDDEN" => "Y",
	),
	"SET_BROWSER_TITLE" => array(
		"HIDDEN" => "Y",
	),
	"SET_META_KEYWORDS" => array(
		"HIDDEN" => "Y",
	),
	"SET_META_DESCRIPTION" => array(
		"HIDDEN" => "Y",
	),
	"DISPLAY_TOP_PAGER" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_DESC_NUMBERING" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_DESC_NUMBERING_CACHE_TIME" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_SHOW_ALL" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_BASE_LINK_ENABLE" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_TITLE" => array(
		"HIDDEN" => "Y",
	),
	"DISPLAY_BOTTOM_PAGER" => array(
		"HIDDEN" => "Y",
	),
	"PAGER_TEMPLATE" => array(
		"HIDDEN" => "Y",
	),
);