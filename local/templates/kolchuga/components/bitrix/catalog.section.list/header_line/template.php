<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 
	$curr_page = $APPLICATION->GetCurPage();
?>
<ul class="top_menu_child">
	<li class="first_li ">
		<div class="item-text">
			<a class="<?if(strstr($curr_page, '/basket')) echo 'activ';?>" href="/internet_shop/basket/">Корзина</a>
		</div>
	</li>
	<? foreach ($arResult['SECTIONS'] as $arSection): ?>				
	<li class="first_li ">
		<div class="item-text">
			<a class="<?if(strstr($curr_page, $arSection['SECTION_PAGE_URL'])) echo 'activ';?>" href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
		</div>
	</li>
	<? endforeach ?>					
</ul>