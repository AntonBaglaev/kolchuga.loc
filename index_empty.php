<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); 
$APPLICATION->SetTitle("  ");?>

<?
\Bitrix\Main\Loader::includeModule('iblock');
    // вывод блока
    $rest = \CIBLockElement::GetList (Array(), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '61'), false, ["nTopCount" => 2], Array('ID','NAME','PROPERTY_RAZMER','PROPERTY_LINK','PROPERTY_TEXT_BTN','DETAIL_PICTURE','PREVIEW_PICTURE'));
    while ($db_item = $rest->GetNext())
    {
    $ar_rest[] = $db_item;
    }
	
	
    echo "<pre>";print_r($ar_rest);echo "</pre>";
    ?>
<div class="row">
<section class="container baner_block mb-5">
	<div class="row">
		<?foreach(){}?>
		<div class="col-sm-4 stolb stolb1">
			<img src='/images/b1.png' class=" img-0" />
			<div class="baner_logotip">Blaser</div>
			<div class="baner_text">Одежда для охоты</div>
			<div class="baner_btn"><a href='javascript:void(0);'>Смотреть</a></div>
			
			
		</div>
		<div class="col-sm-8 stolb stolb2 pl-sm-0">
			<img src='/images/b2.png' class=" img-0" />
			<div class="baner_logotip">Kahles</div>
			<div class="baner_text">Оптические прицелы</div>
			<div class="baner_btn"><a href='javascript:void(0);'>Подробнее</a></div>
		</div>
	</div>
</section>
</div>



<style>
.basa {background-color:#fafafa;text-align:center;}
.inista {font-family: 'PT Sans';font-size:18px;color:#c5c5c5;text-decoration:none;display:block;margin:10px auto;}
.allbrand2{
    display: block;
    text-align: center;
    border: 1px solid #5C5C5C;
    width: 120px;
	font-size:14px;
    margin: 20px auto 0 auto;
    padding: 6px 10px;
    font-family: 'PT Sans';
    color: #5C5C5C;
    text-decoration: none;
    cursor: pointer;
    text-transform: uppercase
}
.block_2_2 .title_line{margin-bottom:1em;}

.title_line1{border-top:1px solid #c5c5c5;text-align:center;}
.title_line{text-align:center;}
.title_line:after {
                content: '';
                display: block;
                width: 100%;
                height: 1px;
                background-color: #c5c5c5;
                position: relative;
                margin-top: -12px;
                z-index: 0;
            }
.title_line span{padding:5px;background-color:#fff;text-transform: uppercase;position: relative; z-index: 1;}

.withparalax_title {margin-bottom:1em;}
.withparalax_title a{font-size:36px;color:#21385E;}
.withparalax_text{font-size:18px;font-family: 'PT Sans';color:#5c5c5c;margin-bottom:1em;}
.withparalax_icon{display: flex;   justify-content: space-between;   flex-wrap: wrap;text-align: center;text-transform: uppercase;}
.withparalax_icon a{text-transform: uppercase;font-size:18px;font-family: 'PT Sans';color:#5c5c5c;}

.containerparallax { position: relative; background: #1f2c2c; height: 286px; width: 400px; margin: 6% auto 0; overflow: hidden;}
.parallax {  position: absolute;}
#scene {  z-index: 100;}
#crowd-first {  z-index: 200;}

.salon_block .salon_block_title{display:table;margin: 0 auto;}
.salon_block .salon_block_title_cell{font-size:48px;display:table-cell;width:100%;vertical-align: middle;color:#21385E;}
.salon_block .salon_block_hide{border-top:1px solid #21385E;padding-top:5px;display:none;text-align: left;}
.salon_block .salon_block_hide a{float:right;}
.salon_block .salon_block_hide .zag{text-transform: uppercase;font-size:10px;font-family: 'PT Sans';color:#5c5c5c;}
.salon_block .salon_block_hide .tel{text-decoration:underline;font-size:10px;font-family: 'PT Sans';color:#5c5c5c;}
.salon_block .salon_block_hide .time{font-size:10px;font-family: 'PT Sans';margin-bottom:1.1em;color:#5c5c5c;}
.salon_block .salon_block_show {text-align:center;display:table-cell;vertical-align: middle;color:#5c5c5c;}
.salon_block .salon_block_show:hover .salon_block_hide {display:block;}
.salon_block .salon_block_content {min-height:260px;display:table;width:100%;}
.salon_block .sender a {  display:block;  width: 50%; float: left; text-align: center; font-size: 10px;color:#5c5c5c;font-family: 'PT Sans';}


.img-0{  min-width: 100%; min-height: 100%; flex-shrink: 0;object-fit: cover;}
.stolb{margin-bottom:1em;}
.stolb1 .baner_logotip{position: absolute; top: 5%; right: 10%; color: #fff;}
.stolb1 .baner_text{position: absolute; top: 40%; left: -25%; color: #fff; font-size: 24px;line-height: 28px; width: 50%;  margin-left: 50%;}
.stolb1 .baner_btn{position: absolute; bottom: 15%; left: -25%; font-size: 1em; width: 50%; margin-left: 50%; text-align: center;}	
.stolb2 .baner_logotip{position: absolute; top: 5%; right: 5%; color: #fff;}
.stolb2 .baner_text{position: absolute; top: 40%; left: -20%; color: #fff; font-size: 24px;	line-height: 28px; width: 200px; margin-left: 30%;}	
.stolb2 .baner_btn{position: absolute; bottom: 15%; left: -20%; font-size: 1em; width: 40%; margin-left: 30%; text-align: center;}
.baner_btn a{color:#fff;display:block; width:200px; border:1px solid #fff;padding:5px 10px;}
.container { width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;}

@media (max-width: 740px){
	.stolb2 .baner_logotip{position: absolute;    right: 10%; }
	.stolb2 .baner_text{ font-size: 18px;line-height: 20px;  }
	.stolb2 .baner_btn{font-size: 16px;  }
	.withparalax_icon{justify-content: space-around;}
}
</style>
<script>
$(document).ready(function(){

  var elem = $('.containerparallax'),
      pos = elem.offset(),
      elem_left = pos.left,
      elem_top = pos.top,
      elem_width = elem.width(),
      elem_height = elem.height(),
      x_center,
      y_center;


  $('.containerparallax').mousemove(function(e){

    x_center = ( elem_width / 2 ) - ( e.pageX - elem_left );
    y_center = ( elem_height / 2 ) - ( e.pageY - elem_top );

    $('.containerparallax .parallax').each(function(){

      var speed = $(this).attr('data-speed'),
          xPos = Math.round(-1*x_center/30*speed),
          yPos = Math.round(y_center/20*speed);

      if (yPos < 0)
        yPos = -2*speed;
     
      $(this).css('transform', 'translate3d('+xPos+'px, '+yPos+'px, 0px)');

        });

    });

});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>