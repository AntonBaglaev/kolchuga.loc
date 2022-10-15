<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 03.04.2018
 * Time: 0:31
 */

namespace litebox\kassa\lib\Api\Methods\v1;


use litebox\kassa\lib\Template\Orders\Files;
use litebox\kassa\lib\Template\Orders\Item;
use litebox\kassa\lib\Template\Orders\Order;
use litebox\kassa\lib\Template\Orders\OrderItemOption;
use litebox\kassa\lib\Template\Orders\PersonInfo;
use litebox\kassa\lib\Template\Orders\ShippingOptionInfo;
use Bitrix\Main\Diag\Debug;

class Orders extends Base
{
    /**
     * @param null $updatedFrom
     * @return string
     */
    public function executeGET($updatedFrom = null, $id = null)
    {
        $ID = $id;
        $data = json_decode(file_get_contents('php://input'));
        if (isset($data['ID'])) {
            $ID = $data;
        }
        $arFilter = [];
        $arOrder = [
            'DATE_INSERT' => 'ASC'
        ];

        if ($ID) {
            $arFilter['ID'] = $ID;
        }

        if (!is_null($updatedFrom)) {
            if (is_numeric($updatedFrom)) {
                $date = new \DateTime();

                $date->setTimestamp($updatedFrom);

                $updatedFrom = clone $date;
            } else {
                $updatedFrom = new \DateTime($updatedFrom);
            }

            if ($updatedFrom) {
                $arFilter['>=DATE_UPDATE'] = $updatedFrom->format('d.m.Y H:i:s');
            }
        }

        $arNavParam = [
            'nPageSize' => $this->result->pageSize,
            'iNumPage' => $this->result->page,
            'checkOutOfRange' => true,
        ];

        $data = $this->getList($arOrder, $arFilter, [], $arNavParam);

        foreach ($data as $dataItem) {
            $paymentInfo = $this->getPaymentSystem($dataItem['PAY_SYSTEM_ID']);
            $dataItem['PAY_SYSTEM_NAME'] = $paymentInfo['NAME'];

            $status = \CSaleStatus::GetByID($dataItem['STATUS_ID']);

            $deliveryInfo = \CSaleDelivery::GetByID($dataItem['DELIVERY_ID']);

            //DELIVERY_ID
            $dataItem['DELIVERY_NAME'] = $deliveryInfo['NAME'];


            $statusCode = $dataItem['STATUS_ID'];

            if ($statusCode == 'F') {
                $dataItem['STATUS_NAME'] = 'PAID';
            } else {
                $dataItem['STATUS_NAME'] = 'AWAITING_PAYMENT';
            }

            $statusDelivery = $dataItem['STATUS_ID'];

            if ($statusDelivery == 'DF') {
                $dataItem['DELIVERY_NAME'] = 'DELIVERED';
            } else {
                $dataItem['DELIVERY_NAME'] = 'AWAITING_PROCESSING';
            }


            $resultObj = new Order($dataItem);

            //нужно заводить новые статусы оплат точно такие же как и в ecwid
            //доделать купоны и налоги

            $groupUser = $this->getGroupId($resultObj->customerId);

            $resultObj->customerGroup = $groupUser['NAME'];

            $items = $this->getItemsOrder($dataItem['ID']);

            $subtotal = 0;

            foreach ($items as &$item) {
                $itemData = $this->getItemData($item['PRODUCT_ID']);
                $itemData = array_pop($itemData);
                $itemData['PRODUCT_ID'] = $item['PRODUCT_ID'];
                $itemData['ID'] = $item['ID'];
                $itemData['QUANTITY_STORE'] = $itemData['QUANTITY'];
                $itemData['QUANTITY'] = $item['QUANTITY'];
                $itemData['PRICE'] = $item['PRICE'];
                $itemData['BASE_PRICE'] = $item['BASE_PRICE'];
                $itemData['VAT_RATE'] = $item['VAT_RATE'];

                $itemData['couponApplied'] = (!$item['DISCOUNT_PRICE']) ? true : false;

                $dataSKU = $this->getSKU($itemData['PRODUCT_ID']);

                $itemData['sku'] = $dataSKU['ID'];

                $productData = $this->getDataProduct($dataSKU['IBLOCK_ID'], $dataSKU['ID']);
                $productData = array_pop($productData);

                $productPic = $this->getPicture($productData['DETAIL_PICTURE']);

                $itemData['imageUrl'] = $this->getBaseUrl() . $productPic['SRC'];

                $itemData['shortDescription'] = $productData['PREVIEW_TEXT'];

                if ($itemData['PRICE_TYPE'] == 'S' || $itemData['PRICE_TYPE'] == 'R') {
                    $itemData['isShippingRequired'] = true;
                }

                $itemData['categoryId'] = $item['CATALOG_XML_ID'];

                $billdata = $this->getBillDataOrder($dataItem['ID']);

                $itemProd = new Item($itemData);

                $productPic['SRC'] = $this->getBaseUrl() . $productPic['SRC'];

                $itemProd->files[] = new Files($productPic);


                $propsProduct = $this->getSelectedProperties($item['PRODUCT_ID']);

                foreach ($propsProduct as $propertyItem) {
                    $itemProd->selectedOptions[] = new OrderItemOption($propertyItem);
                }

                $resultObj->items[] = $itemProd;

                $resultObj->billingPerson = new PersonInfo($billdata);
                $resultObj->shippingPerson = $resultObj->billingPerson;

                $delivery = $this->getDelivery($dataItem['DELIVERY_ID']);
                $delivery['period'] = $delivery['PERIOD_TO'] - $delivery['PERIOD_FROM'];

                $delivery["VAT_CODE"] = $this->getVat(\CCatalogVat::GetByID($delivery['VAT_ID']));

                $resultObj->shippingOption = new ShippingOptionInfo($delivery);

                $subtotal += $item['PRICE'];
            }

            $resultObj->subtotal = $subtotal;

            if ($ID) {
                $this->result = $resultObj;
            } else {
                $this->result->items[] = $resultObj;
            }
        }

        return $this->result;
    }




