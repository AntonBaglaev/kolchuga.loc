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
 	<div class="marquee d-none d-md-block mt-5">
		<marquee onmouseout="this.start()" onmouseover="this.stop()" >
		<?foreach($arrMarquee as $kol=>$item){?>
			<?if($kol>0){?><span style="margin-right: 60%;">&nbsp;</span><?}?>
			<span style="color: #2138<?=$endcol[array_rand($endcol)]?>;"><?=$item['PREVIEW_TEXT']?></span>
		<?}?>
		<span style="margin-left: 60%;">&nbsp;</span>
		</marquee>
	</div>
	<div class="marquee marquee-v d-block d-md-none mt-5">
		<marquee  scrollamount="5" direction="left">
		<div style="">
		<?foreach($arrMarquee as $kol=>$item){?>
			<span  style="color: #2138<?=$endcol[array_rand($endcol)]?>;"><?=$item['PREVIEW_TEXT']?></span>
		<?}?>		
		</div>
		</marquee>
	</div>

<style>
marquee {
	 font-size: 20px; font-weight: 100; line-height: 150%; text-shadow: #000000 0px 1px 1px;
	box-shadow: 1px 1px 5px 1px rgb(34 60 80 / 20%) inset;
	padding: 10px 0;
}
.marquee-v marquee{
	padding: 10px 15px;
	font-size: 14px;
	text-shadow: none;
}


</style> 

	
<?}?>