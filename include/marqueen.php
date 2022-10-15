<script type="text/javascript" src="/test/begstroka/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript">
$(function(){
	//$("ul#ticker02").liScroll({travelocity: 0.15});
	$("ul#ticker02").liScroll().css({'visibility':'visible'});
});
</script>

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


$res = \CIBLockElement::GetList (Array(), $arrFilter, false, false, Array('ID','NAME','PREVIEW_TEXT'));
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
<div class="marquee mt-5">
	<ul id="ticker02" style="visibility:hidden;">
		<?foreach($arrMarquee as $kol=>$item){?>
			<li><span style="color: #2138<?=$endcol[array_rand($endcol)]?>;"><?=$item['PREVIEW_TEXT']?></span></li>
		<?}?>		
	</ul>
</div>

 	
<style>
.tickercontainer { 
font-size: 20px; font-weight: 100; line-height: 150%; text-shadow: #000000 0px 1px 1px;
	box-shadow: 1px 1px 5px 1px rgb(34 60 80 / 20%) inset;
	padding: 10px 0;
overflow: hidden; 
}
.tickercontainer .mask { /* that serves as a mask. so you get a sort of padding both left and right */
position: relative;
padding: 10px 15px;
	font-size: 20px;
	text-shadow: none;
}
ul.newsticker { /* that's your list */
position: relative;

list-style-type: none;
margin: 0;
padding: 0;

}
ul.newsticker li {
float: left; /* important: display inline gives incorrect results when you check for elem's width */
white-space: nowrap;
padding-right:3em;
display:block;
}


</style> 

	
<?}?>