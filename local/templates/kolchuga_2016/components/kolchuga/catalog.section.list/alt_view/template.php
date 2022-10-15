<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);?>
<? foreach ($arResult['SECTIONS'] as $arSection): ?>
	<? if(count($arSection['ITEMS']) > 0): ?>
		<div class="alt_section <?=$arSection['BLOCK_CLASS']?>">
			<div class="as_title"><?=$arSection['NAME']?></div>
			<div class="as_content">
				<? if(count($arSection['TAGS']) > 0): ?>
					<div class="as_brands">
						<div>Популярные бренды:</div>
						<? foreach($arSection['TAGS'] as $tag): ?>
							<a href="<?=$tag['URL']?>" onclick="return true;"><?=$tag['NAME']?></a>
						<? endforeach ?>
					</div>
				<? endif ?>
				<div class="as_items">
					<? foreach($arSection['ITEMS'] as $arItem): ?>
						<div class="as_item">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>" onclick="return true;">
								<div class="as_photo">
									<? if($arItem['DETAIL_PICTURE']):?>
										<img src="<?=$arItem['DETAIL_PICTURE']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>">
									<? else: ?>
										<div class="no-photo"></div>
									<? endif ?>
								</div>

								<div class="as_name"><?=$arItem['NAME']?></div>
								<span class="price line_price"><?=$arItem['PRICE_FORMATTED']?></span>
								<? if($arItem['OLD_PRICE'] > $arItem['PRICE']): ?>
									<span class="line_old_price"><?=$arItem['OLD_PRICE_FORMATTED']?></span>
									<span class="line_diff_price">(-<?=$arItem['DIFF_PERCENT']?>%)</span>
								<? endif ?>
							</a>
						</div>
					<? endforeach ?>
				</div>
				<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="as_btn_all btn-blue" onclick="return true;">Показать все</a>
			</div>
		</div>
	<? endif ?>
<? endforeach ?>