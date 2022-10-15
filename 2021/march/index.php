<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Март");
?><div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Март</h1>
			<div class="osnanons">
				<p>
					 Коллекционная модель Blaser R8 Aniversary была изготовлена лимитированной серией в двадцать экземпляров в честь юбилея бренда. Эта превосходная винтовка в особом исполнении украсит частный арсенал самого взыскательного любителя и знатока оружия и станет ценной семейной реликвией.&nbsp;<br>
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="march_blaser.jpg" src="/upload/medialibrary/5e0/5e04bd3b2a4e7e473406fcf6fb22e46d.jpg" title="march_blaser.jpg">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			<p>
				 Для изготовления Blaser R8 Aniversary использовались самые высококачественные материалы. Вороненая ствольная коробка украшена эмблемой фирмы Blaser, на шарике рукоятки так же присутствует фирменная эмблема, а спусковой крючок и личина покрыты нитрид-титаном. Классической формы приклад изготовлен из орехового дерева высшей категории.
			</p>
			<p>
				 При этом, премиальная винтовка сохранила технологичность, практичность, простоту в обращении и все остальные преимущества так любимой охотниками и спортсменами модели Blaser 8. Затворная группа винтовки устроена таким образом, чтобы ускорить процесс перезарядки оружия без ущерба его точности. Предохранительная система привязана к взводу боевой пружины, что делает оружие максимально безопасным. Магазин винтовки отъемный, емкостью 4 патрона.
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
 <a href="/2021/september/"> <img alt="february_sauer_sohn_339.jpg" src="/upload/medialibrary/004/004b86c9147fbb2715f0d2357572093b.jpg" border="0" title="february_sauer_sohn_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/september/">Февраль</a><br>
 </h3>
										<div class="minanons">
											 Sauer&amp;Sohn 9.3x74/9.3x74
										</div>
 <br>
 <a target="_blank" href="/2021/september/" class="btn-blue mx-0">Подробнее</a>
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
 <a href="/2021/april/"> <img alt="april_lucianobosis_339.jpg" src="/upload/medialibrary/915/915dacc2e6b684412df3a4f748969870.jpg" border="0" title="april_lucianobosis_339.jpg" class="preview_picture "> </a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="container-fluid h-100">
								<div class="row h-100">
									<div class="col-md-2">
									</div>
									<div class="col-md-10 service_item_opis h-100">
										<h3><a href="/2021/april/">Апрель</a><br>
 </h3>
										<div class="minanons">
											 Luciano Bosis Wild
										</div>
 <br>
 <a target="_blank" href="/2021/april/" class="btn-blue mx-0">Подробнее</a>
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