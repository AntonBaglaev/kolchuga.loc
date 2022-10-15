<?php
IncludeModuleLangFile(__FILE__);

class tgarl_derevo_pr
{
	function DoBuildGlobalMenuPr(&$aGlobalMenu, &$aModuleMenu) {
		if (empty($aGlobalMenu["global_menu_tgarl"])){
		$aGlobalMenu["global_menu_tgarl"] = array(
				 "menu_id" => "tgarl",
				 "page_icon" => "services_title_icon",
				 "index_icon" => "services_page_icon",
				 "text" => GetMessage("GLOBAL_MENU_TITLE_TGARL"),
				 "title" => "tgarl razdel",
				 "sort" => 900,
				 "items_id" => "global_menu_tgarli",
				 "help_section" => "custom",
				 "items" => array()
		   );		
		}
	}
	function OnPanelCreateHandler()
    {
        global $APPLICATION, $USER;
		if(!is_object($USER)){
			 $USER = new CUser();
		}
		if ($USER->IsAdmin()){
			$ur='';
			$srcs='/bitrix/tools/tgarl_derevo/tree50s.png';
			if(!empty($_SERVER['ELEMENT_ID'])){
				$ur='&CODE='.$_SERVER['ELEMENT_ID'].'&VIBOR=ID'; 
				$srcs='/bitrix/tools/tgarl_derevo/tree50.png';
			}elseif(!empty($_SERVER['ELEMENT_CODE'])){
				$ur='&CODE='.$_SERVER['ELEMENT_CODE'].'&VIBOR=CODE'; 
				$srcs='/bitrix/tools/tgarl_derevo/tree50.png';
			}else{
				$str_url=explode('?',$_SERVER['REQUEST_URI']);
				$code = array_pop(array_filter(explode( '/',  $str_url[0])));
				\CModule::IncludeModule("iblock");
				$rsEl = \CIBlockElement::GetList(array(),array('=CODE' => $code),false,false,array('ID'));
				if($rsEl->Fetch() !== false){
					$ur='&CODE='.$code.'&VIBOR=CODE'; 
					$srcs='/bitrix/tools/tgarl_derevo/tree50.png';
				}else{
					$rsEl2 = \CIBlockElement::GetList(array(),array('=ID' => $code),false,false,array('ID'));
					if($rsEl2->Fetch() !== false){
						$ur='&CODE='.$code.'&VIBOR=ID'; 
						$srcs='/bitrix/tools/tgarl_derevo/tree50.png';
					}
				}
				
			}			
			
			$arDialogParams =   array(
				'content_url'   => '/bitrix/admin/tgarl_derevo.php?lang=ru'.$ur,
				'title'         => "TREE",
				'resizable'     => true,
				'draggable'     => true,
				'content_post'  => '',
			);
			$defaultUrl   =   '(new BX .CDialog('.CUtil::PhpToJsObject($arDialogParams).')).Show()';

			$APPLICATION->AddPanelButton(array(
				"HREF"      => "/bitrix/admin/tgarl_derevo.php?lang=ru".$ur, // ссылка на кнопке
				//"HREF"=>"javascript:".$defaultUrl,
				//"ACTION"=> "javascript:".$defaultUrl,
				"SRC"       => $srcs, // картинка на кнопке
				"ALT"       => "Tree", 
				"MAIN_SORT" => 9300, 
				"SORT"      => 100,
				"TYPE"      => 'BIG',
				"TEXT"      => "TREE",
				"DEFAULT"   => false,
			));
		}
    }
}
?>