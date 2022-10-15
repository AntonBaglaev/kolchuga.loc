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
$this->setFrameMode(true);
$this->addExternalCss(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.5');
$this->addExternalJS(SITE_TEMPLATE_PATH.'/js/plugins/fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.5');
?>
<?//echo "<pre style='text-align:left;'>";print_r($arResult['PROPERTIES']['VIDEO_YOUTUBE']);echo "</pre>";
/* [VALUE] => https://youtu.be/0hNT7kAZAuI
    [DESCRIPTION] => Benelli Wild */
	//\Kolchuga\Settings::xmp($arResult['PROPERTIES']['SLIDER'],11460, __FILE__.": ".__LINE__);
	//\Kolchuga\Settings::xmp($arResult['PROPERTIES']['TITLE_ALT_SLIDER'],11460, __FILE__.": ".__LINE__);
?>
<section class="block_lend_ban container-fluid mb-5 ">
	<div class="row">
		<div class="col-12 text-center">
			<?if(!empty($arResult['PROPERTIES']['LINK_DETAIL_PICTURE']['VALUE'])){?>
				<a href="<?=$arResult['PROPERTIES']['LINK_DETAIL_PICTURE']['VALUE']?>"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt='<?=$arResult['DETAIL_PICTURE']['ALT']?>' title='<?=$arResult['DETAIL_PICTURE']['TITLE']?>' ></a>
			<?}else{?>
				<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt='<?=$arResult['DETAIL_PICTURE']['ALT']?>' title='<?=$arResult['DETAIL_PICTURE']['TITLE']?>' >
			<?}?>
				<div class="block_bereta_1 opis">
					<h1 class="mb-5 grey"><?=$arResult['NAME']?></h1>	
					<h2 class="grey"><?=$arResult['PROPERTIES']['MINI_ANONS']['VALUE']?></h2>
				</div>
		</div>
				
	</div>
</section>


<section class="block_lend_anons container mb-5 ">
	<div class="row">
		<div class="col-1 text-center"></div>
		<div class="col-10 grey text-center">
			<?=$arResult['PREVIEW_TEXT']?>			
		</div>
		<div class="col-1 text-center"></div>
	</div>
</section>

<?if(!empty($arResult['PROPERTIES']['SLIDER']['VALUE'])){?>
	<?//echo "<pre style='text-align:left;'>";print_r($arResult['PROPERTIES']['SLIDER']);echo "</pre>";?>
	<section class="block_lend_slider container-fluid mb-5 ">
	<div class="row">
		
		<div class="col-12 ">					
<div class="slider-wrap1">
  <div class="slider-for">
  <?foreach($arResult['PROPERTIES']['SLIDER']['VALUE'] as $kl=>$fotoid){
	  $galerea[$kl]=\CFile::GetPath($fotoid);
	  //$galereanavi[$kl]=\CFile::ResizeImageGet( $fotoid,   ['width' => 280, 'height' => 186],BX_RESIZE_IMAGE_EXACT)['src'];
	  $galereanavi[$kl]=\CFile::ResizeImageGet( $fotoid,   ['width' => 160, 'height' => 110],BX_RESIZE_IMAGE_PROPORTIONAL)['src'];
	  
  }
  foreach($galerea as $kl=>$vl){  ?>
	<div class="block_slide_content"> <a class="fancybox"  data-src="<?=$vl?>" href="javascript:void(0);"><img src="<?=$vl?>" alt='<?=$arResult['PROPERTIES']['TITLE_ALT_SLIDER']['VALUE'][$kl]?>' title='<?=$arResult['PROPERTIES']['TITLE_ALT_SLIDER']['DESCRIPTION'][$kl]?>'></a><div class='block_slide_description'><?=$arResult['PROPERTIES']['SLIDER']['DESCRIPTION'][$kl]?></div> </div>
  <?}
  /* if(count($galerea)<6){
	  foreach($galerea as $kl=>$vl){  ?>
		<div class="block_slide_content"> <a  class="fancybox"  data-src="<?=$vl?>" href="javascript:void(0);"><img src="<?=$vl?>" ></a> </div>
	  <?}
  } */
  ?>
 </div>

  <div class="slider-nav">
  <?foreach($galereanavi as $kl=>$vl){  ?>
	<div class="block_slide_content"> <img src="<?=$vl?>" alt='<?=(!empty($arResult['PROPERTIES']['TITLE_ALT_SLIDER']['VALUE'][$kl]) ? $arResult['PROPERTIES']['TITLE_ALT_SLIDER']['VALUE'][$kl].' мини':'')?>' title='<?=(!empty($arResult['PROPERTIES']['TITLE_ALT_SLIDER']['DESCRIPTION'][$kl]) ? $arResult['PROPERTIES']['TITLE_ALT_SLIDER']['DESCRIPTION'][$kl].' ':'')?>'> </div>
  <?}
  /* if(count($galereanavi)<6){
	  foreach($galereanavi as $vl){  ?>
		<div class="block_slide_content"> <img src="<?=$vl?>"> </div>
	  <?}
  } */
  ?>
 </div>
  </div>
			
			<script>
			$(document).ready(function() {
				/*$('.slider-wrap1 .slider-for a.fancybox').fancybox({
  selector : '.slick-active',
  hash     : false
});*/

$slider = $('.slider-wrap1 .slider-for');
  $slider.slick({
  asNavFor: '.slider-wrap1 .slider-nav',
 variableWidth: true,
        centerPadding: '80px',
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
		lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		arrows: true,
		
});

/*.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
  var href=$('a.fancybox', $slider).eq(nextSlide).attr('data-src');
  $('.slider-wrap1 .slider-for a.fancybox').fancybox({
       href : href
   });
})*/
/*$slider.on('afterChange', function(event, slick, currentSlide){  
	var href=$('a.fancybox', $slider).eq(currentSlide).attr('data-src');
	$('.slider-wrap1 .slider-for a.fancybox').fancybox({
       href : href
   });   
});*/
var href=$('.slider-wrap1 .slider-for .slick-active a.fancybox').attr('data-src');
$('.slider-wrap1 .slider-for .slick-active a.fancybox').fancybox({
       href : href
   });
$slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
	//console.log(currentSlide + ' -> ' + nextSlide);	
	var href=$('.slider-wrap1 .slider-for [data-slick-index="'+nextSlide+'"] a.fancybox').attr('data-src');	
		$('.slider-wrap1 .slider-for a.fancybox').fancybox({
		   href : href
	   });	
	   
});

$('.slider-wrap1 .slider-nav').slick({
  slidesToShow: 8,
  slidesToScroll: 1,
  asNavFor: '.slider-wrap1 .slider-for',
  dots: false,
  centerMode: false,
  focusOnSelect: true,
  centerPadding: '80px',
  lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
		responsive: [
		{
      breakpoint: 1280,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '60px',
        slidesToShow: 6
      }
    },
		{
      breakpoint: 1024,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 5
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '10px',
        slidesToShow: 3
      }
    }
  ]
});
  
});
/*$(document).on('click','.slider-wrap1 .slider-for .slick-active a.fancybox',function(){
	$(this).fancybox({
       href : $(this).attr('data-src')
   });
});*/

