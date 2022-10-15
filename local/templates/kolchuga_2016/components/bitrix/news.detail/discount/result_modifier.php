<?php
$cp = $this->__component; // объект компонента

if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'])){
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['LINK_IBLOCK_ID'], 'ID'=>$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']['VALUE'], ), false, false, Array('ID','PROPERTY_address','PROPERTY_phones','PROPERTY_phones_service','PROPERTY_masterskaya','PROPERTY_DOP_DESCRIPTION'));
	while($arEl = $dbEl->Fetch())	
	{
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
		$arResult['DISPLAY_PROPERTIES']['NEXT_SALON']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
	}
}

if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'])){
	
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array(/* 'IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['LINK_IBLOCK_ID'], */ 'ID'=>$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']['VALUE'], '!PROPERTY_ANONS'=>false, '!PREVIEW_PICTURE'=>false), false, false, Array('ID','PROPERTY_ANONS'));
	while($arEl = $dbEl->Fetch())	
	{		
		$arResult['DISPLAY_PROPERTIES']['NEXT_SERVICE']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
	}
	
}

if(!empty($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE'])){
	$arConvertParams=array();
	\CModule::IncludeModule('catalog');
	$res = \CIBlockPriceTools::GetCatalogPrices($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_IBLOCK_ID'], array('Розничная', ));
	$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_IBLOCK_ID'], 'ID'=>$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['VALUE'], ), false, false, Array('ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL','NAME'));
	while($arEl = $dbEl->GetNext())	
	{				
		
		$arEl["PRICES"] = array();
		$arEl["PRICE_MATRIX"] = false;
		$arEl['MIN_PRICE'] = false;		
		$arEl["PRICES"] = \CIBlockPriceTools::GetItemPrices($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']['LINK_IBLOCK_ID'], $res, $arEl, true, $arConvertParams, $USER->GetID(), 's1');
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
			
			/*$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
				$arEl['ID'], // ID товара
				$USER->GetUserGroupArray(), // Укажем группу пользователя для проверки прав доступа к скиде
				"N",
				$arEl['MIN_PRICE']['PRICE_ID'], // тип цены BASE
				's1'
			);
			$arEl['MIN_PRICE']['VD_DISCOUNT_PARAMS'] = $arDiscounts;*/
		
		if(!empty($arEl['DETAIL_PICTURE'])){
			$arEl['DETAIL_PICTURE_SRC']=CFile::ResizeImageGet(
                                            $arEl['DETAIL_PICTURE'],
                                            array('width' => 210, 'height' => 158),
                                            BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60
                                        )['src'];
		}

		$arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
	}
}
if(isset($arParams['SHOW_NEWS_ALWAYS']) && $arParams['SHOW_NEWS_ALWAYS']=='Y'){
	$vl=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE'];
	$vl_n=$arResult['DISPLAY_PROPERTIES']['REKOMEND']['NAME'];
	$arResult['DISPLAY_PROPERTIES']['REKOMEND']=[];
	$arResult['DISPLAY_PROPERTIES']['REKOMEND']['VALUE']=$vl;
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
			
			
/*?><!--pre>avail <?print_r($arEl);?></pre--><?*/
			$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
		}
		
		$metki=[];
		foreach($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['DESCRIPTION'] as $kl=>$vl){
			if(empty($metki[$vl])){$metki[$vl]=[];}
			$zn=$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']['VALUE'][$kl];
			if($arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["DOPOLNITELNO"][$zn]['CATALOG_AVAILABLE']!='Y'){continue;}
			$metki[$vl][]=$zn;
		}
		$arResult['DISPLAY_PROPERTIES']['TOVARS_IN_NEWS']["METKI"]=$metki;
		
		$table_code='';
		$table_price='';
		$i=0;
		foreach($metki as $mt=>$vl){
			$pos = strpos($mt, 'slider_');
			if ($pos !== false) {
				
				//$table_code='<div class="row"><section class="container-fluid '.$mt.'"><div class="row"><div class="col-12"><div class="owl-carousel owl-theme slider_set">';
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
        
				//$table_code.='</div></div></div></section></div>';
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
					/*$table_price.='</tr>';
					$table_code.='</tr>';*/
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
	
	if(!empty($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"]))
	{
		$arResult["GALLERY"] = array();
		$arWaterMark = Array();
        foreach($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"] as $k => $arImages)
		{
			$img_lg = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1600), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, 85);
			$arResult["GALLERY"][$k]["SRC_LG"] = $img_lg['src'];
			//$img_xs = CFile::ResizeImageGet($arImages, array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);
			$img_xs = CFile::ResizeImageGet($arImages, array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, 85);
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
								if($kolgaler>4 || $kolgaler % 4 == 0){
									$metka_gal.='<div class="col-md-3 col-sm-4 col-6 middle">';
								}elseif($kolgaler % 3 == 0){
									$metka_gal.='<div class="col-sm-4 col-6 middle">';
								}elseif($kolgaler % 2 == 0){
									$metka_gal.='<div class="col-6 middle">';
								}
									$metka_gal.='<a data-gallery="gallery-news-'.$arResult["ID"].'" href="'.$arImage["SRC_LG"].'" title="'.$arImage["DESC"].'" class="cursor-loop fancybox" data-fancybox-group="gallery-news-'.$arResult["ID"].'">
										<div class="gallery-img small-size lazyload" data-src="'.$arImage["SRC_XS"].'">
											<div class="corner-line"></div>
										</div>
									</a>
								</div>';
							}
						$metka_gal.='</div>										
					</div>';
			$arResult["DETAIL_TEXT"]=str_replace($arResult["PROPERTIES"]["METKA_GALLERY"]["VALUE"],$metka_gal,$arResult["DETAIL_TEXT"]);
			unset($arResult["GALLERY"]);
		}
	}
	
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
	
	
	if(!empty($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['VALUE'])){
		foreach($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION'] as $kl=>$vl){
			$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION'][$kl]=unserialize(html_entity_decode($vl,ENT_QUOTES));
		}
		
		$arConvertParams=array();
		\CModule::IncludeModule('catalog');
		$res = \CIBlockPriceTools::GetCatalogPrices(40, array('Розничная', ));
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'ID'=>$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['VALUE'], ), false, false, Array('ID','XML_ID','CATALOG_TYPE','DETAIL_PICTURE','PROPERTY_OLD_PRICE','CATALOG_GROUP_2','DETAIL_PAGE_URL','NAME','PROPERTY_IDGLAVNOGO'));
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
				$arEl['DETAIL_PICTURE_SRC_ORIG']=\CFile::GetPath($arEl["DETAIL_PICTURE"]);
				$arEl['DETAIL_PICTURE_SRC']=\CFile::ResizeImageGet(
												$arEl['DETAIL_PICTURE'],
												array('width' => 450, 'height' => 450),
												BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 80
											)['src'];
			}

			$arResult['PROPERTIES']['PRODUCTS_SEVERAL']["DOPOLNITELNO"][$arEl['ID']]=$arEl;
		}
		
		$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2']=[];	
		$arXmlIDGl=[];
		foreach($arResult['PROPERTIES']['PRODUCTS_SEVERAL']["DOPOLNITELNO"] as $key => $arItem){
			$arXmlIDGl[$arItem['ID']]=$arItem['XML_ID'];
		}
		//echo "<pre>";print_r($arXmlIDGl);echo "</pre>";
		
		$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID'=>40, 'PROPERTY_IDGLAVNOGO' => $arXmlIDGl, '>CATALOG_QUANTITY' => 0), false, false, Array('ID','CATALOG_QUANTITY','PROPERTY_IDGLAVNOGO'));
		while($obEl = $dbEl->Fetch()){
			$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['QUANTITY']=$obEl['CATALOG_QUANTITY'];
			$VALUES = array();
			$res = \CIBlockElement::GetProperty(40, $obEl['ID'], Array("sort"=>"asc"), array("CODE" => "RAZMER"));
			while ($ob = $res->GetNext()){			
				$VALUES[] = $ob['VALUE'];
			}		
			$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2'][$obEl['PROPERTY_IDGLAVNOGO_VALUE']][$obEl['ID']]['RAZMER']=$VALUES[0];
		}
		
		
		$massa=[];
		foreach($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION'] as $kl=>$vl){
			if(!empty($vl[2])){ $massa[$vl[1]]['GROUP']=$vl[2]; }
			$massa[$vl[1]]['INFO'][]=['KOL'=>$vl[0],'ID'=>$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['VALUE'][$kl]];			
		}
		//$arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION']=unserialize($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION']);
		/* echo "<pre>";print_r($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['SKU2']);echo "</pre>";
		echo "<pre>";print_r($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DOPOLNITELNO']);echo "</pre>";
		echo "<pre>";print_r($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['VALUE']);echo "</pre>";
		echo "<pre>";print_r($arResult['PROPERTIES']['PRODUCTS_SEVERAL']['DESCRIPTION']);echo "</pre>"; */
		$blockimetki=0;
		foreach($massa as $metka=>$group){
			$group['BLOCK']=$blockimetki;
			$blockimetki++;
			$table_code=include(dirname(__FILE__).'/templ_discount_beretta2.php');					
			$arResult['PROPERTIES']['PRODUCTS_SEVERAL']["HTML_METKI"][$metka]=$table_code;
			
			$arResult["DETAIL_TEXT"]=str_replace('{'.$metka.'}', $table_code, $arResult["DETAIL_TEXT"]);
		}
	}
	
	if(!empty($arResult['PROPERTIES']['SHOW_CATALOG']['VALUE'])){
		if(!empty($arResult['PROPERTIES']['FILTER_SHOW_CATALOG']['VALUE']['TEXT'])){
			//\Kolchuga\Settings::xmp($arResult['PROPERTIES']['FILTER_SHOW_CATALOG']['VALUE']['TEXT'],11460, __FILE__.": ".__LINE__);
			
			//preg_replace('/^(.*):(.*)$/emU', '${"$1"} = "$2";',$arResult['PROPERTIES']['FILTER_SHOW_CATALOG']['VALUE']['TEXT']);
			
			preg_match_all("/^(.*)=(.*)$/mU", $arResult['PROPERTIES']['FILTER_SHOW_CATALOG']['VALUE']['TEXT'], $match);
			$filtr=[];
			foreach($match[1] as $key=>$vl){
				$zn=$match[2][$key];
				//if($zn[0]=='['){$arra = preg_split('[,]\s*', $zn); $zn=$arra;}
				if($zn[0]=='['){
					/*$zn=str_replace(array('[\'','\']'),'',$zn);					
					$arra = preg_split('[\',\']', $zn); 					
					$zn=$arra;			*/		
					$zn=str_replace(array('[',']'),'',$zn);
					$arra2=str_getcsv($zn,',','\'');
					$zn=$arra2;
				}
				$filtr[$vl]=$zn;
			}
			$arResult['PROPERTIES']['SHOW_CATALOG']['FILTER']=$filtr;
			//\Kolchuga\Settings::xmp($arra2,11460, __FILE__.": ".__LINE__);
			//\Kolchuga\Settings::xmp($filtr,11460, __FILE__.": ".__LINE__);
			
			
			
				if (is_object($cp))
				{
					$cp->arResult['SHOW_CATALOG'] = $arResult['PROPERTIES']['SHOW_CATALOG'];

					$cp->SetResultCacheKeys(array('SHOW_CATALOG'));
				}
		}
	}
?>
<?/*<!--pre><?print_r($arResult['RECOMEND_BLOCK_BANNER']);?></pre-->*/?>
<?//echo "<pre>";print_r($arResult['DISPLAY_PROPERTIES']['NEXT_TOVAR']);echo "</pre>";die;?>