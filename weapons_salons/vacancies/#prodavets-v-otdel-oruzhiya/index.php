<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Продавец в отдел одежды");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Продавец в отдел оружия</h1>
			<div class="osnanons">
				<p>
					 В оружейные салоны «Кольчуга» требуются продавцы-консультанты&nbsp;в отдел оружия:
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="prodavec_oruzhia_1.jpg" src="/upload/medialibrary/834/834c380d596a0249f0ed37d6234cd268.jpg" title="prodavec_oruzhia_1.jpg">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<p>
 <b>Обязанности:</b>
			</p>
			<ul>
				<li>
				Консультирование клиентов по товарному ассортименту, подбор товаров; </li>
				<li>Продажа оружия, патронов, запчастей к гражданскому оружию, ножей;</li>
				<li>Участие в приеме товара, размещение товара в торговом зале;</li>
				<li>Участие в проведении инвентаризации;</li>
				<li>Участие в рекламных акциях;<br>
 </li>
				<li>Участие в оружейных выставках.</li>
			</ul>
			<p>
 <b>Требования:</b>
			</p>
			<ul>
				<li>Знание техники продаж;<br>
 </li>
				<li>Понимание и увлечённость оружейной тематикой;</li>
				<li>Желание овладеть интересной профессией;</li>
				<li>Клиентоориентированность, пунктуальность, внимательность, хорошие коммуникативные навыки, позитивный настрой.</li>
			</ul>
			<p>
 <b>Условия:</b>
			</p>
			<ul>
				<li>Интересная работа с мировыми брендами в стабильной, динамичной компании;</li>
				<li>График работы 8-ми часовой рабочий день, 5/2 со скользящими выходными;</li>
				<li>Оклад + ежемесячная премия по итогам работы. Премии по итогам работы за квартал и годовые;</li>
				<li>Комфортные условия работы;</li>
				<li>Оформление согласно трудовому законодательству РФ;<br>
 </li>
				<li>Возможность карьерного роста и профессионального развития;</li>
				<li>Проводится обучение. Стажировка оплачивается.</li>
			</ul>
 <br>
		</div>
		<div class="col-md-1 d-none d-md-block">
		</div>
		<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
			 <?$APPLICATION->IncludeFile("/2021/recomend.php"); //рекомендуем?>
		</div>
	</div>
</div>
 Резюме рассматриваются по электронному адресу: <a href="mailto:hr@kolchuga.ru">hr@kolchuga.ru</a>
<p>
	 Телефон отдела кадров: <a href="tel:+74959252641">+7 (495) 925-26-41</a> доб. 309
</p>
<div class="container-fluid next_service pb-5">
	<div class="row">
		 <!-- start --> <!-- end -->
	</div>
</div>
<style>
.title-page{display:none;}
.next_recomend {position:relative;}
.next_recomend.fixed {position:fixed;top:0;z-index: 10;}
.next_recomend .recomend_title{height: 40px;text-align:center;color:#fff;background-color:#c4c4c4;font-family: 'PT Sans';font-size: 14px;text-transform: uppercase;line-height: 40px;}
.next_recomend .recomend_list ul{list-style: none;padding-left:0;}
.next_recomend .recomend_list li{padding-top:12px;}
.next_recomend .recomend_list li, .next_recomend .recomend_list li a{font-family: 'PT Sans Bold';font-size: 16px;line-height: 18px;color:#616161;font-weight:900;}
.next_recomend .recomend_list li span{font-size: 12px;font-weight:500;}
.next_recomend .recomend_list .btn-blue{padding: 5px 8px;width: 108px;}
</style>
<script>
	$(document).ready(function(){
		$('.osntext  .rewievs').owlCarousel({
			loop:true,
			items:1,
			margin:10,
			dots:false,
			nav:true,
			navText:['<span class="icon-arrow-left3"></span>','<span class="icon-arrow-right3"></span>'],
		});	

var fixed = false;
	
	 
		var hcont=$('.next_recomend').outerHeight();
		var hcont_anchor=$('.anchor_next_recomend').outerHeight();		
		var hosntext=$('.osntext').outerHeight();
		var raznica_hcont=hcont_anchor-hosntext;
		if(raznica_hcont>0){hcont=hcont+raznica_hcont;}
		var wcont=$('.next_recomend').outerWidth();
		var what_stop='foter';
		var elementstop =$('.footer').offset().top - hcont;
		
		if($('.next_tovar').length>0){
			elementstop = $('.next_tovar').offset().top - hcont -30;
			what_stop='next_tovar';
		}else if($('.next_service').length>0){
			elementstop = $('.next_service').offset().top - hcont;
			what_stop='next_service';
		}
        var action_top = $('.anchor_next_recomend').offset().top;
		
		
    $(window).scroll(function (event) {
		

       var st = $(document).scrollTop();
		
		
		//console.log(st+' -> '+elementstop+' -> '+action_top+' -> '+what_stop);
		
        if (st > action_top) {
			if(elementstop>0 && st<elementstop && !fixed){
				$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
				fixed=true;
			}else if(elementstop<1 && !fixed){
				$('.next_recomend').addClass('fixed').css({"width":wcont+"px"}); 
				fixed=true;
			}else if(st>elementstop && fixed){
				$('.next_recomend').removeClass('fixed').css({"width":"auto"}); 
				fixed=false;
			}
        }
        else {
			if(fixed){
				$('.next_recomend').removeClass('fixed').css({"width":"auto"});
				fixed=false;
			}
        }
 
 
    });		
	});
</script><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>