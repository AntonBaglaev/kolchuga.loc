<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $price = (int)$request->getPost('price');
    $_SESSION['DELIVERY_PRICE'] = $price;

}

?>