<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

parse_str($_REQUEST['data'], $data);

$arResult = ['status' => 'error', 'msg' => ''];

if (empty($data['AUTH_ANTIBOT'])) {

    $email = addslashes(htmlspecialchars($data['email']));
    $password = addslashes(htmlspecialchars($_REQUEST['password']));

    if (!$data['email'] || !$data['password']) {

        $arResult = ['status' => 'error', 'msg' => ''];

        if (!$data['email'])
            $arResult['errors'][] = ['message' => 'Не введен E-mail',
                                     'field'   => 'email'
            ];

        if (!$data['password'])
            $arResult['errors'][] = ['message' => 'Не введен пароль',
                                     'field'   => 'password'
            ];

        die(json_encode($arResult));
    }

    if ($data['email'] && $data['password']) {

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $arFilter["EMAIL"] = htmlspecialchars(addslashes($data['email']));
        else
            $arFilter['LOGIN'] = htmlspecialchars(addslashes($data['password']));

        $rsUser = \CUser::GetList($by, $order, $arFilter);
        if ($arUser = $rsUser->Fetch()) {

            if ($arUser["LOGIN"]) {
                $arAuthResult = (new \CUser)->Login($arUser["LOGIN"],
                    htmlspecialchars($data['password']),
                    (isset($data['USER_REMEMBER']) && $data['USER_REMEMBER'] == 'Y' ? 'Y' : 'N')
                );
                $APPLICATION->arAuthResult = $arAuthResult;

                if ($arAuthResult['TYPE'] == 'ERROR') {
                    $arResult = ['status' => 'error', 'msg' => $arAuthResult['MESSAGE']];
                } elseif ($arAuthResult === true) {
                    $arResult = ['status' => 'ok', 'msg' => ''];
                }
            }

        }

    }
}

echo json_encode($arResult);

?>