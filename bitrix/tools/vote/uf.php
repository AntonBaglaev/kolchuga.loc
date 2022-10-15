<?
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isPost()) {
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
    die ();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/tools/uf.php");?>