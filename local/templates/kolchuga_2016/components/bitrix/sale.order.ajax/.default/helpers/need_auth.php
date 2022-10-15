<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 10/09/15
 * Time: 14:48
 */


if (!empty($arResult["ERROR"])) {
    foreach ($arResult["ERROR"] as $v)
        echo ShowError($v);
} elseif (!empty($arResult["OK_MESSAGE"])) {
    foreach ($arResult["OK_MESSAGE"] as $v)
        echo ShowNote($v);
}

include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/auth.php");
