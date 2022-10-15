<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");

$APPLICATION->AddHeadScript('/brands/script.js');
$APPLICATION->SetAdditionalCSS("/brands/style.css");

?><?$APPLICATION->IncludeComponent(
	"maxyss:hl_brand.detail", 
	"branddetail",
	array(
		"BLOCK_ID" => "6",
		"BROWSER_TITLE" => "UF_TITLE",
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "N",
		"CHECK_PERMISSIONS" => "N",
		"FIELD_CODE" => array(
			"UF_FILE_MINI",
			"UF_FULL_DESCRIPTION",
			"UF_WEB",
			"UF_LOGO",
			"UF_DOWNLOAD_FILE",
			"UF_DOWNLOAD_OPIS",
			"UF_STRANA",
			"UF_COLOR_BRAND",
			"UF_LINK_BANNER",
		),
		"FILTER_CODE" => "BREND_STRANITSA_BRENDA",
		"FILTER_NAME" => "brandfilter",
		"LIST_URL" => "/brands/",
		"META_DESCRIPTION" => "UF_DESCRIPTION",
		"META_KEYWORDS" => "UF_NAME",
		"ROW_ID" => $_REQUEST["ID"],
		"ROW_KEY" => "ID",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "#UF_LINK#",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "N",
		"SET_TITLE_HL" => "Y",
		"TITLE_HL" => "UF_NAME",
		"COMPONENT_TEMPLATE" => "branddetail"
	),
	false
);?>


<?
//\Kolchuga\Settings::xmp($brandfilter,11460, __FILE__.": ".__LINE__);
if(empty($brandfilter)){			
	$APPLICATION->SetPageProperty('title', "Страница не найдена");
   \Bitrix\Iblock\Component\Tools::process404(
	   false, //Сообщение
	   true, // Нужно ли определять 404-ю константу
	   true, // Устанавливать ли статус
	   true, // Показывать ли 404-ю страницу
	   false // Ссылка на отличную от стандартной 404-ю
	);
}
?>


<?
$obCache = new CPHPCache;
        $life_time = 12*3600; 
        $cache_id = 'brand-'.$brandfilter['PROPERTY_BREND_STRANITSA_BRENDA'];
		if($obCache->InitCache($life_time, $cache_id, "/brand_sidebar_menu")) {
			$razdel_0 = $obCache->GetVars();
		} else {
			$razdel_m=[];
			$filyael=$brandfilter;
			$filyael["IBLOCK_ID"]=40;
			$filyael["IBLOCK_TYPE"]='1c_catalog';
			$filyael["ACTIVE"]='Y';
			$filyael["!PROPERTY_253"]='298882';
			$filyael[">CATALOG_PRICE_2"]='0';
			$filyael['!DETAIL_PICTURE']=false;
			$filyael[]=array(
				'LOGIC' => 'OR',
				'>CATALOG_QUANTITY' => 0,
				'>PROPERTY_SKU_QUANTITY' => 0
			);
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filyael, false, false, Array('ID','IBLOCK_SECTION_ID'));
			$razdel=[];
			while($obEl = $dbEl->Fetch()){
				$razdel[$obEl['IBLOCK_SECTION_ID']]['ID'][]=$obEl['ID'];
				
			}
			foreach($razdel as $SectionID=>$el){
				$navChain = \CIBlockSection::GetNavChain(40, $SectionID); 
				while ($arNav=$navChain->GetNext()){
					$razdel[$SectionID]['SECTION'][]=$arNav;
					$razdel_m[$arNav['DEPTH_LEVEL']][$arNav['ID']]=$arNav['NAME'];
				}
			}
			$razdel_0=[$razdel,$razdel_m];
			 $obCache->StartDataCache();
            $obCache->EndDataCache($razdel_0);
        }
		//\Kolchuga\Settings::xmp($razdel_0[1][1],11460, __FILE__.": ".__LINE__);
		
		$obCache = new CPHPCache;
        $life_time = 12*3600; 
        $cache_id = 'brandsect-'.$brandfilter['PROPERTY_BREND_STRANITSA_BRENDA'];
		if($obCache->InitCache($life_time, $cache_id, "/brand_sidebar_menu_cust")) {
			$section_brand = $obCache->GetVars();
		} else {
			$filyael_cust=$brandfilter;
			$filyael_cust["IBLOCK_ID"]=40;
			$filyael_cust["IBLOCK_TYPE"]='1c_catalog';
			$filyael_cust["ACTIVE"]='Y';
			$filyael_cust["!PROPERTY_253"]='298882';
			$filyael_cust["!PROPERTY_610"]=false;
			$filyael_cust[">CATALOG_PRICE_2"]='0';
			$filyael_cust[]=array(
				'LOGIC' => 'OR',
				'>CATALOG_QUANTITY' => 0,
				'>PROPERTY_SKU_QUANTITY' => 0
			);
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), $filyael_cust, false, false, Array('ID','IBLOCK_SECTION_ID','PROPERTY_BRAND_SECTION'));
			$eee=[];
			$section_brand=[];
			while($obEl = $dbEl->Fetch()){
				$eee[]=$obEl;
				//$zn=str_replace(' ','_',$obEl['PROPERTY_BRAND_SECTION_VALUE']);
				$arParams = array("replace_space"=>"_","replace_other"=>"_");
				$zn = \Cutil::translit($obEl['PROPERTY_BRAND_SECTION_VALUE'],"ru",$arParams);
				$section_brand[mb_strtolower($zn)]=$obEl['PROPERTY_BRAND_SECTION_VALUE'];
				
			}
			asort($section_brand);
			$obCache->StartDataCache();
            $obCache->EndDataCache($section_brand);
        }
		//\Kolchuga\Settings::xmp($section_brand,11460, __FILE__.": ".__LINE__); //PROPERTY_BRAND_SECTION_VALUE
		if(!empty($_REQUEST['bfilter'])){
			$brandfilter['PROPERTY_BRAND_SECTION']=$section_brand[$_REQUEST['bfilter']];
			$brandfilter['INCLUDE_SUBSECTIONS']='Y';
		}
		
