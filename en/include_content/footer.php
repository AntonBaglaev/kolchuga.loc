<?
if(CModule::IncludeModule('iblock'))
{
    $r = CIBLockElement::GetList (Array(), Array('ID' => 697070, 'ACTIVE'=>'Y', 'IBLOCK_ID' => 65), false, false, Array('*'));
    while ($db_item = $r->GetNextElement())
    {
        $ar_res1 = $db_item->GetFields();
        $ar_res2 = $db_item->GetProperties();
        $TEXT_BANNER = $ar_res2["TEXT_BANNER"]['VALUE'];
        $TEXT_BUTTON = $ar_res2["TEXT_BUTTON"]['VALUE'];
        $LINK_BUTTON = $ar_res2["LINK_BUTTON"]['VALUE'];
        $PHOTO_CERTIFICATE = CFile::GetPath($ar_res2["PHOTO_CERTIFICATE"]['VALUE']);
		$arFile = \Kolchuga\Pict::getWebpImgSrc($PHOTO_CERTIFICATE, $intQuality = 90);
		$PHOTO_CERTIFICATE = $arFile['DETAIL_PICTURE']['WEBP_SRC'];
		
		if(empty($LINK_BUTTON)){$LINK_BUTTON="/programma-loyalnosti/gift_certificate/";}
    }
}
?>

<section id="sertificate">
	<div class="sertificate__item sertificate-block" style="background: url(<?=$PHOTO_CERTIFICATE?>) no-repeat top/cover;cursor: pointer;" onclick="javascript:location.href='<?=$LINK_BUTTON?>'" data-bg="<?=$arFile['DETAIL_PICTURE']['SRC']?>" data-bg-webp="<?=$PHOTO_CERTIFICATE?>">
		<div class="sertificate-block__title"><?=$TEXT_BANNER?></div>
		<div class="banner__btn main__btn"><a href="<?=$LINK_BUTTON?>"><?=$TEXT_BUTTON?></a></div>
	</div>
</section>




<?/*$APPLICATION->IncludeComponent(
	"bitrix:photo.section", 
	"brands.carousel", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "brands.carousel",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "users",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Фотографии",
		"PAGE_ELEMENT_COUNT" => "100",
		"PROPERTY_CODE" => array(
			0 => "email",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "45",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N"
	),
	false
);*/?>