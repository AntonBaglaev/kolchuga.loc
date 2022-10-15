<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 04.04.2018
 * Time: 2:01
 */

namespace litebox\kassa\lib\Template\Orders;


class Order
{
    /** @var string $vendorOrderNumber Order number with prefix and suffix defined by admin, e.g. ABC34-q */
    public $vendorOrderNumber;
    /** @var int $orderNumber Unique order number without prefixes/suffixes, e.g. 34 */
    public $orderNumber;
    /** @var int $tax Tax total */
    public $tax;
    /** @var int $subtotal Order subtotal. Includes the sum of all products’ cost in the order */
    public $subtotal;
    /** @var int $total Order total cost. Includes shipping, taxes, discounts, etc. */
    public $total;
    /** @var int $usdTotal Order total in USD */
    public $usdTotal;
    /** @var string $paymentMethod Payment method name */
    public $paymentMethod;
    /** @var int $paymentMethodId Payment method id */
    public $paymentMethodId;
    /** @var string $paymentStatus Payment status */
    public $paymentStatus;
    /** @var int $paymentStatusId Payment status id */
    public $paymentStatusId;
    /** @var string $fulfillmentStatus Fulfilment status */
    public $fulfillmentStatus;
    /** @var string $refererUrl URL of the page when order was placed (without hash (#) part) */
    public $refererUrl = SITE_SERVER_NAME;
    /** @var string $globalReferer URL that the customer came to the store from */
    public $globalReferer = SITE_SERVER_NAME;
    /** @var string $createDate The date/time of order placement, e.g 2014-06-06 18:57:19 +0000 */
    public $createDate;
    /** @var string $updateDate The date/time of the last order change, e.g 2014-06-06 18:57:19 +0000 */
    public $updateDate;
    /** @var int $createTimestamp The date of order placement in UNIX Timestamp format, e.g 1427268654 */
    public $createTimestamp;
    /** @var int $updateTimestamp The date of the last order change in UNIX Timestamp format, e.g 1427268654 */
    public $updateTimestamp;
    /** @var bool $hidden Determines if the order is hidden (removed from the list). Applies to unsfinished orders only. */
    public $hidden = false;
    /** @var string $orderComments Order comments */
    public $orderComments;
    /** @var string $privateAdminNotes Private note about the order from store owner */
    public $privateAdminNotes;
    // Basic customer information
    /** @var string $email Customer email address */
    public $email;
    /** @var string $ipAddress Customer IP */
    public $ipAddress;
    /** @var int $customerId Unique customer internal ID (if the order is placed by a registered user) */
    public $customerId;
    /** @var int $customerGroupId Customer group ID */
    public $customerGroupId;
    /** @var int $customerGroup The name of group (membership) the customer belongs to */
    public $customerGroup;
    /** @var bool $customerTaxExempt true if customer is tax exempt, false otherwise */
    public $customerTaxExempt = false;
    /** @var string $customerTaxId Customer tax ID */
    public $customerTaxId = '';
    /** @var bool $customerTaxIdValid true if customer tax ID is valid, false otherwise */
    public $customerTaxIdValid = false;
    /** @var bool $reversedTaxApplied true if order tax was set to 0 because customer specified their valid tax ID in checkout process. false otherwise */
    public $reversedTaxApplied = false;
    // Discounts in order
    /** @var int $membershipBasedDiscount Sum of discounts based on customer group. Is included into the discount field */
    public $membershipBasedDiscount = 0;
    /** @var int $totalAndMembershipBasedDiscount The sum of discount based on subtotal AND customer group. Is included into the discount field */
    public $totalAndMembershipBasedDiscount;
    /** @var int $couponDiscount Discount applied to order using a coupon */
    public $couponDiscount;
    /** @var int $discount The sum of all applied discounts except for the coupon discount. To get the total order discount, take the sum of couponDiscount and discount field values */
    public $discount;
    /** @var int $volumeDiscount Sum of discounts based on subtotal. Is included into the discount field */
    public $volumeDiscount;
    /** @var object $discountCoupon Information about applied coupon */
    public $discountCoupon; //object
    /** @var array $discountInfo Information about applied discounts (coupons are not included) */
    public $discountInfo;
    /** @var array $items Order items */
    public $items;
    /** @var \litebox\kassa\lib\Template\Orders\PersonInfo $billingPerson Name and billing address of the customer. Can be omitted, if this form is disabled by merchant in Ecwid Control Panel > Settings > General > Cart > Ask for a billing address during checkout */
    public $billingPerson;
    /** @var \litebox\kassa\lib\Template\Orders\PersonInfo $shippingPerson Name and address of the person entered in shipping information */
    public $shippingPerson;
    /** @var \litebox\kassa\lib\Template\Orders\ShippingOptionInfo $shippingOption Information about selected shipping option */
    public $shippingOption;
    /** @var object $handlingFee Handling fee details */
    public $handlingFee;
    /** @var object $predictedPackages Predicted information about the package to ship items in to customer */
    public $predictedPackages;
    /** @var object $additionalInfo Additional order information if any (reserved for future use) */
    public $additionalInfo;
    /** @var object $paymentParams Additional payment parameters entered by customer on checkout, e.g. PO number in “Purchase order” payments */
    public $paymentParams;
    /** @var object $extraFields Additional optional information about order. Total storage of extra fields cannot exceed 8Kb */
    public $extraFields;
    /** @var array $taxesOnShipping Taxes applied to shipping. null for old orders, [] for orders with taxes applied to subtotal only. Are not recalculated if order is updated later manually */
    public $taxesOnShipping = [];

