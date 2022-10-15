<?php
CModule::IncludeModule("sale");
$arClasses = array(
  'Starrys\Cashbox\EventHandler'      => 'lib/eventhandlers.php',
  'Starrys\Cashbox\CashboxStarrys'    => 'lib/cashboxstarrys.php',
  'Starrys\Cashbox\PartPaymentCheck'  => 'lib/partpaymentcheck.php',
  'Starrys\Cashbox\Api\Client'        => 'lib/api/client.php',
  'Starrys\Cashbox\Api\Command'       => 'lib/api/command.php',
  'Starrys\Cashbox\Api\DeviceStatus'  => 'lib/api/devicestatus.php',
  'Starrys\Cashbox\Api\DocumentType'  => 'lib/api/documenttype.php',
  'Starrys\Cashbox\Api\Helper'        => 'lib/api/helper.php',
  'Starrys\Cashbox\Api\NonCashType'   => 'lib/api/noncashtype.php',
  'Starrys\Cashbox\Api\PayAttribute'  => 'lib/api/payattribute.php',
  'Starrys\Cashbox\Api\TaxId'         => 'lib/api/taxid.php',
  'Starrys\Cashbox\Api\ProductList'   => 'lib/api/productlist.php',
);

CModule::AddAutoloadClasses("starrys.cashbox", $arClasses);


?>