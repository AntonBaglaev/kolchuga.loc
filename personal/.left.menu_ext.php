<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuNativeExt = array();

if (!$GLOBALS["USER"]->IsAuthorized())
{
    /* if($_REQUEST['ps']!=22){
	$arParamsToDelete = array(
        "login",
        "logout",
        "register",
        "forgot_password",
        "change_password",
        "confirm_registration",
        "confirm_code",
        "confirm_user_id",
    );

    $loginPath = SITE_DIR."login/?backurl=".urlencode($APPLICATION->GetCurPageParam("", array_merge($arParamsToDelete, array("backurl")), $get_index_page=false));
    $aMenuNativeExt = array(
        Array(
            "Войти",
            $loginPath,
            Array(),
            Array(),
            ""
        )
    );
	} */
}
else
{
    $aMenuNativeExt = Array(
        Array(
            "Профиль",
            SITE_DIR."personal/profile/",
            Array(),
            Array("ICON" => "icon-user"),
            ""
        ),
        Array(
            "Корзина",
            SITE_DIR."personal/cart/",
            Array(),
            Array("ICON" => "icon-shopping-bag"),
            ""
        ),
        Array(
            "Скидочная карта",
            SITE_DIR."personal/discount/",
            Array(),
            Array("ICON" => "icon-credit-card-alt"),
            ""
        ),
/*        Array(
            "Избранное",
            SITE_DIR."personal/favourite/",
            Array(),
            Array("ICON" => "icon-heart-o"),
            ""
        ), */
        Array(
            "Заказы",
            SITE_DIR."personal/order/",
            Array(),
            Array("ICON" => "icon-folder-open"),
            ""
        ),
        Array(
            "Выйти",
            $APPLICATION->GetCurPageParam("logout=yes", Array("logout")),
            Array(),
            Array("ICON" => "icon-exit"),
            ""
        ),
    );
}
$aMenuLinks = $aMenuNativeExt;
?>