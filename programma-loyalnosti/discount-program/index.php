<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("tags", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords_inner", "Нарезное оружие, гладкоствольное оружие, ножи, оптика, бинокли, прицелы, пневматика, пневматическое оружие, травматическое оружие, электрошокеры, одежда для охоты, патроны, сувениры, сейфы, аксессуары для охоты, Anschutz, Armi Sport, Armsan, Benelli, Beretta, Blaser, Browning, Ceska Zbroovka, Companion, Cosmi, Fabarm, Fausti, Franchi, Krieghoff, Lanber, Mannlicher, Mauser, Merkel, Pedersoli, Remington, Sako, Sauer, SDI Waffen, SHR, Stoeger, Tikka, Walther, Winchester, Zoli");
$APPLICATION->SetPageProperty("keywords", "дисконтная карта, скидки на оружие");
$APPLICATION->SetPageProperty("description", "Дисконтная карта \"Кольчуга\"");
$APPLICATION->SetPageProperty("title", "Дисконтная программа");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Дисконтная программа</h1>
 <br>
			<div class="osnanons">
				<p>
					 Правила получения и использования дисконтных карт.
				</p>
				<p>
					 Предлагаем Вашему вниманию дисконтную систему компании «Кольчуга». Компания выпускает карты, дающие право на получение скидок в размере 3%, 5%, и 10%. Дисконтная карта выдается покупателю при совершении разовой покупки в салоне «Кольчуга» на сумму:
				</p>
				<ul>
					<li style="text-align: left;">30 000 рублей - карту номиналом 3%&nbsp;</li>
					<li style="text-align: left;">400 000 рублей - карту номиналом 5%</li>
					<li style="text-align: left;">1 000 000 рублей - карту номиналом 10%</li>
				</ul>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img width="100%" src="/upload/medialibrary/d3f/d3fe2ad3d787c2e676a8af7591b75f75.jpg" class="preview_picture " border="0">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<div>
				<div style="text-align: left;">
					 Основанием для выдачи дисконтной карты является кассовый чек и заполненная владельцем анкета. Карты именные, на них действует накопительный механизм перерасчета скидки. Сумма всех покупок, за исключением первой, заносится на персональный счет покупателя, увеличивая размер скидки до максимальных 10%. Дисконтная карта является собственностью АО «Фирма «Кольчуга», не подлежит передаче или продаже другому лицу и должна быть возвращена по требованию администрации.&nbsp;Утерянная именная дисконтная карта восстанавливается в течение 2 (двух) рабочих дней.
				</div>
				<div style="text-align: left;">
 <br>
				</div>
				<div style="text-align: left;">
					 Компания «Кольчуга» оставляет за собой право вносить изменения в правила работы дисконтной системы с последующим уведомлением клиента. <b>Карта не действует при покупке товаров по специальным ценам, а также в период сезонных распродаж, но сумма этих покупок зачисляется на карту.</b> Дисконтная карта позволяет постоянным покупателям оружейных салонов «Кольчуга» получать скидки также и при приобретении товаров и услуг во всех подразделениях группы компаний «Кольчуга».&nbsp;
				</div>
				<div style="text-align: left;">
 <br>
				</div>
			</div>
			<div style="text-align: left;">
 <b>Уведомляем Вас, что при покупке оружия стоимостью свыше 1 100 000 рублей действует плавающая система скидок.</b> <br>
 <br>
				<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
					 <?if(!empty($arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'])){?>
					<div class="next_recomend ">
						<div class="recomend_title">
							 <?=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME']?>
						</div>
						<div class="recomend_list">
							<ul>
								 <?foreach($arResult['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'] as $idR=>$vlR){?>
								<li><a href="<?=$vlR['DETAIL_PAGE_URL']?>"><?=$vlR['NAME']?> &gt;&gt;</a><br>
								 <?=$arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$idR]['DATA_FORMAT']?> </li>
								 <?}?>
							</ul>
 <a target="_blank" href="/news/" class="btn-blue">Все новости</a>
						</div>
					</div>
					 <?}?>
				</div>
			</div>
		</div>
 <br>
	</div>
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>