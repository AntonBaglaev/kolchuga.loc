<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if(empty($arResult)) return false; ?>
<ul>
    <? $prev_lv = 0;
    foreach($arResult as $arItem):
    if($prev_lv && $arItem["DEPTH_LEVEL"] < $prev_lv)
        echo str_repeat("</ul></li>", ($prev_lv - $arItem["DEPTH_LEVEL"]));

    if($arItem['IS_PARENT']): ?>
    <li class="<?=$arItem['SELECTED'] ? 'active' : ''?>">
        <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
            <span class="<?= $arItem['PARAMS']['ICON'] ?>"></span>
            <em><?= $arItem['TEXT'] ?></em>
        </a>
        <ul>
            <? else:?>
                <li class="<?=$arItem['SELECTED'] ? 'active' : ''?>">
                    <?if ($arItem['LINK'] == '/personal/profile/' || $arItem['LINK'] == '/personal/favourite/'):?>
                        <noindex>
                            <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>" rel="nofollow">
                                <i class="<?= $arItem['PARAMS']['ICON'] ?>"></i>
                                <span><?= $arItem['TEXT'] ?></span>
                            </a>
                        </noindex>    
                    <?else:?>
                        <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>">
                            <i class="<?= $arItem['PARAMS']['ICON'] ?>"></i>
                            <span><?= $arItem['TEXT'] ?></span>
                        </a>
                    <?endif;?>        
                </li>
            <?
            endif;
            $prev_lv = $arItem['DEPTH_LEVEL'];
            endforeach;
            if($prev_lv > 1)
                echo str_repeat("</ul></li>", ($prev_lv - 1)); ?>
        </ul>



