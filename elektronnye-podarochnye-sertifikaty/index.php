<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Электронные подарочные карты");
$APPLICATION->SetPageProperty("title", "Электронные подарочные сертификаты");
?>


<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		
		<div style="width: 100%;display: flex;padding: 10px;align-items: center;justify-content: space-between;background: #fff url(ba0f.png) center center repeat;">		
			<div class="" style="padding-right:15px; width:40%"><div style=" font-size: calc( (100vw - 320px)/(1920 - 320) * (38 - 14) + 14px);color:#002D63;">Электронные подарочные сертификаты</div></div>
			<div class=""><img src="ba1_1.png"></div>		
		</div>
	</div>
</div>



<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Оружейные салоны «Кольчуга» предоставляют новый моментальный сервис для покупки электронных подарочных сертификатов. Позвольте вашим близким людям, друзьям или коллегам самостоятельно выбрать желанный подарок из широкого ассортимента оружейных салонов «Кольчуга». Подарить выбор легко: выберите дизайн сертификата, определитесь с суммой, произведите оплату и в течение 30 секунд ваш подарок будет доставлен адресату.
				
			</div>
		
	</div>
</div>

<div class="row" style="justify-content: center;">
	<div class="col-12 cert usl ">		
        <div class="content-text">
			
			<div class="inblock2">
				<div class="blockkarta" style=" max-width: 300px;border: 1px solid #eee;border-radius: 5px;"><a href="javascript:void(0);" class="js_iframe_widget open_dgift" style=""><img class="cert pb40 pr20" src="cart_4.jpg" alt="Электронные подарочные карты Кольчуга"></a><div class="text-center" style="position: absolute;bottom: 10%;width:100%;"><a class="js_iframe_widget" href="javascript:void(0);" style=" text-decoration: underline; font-size: 20px; color: #fff;">Купить сертификат</a></div></div>
				
				<div class="blockkarta" style=" max-width: 300px;border: 1px solid #eee;border-radius: 5px;"><a href="javascript:void(0);" class="js_balance_widget open_dgift" style=""><img class="cert pb40 pr20" src="cart_6.jpg" alt="Электронные подарочные карты Кольчуга"></a><div class="text-center" style="position: absolute;bottom: 10%;width:100%;"><a class="js_balance_widget" href="javascript:void(0);" style=" text-decoration: underline; font-size: 20px; color: #002D63;">Проверить баланс</a></div></div>
			</div>
		</div>
	</div>
</div>
<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Приобрести электронный сертификат легко:				
			</div>
		
	</div>
</div>
<div class="row mb-5" style=" align-items: center;">	
		<div class="col-12 col-md-4 pt-20 inblock" style="border-right: 1px solid #eee;">	
			<div ><div class="text-center" style="">Шаг 1</div>
			<div class="" style="">
				<div class="gifts-card__icon">
					<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
				</div>
				<div class="gifts-card__descr content-text">
					Выберите номинал и дизайн <br>подарочной карты
				</div>
			</div></div>
		</div>
		<div class="col-12 col-md-4 pt-20 inblock" style="border-right: 1px solid #eee;">
			<div class=""><div class="text-center" style="">Шаг 2</div>
			<div class="" style="">
				<div class="gifts-card__icon">
					<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
				</div>
				<div class="gifts-card__descr content-text">
					Дождитесь уведомления <br>и совершите оплату
				</div>
			</div></div>
		</div>
		<div class="col-12 col-md-4 pt-20 inblock">
			<div class=""><div class="text-center" style="">Шаг 3</div>
			<div class="" style="">
				<div class="gifts-card__icon">
					<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
				</div>
				<div class="gifts-card__descr content-text">
					Ваш подарок <br>уже направлен адресату<br>
				</div>
			</div></div>
		</div>
</div>

<div class="mb-3" style=" align-items: center;">
<div class="col-12" >	
	<br>
</div>
</div>

<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert" >	
		<?$APPLICATION->IncludeFile('/include/wsalon_sert.php', array(), array())?>
	</div>
</div>
	

<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Преимущества покупки электронного сертификата
				
			</div>
		
	</div>
</div>


<div class="row">
	<div class="col-12 col-md-4 cert pt-20 text-center">
		
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<img src="ems2.png" width="100px">
			</div>
			<div class="gifts-card__descr content-text">
				Моментальная доставка в SMS и Email
				
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<img src="atw.png" width="100px">
			</div>
			<div class="gifts-card__descr content-text">
				Покупка в любой точке мира
				
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<img src="gift2.png" width="100px">
			</div>
			<div class="gifts-card__descr content-text">
				Универсальный подарок
				
			</div>
		</div>
	</div>
</div>


<div class="mb-3" style=" align-items: center;">
<div class="col-12" >	
	<div class="blockkarta_end" style=" max-width: 300px; padding: 17px;  border: 1px solid #eee;  box-shadow: 5px 5px 5px -5px rgba(34, 60, 80, 0.6);border: 1px solid #20426a;background-color: #002D63;text-align:center;margin:3em auto 1em;"><a href="javascript:void(0);" class="js_iframe_widget open_dgift" style="color:#fff">Купить сертификат</a></div>
</div>
</div>

<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Правила использования электронных подарочных карт
				
			</div>
		
	</div>
</div>

