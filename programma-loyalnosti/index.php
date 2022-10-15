<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("keywords", "Программы лояльности");
$APPLICATION->SetPageProperty("description", "Программы лояльности");
$APPLICATION->SetPageProperty("title", "Программы лояльности");

?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Дисконтные карты «Кольчуга»</h1>
 <br>
			<div class="osnanons">
				<p>
					 Для держателей карт лояльности оружейных салонов «Кольчуга» доступна дисконтная система, которая предоставляет возможность постоянным клиентам салонов и интернет-магазина получать скидки в размере 3%, 5%, или 10% на покупки всего ассортимента товаров.
				</p>
				<p>
					 Дисконтная карта выдается покупателю при совершении разовой покупки в салонах «Кольчуга» и имеет накопительную систему скидок.
				</p>
				<ul>
					<li>При покупке на сумму от 30 000 руб. предоставляется дисконтная карта на скидку 3%</li>
					<li>При покупке на сумму от 400 000 руб. предоставляется дисконтная карта на скидку 5%</li>
					<li>При покупке на сумму от 1 000 000 руб. предоставляется дисконтная карта на скидку 10%</li>
				</ul>
 <a target="_blank" href="/programma-loyalnosti/discount-program/" class="btn-blue">Дисконтные карты</a>
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
		</div>
		<div class="col-md-1 d-none d-md-block">
		</div>
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
<div class="container-fluid next_service pb-5">
	<div class="row">
		<div class="col-md-6 service_item mb-5">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/programma-loyalnosti/skidka-v-den-rozhdeniya/"> <img src="/upload/medialibrary/c20/c2033d6aeb41ecf991cfc0ef95ca14b1.jpg" class="preview_picture " border="0"> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/programma-loyalnosti/skidka-v-den-rozhdeniya/">Скидка 5% в День рождения</a><br>
 </h3>
										<div class="minanons">
											 Мы дарим всем клиентам скидку 5% на огнестрельное гладкоствольное и нарезное оружие
										</div>
 <br>
 <a target="_blank" href="/programma-loyalnosti/skidka-v-den-rozhdeniya/" class="btn-blue mx-0">Подробнее</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 service_item mb-5">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/programma-loyalnosti/gift_certificate/"> <img alt="sert_grey1.jpg" src="/upload/medialibrary/51f/51f73c4609ddb4ab156e9272b3015451.jpg" border="0" title="sert_grey1.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/programma-loyalnosti/gift_certificate/">Подарочные сертификаты</a><br>
 </h3>
										<div class="minanons">
											 Подарочный сертификат на оружие и товары для охоты<br>
 <br>
 <br>
										</div>
 <br>
 <a target="_blank" href="/programma-loyalnosti/gift_certificate/" class="btn-blue mx-0">Подробнее</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 service_item mb-5">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/elektronnye-podarochnye-sertifikaty/"> <img alt="a58480910609d5313c71890ff49cb9b8.jpg" src="/upload/medialibrary/e1a/e1add67061668e788cb9232e2b897b98.jpg" border="0" title="a58480910609d5313c71890ff49cb9b8.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/elektronnye-podarochnye-sertifikaty/">Электронный подарочный сертификат</a><br>
										</h3>
										<div class="minanons">
											 Отправим моментально по всей России!<br>
 <br>
 <br>
										</div>
 <br>
 <a target="_blank" href="/elektronnye-podarochnye-sertifikaty/" class="btn-blue mx-0">Подробнее</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>