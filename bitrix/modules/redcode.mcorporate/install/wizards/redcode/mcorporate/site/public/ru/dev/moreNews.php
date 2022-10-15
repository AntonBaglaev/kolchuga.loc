<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	die("Error in file moreNews.php");

$arOrder = array($_REQUEST["sortby"] => $_REQUEST["sortorder"], $_REQUEST["sortby2"] => $_REQUEST["sortorder2"]);
$arFilter = array("IBLOCK_ID" => $_REQUEST["iblockid"], "ACTIVE" => "Y");
$arSelect = array("PREVIEW_PICTURE", "PROPERTY_SHOW_IMAGE", "DATE_ACTIVE_FROM", "NAME", "DETAIL_PAGE_URL", "PREVIEW_TEXT", "PROPERTY_TAG");

$news = CIBlockElement::GetList($arOrder, $arFilter, false,
array(
	"iNumPage" => $_REQUEST["page"] + 1,
	"nPageSize" => $_REQUEST["pagesize"]
),
$arSelect);

while($newsElement = $news->GetNext(false,false)){
	$newsElement["PICTURE_SRC"] = CFile::GetPath($newsElement["PREVIEW_PICTURE"]);

	if(!empty($newsElement["PICTURE_SRC"]) && $newsElement["DISPLAY_PROPERTY_SHOW_IMAGE_VALUE"] != "no")
		$background = $newsElement["PICTURE_SRC"];
	else
		$background = "";
?><!--
 --><div class="elementNews">
		<a class="img" style="background: #efefef url('<?=$background;?>') no-repeat center; background-size: cover;" href="<?=$newsElement["DETAIL_PAGE_URL"];?>" title="<?=$newsElement["NAME"];?>"></a>
		<?if($_REQUEST["name"] !== "shares"){?>
			<div class="allText">
				<?if(!empty($newsElement["PROPERTY_TAG_VALUE"]) || !empty($newsElement["ACTIVE_FROM"])){?>
					<div class="title">
						<?if(!empty($newsElement["PROPERTY_TAG_VALUE"])){?>
							<div class="tag"><?=$newsElement["PROPERTY_TAG_VALUE"];?></div>
						<?}?>
						<?if(!empty($newsElement["ACTIVE_FROM"])){?>
							<div class="date"><?=$newsElement["ACTIVE_FROM"];?></div>
						<?}?>
					</div>
				<?}?>
				<a class="newsName" href="<?=$newsElement["DETAIL_PAGE_URL"];?>" title="<?=$newsElement["NAME"];?>"><?=$newsElement["NAME"];?></a>
			</div>
		<?}else{?>
			<div class="allText">
				<?if(!empty($newsElement["DISPLAY_ACTIVE_FROM"])){?>
					<div class="title">
						<?if(!empty($newsElement["DISPLAY_ACTIVE_FROM"])){?>
							<div class="date">с <?=$newsElement["DISPLAY_ACTIVE_FROM"];?></div>
						<?}?>
						<?if(!empty($newsElement["DISPLAY_DATE_ACTIVE_TO"])){?>
							<div class="date"> до <?=$newsElement["DISPLAY_DATE_ACTIVE_TO"];?></div>
						<?}?>
					</div>
				<?}?>
				<a class="newsName" href="<?=$newsElement["DETAIL_PAGE_URL"];?>" title="<?=$newsElement["NAME"];?>"><?=$newsElement["NAME"];?></a>
			</div>
		<?}?>
	</div><!--
--><?}?>