<?php
foreach($arResult as $key=>$arItem){
	$id = 'dopid_'.md5($arItem['TEXT'].$arItem['DEPTH_LEVEL']);
	$arResult[$key]['PARAMS']['CLASS_A'] .= ' '.$id;	
}
?>
<?/*<!--pre>mm <?print_r($arResult);?></pre-->*/?>