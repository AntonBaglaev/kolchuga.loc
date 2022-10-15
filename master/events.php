<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$service_center = addslashes(htmlspecialchars($_REQUEST['service_center']));

if ($service_center) {

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

    $json = array();

    $arRows = [];

    $rsSections = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 81, '=CODE' => $service_center));
    if ($arSection = $rsSections->Fetch()) {


        $arSelect = array("ID", "IBLOCK_ID", "PREVIEW_TEXT", "IBLOCK_SECTION_ID", "NAME", "PROPERTY_*");
        $arFilter = array("IBLOCK_ID" => 81, "SECTION_ID" => $arSection['ID'], "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(array("ID" => "DESC"), $arFilter, false, array("nPageSize" => 500), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();

            $sectionCode = '';

            $arRows[$arFields['ID']]['id'] = $arFields['ID'];
            $arRows[$arFields['ID']]['service_center'] = $arSection['CODE'];
            $arRows[$arFields['ID']]['title'] = $arFields['NAME'];
            $arRows[$arFields['ID']]['start'] = date('Y-m-d H:i:s', strtotime($arProps['start']['VALUE']));
            $arRows[$arFields['ID']]['end'] = date('Y-m-d H:i:s', strtotime($arProps['end']['VALUE']));
            $arRows[$arFields['ID']]['name'] = $arProps['name']['VALUE'];
            $arRows[$arFields['ID']]['email'] = $arProps['email']['VALUE'];
            $arRows[$arFields['ID']]['phone'] = $arProps['phone']['VALUE'];
            $arRows[$arFields['ID']]['message'] = $arFields['PREVIEW_TEXT'];

            if (!in_array($service_center , $arAllowed)) {
                $arRows[$arFields['ID']]['title'] = 'Занято';
                $arRows[$arFields['ID']]['name'] = '';
                $arRows[$arFields['ID']]['email'] = '';
                $arRows[$arFields['ID']]['phone'] = '';
                $arRows[$arFields['ID']]['message'] = '';

            }

        }
    }
    
}

echo json_encode(array_values($arRows));

?>