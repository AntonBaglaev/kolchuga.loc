<?
namespace Intervolga\ConversionPro\Internal;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;

Loc::loadMessages(__FILE__);

class OrdersLogTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'intervolga_conversionpro_orders_log';
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
            new Entity\IntegerField('ORDER_ID', array(
                'required' => true,
                'default_value' => 0
            ))
        );
    }
}