</script>
<style>
.slider-wrap1 .slider-for, .slider-wrap1 .slider-nav{display:none;}
.slider-wrap1 .slider-for.slick-initialized, .slider-wrap1 .slider-nav.slick-initialized{display:block;}
.slider-wrap1 .slick-arrow:before{color:gray;}
.slider-wrap1{width:95%;margin:0 auto;}
.slider-wrap1 .slick-slide {   margin: 0px 20px;  }
.slider-wrap1 .slider-for .slick-prev {  left: 50%;
    margin-left: -300px;
    z-index: 1;
    height: 100%;
    background-color: #fff;
    opacity: 0;
    width: 50px;
    text-align: center; }
.slider-wrap1 .slider-for .slick-next {  right: 50%;
    margin-right: -300px;
    z-index: 1;
    height: 100%;
    background-color: #fff;
    opacity: 0;
    width: 50px;
    text-align: center; }
	.slider-wrap1 .slider-nav .slick-prev {  left: -20px;    }
.slider-wrap1 .slider-nav .slick-next {  right: -20px;}
.slider-wrap1 .slick-list {
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
  
  .slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 600px;}
    .slider-wrap1 .slider-for .slick-slide img {
		max-width: 100vw;
		width: 100%;
    }
	.slider-wrap1 .slider-nav .slick-slide img {
      width: 100%;
    }

    .slider-wrap1 .slick-prev:before,
    .slider-wrap1 .slick-next:before {
      color: black;
    }


    .slider-wrap1 .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slider-wrap1 .slick-active {
      opacity: .5;
    }

    .slider-wrap1 .slick-current {
      opacity: 1;
    }
	@media (min-width: 1000px){
	.slider-wrap1 .slider-for .slick-current.slick-active{border: 1px solid #14315C;padding: 1px;}
	.slider-wrap1 .slider-for:hover .slick-prev, .slider-wrap1 .slider-for:hover .slick-next{opacity: 0.7;}
	}
	@media (max-width: 650px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 500px;}
		.slider-wrap1 .slider-for .slick-prev {  left: 0; margin-left: -20px; opacity: 0.5;  }
		.slider-wrap1 .slider-for .slick-next {  right: 0; margin-right: -20px; opacity: 0.5;}
	}
	@media (max-width: 540px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 400px;}
	}
	@media (max-width: 430px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 350px;}
		.slider-wrap1 .slider-nav.slick-initialized {display:none;}
	}
	@media (max-width: 375px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 320px;}
	}
	@media (max-width: 345px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 310px;}
	}
	@media (max-width: 335px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 300px;}
	}
	@media (max-width: 320px){
		.slider-wrap1 .slider-for .slick-slide .block_slide_content{max-width: 280px;}
	}
