<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult)){?>
	<ul class="leftMenu">
		<?foreach($arResult as $arItem){
			if($arItem["DEPTH_LEVEL"] > 1) 
				continue;
		?>
			<li <?echo ($arItem["SELECTED"] ? "class='selected'" : "");?>>
				<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			</li>
		<?}?>
	</ul>
<?}?>