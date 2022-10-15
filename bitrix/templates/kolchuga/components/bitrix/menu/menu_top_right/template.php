<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!empty($arResult)):?>
<ul class="menu_top_right">
	<?$APPLICATION->IncludeComponent(
		"bitrix:sale.basket.basket.line",
		"basketviewer",
		Array(
			"PATH_TO_BASKET" => "/internet_shop/basket/",
			"PATH_TO_PERSONAL" => "/internet_shop/the-order-of-the-goods/",
			"SHOW_PERSONAL_LINK" => "N"
		)
	);?>
	<?
	$previousLevel = 0;
	$len = count($arResult);
	foreach($arResult as $index =>$arItem):
	?>		
		<? if ($arItem["PERMISSION"] > "D"):?>
				<li class="dib <?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?> <?if($arItem["SELECTED"]):?>activ<?endif?>">
					<h2 class="item-text adventure">
						<a href="<?=$arItem["LINK"]?>">
							<?=$arItem["TEXT"]?>
						</a>
					</h2>
					<i></i>
					<em></em>
				</li>
		<?endif?>		
	<?endforeach?>
	
</ul>

<?endif?>