</style>
 
		</div>
		
	</div>
</section>
<?}?>

<?if(!empty($arResult['PROPERTIES']['TOVAR']['VALUE'])){?>
<section class="block_lend_srav container mb-5 ">
	<div class="row">
		<div class="col-12 text-center mb-5">
			<h4 class="grey">Характеристики</h4>
		</div>
		<div class="col-12">
		<div class="table-responsive">
			<table class="table table-bordered">
			  <thead>
				<tr>
				  <th scope="col" class='first' ><?=$arResult['NAME']?></th>
				  <th scope="col" >Цена</th>
				  <th scope="col" >Наличие</th>
				  <?foreach($arResult['ROW'] as $zn){?>
					<th scope="col" ><?=$zn?></th>
				  <?}?>				  
				</tr>
			  </thead>
			  <tbody>
			  <?foreach($arResult['PROPERTIES']['TOVAR']['INFO'] as $val){?>			  
					<tr>
					  <td class='left text-nowrap'><a href="<?=$val['DETAIL_PAGE_URL']?>"><?=$val['NAME']?></a></td>
					  <td class='center text-nowrap'><?=$val['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></td>
					  <td class='center'><?=($val['CATALOG_AVAILABLE']=='Y' ? '+':'-')?></td>
					  <?foreach($arResult['ROW'] as $code=>$zn){?>
						<td class='center'>
						<?if(is_array($val['PROP'][$code]['VALUE'])){
							echo implode(' / ',$val['PROP'][$code]['VALUE']);
						}else{
							echo $val['PROP'][$code]['VALUE'];
						}?>					  
						</td>
					  <?}?>
					</tr>
			  <?}?>
				
			  </tbody>
			</table>
		</div>
		</div>
	</div>
</section>
<?}?>



<?if(!empty($arResult['PROPERTIES']['VIDEO_YOUTUBE']['VALUE'])){
	$arResult['PROPERTIES']['VIDEO_YOUTUBE']['VALUE']=str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $arResult['PROPERTIES']['VIDEO_YOUTUBE']['VALUE']);
	?>
<section class="block_lend_video container mb-5 ">
	<div class="row">
		<div class="col-12">
			<div class="thumb-wrap">
				<iframe width="560" height="315" src="<?=$arResult['PROPERTIES']['VIDEO_YOUTUBE']['VALUE']?>" frameborder="0" allowfullscreen></iframe>					
			</div>
		</div>
	</div>
</section>
<?}?>

