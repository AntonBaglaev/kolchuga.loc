<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Электронные подарочные карты");
$APPLICATION->SetPageProperty("title", "Электронные подарочные карты");
?>



<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		
		<div style="background: url(4aa.jpg) no-repeat;
    width: 100%;background-size: cover;
    display: flex;
    min-height: 280px;">
		<div style="flex: 0 0 41%;
    color: #fff;
    margin-right: auto;
        margin-left: 4%;
    margin-bottom: auto;
    margin-top: 7%;
        font-size: calc( (100vw - 320px)/(1308 - 320) * (30 - 10) + 10px);
	">Электронные подарочные сертификаты</div>
		</div>
	</div>
</div>



<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Оружейные салоны «Кольчуга» подготовили новый моментальный сервис для покупки электронных подарочных сертификатов. Пусть близкие сами выберут из широкого ассортимента то, что им точно понравится: определитесь с суммой, оплачивайте стоимость и просто передайте получателю все данные для покупки. 
				
			</div>
		
	</div>
</div>



<div class="row" style="justify-content: center;">
	<div class="col-12 cert usl ">		
        <div class="content-text">
			<div class="main__btn inblock"><a href="javascript:void(0);" class="js_iframe_widget open_dgift" style="font-size: 16px;width: 300px;padding: 10px 0;margin: 10px auto 0;">Купить карту</a> <a href="javascript:void(0);" class="js_balance_widget open_dgift_balance"  style="font-size: 16px;width: 300px;padding: 10px 0;margin: 10px auto 0;">Проверить баланс</a></div>
			
		</div>
	</div>
</div>
<div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<div class="content-text text-center" style="font-size: 21px;">
				Преобрести электронный сертификат легко:
				
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
	<div class="col-12 pt-20 cert" style=" background-color: #002D63;">	
		<?$APPLICATION->IncludeFile('/include/wsalon_sert.php', array(), array())?>
	</div>
</div>
	

<?/* <div class="row" style=" align-items: center;">
	<div class="col-12 pt-20 cert">	
		<?$storeList=\Kolchuga\StoreList::getListSalonProp();?>
		<div class="d-none d-md-flex" style=" width: 100%;    display: flex;">
			<img src="ba2.png">
			<div  style="width: 40%;  color: #fff;  margin-right: auto;  margin-left: 4%;  margin-bottom: auto;  margin-top: 1%;  font-size: 20px;  position: absolute;">
				Воспользуйтесь электронным сертификатом в любом оружейном салоне Кольчуга:<br><br>
				<div class="" style="font-size:14px;color:#fff">
				<?				
					foreach($storeList['STORE_LIST_ALL'] as $idsalon=>$val){
						if(in_array($idsalon,[631125])){continue;}
						?>
						<a href="/weapons_salons/<?=$val['CODE']?>/" style="color:#fff"><?=$val['PROPERTY_DOP_NAME_VALUE']?></a><br>
						<span style="font-size:10px;color:#fff"><?=$val['PROPERTY_PHONES_VALUE']?></span><br><br>
						<?
					}
				?>
				</div>
			</div>		
		</div>
		
		<div class="d-md-none" style=" width: 100%;    display: flex;">
			<img src="ba2.png">
			<div class="d-block d-md-none" style="width: 40%;  color: #fff;  margin-right: auto;  margin-left: 4%;  margin-bottom: auto;  margin-top: 10%;  font-size: 20px;  position: absolute;">
				Где купить:<br><br>			
			</div>
		</div>
		<div class="d-block d-md-none" style="font-size:14px;color:#002D63">
		<?				
			foreach($storeList['STORE_LIST_ALL'] as $idsalon=>$val){
				if(in_array($idsalon,[631125])){continue;}
				?>
				<div class="" style=" margin: 1em 0; padding: 10px; border: 1px dotted #002d63;">
					<a href="/weapons_salons/<?=$val['CODE']?>/" style="color:#002D63"><?=$val['PROPERTY_DOP_NAME_VALUE']?></a><br>
					<span style="font-size:10px;color:#002D63"><?=$val['PROPERTY_PHONES_VALUE']?></span><br>
				</div>
				<?
			}
		?>
		</div>
	</div>
</div> */?>



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
				<img src="dostavka.png" width="100px">
			</div>
			<div class="gifts-card__descr content-text">
				Моментальная доставка в SMS и Email
				
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<img src="pomiru.png" width="100px">
			</div>
			<div class="gifts-card__descr content-text">
				Покупка в любой точке мира
				
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<img src="gift.png" width="100px">
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
	.inblock {display: block;}
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