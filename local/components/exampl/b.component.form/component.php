<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$request = Application::getInstance()->getContext()->getRequest();
$arFiles = $request->getFileList()->toArray();

if ($request->isPost() && Loader::includeModule('iblock')) {

    $name = trim(strip_tags($request->getPost('name')));
    $email = trim(strip_tags($request->getPost('email')));
    $phone = preg_replace('/[^\d]/', '', trim(strip_tags($request->getPost('phone'))));
    $message = trim(strip_tags($request->getPost('message')));

    $nameReq = trim(strip_tags($request->getPost('PROPERTY_NAME_REQUREARED')));
    $emailReq = trim(strip_tags($request->getPost('PROPERTY_EMAIL_REQUREARED')));
    $phoneReq = trim(strip_tags($request->getPost('PROPERTY_PHONE_REQUREARED')));
    $messageReq = trim(strip_tags($request->getPost('PROPERTY_MESSAGE_REQUREARED')));
    $fileReq = trim(strip_tags($request->getPost('PROPERTY_FILE_REQUREARED')));

    $fileMaxSize = (int)$request->getPost('PROPERTY_FILE_MAX_SIZE');

    $propertyName = (int)$request->getPost('PROPERTY_NAME_ID');
    $propertyEmail = (int)$request->getPost('PROPERTY_EMAIL_ID');
    $propertyPhone = (int)$request->getPost('PROPERTY_PHONE_ID');
    $propertyMessage = (int)$request->getPost('PROPERTY_MESSAGE_ID');
    $propertyFile = (int)$request->getPost('PROPERTY_FILE_ID');

    $iblock = (int)$request->getPost('IBLOCK_ID');
    $arEvent = explode('#', $request->getPost('MESSAGE_ID'));
    $form = trim(strip_tags($request->getPost('FORM_ID')));

    //Проверяем ID формы
    if ($form == $arParams['FORM_ID']) {

        $arResult = [];
        $arProperty = [];

        $arResult['fields']['name'] = $name;
        $arResult['fields']['email'] = $email;
        $arResult['fields']['phone'] = $phone;
        $arResult['fields']['message'] = $message;

        //Имя
        if (empty($name) && $nameReq == 'Y') {

            $arResult['errors']['name'] = Loc::getMessage("ERRORS_NAME");

        } else {

            $arResult['successes']['name'] = $name;

        }

        //Email
        if ((empty($email) && $emailReq == 'Y') || (!empty($email) && !check_email($email))) {

            $arResult['errors']['email'] = Loc::getMessage("ERRORS_EMAIL");

        } else {

            $arResult['successes']['email'] = $email;

        }

        //Телефон
        if ((empty($phone) && $phoneReq == 'Y') || (!empty($phone) && strlen($phone) != 10)) {

            $arResult['errors']['phone'] = Loc::getMessage("ERRORS_PHONE");

        } else {

            $arResult['successes']['phone'] = $phone;

        }

        //Сообщение
        if (empty($message) && $messageReq == 'Y') {

            $arResult['errors']['message'] = Loc::getMessage("ERRORS_MESSAGE");

        } else {

            $arResult['successes']['message'] = $message;

        }

        //Файл
        if ($arFiles['file']['error'] != 0 && $fileReq == 'Y') {

            $arResult['errors']['file'] = Loc::getMessage("ERRORS_FILE");

        } else {

            if ($arFiles['file']['size'] > $fileMaxSize) {

                $arResult['errors']['system'] = Loc::getMessage('ERRORS_FILE_SIZE');

            } else {

                $arResult['successes']['file'] = $arFiles['file'];

            }

        }

        //Проверяем наличие ошибок
        if (empty($arResult['errors'])) {

            //Добавляем новое сообщение
            $newElement = new \CIBlockElement;

            if (!empty($propertyName)) {

                $arProperty[$propertyName] = $name;

            }

            if (!empty($propertyPhone)) {

                $arProperty[$propertyPhone] = $phone;

            }

            if (!empty($propertyEmail)) {

                $arProperty[$propertyEmail] = $email;

            }

            if (!empty($propertyMessage)) {

                $arProperty[$propertyMessage] = $message;

            }

            if (!empty($propertyFile)) {

                if ($arFiles['file']['error'] == 0) {

                    $fileId = \CFile::SaveFile($arFiles['file'], 'ws_simple_form');
                    $filePath = 'http://' . SITE_SERVER_NAME . \CFile::GetPath($fileId);

                    if (!empty($fileId)) {

                        $arProperty[$propertyFile] = $fileId;

                    }

                }

            }

            $arFields = [
                'CREATED_BY' => 1,
                'MODIFIED_BY' => 1,
                'IBLOCK_ID' => $iblock,
                'NAME' => Loc::getMessage("NEW_ELEMENT_NAME") . $name,
                'PROPERTY_VALUES' => $arProperty,
            ];

            $newElementId = $newElement->Add($arFields);

            if (empty($newElementId)) {

                //Отправляем письмо с ошибкой
                $arEventFields = [
                    'MESSAGE' => $newElement->LAST_ERROR,
                ];

                $arResult['errors']['system'] = $newElement->LAST_ERROR;

            } else {

                //Отправляем письмо с сообщением
                $arEventFields = [
                    'NAME' => $name,
                    'PHONE' => $phone,
                    'EMAIL' => $email,
                    'MESSAGE' => $message,
                    'FILE' => ($fileId) ? $filePath : '',
                ];

                $arResult['successes']['result'] = Loc::getMessage("SUCCESSES_RESULT");

            }

            \CEvent::Send($arEvent[1], SITE_ID, $arEventFields, 'Y', $arEvent[0]);

        }

    }

}

//Сохраняем параметры компонента
$_SESSION['SIMPLE_FORM_' . $arParams['FORM_ID']] = $arParams;

//Подключаем шаблон
$this->IncludeComponentTemplate();

?>