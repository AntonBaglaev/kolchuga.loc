<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class CouponRegisterComponent extends CBitrixComponent
{
	const status_init = 0;
	const status_cancel = 1;
	const status_3 = 3;
	const status_5 = 5;
	const status_10 = 10;

	/**
	 */
	public function onIncludeComponentLang()
	{
		$this->includeComponentLang(basename(__FILE__));
		Loc::loadMessages(__FILE__);
	}

	/**
	 * @throws LoaderException
	 */
	protected function checkModules()
	{
		if (!Main\Loader::includeModule('iblock'))
			throw new Main\LoaderException(Loc::getMessage('DI_IBLOCK_MODULE_NOT_INSTALLED'));
	}

	/**
	 * @throws SystemException
	 */
	protected function checkParams()
	{

		if ((int)$this->arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');
		if (strlen($this->arParams['EVENT']) < 1){
			throw new Main\ArgumentNullException('EVENT');
		}
	}


	/**
	 */

	protected function getResult()
	{

		global $USER;
		global $APPLICATION;

			
		$this->arResult['STATUS'] = $this->getStatusList();

		if(isset($_REQUEST['check']) && strlen($_REQUEST['check']) > 0){
			$APPLICATION->RestartBuffer();
			
			$hash = $_REQUEST['check'];
			$this->arResult['COUPON'] = $this->getCoupon(false, array('=PROPERTY_HASH' => $hash));
			if(!$this->arResult['COUPON']['ID']){
				throw new \Exception('Coupon for user not found');
			}

			$status = $_REQUEST['set'];

			if(array_key_exists($status, $this->arResult['STATUS'])){
				$this->setCouponStatus($this->arResult['COUPON']['ID'], $this->arResult['STATUS'][$status]['ID']);
				$this->setUserGroup($status);
				$this->deActiveCart($this->arResult['COUPON']['ID'], $status);
				$this->arResult['COUPON'] = $this->getCoupon(false, array('=PROPERTY_HASH' => $hash));

				echo '<p style="color: red">Статус карты успешно обновлен</p>';

			} else {
				throw new \Exception('Invalid status value');
			}

			
			die();
		}

		$user_id = $USER->GetID();

		$this->arResult['TEMPLATE_PART'] = 'CREATE';
		$this->arResult['COUPON'] = $this->getCoupon($user_id);

		if($this->arResult['COUPON']){

			$status_id = $this->arResult['COUPON']['STATUS'];
			$status_code = false;

			if(!$status_id){
				$this->arResult['TEMPLATE_PART'] = 'MODERATION';
			} else {

				foreach($this->arResult['STATUS'] as $code => $status){
					if($status['ID'] == $status_id){
						$status_code = $code;
						break;
					}
				}

				$this->arResult['COUPON']['STATUS_CODE'] = $status_code;

				if($status_code == 'STATUS_DEFAULT' || !$status_code){
					$this->arResult['TEMPLATE_PART'] = 'MODERATION';
				} elseif($status_code == 'STATUS_CANCEL'){
					$this->arResult['TEMPLATE_PART'] = 'CANCEL';
				} else{
					$this->arResult['TEMPLATE_PART'] = 'SUCCESS';
				}
			}

		}
		elseif(isset($_REQUEST['SET_COUPON'])){

			$data = $_POST['COUPON'];

			$errors = $this->validateData($data);
			if(count($errors) < 1){
				$data['HASH'] = $this->hash();
				$data['USER'] = $USER->GetID();
				$result = $this->setCoupon($data);

				if($result['error']){
					$this->arResult['SYSTEM_ERROR'] = $result['massage'];
				} else {
					$this->arResult['COUPON'] = $this->getCoupon($user_id);
					$this->arResult['TEMPLATE_PART'] = 'MODERATION';
				}


			} else {
				$this->arResult['VALUES'] = $data;
				$this->arResult['ERRORS'] = $errors;
			}

		}
	}

	public function getCoupon($user_id, $ext_filter = array()){

		$coupon = array();
		
		if($user_id > 0){
			$filter = array('IBLOCK_ID' => $this->arParams['IBLOCK_ID'], '=PROPERTY_USER' => $user_id);
		} else {
			$filter = array_merge(array('IBLOCK_ID' => $this->arParams['IBLOCK_ID']), $ext_filter);
		}
		$filter['ACTIVE']='Y';	
		$res = \CIBlockElement::GetList(
			array(),
			$filter,
			false,
			false,
			array(
				'ID',
				'TIMESTAMP_X',
				'IBLOCK_ID', 
				'NAME', 
				'PROPERTY_FIO', 
				'PROPERTY_EMAIL', 
				'PROPERTY_PHONE', 
				'PROPERTY_HASH', 
				'PROPERTY_STATUS',
				'PROPERTY_USER'
			)
		);
		
		if($item = $res->GetNext()){
			$coupon = array(
				'ID' => $item['ID'],
				'DATE' => $item['TIMESTAMP_X'],
				'CODE' => $item['NAME'],
				'FIO' => $item['PROPERTY_FIO_VALUE'],
				'EMAIL' => $item['PROPERTY_EMAIL_VALUE'],
				'PHONE' => $item['PROPERTY_PHONE_VALUE'],
				'HASH' => $item['PROPERTY_HASH_VALUE'],
				'STATUS' => $item['PROPERTY_STATUS_ENUM_ID'],
				'STATUS_TEXT' => $item['PROPERTY_STATUS_VALUE'],
				'USER' => $item['PROPERTY_USER_VALUE']
			);
			
		}
	
		return $coupon;

	}

	public function setCoupon($fields){

		$result_fields = array(
			'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
			'ACTIVE' => 'Y',
			'NAME' => $fields['CODE'],
			'PROPERTY_VALUES' => array(
				'FIO' => $fields['FIO'],
				'EMAIL' => $fields['EMAIL'],
				'PHONE' => $fields['PHONE'],
				'STATUS' => $this->arResult['COUPON']['STATUS'] ?
					$this->arResult['COUPON']['STATUS'] : $this->arResult['STATUS']['STATUS_DEFAULT']['ID'],
				'USER' => $fields['USER'],
				'HASH' => $fields['HASH']
			)
		);
		
		$el = new \CIBlockElement();

		if($this->arResult['COUPON']['ID']){
			$result = $el->Update($this->arResult['COUPON']['ID'], $result_fields);
			if($result){
				$this->sendManager($fields);		
				return array('success' => true, 'id' => $this->arResult['COUPON']['ID']);
			}
			else
				return array('error' => true, 'message' => $el->LAST_ERROR);
		}
		else{
			$result = $el->Add($result_fields);
			if($result > 0){
				$this->sendManager($fields);
				return array('success' => true, 'id' => $result);
			}
			else
				return array('error' => true, 'message' => $el->LAST_ERROR);
		}
			
			
			
	}

	public function setCouponStatus($id, $status){
		\CIBlockElement::SetPropertyValuesEx(
			$id,
			$this->arParams['IBLOCK_ID'],
			array(
				'STATUS' => $status
			)
		);
	}

	public function validateData($fields){
		$errors = array();
		$req = array('CODE', 'FIO', 'PHONE', 'EMAIL');

		foreach($req as $code){
			if(strlen($fields[$code]) < 3)
				$errors[] = $code;
		}

		return $errors;
	}

	public function hash(){
		return md5(time());
	}

	public function sendManager($fields){

		$arEventFields = array(
			"CODE" => $fields['CODE'],
			"FIO" => $fields['FIO'],
			"EMAIL" => $fields['EMAIL'],
			"PHONE" => $fields['PHONE'],
			"SET_STATUS_3" => $this->makeLink('STATUS_3', $fields['HASH']),
			"SET_STATUS_5" => $this->makeLink('STATUS_5', $fields['HASH']),
			"SET_STATUS_10" => $this->makeLink('STATUS_10', $fields['HASH']),
			"SET_STATUS_CANCEL" => $this->makeLink('STATUS_CANCEL', $fields['HASH'])
		);

		$res = \CEvent::Send($this->arParams['EVENT'], SITE_ID, $arEventFields);
		
	}

	public function sendClient(){

	}

	public function setUserGroup($status){
		
		$user_id = $this->arResult['COUPON']['USER'];
		
		$currGroups = \CUser::GetUserGroup($user_id);
		
		$group_status = array(
			'STATUS_3' => 8,
			'STATUS_5' => 9,
			'STATUS_10' => 10,
			'STATUS_CANCEL' => ''
		);

		/* clean old disount user groups */
		foreach($currGroups as $k => $g_id){
			if(in_array($g_id, array(8,9,10))){
				unset($currGroups[$k]);
			}
		}

		if($status == 'STATUS_CANCEL'){
			$user = new \CUser;
			$res = $user->Update($user_id, array(
					'GROUP_ID' => $currGroups
				)
			);
			$fields= $this->getCoupon($user_id);
			$arEventFields = array(
				"CODE" => $fields['CODE'],
				"FIO" => $fields['FIO'],
				"EMAIL" => $fields['EMAIL'],
				"PHONE" => $fields['PHONE'],				
				"SET_STATUS_CANCEL" => 'THE USER CANCELED THEIR CARD'
			);
			$res = \CEvent::Send($this->arParams['EVENT'], SITE_ID, $arEventFields);
		} else{
			$currGroups[] = $group_status[$status];

			$user = new \CUser;
			$res = $user->Update($user_id, array(
					'GROUP_ID' => $currGroups
				)
			);
		}
	}
	protected function deActiveCart($cuponId,$status)
	{
		if($status=='STATUS_CANCEL' && intval($cuponId)>0){
			$el = new \CIBlockElement();
			$result = $el->Update($cuponId, array('ACTIVE'=>'N'));
		}
	}
	public function makeLink($status, $hash){
		return 'http://' .  
				$_SERVER['HTTP_HOST'] . 
				'/personal/discount/' .
				'?check=' . $hash .
				'&set=' . $status;
	}

	public function getStatusList(){
		$result = array();
		
		$res = \CIBlockPropertyEnum::GetList(array('SORT' => 'ASC'), array('CODE' => 'STATUS'));
		while($enum = $res->GetNext()){
            $result[$enum['XML_ID']] = array('ID' => $enum['ID'], 'VALUE' => $enum['VALUE']);
        }
       
        return $result;
	}	

	/**
	 */
	public function executeComponent()
	{
		try {
			$this->checkModules();
			$this->checkParams();
			$this->getResult();
			$this->includeComponentTemplate();
		} catch (Exception $e) {
			echo $e->getMessage();

		}
	}
}