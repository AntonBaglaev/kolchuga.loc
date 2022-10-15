<!-- <script type="text/javascript" src="/js/jquery.fancybox-1.3.4.css"></script> -->
<!-- <script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>-->
<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.js"></script> 

<script type="text/javascript">
	$(document).ready(function(){
		$(".fancybox").fancybox({
			'margin'		:	1, 
			'padding'		:	1, 
			'hideOnContentClick'	:	true
		});

	});
	jQuery(function() {

		$.fn.startCarousel = function() {
			var bodywidth = $('.home_block_gallery').width(),
				itemwth = $('.menu_home li').outerWidth(true),		
				mycontwith = bodywidth > itemwth ? bodywidth - bodywidth%itemwth : itemwth,
				licount = $('.menu_home li').size(),
				jscroll = 1;
				
			if(licount > mycontwith/itemwth){
				jscroll =  mycontwith/itemwth;
			} else {
				jscroll = 0;
				mycontwith = licount * itemwth;
			}
			
			$('.home_gallery_content').width(mycontwith);
				
			$('.menu_home').jcarousel({
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
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="ghome"> 
<div class="home_block_gallery"> 
	<div class="home_gallery_content">
		<ul class="menu_home">	
		<?foreach($arResult["ROWS"] as $arItems):?>
				<?foreach($arItems as $arItem):?>
						<!-- <?echo"<pre>"; print_r($arItem); echo"</pre>";?>	 -->		
						<?if(is_array($arItem)):?>
							<li>
								<div>
									<?
									$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
									$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));
									?>

									<!-- <img src="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" alt="" /> -->
									
									
									<?if ($arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]):?>
										<?
											/*echo"<pre>";
											print_r($arItem["DISPLAY_PROPERTIES"]);
											echo"</pre>";*/
											$imgb =thumbnail($arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]['ID'], 370, 185, false, TRUE);
										?>
										<a href="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" class="fancybox">
											<!-- <img src="<?=$arItem["DISPLAY_PROPERTIES"]["REAL_PICTURE"]["FILE_VALUE"]["SRC"]?>" class="bdr" id="<?=$this->GetEditAreaId($arItem['ID']);?>"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" style="width:370px" /> -->
											
											<img src="<?=$imgb?>" class="bdr" alt="" />
										</a>
									<?else:?>	
										<?if(is_array($arItem["PICTURE"])):?>
											<a href="<?=$arItem["DISPLAY_PROPERTIES"]["email"]["VALUE"]?>" target="_blank">
												<img src="<?=$arItem["PICTURE"]["SRC"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="bdr" style="width:370px"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
											</a>
										<?endif?>
									<?endif?>
									<span>
										<?=$arItem["NAME"]?>
									</span>
								</div>
							</li>
						<?endif;?>
					
				<?endforeach?>
		<?endforeach?>
		</ul>
	</div>
</div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>