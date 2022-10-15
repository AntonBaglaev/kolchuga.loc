<?
if(empty($arResult['SECTIONS']) && $arResult['SECTION']['ID']){
	$arFilter = array('SECTION_ID' => $arResult['SECTION']['IBLOCK_SECTION_ID']);
	$arSelect = array('ID', 'IBLOCK_ID', 'NAME', 'SECTION_PAGE_URL');
	
	$res = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter, false, $arSelect, false);
	while($section = $res->GetNext()){
		
		if($section['ID'] == $arResult['SECTION']['ID'])
			$section['CURRENT'] = 'Y';
			
		$arResult['SECTIONS'][] = $section;
	}	
}?>