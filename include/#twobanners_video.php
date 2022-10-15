
<section id="banners">
	<div class="banners dflex">
		<div class="banners__item banner">
			<div class="b-video"><a href="https://www.youtube.com/watch?v=Xa4UiHIc4Oo" target="_blank">
				<video class="viedeo__file" src="/upload/video/barviha.mov" loop="loop" muted="muted" autoplay="autoplay" preload="auto" playsinline="" style="width: 100%;"></video>
			</a></div>			
		</div>
		<?	
		$arFile = \Kolchuga\Pict::getWebpImgSrc( "/images/b3bdb56b6e4309.jpg" , $intQuality = 90);	
		?>
		<div class="banners__item banner">
			<a href="/brands/gampr/?sfilter=17858">
				
				<picture>
					<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
						<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
					<?endif;?>
					<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" alt="<?=$val["NAME"]?>" />
				</picture>
				
			</a>
			<div class="banner__info">
				<div class="banner__title">GAMPR - новое слово в оружейном мире</div>
				<div class="banner__btn main__btn"><a href="/brands/gampr/?sfilter=17858">Зарезервировать</a></div>
			</div>
		</div>
	
	
	
	
	
	</div>
</section>
<style>
/* #banners video{height:339px;}*/

 .b-video {
      width: 100%;
      min-height: 200px;
      height: 339px;
      position: relative;
      overflow: hidden;
      z-index: 1;
}
.viedeo__file{
    position: relative;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
@media (max-width: 767px){
	#banners video{height:auto;object-fit: contain;position: relative;}
	.b-video{height: auto;}
	#banners .banners__item {min-height: auto;}
} 
</style>