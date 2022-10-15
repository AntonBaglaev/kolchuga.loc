<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (Loader::includeModule('iblock')) {

    //Получаем список типов инфоблоков
    $arOrder = ["SORT" => "ASC"];
    $arFilter = [
        "ACTIVE" => "Y",
    ];

    $res = CIBlockType::GetList($arOrder, $arFilter);
    while ($arRes = $res->GetNext()) {

        //Настройки типа информационных блоков по ID
        if ($arResType = CIBlockType::GetByIDLang($arRes["ID"], LANG, true)) {

            $iblockTypeId = $arResType["ID"];
            $iblockTypeName = $arResType["NAME"];
            $arIblockType[$iblockTypeId] = $iblockTypeName;

        }

    }

    //Получаем список инфоблоков выбранного типа
    $arOrder = ["SORT" => "ASC"];
    $arFilter = [
        "ACTIVE" => "Y",
        "TYPE" => $arCurrentValues["IBLOCK_TYPE"],
    ];

    $res = CIBlock::GetList($arOrder, $arFilter, true);
    while ($arRes = $res->Fetch()) {

        $iblockId = $arRes["ID"];
        $iblockName = $arRes["NAME"];
        $arIblock[$iblockId] = $iblockName;

    }

    //Получаем список пользовательских свойств выбранного инфоблока
    $arOrder = ["SORT" => "ASC", "NAME" => "ASC"];
    $arFilter = [
        "ACTIVE" => "Y",
        "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"],
    ];

    $arProperty[] = Loc::getMessage("PROPERTY_GETLIST_DEFAULT");

    $res = CIBlockProperty::GetList($arOrder, $arFilter, true);
    while ($arRes = $res->GetNext()) {

        $propertyId = $arRes["ID"];
        $propertyName = $arRes["NAME"];
        $arProperty[$propertyId] = $propertyName;

    }

    //Почтовые шаблоны
    $arEvent = [];
    $dbType = CEventMessage::GetList($by = "EVENT_NAME", $order = "DESC", $arFilter);
    while ($arType = $dbType->GetNext()) {

        $arEvent[$arType["ID"] . '#' . $arType["EVENT_NAME"]] = $arType["EVENT_NAME"] . ' - ' . "[" . $arType["ID"] . "] ";

    }

}

