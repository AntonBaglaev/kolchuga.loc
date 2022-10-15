<?
namespace Intervolga\ConversionPro;


use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;
use Bitrix\Main\UserTable;
use Bitrix\Main\Web\Cookie;

class Visitor
{
    const MODULE_ID = 'intervolga.conversionpro';
    const VISITOR_COOKIE_NAME = 'IEC_VID';
    const ADMIN_COOKIE_NAME = 'IEC_ADM';
    const CHECK_COOKIE_NAME = 'IEC_CHK';
    const COOKIE_LIFETIME = 94608000; //3 * 365 * 24 * 60 * 60
    const ADMIN_GROUP_ID = 1;

    /**
     * @var string|bool|null
     */
    protected static $currentVisitorId = false;
    protected static $watcher_initialized = false;


    /********************************************************************************
     * Get current Visitor/User/FUser/ ID
     ********************************************************************************/

    /**
     * Current Visitor ID
     * @return null|string
     */
    public static function currentVisitorId()
    {
        if (false === self::$currentVisitorId) {
            $request = Application::getInstance()->getContext()->getRequest();
            if (null === $request) {
                self::$currentVisitorId = null;
                return self::$currentVisitorId;
            }

            $visitorId = $request->getCookie(self::VISITOR_COOKIE_NAME);
            if (null !== $visitorId && strlen($visitorId) === 36) {
                self::$currentVisitorId = $visitorId;
            } else {
                self::$currentVisitorId = self::generateVisitorId();
            }

            return self::$currentVisitorId;

        }

        return self::$currentVisitorId;
    }

    /**
     * Current User ID
     *
     * @return int|null
     */
    public static function currentUserId()
    {
        global $USER;

        if (is_object($USER) && $USER->IsAuthorized()) {
            return (int)$USER->GetID();
        }

        $fUser = self::currentFUserId();
        if (null !== $fUser && Loader::includeModule('sale')) {
            $userId = \Bitrix\Sale\Fuser::getUserIdById($fUser);
            if ($userId > 0) {
                return $userId;
            }
        }

        return null;
    }

    /**
     * Current FUser ID
     *
     * @return int|null
     */
    public static function currentFUserId()
    {
        if (!Loader::includeModule('sale')) {
            return null;
        }

        $fUserId = \Bitrix\Sale\Fuser::getId(true);
        return (int)$fUserId > 0 ? $fUserId : null;
    }


    /********************************************************************************
     * Refresh current Visitor/Admin/Queue cookie
     ********************************************************************************/

    /**
     * Set Visitor ID cookie
     */
    public static function refreshVisitorId()
    {
        $visitorCookie = new Cookie(
            self::VISITOR_COOKIE_NAME,
            self::currentVisitorId(),
            time() + self::COOKIE_LIFETIME
        );
        $visitorCookie->setHttpOnly(false);

        // $response->addCookie($cookie) doesn't work with die()
        setcookie(
            $visitorCookie->getName(),
            $visitorCookie->getValue(),
            $visitorCookie->getExpires(),
            $visitorCookie->getPath(),
            $visitorCookie->getDomain(),
            $visitorCookie->getSecure(),
            $visitorCookie->getHttpOnly()
        );
    }

    /**
     * Set "Is Admin" cookie
     */
    public static function refreshIsAdmin()
    {
        if (!self::userIsAdmin()) {
            return;
        }

        $adminCookie = new Cookie(
            self::ADMIN_COOKIE_NAME,
            'Y',
            time() + self::COOKIE_LIFETIME
        );
        $adminCookie->setHttpOnly(false);

        // $response->addCookie($cookie) doesn't work with die()
        setcookie(
            $adminCookie->getName(),
            $adminCookie->getValue(),
            $adminCookie->getExpires(),
            $adminCookie->getPath(),
            $adminCookie->getDomain(),
            $adminCookie->getSecure(),
            $adminCookie->getHttpOnly()
        );
    }

