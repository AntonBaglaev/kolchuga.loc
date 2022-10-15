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

$this->addExternalCss(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5');
$this->addExternalJS(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5');
?>
<?/*<script>console.log(<?echo json_encode($arResult['PROPERTIES'])?>);</script>*/?>

<?if(!empty($arResult['PROPERTIES']['N_BANNER']['VALUE'])){?>
<section class="block_salon_baner container-fluid mb-5 " id="<?= $this->GetEditAreaId($arResult['ID']) ?>">
	<div class="row">
		<div class="col-12 pr-0 pl-0">					
				<img src="<?= CFile::GetPath($arResult['PROPERTIES']['N_BANNER']['VALUE']) ?>"  >
				<img src="<?= CFile::GetPath($arResult['PROPERTIES']['N_BANNER_LOGO']['VALUE']) ?>" class="homelogo"  >
				<h3 class="serif-header pt-3 pb-3  d-none d-sm-block"><?=$arResult['PROPERTIES']['N_BANNER_TEXT']['VALUE']?></h3> 
		</div>			
	</div>
</section>
<?}?>

<?if(!empty($arResult['PROPERTIES']['SALON_LOGO']['VALUE']) || !empty($arResult['PROPERTIES']['SALON_LOGO_TEXT']['VALUE'])){?>
<section class="block_salon_1 container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">
			<?if(!empty($arResult['PROPERTIES']['SALON_LOGO']['VALUE'])){?>
				<img src="<?= CFile::GetPath($arResult['PROPERTIES']['SALON_LOGO']['VALUE']) ?>"  >
			<?}?>
			<?if(!empty($arResult['PROPERTIES']['SALON_LOGO_TEXT']['VALUE'])){?>
				<h3 class="mt-5 grey"><?=$arResult['PROPERTIES']['SALON_LOGO_TEXT']['VALUE']?></h3>	
			<?}?>
					 
		</div>			
	</div>
</section>
<?}?>

<?if(!empty($arResult['PROPERTIES']['SALON_MAP']['VALUE'])){?>
<section class="block_salon_karta container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">
			<iframe src="<?=$arResult['PROPERTIES']['SALON_MAP']['VALUE']?>" frameborder="0"></iframe>
		</div>			
	</div>
</section>
<?}?>

<?if(!empty($arResult['PROPERTIES']['SALON_GALEREYA']['VALUE']) && !empty($arResult['PROPERTIES']['SALON_GALEREYA']['LINK_INFO'])){?>
<section class="block_salon_slider container mb-5">
	<div class="row">
		<div class="col-12  ">	
		
			<div class="recommend owl-carousel owl-theme js_recommend">
				<?foreach($arResult['PROPERTIES']['SALON_GALEREYA']['LINK_INFO'] as $arItem){?>
					<div class="recommend__item" >            
						<div class="recommend__img">
							<a data-gallery="gallery-1" class="fancybox" data-fancybox-group="gallery-1>" href="<?=$arItem['PROPERTIES']['REAL_PICTURE']['BIG_F']?>">
								<img src="<?=$arItem['PROPERTIES']['REAL_PICTURE']['SMALL_F']?>" >
							</a>
						</div>                
					</div>
				<?}?>
				<?
				if(count($arResult['PROPERTIES']['SALON_GALEREYA']['LINK_INFO'])<5){
				foreach($arResult['PROPERTIES']['SALON_GALEREYA']['LINK_INFO'] as $arItem){?>					
					<div class="recommend__item" >            
						<div class="recommend__img">
							<a data-gallery="gallery-1" class="fancybox" data-fancybox-group="gallery-1>" href="<?=$arItem['PROPERTIES']['REAL_PICTURE']['BIG_F']?>">
								<img src="<?=$arItem['PROPERTIES']['REAL_PICTURE']['SMALL_F']?>" >
							</a>
						</div>                
					</div>
				<?}
				}?>
			</div>			 
		</div>			
	</div>
</section>
<?}?>

<?if(!empty($arResult['DETAIL_TEXT'])){?>
<section class="block_salon_anons container mb-5">
	<div class="row">
		<div class="col-12 pr-0 pl-0 text-center">					
				<?=$arResult['DETAIL_TEXT']?>		 
		</div>			
	</div>
</section>
<?}?>

<section class="block_salon_time container mb-5">	
		<div class="row justify-content-center">
			<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-4">				
				<small><div class="card">
				  <!-- Default panel contents -->
					<div class="card-header text-center">Часы работы:</div>
						<!-- List group -->
						<ul class="list-group opening-hours text-left">						
						<?
						$vremya=explode('; ', $arResult['PROPERTIES']['clock']['VALUE']);
						foreach($vremya as $el){
							$el_time=explode(': ', $el);
							?>
							<li class="list-group-item"><?=$el_time[0]?> <span class="pull-right"><?=$el_time[1]?></span></li>
							<?}?>
							
						</ul>
						
				</div>	</small>
			</div>
		</div>
	
</section>

<section class="block_salon_form container mb-5">
	<div class="row">
		<div class="col-12 pr-0 pl-0 text-center">					
				<p>Свяжитесь с нами в Москве<br>
по тел.: <?=$arResult['PROPERTIES']['phones']['VALUE']?> или заполните форму ниже </p>				 
		</div>			
	</div>
	<div class="row justify-content-center">
			<div class="col-md-8">
				
						
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"salon",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => Array(),
		"WEB_FORM_ID" => 7
	)
);?>
			</div>
			
		</div>
</section>

<?if(!empty($arResult['PROPERTIES']['N_BANNER_FOOTER']['VALUE'])){?>
<section class="block_salon_baner_foot container-fluid ">
	<div class="row">
		<div class="col-12 pr-0 pl-0 ">					
				<img src="<?= CFile::GetPath($arResult['PROPERTIES']['N_BANNER_FOOTER']['VALUE']) ?>"  >					 
		</div>			
	</div>
</section>
<?}?>