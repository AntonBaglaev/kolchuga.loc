<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 04/07/16
 * Time: 00:39
 */

class DataInlifeSplitOrder {

    const IBLOCK_ID = 40;
    const OnlinePropertyCode = 'DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY';

    const DELIVERY_ID = 1;
    const DELIVERY_NAME = 'Согласуется с менеджером';

    const PAYSYSTEM_ID = 1;
    const PAYSYSTEM_NAME = 'Согласуется с менеджером';

    /** @var \Bitrix\Sale\Order  */
    protected $order;
    protected $save;

    public function __construct($order, $save = false)
    {
        $this->order = $order;
        $this->save = $save === true;
    }


    /* Make Result */
    public function split(){

        $unavailableIDS =  $this->getOnlineUnavailable($this->order->getBasket());

        if(!$unavailableIDS)
            return;

        $shipmentCollection = $this->order->getShipmentCollection();
        $this->deleteOnlineUnavailableShipment($shipmentCollection[0], $unavailableIDS);

        $systemShipmentItemCollection = $shipmentCollection->getSystemShipment()->getShipmentItemCollection();
        $newShipmentPrice = $this->createOnlineUnavailableShipment();

        $this->updateOnlineAvailablePaymentPrice($newShipmentPrice);
        $this->createOnlineUnavailablePayment($newShipmentPrice);

        if($this->save)
            $this->order->save();
        else{
            return $this->order;
        }
    }

    /* Получить id товаров недоступных для онлайн оплаты */
    public function getOnlineUnavailable(\Bitrix\Sale\Basket $basket){

        $unavailableItems = array();

        /** @var \Bitrix\Sale\BasketItem $item */
        foreach($basket->getBasketItems() as $item){
            $productID = $item->getProductId();

            $db_props = CIBlockElement::GetProperty(
                self::IBLOCK_ID,
                $productID,
                array("sort" => "asc"),
                Array("CODE" => self::OnlinePropertyCode)
            );

            $buy_online = $db_props->Fetch()['VALUE_XML_ID'];

            if($buy_online !== 'true')
                $unavailableItems[] = $item->getId();

        }

        return $unavailableItems;
    }

    /* Удалить недоступные товары из текущей отгрузки */
    public function deleteOnlineUnavailableShipment(\Bitrix\Sale\Shipment $shipment, $basket_ids){

        /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        /** @var \Bitrix\Sale\ShipmentItem $item */
        foreach($shipment->getShipmentItemCollection() as $item){
            if(in_array($item->getBasketId(), $basket_ids)){
                $item->delete();
                $this->order->onShipmentCollectionModify('DELETE', $shipment);
            }
        }
    }
    /* Создать отгрузку из товаров недоступных для онлайн оплаты (вернёт сумму отгрузки) */
    public function createOnlineUnavailableShipment(){

        /** @var \Bitrix\Sale\Shipment $shipment */
        $shipment = $this->order->getShipmentCollection()->createItem();

        /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
        $shipmentCollection = $shipment->getCollection();

        $systemShipment = $shipmentCollection->getSystemShipment();

        /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
        $systemShipmentItemCollection = $systemShipment->getShipmentItemCollection();

        /** @var \Bitrix\Sale\ShipmentItemCollection $shipmentItemCollection */
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        $productPrice = 0;

        /** @var \Bitrix\Sale\ShipmentItem $item */
        foreach($systemShipmentItemCollection as $item){

            if ($item->getQuantity() <= 0)
                continue;

            $basketItem = $item->getBasketItem();
            $shipmentItem = $shipmentItemCollection->createItem($basketItem);
            $shipmentItem->setField('QUANTITY', $item->getQuantity());

            $productPrice += floatval($basketItem->getPrice()) * $shipmentItem->getQuantity();

        }

        $shipment->setField('CUSTOM_PRICE_DELIVERY', 'N');
        $shipment->setField('DELIVERY_ID', self::DELIVERY_ID);
        $shipment->setField('COMPANY_ID', $systemShipment->getField('COMPANY_ID'));
        $shipment->setField('DELIVERY_NAME', self::DELIVERY_NAME);
        $shipment->setExtraServices($systemShipment->getExtraServices());
        $shipment->setStoreId($systemShipment->getStoreId());

        $price = \Bitrix\Sale\Helpers\Admin\Blocks\OrderShipment::getDeliveryPrice($shipment);
        $shipment->setField('BASE_PRICE_DELIVERY', $price);

        $resultPrice = $productPrice + floatval($price);

        return $resultPrice;

    }
    /* Обновить текущую оплату (вычесть сумму недоступных товаров для онлайн оплаты) */
    public function updateOnlineAvailablePaymentPrice($unavailablePrice){
        /** @var \Bitrix\Sale\Payment $payment */
        $payment = $this->order->getPaymentCollection()[0];
        $payment->setField('SUM', floatval($payment->getField('SUM')) - $unavailablePrice);
    }
    /* Создать новую оплату для товаров недоступных онлайн */
    public function createOnlineUnavailablePayment($unavailablePrice){
        /** @var \Bitrix\Sale\Payment $payment */
        $payment = $this->order->getPaymentCollection()->createItem();
        $payment->setField('PAY_SYSTEM_ID', self::PAYSYSTEM_ID);
        $payment->setField('PAY_SYSTEM_NAME', self::PAYSYSTEM_NAME);
        $payment->setField('SUM', $unavailablePrice);
    }

}
