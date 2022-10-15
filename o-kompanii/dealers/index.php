<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Оптовикам");
$APPLICATION->SetPageProperty("robots", "Оптовым клиентам");
$APPLICATION->SetPageProperty("keywords", "Оптовикам");
$APPLICATION->SetPageProperty("description", "«Кольчуга» - ведущая оптовая оружейная компания нашей страны. У нас широчайший и постоянно обновляющийся ассортимент, представленный в крупнейшем электронном каталоге оружия, товаров для охоты, туризма и активного отдыха.");
$APPLICATION->SetPageProperty("title", "Оружие  оптом - информация для оптовых клиентов Diada-Arms «Кольчуга»");
?><?
\Bitrix\Main\Loader::includeModule('iblock');
\CJSCore::Init();
CJSCore::init("sidepanel");
//echo "<pre>";print_r($ar_rest);echo "</pre>";
?>
<div class="container-fluid pb-5">
	<div class="row">
		<div class="rowanons col-md-6 order-2 mt-4 mt-md-0">
			<h1>Оптовым клиентам</h1>
 <br>
			<div class="osnanons">
				<p>
 <strong>Начните сотрудничество с оптовым лидером оружейного рынка России - группой компаний «Кольчуга» - прямо сейчас!</strong>
				</p>
				<p>
					 Сегодня «Кольчуга» - ведущая оптовая оружейная компания нашей страны, основанная более 25 лет назад. Это не только сеть оружейных салонов и современный интернет-магазин, но и широчайший и постоянно обновляющийся ассортимент, представленный в крупнейшем электронном каталоге оружия, товаров для охоты, туризма и активного отдыха.
				</p>
			</div>
		</div>
		<div class="col-md-6 order-1 order-md-2">
 <img alt="shutterstock_1662171529.jpg" src="/upload/medialibrary/d52/d52f0f2dc96ccfedc1f5d1ba4df7979d.jpg" border="0" title="shutterstock_1662171529.jpg" class="preview_picture ">
		</div>
	</div>
	<div class="w-100 pb-5">
 <br>
	</div>
	<div class="row">
		<div class="col-md-8 osntext pr-md-5">
			 <?$APPLICATION->IncludeFile("/optovik/block_1.php"); //преимущества?> 
			 <?$APPLICATION->IncludeFile("/optovik/block_2.php"); //бренды?> 
			 <?$APPLICATION->IncludeFile("/optovik/block_3.php"); //Отзывы?> 
			 <?$APPLICATION->IncludeFile("/optovik/block_4.php"); //Карта?> 
			 <?$APPLICATION->IncludeFile("/optovik/block_5.php"); //Форма?>
		</div>
		<div class="col-md-1 d-none d-md-block">
		</div>
		<div class="col-md-3 d-none d-md-block anchor_next_recomend pl-md-2">
			 <?$APPLICATION->IncludeFile("/optovik/recomend.php"); //рекомендуем?>
		</div>
	</div>
</div>
 <style>
 
