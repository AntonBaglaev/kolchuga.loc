<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$id = addslashes(htmlspecialchars($_REQUEST['id']));
$service_center = addslashes(htmlspecialchars($_REQUEST['service_center']));

$arAllowed = [];

if ($GLOBALS['USER']->IsAuthorized()) {

    $arFilter = array("ID" => $GLOBALS['USER']->GetID());
    $arParams["SELECT"] = array("UF_SERVICE");
    $arRes = CUser::GetList($by, $order, $arFilter, $arParams);
    if ($res = $arRes->Fetch()) {
        foreach ($res["UF_SERVICE"] as $intId) {
            $rsRes = CUserFieldEnum::GetList(array(), array(
                "ID" => $intId,
            ));
            if ($arService = $rsRes->GetNext())
                $arAllowed[] = $arService["XML_ID"];
        }
    }

}

if ($id && $service_center && in_array($service_center, $arAllowed)) {

    CIBlockElement::Delete($id);

}

?>
