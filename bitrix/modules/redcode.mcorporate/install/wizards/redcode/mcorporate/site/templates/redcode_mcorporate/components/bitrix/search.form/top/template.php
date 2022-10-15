<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="modalSearch">
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<?if($arParams["USE_SUGGEST"] === "Y"):?>
			<?$APPLICATION->IncludeComponent(
					"bitrix:search.suggest.input",
					"redcodeInput",
					array(
						"NAME" => "q",
						"VALUE" => "",
						"PLACEHOLDER_TEXT" => $arParams["PLACEHOLDER_TEXT"],
						"INPUT_SIZE" => 15,
						"DROPDOWN_SIZE" => 10
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
		<?else:?>
				<input type="text" name="q" value="" placeholder="<?=$arParams["PLACEHOLDER_TEXT"];?>" />
		<?endif;?>
		<div class="submit">
			<input name="s" type="submit" class="materialIcons" value="&#xE8B6;" />
		</div>
	</form>
	<div class="searchCross"><?=GetMessage("SEARCH_CLOSE");?></div>
</div>