.service_bread{border-top:1px solid #EA5B35;margin-bottom:1em;}
.service_bread div.bgbread{background-color: #EA5B35;}
.service_bread ul{list-style: none;padding:0;margin:0;}
.service_bread ul li{display:inline-block; font-family: 'PT Sans';font-size: 14px;margin-right:5px;}
.rowanons h1 {font-size: 36px;color:#21385E;}
.service_item {margin-bottom:1.5em;padding-top: 10px;  padding-bottom: 2em;    border-bottom: 1px solid #c4c4c4;}
.service_item_opis h3{padding-top: 30%; height: 50%;font-size:28px;color:#21385E;}
.service_item_opis h3 a:link, .service_item_opis h3 a:focus, .service_item_opis h3 a:visited {color:#616161;} 
.service_item_opis h3 a:hover {color:#21385E;}
.service_item_opis h3 a {text-decoration:none;}
.service_item_opis .minanons{font-size: 16px;font-family: 'PT Sans';color:#616161;}
.service_item_opis .btn-blue{position: absolute; bottom: 10%; font-family: 'PT Sans'; font-size: 14px; width: 108px;height:36px;line-height:36px; padding: 0;}
.osnanons {font-family: 'PT Sans';font-size: 18px;color:#616161;}
.osntext {font-size: 16px;}
.next_salon {margin-top:1.5em !important;}
.next_salon h2 {font-size:30px;color:#21385E;}
.next_salon .next_salon_item {margin-bottom:16px;font-size: 16px;}

.next_service{padding-top: 10px;    border-top: 1px solid #c4c4c4;}
.next_tovar h2{text-transform: uppercase; text-align: center;vertical-align: middle;overflow:hidden;font-size:18px;font-family: 'PT Sans';color:#5C5C5C;}
.next_tovar h2:before,
.next_tovar h2:after {
    /* Обязательно указываем пустое свойство content, 
    ** иначе псевдоэлементы не появятся на сайте */
    content: "";
    /* Указываем что наши линии будут строчно-блочные и 
    ** выравнивание по высоте - по центру */
    display: inline-block;
    vertical-align: middle;
    /* Задаем ширину 100% и выбираем высоту линии, 
    ** в нашем примере она равна 4 пикселям */
    width: 100%;
    height: 1px;
    /* Добавляем цвет для линии */
    background-color: #5C5C5C;
    /* Добавляем пседоэлемантам возможность изменить 
    ** позицию линии, для создания отступов от текста */
    position: relative;
}
.next_tovar h2:before {
    /* Смещаем левую линию на 100% влево, чтобы линия 
    ** встала рядом с текстом слева */
    margin-left: -100%;
    /* Указываем в пикселях отступ линии от текста заголовка */
    left: -14px;
}
.next_tovar h2:after {
    /* Смещаем правую линию на 100% вправо, чтобы 
    ** линия встала рядом с текстом справа */
    margin-right: -100%;
    /* Указываем в пикселях отступ линии от текста заголовка */
    right: -14px;
}
.next_recomend {position:relative;}
.next_recomend.fixed {position:fixed;top:0;z-index: 10;}
.next_recomend .recomend_title{height: 40px;text-align:center;color:#fff;background-color:#c4c4c4;font-family: 'PT Sans';font-size: 14px;text-transform: uppercase;line-height: 40px;}
.next_recomend .recomend_list ul{list-style: none;padding-left:0;}
.next_recomend .recomend_list li{padding-top:12px;}
.next_recomend .recomend_list li, .next_recomend .recomend_list li a{font-family: 'PT Sans Bold';font-size: 16px;line-height: 18px;color:#616161;font-weight:900;}
.next_recomend .recomend_list li span{font-size: 12px;font-weight:500;}
.next_recomend .recomend_list .btn-blue{padding: 5px 8px;width: 108px;}


.teml_discount .item {
    color: #1d355b;
    display: inline-block;
    background: #f5f5f5;
    padding: 1em;
    margin: 0 0 1.5em;
    width: 100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-shadow: 2px 2px 4px 0 #efefef;
}
.teml_discount .imgitem{
	display: block;
    height: 250px;
    width: 100%;
    
}
.teml_discount .textitem{height:50px; overflow:hidden;margin-bottom:1em;}
.slider_set .owl-stage{/*display:flex;flex-wrap: wrap;*/}
.slider_set {}

@media (max-width: 719px) {
  .service_item_opis h3{padding-top: 10%; height: auto;}
.service_item_opis .minanons{font-size: 80%;padding:1em 0;}
.service_item_opis .btn-blue{position: relative; bottom: none;}
.osnanons {font-size: 100%;}
.order-2 h2{padding-top:10%;}
}

div.gallery-block div.gallery-img {
	/*margin: 0 -10px 10px 0;*/
	margin:0;
    position: relative;
    background-repeat: no-repeat;
    background-position: center;
    /*background-size: cover;*/
    background-size: contain;
}
div.gallery-block.gallery div.gallery-img.small-size{
			height: 100px;
		}
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
}
.knopka a {color:#ffffff;}



.osntext .rewievs_block{
	padding-bottom:1em;
	border:1px dotted #c4c4c4;
	margin: 0 auto;
	display:block;
}
.osntext .rewiev_item{
	text-align: center;
	padding: 0 30px;
}
.osntext .rewiev_text{
	font-family: PT Serif;
	font-size: 18px;
	color: #21385E;
	margin: 20px 0;
}
.osntext .rewiev_author {
	font-family: PT Sans;
	font-size: 18px;
	color: #5C5C5C;
	max-width: 225px;
	margin: 0 auto;
	line-height: 23px;
}
.osntext .rewiev_author p{
	padding: 0;
	font-size: 20px;
}

.osntext .rewievs.owl-theme .owl-nav .owl-next{
	right: 1px;
}
.osntext .rewievs.owl-theme .owl-nav .owl-prev{
	left: 1px;
}
.osntext .catalog_banner{
	background: url(/images/banner_cat_1.png) no-repeat;
    width: 100%;
    display: flex;
    min-height: 300px;
    background-size: contain;
}
.opt_brands div.brand{margin:8px;}
.stamp {
margin:0 auto;
 max-width:480px;
 padding: 10px;
 background: white;
 position: relative;
 
 /*The stamp cutout will be created using crisp radial gradients*/
 background: radial-gradient(
 transparent 0px, 
 transparent 4px, 
 white 4px,
 white
 );
 /*reducing the gradient size*/
 background-size: 20px 20px;
 /*Offset to move the holes to the edge*/
 background-position: -10px -10px;
}
.stamp:after {
 content: '';
 position: absolute;
 /*We can shrink the pseudo element here to hide the shadow edges*/
 left: 5px; top: 5px; right: 5px; bottom: 5px;
 /*Shadow - doesn't look good because of the stamp cutout. */
 box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.5);
 /*pushing it back*/
 z-index: -1;
}
/*Some text*/
.stamp:before {
 content: 'CSS3';
 position: absolute;
 bottom: 0; left: 0;
 font: bold 24px arial;
 color: white;
 opacity: 0.75;
 line-height: 100%;
 padding: 20px;
}
@media (max-width: 415px) {
	.catalog_banner{min-height:130px !important;}
	.catalog_banner .catalog-banner-info {padding-top: 5px;}
	.catalog_banner .catalog-banner-info .banner-info__title{font-size: 22px;}
	.catalog_banner .catalog-banner-info .banner-info__text{margin: 22px 0;}
}
@media (max-width: 340px) {
	.catalog_banner{min-height:100px !important;}
	.catalog_banner .catalog-banner-info .banner-info__title{font-size: 18px;}
	.catalog_banner .catalog-banner-info .banner-info__text{margin: 18px 0;}
	.catalog_banner .catalog-banner-info .main__btn a { width: 200px;}
}
</style> <script>
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

$(document).on('click','#listdilers',function(){
	BX.SidePanel.Instance.open(	"/optovik/magazins_table.php");
});
</script> <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>