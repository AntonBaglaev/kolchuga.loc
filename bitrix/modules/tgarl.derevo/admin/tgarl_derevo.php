<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    return;
}


// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle(GetMessage("NPC_TTTLE"));
CJSCore::Init(array("jquery")); 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог


function getTree($dataset) {
		$tree = array();
		if(!empty($dataset) && is_array($dataset)){
		foreach ($dataset as $id => &$node) {    
			//Если нет вложений
			if (!$node['PARENT']){
				$tree[$id] = &$node;
			}else{ 
				//Если есть потомки то перебераем массив
				$dataset[$node['PARENT']]['childs'][$id] = &$node;
			}
		}
		}
		return $tree;
	}
	
	//Шаблон для вывода меню в виде дерева
function tplMenu($category, $cont){
	$menu = '<li '.($cont==1?"class=sole":'').'>
		<a href="'. $category['URL'] .'" title="'. $category['NAME'] .'" target="_blank">'. 
		$category['NAME'].'</a>';
		
		if(isset($category['childs'])){
			$menu .= '<ul>'. showCat($category['childs']) .'</ul>';
		}
	$menu .= '</li>';
	
	return $menu;
}

/**
* Рекурсивно считываем наш шаблон
**/
function showCat($data){
	$string = '';
	if(!empty($data) && is_array($data)){
	$cont=count($data);
	foreach($data as $item){
		$string .= tplMenu($item, $cont);
	}
	}
	return $string;
}

if(!empty($_REQUEST['CODE'])){
	if($_REQUEST['VIBOR']=='CODE'){
		$elementCode=$_REQUEST['CODE'];
		$sectionTree=array();
		$sectionTree2=array();
		$element_id0 = \CIBlockElement::GetList(null, Array('CODE' => $elementCode), false , false,array('ID','IBLOCK_ID','IBLOCK_TYPE_ID','NAME','CODE','IBLOCK_SECTION_ID','DETAIL_PAGE_URL','ACTIVE'));
		while($element_id1 = $element_id0->GetNext()){
			$element_id = $element_id1;
		}
		
		$elementId=$element_id['ID'];
	}elseif($_REQUEST['VIBOR']=='ID'){
		$elementId=$_REQUEST['CODE'];
		$element_id0 = \CIBlockElement::GetList(null, Array('ID' => $elementId), false , false,array('ID','IBLOCK_ID','IBLOCK_TYPE_ID','NAME','CODE','IBLOCK_SECTION_ID','DETAIL_PAGE_URL','ACTIVE'));
		while($element_id1 = $element_id0->GetNext()){
			$element_id = $element_id1;
		}
	}/* elseif($_REQUEST['VIBOR']=='BARCODE'){
		$element_id0 = \CIBlockElement::GetList(null, Array( 'ID' => \CIBlockElement::SubQuery('PROPERTY_CML2_LINK', array( 'IBLOCK_ID' => '27', 'PROPERTY_CML2_BAR_CODE' => $_REQUEST['CODE']  )), 'IBLOCK_ID'=>'26'), false , false,array('ID','IBLOCK_ID','IBLOCK_TYPE_ID','NAME','CODE','IBLOCK_SECTION_ID','DETAIL_PAGE_URL','ACTIVE'));
		while($element_id1 = $element_id0->GetNext()){
			$element_id = $element_id1;
		}
		$elementId=$element_id['ID'];
	} */
	$db_old_groups = \CIBlockElement::GetElementGroups($elementId, true);
	while($ar_group = $db_old_groups->Fetch()){
		$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
		$realNavChain = array();
		$k=0;
		while ($arNav=$navChain->GetNext()){
			if ($arNav['ID']==$element_id['IBLOCK_SECTION_ID']){
				$realNavChain[]=$arNav['NAME'].'<strong style="color:#2a9638">('.$arNav['ID'].(!empty($arNav['CODE'])?' - '.$arNav['CODE']:'').')</strong>';
			}else{
				$realNavChain[]=$arNav['NAME'].'('.$arNav['ID'].(!empty($arNav['CODE'])? ' - '.$arNav['CODE']:'').')';
			}
			$sectionTree2[$arNav['ID']]=array('NAME'=>$arNav['NAME'],"ID"=>$arNav['ID'],"PARENT"=>$arNav['IBLOCK_SECTION_ID'],'URL'=>$arNav['SECTION_PAGE_URL']);		
		$k++;
		}
		$sectionTree[]=implode(' -> ',$realNavChain);
	}
	
	/* if($_REQUEST['VIBOR']=='BARCODE'){
		$rsOffers = \CCatalogSKU::getOffersList(
		   $elementId,
		   $element_id['IBLOCK_ID'],
		   $skuFilter = array(),
		   $fields = array('NAME','CATALOG_QUANTITY','ACTIVE','PROPERTY_CML2_BAR_CODE'),
		   $propertyFilter = array()
		);
	}else{ */
	$rsOffers=array();
	if (Loader::includeModule('catalog')) {
		$rsOffers = \CCatalogSKU::getOffersList(
		   $elementId,
		   $element_id['IBLOCK_ID'],
		   $skuFilter = array(),
		   $fields = array('NAME','CATALOG_QUANTITY','ACTIVE'),
		   $propertyFilter = array()
		);		
	}
	//}
	//echo "<pre style='text-align:left;'>";print_r($rsOffers);echo "</pre>";
	
	
	if(!empty($_REQUEST['VIEW']) && $_REQUEST['VIEW']=='Y'){
	$trees=getTree($sectionTree2);
	//Получаем HTML разметку
	$cat_menu = showCat($trees);
	}
}

