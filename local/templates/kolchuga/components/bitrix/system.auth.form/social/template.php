<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin();
?>

<?if(!$USER->IsAuthorized()):?>
    
<div class="w50">
                                    <div class="bx-authform-social">
                                        <div class="bx-authform-social-title">
                                            Войти, используя аккаунты социальных сетях
                                        </div>
                                        <?if($arResult["AUTH_SERVICES"]):
                                            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "flat",
                                                array(
                                                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                                                    "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                                                    "AUTH_URL"=> ($arParams["BACKURL"] ? $arParams["BACKURL"] : $arResult["BACKURL"]),
                                                    "POST"=>$arResult["POST"],
                                                    "SUFFIX" => $this->randString(8)
                                                ),
                                                $component,
                                                array("HIDE_ICONS"=>"Y")
                                            );
                                        endif;?>
                                    </div>
                                </div>
                                
<?endif?>

