<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>
<?
    /*$rest = \CIBLockElement::GetList (Array(), Array('ACTIVE'=>'Y', 'IBLOCK_ID' => '13', 'ID'=>[213,238,216,230,210,212,214,234]), false, false, Array('ID','NAME','PREVIEW_PICTURE', 'PROPERTY_email'));
    while ($db_item = $rest->Fetch())
    {
    $ar_rest[] = $db_item;
    }*/
?>
<div class="opt_brands">
				<p><strong>Ведущие мировые бренды</strong></p>
				<p>Залог успешного бизнеса - качественный и востребованный потребителем ассортимент.  В нашем портфеле представлены большинство ведущих европейских и мировых брендов-  производителей оружия, товаров для спорта и активного отдыха. </p>
				
				<div class="gallery-block gallery">
						<div class="row">							
							<?/*foreach($ar_rest as $vl){?>
							
								<div class="col-md-3 col-sm-4 col-6 middle">
									<a href="<?=$vl["PROPERTY_EMAIL_VALUE"]?>" target="_blank">
										<div class="gallery-img small-size lazyload" data-src="<?=$img_xs['src']?>" style="display: block; background-image: url(<?=CFile::GetPath($vl["PREVIEW_PICTURE"])?>);">
											<div class="corner-line"></div>
										</div>
									</a>
								</div>
							<?}*/?>
<?global $brandfilter; $brandfilter['UF_NAME']=['fabarm','benelli','blaser','beretta','browning','norma','Clever','swarovski'];?>
 <?$APPLICATION->IncludeComponent(
	"maxyss:hl_brand.list", 
	"brands", 
	array(
		"BLOCK_ID" => "6",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHECK_PERMISSIONS" => "N",
		"DETAIL_URL" => "/brands/detail.php",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "UF_FILE",
			1 => "UF_LOGO",
			2 => "",
		),
		"FILTER_NAME" => "brandfilter",
		"PAGEN_ID" => "",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "стр.",
		"ROWS_PER_PAGE" => "",
		"ROW_ID" => $_REQUEST["ID"],
		"ROW_KEY" => "ID",
		"SEF_MODE_HL" => "Y",
		"SEF_MODE_PARAM" => "/brands/#UF_LINK#/",
		"SORT_BY1" => "UF_NAME",
		"SORT_ORDER1" => "ASC",
		"COMPONENT_TEMPLATE" => "brands"
	),
	false
);?>
						</div>										
					</div>	
				
				<p>Ознакомиться со всеми нашими брендами можно <a href="/brands/" target="blank">здесь</a>.</p>
				<p>&nbsp;</p>
				</div>
				
				<div class="catalog_banner">
		<div class="catalog-banner-info">
			<div class="banner-info__title">Широкий ассортимент</div>
			<div class="banner-info__text"></div>
			<div class="banner__btn main__btn"><a href="/internet_shop/">Весь каталог </a></div>		
		</div>
	</div>