<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript">
	jQuery(function() {

		$.fn.startCarousel = function() {
			var bodywidth = $('.img_block_gallery').width(),
				itemwidth = $('.menu_img li').outerWidth(true),		
				mycontwidth = bodywidth > itemwidth ? bodywidth - bodywidth%itemwidth : itemwidth,
				licount = $('.menu_img li').size(),
				jscroll = 1;
				
			if(licount > mycontwidth/itemwidth){
				jscroll =  mycontwidth/itemwidth;
			} else {
				jscroll = 0;
				mycontwidth = licount * itemwidth;
			}
			
			$('.block_gallery_content').width(mycontwidth);
				
			$('.menu_img').jcarousel({
				scroll:jscroll,
				wrap:'circular'
			});
		};
		
		$(this).startCarousel();
		
		$(window).resize(function(){
			$(this).startCarousel();
		}); 
	});
</script>

<?if (!empty($arResult)):?>
<div class="img_block_gallery"> 
	<div class="block_gallery_content">
		<ul class="menu_img">
			<?
			$previousLevel = 0;
			$len = count($arResult);
			foreach($arResult as $index =>$arItem):
			?>
				<?if ($arItem['DEPTH_LEVEL'] == 1):?>
					<?if ($arItem["PERMISSION"] > "D"):?>
							<li class="<?if ($index == 0):?>first_li<?endif?> <?if ($index == $len - 1):?>last_li<?endif?>">
								<a href="<?=$arItem["LINK"]?>" target="_blank" <?if($arItem["SELECTED"]):?>class="activ"<?endif?>>
									<img src="<?=$arItem[PARAMS][logo_min]?>" alt="<?=$arItem["TEXT"]?>" title="<?=$arItem["TEXT"]?>" />
								</a>
							</li>
					<?endif?>
				<?endif?>		
			<?endforeach?>
		</ul>
	</div>
</div>


<?endif?>