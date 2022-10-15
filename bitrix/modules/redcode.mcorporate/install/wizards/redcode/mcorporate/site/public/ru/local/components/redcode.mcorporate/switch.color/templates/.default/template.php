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
$this->setFrameMode(false);
?>

<div id="switchOptions">
	<div id="switchButton">
		<i class="materialIcons">&#xE8B8;</i>
	</div>
	<div class="switchOptionsWrapper">
		<form method="post" name="updateOptions">
			<?foreach($arResult as $elementCode => $element)
			{
				if($element["VALUE"] === "CUSTOM")
					$customColor = (!empty($arResult["COLOR_CUSTOM"]["VALUE"]) ? $arResult["COLOR_CUSTOM"]["VALUE"] : "");
				else
					$customColor = $arResult["COLOR"]["LIST"][$element["VALUE"]]["COLOR"];

				if($elementCode !== "COLOR_CUSTOM")
				{
					if($elementCode === "COLOR")
					{
			?>
						<div class="elementOption">
							<div class="title"><?=$element["TITLE_FOR_SWITCH"];?></div>
							<div class="element" id="buttonsColor" data-href="<?=SITE_TEMPLATE_PATH;?>">
								<input type="hidden" name="COLOR" value="<?=$element["VALUE"];?>" />
								<input type="hidden" name="COLOR_CUSTOM" value="<?=$customColor;?>" />
								<?foreach($element["LIST"] as $key => $list)
								{
									if($key !== "CUSTOM")
									{
								?>
										<div data-key="<?=$key;?>" <?if($element["VALUE"] == $key) echo "class='active' style='border-color: ".$list["COLOR"]."'";?>>
											<span style="background-color: <?=$list["COLOR"];?>;"></span>
										</div>
									<?
									}
									else
									{
									?>
										<div id="custom" data-key="<?=$key;?>" class="materialIcons <?if($element["VALUE"] == $key) echo "active";?>" <?if($element["VALUE"] == $key) echo "style='border-color: ".$customColor."; color: ".$customColor."'";?>>&#xE3B7;</div>
								<?	}
								}?>
							</div>
						</div>
					<?
					}
					if(!empty($element["TYPE"]) && $element["TYPE"] == "checkbox")
					{
						$elementChecked = ($element["VALUE"] == "Y" ? "checked" : "");
					?>
					<div class="elementOption">
						<div class="element checkbox">
							<input type="checkbox" name="<?=$elementCode;?>" value="<?=$element["VALUE"];?>" <?=$elementChecked;?> />
							<div class="checkboxSwitch">
								<div class="checkboxSwitchBar <?=$elementChecked;?>"></div>
								<div class="checkboxSwitchButton <?=$elementChecked;?>"></div>
							</div>
						</div>
						<div class="title"><?=$element["TITLE_FOR_SWITCH"];?></div>
					</div>
			<?		
					}
				}
			}
			?>
			<div class="blockSubmit">
				<input type="submit" name="switchSubmit" value="<?=GetMessage("APPLY");?>" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
jQuery(function() {
	"use strict";
	
	var $custom = $("#custom"),
		$form = $("form[name='updateOptions']");
	
	$custom.spectrum({
		chooseText: "<?=GetMessage("COLOR_CHOOSE")?>",
		cancelText: "<?=GetMessage("COLOR_CANCEL")?>",
		preferredFormat: "hex",
		showButtons: true,
		showInput: true,
		container: "#switchOptions",
		clickoutFiresChange: false,
		move: function(color){
			$(this).attr("style", "color:" + color.toHexString());
		},
		hide: function(color){
			$(this).attr("style", "color:" + color.toHexString());
		},
		change: function(color){
			$("#buttonsColor div").removeClass("active").css({"border-color": ""});
			$(this).addClass("active");
			
			$("input[name='COLOR']", $form).val($(this).attr("data-key"));
			$("input[name='COLOR_CUSTOM']", $form).val(color.toHexString());
		}
	});
	
	$custom.spectrum("set", $custom.css("background-color"));
	$(".sp-container").appendTo($("#switchOptions"));
	
});
</script>