<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$r = 0;
if(is_array($arResult["SECTIONS"])){
for($r=0;$r<count($arResult["SECTIONS"]);$r++){

	$sql_section = CIBlockSection::GetList(Array(), Array('IBLOCK_ID'=>2, 'ACTIVE'=>'Y', 'ID'=>$arResult["SECTIONS"][$r]['ID']), false, Array('UF_*'));
	if($m = $sql_section->GetNext())
	{
	   if($m["UF_SEONAME"]!=''){
		   $arResult["SECTIONS"][$r]['UF_SEONAME'] = $m["UF_SEONAME"];
	   }
	}
	
}
}
$model_ryad=["IBLOCK_ID"=>72,'PROPERTY_BRAND'=>$arResult['row']['UF_XML_ID'],'PROPERTY_SEE_ON_STR_BRAND_VALUE'=>'Да'];
$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $model_ryad, false, false, Array('ID','NAME','CODE','PROPERTY_GROUP','PROPERTY_GROUP_ELEMENT'));
while($obEl = $dbEl->Fetch()){
	$group=trim($obEl['PROPERTY_GROUP_VALUE']);
	if(empty($group)){$group='Модельный ряд бренда';}
	$arResult['MODEL_RYAD'][$group][]=$obEl;				
}

$model_ryad=["IBLOCK_ID"=>Array('1'),'>SORT'=>1,'PROPERTY_SEE_IN_BRAND'=>$arResult['row']['UF_XML_ID'],'ACTIVE'=>'Y'];
$dbEl = \CIBlockElement::GetList(array('ACTIVE_FROM' => 'DESC'), $model_ryad, false, Array("nPageSize"=>1), Array('ID','NAME','CODE','DETAIL_PAGE_URL'));
while($obEl = $dbEl->GetNext()){
	$arResult['SEE_NEWS']=$obEl;				
}

if(!empty($arResult['row']['DISPLAY']['UF_STRANA'])){
	
	$strana=["IBLOCK_ID"=>$arResult['fields']['UF_STRANA']['SETTINGS']['IBLOCK_ID'],'ID'=>$arResult['row']['DISPLAY']['UF_STRANA']['VALUE']];
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $strana, false, false, Array('ID','NAME','XML_ID','PREVIEW_PICTURE'));
	while($obEl = $dbEl->Fetch()){
		if(!empty($obEl['PREVIEW_PICTURE'])){$obEl['PREVIEW_PICTURE']=\CFile::GetPath($obEl['PREVIEW_PICTURE']);}
		$arResult['STRANA'][]=$obEl;				
	}
}

//$APPLICATION->SetPageProperty("description", $arResult["fields"]["UF_NAME"]["VALUE"]." – история и особенности бренда. Познакомиться с ассортиментом знаменитого бренда можно в магазинах «Кольчуга»");
?>