?>


<div class="crm-admin-wrap">
<?if(!empty($_REQUEST['CODE'])){?>
	 <?echo '<div style="'.($element_id['ACTIVE']=="N"?"opacity:0.5":"").'" title="'.($element_id['ACTIVE']=="N"?GetMessage("TGARL_DEREVO_NACTIVE_EL"):GetMessage("TGARL_DEREVO_ACTIVE_EL")).'">'.GetMessage("TGARL_DEREVO_EL").': <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='.$element_id['IBLOCK_ID'].'&type='.$element_id['IBLOCK_TYPE_ID'].'&ID='.$element_id['ID'].'&lang=ru" target="_blank">'.$element_id['NAME'].'</a> ( CODE => '.$element_id['CODE'].', ID => '.$element_id['ID'].', <span style="color:#2a9638">OSNOVNOI_RAZDEL =>'.$element_id['IBLOCK_SECTION_ID'].'</span> )</div><br><hr><br>';?>

	<?if(!empty($_REQUEST['VIEW']) && $_REQUEST['VIEW']=='Y'){?>
		<div class="tree"><ul><?=$cat_menu?></ul></div>
		<?if(empty($_REQUEST['READ'])){?>
		<style>	

		.tree ul {
		  position: relative;
		  padding: 1em 0;
		  white-space: nowrap;
		  margin: 0 auto;
		  text-align: center;
		}
		.tree ul::after {
		  content: '';
		  display: table;
		  clear: both;
		}

		.tree li {
		  display: inline-block;
		  vertical-align: top;
		  text-align: center;
		  list-style-type: none;
		  position: relative;
		  padding: 1em .5em 0 .5em;
		}
		.tree li::before, .tree li::after {
		  content: '';
		  position: absolute;
		  top: 0;
		  right: 50%;
		  border-top: 1px solid #ccc;
		  width: 50%;
		  height: 1em;
		}
		.tree li::after {
		  right: auto;
		  left: 50%;
		  border-left: 1px solid #ccc;
		}
		.tree li:only-child::after, .tree li:only-child::before {
		  display: none;
		}
		.tree li:only-child {
		  padding-top: 0;
		}
		.tree li:first-child::before, .tree li:last-child::after {
		  border: 0 none;
		}
		.tree li:last-child::before {
		  border-right: 1px solid #ccc;
		  border-radius: 0 5px 0 0;
		}
		.tree li:first-child::after {
		  border-radius: 5px 0 0 0;
		}

		.tree ul ul::before {
		  content: '';
		  position: absolute;
		  top: 0;
		  left: 50%;
		  border-left: 1px solid #ccc;
		  width: 0;
		  height: 1em;
		}

		.tree li a {
		  border: 1px solid #ccc;
		  padding: .5em .75em;
		  text-decoration: none;
		  display: inline-block;
		  border-radius: 5px;
		  color: #333;
		  position: relative;
		  top: 1px;
		  
		}

		.tree li a:hover,
		.tree li a:hover + ul li a {
		  background: #e9453f;
		  color: #fff;
		  border: 1px solid #e9453f;
		}

		.tree li a:hover + ul li::after,
		.tree li a:hover + ul li::before,
		.tree li a:hover + ul::before,
		.tree li a:hover + ul ul::before {
		  border-color: #e9453f;
		}
		</style>
		<?}else{?>
			<style>
				.tree {
				  position: relative;
				}

				.tree ul ul{
				  position: relative;
				  margin-left: 232px;
				}
				.tree ul ul:before {
				  content: "";
				  width: 50px;
				  border-top: 2px solid #eee9dc;
				  position: absolute;
				  left: -60px;
				  top: 50%;
				  margin-top: 1px;
				}

				.tree li {
				  position: relative;
				  min-height: 60px;
				  list-style: none;
				}
				.tree li:before {
				  content: "";
				  height: 100%;
				  border-left: 2px solid #eee9dc;
				  position: absolute;
				  left: -50px;
				}
				.tree li:after {
				  content: "";
				  width: 50px;
				  border-top: 2px solid #eee9dc;
				  position: absolute;
				  left: -50px;
				  top: 50%;
				  margin-top: 1px;
				}
				.tree li:first-child:before {
				  width: 10px;
				  height: 50%;
				  top: 50%;
				  margin-top: 2px;
				  border-radius: 10px 0 0 0;
				}
				.tree li:first-child:after {
				  height: 10px;
				  border-radius: 10px 0 0 0;
				}
				.tree li:last-child:before {
				  width: 10px;
				  height: 50%;
				  border-radius: 0 0 0 10px;
				}
				.tree li:last-child:after {
				  height: 10px;
				  border-top: none;
				  border-bottom: 2px solid #eee9dc;
				  border-radius: 0 0 0 10px;
				  margin-top: -9px;
				}
				.tree li.sole:before {
				  display: none;
				}
				.tree li.sole:after {
				  width: 50px;
				  height: 0;
				  margin-top: 1px;
				  border-radius: 0;
				}

				.tree a {
				  display: block;
				  min-width: 150px;
				  padding: 5px 10px;
				  line-height: 20px;
				  text-align: center;
				  border: 2px solid #eee9dc;
				  border-radius: 5px;
				  position: absolute;
				  left: 0;
				  top: 50%;
				  margin-top: -15px;
				}

			</style>
		<?}?>

		<?if(!empty($_REQUEST['ROTATE']) && $_REQUEST['ROTATE']=='Y' && empty($_REQUEST['READ'])){?>

			<style>
			.tree {
			  -webkit-transform: rotate(180deg);
					  transform: rotate(180deg);
			  -webkit-transform-origin: 50%;
					  transform-origin: 50%;
			}
			.tree li a {
				-webkit-transform: rotate(180deg);
				  transform: rotate(180deg);
			}
			</style>
		<?}?>

	<?}else{?>
		<?echo "<pre>";print_r($sectionTree);echo "</pre>";?>	
		<?if(!empty($rsOffers[$elementId])){
			echo '<br>'.GetMessage("TGARL_DEREVO_TP").':<br><ul>';
			foreach($rsOffers[$elementId] as $vl){
				?>
				<li>
					<?=$vl['NAME']?> - <?=$vl['CATALOG_QUANTITY']?><?=GetMessage("TGARL_DEREVO_ED")?>
					<?/* if($_REQUEST['VIBOR']=='BARCODE'){
						echo '; ( Штрихкод: ';
						if($vl['PROPERTY_CML2_BAR_CODE_VALUE']==$_REQUEST['CODE']){
							?><span style="color:#2a9638;font-weight:bold;"><?=$vl['PROPERTY_CML2_BAR_CODE_VALUE']?></span><?
						}else{
							echo $vl['PROPERTY_CML2_BAR_CODE_VALUE'];
						}
						echo' )';
					} */?>
				</li>
				<?				
			}
			echo'</ul>';
		}?>
	<?}?>
	<br><br><a href="<?=$APPLICATION->GetCurPageParam("lang=ru", array("lang","CODE","VIEW","VIBOR","ROTATE","READ"))?>"><?=GetMessage("TGARL_DEREVO_BACK")?></a> <a href="<?=$element_id['DETAIL_PAGE_URL']?>" target="_blank" style="float: right;display: block;"><?=GetMessage("TGARL_DEREVO_SEE_EL")?></a>
<?}else{?>
	<script  type="text/javascript">
	 $(function () {
		 $("#selall").click(function  () {
			 if  (!$("#selall").is(":checked")){ 
				  $(".see_dop_fn input").prop('disabled', true);; 
			}
			else{
				 $(".see_dop_fn input").prop('disabled', false);; 
		   }
		 });
	});
	</script> 
	<form action='' method='get'>
	<input type='hidden' name='lang' value='ru' >
	<input type='text' name='CODE' value='' placeholder='<?=GetMessage("TGARL_DEREVO_ENTER_CODE")?>'> <select name='VIBOR'><option value='ID'>ID</option><option value='CODE'>CODE</option><select><br>
	<label><input type='checkbox' name='VIEW' value='Y' id="selall"> <?=GetMessage("TGARL_DEREVO_VIEW")?> <span style="color:#ccc;">(<?=GetMessage("TGARL_DEREVO_VIEW_PS")?>)</span></label><br>
	<div class="see_dop_fn"><?=GetMessage("TGARL_DEREVO_SEE_DOP_FN")?><br><br>
	<label><input type='checkbox' name='ROTATE' value='Y' disabled> <?=GetMessage("TGARL_DEREVO_NV")?></label><br>
	<label><input type='checkbox' name='READ' value='Y' disabled> <?=GetMessage("TGARL_DEREVO_SP")?></label><br><br>
	</div>
	<input type='submit' value='<?=GetMessage("TGARL_DEREVO_SEARCH")?>'>
	</form>
<?}?>
</div>
<style>
.crm-admin-wrap {
    font-family: Arial, sans-serif;
    font-size: 12px;
    padding: 15px;
    background: #fff;
    border: solid 1px #C5CECF;
    border-radius: 4px;
}
.see_dop_fn {padding:10px 0 0 2em;}	
#selall span{color:#ccc;}
</style>


<?
echo BeginNote();
echo GetMessage("TGARL_DEREVO_DESCR");
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>