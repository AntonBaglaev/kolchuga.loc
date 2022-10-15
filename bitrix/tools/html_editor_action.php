<?
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isPost()) {
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
    die ();
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/admin/fileman_html_editor_action.php");
?>