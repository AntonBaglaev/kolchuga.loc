<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 20/06/16
 * Time: 10:00
 */

AddEventHandler("main", "OnBeforeUserAdd", "EmailToLogin");
AddEventHandler("main", "OnBeforeUserUpdate", "EmailToLogin");

AddEventHandler("main", "OnAfterUserAdd", "SetSubscribe");
AddEventHandler("main", "OnAfterUserUpdate", "SetSubscribe");

function EmailToLogin(&$arFields){
    $arFields['LOGIN'] = $arFields['EMAIL'];
    return $arFields;
}

function SetSubscribe(&$arFields){

    $uid = $arFields['ID'];
    $email = $arFields['EMAIL'];

    // проверим есть ли подписка у данного юзера
    CModule::includeModule('subscribe');
    $sub = CSubscription::GetList(
        array(),
        array('USER_ID' => $uid)
    )->fetch();

    if(!$sub && isset($_REQUEST['SET_SUBSCRIBE'])){
        // создадим новую
        $sub_fields = Array(
            "USER_ID" => $uid,
            "FORMAT" => 'html',
            "EMAIL" => $email,
            "ACTIVE" => "Y",
            "RUB_ID" => array(1),
            "SEND_CONFIRM" => 'N',
            "CONFIRMED" => 'Y'
        );

        $subscr = new CSubscription;
        $sub_id = $subscr->Add($sub_fields, SITE_ID);

    } elseif(isset($_REQUEST['SET_SUBSCRIBE'])){
        // получим рубрики
        $rubs = CSubscription::GetRubricArray($sub['ID']);
        if(!$rubs || !is_array($rubs)){
            $rubs = array();
        }
        // нашлась
        if(in_array(1, $rubs))
            return true;

        // не нашлась - обновим список
        $rubs[] = 1;

        $subscr = new CSubscription;
        $update = $subscr->Update($sub['ID'], array('RUB_ID' => $rubs), SITE_ID);

    } elseif($sub){
        CSubscription::Delete($sub['ID']);
    }

    return $arFields;

}