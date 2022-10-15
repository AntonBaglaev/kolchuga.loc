<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if(empty($arResult)) return false; ?>
<nav id="mmenu" class="mobile-menu">
<ul>
    <? $prev_lv = 0;
    foreach($arResult as $arItem):

    if($prev_lv && $arItem["DEPTH_LEVEL"] < $prev_lv)
        echo str_repeat("</ul></li>", ($prev_lv - $arItem["DEPTH_LEVEL"]));

    if($arItem['IS_PARENT']): ?>
    <li class="<?=$arItem['SELECTED'] ? 'active' : ''?>">
        <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
            <span class="<?= $arItem['PARAMS']['ICON'] ?>"></span>
           <?= $arItem['TEXT'] ?>
        </a>
        <ul>
            <? else:?>
                <li class="<?= $arItem['SELECTED'] ? 'active' : '' ?> <?= $arItem['PARAMS']['CLASS'] ?>">
                    <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
                        <span class="<?= $arItem['PARAMS']['ICON'] ?>"></span>
                        <?= $arItem['TEXT'] ?>
                    </a>
                </li>
            <?
            endif;
            $prev_lv = $arItem['DEPTH_LEVEL'];
            endforeach;
            if($prev_lv > 1)
                echo str_repeat("</ul></li>", ($prev_lv - 1)); ?>
        </ul>
</nav>

