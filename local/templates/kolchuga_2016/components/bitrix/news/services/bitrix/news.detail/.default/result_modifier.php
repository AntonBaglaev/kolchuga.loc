<?php
/****************************************************************************** start ********************************************/
		if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){
			$elget=\Kolchuga\DopViborka::getItemInDopolnitelno(
					$param=array(
						'IBLOCK_ID'=>$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['LINK_IBLOCK_ID'], 
						'SELECT'=>Array('ID','PROPERTY_address','PROPERTY_phones','PROPERTY_phones_service','PROPERTY_masterskaya','PROPERTY_DOP_DESCRIPTION')
					),
					$item=$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'],
					$dop=array('NOPRICE'=>'Y')
				);
				
			foreach($elget["DOPOLNITELNO"] as $id=>$arEl){
				$pos = strpos($arEl['PROPERTY_ADDRESS_VALUE'], 'Москва');
				if ($pos === false) {
					$arEl['IN']='';
					$arEl['PROPERTY_ADDRESS_SRC']=$arEl['PROPERTY_ADDRESS_VALUE'];
				}else{
					$arEl['IN']='MSK';
					$lk=explode(',',$arEl['PROPERTY_ADDRESS_VALUE']);
					unset($lk[0]);
					$arEl['PROPERTY_ADDRESS_SRC']=trim( implode(',',$lk) );
				}
				$elget["DOPOLNITELNO"][$id]=$arEl;
			}	
			$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']["DOPOLNITELNO"]=$elget["DOPOLNITELNO"];			
		}
/****************************************************************************** end ********************************************/


/****************************************************************************** start ********************************************/
		if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'])){
			
			$elget=\Kolchuga\DopViborka::getItemInDopolnitelno(
					$param=array(
						'FILTER'=>array('!PROPERTY_ANONS'=>false, '!PREVIEW_PICTURE'=>false), 
						'SELECT'=>Array('ID','PROPERTY_ANONS')
					),
					$item=$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'],
					$dop=array('NOPRICE'=>'Y')
				);
			$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"]=$elget["DOPOLNITELNO"];
		}
/****************************************************************************** end ********************************************/


/****************************************************************************** start ********************************************/
		if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE'])){
			$elget=\Kolchuga\DopViborka::getItemInDopolnitelno(
					$param=array('IBLOCK_ID'=>$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_IBLOCK_ID'], 'TYPE_PRICE'=>array('Розничная'), 'SELECT'=>Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL','NAME')),
					$item=$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE']
				);
				
			$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"]=$elget["DOPOLNITELNO"];	
		}
/****************************************************************************** end ********************************************/


/****************************************************************************** start ********************************************/
		if(isset($arParams['SHOW_NEWS_ALWAYS']) && $arParams['SHOW_NEWS_ALWAYS']=='Y'){
			$vl=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'];
			$vl_n=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME'];
			$arResult['DISPLAY_PROPERTIES']['REKOMEND']=[];
			$arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE']=$vl;
			$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME']=$vl_n;

			$intIblock = $arParams['IBLOCK_ID'] > 0 ? intval($arParams['IBLOCK_ID']) : 1;

			$dbEl = \CIBlockElement::GetList(array('id' => 'desc'), array('IBLOCK_ID' => $intIblock, '!ID'=>$arResult['ID'], '>SORT'=>10, 'ACTIVE'=>'Y' ), false, array('nTopCount'=>3), Array('ID','ACTIVE_FROM','DETAIL_PAGE_URL','NAME','ACTIVE_FROM', 'SHOW_COUNTER'));
				while($arEl = $dbEl->GetNext())	
				{		
					$arEl['DATA_FORMAT']=FormatDate("d/m/Y", MakeTimeStamp($arEl["ACTIVE_FROM"]), time());
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'][$arEl['ID']]=[
						'NAME'=>$arEl['NAME'],
						'DETAIL_PAGE_URL'=>$arEl['DETAIL_PAGE_URL'],
						'ID'=>$arEl['ID']
					];
				}
		}elseif(!empty($arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'])){
			foreach($arResult['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'] as $idR=>$vlR){
				$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $vlR['IBLOCK_ID'], 'ID'=>$idR ), false, false, Array('ID','ACTIVE_FROM', 'SHOW_COUNTER'));
				while($arEl = $dbEl->Fetch())	
				{		
					$arEl['DATA_FORMAT']=FormatDate("d/m/Y", MakeTimeStamp($arEl["ACTIVE_FROM"]), time());
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
				}
			}
		}elseif(isset($arParams['SHOW_NEWS_ALWAYS']) && $arParams['SHOW_NEWS_ALWAYS']=='N'){
			$vl_n=$arResult['PROPERTIES']['REKOMEND']['NAME'];
			$arResult['DISPLAY_PROPERTIES']['REKOMEND']=[];
			$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME']=$vl_n;
			$dbEl = \CIBlockElement::GetList(array('id' => 'desc'), array('IBLOCK_ID' => 1, '!ID'=>$arResult['ID'], '>SORT'=>10, 'ACTIVE'=>'Y' ), false, array('nTopCount'=>3), Array('ID','ACTIVE_FROM','DETAIL_PAGE_URL','NAME','ACTIVE_FROM', 'SHOW_COUNTER'));
				while($arEl = $dbEl->GetNext())	
				{		
					$arEl['DATA_FORMAT']=FormatDate("d/m/Y", MakeTimeStamp($arEl["ACTIVE_FROM"]), time());
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']['LINK_ELEMENT_VALUE'][$arEl['ID']]=[
						'NAME'=>$arEl['NAME'],
						'DETAIL_PAGE_URL'=>$arEl['DETAIL_PAGE_URL'],
						'ID'=>$arEl['ID']
					];
					$arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'][]=$arEl['ID'];
				}
		}
