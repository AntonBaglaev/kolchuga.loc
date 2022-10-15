<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("keywords", "Скидка в день рождения");
$APPLICATION->SetPageProperty("description", "Скидка в день рождения");

$APPLICATION->SetPageProperty("title", "Скидка в день рождения");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Скидка в день рождения</h1>
 <br>
			<div class="osnanons">
				<p>
					 Уважаемые покупатели!
				</p>
				<p>
					 Во всех оружейных салонах «Кольчуга» действует программа лояльности клиента – покупатель может получить скидку 5% на огнестрельное гладкоствольное или нарезное оружие и огнестрельное оружие ограниченного поражения при совершении покупки в День своего рождения. Для держателей дисконтных карт скидка суммируется.
				</p>
				<p>
					 Основанием для предоставления скидки является документ, удостоверяющий личность. Скидка не распространяется на оружие, стоимостью свыше 1 100 000 рублей, уцененные и участвующие в акциях товары.
				</p>
				<p>
					 Воспользоваться акцией для именинника можно единоразово в течение недели до, в День Рождения и в течение недели после даты рождения.
				</p>
 <br>
 <br>
				 <style>
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
}
</style>
				<div align="center" class="knopka">
 <a href="/internet_shop/" style="color: #ffffff">Перейти в каталог</a>
				</div>
 <br>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img width="100%" src="/upload/medialibrary/c20/c2033d6aeb41ecf991cfc0ef95ca14b1.jpg" class="preview_picture " border="0">
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
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>