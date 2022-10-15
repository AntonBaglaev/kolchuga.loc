<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if($detailed)
	echo "</div>";
?>
<footer>
	<div class="footerWrap">
		<div class="footerHeader">
			<div class="footerBlock footerCopyright">
				<div><?=date("Y");?> © <?=$loc->getMessage("ALL_RIGHTS_RESERVED");?></div>
				<?
				if($optionTheme["PERSONAL_INFO"]["VALUE"] == "Y")
				{
					$APPLICATION->IncludeComponent(
						"bitrix:main.include", "", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include_areas/contact/personalInfo.php",
						)
					);
				}
				?>
			</div><!--
		 --><div class="footerBlock footerContacts">
				<div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", "", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include_areas/contact/address.php",
						)
					);?>
				</div>
				<div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", "", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include_areas/contact/phone.php",
						)
					);?>
				</div>
				<div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", "", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include_areas/contact/email.php",
						)
					);?>
				</div>
			</div><!--
		 --><div class="footerBlock footerMenu">
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu", 
					"bottomMenu", 
					array(
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "left",
						"COMPONENT_TEMPLATE" => "bottomMenu",
						"DELAY" => "N",
						"MAX_LEVEL" => "2",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"MENU_THEME" => "site",
						"ROOT_MENU_TYPE" => "bottom",
						"USE_EXT" => "Y"
					),
					false
				);?>
			</div><!--
		 --><div class="footerBlock footerSocial">
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list", 
					"social", 
					array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "N",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "Y",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"COMPONENT_TEMPLATE" => "social",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"DISPLAY_DATE" => "N",
						"DISPLAY_NAME" => "N",
						"DISPLAY_PICTURE" => "N",
						"DISPLAY_PREVIEW_TEXT" => "N",
						"DISPLAY_TOP_PAGER" => "N",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"FILTER_NAME" => "",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => "#SOCIAL_IBLOCK_ID#",
						"IBLOCK_TYPE" => "redcode_mcorporate",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"INCLUDE_SUBSECTIONS" => "N",
						"MESSAGE_404" => "",
						"NEWS_COUNT" => "",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => "modern",
						"PAGER_TITLE" => "social",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array(
							0 => "SOC_LINK",
							1 => "",
						),
						"SET_BROWSER_TITLE" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"SORT_BY1" => "SORT",
						"SORT_BY2" => "SORT",
						"SORT_ORDER1" => "ASC",
						"SORT_ORDER2" => "ASC",
						"FILE_404" => "",
						"STRICT_SECTION_CHECK" => "N"
					),
					false
				);?>
			</div>
		</div>
	</div>
</footer>

<div class="buttonPosition">
	<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include_areas/footer/buttonTop.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);
	?>
</div>
<div class="materialIcons buttonMenu">&#xE5D2;</div>
<div class="materialIcons buttonSearch">&#xE8B6;</div>
<div id="blackBack"></div>
<div id="siteDir" data-dir="<?=SITE_DIR;?>"></div>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	"callBack", 
	array(
		"EMAIL_TO" => "#EMAIL#",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"COMPONENT_TEMPLATE" => "callBack",
		"EVENT_MESSAGE_ID" => "#REDCODE_CALLBACK_ID#",
		"ELEMENT_FORM" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
		),
		"OPTION_THEME" => $optionTheme,
		"USE_CAPTCHA" => "",
		"FORM_TITLE" => "#FORM_TITLE#",
		"FORM_NAME_SUBMIT" => "#FORM_NAME_SUBMIT#"
	),
	false
);
$APPLICATION->IncludeComponent(
	"bitrix:search.form", 
	"top", 
	array(
		"COMPONENT_TEMPLATE" => "top",
		"PAGE" => "#SITE_DIR#search/index.php",
		"USE_SUGGEST" => "Y",
		"PLACEHOLDER_TEXT" => $loc->getMessage("PLACEHOLDER_TEXT")
	),
	false
);
$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"topMenu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "topMenu",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y"
	),
	false
);

$asset->addJs(SITE_TEMPLATE_PATH."/js/jquery.cookie.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/scripts.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/custom.js", true);
$asset->addCss(SITE_TEMPLATE_PATH."/css/custom.css", true);
$asset->addCss("//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");

if($APPLICATION->GetCurPage(false) != SITE_DIR)
{
	$asset->addJs("//yastatic.net/es5-shims/0.0.2/es5-shims.min.js");
	$asset->addJs("//yastatic.net/share2/share.js");
}
else
{
	$asset->addJs(SITE_TEMPLATE_PATH."/js/imagesloaded.pkgd.min.js");
	$asset->addJs(SITE_TEMPLATE_PATH."/js/owl.carousel.min.js");
	$asset->addCss(SITE_TEMPLATE_PATH."/css/owl.carousel.css");
}
?>

</body>
</html>