//Параметры входных настроек компонента
$arComponentParameters = [
    "GROUPS" => [
        "BLOCK1" => [
            "NAME" => Loc::getMessage("BLOCK1_NAME"),
            "SORT" => "100",
        ],
        "BLOCK2" => [
            "NAME" => Loc::getMessage("BLOCK2_NAME"),
            "SORT" => "200",
        ],
        "BLOCK3" => [
            "NAME" => Loc::getMessage("BLOCK3_NAME"),
            "SORT" => "300",
        ],
        "BLOCK4" => [
            "NAME" => Loc::getMessage("BLOCK4_NAME"),
            "SORT" => "400",
        ],
        "BLOCK4.1" => [
            "NAME" => Loc::getMessage("BLOCK4.1_NAME"),
            "SORT" => "400",
        ],
        "BLOCK4.2" => [
            "NAME" => Loc::getMessage("BLOCK4.2_NAME"),
            "SORT" => "400",
        ],
        "BLOCK4.3" => [
            "NAME" => Loc::getMessage("BLOCK4.3_NAME"),
            "SORT" => "400",
        ],
        "BLOCK4.4" => [
            "NAME" => Loc::getMessage("BLOCK4.4_NAME"),
            "SORT" => "400",
        ],
        "BLOCK4.5" => [
            "NAME" => Loc::getMessage("BLOCK4.5_NAME"),
            "SORT" => "400",
        ],
    ],
    "PARAMETERS" => [
        //Работа в режиме Ajax
        "FORM_AJAX_MODE" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_AJAX_MODE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        //Заголовок формы
        "FORM_TITLE_TEXT" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_TITLE_TEXT_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("FORM_TITLE_TEXT_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Подзаголовок формы
        "FORM_SUBTITLE_TEXT" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_SUBTITLE_TEXT_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("FORM_SUBTITLE_TEXT_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Текст на кнопке Отправить
        "FORM_BUTTON_TEXT" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_BUTTON_TEXT_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("FORM_BUTTON_TEXT_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Текст успешной отправки
        "FORM_SUCCESS_TEXT" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_SUCCESS_TEXT_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("FORM_SUCCESS_TEXT_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Текст при возникновении ошибок
        "FORM_ERROR_TEXT" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_ERROR_TEXT_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("FORM_ERROR_TEXT_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Идентификатор формы
        "FORM_ID" => [
            "PARENT" => "BLOCK1",
            "NAME" => Loc::getMessage("FORM_ID_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => "SF_" . time(),
            "REFRESH" => "N",
        ],
        //Выберите тип инфоблока
        "IBLOCK_TYPE" => [
            "PARENT" => "BLOCK2",
            "NAME" => Loc::getMessage("IBLOCK_TYPE_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arIblockType,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "Y",
            "MULTIPLE" => "N",
        ],
        //Выберите инфоблок
        "IBLOCK_ID" => [
            "PARENT" => "BLOCK2",
            "NAME" => Loc::getMessage("IBLOCK_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arIblock,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
            "MULTIPLE" => "N",
        ],
        //Выберите почтовый шаблон
        "MESSAGE_ID" => [
            "PARENT" => "BLOCK3",
            "NAME" => Loc::getMessage("MESSAGE_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arEvent,
            "DEFAULT" => "",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        //Имя
        "PROPERTY_NAME_ID" => [
            "PARENT" => "BLOCK4.1",
            "NAME" => Loc::getMessage("PROPERTY_NAME_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arProperty,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        "PROPERTY_NAME_TITLE" => [
            "PARENT" => "BLOCK4.1",
            "NAME" => Loc::getMessage("PROPERTY_NAME_TITLE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_NAME_TITLE_DEFAULT"),
            "REFRESH" => "N",
        ],
        "PROPERTY_NAME_HIDE" => [
            "PARENT" => "BLOCK4.1",
            "NAME" => Loc::getMessage("PROPERTY_NAME_HIDE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_NAME_REQUREARED" => [
            "PARENT" => "BLOCK4.1",
            "NAME" => Loc::getMessage("PROPERTY_NAME_REQUREARED_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
        //E-mail
        "PROPERTY_EMAIL_ID" => [
            "PARENT" => "BLOCK4.2",
            "NAME" => Loc::getMessage("PROPERTY_EMAIL_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arProperty,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        "PROPERTY_EMAIL_TITLE" => [
            "PARENT" => "BLOCK4.2",
            "NAME" => Loc::getMessage("PROPERTY_EMAIL_TITLE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_EMAIL_TITLE_DEFAULT"),
            "REFRESH" => "N",
        ],
        "PROPERTY_EMAIL_HIDE" => [
            "PARENT" => "BLOCK4.2",
            "NAME" => Loc::getMessage("PROPERTY_EMAIL_HIDE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_EMAIL_REQUREARED" => [
            "PARENT" => "BLOCK4.2",
            "NAME" => Loc::getMessage("PROPERTY_EMAIL_REQUREARED_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        //Телефон
        "PROPERTY_PHONE_ID" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arProperty,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        "PROPERTY_PHONE_TITLE" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_TITLE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_PHONE_TITLE_DEFAULT"),
            "REFRESH" => "N",
        ],
        "PROPERTY_PHONE_HIDE" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_HIDE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_PHONE_REQUREARED" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_REQUREARED_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_PHONE_MASK" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_MASK_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_PHONE_MASK_CODE" => [
            "PARENT" => "BLOCK4.3",
            "NAME" => Loc::getMessage("PROPERTY_PHONE_MASK_CODE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_PHONE_MASK_CODE_DEFAULT"),
            "REFRESH" => "N",
        ],
        //Сообщение
        "PROPERTY_MESSAGE_ID" => [
            "PARENT" => "BLOCK4.4",
            "NAME" => Loc::getMessage("PROPERTY_MESSAGE_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arProperty,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        "PROPERTY_MESSAGE_TITLE" => [
            "PARENT" => "BLOCK4.4",
            "NAME" => Loc::getMessage("PROPERTY_MESSAGE_TITLE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_MESSAGE_TITLE_DEFAULT"),
            "REFRESH" => "N",
        ],
        "PROPERTY_MESSAGE_HIDE" => [
            "PARENT" => "BLOCK4.4",
            "NAME" => Loc::getMessage("PROPERTY_MESSAGE_HIDE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_MESSAGE_REQUREARED" => [
            "PARENT" => "BLOCK4.4",
            "NAME" => Loc::getMessage("PROPERTY_MESSAGE_REQUREARED_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        //Файл
        "PROPERTY_FILE_ID" => [
            "PARENT" => "BLOCK4.5",
            "NAME" => Loc::getMessage("PROPERTY_FILE_ID_NAME"),
            "TYPE" => "LIST",
            "VALUES" => $arProperty,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "SIZE" => 1,
        ],
        "PROPERTY_FILE_TITLE" => [
            "PARENT" => "BLOCK4.5",
            "NAME" => Loc::getMessage("PROPERTY_FILE_TITLE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_FILE_TITLE_DEFAULT"),
            "REFRESH" => "N",
        ],
        "PROPERTY_FILE_HIDE" => [
            "PARENT" => "BLOCK4.5",
            "NAME" => Loc::getMessage("PROPERTY_FILE_HIDE_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_FILE_REQUREARED" => [
            "PARENT" => "BLOCK4.5",
            "NAME" => Loc::getMessage("PROPERTY_FILE_REQUREARED_NAME"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ],
        "PROPERTY_FILE_MAX_SIZE" => [
            "PARENT" => "BLOCK4.5",
            "NAME" => Loc::getMessage("PROPERTY_FILE_MAX_SIZE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("PROPERTY_FILE_MAX_SIZE_DEFAULT"),
            "REFRESH" => "N",
        ],
    ],
];

?>