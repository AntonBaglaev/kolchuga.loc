<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$frame = $this->createFrame()->begin("");

$injectId = 'bigdata_recommeded_products_'.rand();

?>
<script type="application/javascript">
	BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
	BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
	BX.current_server_time = '<?=time()?>';

	BX.ready(function(){
		bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
	});

</script>
<?
if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>" class="bigdata_recommended_products_container"></span>

	<script type="application/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script><?

	$frame->end();
	return;
}
?>
<? //echo '<script>console.log(' . \Bitrix\Main\Web\JSON::encode($arResult) . ')</script>';
if(empty($arResult['ITEMS'])) return false;?>
<h2><?=GetMessage('BIGDATA_TITLE')?></h2>
<div class="recommend__wrapper" id="bigdata_carousel">
	<div class="recommend owl-carousel owl-theme js_recommend"><?

		$i = 0;
		foreach($arResult['ITEMS'] as $arItem)
		{
			if(!$arItem['PREVIEW_PICTURE']['SRC'] || $i > 8) continue;
			$i++;

			?><div class="recommend__item">
				<div class="recommend__img">
					<a href="<?= $arItem['DETAIL_PAGE_URL']?>?id=<?=$arItem['ID']?>&rcm=<?=base64_encode($arItem['ADD_URL'])?>">
							 <? /*if ($_GET['dev'] == 1):*/ ?>
		                        <? $resizeImage = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],
                                    array('width' => 200, 'height' => 150),
                                    BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60);  
		                        /*var_dump($arItem['PREVIEW_PICTURE']);*/
		                        ?>
								<img src="<?=$resizeImage['src']?>" alt="<?=$arItem['NAME']?>"/>
		                    <? /*else: ?>
								<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" class="q1234"/>
		                    <?php endif */?>
					</a>
				</div>
				<div class="recommend__title">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>?id=<?=$arItem['ID']?>&rcm=<?=base64_encode($arItem['ADD_URL'])?>"><?=$arItem['NAME']?></a>
				</div><?
				if($arItem['MIN_PRICE']['VALUE'] > 0)
				{
					?><div class="recommend__price"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div><?
				}
			?></div><?
		}

	?></div>
</div>
<script>
	$(document).ready(function(){
		var owlbrand = $('.js_recommend');
		owlbrand.owlCarousel({
			loop:true,
			items:4,
			margin:10,
			dots:false,
			nav:true,
			navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
			responsiveClass:true,
			responsive:{
				0:{
					items:1
				},
				500:{
					items:2
				},
				768:{
					items:3
				},
				1024:{
					items:4
				},
				1100:{
					items:4
				}
			}
		});
	});
</script>
