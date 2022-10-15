<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 07.04.2018
 * Time: 3:13
 */

namespace litebox\kassa\lib\Template\Orders;


use litebox\kassa\lib\Template\GenerateData;

class ShippingOptionInfo extends GenerateData
{
    /** @var string $shippingCarrierName Optional. Is present for orders made with carriers, e.g. USPS or shipping applications. */
    public $shippingCarrierName;
    /** @var string $shippingMethodName Shipping option name */
    public $shippingMethodName;
    /** @var int $shippingRate Rate */
    public $shippingRate;
    /** @var string $estimatedTransitTime Delivery time estimation. Formats accepted: number “5”, several days estimate “4-9” */
    public $estimatedTransitTime;
    /** @var bool $isPickup true if selected shipping option is local pickup. false otherwise */
    public $isPickup = true;
    /** @var string $pickupInstruction Instruction for customer on how to receive their products */
    public $pickupInstruction;
    /** @var int $id id */
    public $id;
    /** @var string $vat_code null*/
    public $vat_code;

    public $rules = [
        'shippingCarrierName' => '',
        'shippingMethodName' => 'NAME',
        'shippingRate' => 'PRICE',
        'estimatedTransitTime' => 'period',
        'pickupInstruction' => 'DESCRIPTION',
        'id' => 'ID',
        'vat_code' => 'VAT_CODE',
    ];
}