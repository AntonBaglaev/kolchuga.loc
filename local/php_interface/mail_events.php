<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 28/06/16
 * Time: 15:07
 */

use Bitrix\Sale\Order as Order;
use \Bitrix\Main;

AddEventHandler("main", "OnBeforeEventAdd", "orderInfo");

function orderInfo($event, &$lid, &$arFields){

    if(!isset($arFields['ORDER_ID'])){
        return $arFields;
    }

    CModule::IncludeModule('sale');

    $order_id = $arFields['ORDER_ID'];

    $fields = array(
        'ORDER_ID' => $order_id,
        'ORDER_USER' => '',
        'ORDER_DATE' => '',
        'ORDER_STATUS' => '',
        'ORDER_CANCEL_URL' => '',
        'ORDER_PAY_URL' => '',
        'ORDER_USER_FIO' => '',
        'ORDER_USER_PHONE' => '',
        'ORDER_USER_EMAIL' => '',
        'ORDER_DELIVERY' => '',
        'ORDER_DELIVERY_LOCATION' => '',
        'ORDER_DELIVERY_ADDRESS' => '',
        'ORDER_PAYMENT' => '',
        'ORDER_PAYMENT_STATUS' => ''
    );

    /** @var Bitrix\Sale\Order $order */
    $order = Order::load($order_id);

    $fields['ORDER_DATE'] = $order->getDateInsert()->format('d.m.y h:i');

    $props = $order->getPropertyCollection();

    /** @var \Bitrix\Sale\PropertyValue $prop */
    foreach($props as $prop){

        $propParams = $prop->getProperty();
        $propValue = $prop->getValue();

        if($propParams['IS_PAYER'] == 'Y'){

            $fields['ORDER_USER'] = $propValue;
            $fields['ORDER_USER_FIO'] = $propValue;

        } elseif($propParams['IS_EMAIL'] == 'Y'){

            $fields['ORDER_USER_EMAIL'] = $propValue;

        } elseif($propParams['IS_PHONE'] == 'Y'){

            $fields['ORDER_USER_PHONE'] = $propValue;

        } elseif($propParams['IS_ADDRESS'] == 'Y'){

            $fields['ORDER_DELIVERY_ADDRESS'] = $propValue;

        } elseif($propParams['IS_LOCATION'] == 'Y'){

            if(intval($propValue) > 0){

                $arLocs = CSaleLocation::GetByID($propValue, LANGUAGE_ID);

                $propValue = $arLocs['CITY_NAME'];

                if($arLocs["REGION_NAME"]){
                    $propValue .= ", " . $arLocs["REGION_NAME"];
                }

                $fields['ORDER_DELIVERY_LOCATION'] = $propValue;
            }

        }

    }

    $arPayments = array();
$ule=[
		21=>'Cклад',
		18=>'Варварка',
		19=>'Ленинский проспект',
		20=>'Волоколамское шоссе',
	];

    /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
    $paymentCollection = $order->getPaymentCollection();
    /** @var \Bitrix\Sale\Payment $payment */
    foreach($paymentCollection as $payment){

        $result_str = '';
        $name = $payment->getField('PAY_SYSTEM_NAME');
        $paid = $payment->isPaid();

        /** @var \Bitrix\Sale\PaySystem\Service $paysystem */
        $paysystem = $payment->getPaySystem();
        $cash = $paysystem->isCash();
        $hasAction = false;
			$fields['SKLAD']=$ule[$paysystem->getField('PAY_SYSTEM_ID')];

        $pathToAction = Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

        $pathToAction = str_replace("\\", "/", $pathToAction);

        while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
            $pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


        if (file_exists($pathToAction))
        {
            if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
                $pathToAction .= "/payment.php";

            $hasAction = true;
        }
		
		if($paysystem->getField('ACTION_FILE') == 'assist' ){
			$hasAction = true;
		}

         $result_str .= $name;

        if($paid){
            $result_str .= ' [Оплачено]';
        }
        elseif(!$cash && ($hasAction || $paysystem->isAffordPdf())){
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/paysystem.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($order_id, true), FILE_APPEND | LOCK_EX);
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/paysystem.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($payment->getId(), true), FILE_APPEND | LOCK_EX);

            if($paysystem->isAffordPdf()){

                $link = 'http://'.$_SERVER['HTTP_HOST'].'/personal/order/payment/?ORDER_ID='. $order_id . '&PAYMENT_ID=' . $payment->getId() . '&pdf=1&DOWNLOAD=Y';
                $result_str .= '[' . '<a href="'.$link.'">Скачать счет</a>' . ']';

            } else {

                $link = 'http://'.$_SERVER['HTTP_HOST'].'/personal/order/payment/?ORDER_ID='. $order_id . '&PAYMENT_ID=' . $payment->getId();
                $result_str .= '[' . '<a href="'.$link.'">Оплатить</a>' . ']';
				$newlink='<table cellpadding="0" border="0" cellspacing="0" class="sp-button flat full-width" width="100%" style="border-collapse:collapse; font-size:14px; line-height:1.5; border:0; margin-left:auto; margin-right:auto; background:#ea5b35; border-radius:0; box-shadow:none">
                                                         <tbody>
                                                            <tr style="border-color:transparent">
                                                               <td class="sp-button-text" style="border-collapse:collapse; border-color:transparent; border-style:none; border-width:0; border:0; padding:0; align:center; border-radius:0; height:40px; text-align:center; vertical-align:middle; width:100%" height="40" align="center" valign="middle" width="100%">
                                                                  <table cellpadding="0" border="0" cellspacing="0" width="100%" style="border-collapse:collapse; font-size:14px; line-height:1.5; border:0">
                                                                     <tr style="border-color:transparent">
                                                                        <td align="center" style="border-collapse:collapse; border-color:transparent; border:0; padding:0; line-height:1"><a style="text-decoration:none; color:#fff; display:block; font-family:-apple-system, BlinkMacSystemFont, Roboto, Ubuntu, Helvetica, Arial, sans-serif; font-family-short:sans-serif; font-size:16px; font-weight:normal; padding:12px 0; width:100%" href="'.$link.'" width="100%">ОПЛАТИТЬ</a></td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>';

            }

            if(strlen($fields['ORDER_PAY_URL']) == 0){
                $fields['ORDER_PAY_URL'] = $link;
            }
			if(!empty($newlink)){
				$fields['ORDER_PAY_URL2'] = $newlink;
			}else{
				$fields['ORDER_PAY_URL2'] = '
				<table cellpadding="0" border="0" cellspacing="0" class="sp-button flat full-width" width="100%" style="border-collapse:collapse; font-size:14px; line-height:1.5; border:0; margin-left:auto; margin-right:auto; border-radius:0; box-shadow:none">
                                                         <tbody>
                                                            <tr style="border-color:transparent">
                                                               <td class="sp-button-text" style="border-collapse:collapse; border-color:transparent; border-style:none; border-width:0; border:0; padding:0; align:center; border-radius:0; height:40px; text-align:center; vertical-align:middle; width:100%" height="40" align="center" valign="middle" width="100%">
                                                                  <table cellpadding="0" border="0" cellspacing="0" width="100%" style="border-collapse:collapse; font-size:14px; line-height:1.5; border:0">
                                                                     <tr style="border-color:transparent">
                                                                        <td align="center" style="border-collapse:collapse; border-color:transparent; border:0; padding:0; line-height:1"></td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
				';
			}
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/paysystem.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($fields['ORDER_PAY_URL'], true), FILE_APPEND | LOCK_EX);
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/paysystem.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($fields, true), FILE_APPEND | LOCK_EX);

        } else{
            $result_str .= ' [Не оплачено]';
        }

        $arPayments[] = $result_str;

    }

    $fields['ORDER_PAYMENT'] = implode(',<br/>', $arPayments);

    /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
    $shipmentCollection = $order->getShipmentCollection();

    /** @var \Bitrix\Sale\Shipment $shipment */
    $arShipments = array();
    foreach($shipmentCollection as $shipment){

        if($shipment->isSystem())
            continue;

        $result_str = '';
        $name = $shipment->getField('DELIVERY_NAME');
        $status = \Bitrix\Sale\DeliveryStatus::getAllStatusesNames()[$shipment->getField('STATUS_ID')];

        $result_str .= $name . ' ['.$status.']';

       $arShipments[] = $result_str;
    }

    $fields['ORDER_DELIVERY'] = implode(',<br/>', $arShipments);

    $fields['ORDER_STATUS'] =
        \Bitrix\Sale\OrderStatus::getAllStatusesNames()[$order->getField('STATUS_ID')];


    $fields['ORDER_CANCEL_URL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/personal/order/detail/' . $fields['ORDER_ID'] . '/?CANCEL=Y';

    $fields['ORDER_URL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/personal/order/detail/' . $fields['ORDER_ID'] . '/';

	/** @var \Bitrix\Sale\Basket $dbRes */
	$dbRes = \Bitrix\Sale\Basket::getList([
		'select' => ['NAME', 'QUANTITY', 'PRICE', 'BASE_PRICE', 'DETAIL_PAGE_URL', 'PRODUCT_ID', 'DISCOUNT_PRICE', 'DISCOUNT_VALUE', 'MEASURE_NAME'],
		'filter' => ['ORDER_ID' => $order_id, '=LID' => \Bitrix\Main\Context::getCurrent()->getSite() ]
	]);
	$sostavAr=[];
	$sostavHtml='';
	$sostavHtml2='';
	while ($item = $dbRes->fetch())
	{
		$sostavAr[]=$item;
		$english_format_number = number_format($item['PRICE'], 2, '.', ' ');
		$sostavHtml.='<a href="http://'.$_SERVER['HTTP_HOST'].$item['DETAIL_PAGE_URL'].'">'.$item['NAME'].' ('.($item['QUANTITY']*1).' '.$item['MEASURE_NAME'].')</a> - '.($english_format_number).' руб.<br>'; 

		$dbItems = \Bitrix\Iblock\ElementTable::getList(array(
			'select' => array('ID', 'IBLOCK_ID', 'DETAIL_PICTURE'), 
			'filter' => array('ID' => $item['PRODUCT_ID']), 
			));
		$el=$dbItems->fetch();
		$img=\CFile::ResizeImageGet(
						$el['DETAIL_PICTURE'],
						array('width' => 250, 'height' => 187),
						BX_RESIZE_IMAGE_PROPORTIONAL
					)['src'];
		
		$sostavHtml2.='
		<table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:14px; line-height:1.5; background-color:#fff" bgcolor="#ffffff">
                                    <tr style="border-color:transparent">
                                       <td cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:transparent">
                                          <table width="100%" cellpadding="0" cellspacing="0" id="w" style="border-collapse:collapse; font-size:14px; line-height:1.5; background-color:#fff; font-weight:normal; margin:0; text-color:black" bgcolor="#ffffff">
                                             <tr class="content-row" style=\'border-color:transparent; color:#444; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif\'>
                                                <td class="content-cell padding-bottom-0" width="520" style="border-collapse:collapse; border-color:transparent; vertical-align:top; padding-bottom:0; padding-left:40px; padding-right:40px; padding-top:10px" valign="top">
                                                   <div style="font-size:1px; line-height:1.5">
                                                      
                                                      <table style="border-collapse:collapse; font-size:14px; line-height:1.5; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%" align="left" valign="top" width="100%">
                                                         <tbody>
                                                            <tr style="border-color:transparent">
                                                               <td style="border-collapse:collapse; border-color:transparent; padding:0 0 20px 0">
                                                                  <table style="border-collapse:collapse; font-size:14px; line-height:1.5; border-spacing:0; padding:0; text-align:left; width:100%" align="left" width="100%">
                                                                     <tbody>
                                                                        <tr style="border-color:transparent">
                                                                           <td style="border-collapse:collapse; border-color:transparent; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0; width:225px" align="left" valign="top" width="225">
                                                                              <table style="border-collapse:collapse; font-size:0; line-height:0; font-weight:lighter; margin:0; padding:0; text-align:left; width:225px" width="225" align="left">
                                                                                 <tbody>
                                                                                    <tr style="border-color:transparent">
                                                                                       <td style="border-collapse:collapse; border-color:transparent; background-image:url(https://'.$_SERVER['HTTP_HOST'].$img.'); background-position:left center; background-repeat:no-repeat; background-size:contain; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 25px 0 0; text-align:left; width:225px" valign="top" width="225" align="left"><a href="https://'.$_SERVER['HTTP_HOST'].$item['DETAIL_PAGE_URL'].'" style="text-decoration:none; color:#21385e"><img style="height:auto; line-height:100%; outline:0; text-decoration:none; border:0; display:block; margin:0; padding:0; width:200px" src="'.$img.'" alt="'.$item['NAME'].'" width="200" height="auto"> </a></td>
                                                                                    </tr>
                                                                                    <tr style="border-color:transparent">
                                                                                       <td style="border-collapse:collapse; border-color:transparent; font-family:Arial, sans-serif; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 0 20px 0" valign="bottom" width="200">&nbsp;</td>
                                                                                    </tr>
                                                                                 </tbody>
                                                                              </table>
                                                                           </td>
                                                                           <td style="border-collapse:collapse; border-color:transparent; color:#444; font-family:Arial, sans-serif; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 0 35px 0; text-align:left; width:295px" valign="top" width="295" align="left">
                                                                              <p style="line-height:1.5; margin:0 !important; font-size:14px; color:#444; font-family:Arial, sans-serif; font-weight:normal; padding:0"><span style="font-size: 14px; color: #444444; display: block; text-decoration: none;"><a style="text-decoration:none; color:#444; font-size:14px" href="https://'.$_SERVER['HTTP_HOST'].$item['DETAIL_PAGE_URL'].'"><strong>'.$item['NAME'].'</strong></a></span></p>
                                                                              <p style=\'line-height:1.5; margin:0 !important; font-size:15px; color:#444; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight:normal; padding:0\'>&nbsp;</p>
                                                                              <p style="line-height:1.5; margin:0 !important; font-size:20px; color:#424242; font-family:Arial, sans-serif; font-weight:normal; padding:0"><strong>'.$english_format_number.' ₽</strong></p>
                                                                              <p style=\'line-height:1.5; margin:0 !important; font-size:25px; color:#444; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight:normal; padding:0\'>&nbsp;</p>
                                                                              <p style="line-height:1.5; margin:0 !important; font-size:14px; color:#24c1ff; font-family:Arial, sans-serif; font-weight:normal; padding:0"><span style="font-size: 14px; color: #808080; display: block; margin-bottom: -5px; text-decoration: none;"><a style="  display: block;width: 200px;font-family: PT Sans;font-size: 14px;color: #21385E;border: 1px solid #21385E;text-align: center;padding: 7px 0;text-decoration: none;" href="https://'.$_SERVER['HTTP_HOST'].$item['DETAIL_PAGE_URL'].'">Перейти к товару</a></span></p>
                                                                           </td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                      
                                                   </div>
                                                   <div style="font-size:14px; line-height:1.5; clear:both"></div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
		';
	}
	
	$fields['SOSTAV_ARR']=$sostavAr;
	$fields['SOSTAV_HTML']=$sostavHtml;
	$fields['SOSTAV_HTML2']=$sostavHtml2;

    $arFields = array_merge($arFields, $fields);


    return $arFields;
}
