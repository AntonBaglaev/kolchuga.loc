<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
$str=str_word_count($_SERVER['REQUEST_URI'],1);
if($str[1]=='xml' && $str[2]=='order'){die;}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/* $APPLICATION->AddHeadString('<script>
var url = document.location.pathname + document.location.search;
var url_referrer = document.referrer;
var yaParams = {error404: {page: url, from: url_referrer}};
</script>'); */
$APPLICATION->SetPageProperty("title", "Страница не найдена");
//$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty("not_show_nav_chain", "Y");
$APPLICATION->SetPageProperty("fluid_container", "-fluid");
//$APPLICATION->AddHeadString("<script>ym(36451865,'reachGoal','404error');</script>");

?>
<script type="text/javascript">
var url = document.location.pathname + document.location.search;
var url_referrer = document.referrer;
window.yaParams = {error404: {page: url, from: url_referrer}};
ym(36451865, 'params', window.yaParams||{});
</script>
<script>
window.onload = function () {
 yaCounter36451865.reachGoal('404error');
 }
</script>
<?/* <h1>Страница не найдена</h1>

<p>К сожалению, страница не найдена.</p> */?>

<div class="row thumb-wrap-img1 d-none d-md-block"><img src="/images/404_page.jpg" width="100%" style=""></div>
<div class="row thumb-wrap-img1 d-block d-md-none"><img src="/images/404_pagemob.jpg" width="100%" style=""></div>
<br><br>
<div class="container">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "40",
		"IBLOCK_TYPE" => "",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => "",
		"SECTION_ID" => "",
		"SECTION_URL" => "/internet_shop/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => "",
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "TEXT"
	)
);?></div>
<style>
.thumb-wrap-img {
    position: relative;
    padding-bottom: 56%;
    height: 0;
    overflow: hidden;
}
.thumb-wrap-img img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-width: 0;
    outline-width: 0;
}
.thumb-wrap-img1{text-align:center;}
.thumb-wrap-img1 img{max-width:1900px;text-align:center;}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>