if(!empty($_REQUEST['sfilter'])){
	$brandfilter['SECTION_ID']=$_REQUEST['sfilter'];
	$brandfilter['INCLUDE_SUBSECTIONS']='Y';
}
$setSection='';


?>

<div class="container-fluid">
		<div class="row">	
		  <div class="rowanons col-sm-3 sidebar__menu pr-0 pl-0">
              <div class="sidebar__menu-sticky">
                  <br>
		  <div class="separator">Каталог</div>
		  <ul>
		  <?
		  if(!empty($section_brand) && !empty($_REQUEST['bfilter']) && 1==2){
			  
			  foreach($section_brand as $SectionID=>$el){
				  if(!empty($_REQUEST['bfilter']) && $_REQUEST['bfilter']==$SectionID){						
						$setSection.=$el;					  
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("bfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  $setSection0.=$el;
					?><li><a href="<?=$APPLICATION->GetCurPageParam("bfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection0?></a></li><?
				  }
			  }
		  }elseif(count($razdel_0[1][1])>1){
			  /*foreach($razdel_0[0] as $SectionID=>$el){
				  if(!empty($_REQUEST['sfilter']) && $_REQUEST['sfilter']==$SectionID){
						//$setSection=end($el['SECTION'])['NAME'];
					  foreach($el['SECTION'] as $val){
						if(!empty($setSection)){$setSection.=' / ';}
						$setSection.=$val['NAME'];
					  }
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  foreach($el['SECTION'] as $val){
						if(!empty($setSection0)){$setSection0.=' / ';}
						$setSection0.=$val['NAME'];
					  }
					?><li><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection0?></a></li><?
				  }
			  }*/
			  if(!empty($razdel_0[1][1][17827])){
				  $or[17827]=$razdel_0[1][1][17827];
				  unset($razdel_0[1][1][17827]);
				  foreach($razdel_0[1][1] as $SectionID=>$el){
					$or[$SectionID]=$el;
				  }
				  $razdel_0[1][1]=$or;
				  
			  }
			  
			  foreach($razdel_0[1][1] as $SectionID=>$el){
				  if(!empty($_REQUEST['sfilter']) && $_REQUEST['sfilter']==$SectionID){						
						$setSection.=$el;					  
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  $setSection0.=$el;
					?><li><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection0?></a></li><?
				  }
			  }
		  }else{
			  foreach($razdel_0[1][2] as $SectionID=>$el){
				  if(!empty($_REQUEST['sfilter']) && $_REQUEST['sfilter']==$SectionID){						
						$setSection.=$el;					  
					?><li class="active"><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection?></a></li><?
				  }else{
					  $setSection0='';
					  $setSection0.=$el;
					?><li><a href="<?=$APPLICATION->GetCurPageParam("sfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$setSection0?></a></li><?
				  }
			  }
		  }
		  ?>
		  <li <?=(empty($setSection) ? 'class="active"' : '')?>><a href="<?=$APPLICATION->GetCurPageParam("", array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1","PAGEN_3"))?>">Все товары</a></li>
		  </ul>
		  <?$APPLICATION->ShowViewContent("block_brands_file");?>
		  <a name="productlist" id="productlist" style=" clear: both; display: block;"></a>
		  <? 
		  //if(!empty($_REQUEST['bfilter']) || !empty($_REQUEST['sfilter']) || !empty($_REQUEST['PAGEN_2']) || !empty($_REQUEST['PAGEN_3'])){
		  if(!empty($_REQUEST['bfilter']) || !empty($_REQUEST['sfilter']) || preg_grep('/^PAGEN_/', array_keys($_REQUEST)) ){
						  ?><script type="text/javascript">$(document).on('ready', function() {
							  if ($(window).width() < 640) {
							  $([document.documentElement, document.body]).animate({
									scrollTop: $("#productlist").offset().top
								}, 3000);
							  }
						  });</script><?
					  }?>
              </div>
		  </div>
		  <div class="rowanons col-sm-9 osnblok">
		  <?if(!empty($section_brand) ){
			  $massivcust = \Kolchuga\DopViborka::getSeeSectionInBrand($seeslider='Y');
			  //\Kolchuga\Settings::xmp($massivcust,11460, __FILE__.": ".__LINE__);
			  
			  if(!empty($massivcust)){
				  ?>
                    <br>
					<div class="section_brand container-fluid0 mb-5">
						<div class="row setslick">
							<?foreach ($section_brand as $SectionID=>$el){?>
								<?if(!empty($_REQUEST['bfilter']) && $_REQUEST['bfilter']==$SectionID){						
									$setSection.=$el;
								}else{
									$setSection0='';
									$setSection0.=$el;
								}
								?>
								<div class="<?=$massivcust[$SectionID]['CLASS']?> mb-5 mlh pl5 pr0">									
									<div class="separator <?=(!empty($_REQUEST['bfilter']) && $_REQUEST['bfilter']==$SectionID ? 'active':'')?>"><a href="<?=$APPLICATION->GetCurPageParam("bfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>"><?=$massivcust[$SectionID]['NAME']?></a></div>
									<a href="<?=$APPLICATION->GetCurPageParam("bfilter=".$SectionID, array("sfilter","bfilter","UF_LINK","PAGEN_2","PAGEN_1"))?>">
									<?$arFile = \Kolchuga\Pict::getWebpImgSrc($massivcust[$SectionID]['PICTURE'], $intQuality = 80);?>
									<picture>
										<?if ($arFile['DETAIL_PICTURE']['WEBP_SRC']) :?>
											<source type="image/webp" srcset="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>">
										<?endif;?>
										<img src="<?=$arFile['DETAIL_PICTURE']["SRC"]?>" class=" img-0" />
									</picture>
									</a>
								</div>
							<?}?>
						</div>
					</div>
				  <?
				  //if($USER->GetID()=="11460"){
					  ?>
						<link rel="stylesheet" type="text/css" href="/local/templates/kolchuga_2016/plugins/slick/slick.css">
						<link rel="stylesheet" type="text/css" href="/local/templates/kolchuga_2016/plugins/slick/slick-theme.css">
						<script src="/local/templates/kolchuga_2016/plugins/slick/slick.js" type="text/javascript" charset="utf-8"></script>
					  <?
				  //}
				  
					 
				  
			  }
			  
		  }?>

		  <div class='sec_pag'>
		  <?
		  $tmp='withborder';
		  $brandfilter['!DETAIL_PICTURE']=false;
		  ?>
          <? $APPLICATION->IncludeComponent(
              "bitrix:catalog.section",
              $tmp,
              array(
                  "ACTION_VARIABLE"                 => "action",
                  "ADD_PICT_PROP"                   => "MORE_PHOTO",
                  "ADD_PROPERTIES_TO_BASKET"        => "Y",
                  "ADD_SECTIONS_CHAIN"              => "N",
                  "ADD_TO_BASKET_ACTION"            => "ADD",
                  "AJAX_MODE"                       => "Y",
                  "AJAX_OPTION_ADDITIONAL"          => "",
                  "AJAX_OPTION_HISTORY"             => "N",
                  "AJAX_OPTION_JUMP"                => "N",
                  "AJAX_OPTION_STYLE"               => "Y",
                  "INSTANT_RELOAD"                  => "Y",
                  "BACKGROUND_IMAGE"                => "-",
                  "BASKET_URL"                      => "/personal/basket.php",
                  "BROWSER_TITLE"                   => "-",
                  "CACHE_FILTER"                    => "N",
                  "CACHE_GROUPS"                    => "Y",
                  "CACHE_TIME"                      => "36000000",
                  "CACHE_TYPE"                      => "A",
                  "COMPATIBLE_MODE"                 => "N",
                  "CONVERT_CURRENCY"                => "N",
                  "CUSTOM_FILTER"                   => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:40:253\",\"DATA\":{\"logic\":\"Not\",\"value\":298882}}]}",
                  "DETAIL_URL"                      => "",
                  "DISABLE_INIT_JS_IN_COMPONENT"    => "N",
                  "DISPLAY_BOTTOM_PAGER"            => "Y",
                  "DISPLAY_COMPARE"                 => "N",
                  "DISPLAY_TOP_PAGER"               => "N",
                  "ELEMENT_SORT_FIELD"              => "HAS_DETAIL_PICTURE",
                  "ELEMENT_SORT_FIELD2"             => "sort",
                  "ELEMENT_SORT_ORDER"              => "desc",
                  "ELEMENT_SORT_ORDER2"             => "asc",
                  "ENLARGE_PRODUCT"                 => "STRICT",
                  "FILE_404"                        => "",
                  "FILTER_NAME"                     => "brandfilter",
                  "HIDE_NOT_AVAILABLE"              => "Y",
                  "HIDE_NOT_AVAILABLE_OFFERS"       => "Y",
                  "IBLOCK_ID"                       => "40",
                  "IBLOCK_TYPE"                     => "1c_catalog",
                  "INCLUDE_SUBSECTIONS"             => "A",
                  "LABEL_PROP"                      => "",
                  "LAZY_LOAD"                       => "N",
                  "LINE_ELEMENT_COUNT"              => "3",
                  "LOAD_ON_SCROLL"                  => "N",
                  "MESSAGE_404"                     => "",
                  "MESS_BTN_ADD_TO_BASKET"          => "В корзину",
                  "MESS_BTN_BUY"                    => "Купить",
                  "MESS_BTN_DETAIL"                 => "Подробнее",
                  "MESS_BTN_SUBSCRIBE"              => "Подписаться",
                  "MESS_NOT_AVAILABLE"              => "Нет в наличии",
                  "META_DESCRIPTION"                => "-",
                  "META_KEYWORDS"                   => "-",
                  "OFFERS_CART_PROPERTIES"          => "",
                  "OFFERS_FIELD_CODE"               => array(
                      0 => "",
                      1 => "",
                  ),
                  "OFFERS_LIMIT"                    => "0",
                  "OFFERS_PROPERTY_CODE"            => array(
                      0 => "",
                      1 => "",
                  ),
                  "OFFERS_SORT_FIELD"               => "sort",
                  "OFFERS_SORT_FIELD2"              => "id",
                  "OFFERS_SORT_ORDER"               => "asc",
                  "OFFERS_SORT_ORDER2"              => "desc",
                  "PAGER_BASE_LINK_ENABLE"          => "N",
                  "PAGER_DESC_NUMBERING"            => "N",
                  "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                  "PAGER_SHOW_ALL"                  => "N",
                  "PAGER_SHOW_ALWAYS"               => "N",
                  "PAGER_TEMPLATE"                  => ".default",
                  "PAGER_TITLE"                     => "Товары",
                  "PAGE_ELEMENT_COUNT"              => "18",
                  "PARTIAL_PRODUCT_PROPERTIES"      => "N",
                  "PRICE_CODE"                      => array(
                      0 => "Розничная",
                  ),
                  "PRICE_VAT_INCLUDE"               => "Y",
                  "PRODUCT_BLOCKS_ORDER"            => "price,props,sku,quantityLimit,quantity,buttons,compare",
                  "PRODUCT_DISPLAY_MODE"            => "N",
                  "PRODUCT_ID_VARIABLE"             => "id",
                  "PRODUCT_PROPERTIES"              => array(),
                  "PRODUCT_PROPS_VARIABLE"          => "prop",
                  "PRODUCT_QUANTITY_VARIABLE"       => "quantity",
                  "PRODUCT_ROW_VARIANTS"            => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                  "PRODUCT_SUBSCRIPTION"            => "N",
                  "PROPERTY_CODE"                   => array(
                      0 => "BREND_STRANITSA_BRENDA",
                      1 => "BRAND_REF",
                      2 => "ARTNUMBER",
                      3 => "",
                  ),
                  "PROPERTY_CODE_MOBILE"            => "",
                  "RCM_PROD_ID"                     => $_REQUEST["PRODUCT_ID"],
                  "RCM_TYPE"                        => "personal",
                  "SECTION_CODE"                    => "",
                  "SECTION_ID"                      => $_REQUEST["SECTION_ID"],
                  "SECTION_ID_VARIABLE"             => "SECTION_ID",
                  "SECTION_URL"                     => "",
                  "SECTION_USER_FIELDS"             => array(
                      0 => "",
                      1 => "",
                  ),
                  "SEF_MODE"                        => "N",
                  "SET_BROWSER_TITLE"               => "N",
                  "SET_LAST_MODIFIED"               => "N",
                  "SET_META_DESCRIPTION"            => "N",
                  "SET_META_KEYWORDS"               => "N",
                  "SET_STATUS_404"                  => "Y",
                  "SET_TITLE"                       => "N",
                  "SHOW_404"                        => "Y",
                  "SHOW_ALL_WO_SECTION"             => "Y",
                  "SHOW_CLOSE_POPUP"                => "N",
                  "SHOW_DISCOUNT_PERCENT"           => "N",
                  "SHOW_FROM_SECTION"               => "N",
                  "SHOW_MAX_QUANTITY"               => "N",
                  "SHOW_OLD_PRICE"                  => "N",
                  "SHOW_PRICE_COUNT"                => "1",
                  "SHOW_SLIDER"                     => "N",
                  "SLIDER_INTERVAL"                 => "3000",
                  "SLIDER_PROGRESS"                 => "N",
                  "TEMPLATE_THEME"                  => "blue",
                  "USE_ENHANCED_ECOMMERCE"          => "N",
                  "USE_MAIN_ELEMENT_SECTION"        => "N",
                  "USE_PRICE_COUNT"                 => "N",
                  "USE_PRODUCT_QUANTITY"            => "N",
                  "COMPONENT_TEMPLATE"              => ".default"
              ),
              false
          ); ?>
