<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ноябрь");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Ноябрь</h1>
			<div class="osnanons">
				<p>
					 Imperiale Montecarlo&nbsp;от&nbsp;Beretta&nbsp;– произведение&nbsp;оружейного&nbsp;искусства от&nbsp;итальянских мастеров.
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="november_imperial.jpg" src="/upload/medialibrary/d6b/d6bfd7bb7beb17ede88bb4435aadcb89.jpg" title="november_imperial.jpg">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<p>
				 Элегантное двуствольное ружье Beretta Imperiale Montecarlo – настоящая легенда, вошедшая в историю оружейного дела. Ружья этой модели производятся в ограниченном количестве для самых эксклюзивных клиентов. Уникальный внешний вид и гравировки лучших мастеров сочетаются с безупречным механизмом, работающим как изготовленные на заказ часы. Точная обработка каждой детали напильником и наждачной тканью, а также тщательнейшие подгонка и полировка выполняются с величайшем вниманием.&nbsp;
			</p>
			<p>
				 Тема гравировки обсуждается с каждым клиентом индивидуально. Опытные художники-граверы наносят на модели Beretta сцены охоты, цветочные орнаменты и даже портреты.&nbsp;
			</p>
			<p>
				 Используемая для ружей специальная сталь обеспечивает чрезвычайно высокую стойкость и прочность. Приклад из дерева орешника изготавливается в различных формах, придавая этому оружейному шедевру дополнительные индивидуальность и уникальность.
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
 <a href="/2021/july/"> <img alt="october_benelli_magnifico_339.jpg" src="/upload/medialibrary/922/922097b05db0be568e40d6d35224fbfe.jpg" border="0" title="october_benelli_magnifico_339.jpg" class="preview_picture "> </a>
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
		 <!-- end --> <!-- start -->
		<div class="col-md-6 service_item">
			<div class="row">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 pr-md-0">
							<div class="row">
 <a href="/2021/december/"> <img alt="december_cosmideluxe_339.jpg" src="/upload/medialibrary/293/293dd1f3a3bb8b52f9934a11c0cb4256.jpg" border="0" title="december_cosmideluxe_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/december/">Декабрь</a><br>
 </h3>
										<div class="minanons">
											 Cosmi De Luxe G6
										</div>
 <br>
 <a target="_blank" href="/2021/december/" class="btn-blue mx-0">Подробнее</a>
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