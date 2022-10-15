<?php

namespace Roztech\Tools;

use bh\service\settings;
//use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;
use Bitrix\Main\Context;

//use Bitrix\Main\Diag\Debug;

//require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

/**
 * Class SomeTabset
 * @package Roztech\Tools
 */
class SomeTabset 
{
  function getTabList($elementInfo)
    {
         $request = Context::getCurrent()->getRequest();
        if($elementInfo['ID'] > 0 && $elementInfo['IBLOCK']['ID'] == 40 && (!isset($request['action']) || $request['action'] != 'copy')){ 		
			return [
				[
					"DIV"   => 'maximaster_some_tab40',
					"SORT"  => PHP_INT_MAX,
					"TAB"   => 'Дерево разделов',
					"TITLE" => 'Дерево разделов',
				],
			];
		}else{
			return null;
		}
    }
 
    function showTabContent($div, $elementInfo, $formData)
		{
		?><tr>
		<td>
		<?
		Loader::includeModule('iblock');
		
			$elementId=$elementInfo['ID'];
		if ($div == "maximaster_some_tab40"){
			$element_id0 = \CIBlockElement::GetList(null, Array('ID' => $elementId), false , false,array('ID','IBLOCK_ID','IBLOCK_TYPE_ID','NAME','CODE','IBLOCK_SECTION_ID','DETAIL_PAGE_URL','ACTIVE'));
			while($element_id1 = $element_id0->GetNext()){
				$element_id = $element_id1;
			}
		}		
			$db_old_groups = \CIBlockElement::GetElementGroups($elementId, true);
			while($ar_group = $db_old_groups->Fetch()){
				$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
				$realNavChain = array();
				$k=0;
				while ($arNav=$navChain->GetNext()){
					if ($arNav['ID']==$element_id['IBLOCK_SECTION_ID']){
						$realNavChain[]=$arNav['NAME'].'<strong style="color:#2a9638">('.$arNav['ID'].' - '.$arNav['CODE'].')</strong>';
					}else{
						$realNavChain[]=$arNav['NAME'].'('.$arNav['ID'].' - '.$arNav['CODE'].')';
					}
					$sectionTree2[$arNav['ID']]=array('NAME'=>$arNav['NAME'],"ID"=>$arNav['ID'],"PARENT"=>$arNav['IBLOCK_SECTION_ID'],'URL'=>$arNav['SECTION_PAGE_URL']);		
				$k++;
				}
				$sectionTree[]=implode(' -> ',$realNavChain);
			}
			
		
		$trees=self::getTree($sectionTree2);
	//Получаем HTML разметку
	$cat_menu = self::showCat($trees);
		?>
		
		
		<div class="tree"><ul><?=$cat_menu?></ul></div>
		<?if ($div == "maximaster_some_tab40"){?>		
			<?
			echo '<br><hr style="border-color: #ccc;"><br>';
			echo '<div style=""><br><strong>Элемент на сайте</strong>: <a href="'.$element_id['DETAIL_PAGE_URL'].'" target="_blank">Посмотреть</a></div>';
			
			
		}?>
		
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
		</td>
		</tr><?
		}
		
 
    function check()
    {
        return true;
    }
 
    function action()
    {
        return true;
    }
	public function getTab()
	{
	$tabset = new \Roztech\Tools\SomeTabset();
	return [
	'TABSET' => 'tabset_cust',
	'Check' => [$tabset, 'check'],
	'Action' => [$tabset, 'action'],
	'GetTabs' => [$tabset, 'getTabList'],
	'ShowTab' => [$tabset, 'showTabContent']
	];
	}
	function getTree($dataset) {
		$tree = array();

		foreach ($dataset as $id => &$node) {    
			//Если нет вложений
			if (!$node['PARENT']){
				$tree[$id] = &$node;
			}else{ 
				//Если есть потомки то перебераем массив
				$dataset[$node['PARENT']]['childs'][$id] = &$node;
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
				$menu .= '<ul>'. self::showCat($category['childs']) .'</ul>';
			}
		$menu .= '</li>';
		
		return $menu;
	}

	/**
	* Рекурсивно считываем наш шаблон
	**/
	function showCat($data){
		$string = '';
		$cont=count($data);
		foreach($data as $item){
			$string .= self::tplMenu($item, $cont);
		}
		return $string;
	}
}