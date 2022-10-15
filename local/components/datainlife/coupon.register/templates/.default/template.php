<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

?>
<div class="discount">

    <? if($arResult['TEMPLATE_PART'] == 'CREATE'): ?>
        <div class="discount__query">
            <div class="discount__query--left">

                <div class="discount__card--list">
                    <ul>
                        <li><img src="<?=$templateFolder?>/images/card_3.png" alt=""></li>
                        <li><img src="<?=$templateFolder?>/images/card_5.png" alt=""></li>
                        <li><img src="<?=$templateFolder?>/images/card_10.png" alt=""></li>
                    </ul>
                </div>

            </div>
            <div class="discount__query--right">

                <?if(count($arResult['ERRORS']) > 0):
                    foreach($arResult['ERRORS'] as $error):?>
                    <div class="alert alert-danger"><?=GetMessage('ERROR_' . $error)?></div>
                <?endforeach;
                endif?>
                <form method="post">

                    <div class="form__group">
                        <label for="field_1">ФИО держателя карты<span class="req">*</span></label>
                        <div class="form__input">
                            <input id="field_1"
                                   type="text"
                                   name="COUPON[FIO]"
                                   value="<?=$arResult['VALUES']['FIO']?>">
                        </div>
                    </div>
                    <div class="form__group">
                        <label for="field_2">№ карты<span class="req">*</span></label>
                        <div class="form__input">
                            <input id="field_2"
                                   name="COUPON[CODE]"
                                   type="text"
                                   value="<?=$arResult['VALUES']['CODE']?>">
                        </div>
                    </div>
                    <div class="form__group">
                        <label for="field_3">E-mail держателя</label>
                        <div class="form__input">
                            <input id="field_3"
                                   name="COUPON[EMAIL]"
                                   type="email"
                                   value="<?=$arResult['VALUES']['EMAIL']?>">
                        </div>
                    </div>
                    <div class="form__group">
                        <label for="field_4">Телефон держателя карты<span class="req">*</span></label>
                        <div class="form__input">
                            <input id="field_4"
                                   type="text"
                                   name="COUPON[PHONE]"
                                   value="<?=$arResult['VALUES']['PHONE']?>">
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__input">
                            <input type="submit" name="SET_COUPON" class="btn btn-primary" value="Привязать карту">
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <div class="discount__info"><?= GetMessage('STATUS_INFO_' . $arResult['TEMPLATE_PART']) ?></div>
        <? else: ?>
        <div class="discount__result">
            <p>Результат проверки вашего запроса на скидочную карту менеджером "Кольчуги"</p>
            <div class="discount__card">
                <div class="discount__card--inner">
                    <? if($arResult['TEMPLATE_PART'] == 'SUCCESS'):
                        $img_name = 'card_' . explode('_', $arResult['COUPON']['STATUS_CODE'])[1] . '.png';
                    ?>
                    <img src="<?=$templateFolder?>/images/<?=$img_name?>">
                    <?endif?>
                </div>
            </div>
            <? $css_class = '';
            if($arResult['TEMPLATE_PART'] == 'MODERATION')
                $css_class = 'text-warning';
            elseif($arResult['TEMPLATE_PART'] == 'SUCCESS')
                $css_class = 'text-success';
            elseif($arResult['TEMPLATE_PART'] == 'CANCEL')
                $css_class = 'text-danger'; ?>
            <p class="<?= $css_class ?>"><?= GetMessage('STATUS_' . $arResult['TEMPLATE_PART']) ?>
                (<?= $arResult['COUPON']['DATE'] ?> г.)</p>

            <div class="discount__info">
                <?= GetMessage('STATUS_INFO_' . $arResult['TEMPLATE_PART']) ?>
            </div>
        </div>
    <? endif ?>
</div>
