<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Август");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Август</h1>
			<div class="osnanons">
				<p>
					 Горизонтальный штуцер калибра .375H&amp;H\.375H&amp;H – это настоящее произведение искусства от австрийского оружейного дома.
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="august_just.jpg" src="/upload/medialibrary/894/894dd76dfab4636c3fb50c93f0e76d4f.jpg" title="august_just.jpg">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<p>
				 Каждый экземпляр изготавливается по индивидуальному заказу, с самыми строгими требованиями к каждому элементу.
			</p>
			<p>
			</p>
			<p>
				 Так, цевье и приклад щтуцера выполнены из комелевой части ореха высшей категории. Ручная гравировка с изображением представителей «большой пятёрки» и очертаний Африканского континента создается с применением драгоценных материалов и украшает ствольную коробку.
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
 <a href="/2021/october/"> <img alt="july_krieghoffk80_339.jpg" src="/upload/medialibrary/f97/f975bb2e17948c33bf2632133152353e.jpg" border="0" title="july_krieghoffk80_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/october/">Июль</a><br>
 </h3>
										<div class="minanons">
											 Krieghoff K 80
										</div>
 <br>
 <a target="_blank" href="/2021/october/" class="btn-blue mx-0">Подробнее</a>
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
 <a href="/2021/june/"> <img alt="september_rigby_339.jpg" src="/upload/medialibrary/4bf/4bfc715dd552f7eb907fbaefcb519fc5.jpg" border="0" title="september_rigby_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/june/">Сентябрь</a><br>
 </h3>
										<div class="minanons">
											 John Rigby London Best Big Game
										</div>
 <br>
 <a target="_blank" href="/2021/june/" class="btn-blue mx-0">Подробнее</a>
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