/****************************************************************************** end ********************************************/


/****************************************************************************** start ********************************************/
		if(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'])){
				
				$elget=\Kolchuga\DopViborka::getItemInDopolnitelno(
					$param=array(
						'IBLOCK_ID'=>40, 
						'TYPE_PRICE'=>array('Розничная'), 
						'SELECT'=>Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL','NAME','ACTIVE', 'XML_ID','PROPERTY_IDGLAVNOGO')
					),
					$item=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'], 
					$dop=array('ARXMLIDGL'=>'Y')
				);
				//\Kolchuga\Settings::xmp($elget,11460, __FILE__.": ".__LINE__);
				$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"]=$elget["DOPOLNITELNO"];
				$arXmlIDGl=$elget["ARXML"];
				
				$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['SKU2'] = \Kolchuga\DopViborka::getItemRazmerSku($arXmlIDGl);	
				
				
				$metki=[];
				foreach($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['DESCRIPTION'] as $kl=>$vl){
					if(empty($metki[$vl])){$metki[$vl]=[];}
					$zn=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'][$kl];
					if($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$zn]['CATALOG_AVAILABLE']!='Y'){continue;}
					if($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$zn]['ACTIVE']!='Y'){continue;}
					$metki[$vl][]=$zn;
				}
				$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["METKI"]=$metki;
				
				$table_code='';
				$table_price='';
				$i=0;
				foreach($metki as $mt=>$vl){
					$pos = strpos($mt, 'slider_');
					if ($pos !== false) {
						
						$table_code='<div style=""><div class="owl-carousel owl-theme slider_set">';
						foreach($vl as $valid){	
							$table_code.='<div class="recommend__item">            
								<div class="recommend__img">
									<a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'">
										<img src="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC'].'" >
									</a>							
								</div>
								<div class="recommend__title">
									<a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'">'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME'].'</a>
								</div>
								<div class="recommend__price">
									<span>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <br><del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].'</del>':'').'</span>
								</div>
							</div>';
						}
				
						$table_code.='</div></div>';
						$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]='';
						$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
					}else{
						if(empty($arParams['TEML_DISCOUNT'])){
							$table_code.='<table align="center" width="90%" cellspacing="10" class="'.$mt.'"><tbody>';
							$table_code.='<tr>';
							$table_price.='<tr>';
							foreach($vl as $valid){
							$table_code.='<td align="center"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC_ORIG'].'" target="_blank" class="popup"><img src="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC'].'"></a></td>';
							$table_price.='<td align="center"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" target="_blank">'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME'].'<br>
						'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].'</del>':'').'</a></td>';
							$i++;
							if($i==3){$table_code.='</tr>'; $table_price.='</tr>';$table_code.=$table_price; $table_price='<tr>'; $table_code.='<tr>';$i=0;}
							}
							if($i<3 && $i>0){
								$table_code.='</tr>'; $table_price.='</tr>';$table_code.=$table_price; 
							}
							
							$table_code.='</tbody></table>';
							
							$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
							$table_code='';
							$table_price='';
							$i=0;
						}elseif($arParams['TEML_DISCOUNT']=='beretta'){
							$table_code=include(dirname(__FILE__).'/templ_discount_beretta.php');					
							$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
						}else{
							$table_code='<div class="row"><section class="container-fluid '.$mt.'"><div class="row" style="justify-content: center;">';
							$colonok=count($vl);
							foreach($vl as $valid){
								/*$table_code.='<div class="kolonk_'.$colonok.' col-sm-6 col-md-4 '.($colonok==1 ? 'offset-sm-3 offset-md-4' : ($colonok==2 ? 'offset-md-2':'') ).' text-center teml_discount">*/
								$table_code.='<div class="kolonk_'.$colonok.' col-sm-6 col-md-4 text-center teml_discount">
									<div class="item">
									<a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" style="background: transparent url('.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PICTURE_SRC'].') center center /contain no-repeat;" class="imgitem" ></a>
									<div class="textitem"><a href="'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['DETAIL_PAGE_URL'].'" target="_blank">'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['NAME'].'</a></div>
									'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'].(!empty($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'])? ' <del>'.$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$valid]['PROPERTY_OLD_PRICE_VALUE'].'</del>':'').'
									</div>						
								</div>';
								unset($colonok);
							}
					
							$table_code.='</div></section></div>';
							$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt]=$table_code;
						}
					}
				}
				
				foreach($metki as $mt=>$vl){
					$arResult["DETAIL_TEXT"]=str_replace('#'.$mt.'#',$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["HTML_METKI"][$mt],$arResult["DETAIL_TEXT"]);
				}
				
			}
