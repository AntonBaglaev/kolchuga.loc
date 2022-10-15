<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (!empty($arResult['ERROR']))
{
	ShowError($arResult['ERROR']);
	return false;
}

global $USER_FIELD_MANAGER;
//\Kolchuga\Settings::xmp($arResult,11460, __FILE__.": ".__LINE__);
$listUrl = str_replace('#BLOCK_ID#', intval($arParams['BLOCK_ID']),	$arParams['LIST_URL']);
?>
<!--<a href="<?=htmlspecialcharsbx($listUrl)?>"><?=GetMessage('HLBLOCK_ROW_VIEW_BACK_TO_LIST')?></a>--><br>
<? if (!empty($arResult['STRANA'])) {
    ?>
    <div class="img_strana">
    <div class="region_text">Страна:</div>
    <div class="region_img" style="background-image: url(<?= $arResult['STRANA'][0]['PREVIEW_PICTURE'] ?>)"
         title="<?= current($arResult['STRANA'])['NAME'] ?>"></div>
    </div><?
} ?>
<?if(!empty($arResult['MODEL_RYAD'])){?>
<div class="row">
	<?foreach($arResult['MODEL_RYAD'] as $gr=>$item){?>
		<div class="col-sm-3 ">
			<strong><?=$gr?></strong>:<br>
			<ul style="list-style: none;" class="pl-0">
			<?foreach($item as $vl){?>
				<li><a href="<?=htmlspecialcharsbx($listUrl)?><?=$arResult['row']['UF_LINK']?>/<?=$vl['CODE']?>/"><?=(!empty($vl['PROPERTY_GROUP_ELEMENT_VALUE']) ? $vl['PROPERTY_GROUP_ELEMENT_VALUE'] : $vl['NAME'])?></a></li>
			<?}?>
			</ul>
		</div>
	<?}?>
</div>
<?}?>
<div class="reports-result-list-wrap">

    <div class="reports-result_banner"
         style="background-image: url(<?= CFile::GetPath($arResult['row']['DISPLAY']['UF_FILE_MINI']['VALUE']) ?>)"><a href="<?= $arResult['row']['DISPLAY']['UF_LINK_BANNER']['VALUE']?>"><img src="/images/1310_360.png"></a></div>

</div>
<?/* if(!empty($arResult['MODEL_RYAD'])){?>
	<div class="reports-result-list-wrap">
	<h3>Модельный ряд бренда</h3>
	<ul style="list-style: none;">
	<?foreach($arResult['MODEL_RYAD'] as $vl){?>
		<li><a href="<?=htmlspecialcharsbx($listUrl)?><?=$arResult['row']['UF_LINK']?>/<?=$vl['CODE']?>/"><?=$vl['NAME']?></a></li>
	<?}?>
	</ul>
	</div>
<?} */?>

<?if(!empty($arResult['row']['DISPLAY']['UF_DOWNLOAD_FILE']['VALUE'])){?>
<?$this->SetViewTarget("block_brands_file");?>
				 
				<div class="text-left mb-3"><?
				foreach($arResult['row']['DISPLAY']['UF_DOWNLOAD_FILE']['VALUE'] as $klfile=>$href){
					$arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$href);
					//\Kolchuga\Settings::xmp($arFile['type'],11460, __FILE__.": ".__LINE__);
					$ftype='';
					if($arFile['type']=='application/pdf'){ $ftype='download_pdf'; }
					elseif($arFile['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ $ftype='download_doc'; }
					
					?>
					<div class="download_file <?=$ftype?>">
						<a href="<?=$href?>" class="_file" target="_blank"><span><?=(!empty($arResult['fields']['UF_DOWNLOAD_OPIS']['VALUE'][$klfile]) ? $arResult['fields']['UF_DOWNLOAD_OPIS']['VALUE'][$klfile]:'Скачать каталог')?></span></a>					
					</div><?
				}
				?></div>
<?$this->EndViewTarget("block_brands_file");?>
			<?}?>

<?$this->SetViewTarget("block_brands_detail");?>
<div class="reports-result-list-wrap">

			<? foreach($arResult['row']['DISPLAY'] as $keys=>$val):?>
			<?if(in_array($keys,['UF_COLOR_BRAND'])){ continue ; }?>
			<?if(in_array($keys,['UF_LINK_BANNER'])){ continue ; }?>
                <?if($val['VALUE'] != '' && $val['VALUE'] != NULL){?>
				<div>
                    <?if($val['TYPE']=='file'){?>
                       
                    <?}else{?>
                        <?if($val['MULTIPLE']=='Y'){
							if(in_array($keys,['UF_DOWNLOAD_FILE','UF_DOWNLOAD_OPIS','UF_STRANA','UF_COLOR_BRAND','UF_LINK_BANNER'])){
								
							}else{
								foreach ($val['VALUE'] as $vals){?>
									<div class="reports-last-column"><?=$vals?></div>
								<?}
							}
                        }else{?>
					            <div class="reports-last-column"><?=$val['VALUE']?></div>
                            <?}?>
                    <?}?>
				</div>
                <?}?>
			<? endforeach; ?>
</div>
<?$this->EndViewTarget("block_brands_detail");?>

<?if(!empty($arResult['row']['UF_COLOR_BRAND'])){?>
	<style>
	.sidebar__menu ul li a:hover, .sidebar__menu ul li.active a {
		background-color: <?=$arResult['row']['UF_COLOR_BRAND']?>;		
	}
	</style>
<?}?>