<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="b-sections">
    <div class="b-sections__row"><?
	foreach ($arResult['SECTIONS'] as $arSection)
	{
		?><a class="b-section" href="<?= $arSection['SECTION_PAGE_URL'] ?>">
            <div class="b-section__img">
                <div class="b-section__img_cnt">
                <? 
                   switch ($arSection['ID']) {
                      case 18013:
                          break;
                      case 18018:
                          break;
                      case 18061:
                          break;
                      default:
                          $arSection['PICTURE']['SRC'] =
                                  CFile::ResizeImageGet($arSection['PICTURE']["ID"], 
                                                        array('width' => 200, 'height' => 150), 
                                                        BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 60)['src'];
                  }
                ?>
                    <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>"/>
                </div>
            </div>
            <span class="b-section__title"><?=$arSection['NAME']?></span>
        </a><?
	}
	?></div>
</div>
