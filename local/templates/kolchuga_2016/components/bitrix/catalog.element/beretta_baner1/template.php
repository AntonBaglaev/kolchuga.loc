<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

?>
<section class="block_bereta_baner container-fluid mb-5 " id="<?= $this->GetEditAreaId($arResult['ID']) ?>">
	<div class="row">
		<div class="col-12 pr-0 pl-0">					
				<img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>"  >
				<img src="<?= $arResult['PREVIEW_PICTURE']['SRC'] ?>" class="homelogo"  >
				<h3 class="serif-header pt-3 pb-3  d-none d-sm-block"><?=$arResult['PREVIEW_TEXT']?></h3> 
		</div>			
	</div>
</section>

