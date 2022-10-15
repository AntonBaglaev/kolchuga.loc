<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>

    <div class="top-menu">

        <nav class="d-md-block">

            <ul class="top-menu-wrapper">

                <? $prev_lv = 0;
                foreach ($arResult

                as $arItem):

                if ($prev_lv && $arItem["DEPTH_LEVEL"] < $prev_lv)
                    echo str_repeat("</ul></li>", ($prev_lv - $arItem["DEPTH_LEVEL"]));

                if ($arItem['IS_PARENT']): ?>
                <li class="with-submenu">
                    <a href="<?= $arItem['LINK'] ?>" title="<?= $arItem['TEXT'] ?>"
                       class="submenu-link root-item <?= $arItem['SELECTED'] ? 'active' : '' ?>"><?= $arItem['TEXT'] ?></a>
                    <ul class="submenu">
                        <? else: ?>
                            <li <?= $arItem['PARAMS']['CLASS']
                                ? 'class="' . $arItem['PARAMS']['CLASS'] . '"'
                                : '' ?>><a href="<?= $arItem['LINK'] ?>"
                                           title="<?= $arItem['TEXT'] ?>"
                                           class="<?= $arItem['SELECTED'] ? 'active' : '' ?>"><?= $arItem['TEXT'] ?></a>
                            </li>
                        <?
                        endif;
                        $prev_lv = $arItem['DEPTH_LEVEL'];
                        endforeach;
                        if ($prev_lv > 1)
                            echo str_repeat("</ul></li>", ($prev_lv - 1)); ?>
                    </ul>
        </nav>
    </div>

<? endif ?>