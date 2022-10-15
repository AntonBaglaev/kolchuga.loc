<?
define('NO_AGENT_CHECK', true);
define('NO_KEEP_STATISTIC', true);
//define('NOT_CHECK_PERMISSIONS', true);
define('PUBLIC_AJAX_MODE', true);
define('IEC_SKIP_AUTO_CHECK_QUEUE', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Config\ConfigurationException;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;


Loc::loadMessages(__FILE__);

$moduleId = 'intervolga.conversionpro';

try {
    if (!Loader::includeModule($moduleId)) {
        throw new ConfigurationException(Loc::getMessage('INTERVOLGA_CONVERSIONPRO_MODULE_ERROR'));
    }

    $request = Application::getInstance()->getContext()->getRequest();
    $response = Application::getInstance()->getContext()->getResponse();

    switch ($request->getRequestMethod()) {
        case 'GET':
            $queue = \Intervolga\ConversionPro\Queue::get();
            $response->addHeader('Content-Type: application/json; charset=' . SITE_CHARSET);
            $response->flush($queue);
            break;

        case 'POST':
            $processed = strval($request->getPost('PROCESSED'));
            if (strlen($processed)) {
                $processed = array_map('intval', explode(',', $processed));
                if (count($processed)) {
                    \Intervolga\ConversionPro\Queue::remove($processed);
                }
                \Intervolga\ConversionPro\Visitor::refreshQueueState(true);
                $response->flush('');
            }

            $notReady = strval($request->getPost('NOTREADY'));
            if (('YM' === $notReady || 'UA' === $notReady) &&
                !$_SESSION['INTERVOLGA_CONVERSIONPRO_NOTREADY_' . $notReady]
            ) {
                $_SESSION['INTERVOLGA_CONVERSIONPRO_NOTREADY_' . $notReady] = true;
                \CEventLog::Add(array(
                    'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_MAIN_AJAX',
                    'MODULE_ID' => $moduleId,
                    'DESCRIPTION' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_NOTREADY', array(
                        '#VISITOR_ID#' => \Intervolga\ConversionPro\Visitor::currentVisitorId(),
                        '#COUNTER#' => 'YM' === $notReady ? 'Yandex.Metrika' : 'Universal Analytics'
                    ))
                ));
            }

            $dnt = strval($request->getPost('DNT'));
            if ('Y' === $dnt && !$_SESSION['INTERVOLGA_CONVERSIONPRO_DNT']) {
                $_SESSION['INTERVOLGA_CONVERSIONPRO_DNT'] = true;
                \CEventLog::Add(array(
                    'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_MAIN_AJAX',
                    'MODULE_ID' => $moduleId,
                    'DESCRIPTION' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_DNT', array(
                        '#VISITOR_ID#' => \Intervolga\ConversionPro\Visitor::currentVisitorId()
                    ))
                ));
            }
            break;

        default:
            throw new ArgumentException('Unknown request type');
    }
} catch (\Exception $e) {
    \CEventLog::Add(array(
        'SEVERITY' => 'WARNING',
        'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_MAIN_AJAX',
        'MODULE_ID' => $moduleId,
        'DESCRIPTION' => strval($e)
    ));

    $response = Application::getInstance()->getContext()->getResponse();

    $response->addHeader('Content-Type: text/html; charset=' . SITE_CHARSET);
    $response->setStatus(400);
    $response->flush($e->getMessage());
}

die();
