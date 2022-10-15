<?
namespace Intervolga\ConversionPro\Internal;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;

Loc::loadMessages(__FILE__);

class QueueTable extends Entity\DataManager
{
    const MODULE_ID = 'intervolga.conversionpro';
    const PAYLOAD_SIZE = 7000;

    public static function getTableName()
    {
        return 'intervolga_conversionpro_queue';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\DatetimeField('TIMESTAMP', array(
                'required' => true,
                'default_value' => new Type\DateTime()
            )),
            new Entity\StringField('VISITOR_UUID', array(
                'size' => 36,
                'default_value' => ''
            )),
            new Entity\IntegerField('USER_ID', array(
                'required' => true,
                'default_value' => 0
            )),
            new Entity\IntegerField('FUSER_ID', array(
                'required' => true,
                'default_value' => 0
            )),
            new Entity\TextField('DATA', array(
                'required' => true,
                'default_value' => array(),
                'save_data_modification' => function () {
                    return array(
                        function ($value) {
                            // Measurement protocol GET payload should be less than 8000 bytes
                            // About 1000 bytes taken by default UA parameters
                            // So, we have about 7000 bytes in urlencoded representation

//                            TODO: \Bitrix\Main\Web\Json::encode()
                            $json = \CUtil::PhpToJSObject($value, false, false, true);

                            if (strlen(urlencode($json)) > QueueTable::PAYLOAD_SIZE) {
                                \CEventLog::Add(array(
                                    'SEVERITY' => 'WARNING',
                                    'AUDIT_TYPE_ID' => 'INTERVOLGA_CONVERSIONPRO_QUEUE_DATA_TOO_LONG',
                                    'MODULE_ID' => QueueTable::MODULE_ID,
                                    'DESCRIPTION' => Loc::getMessage('INTERVOLGA_CONVERSIONPRO_QUEUE_DATA_TOO_LONG', array(
                                        '#DATA#' => $json
                                    ))
                                ));
                            }

                            return $json;
                        }
                    );
                }
            )),
        );
    }

    public static function onBeforeAdd(Entity\Event $ev)
    {
        $result = new Entity\EventResult;
        $fields = $ev->getParameter('fields');

        if ('' === (string)$fields['VISITOR_UUID'] && 0 === (int)$fields['USER_ID'] && 0 === (int)$fields['FUSER_ID']) {
            $result->addError(new Entity\EntityError(
                Loc::getMessage('INTERVOLGA_CONVERSIONPRO_REQUIRED_FIELDS')
            ));
        }

        $identityFields = array();
        if (array_key_exists('VISITOR_UUID', $fields)) {
            $identityFields['VISITOR_UUID'] = (string)$fields['VISITOR_UUID'];
        }
        if (array_key_exists('USER_ID', $fields)) {
            $identityFields['USER_ID'] = (int)$fields['USER_ID'];
        }
        if (array_key_exists('FUSER_ID', $fields)) {
            $identityFields['FUSER_ID'] = (int)$fields['FUSER_ID'];
        }

        if (count($identityFields)) {
            $result->modifyFields($identityFields);
        }

        return $result;
    }

    public static function onBeforeUpdate(Entity\Event $ev)
    {
        $result = new Entity\EventResult;

        $result->addError(new Entity\EntityError(
            Loc::getMessage('INTERVOLGA_CONVERSIONPRO_UPDATE_DENIED')
        ));

        return $result;
    }
}
