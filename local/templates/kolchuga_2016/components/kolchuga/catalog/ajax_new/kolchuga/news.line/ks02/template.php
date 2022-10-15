
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

  if (!is_array($arResult["SECTION_GROUP"]) ||
      empty($arResult["SECTION_GROUP"]))
  {
    return NULL;
  }

?>

<div class="exFilterList">
    <? foreach($arResult["SECTION_GROUP"] as $arSection): ?>
      <div class="fName">
      <? if($APPLICATION->GetCurPage(false) == '/internet_shop/nozhi/topory-lopaty-pily/'): ?>
        Популярные категории:
      <? else: ?>
        <?=$arSection["NAME"];?>:
      <? endif ?>
      </div>
      <ul class="teggroup<?=$arSection["ID"]?>">
          <? foreach($arSection["ITEMS"] as $arItem): ?>
            <li><a onclick="return true;" href="<?=$arItem["DETAIL_PAGE_URL"];?>"<?=(($arItem["SELECTED"])? ' class="active"' : "");?>><?=$arItem["NAME"];?></a></li>
          <? endforeach; ?>
      </ul>
    <? endforeach; ?>
</div>