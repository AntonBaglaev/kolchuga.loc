<?
namespace PickPoint\DeliveryService;

use \Bitrix\Main\Localization\Loc;
//use \PickPoint\DeliveryService\Bitrix\Tools;

Loc::loadMessages(__FILE__);

/**
 * Class Option
 * @package PickPoint\DeliveryService
 */
class Option extends AbstractGeneral
{   
    /**
     * Option getter
     * 
     * @return mixed
     */	
	public static function get($option)
    {
        $self = \COption::GetOptionString(self::getMID(), $option, self::getDefault($option));
        		
		if (self::checkMultiple($option) && ($tmp = unserialize($self)))
            $self = $tmp;
		
        return $self;
    }

	/**
     * Return default option value
     * 
     * @return mixed|false
     */	
	public static function getDefault($option)
    {
        $opt = self::collection();
		
        if (array_key_exists($option, $opt))
            return $opt[$option]['default'];	
		
        return false;
    }
	
	/**
     * Return available variants of the option value (used for select input type)
     * 
     * @return array|false
     */	
	public static function getVariants($option)
    {
        $opt = self::collection();
		
        if (array_key_exists($option, $opt))
            return $opt[$option]['variants'];	
		
        return false;
    }
	
	/**
     * Option setter
     */	
    public static function set($option, $val, $doSerialise = false)
    {
        if ($doSerialise)
		   $val = serialize($val);
        		
        \COption::SetOptionString(self::getMID(), $option, $val);
    }

    /**
     * Check if option may have multiple values 
	 *
	 * @return bool
     */
    public static function checkMultiple($option)
    {
        $opt = self::collection();
		
        if (array_key_exists($option, $opt) && array_key_exists('multiple', $opt[$option]))
            return $opt[$option]['multiple'];
		
        return false;
    }
	
	/**
     * Validate option value by validator rule
	 *
	 * @return mixed
     */
    public static function validateOption($option, $value)
    {
        $opt = self::collection();
		
		// ! Validator must be called as a function
		if (array_key_exists($option, $opt) && is_callable($opt[$option]['validator']))
			return $opt[$option]['validator']($value);			
				
		// Something wrong with validator or option
		return NULL;
    }
	
	/**
     * Validate required options with validator rules
	 *
	 * @return mixed
     */
    public static function validateRequiredOptions($values)
    {		
		$errors = array();		
				
        $opt = self::collection();
		foreach ($opt as $name => $data)
		{
			if ($data['required'] == true)
			{				
				if (array_key_exists($name, $values))
				{					
					$check = self::validateOption($name, $values[$name]);				
										
					if (is_string($check))
					{
						$errors[] = $check;						
					}						
					elseif (is_null($check))
					{
						// Something wrong with validator or option
						$errors[] = Loc::getMessage('PP_REQUIRED_PARAM_VALIDATOR_FAIL', array('#OPTION#' => $name));						
					}					
				}
				else
				{
					if ($data['type'] == 'select')
					{
						// Damn selects
						$errors[] = Loc::getMessage('PP_WRONG_'.strtoupper(ltrim($name, 'pp_')));						
					}
					else					
						$errors[] = Loc::getMessage('PP_REQUIRED_PARAM_MISS', array('#OPTION#' => $name));
				}				
			}						
		}
		
		if (count($errors))
			return implode('<br />', $errors);
		
		return false;		
    }

	/**
     * Check if all required module options defined
	 *
	 * @return bool
     */
	public static function isRequiredOptionsSet()
	{
		$result = true;
		
		$opt = self::collection();
		foreach ($opt as $name => $data)
		{
			if ($data['required'] == true)
			{				
				$value = self::get($name);				
				$check = self::validateOption($name, $value);				
								
				if (!is_bool($check) || $check !== true)
				{
					// Some option not defined or something wrong with validator
					$result = false;
					break;					
				}					
			}						
		}		
		
		return $result;
	}
	
