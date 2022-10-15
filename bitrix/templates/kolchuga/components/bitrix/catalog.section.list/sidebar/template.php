<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="menu-sitemap-tree">
    <ul class="catalog_menu">
        <? foreach ($arResult['SECTIONS'] as $arSection): ?>
        <li class="close">
            <a class="folder <?if($arSection['CURRENT'] == 'Y'):?>activ<?endif?>" href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
        </li>
        <? endforeach ?>
    </ul>
</div>
