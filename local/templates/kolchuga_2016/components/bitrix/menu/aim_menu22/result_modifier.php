<?php
foreach($arResult as $key=>$arItem){
	$id = 'dopid_'.md5($arItem['TEXT'].$arItem['DEPTH_LEVEL']);
	$arResult[$key]['PARAMS']['CLASS_A'] .= ' '.$id;	
	$arResult[$key]['SORT']=(!empty($arItem['PARAMS']['ALT_SORT'])  ? $arItem['PARAMS']['ALT_SORT'] : $arItem['PARAMS']['SORT']);
}

$menuList = array();
$lev = 0;
$lastInd = 0;
$parents = array();
foreach ($arResult as $arItem) {
	$lev = $arItem['DEPTH_LEVEL'];

	if ($arItem['IS_PARENT']) {
		$arItem['CHILDREN'] = array();
	}
	

	if ($lev == 1) {
		$menuList[] = $arItem;
		$lastInd = count($menuList)-1;
		$parents[$lev] = &$menuList[$lastInd];		
	} else {
		$arItem['PARENTLINK']=$parents[$lev-1]['LINK'];
		$parents[$lev-1]['CHILDREN'][] = $arItem;
		$lastInd = count($parents[$lev-1]['CHILDREN'])-1;
		$parents[$lev] = &$parents[$lev-1]['CHILDREN'][$lastInd];
	}	
}
$arResult=$menuList;
foreach ($arResult as &$arItem) {
	if($arItem['LINK'] == '/internet_shop/'){
		\Bitrix\Main\Type\Collection::sortByColumn($arItem['CHILDREN'] ,'SORT');
	}
} 
?>
<?/*<!--pre>mm <?print_r($arResult);?></pre-->*/?>