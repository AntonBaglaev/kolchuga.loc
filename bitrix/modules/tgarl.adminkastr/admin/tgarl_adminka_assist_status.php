<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

// подключим языковой файл
IncludeModuleLangFile(__FILE__);
// здесь будет вся серверная обработка и подготовка данных

$APPLICATION->SetTitle('Статус заказа в Assist');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог


?>


<div class="crm-admin-wrap">

<?if(!empty($_REQUEST['CODE'])){
	?><p style="font-size:1.2em;line-height:1.5em;"><?
	$order = \Bitrix\Sale\Order::load($_REQUEST['CODE']);
	$paymentCollection = $order->getPaymentCollection();

	$arPayments=[];
	foreach($paymentCollection as $payment){

		$paid = $payment->isPaid();

		$paysystem = $payment->getPaySystem();

		$cash = $paysystem->isCash();
		$hasAction = false;

		$pathToAction = \Bitrix\Main\Application::getDocumentRoot().$paysystem->getField('ACTION_FILE');

		$pathToAction = str_replace("\\", "/", $pathToAction);

		while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
			$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);


		if (file_exists($pathToAction))
		{
			if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
				$pathToAction .= "/payment.php";

			$hasAction = true;
		}

		if(!$paid && !$cash ){
			
				$link = '/personal/order/payment/' . '?ORDER_ID=' . $id . '&PAYMENT_ID=' . $payment->getId();
				$type = false;
			
		}
		else {
			$link = false;
		}

		$name = $payment->getField('PAY_SYSTEM_NAME');
		$arPayments = array(
			'PAY_SYSTEM_ID' => $payment->getField('PAY_SYSTEM_ID'),
			'NAME' => $name,
			'PAYMENT_ID' => $payment->getId(),
			'LINK' => $link,
			'PAID' => $paid,
			'TYPE' => $type,
			
		);
		$arPayments['PARAM_EXTRA'] = [
				'ASSIST_SHOP_IDP' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_IDP", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
				'ASSIST_SHOP_LOGIN' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_LOGIN", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
				'ASSIST_SHOP_PASSWORD' => \Bitrix\Sale\BusinessValue::get("ASSIST_SHOP_PASSWORD", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
				'ASSIST_SERVER_URL' => \Bitrix\Sale\BusinessValue::get("ASSIST_SERVER_URL", "PAYSYSTEM_".$arPayments['PAY_SYSTEM_ID'] ),
			];
	}
	if(!empty($arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'])){
		$massa=[
				"merchant"=>[
					"merchant_id"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_IDP'],
					"login"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_LOGIN'],
					"password"=>$arPayments['PARAM_EXTRA']['ASSIST_SHOP_PASSWORD']
				]
			];
			
			$url_status='https://'.$arPayments['PARAM_EXTRA']['ASSIST_SERVER_URL'].'/orderstate/orderstate.cfm';
			$massa_status=$massa;
			$massa_status["ordernumber"]=$arPayments['PAYMENT_ID'];
			
			$massa_status["startyear"]=date("Y", mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y')));
			$massa_status["startmonth"]=date("n", mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y')));
			$massa_status["startday"]=date("j", mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y')));
			$massa_status["starthour"]=date("H", mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y')));
			$massa_status["startmin"]=date("i", mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y')));
			
			$massa_status["format"]=3;
			
			function postRequest($url, $data) {
			$data_string = json_encode($data);
			$result = file_get_contents($url, null, stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => 'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data_string) . "\r\n",
					'content' => $data_string,
				],
			]));
			
			return $result;
			}
			
			function ardt($massiv){
				$result=[];
				foreach($massiv['#'] as $key=>$value){
					if(empty($value[1])){
						if(!is_array($value[0]['#'])){
							$result[$key]=$value[0]['#'];
						}else{
							$result[$key]=ardt($value[0]);
						}
					}else{
						//echo "<pre>";print_r($value);echo "</pre>";die;
						foreach($value as $key2=>$item){
							$result[$key][$key2]=ardt($item);
						}
					}
					
				}
				
				return $result;
			}
			//echo "<blockquote class='blockquote'><pre>";print_r($massa_status);echo "</pre></blockquote><br>";
			$result=postRequest($url_status, $massa_status);
			
			if($_REQUEST['DEBUG']=='Y'){
			echo "<blockquote class='blockquote'><pre>";print_r($result);echo "</pre></blockquote><br>";
			}
			require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
			$objXML = new CDataXML();
			$objXML->LoadString($result);
			$arData = $objXML->GetArray();			
			
			$arResult=ardt($arData['result']);
			
			if($_REQUEST['DEBUG']=='Y'){
			echo "<blockquote class='blockquote'><pre>";print_r($arResult);echo "</pre></blockquote><br>";
			}
			
			if(!empty($arResult['order'][0])){
				foreach($arResult['order'] as $kluch=>$value){
					if($value['orderstate']=='Delayed'){
						$arResult['order']=$value;
						break;
					}
				}
			}
			if($_REQUEST['DEBUG']=='Y'){
			echo "<blockquote class='blockquote'><pre>";print_r($arResult);echo "</pre></blockquote><br>";
			}
			$status=[
				'Approved'=>'Оплачен',
				'Delayed'=>'Ожидает подтверждения',
				'PartialDelayed '=>'Подтвержден частично',
				'Timeout '=>'Закрыт по истечении времени',
				'Declined '=>'Отклонен',
			];
			if($_REQUEST['DEBUG']!='Y'){
			echo '<blockquote class="blockquote">Текущий статус: '.(!empty($status[$arResult['order']['orderstate']]) ? $status[$arResult['order']['orderstate']]: $arResult['order']['orderstate'] ).'</blockquote><br>';
			}
	}
	?></p><?
}?>

<form action='' method='get'>
	<input type='hidden' name='lang' value='ru' >
	<input type='text' name='CODE' value='<?=$_REQUEST['CODE']?>' placeholder='Введите номер заказа'><br><br>
	<input type='checkbox' name='DEBUG' value='Y'> Выводить коды ответа (для разработчика)<br><br>
	
	<input type='submit' value='Узнать'>
</form>
<style>
blockquote {
padding: 10px 20px;
    margin: 0 0 20px;
    border-left: 5px solid #585F6B;
    background-color: #CCD7DB;
}
</style>
</div>


<?
echo BeginNote();
echo 'About...';
echo EndNote();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>