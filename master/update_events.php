<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$id = addslashes(htmlspecialchars($_REQUEST['id']));
$service_center = addslashes(htmlspecialchars($_REQUEST['service_center']));
$title = addslashes(htmlspecialchars($_REQUEST['title']));
$start = addslashes(htmlspecialchars($_REQUEST['start']));
$end = addslashes(htmlspecialchars($_REQUEST['end']));

if (strpos($start, 'T') !== false || strpos($end, 'T') !== false) {
    $start = str_replace(' ', '+', $start);
    $end = str_replace(' ', '+', $end);
}

if ($id && $service_center) {

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

    if (in_array($service_center, $arAllowed)) {
        CIBlockElement::SetPropertyValueCode($id, "start", date('d.m.Y H:i:s', strtotime($start)));
        CIBlockElement::SetPropertyValueCode($id, "end", date('d.m.Y H:i:s', strtotime($end)));
    }

}
?>