<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if(empty($arResult)) return false; ?>
    <?/*
    <ul>
    <? $prev_lv = 0;
    foreach($arResult as $arItem):
    if($prev_lv && $arItem["DEPTH_LEVEL"] < $prev_lv)
        echo str_repeat("</ul></li>", ($prev_lv - $arItem["DEPTH_LEVEL"]));

    if($arItem['IS_PARENT']): ?>
    <li>
        <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
            <span class="<?= $arItem['PARAMS']['ICON'] ?>"></span>
            <em><?= $arItem['TEXT'] ?></em>
        </a>
        <ul>
            <? else:?>
                <li>
                    <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
                        <span class="<?= $arItem['PARAMS']['ICON'] ?>"></span>
                        <em><?= $arItem['TEXT'] ?></em>
                    </a>
                </li>
            <?
            endif;
            $prev_lv = $arItem['DEPTH_LEVEL'];
            endforeach;
            if($prev_lv > 1)
                echo str_repeat("</ul></li>", ($prev_lv - 1)); ?>
        </ul>
        */?>
        <div class="mobile-menu-bar">
            <a id="hamburger" href="#mmenu"><span></span></a>
        </div>