    /**
     * Set "Queue not empty" cookie
     * Skips check if IEC_SKIP_AUTO_CHECK_QUEUE constant set to true
     *
     * @param bool $force if IEC_SKIP_AUTO_CHECK_QUEUE should be forced
     */
    public static function refreshQueueState($force = false)
    {
        if (!$force && defined('IEC_SKIP_AUTO_CHECK_QUEUE') && IEC_SKIP_AUTO_CHECK_QUEUE) {
            return;
        }

        if (defined('ADMIN_SECTION') && ADMIN_SECTION) {
            return;
        }

        if (self::userIsAdmin()) {
            return;
        }

        $checkCookie = new Cookie(self::CHECK_COOKIE_NAME, 'N', -1);
        if (!Queue::isEmpty()) {
            $checkCookie = new Cookie(
                self::CHECK_COOKIE_NAME,
                'Y',
                time() + self::COOKIE_LIFETIME
            );
        }
        $checkCookie->setHttpOnly(false);

        // $response->addCookie($cookie) doesn't work with die()
        setcookie(
            $checkCookie->getName(),
            $checkCookie->getValue(),
            $checkCookie->getExpires(),
            $checkCookie->getPath(),
            $checkCookie->getDomain(),
            $checkCookie->getSecure(),
            $checkCookie->getHttpOnly()
        );
    }


    /********************************************************************************
     * Common methods
     ********************************************************************************/

    /**
     * Check if user is Admin or was it some time ago
     *
     * @param int|null $userId
     * @return bool
     */
    public static function userIsAdmin($userId = null)
    {
        global $USER;

        $currentUserId = self::currentUserId();

        if (null !== $currentUserId &&
            (null === $userId || $currentUserId === $userId) &&
            $USER->IsAdmin()
        ) {
            return true;
        }

        $request = Application::getInstance()->getContext()->getRequest();
        if (null !== $request &&
            (null === $userId || $currentUserId === $userId) &&
            'Y' === $request->getCookie(self::ADMIN_COOKIE_NAME)
        ) {
            return true;
        }

        if ($userId && $currentUserId !== $userId) {
            $userGroups = UserTable::getUserGroupIds($userId);
            if (in_array(self::ADMIN_GROUP_ID, $userGroups)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Generate unique visitor id
     *
     * @return string
     */
    protected static function generateVisitorId()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }


    /**
     * Initialize watcher and it's config
     */
    public static function watch()
    {
        if (self::$watcher_initialized)
            return;

        if (defined('ADMIN_SECTION') && ADMIN_SECTION) {
            return;
        }

        if (defined('PUBLIC_AJAX_MODE') && PUBLIC_AJAX_MODE)
            return;

        \CJSCore::Init(array('ajax'));


        $container = Option::get(self::MODULE_ID, 'container_name');
        $config = array(
            'ready_when' => Option::get(self::MODULE_ID, 'ready_when'),
            'metrika_id' => Option::get(self::MODULE_ID, 'metrika_id'),
            'analytics_id' => Option::get(self::MODULE_ID, 'analytics_id'),
            'container_name' => $container
        );
        if (Loader::includeModule('sale') && Loader::includeModule('currency')) {
            $config['base_currency'] = \IntervolgaConversionProConverter::baseCurrency();
        }
        $initScript = '<script type="text/javascript" data-skip-moving="true">var t = window; t.' . $container . ' = t.' . $container . ' || []; t.conversionpro_config = t.conversionpro_config || ' . \CUtil::PhpToJsObject($config) . ';</script>';
        Asset::getInstance()->addString($initScript, true, AssetLocation::BEFORE_CSS);
        Asset::getInstance()->addJs('/bitrix/js/' . self::MODULE_ID . '/watcher.js');

        if (Loader::includeModule('sale') && Loader::includeModule('currency')) {
            Asset::getInstance()->addJs('/bitrix/js/' . self::MODULE_ID . '/watcher.ecommerce.js');
        }

        self::$watcher_initialized = true;
    }


}