    /** @var string $pickupTime Order pickup time in the store date format, e.g.: "2017-10-17 05:00:00 +0000" */
    public $pickupTime;
    /** @var string $trackingNumber Shipping tracking code */
    public $trackingNumber;
    /** @var string $affiliateId Affiliate ID */
    public $affiliateId;

    private $rules = [
        'orderNumber' => 'ID',
        'vendorOrderNumber' => 'ID',
        'tax' => 'TAX_VALUE',
        'subtotal' => 'SUM_PAID',
        'total' => 'PRICE',
        'usdTotal' => 'PRICE',
        'paymentMethod' => 'PAY_SYSTEM_NAME',
        'paymentMethodId' => 'PAY_SYSTEM_ID',
        'paymentStatus' => 'STATUS_NAME',
        'paymentStatusId' => 'STATUS_ID',
        'fulfillmentStatus' => 'DELIVERY_NAME',

        'createDate' => 'DATE_INSERT',
        'updateDate' => 'DATE_UPDATE',
        'orderComments' => 'USER_DESCRIPTION',
        'privateAdminNotes' => 'COMMENTS',

        'email' => 'USER_EMAIL',
        'customerId' => 'USER_ID',
        'customerGroupId' => 'PERSON_TYPE_ID',

        'totalAndMembershipBasedDiscount' => 'DISCOUNT_VALUE',
        'couponDiscount' => 'DISCOUNT_VALUE',
        'discount' => 'DISCOUNT_VALUE',

        'pickupTime' => 'DATE_DEDUCTED',
        'trackingNumber' => 'TRACKING_NUMBER',
        'affiliateId' => 'AFFILIATE_ID',
    ];

    public $rulesItem = [];

    public function __construct($dataItemOrder, $reverse = false)
    {
        foreach ($this as $key => &$value) {
            $realKey = $this->rules[$key];

            if ($reverse) {
                $realKey = $key;
            }

            $value = $dataItemOrder[$realKey];
        }

        $createDate = new \DateTime($this->createDate);
        $updateDate = new \DateTime($this->updateDate);

        $this->createTimestamp = $createDate->getTimestamp();
        $this->updateTimestamp = $updateDate->getTimestamp();

        $this->additionalInfo = (object)[];
    }
}