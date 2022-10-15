<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Электронные подарочные карты");
$APPLICATION->SetPageProperty("title", "Электронные подарочные карты");
?>


    
<div class="row" style=" align-items: center;">	
		<div class="col-12 col-md-6 pt-20 cert">
		<div class="content-title text-center" style="font-size: 48px;">Электронные <br>подарочные карты</div>
		
			<div class="main__btn"><a href="javascript:void(0);" class="js_iframe_widget open_dgift">Выбрать карту</a></div>
			<div class="main__btn"><a href="javascript:void(0);" class="js_balance_widget open_dgift_balance">Проверить баланс</a></div>
			
		</div>
		<div class="col-12 col-md-6 pt-20 cert">
			<div class="" style="  padding: 17px;  border: 1px solid #eee;  border-radius: 20px;   box-shadow: 5px 5px 5px -5px rgba(34, 60, 80, 0.6);
"><img class="cert pb40 pr20" src="DSC1784_final2.jpg" alt="Электронные подарочные карты Кольчуга">
			<!-- <img class="cert pb40 pr20" src="Beretta_150509__F6A2911.jpg" alt="Электронные подарочные карты Кольчуга"> --></div>
		</div>
</div>

<div class="row">
	<div class="col-12 col-md-4 cert pt-20 text-center">
		<div class="section_title"><span>1</span></div>
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
			</div>
			<div class="gifts-card__descr content-text">
				Выберите номинал<br>
				и&nbsp;дизайн подарочной<br>
				карты, заполните<br>
				поля «От&nbsp;кого»<br>
				и&nbsp;«Поздравление» 
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		<div class="section_title"><span>2</span></div>
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
			</div>
			<div class="gifts-card__descr content-text">
				Нажмите «Оформить карту», <br>чтобы получить письмо с&nbsp;электронной<br>
				подарочной картой,<br>
				а&nbsp;также пин-код для ее&nbsp;активации
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 cert pt-20 text-center">
		<div class="section_title"><span>3</span></div>
		<div class="gifts-card">
			<div class="gifts-card__icon">
				<!-- <img src="/upload/iblock/213/Иконка_3.png"> -->
			</div>
			<div class="gifts-card__descr content-text">
                Подарите<br>
				близкому человеку <br>
				или партнеру.<br>
			</div>
		</div>
	</div>
</div>


<div class="row" style="justify-content: center;">
	<div class="col-12 col-md-6 cert usl pt-40 ">		
        <div class="content-title text-center">Условия использования</div>
		<!-- <ol class="content-text">
			<li>
				<div class="gifts-terms-list__title">Срок действия</div>
				<div class="gifts-terms-list__body">Карта действует 1&nbsp;год с&nbsp;момента покупки. <a class="js_balance_widget" data-popup="checkCard" href="javascript: void(0);"><span>Проверить срок действия</span></a></div>
			</li>
			<li>
				<div class="gifts-terms-list__title">Обмен и возврат</div>
				<div class="gifts-terms-list__body">После покупки подарочная карта не подлежит возврату.</div>
			</li>
		</ol> -->
		
		<div class="content-text">
                <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Активация карты</div>
                    <div class="accordion__content">                        
                        <p>Подарочная карта будет активна сразу после покупки.</p>
                    </div>
                </label>
                <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Как активировать </div>
                    <div class="accordion__content">                        
                        <p>Для использования ЭПК получите пин-код, для этого укажите свой номер телефона в поле на карте и нажмите "Получить PIN". В розничном магазине при оплате покупки предъявите ЭПК на кассе и сообщите пин-код.</p>
                    </div>
                </label>
				<label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Где использовать </div>
                    <div class="accordion__content">                        
                        <p class="content-text">Воспользоваться электронной подарочной картой вы можете в одном из наших <a href="/weapons_salons/">Оружейных салонах</a></p>
                    </div>
                </label>
               <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Срок действия</div>
                    <div class="accordion__content">
                        
                        <p>Карта действует 1&nbsp;год с&nbsp;момента покупки. <a class="js_balance_widget" data-popup="checkCard" href="javascript: void(0);"><span>Проверить срок действия</span></a></p>
                    </div>
                </label>
                <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Формат использования</div>
                    <div class="accordion__content">
                        
                        <p>Для оплаты предъявите кассиру штрих-код и ПИН-код карты.</p>
                    </div>
                </label>
                
                <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Кратность использования</div>
                    <div class="accordion__content">
                        
                        <p>Карта может быть использована однократно</p>
                    </div>
                </label>
               <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Суммирование карт</div>
                    <div class="accordion__content">
                        
                        <p>Карта может суммироваться с другими подарочными картами</p>
                    </div>
                </label>
               <label class="accordion">
                    <input type='checkbox' name='checkbox-accordion' class="no_check">
                    <div class="accordion__header">Обмен и возврат</div>
                    <div class="accordion__content">
                        
                        <p>После покупки подарочная карта не подлежит возврату в оружейных салонах ООО «Кольчуга».</p>
                    </div>
                </label>
               
            </div>
		
	</div>
</div>


<div class="row" style="justify-content: center;">
	<div class="col-12 col-md-6 cert usl pt-20 ">		
        <div class="content-title text-center">Электронные подарочные карты</div>
		<div class="content-text">
			<p class="text-center">Ваш универсальный подарок</p>
			<div class="main__btn inblock"><a href="javascript:void(0);" class="js_iframe_widget open_dgift">Выбрать карту</a> <a href="javascript:void(0);" class="js_balance_widget open_dgift_balance">Проверить баланс</a></div>
		</div>
	</div>
</div>



<style>
.pt-20{padding-top:20px;}
.pt-40{padding-top:40px;}
.pb-20{padding-bottom:20px;}
.inblock {justify-content: center;    display: flex;}
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