	/**
     * Return collection of module options 
	 *
	 * @return array
     */
    public static function collection()
    {
        return array(
			// Main Setup 
			'pp_ikn_number' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) { 				
												$res = (preg_match('#[0-9]{10}#', $val)) ? true : Loc::getMessage('PP_WRONG_IKN');
												return $res;
												},									
            ),
			'pp_api_login' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_API_LOGIN'));
												return $res;
												},
            ),
			'pp_api_password' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_API_PASSWORD'));
												return $res;
												},
            ),
			'pp_enclosure' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_ENCLOSURE'));
												return $res;
												},
            ),
			'pp_test_mode' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),
			
			'pp_service_types_all' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
				'variants'  => array(
									0 => 'STD',
									1 => 'STDCOD',
									2 => 'PRIO',
									3 => 'PRIOCOD',
								),
                'type'      => 'select',
				'required'  => false,
				'validator' => '',
				'multiple'  => true,
            ),
			'pp_service_types_selected' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
				'variants'  => array(
									0 => 'STD',
									1 => 'STDCOD',
									2 => 'PRIO',
									3 => 'PRIOCOD',
								),
                'type'      => 'select',				
				'required'  => true,
				'validator' => function ($val) {
												// variants keys to values
												$possible = array_flip(array_keys(Option::getVariants('pp_service_types_selected')));								
																								
												$res = (!empty($val) && count(array_intersect($possible, $val))) ? true : Loc::getMessage('PP_WRONG_SERVICE_TYPES_SELECTED');
												return $res;												
												},
				'multiple'  => true,
            ),
			
			'pp_enclosing_types_all' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
				'variants'  => array(
									0 => 'CUR',
									1 => 'WIN',
									2 => 'APTCON',
									3 => 'APT',
								),
                'type'      => 'select',
				'required'  => false,
				'validator' => '',
				'multiple'  => true,
            ),
			'pp_enclosing_types_selected' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
				'variants'  => array(
									0 => 'CUR',
									1 => 'WIN',
									2 => 'APTCON',
									3 => 'APT',
								),
                'type'      => 'select',				
				'required'  => true,
				'validator' => function ($val) {
												// variants keys to values
												$possible = array_flip(array_keys(Option::getVariants('pp_enclosing_types_selected')));								
																								
												$res = (!empty($val) && count(array_intersect($possible, $val))) ? true : Loc::getMessage('PP_WRONG_ENCLOSING_TYPES_SELECTED');
												return $res;												
												},
				'multiple'  => true,
            ),
			
			'pp_term_inc' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),			
			'pp_postamat_picker' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => 'ADDRESS',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			'pp_add_info' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '1',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),
			'pp_order_phone' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),
			'pp_city_location' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),
			'pp_order_city_status' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),
			// --
			
			// Sender
			'pp_from_city' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'select',				
				'required'  => true,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_FROM_CITY'));
												return $res;
												},				
            ),		
			// VAT
			// Actual VAT variants defined in ./constants.php , this for future using
			'pp_delivery_vat' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
				'variants'  => array(
									'VATNONE' => Loc::getMessage('PP_DELIVERY_VAT_NONE'),
									'VAT0'    => '0%',
									'VAT10'   => '10%',
									'VAT20'   => '20%',
								),
                'type'      => 'select',
				'required'  => false,
				'validator' => '',				
            ),
			
			// Revert
			'pp_store_region' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			'pp_store_city' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'select',				
				'required'  => true,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_STORE_CITY'));
												return $res;
												},					
            ),	
			'pp_store_address' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => function ($val) {
												$res = (strlen(trim($val)) ? true : Loc::getMessage('PP_WRONG_STORE_ADDRESS'));
												return $res;
												},
            ),
			'pp_store_phone' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => function ($val) {
												$res = (preg_match('#[0-9]{10}#', $val)) ? true : Loc::getMessage('PP_WRONG_STORE_PHONE');
												return $res;
												},
            ),
			'pp_store_fio' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			'pp_store_post' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			'pp_store_organisation' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			'pp_store_comment' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),
			// Dimensions
			'pp_dimension_width' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (intval(trim($val)) > 0) ? true : Loc::getMessage('PP_WRONG_DIMENSION_WIDTH');
												return $res;
												},
            ),
			'pp_dimension_height' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (intval(trim($val)) > 0) ? true : Loc::getMessage('PP_WRONG_DIMENSION_HEIGHT');
												return $res;
												},
            ),
			'pp_dimension_depth' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => true,
				'validator' => function ($val) {
												$res = (intval(trim($val)) > 0) ? true : Loc::getMessage('PP_WRONG_DIMENSION_DEPTH');
												return $res;
												},
            ),
			// Regional coefficient
			'pp_use_coeff' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '0',
                'type'      => 'checkbox',
				'required'  => false,
				'validator' => '',
            ),			
			'pp_custom_coeff' => array(
                'group'     => '',
                'hasHint'   => 'N',
                'default'   => '',
                'type'      => 'text',
				'required'  => false,
				'validator' => '',
            ),			
        );
    }	
}