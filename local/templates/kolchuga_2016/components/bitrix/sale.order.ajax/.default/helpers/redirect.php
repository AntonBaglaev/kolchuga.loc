<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 10/09/15
 * Time: 14:47
 */

//Couldn't understand stupid bitrix logic, cause on submit it returns only
// e.g. "success":"Y","redirect":"\/personal\/order\/make\/?ORDER_ID=28"

if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
    {
        if(strlen($arResult["REDIRECT_URL"]) > 0)
        {
            $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
            die();
        }

    }
}

//therefore .........
if($arResult['SUCCESS'] == 'Y' && strlen($arResult['REDIRECT']) > 0):?>
<script>
    location.href='<?=CUtil::JSEscape($arResult["REDIRECT"])?>';
</script>
<?endif;