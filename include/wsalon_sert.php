<?php
$storeList=\Kolchuga\StoreList::getListSalonProp();
//\Kolchuga\Settings::xmp($storeList,11460, __FILE__.": ".__LINE__);

?>
<section id="location">
		<div class="location-block__title">Воспользуйтесь электронным сертификатом в любом оружейном салоне «Кольчуга»</div>
	<div class="location-block">
		<div class="location-block__place dflex">
		<?foreach($storeList['STORE_LIST_ALL'] as $idsalon=>$val){?>
			<?if(in_array($idsalon,[631125, 705387])){continue;}?>
			<div class="place place-hover">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location.png" alt="<?=$val['PROPERTY_DOP_NAME_VALUE']?>">
					<a href="/weapons_salons/<?=$val['CODE']?>/"><?=$val['PROPERTY_DOP_NAME_VALUE']?></a>
				</div>
				<div class="hide__block">
					<?if(!empty($val['PROPERTY_PHONES_VALUE'])){?>				
						<div class="place__info place__info_salon">
							<div class="place__info-top dflex">
								<p>ОРУЖЕЙНЫЙ САЛОН</p>
								<a href="tel:<?=intval($val['E164_PHONE'])?>"><?=$val['PROPERTY_PHONES_VALUE']?></a>							
							</div>
							<div class="place__info-bottom">
								<?=$val['PROPERTY_CLOCK_VALUE']?>
							</div>
						</div>
					<?}?>
					<?if(!empty($val['PROPERTY_PHONES_SERVICE_VALUE'])){?>
						<div class="place__info place__info_service">
							<div class="place__info-top dflex">
								<p>СЕРВИСНЫЙ ЦЕНТР</p>
								<a href="tel:<?=intval($val['E164_PHONE_SERVICE'])?>"><?=$val['PROPERTY_PHONES_SERVICE_VALUE']?></a>								
							</div>
							<div class="place__info-bottom">
								<?=$val['PROPERTY_MASTERSKAYA_VALUE']?>								
							</div>
						</div>
					<?}?>
					
				</div>
			</div>
		<?}?>
		</div>
	</div>
</section>
<style>
.location-block__title {
    font-size: 28px;
    text-align:center;
}
.location-block {    
    padding: 20px 0 20px;  
display: block;	
}
.place-block > a, .place__info-top a,.hide__block, .link_bottom_info a {    
   
}
.place:hover .hide__block, .place-hover .hide__block{
	min-height: 160px;
}
.hide__block {
    bottom: -10px;
}
@media (max-width: 1250px){
	.location-block__place {    justify-content: center;}
}
@media (max-width: 500px){
	.location-block__title {  width: 100%;}
}
</style>