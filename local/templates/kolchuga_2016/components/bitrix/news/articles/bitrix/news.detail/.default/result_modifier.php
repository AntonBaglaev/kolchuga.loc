<?php
//if($_REQUEST['adm']=='Y'){
	
	if(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'])){
		$arConvertParams=array();
		CModule::IncludeModule('catalog');
		$res = \CIBlockPriceTools::GetCatalogPrices(40, array('Розничная', ));
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'ID'=>$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'], ), false, false, Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL','NAME'));
		//$res->SetUrlTemplates("#SITE_DIR#/internet_shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/");
		while($arEl = $dbEl->GetNext())	
		{				
			
			$arEl["PRICES"] = array();
			$arEl["PRICE_MATRIX"] = false;
			$arEl['MIN_PRICE'] = false;		
			$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices(40, $res, $arEl);
			if (!empty($arEl['PRICES']))
				$arEl['MIN_PRICE'] = \CIBlockPriceTools::getMinPriceFromList($arEl['PRICES']);		

			if(!empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
				$pos = strpos($arEl['PROPERTY_OLD_PRICE_VALUE'], 'руб');
				if ($pos === false) {
					$arEl['PROPERTY_OLD_PRICE_VALUE'].=' руб';
				}
			}
			
			 if($arEl['MIN_PRICE']['VALUE'] > 0 && $arEl['MIN_PRICE']['DISCOUNT_VALUE'] < $arEl['MIN_PRICE']['VALUE'] && empty($arEl['PROPERTY_OLD_PRICE_VALUE'])){
			  $arEl['PROPERTY_OLD_PRICE_VALUE'] = $arEl['MIN_PRICE']['PRINT_VALUE'];			  
			}
			
			
			if(!empty($arEl['DETAIL_PICTURE'])){
				$arEl['DETAIL_PICTURE_SRC_ORIG']=CFile::GetPath($arEl["DETAIL_PICTURE"]);
				$arEl['DETAIL_PICTURE_SRC']=CFile::ResizeImageGet(
												$arEl['DETAIL_PICTURE'],
												array('width' => 300, 'height' => 300),
												BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60
											)['src'];
			}

			$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
		}
		/*?><script>console.log(<?echo json_encode($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"])?>);</script><?*/
		$metki=[];
		foreach($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['DESCRIPTION'] as $kl=>$vl){
			$metki[$vl][]=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'][$kl];
		}
		$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["METKI"]=$metki;
		
		$table_code='';
		$table_price='';
		$i=0;
		$musoony='Y';
		foreach($metki as $mt=>$vl){
			if($musoony!='Y'){
			$table_code.='<table align="center" width="90%" cellspacing="10" class="'.$mt.'"><tbody>';
			$table_code.='<tr>';
			$table_price.='<tr>';
			foreach($vl as $valid){
				$procent='';
				if(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])){
					$procent=(round(100-(intval($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['DISCOUNT_VALUE'])*100/intval(preg_replace("/[^0-9]/", '', $arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])))));
				}
				
			$table_code.='<td align="center"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC_ORIG'].'" target="_blank" class="popup" '.($procent>0?"style='position:relative;display:inline-block;'":"").'>'.($procent>0?"<div class='procent_skidki_boll'>-".$procent."%</div>":"").'<img src="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC'].'"></a></td>';
			$table_price.='<td align="center"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" target="_blank">'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME'].'<br>
		'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].'</del>':'').'</a>
	</td>';
			$i++;
			if($i==3){$table_code.='</tr>'; $table_price.='</tr>';$table_code.=$table_price; $table_price='<tr>'; $table_code.='<tr>';$i=0;}
			}
			if($i<3 && $i>0){
				$table_code.='</tr>'; $table_price.='</tr>';$table_code.=$table_price; 
			}
			/*$table_price.='</tr>';
			$table_code.='</tr>';*/
			$table_code.='</tbody></table>';
			
			$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
			$table_code='';
			$table_price='';
			$i=0;
			}else{
				$table_code='<div class="row"><section class="container-fluid '.$mt.'"><div class="row">';
					$colonok=count($vl);
					foreach($vl as $valid){
						$procent='';
						if(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])){
							$procent=(round(100-(intval($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['DISCOUNT_VALUE'])*100/intval(preg_replace("/[^0-9]/", '', $arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])))));
						}
						
						$table_code.='<div class="kolonk_'.$colonok.' col-sm-6 col-md-4 '.($colonok==1 ? 'offset-sm-3 offset-md-4' : ($colonok==2 ? 'offset-md-2':'') ).' text-center teml_discount">
							<div class="item">
							
							<a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" style="background: transparent url('.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC'].') center center /contain no-repeat;" class="imgitem" >'.($procent>0?"<div class='procent_skidki_boll'>-".$procent."%</div>":"").'</a>
							<div class="textitem"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" target="_blank">'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME'].'</a></div>
							'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].' руб</del>':'').'
							</div>						
						</div>';
						unset($colonok);
					}
			
					$table_code.='</div></section></div>';
					$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
			}
		}
		
		foreach($metki as $mt=>$vl){
			$arResult["DETAIL_TEXT"]=str_replace('#'.$mt.'#',$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt],$arResult["DETAIL_TEXT"]);
		}
		
	}
	//$arResult["DETAIL_TEXT"]
	//echo "<pre>";print_r($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']);echo "</pre>";die;
//}
