<?
namespace Intervolga\ConversionPro;


use Bitrix\Main\Config\ConfigurationException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\Localization\Loc;
use Intervolga\ConversionPro\Internal\OrdersLogTable;
use Intervolga\ConversionPro\Internal\QueueTable;

Loc::loadMessages(__FILE__);

class EQueue
{
    const MODULE_ID = 'intervolga.conversionpro';


    /**
     * Update user basket from old to new
     *
     * @param \Bitrix\Sale\Basket $old
     * @param \Bitrix\Sale\Basket $new
     */
    public static function updateBasket(\Bitrix\Sale\Basket $old, \Bitrix\Sale\Basket $new)
    {
        $oldProducts = \IntervolgaConversionProConverter::basketToProductList($old);
        $newProducts = \IntervolgaConversionProConverter::basketToProductList($new);

        $addedProducts = array_diff_assoc($newProducts, $oldProducts);
        $removedProducts = array_diff_assoc($oldProducts, $newProducts);

        $changedProducts = array_intersect_assoc($newProducts, $oldProducts);
        foreach (array_keys($changedProducts) as $id) {
            $newProduct = $newProducts[$id];
            $oldProduct = $oldProducts[$id];
            $diff = array_diff_assoc($newProduct, $oldProduct);

            if (0 === count($diff)) {
                continue;
            }

            if (1 === count($diff) && array_key_exists('quantity', $diff)) {
                $quantity = floatval($newProduct['quantity']) - floatval($oldProduct['quantity']);

                $diffProduct = $newProduct;
                $diffProduct['quantity'] = abs($quantity);

                if ($quantity > 0) {
                    $addedProducts[$id] = $diffProduct;
                } else {
                    $removedProducts[$id] = $diffProduct;
                };
            } else {
                $removedProducts[$id] = $oldProduct;
                $addedProducts[$id] = $newProduct;
            }
        }

        if (0 === count($addedProducts) + count($removedProducts)) {
            return;
        }

        $action = array(
            'event' => 'ivcp.basket_updated',
            'ecommerce' => array(
                'currencyCode' => \IntervolgaConversionProConverter::baseCurrency(),
            )
        );
        if (count($removedProducts) > 0) {
            $action['ecommerce']['remove'] = array(
                'products' => array_values($removedProducts)
            );
        }
        if (count($addedProducts) > 0) {
            $action['ecommerce']['add'] = array(
                'products' => array_values($addedProducts)
            );
        }
        $action = self::reduceActionSize($action);

        $visitorId = Visitor::currentVisitorId(); // current Visitor

        $fUserId = null; // actual FUser
        if ($foundFUserId = $old->getFUserId(true)) {
        } elseif ($foundFUserId = $new->getFUserId(true)) {
            $fUserId = $foundFUserId;
        }

        $userId = null; // actual User
        if ($fUserId) {
            $foundUserId = \Bitrix\Sale\Fuser::getUserIdById($fUserId);
            if ($foundUserId) {
                $userId = $foundUserId;
            }
        }

        if (Visitor::userIsAdmin($userId)) {
            // Can identify only by Visitor cookie
            $userId = false;
            $fUserId = false;
        }
        if (Visitor::userIsAdmin()) {
            // Can identify only by User/FUser ID
            $visitorId = false;
        }

        // And yes, if current user is admin and customer is admin
        // all identity fields will be false
        Queue::put($action, $visitorId, $userId, $fUserId);
    }


    /**
     * Send order
     *
     * @param \Bitrix\Sale\Order $order
     * @throws ConfigurationException
     * @throws Exception
     */
    public static function addOrder(\Bitrix\Sale\Order $order)
    {
        $orderInLog = OrdersLogTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=ORDER_ID' => $order->getId()),
            'limit' => 1
        ))->fetch();
        if ($orderInLog) {
            return;
        }

        $shouldBeSent = false;
        $sendStrategy = Option::get(self::MODULE_ID, 'send_orders');
        switch ($sendStrategy) {
            case 'pr':
                $shouldBeSent = true;
                break;
            case 'pp':
                foreach ($order->getPaymentCollection() as $payment) {
                    /** @var \Bitrix\Sale\Payment $payment */

                    if ($payment->isPaid()) {
                        $shouldBeSent = true;
                    }
                }
                break;
            case 'fp':
                $shouldBeSent = $order->isPaid();
                break;
            default:
                throw new ConfigurationException(
                    Loc::getMessage('INTERVOLGA_CONVERSIONPRO_UNKNOWN_ORDERS_STRATEGY')
                );
        }
        if (!$shouldBeSent) {
            return;
        }

        $baseCurrency = \IntervolgaConversionProConverter::baseCurrency();
        $actionField = \IntervolgaConversionProConverter::orderToActionField($order);
        $products = \IntervolgaConversionProConverter::basketToProductList($order->getBasket());

        $action = array(
            'event' => 'ivcp.order_processed',
            'ecommerce' => array(
                'currencyCode' => $baseCurrency,
                'purchase' => array(
                    'actionField' => $actionField,
                    'products' => array_values($products)
                )
            )
        );
        $action = self::reduceActionSize($action);

        $visitorId = Visitor::currentVisitorId(); // current Visitor
        $userId = $order->getUserId(); // actual User
        $fUserId = null;
        if ($foundFUserId = $order->getBasket()->getFUserId(true)) {
            $fUserId = $foundFUserId; // actual FUser
        }

        if (Visitor::userIsAdmin($userId)) {
            // Can identify only by Visitor cookie
            $userId = false;
            $fUserId = false;
        }
        if (Visitor::userIsAdmin()) {
            // Can identify only by User/FUser ID
            $visitorId = false;
        }

        // And yes, if current user is admin and customer is admin
        // all identity fields will be false
        Queue::put($action, $visitorId, $userId, $fUserId);

        $addResult = OrdersLogTable::add(array('ORDER_ID' => $order->getId()));
        if (!$addResult->isSuccess()) {
            throw new Exception(implode("\n", $addResult->getErrorMessages()));
        }
    }


    /**
     * Removes product values from action until it fits counter payload
     *
     * @param array $action
     * @return array
     */
    public static function reduceActionSize(array $action)
    {
        $productKeys = array('category', 'brand', 'variant', 'name', 'coupon', 'price', 'quantity');

        do {
            $json = \CUtil::PhpToJSObject($action, false, false, true);
            $currentSize = strlen(urlencode($json));
            if ($currentSize < QueueTable::PAYLOAD_SIZE) {
                return $action;
            }

            $key = array_shift($productKeys);
            $action = self::reduceActionSizeByProductKey($action, $key);

        } while (count($productKeys) > 0);

        return $action;
    }


    /**
     * Remove some value from all products in all ecommerce actions
     *
     * @param array $action
     * @param string $key
     * @return array
     */
    protected static function reduceActionSizeByProductKey(array $action, $key)
    {
        $productsHolders = array('add', 'remove', 'purchase');

        foreach ($productsHolders as $holder) {
            if (!array_key_exists($holder, $action['ecommerce'])) {
                continue;
            }

            $products = $action['ecommerce'][$holder]['products'];
            foreach ($products as $i => $product) {
                $products[$i] = self::reduceProductSizeByKey($product, $key);
            }
            $action['ecommerce'][$holder]['products'] = $products;
        }

        return $action;
    }


    /**
     * Remove some value from product with required fields validation
     *
     * @param array $product
     * @param string $key
     * @return array
     */
    protected static function reduceProductSizeByKey(array $product, $key)
    {
        if ('name' === $key && !$product['id']) {
            return $product;
        }

        unset($product[$key]);

        return $product;
    }
}