/****************************************************************************** end ********************************************/


/****************************************************************************** start ********************************************/	
		if(!empty($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"]))
		{
			$arResult["GALLERY"] = array();
			$arWaterMark = Array();
			foreach($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"] as $k => $arImages)
			{
				$img_lg = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1600), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, 85);
				$arResult["GALLERY"][$k]["SRC_LG"] = $img_lg['src'];
				//$img_xs = CFile::ResizeImageGet($arImages, array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
				$img_xs = CFile::ResizeImageGet($arImages, array('width'=>450, 'height'=>400), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, 100);
				$arResult["GALLERY"][$k]["SRC_XS"] = $img_xs['src'];
				$arResult["GALLERY"][$k]["DESC"] = (isset($arResult["PROPERTIES"]["NEWS_GALLERY"]["~DESCRIPTION"][$k]{0}))? $arResult["PROPERTIES"]["NEWS_GALLERY"]["~DESCRIPTION"][$k]:"";
			}
			unset($img_big, $img_min);
			if(!empty($arResult["PROPERTIES"]["METKA_GALLERY"]["VALUE"])){
				$metka_gal='';
				if(strlen($arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["~VALUE"])>0){   
					$metka_gal.='<div class="text-content"><h2>'.$arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["~VALUE"].'</h2></div>';
				}
				$kolgaler=count($arResult["GALLERY"]);
				$metka_gal.='<div class="gallery-block gallery">
							<div class="row">';							
								foreach($arResult["GALLERY"] as $k => $arImage){
										$metka_gal.='<div class="col-md-4 mb-5 col-sm-6">';

										$metka_gal.='<a data-gallery="gallery-news-'.$arResult["ID"].'" href="'.$arImage["SRC_LG"].'" title="'.$arImage["DESC"].'" class="cursor-loop fancybox" data-fancybox-group="gallery-news-'.$arResult["ID"].'">
											<img src="' . $arImage['SRC_XS'] . '" alt="">
										</a>
									</div>';
								}
							$metka_gal.='</div>										
						</div>';
				$arResult["DETAIL_TEXT"]=str_replace($arResult["PROPERTIES"]["METKA_GALLERY"]["VALUE"],$metka_gal,$arResult["DETAIL_TEXT"]);
				unset($arResult["GALLERY"]);
			}
		}
/****************************************************************************** end ********************************************/	


/****************************************************************************** start ********************************************/	
		$arrXmlId=["all"];
		$arrXmlId[]=$arResult['IBLOCK_TYPE_ID'];
		$property_enums = \CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>74, "XML_ID"=>$arrXmlId));
		$fil_where=[];
		while($enum_fields = $property_enums->GetNext()){
			$fil_where[]=$enum_fields["ID"];
		}
		$arResult['RECOMEND_BLOCK_BANNER']=[];
		$res = \CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>74, "=PROPERTY_WHERE_SEE"=>$fil_where, 'ACTIVE'=>'Y'), false, false, array("ID", "NAME",'PROPERTY_LINK','PREVIEW_PICTURE','PROPERTY_FOR_ELEMENT'));
		while($arEl = $res->GetNext())	
		{
			if(!empty($arEl['PROPERTY_FOR_ELEMENT_VALUE']) && $arEl['PROPERTY_FOR_ELEMENT_VALUE']!=$arResult['ID']){continue;}
			$arResult['RECOMEND_BLOCK_BANNER'][]=$arEl;
		}
/****************************************************************************** end ********************************************/	
?>
<?/*<!--pre><?print_r($arResult['RECOMEND_BLOCK_BANNER']);?></pre-->*/?>
<?//echo "<pre>";print_r($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']);echo "</pre>";die;?>

<?
$arSliderPhotos = [];
if (!empty($arResult["PROPERTIES"]["NEWS_SLIDER"]['VALUE'])) {
	foreach ($arResult["PROPERTIES"]["NEWS_SLIDER"]['VALUE'] as $arPhoto) {
		if ($arPhoto)
			$arSliderPhotos[] = (\CFile::ResizeImageGet($arPhoto, array('width' => 660, 'height' => 450), BX_RESIZE_IMAGE_PROPORTIONAL, true))['src'];
	}
}

$arResult['SLIDER_PHOTOS'] = $arSliderPhotos ? $arSliderPhotos : [];
?>
