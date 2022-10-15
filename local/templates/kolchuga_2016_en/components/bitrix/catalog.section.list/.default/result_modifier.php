<?foreach($arResult['SECTIONS'] as $key => $arSection){
	if(!$arSection['PICTURE']['ID']) continue;
	
	$resized = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_PROPORTIONAL);
	$arResult['SECTIONS'][$key]['PICTURE']['SRC'] = $resized['src'];
}?>