<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Промокод");

$APPLICATION->SetAdditionalCss("/2022/promocode/styles.css");

$APPLICATION->AddChainItem("Промокод", "/2022/promocode/");
?>


    <div class="row promocode-page">
        <div class="col-12">
            <div class="h-100 promocode-page-image">
                <img src="/2022/promocode/banner.jpg">
            </div>
        </div>

        <div class="col-12">
            <div class="h-100 promocode-page-text">
                <p> Скидка по промокоду распространяется на весь ассортимент товаров в оружейных салонах и интернет-магазине «Кольчуга» стоимостью до  1 100 000 руб., а также на услуги сервисных центров «Кольчуга».</p>
                <p> Скидка по промокоду не распространяется  на акционные товары, не суммируется со скидкой в День рождения и скидками по картам лояльности.</p>
                <p> Срок действия промокода — 1 месяц. Срок действия после активации — 1 день.</p>
            </div>
        </div>
    </div>


<? /*







<div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Промокод</h1>
			<div class="osnanons">
				<p>
					 Оружейный дом John Rigby носит имя своего основателя, открывшего оружейное дело в столице Ирландии, Дублине, в 1775 году.&nbsp;
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="september_rigby.jpg" src="/upload/medialibrary/725/725240ec630c3c1f12b488f05fa570f8.jpg" title="september_rigby.jpg">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<p>
				 Их сохранившихся архивных материалов и «журналов заказов» мы узнаем, что компания была с самого начала ориентирована на создание высококачественного продукта. Кроме технического совершенства оружие John Rigby отличалось и богатством оформления, для которого привлекались лучшие граверы мира. На протяжении своей истории компания пять раз получала почетный статус поставщика королевского двора.
			</p>
			<p>
				 Первый успех пришел к ирландским оружейникам во время Всемирной выставки 1851 года в Лондоне, а затем – в Париже в 1855 году. На обеих выставках оружие Rigby завоевало награды за высокое качество изготовления и совершенство конструкции, что стало началом всемирного признания компании.
			</p>
			<p>
				 Позже наследники Джона Ригби заключили со знаменитым немецким оружейным домом 12 -летний эксклюзивный дистрибьюторский контракт на производство и распространение всех винтовок Mauser в Соединенном Королевстве и британских колониях.
			</p>
			<p>
				 Отдельного упоминания заслуживают достижения компании в производстве патронов. Здесь были созданы два патрона, не только получившие всемирную известность, но и поныне, (спустя более 100 лет!) остающиеся в арсенале охотников на крупную и опасную дичь, – .450 Nitro Express и .416 Rigby.&nbsp;
			</p>
		</div>
		<div class="col-md-1 d-none d-md-block">
		</div>
		<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
			 <?$APPLICATION->IncludeFile("/2021/recomend.php"); //рекомендуем?>
		</div>
	</div>
</div>
<div class="container-fluid next_service pb-5">
	<div class="row">
		 <!-- start -->
		<div class="col-md-6 service_item">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/2021/august/"> <img alt="august_just_339.jpg" src="/upload/medialibrary/dce/dce704ce06231484b09bef88d776b323.jpg" border="0" title="august_just_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/august/">Август</a><br>
 </h3>
										<div class="minanons">
											 Josef Just
										</div>
 <br>
 <a target="_blank" href="/2021/august/" class="btn-blue mx-0">Подробнее</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <!-- end --> <!-- start -->
		<div class="col-md-6 service_item">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/2021/july/"> <img alt="october_benelli_magnifico_339.jpg" src="/upload/medialibrary/bb0/bb00284f709584d6cc29392978e2b1d8.jpg" border="0" title="october_benelli_magnifico_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/july/">Октябрь</a><br>
 </h3>
										<div class="minanons">
											 Benelli Magnifico
										</div>
 <br>
 <a target="_blank" href="/2021/july/" class="btn-blue mx-0">Подробнее</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <!-- end -->
	</div>
</div>
*/ ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>