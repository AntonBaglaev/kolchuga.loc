<?
$curdate = date("d.m.Y H:i:s");

$arrFilter=[
'=ACTIVE' => 'Y', 
'IBLOCK_ID' => '79',
'LOGIC' => 'AND',
        array(
            'LOGIC' => 'OR',
            '>=DATE_ACTIVE_TO' => new \Bitrix\Main\Type\DateTime(),
            'DATE_ACTIVE_TO' => false,
        ),
        array(
            'LOGIC' => 'OR',
            '<=DATE_ACTIVE_FROM' => new \Bitrix\Main\Type\DateTime(),
            'DATE_ACTIVE_FROM' => false,
        ),
];


$res = \CIBLockElement::GetList (Array("sort"=>"asc", "id"=>"desc "), $arrFilter, false, false, Array('ID','NAME','PREVIEW_TEXT'));
$arrMarquee=[];
while ($db_item = $res->Fetch())
{
    $arrMarquee[]=$db_item;
}
$endcol=[
	'21',
	'00',
	'5e',
	'ff',
];
?>
<?if(!empty($arrMarquee)){?>
 	<div class=" mt-5">
	<ul class="slick marquee">
		<?foreach($arrMarquee as $kol=>$item){?>
			<li class="slick-slide"><span style="color: #2138<?=$endcol[array_rand($endcol)]?>;"><?=$item['PREVIEW_TEXT']?></span></li>
			<?if(count($arrMarquee)==1){
				?><li class="slick-slide"><span style="color: #2138<?=$endcol[array_rand($endcol)]?>;"><?=$item['PREVIEW_TEXT']?></span></li><?
			}?>
		<?}?>		
	</ul>
</div>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css'>
<style>
.slick-slide{margin-right:100px;}
.marquee{
	font-size: 20px; 
	font-weight: 100; 
	line-height: 150%; 
	text-shadow: #000000 0px 1px 1px;
	box-shadow: 1px 1px 5px 1px rgb(34 60 80 / 20%) inset;
	padding: 10px 0;
}

</style> 
<script src='https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js'></script>
  <script>
jQuery(document).ready(function($) {
  $('.slick.marquee').slick({
    speed: 20000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: true,
    cssEase: 'linear',
    slidesToShow: 1,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    initialSlide: 1,
    arrows: false,
    buttons: false
  });
});
</script>	
	
<?}?>