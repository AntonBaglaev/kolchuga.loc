<?php
$storeList=\Kolchuga\StoreList::getListSalonProp();
?>

<section id="location">
	<div class="location-block">
		<div class="location-block__title">Оружейные салоны «Кольчуга»</div>
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
					<div class="link_bottom_info dflex">
						<a href="https://yandex.ru/maps/?rtext=~<?=$val['PROPERTY_DOP_YANDEX_VALUE']?>" target="_blank"><img src="/images/main-icon/gps.png"  alt="<?=$val['PROPERTY_DOP_NAME_VALUE']?> Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:<?=$val['PROPERTY_E_MAIL_VALUE']?>"><img src="/images/main-icon/post.png"  alt="<?=$val['PROPERTY_DOP_NAME_VALUE']?> Отправить E-mail"><span>Отправить E-mail</span></a>
					</div>
				</div>
			</div>
		<?}?>
		</div>
	</div>
</section>





















<?/*
<section id="location">
	<div class="location-block">
		<div class="location-block__title">Оружейные салоны «Кольчуга»</div>
		<div class="location-block__place dflex">
		
			<div class="place">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location.png" alt="ул. Варварка">
					<a href="/weapons_salons/varvarka/">ул. Варварка, 3<br /> “Гостиный двор”</a>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>ОРУЖЕЙНЫЙ САЛОН</p>
							<?if(!empty($storeList['STORE_LIST_ALL']['112']['PROPERTY_PHONES_VALUE'])){?>
								<a href="tel:<?=intval($storeList['STORE_LIST_ALL']['112']['E164_PHONE'])?>"><?=$storeList['STORE_LIST_ALL']['112']['PROPERTY_PHONES_VALUE']?></a>
							<?}else{?>
								<a href="tel:+74952343443">+7 (495) 234-34-43</a>
							<?}?>
						</div>
						<div class="place__info-bottom">
							Пн-сб: 10:00-20:00; Вс: 10:00-17:00
						</div>
					</div>
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>СЕРВИСНЫЙ ЦЕНТР</p>
							<?if(!empty($storeList['STORE_LIST_ALL']['112']['PROPERTY_PHONES_SERVICE_VALUE'])){?>
								<a href="tel:<?=intval($storeList['STORE_LIST_ALL']['112']['E164_PHONE_SERVICE'])?>"><?=$storeList['STORE_LIST_ALL']['112']['PROPERTY_PHONES_SERVICE_VALUE']?></a>
							<?}else{?>
								<a href="tel:+74959252641">+7 (495) 925-26-41 доб. 335</a>
							<?}?>
						</div>
						<div class="place__info-bottom">
						<?if(!empty($storeList['STORE_LIST_ALL']['112']['PROPERTY_MASTERSKAYA_VALUE'])){?>
							Пн-пт: 10:00-19:00; Сб: 10:00-17:00; Вс: выходной
						</div>
					</div>
					<div class="link_bottom_info dflex">
						<a href="https://yandex.ru/maps/?rtext=~55.752703,37.626214" target="_blank"><img src="/images/main-icon/gps.png"  alt="ул. Варварка Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:varvarka@kolchuga.ru"><img src="/images/main-icon/post.png"  alt="ул. Варварка Отправить E-mail"><span>Отправить E-mail</span></a>
					</div>
				</div>
			</div>
			<div class="place">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location.png" alt="Ленинский проспект">
					<a href="/weapons_salons/leninsky-prospekt/">Ленинский<br /> проспект, 44</a>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>ОРУЖЕЙНЫЙ САЛОН</p>
							<a href="tel:+74956512500">+7 (495) 651-25-00</a>
						</div>
						<div class="place__info-bottom">
							Пн-сб: 10:00-20:00; Вс: 10:00-17:00
						</div>
					</div>
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>СЕРВИСНЫЙ ЦЕНТР</p>
							<a href="tel:+74959252641">+7 (495) 925-26-41 доб. 513</a>
						</div>
						<div class="place__info-bottom">
							Пн-пт: 10:00-19:00; Сб: 10:00-17:00; Вс: выходной
						</div>
					</div>
					<div class="link_bottom_info dflex">
						<a href="https://yandex.ru/maps/?rtext=~55.701318,37.567150" target="_blank"><img src="/images/main-icon/gps.png" alt="Ленинский проспект Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:leninskiy@kolchuga.ru"><img src="/images/main-icon/post.png" alt="Ленинский проспект Отправить E-mail"><span>Отправить E-mail</span></a>
					</div>
				</div>
			</div>
			<div class="place">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location.png" alt="Волоколамское шоссе">
					<a href="/weapons_salons/volokolamskoe-shosse/">Волоколамское<br> шоссе, 86 </a>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>ОРУЖЕЙНЫЙ САЛОН</p>
							<a href="tel:+74954901420">+7 (495) 490-14-20</a>
						</div>
						<div class="place__info-bottom">
							Пн-сб: 10:00-20:00; Вс: 10:00-17:00
						</div>
					</div>
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>СЕРВИСНЫЙ ЦЕНТР</p>
							<a href="tel:+74959252641">+7 (495) 925-26-41 доб. 284</a>
						</div>
						<div class="place__info-bottom">
							Пн-пт: 10:00-19:00; Сб: 10:00-17:00; Вс: выходной
						</div>
					</div>
					<div class="link_bottom_info dflex">
						<a href="https://yandex.ru/maps/?rtext=~55.822175,37.444844" target="_blank"><img src="/images/main-icon/gps.png"  alt="Волоколамское шоссе Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:volokolamka@kolchuga.ru"><img src="/images/main-icon/post.png" alt="Волоколамское шоссе Отправить E-mail"><span>Отправить E-mail</span></a>
					</div>
				</div>
			</div>
			<div class="place">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location.png" alt="г. Люберцы">
					<a href="/weapons_salons/lyubertsy/">г. Люберцы<br> ул. Котельническая, 24А </a>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>ОРУЖЕЙНЫЙ САЛОН</p>
							<a href="tel:+74955541587"> +7 (495) 554-22-40</a>
						</div>
						<div class="place__info-bottom">
							Пн-сб: 10:00-20:00; Вс: 10:00-17:00
						</div>
					</div>
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>СЕРВИСНЫЙ ЦЕНТР</p>
							<a href="tel:+74959252641">+7 (495) 925-26-41 доб. 207</a>
						</div>
						<div class="place__info-bottom">
							Пн-пт: 10:00-19:00; Сб: 10:00-17:00; Вс: выходной
						</div>
					</div>
					<div class="link_bottom_info dflex">
						<a href="https://yandex.ru/maps/?rtext=~55.668569,37.888944" target="_blank"><img src="/images/main-icon/gps.png" alt="г. Люберцы Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:lubertsy@kolchuga.ru"><img src="/images/main-icon/post.png" alt="г. Люберцы Отправить E-mail"><span>Отправить E-mail</span></a>
					</div>
				</div>
			</div>
			
		
			<?/*<div class="place place_no">
				<div class="place-block">
					<img class="l-hide" src="/images/main-icon/location_on_black.png">
					<a href="javascript:void(0);">ТК “БАРВИХА<br>LUXURY VILLAGE”</a>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div style="font-family: PT Sans;font-size: 10px;line-height: 13px;text-align: center;color: #EA5B35;">СКОРО ОТКРЫТИЕ!</div>
					</div>
					<div class="link_bottom_info dflex">
						<div class="main__btn" style="width:100%;text-align:center;"><a href="javascript:void(0);" style="text-transform: none;width: 160px;margin: 0 auto; display: block;">Подробнее</a></div>
					</div>
				</div>
			</div>*//*?>
			<div class="place our_open">
				<div class="place-block">
					<img class="l-hide " src="/images/main-icon/location.png" alt="п. Барвиха">
					<a href="/news/open_barvikha/" class="spopen">ТК “БАРВИХА<br>LUXURY VILLAGE”</a>
					<span style="color:#ff0000;">Мы открылись!</span>
				</div>
				<div class="hide__block">	
					<div class="place__info">
						<div class="place__info-top dflex">
							<p>ОРУЖЕЙНЫЙ САЛОН</p>
							<a href="tel:+74952252990">+7 (495) 225-29-90</a>
						</div>
						<div class="place__info-bottom ">
							Пн-чт: 10:00-22:00; Пт-вс: 10:00-23:00
						</div>
					</div>
					
					<div class="link_bottom_info dflex">	
						<a href="https://yandex.ru/maps/?rtext=~55.73833374657,37.263638891541&rtt=auto&z=10" target="_blank"><img src="/images/main-icon/gps.png" alt="п. Барвиха Построить маршрут"><span>Построить маршрут</span></a>
						<a href="mailto:barvikha@kolchuga.ru"><img src="/images/main-icon/post.png" alt="п. Барвиха Отправить E-mail"><span>Отправить E-mail</span></a>
					</div> 
					<div class="place__info"><br></div>
				</div>
			</div>
		
		</div>
	</div>
</section>
*/?>