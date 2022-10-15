
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
  
    <? /* ?>
    <div class="fName"><?=$arSection["NAME"];?>:</div>
    <? */ ?>
      <? foreach($arSection["ITEMS"] as $kGroup => $vGroup): ?>
        <? if(count($vGroup) > 0): ?>
          <div class="c_tag_group"><?=$arResult['TAG_GROUP_REV'][$kGroup]?>:</div>
          <ul>
            <? foreach($vGroup as $arItem): ?>    
              <li><a onclick="return true;" href="<?=$arItem["DETAIL_PAGE_URL"];?>"<?=(($arItem["SELECTED"])? ' class="active"' : "");?>><?=$arItem["NAME"];?></a></li>    
            <? endforeach; ?>
          </ul>
        <? endif ?>  
      <? endforeach; ?>

    <? endforeach; ?>
</div>