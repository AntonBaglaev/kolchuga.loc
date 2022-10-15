<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult)){?>
	<ul class="priceMenu">
		<?foreach($arResult as $key => $arItem){
			if($arItem["DEPTH_LEVEL"] > 1) 
				continue;
		?>
			<li data-number="#<?=$key?>#" class="<?echo ($arItem["SELECTED"] ? "selected " : "");?>">
				<span><?=$arItem["TEXT"]?></span>
			</li>
		<?}?>
	</ul>
<?}?>