<div class="row" >
<div class="col-12" >	
	<div class="pravila">
		<ol class="content-text text-left">
		  <li>Электронная подарочная карта (ЭПК) будет активна сразу после покупки.<br>
		  </li>
		  <li>Для использования ЭПК получите пин-код, для этого укажите свой номер телефона в поле на карте и нажмите "Получить PIN". В розничном магазине при оплате покупки предъявите ЭПК на кассе и сообщите пин-код.<br>
		  </li>
		  <li>Использовать подарочную карту можно <b>только в магазинах </b> по следующим адресам: <br>
			<br>
			г. Люберцы, Котельническая улица, д. 24А. Контакты: +7 (495) 554-22-40, lubertsy@kolchuga.ru.<br>
			г. Москва, Ленинский проспект, д. 44. Контакты:  +7 (495) 651-25-00, leninskiy@kolchuga.ru.<br>
			Городской округ Одинцовский, д.Барвиха 114, стр 2. Контакты: +7 (495) 225-29-90, barvikha@kolchuga.ru.<br>
			г. Москва, Волоколамское шоссе, д. 86. Контакты: +7 (495) 490-14-20, volokolamka@kolchuga.ru.<br>
			г. Москва, ул.Варварка д.3. Контакты: +7 (495) 234-34-43, varvarka@kolchuga.ru.<br>
			<br>
		  </li>
		  <li>Срок действия карты составляет 3 года.<br>
		  </li>
		  <li>Адреса магазинов, можно уточнить на сайте <b><a target="_blank" class="link" href="/weapons_salons/">kolchuga.ru</a></b>.<br>
		  </li>
		  <li>Карта может быть использована однократно.<br>
		  </li>
		  <li>Карту можно суммировать с другими подарочными картами.<br>
		  </li>
		  <li>После покупки электронный подарочный  сертификат не подлежит возврату в  оружейных салонах «Кольчуга».<br>
		  </li>
		  <li><b>Дополнения</b>: <br>
			<br>
			<b>А.</b> Проверить баланс подарочной карты можно по <b><a href="javascript:void(0);" class="js_balance_widget open_dgift">ссылке</a></b><br>
			<b>Б.</b> Правила приобретения и использования Подарочных карт могут быть изменены в любой момент, без предварительного уведомления. Держатель Карты самостоятельно отслеживает изменения правил на сайте <b><a target="_blank" class="link" href="/">kolchuga.ru</a></b>.<br>
			<b>В.</b> Приобретая Подарочную карту, держатель (предъявитель Карты) соглашается со всеми правилами приобретения и использования Подарочной карты, обязуется передать эти правила третьему лицу, которому дарится карта.<br>
			<b>Г.</b> Подарочную карту можно использовать совместно с бонусными картами магазина.<br>
			<b>Д.</b> Подарочной картой можно оплачивать все товары предоставленные в магазине.<br>
		  </li>
		</ol>

	</div>
</div>
</div>




<style>
.content-text{text-align:center;}
.blockkarta{
	position: relative;
    overflow: hidden;
}
.blockkarta:after{
	display: block;
    content: '';
    padding-bottom: 100%;
    position: relative;
}
/* .blockkarta:hover:after{
	visibility: visible;
    opacity: 0.8;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
} */
.blockkarta:after {
    overflow: hidden;
    position: absolute;
    top: 0;
    content: "";
    z-index: 100;
    width: 100%;
    height: 100%;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
    pointer-events: none;
    -webkit-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    background-color: rgba(0, 0, 0, 0.3);
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    z-index: 1;
    border-radius: 8px;
}


.pt-20{padding-top:20px;}
.pt-40{padding-top:40px;}
.pb-20{padding-bottom:20px;}
.inblock {justify-content: center;    display: flex;}
.inblock2 {justify-content: space-around;    display: flex;}
@media (max-width: 600px){
	.inblock, .inblock2 {display: block;}
	.inblock2 .blockkarta{margin: 0 auto 1em;}
}
.open_dgift_balance{
	background-color: #eee;
}
.cert .section_title span{
	border-radius: 50%;
    border: 2px solid #5C5C5C;
    line-height: 30px;
}
.cert .usl{}

.accordion {
  display: block;
  font-size: inherit;
  margin: 0 0 10px 0;
  position: relative;
}

.accordion input {
  display: none;
  position: absolute;
  visibility: hidden;
  left: 50%;
  top: 50%;
  z-index: 1;
}

.accordion__header {
  background-color: #21385E;
  border: 1px solid #CFD8DC;
  border-bottom-width: 0px;
  color: #fff;
  cursor: pointer;
  transition: background 0.2s;
  padding: 20px;
  position: relative;
  z-index: 2;
}
.accordion__header:hover {
  background-color: #CFD8DC;
  color: white;
}
.accordion__header:hover:before, .accordion__header:hover:after {
  background-color: white;
}
.accordion__header:before, .accordion__header:after {
  background-color: #CFD8DC;
  content: '';
  display: block;
  position: absolute;
  z-index: 3;
}
.accordion__header:before {
  height: 2px;
  margin-top: -1px;
  top: 50%;
  right: 20px;
  width: 8px;
}
.accordion__header:after {
  height: 8px;
  margin-top: -4px;
  top: 50%;
  right: 23px;
  width: 2px;
}
.accordion input:checked ~ .accordion__header {
  background: #21385E;
  border-color: #21385E;
  color: white;
}
.accordion input:checked ~ .accordion__header:hover {
  background-color: #21385E;
  border-color: #21385E;
  color: white;
}
.accordion input:checked ~ .accordion__header:before {
  background-color: white;
}
.accordion input:checked ~ .accordion__header:after {
  display: none;
}


.accordion__content {
  background-color: white;
  display: none;
  padding: 20px;
}
.accordion input:checked ~ .accordion__content {
  display: block;
}


</style>
<script type="text/javascript" src="https://kolchuga.digift.ru/script"></script>
<script type="text/javascript">document.addEventListener("DOMContentLoaded", function() { IframeWidgetFunctional.init('.js_iframe_widget','.js_balance_widget'); });</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>