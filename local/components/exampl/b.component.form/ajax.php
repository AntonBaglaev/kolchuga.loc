<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $form = trim(strip_tags($request->getPost('FORM_ID')));

    if (!empty($form) && !empty($_SESSION['SIMPLE_FORM_' . $form])) {

        $APPLICATION->IncludeComponent(
            "ws:simple.form",
            $_SESSION['SIMPLE_FORM_' . $form]['COMPONENT_TEMPLATE'],
            $_SESSION['SIMPLE_FORM_' . $form],
            false
        );

    }

}
?>

