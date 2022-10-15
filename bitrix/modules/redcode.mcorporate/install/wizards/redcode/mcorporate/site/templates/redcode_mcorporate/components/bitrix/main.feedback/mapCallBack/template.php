<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

<form method="post" class="sendForm mapCallback" data-form="writeUs">
	<h3><?=$arParams["FORM_TITLE"];?></h3>
	<div class="mapCallback_wrapper">
		<div class="modalBody">
			<?foreach($arResult["ELEMENT"] as $element){?><!--
				--><div <?echo ($element["NAME"] !== "MESSAGE" ? "class='miniBlock'" : "class='bigBlock'");?>><?=$element[0];?></div><!--
			--><?}?>
		</div>
		
		<?if(!empty($arParams["OPTION_THEME"])):
			foreach($arParams["OPTION_THEME"] as $elementCode => $element):
				if($elementCode === "PERSONAL_INFO" && $element["VALUE"] === "Y"):?>
					<div class="personalInfo">
						<div class="checkboxError"><?=$element["TEXT_ERROR"];?></div>
						<input id="<?=$elementCode;?>_writeUs" type="checkbox" name="<?=$elementCode;?>" />
						<label for="<?=$elementCode;?>_writeUs">
							<?=$element["TEXT_ONE"];?> <a href="<?=SITE_DIR;?>include_areas/details-agreement.php" target="_blank"><?=$element["TEXT_SECOND"];?></a>
						</label>
					</div>
		<?		endif;
			endforeach;
		endif;?>
		
		<input type="hidden" name="emailTo" value="<?=$arParams["EMAIL_TO"];?>" />
		<input type="hidden" name="eventMessageId" value="<?=$arParams["EVENT_MESSAGE_ID"];?>" />
	</div>
	<div class="buttonAnimation">
		<input type="submit" data-text="&#xE163;" value="&#xE163;" class="materialIcons modalSend" />
		<div class="materialIcons sendOkey">&#xE876;</div>
		<div class="moreAnimationBlock"></div>
	</div>
</form>