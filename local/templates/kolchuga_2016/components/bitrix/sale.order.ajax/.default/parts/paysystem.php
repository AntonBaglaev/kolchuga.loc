<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
    <?$pay_selected = false;
    foreach($arResult["PAY_SYSTEM"] as $arPaySystem){
        if($arPaySystem["CHECKED"]=="Y") {
            $pay_selected = true;
            break;
        }
    }

    foreach ($arResult["PAY_SYSTEM"] as $arPaySystem):
        $i = 0;
    //if (intval($arPaySystem["PRICE"]) > 0){
    if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
    $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
    else:
    $imgUrl = $templateFolder."/images/logo-default-ps.gif";
    endif;
    ?>
        <div class="form-group">
            <label class="control-label control-label-inner">
                <input type="radio"
                       value="<?= $arPaySystem["ID"] ?>"
                       name="PAY_SYSTEM_ID"
                       data-data="<?=$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]?>"
                    <? if ($arPaySystem["CHECKED"]=="Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]!=="Y")
                        echo " checked=\"checked\""; ?>
                    <?if(!$pay_selected && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]!=="Y")
                        echo " checked=\"checked\"";?>
                >
                <div class="label-inner">
                    <em class="label-icon"><img src="<?=$imgUrl?>" alt="<?= $arPaySystem['PSA_NAME'] ?>"></em>
                    <div><span><?= $arPaySystem['PSA_NAME'] ?></span></div>
                </div>
            </label>
        </div>
    <? $i++;
    endforeach; ?>
