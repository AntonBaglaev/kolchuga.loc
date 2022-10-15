<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

parse_str($_REQUEST['data'], $data);

$arResult = ['status' => 'error', 'id' => '', 'msg' => 'Что-то не так...'];

if (empty($data['AUTH_ANTIBOT'])) {

    $title = addslashes(htmlspecialchars($data['name']));
    $service_center = addslashes(htmlspecialchars($_REQUEST['service_center']));
    $start = addslashes(htmlspecialchars($_REQUEST['start']));
    $end = $end = addslashes(htmlspecialchars($_REQUEST['end']));
    $name = addslashes(htmlspecialchars($data['name']));
    $email = addslashes(htmlspecialchars($data['email']));
    $phone = addslashes(htmlspecialchars($data['phone']));
    $message = addslashes(htmlspecialchars($data['message']));

    if (strpos($start, 'T') !== false || strpos($end, 'T') !== false) {
        $start = str_replace(' ', '+', $start);
        $end = str_replace(' ', '+', $end);
    }

    if (!$GLOBALS['USER']->IsAuthorized()) {
        die(json_encode(['status' => 'error', 'id' => '', 'msg' => 'Пользователь не авторизован']));
    }

    if (!$data['name'] || !$data['email'] || !$data['message']) {

        $arResult = ['status' => 'error', 'id' => '', 'msg' => 'Не заполнены поля'];

        if (!$data['name'])
            $arResult['errors'][] = ['message' => 'Не введено имя',
                                     'field'   => 'name',
                                     'id'      => ''
            ];

        if (!$data['email'])
            $arResult['errors'][] = ['message' => 'Не введен E-mail',
                                     'field'   => 'email',
                                     'id'      => ''
            ];

        if (!$data['message'])
            $arResult['errors'][] = ['message' => 'Не введено сообщение',
                                     'field'   => 'message',
                                     'id'      => ''
            ];

    }

    if ($service_center) {

        $json = array();

        $aRows = [];

        $rsSections = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 81, '=CODE' => $service_center));
        if ($arSection = $rsSections->Fetch()) {

            $el = new CIBlockElement;

            $PROP = array();
            $PROP['name'] = $name;
            $PROP['start'] = date('d.m.Y H:i:s', strtotime($start));
            $PROP['end'] = date('d.m.Y H:i:s', strtotime($end));
            $PROP['email'] = $email;
            $PROP['phone'] = $phone;

            $arLoadProductArray = array(
                "MODIFIED_BY"       => $USER->GetID(),
                "IBLOCK_SECTION_ID" => $arSection['ID'],
                "IBLOCK_ID"         => 81,
                "PROPERTY_VALUES"   => $PROP,
                "NAME"              => $title,
                "PREVIEW_TEXT"      => $message,
                "ACTIVE"            => "Y",
            );

            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                $arResult = ['status'  => 'ok',
                             'id'      => $PRODUCT_ID,
                             'title'   => addslashes(htmlspecialchars($data['name'])),
                             'name'    => addslashes(htmlspecialchars($data['name'])),
                             'email'   => addslashes(htmlspecialchars($data['email'])),
                             'phone'   => addslashes(htmlspecialchars($data['phone'])),
                             'message' => addslashes(htmlspecialchars($data['message'])),
                ];
            }


        }

    }
}

echo json_encode($arResult);

?>