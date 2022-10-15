<div class="flexslider js_slider_bottom">
	<ul class="slides">
		<li><a href="http://www.russianeagle.ru"><img src="/upload/medialibrary/323/323aa385282e274dd6d93358eb6cb97a.jpg"></a></li>
		<li><a href="http://www.armsandhunting.ru"><img src="/upload/medialibrary/350/3508312de932fb895e8f30e0ab94e455.jpg"></a></li>
		<li><a href="http://techno24.tv"><img src="/upload/medialibrary/1d4/1d49a8e13ba172c6bd1b623bee5895d0.jpg"></a></li>
	</ul>
</div>
<script>
	$(document).ready(function(){
		$('.js_slider_bottom').flexslider({
			animation: "fade",
			prevText: "Назад",
			nextText: "Вперед",
			controlNav: false,
		});
	});
</script>
<?$APPLICATION->IncludeComponent(
	"bitrix:photo.section",
	"brands.carousel",
	Array(
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
		"FIELD_CODE" => array(0=>"",1=>"",),
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
		"PROPERTY_CODE" => array(0=>"email",1=>"",),
		"SECTION_CODE" => "",
		"SECTION_ID" => "45",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N"
	)
);?>