    public function executePOST($id = null)
    {
        $data = json_decode(file_get_contents('php://input'));

        $resultAdd = false;

        if (!$id) {
            $products = [];

            foreach ($data->items as $product) {
                $products[] = [
                    'PRODUCT_ID' => $product->productId,
                    'NAME' => $product->name,
                    'PRICE' => $product->price,
                    'CURRENCY' => 'RUB',
                    'QUANTITY' => $product->quantity,
                ];
            }

            $basket = \Bitrix\Sale\Basket::create(SITE_ID);

            foreach ($products as $product) {
                $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
                unset($product["PRODUCT_ID"]);
                $item->setFields($product);
            }

            $order = \Bitrix\Sale\Order::create(SITE_ID, 1);
            $order->setPersonTypeId(1);
            $order->setBasket($basket);

            $shipmentCollection = $order->getShipmentCollection();
            $shipment = $shipmentCollection->createItem(
                \Bitrix\Sale\Delivery\Services\Manager::getObjectById(1)
            );

            $shipmentItemCollection = $shipment->getShipmentItemCollection();

            foreach ($basket as $basketItem) {
                $item = $shipmentItemCollection->createItem($basketItem);
                $item->setQuantity($basketItem->getQuantity());
            }

            $paymentCollection = $order->getPaymentCollection();
            $payment = $paymentCollection->createItem(
                \Bitrix\Sale\PaySystem\Manager::getObjectById(1)
            );

            $payment->setField("SUM", $order->getPrice());
            $payment->setField("CURRENCY", $order->getCurrency());

            $result = $order->save();

            $resultAdd = $result->isSuccess();

            $id = $result->getId();
        }
        if ($resultAdd || $id)
        {
            $STATUS_ID = null;
            $DELIVERY_ID = null;

            if ($data->paymentStatus == 'PAID') {
                $STATUS_ID = 'F';
            } else {
                $STATUS_ID = 'N';
            }

            if ($data->fulfillmentStatus == 'DELIVERED') {
                $DELIVERY_ID = 'DF';
                $order = \Bitrix\Sale\Order::load($id);
                $shipments = $order->getShipmentCollection();

                foreach ($shipments as $shipment)
                {
                    if(!$shipment->isSystem())
                    {
                        $shipment->setField('STATUS_ID', $DELIVERY_ID);
                        $shipment->setField('DEDUCTED', 'Y');
                    }
                }

                $shipments->AllowDelivery();
                $payments = $order->getPaymentCollection();
                $payments[0]->setPaid('Y');


                $payments[0]->save();
                $order->save();

            } else {
                $DELIVERY_ID = 'DN';
            }


            \CSaleOrder::Update($id, [
                'STATUS_ID' => $STATUS_ID,
                'DELIVERY_ID' => $DELIVERY_ID,
            ]);
            //$result->getErrors();
        }

        return ['id' => $id];
    }


    //*********************************
    private function getVat($QueryVat)
    {
        $res = "";
        if($Vat = $QueryVat->Fetch())
        {
            if($Vat["NAME"] == "Без НДС")
                $res = "Без НДС";
            else
                $res = "VAT_".intval($Vat["RATE"]);
        }
        return $res;
    }

    //**********************************

}