</div>
</div>
</div>
</div>

<?$APPLICATION->ShowViewContent("block_brands_detail");?>

<? 
global $arrFilterNews;
$arrFilterNews['>SORT']=1;
$arrFilterNews['=PROPERTY_SEE_IN_BRAND']=$brandfilter['PROPERTY_BREND_STRANITSA_BRENDA'];
?>

	<?$APPLICATION->IncludeComponent("bitrix:news.index","service.list",Array(
			"IBLOCK_TYPE" => "",
			"IBLOCKS" => Array("10",'1'),
			"NEWS_COUNT" => "6",
			"FIELD_CODE" => Array("ID", "CODE", 'PREVIEW_PICTURE'),
			"SORT_BY1" => "SORT",
			"SORT_ORDER1" => "ASC",
			"SORT_BY2" => "ACTIVE_FROM",
			"SORT_ORDER2" => "DESC",
			"DETAIL_URL" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"CACHE_TYPE" => "N",
			"CACHE_TIME" => "300",
			"CACHE_GROUPS" => "Y",
			"FILTER_NAME" => "arrFilterNews",
			"PROPERTY_CODE" => Array("ANONS"), 
		)
	);?>

    <script>
        var component_ajax_id = '<?= $GLOBALS['COMPONENT_AJAX_ID']?>';
    </script>

<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>