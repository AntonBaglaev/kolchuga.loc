<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
if (!$arResult['ITEMS']) return false;
//\Kolchuga\Settings::xmp($arResult,11460, __FILE__.": ".__LINE__);
$arItem=$arResult['ITEMS'][0];
?>
<div class="container-fluid">
	<div class="row">
		<?if(!empty($arItem['PREVIEW_TEXT'])){?>
			<div class="col-12 mb-3 mt-3 mlh pl-10 pr-10">
				<p style="text-align:center;color: #F14E4A;"><?=$arItem['PREVIEW_TEXT']?></p>
			</div>
		<?}else{?>
			<?if(!empty($arItem['DETAIL_PICTURE']['SRC'])){?>
				<div class="col-12 mb-3 mt-3 mlh pl-0 pr-0 text-center d-none d-md-block">
					<?
					$arItem['DETAIL_PICTURE']['SRC_old']=$arItem['DETAIL_PICTURE']['SRC'];
					$arItem['DETAIL_PICTURE'] = \Kolchuga\Pict::getWebp($arItem['DETAIL_PICTURE'],90);					
					?>
					<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])){?>
					<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="alink">
					<?}?>
					<picture>
						<?if ($arItem['DETAIL_PICTURE']['WEBP_SRC']) :?>
							<source type="image/webp" srcset="<?=$arItem['DETAIL_PICTURE']['WEBP_SRC']?>">
						<?endif;?>
						<img src="<?=$arItem['DETAIL_PICTURE']["SRC"]?>"  />
					</picture>
					<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])){?>
						</a>
					<?}?>
				</div>
			<?}?>
			<?if(!empty($arItem['PREVIEW_PICTURE']['SRC'])){?>
				<div class="col-12 mb-3 mt-3 mlh pl-0 pr-0 text-center d-block d-md-none">
					<?
					$arItem['PREVIEW_PICTURE']['SRC_old']=$arItem['PREVIEW_PICTURE']['SRC'];
					$arItem['PREVIEW_PICTURE'] = \Kolchuga\Pict::getWebp($arItem['PREVIEW_PICTURE'],80);					
					?>
					<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])){?>
					<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="alink">
					<?}?>
					<picture>
						<?if ($arItem['PREVIEW_PICTURE']['WEBP_SRC']) :?>
							<source type="image/webp" srcset="<?=$arItem['PREVIEW_PICTURE']['WEBP_SRC']?>">
						<?endif;?>
						<img src="<?=$arItem['PREVIEW_PICTURE']["SRC"]?>"  />
					</picture>
					<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])){?>
						</a>
					<?}?>
				</div>
			<?}?>
		<?}?>
	</div>
</div>