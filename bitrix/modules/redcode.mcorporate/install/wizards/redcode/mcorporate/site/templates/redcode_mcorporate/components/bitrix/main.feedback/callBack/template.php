<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die();
/**
* Bitrix vars
*
* @var array $arParams
* @var array $arResult
* @var CBitrixComponentTemplate $this
* @global CMain $APPLICATION
* @global CUser $USER
*/
?>

<form method="post" class="modal sendForm" data-form="callBack">
	<div class="modalWrapper">

		<div class="modalHeader">
			<div class="materialIcons modalClose">&#xE5CD;</div>
			<h3><?=$arParams["FORM_TITLE"];?></h3>
		</div>
		
		<div class="modalBody">
			<?foreach($arResult["ELEMENT"] as $element) echo $element[0];?>				
		</div>
		
		<?if(!empty($arParams["OPTION_THEME"])):
			foreach($arParams["OPTION_THEME"] as $elementCode => $element):
				if($elementCode === "PERSONAL_INFO" && $element["VALUE"] === "Y"):?>
					<div class="personalInfo">
						<div class="checkboxError"><?=$element["TEXT_ERROR"];?></div>
						<input id="<?=$elementCode;?>_callBack" type="checkbox" name="<?=$elementCode;?>" />
						<label for="<?=$elementCode;?>_callBack">
							<?=$element["TEXT_ONE"];?> <a href="<?=SITE_DIR;?>include_areas/details-agreement.php" target="_blank"><?=$element["TEXT_SECOND"];?></a>
						</label>
					</div>
		<?		endif;
			endforeach;
		endif;?>
		
		<div class="modalFooter">
			<div class="buttonAnimation">
				<input type="hidden" name="emailTo" value="<?=$arParams["EMAIL_TO"];?>" />
				<input type="hidden" name="eventMessageId" value="<?=$arParams["EVENT_MESSAGE_ID"];?>" />
				<input type="submit" data-text="<?=$arParams["FORM_NAME_SUBMIT"];?>" value="<?=$arParams["FORM_NAME_SUBMIT"];?>" class="modalSend" />
				<div class="materialIcons sendOkey">&#xE876;</div>
				<div class="moreAnimationBlock"></div>
			</div>
			<div class="modalFooterSocial">
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
				<div class="workingHours">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", "", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include_areas/contact/working_hours.php",
						)
					);?>
				</div>
			</div>
		</div>
			
	</div>
</form>