<?/*if(!empty($arResult['PROPERTIES']['TOVAR']['VALUE'])){?>
<section class="block_lend_srav container mb-5 ">
	<div class="row">
		<div class="col-12 text-center mb-5">
			<h4 class="grey">Характеристики</h4>
		</div>
		<div class="col-12">
		<div class="table-responsive2">
			<table class=" table-3">
			  <thead>
				<tr>
				  <th scope="col" class='first' ><?=$arResult['NAME']?></th>
				  <th scope="col" >Цена</th>
				  <th scope="col" >Наличие</th>
				  <?foreach($arResult['ROW'] as $zn){?>
					<th scope="col" ><?=$zn?></th>
				  <?}?>				  
				</tr>
			  </thead>
			  <tbody>
			  <?foreach($arResult['PROPERTIES']['TOVAR']['INFO'] as $val){?>			  
					<tr>
					  <td data-label="" class='left text-nowrap'><?=$val['NAME']?></td>
					  <td data-label="Цена" class='center text-nowrap'><?=$val['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></td>
					  <td data-label="Наличие" class='center'><?=($val['CATALOG_AVAILABLE']=='Y' ? '+':'-')?></td>
					  <?foreach($arResult['ROW'] as $code=>$zn){?>
						<td data-label="<?=$zn?>" class='center'>
						<?if(is_array($val['PROP'][$code]['VALUE'])){
							echo implode(' / ',$val['PROP'][$code]['VALUE']);
						}else{
							echo (!empty($val['PROP'][$code]['VALUE']) ? $val['PROP'][$code]['VALUE'] : '&nbsp;');
						}?>					  
						</td>
					  <?}?>
					</tr>
			  <?}?>
				
			  </tbody>
			</table>
		</div>
		</div>
	</div>
</section>
<?}*/?>

<?if(!empty($arResult['PROPERTIES']['SEO_TEXT_1']['VALUE']['TEXT'])){?>
<section class="block_lend_seo container mb-5 ">
	<div class="row">
		<div class="col-12">			
			<?=$arResult['PROPERTIES']['SEO_TEXT_1']['~VALUE']['TEXT']?>
		</div>
	</div>
</section>
<?}?>


<?include ($_SERVER["DOCUMENT_ROOT"].$templateFolder."/block_tovat_card.php");?>


<?if(!empty($arResult['PROPERTIES']['SEO_TEXT_2']['VALUE']['TEXT'])){?>
<section class="block_lend_seo container mb-5 ">
	<div class="row">
		<div class="col-12">			
			<?=$arResult['PROPERTIES']['SEO_TEXT_2']['~VALUE']['TEXT']?>
		</div>
	</div>
</section>
<?}?>
<?//echo "<pre style='text-align:left;'>";print_r($arResult['PROPERTIES']['SEO_TEXT_1']);echo "</pre>";?>



<?if(!empty($arResult['PROPERTIES']['DOWNLOAD_FILE']['VALUE'])){?>
<section class="block_lend_files container mb-5 ">
	<div class="row">
		<div class="col-12">			
			<div class="fles">
			<?foreach($arResult['PROPERTIES']['DOWNLOAD_FILE']['VALUE'] as $kl=>$val){?>
				<a href="<?=$APPLICATION->GetCurPageParam("download=".$val, array("download","UF_LINK","UF_MODEL"))?>" class="btn_dwnload"><?=(!empty($arResult['PROPERTIES']['DOWNLOAD_FILE']['DESCRIPTION'][$kl]) ? $arResult['PROPERTIES']['DOWNLOAD_FILE']['DESCRIPTION'][$kl] : 'Скачать')?></a>
				
			<?}?>	
			</div>		
		</div>
	</div>
</section>
<?}?>






<?/*

<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):
		if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
		{
			?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
			if (!empty($value) && is_array($value))
			{
				?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
			}
		}
		else
		{
			?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
		}
		?><br />
	<?endforeach;
	foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
</div>
*/?>