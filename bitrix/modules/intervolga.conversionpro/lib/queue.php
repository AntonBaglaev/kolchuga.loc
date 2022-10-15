<?

namespace Intervolga\ConversionPro;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;

Loc::loadMessages(__FILE__);

class Queue
{
    const MODULE_ID = 'intervolga.conversionpro';

    /**
     * Put event in Queue
     *
     * @param $data
     * @param null|bool|string $visitorId
     * @param null|bool|int $userId
     * @param null|bool|int $fUserId
     * @throws Exception
     * @throws NotSupportedException
     */
    public static function put($data, $visitorId = null, $userId = null, $fUserId = null)
    {
        if (false === $visitorId && false === $userId && false === $fUserId) {
            throw new NotSupportedException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_REQUIRED_FIELDS', array(
                    '#DATA#' => \CUtil::PhpToJSObject($data, false, false, true)
                ))
            );
        }

        if (Visitor::userIsAdmin($userId)) {
            throw new NotSupportedException(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_ADMIN_DENIED', array(
                    '#DATA#' => \CUtil::PhpToJSObject($data, false, false, true)
                ))
            );
        }

        if (null === $visitorId) {
            $visitorId = Visitor::currentVisitorId();
        }
        if (null === $userId) {
            $userId = Visitor::currentUserId();
        }
        if (null === $fUserId) {
            $fUserId = Visitor::currentFUserId();
        }

        $addResult = Internal\QueueTable::add(array(
            'VISITOR_UUID' => $visitorId,
            'USER_ID' => $userId,
            'FUSER_ID' => $fUserId,
            'DATA' => $data,
        ));

        if (!$addResult->isSuccess()) {
            throw new Exception(implode("\n", $addResult->getErrorMessages()));
        }

        Visitor::refreshQueueState();
    }

    /**
     * Return personal Queue as JSON list
     *
     * @return string
     */
    public static function get()
    {
        $filter = self::personalFilter(
            Visitor::currentVisitorId(),
            Visitor::currentUserId(),
            Visitor::currentFUserId()
        );
        if (null === $filter) {
            return '[]';
        }

        $queue = Internal\QueueTable::getList(array(
            'select' => array('ID', 'DATA'),
            'filter' => $filter,
            'order' => array('ID'),
            'limit' => 10
        ))->fetchAll();

        $result = array();
        foreach ($queue as $q) {
            $result[] = '{\'ID\':' . intval($q['ID']) . ',\'DATA\':' . $q['DATA'] . '}';
        }

        return '[' . implode(',', $result) . ']';
    }

    /**
     * Check if personal Queue is empty
     *
     * @return bool
     */
    public static function isEmpty()
    {
        $filter = self::personalFilter(
            Visitor::currentVisitorId(),
            Visitor::currentUserId(),
            Visitor::currentFUserId()
        );
        if (null === $filter) {
            return true;
        }

        $firstEvent = Internal\QueueTable::getList(array(
            'select' => array('ID'),
            'filter' => $filter,
            'limit' => 1
        ))->fetch();
//        $query = Internal\QueueTable::query()->getLastQuery();
//        \Bitrix\Main\Diag\Debug::dumpToFile($query, 'isEmpty', '/ec.txt');

        return !$firstEvent;
    }


    /**
     * Remove processed events
     *
     * @param array $processed
     * @throws ArgumentNullException
     * @throws Exception
     */
    public static function remove(array $processed)
    {
        if (!count($processed)) {
            throw new ArgumentNullException('processed');
        }

        $filter = self::personalFilter(
            Visitor::currentVisitorId(),
            Visitor::currentUserId(),
            Visitor::currentFUserId()
        );
        if (null === $filter) {
            return;
        }

        $queue = Internal\QueueTable::getList(array(
            'select' => array('ID'),
            'filter' => array(
                '=ID' => $processed,
                $filter
            )
        ))->fetchAll();
        $queue = ivcp_array_column($queue, 'ID');

        if (!count($queue)) {
            $usedFilter = array('=ID' => $processed, $filter);
            $usedFilterJson = \CUtil::PhpToJSObject(
                $usedFilter, false, false, true);
            throw new Exception(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_REMOVE_FILTER', array(
                    '#FILTER#' => $usedFilterJson
                ))
            );
        }

        foreach ($queue as $id) {
            $result = Internal\QueueTable::delete($id);
            if (!$result->isSuccess()) {
                throw new Exception(implode("\n", $result->getErrorMessages()));
            }
        }

        Visitor::refreshQueueState();
    }


    /**
     * Remove old events
     */
    public static function clean()
    {
        $waitDeadline = (int)Option::get(self::MODULE_ID, 'wait_deadline');
        if (0 === $waitDeadline) {
            return;
        }

        $deadline = new Type\DateTime();
        $deadline->add('-' . $waitDeadline . 'D');

        $queue = Internal\QueueTable::getList(array(
            'select' => array('ID'),
            'filter' => array('<TIMESTAMP' => $deadline),
        ))->fetchAll();
        $queue = ivcp_array_column($queue, 'ID');

        foreach ($queue as $id) {
            Internal\QueueTable::delete($id);
        }
    }


    /**
     * Periodic agent
     *
     * @return string
     */
    public static function cleanAgent()
    {
        try {
            self::clean();
        } catch (\Exception $e) {
            \CEventLog::Add(array(
                'SEVERITY' => 'WARNING',
                'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_QUEUE_AGENT',
                'MODULE_ID' => self::MODULE_ID,
                'DESCRIPTION' => strval($e)
            ));
        }

        return '\Intervolga\ConversionPro\Queue::cleanAgent();';
    }

    /**
     * Generate filter for Internal\QueueTable
     *
     * @param null|string $visitorId
     * @param null|int $userId
     * @param null|int $fUserId
     * @return null|array
     */
    protected static function personalFilter($visitorId = null, $userId = null, $fUserId = null)
    {
        $filter = array();
        if ($visitorId && strlen($visitorId)) {
            $filter['=VISITOR_UUID'] = $visitorId;
        }
        if ($userId && (int)$userId > 0) {
            $filter['=USER_ID'] = $userId;
        }
        if ($fUserId && (int)$fUserId > 0) {
            $filter['=FUSER_ID'] = $fUserId;
        }

        $conditionsCount = count($filter);
        if (0 === $conditionsCount) {
            return null;
        } elseif (1 === $conditionsCount) {
            return $filter;
        }

        return array_merge(array('LOGIC' => 'OR'), $filter);
    }
}
