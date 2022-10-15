<?
use \Bitrix\Main\Localization\Loc;
use \PickPoint\DeliveryService\Bitrix\Tools;
use \PickPoint\DeliveryService\Option;

Loc::loadMessages(__FILE__);

CJSCore::Init(array("jquery"));

$module_id = 'pickpoint.deliveryservice';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/constants.php';

$CAT_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ($CAT_RIGHT >= 'R'):
    include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/fields.php';
    global $MESS;
    global $arOptions;    
    include_once $GLOBALS['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/include.php';

	//echo '<pre>'.print_r($arOptions, true).'</pre>';
	//echo '<pre>'.print_r($_REQUEST, true).'</pre>';	
	
	/*$ar = [];
	$oc = Option::collection();
	foreach ($oc as $name => $data)
	{
		$ar['OPTIONS'][$name] = Option::get($name);
	}
	echo '<pre>'.print_r($ar, true).'</pre>';
	*/
	
	// Check required options
	if (!Option::isRequiredOptionsSet())
	{
		$optionsNotSetMessage = new CAdminMessage([
			'MESSAGE' => GetMessage("PP_MODULE_OPTIONS_NOT_SET"), 
			'TYPE' => 'ERROR', 
			'DETAILS' => GetMessage("PP_MODULE_OPTIONS_NOT_SET_TEXT"), 
			'HTML' => true
			]);
		echo $optionsNotSetMessage->Show();
	}	
	
    $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
    $Update = $_REQUEST['Update'];
    $RestoreDefaults = $_REQUEST['RestoreDefaults'];
	
    if ($CAT_RIGHT >= 'W' && check_bitrix_sessid()) 
	{
        if ($REQUEST_METHOD == 'GET' && strlen($RestoreDefaults) > 0) 
		{
            COption::RemoveOption($module_id);
            $z = CGroup::GetList($v1 = 'id', $v2 = 'asc', array('ACTIVE' => 'Y', 'ADMIN' => 'N'));
            while ($zr = $z->Fetch()) {
                $APPLICATION->DelGroupRight($module_id, array($zr['ID']));
            }
        }
        if ($REQUEST_METHOD == 'POST' && strlen($Update) > 0) 
		{
            ob_start();
            require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');
            ob_end_clean();
			
			if (($errorsDetected = Option::validateRequiredOptions($_REQUEST)) !== false)
			{
				$APPLICATION->ThrowException(Loc::getMessage('PP_ERROR_OPTONS_DONT_SAVED').'<br><br>'.$errorsDetected);
					
            //if (!CheckPickpointLicense($_REQUEST['pp_ikn_number'])) {
            //   $APPLICATION->ThrowException(Loc::getMessage('PP_WRONG_KEY'));
            } else {
                foreach ($_REQUEST as $sCode => $Value) {
                    if (in_array($sCode, array_keys($arOptions['OPTIONS']))) {
                        if ($Value) {
                            if (is_array($Value)) {
                                $Value = serialize($Value);
                            }

                            if (!COption::SetOptionString($module_id, $sCode, $Value)) {
                                $arOptions['OPTIONS'][$sCode] = $Value;
                            }
                        } else {
                            COption::SetOptionString($module_id, $sCode, '');
                        }
                    }
                }
                if ($_REQUEST['pp_add_info']) {
                    COption::SetOptionString($module_id, 'pp_add_info', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_add_info', 0);
                }

                if ($_REQUEST['pp_order_phone']) {
                    COption::SetOptionString($module_id, 'pp_order_phone', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_order_phone', 0);
                }

                if ($_REQUEST['pp_order_city_status']) {
                    COption::SetOptionString($module_id, 'pp_order_city_status', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_order_city_status', 0);
                }

                if ($_REQUEST['pp_city_location']) {
                    COption::SetOptionString($module_id, 'pp_city_location', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_city_location', 0);
                }

                if ($_REQUEST['pp_use_coeff']) {
                    COption::SetOptionString($module_id, 'pp_use_coeff', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_use_coeff', 0);
                }

                if ($_REQUEST['pp_test_mode']) {
                    COption::SetOptionString($module_id, 'pp_test_mode', 1);
                } else {
                    COption::SetOptionString($module_id, 'pp_test_mode', 0);
                }

                $arTableOptions = $_REQUEST['OPTIONS'];

                foreach ($arTableOptions as $iPT => $arPersonTypeValues) {
                    foreach ($arPersonTypeValues as $sValueCode => $arValues) {
                        foreach ($arValues as $iKey => $arValueList) {
                            if ($arValueList['TYPE'] == 'ANOTHER') {
                                $arTableOptions[$iPT][$sValueCode][$iKey]['VALUE'] = $arValueList['VALUE_ANOTHER'];
                            }
                            unset($arTableOptions[$iPT][$sValueCode][$iKey]['VALUE_ANOTHER']);
                        }
                    }
                }
                COption::SetOptionString($module_id, 'OPTIONS', serialize($arTableOptions));

                // looks useless
				if (!empty($_REQUEST['CITIES'])) {
                    foreach ($_REQUEST['CITIES'] as $arCityFields) {
                        if (intval($arCityFields['BX_ID'])) {
                            $arCityFields['PRICE'] = floatval($arCityFields['PRICE']);
                            if (!isset($arCityFields['ACTIVE'])) {
                                $arCityFields['ACTIVE'] = 'N';
                            }
                            CPickpoint::SetPPCity($arCityFields['PP_ID'], $arCityFields);
                        }
                    }
                }
				// --

                if (!empty($_REQUEST['ZONES'])) {
                    foreach ($_REQUEST['ZONES'] as $zoneId => $arZoneFields) {
                        $arZoneFields['PRICE'] = floatval($arZoneFields['PRICE']);
                        CPickpoint::SetPPZone($zoneId, $arZoneFields);
                    }
                }
                $arOptions = array();
                if (!(COption::GetOptionString($module_id, 'pp_service_types_all', ''))) {
                    COption::SetOptionString($module_id, 'pp_service_types_all', serialize($arServiceTypes));
                }
                if (!(COption::GetOptionString($module_id, 'pp_enclosing_types_all', ''))) {
                    COption::SetOptionString($module_id, 'pp_enclosing_types_all', serialize($arEnclosingTypes));
                }

                $iTimestamp = COption::GetOptionInt($module_id, 'pp_city_download_timestamp', 0);

                if (time() > $iTimestamp
                    || !file_exists(
                        $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/cities.csv'
                    )
                ) {
                    CPickpoint::GetCitiesCSV();
                }

                $arOptions = array();
                $arOptions['OPTIONS']['pp_add_info'] = COption::GetOptionString($module_id, 'pp_add_info', '1');
                $arOptions['OPTIONS']['pp_order_phone'] = COption::GetOptionString($module_id, 'pp_order_phone', '1');
                $arOptions['OPTIONS']['pp_order_city_status'] = COption::GetOptionString($module_id, 'pp_order_city_status', '1');
                $arOptions['OPTIONS']['pp_city_location'] = COption::GetOptionString($module_id, 'pp_city_location', '1');
                $arOptions['OPTIONS']['pp_ikn_number'] = COption::GetOptionString($module_id, 'pp_ikn_number', '');
                $arOptions['OPTIONS']['pp_enclosure'] = COption::GetOptionString($module_id, 'pp_enclosure', '');
                $arOptions['OPTIONS']['pp_service_types_selected'] = COption::GetOptionString(
                    $module_id,
                    'pp_service_types_selected'
                );
                $arOptions['OPTIONS']['pp_service_types_all'] = COption::GetOptionString(
                    $module_id,
                    'pp_service_types_all'
                );
                $arOptions['OPTIONS']['pp_enclosing_types_selected'] = COption::GetOptionString(
                    $module_id,
                    'pp_enclosing_types_selected'
                );
                $arOptions['OPTIONS']['pp_enclosing_types_all'] = COption::GetOptionString(
                    $module_id,
                    'pp_enclosing_types_all'
                );				
				
				$arOptions['OPTIONS']['pp_term_inc'] = Option::get('pp_term_inc');
				$arOptions['OPTIONS']['pp_postamat_picker'] = Option::get('pp_postamat_picker');
				
                $arOptions['OPTIONS']['pp_zone_count'] = COption::GetOptionString($module_id, 'pp_zone_count', 10);
                $arOptions['OPTIONS']['pp_from_city'] = COption::GetOptionString($module_id, 'pp_from_city', '');
                $arOptions['OPTIONS']['pp_delivery_vat'] = COption::GetOptionString($module_id, 'pp_delivery_vat', '');
                $arOptions['OPTIONS']['pp_use_coeff'] = COption::GetOptionString($module_id, 'pp_use_coeff', '');
                $arOptions['OPTIONS']['pp_custom_coeff'] = COption::GetOptionString($module_id, 'pp_custom_coeff', '');
                $arOptions['OPTIONS']['pp_api_login'] = COption::GetOptionString($module_id, 'pp_api_login', '');
                $arOptions['OPTIONS']['pp_api_password'] = COption::GetOptionString($module_id, 'pp_api_password', '');
                $arOptions['OPTIONS']['pp_test_mode'] = COption::GetOptionString($module_id, 'pp_test_mode', '');
                $arOptions['OPTIONS']['pp_free_delivery_price'] = COption::GetOptionString(
                    $module_id,
                    'pp_free_delivery_price',
                    ''
                );
                LocalRedirect($APPLICATION->GetCurPageParam());
            }
        }
    }
	
	$arServiceTypes = strlen($arOptions['OPTIONS']['pp_service_types_all']) ? unserialize(
        $arOptions['OPTIONS']['pp_service_types_all']
    ) : $arServiceTypes;	
    $arSelectedST = strlen($arOptions['OPTIONS']['pp_service_types_selected']) ? unserialize(
        $arOptions['OPTIONS']['pp_service_types_selected']
    ) : array();	
    $arEnclosingTypes = strlen($arOptions['OPTIONS']['pp_enclosing_types_all']) ? unserialize(
        $arOptions['OPTIONS']['pp_enclosing_types_all']
    ) : $arEnclosingTypes;
    $arSelectedET = strlen($arOptions['OPTIONS']['pp_enclosing_types_selected']) ? unserialize(
        $arOptions['OPTIONS']['pp_enclosing_types_selected']
    ) : array();
			
    $arTableOptions = (unserialize(COption::GetOptionString($module_id, 'OPTIONS')));
	if (!$arTableOptions)
		$arTableOptions = array();
	
    if (isset($_REQUEST['OPTIONS'])) {
        $arTableOptions = $_REQUEST['OPTIONS'];
    }
    foreach ($arOptions['OPTIONS'] as $sKey => $sValue) {
        if (isset($_REQUEST[$sKey])) {
            $arOptions['OPTIONS'][$sKey] = (is_array($_REQUEST[$sKey])) ? serialize($_REQUEST[$sKey])
                : $_REQUEST[$sKey];
        }
    }		
	
	// Tabs in module options
    $arTabs = array(
		array(
            'DIV'   => 'edit1',
            'TAB'   => Loc::getMessage('PPOINT_FAQ_TAB'),            
			'ICON'  => 'support_settings',
            'TITLE' => Loc::getMessage('PPOINT_FAQ_TAB_TITLE'),
			'PATH'  => Tools::defaultOptionPath()."FAQ.php",
        ),
        array(
            'DIV'   => 'edit2',
            'TAB'   => Loc::getMessage('MAIN_TAB_SET'),
            'ICON'  => 'support_settings',
            'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_SET'),
			'PATH'  => Tools::defaultOptionPath()."setup.php",
        ),
        array(
            'DIV'   => 'edit3',
            'TAB'   => Loc::getMessage('PPOINT_ZONES_TAB'),
            'ICON'  => 'support_settings',
            'TITLE' => Loc::getMessage('PPOINT_ZONES_TAB_TITLE'),
			'PATH'  => Tools::defaultOptionPath()."zones.php",
        ),
        array(
            'DIV'   => 'edit4',
            'TAB'   => Loc::getMessage('MAIN_TAB_RIGHTS'),
            'ICON'  => 'pickpoint_settings',
            'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_RIGHTS'),
			'PATH'  => Tools::defaultOptionPath()."rights.php",
        ),
    );
	
	// Allows creating custom tabs using the onTabsBuild module event
	$_arTabs = array();
    foreach (GetModuleEvents($module_id, "onTabsBuild", true) as $arEvent)	
        ExecuteModuleEventEx($arEvent, Array(&$_arTabs));

    $divId = count($arTabs);
    if (!empty($_arTabs))
	{
        foreach ($_arTabs as $tabName => $path)
            $arTabs[] = array("DIV" => "edit".(++$divId), "TAB" => $tabName, "ICON" => "support_settings", "TITLE" => $tabName, "PATH" => $path);
	}
	// --

	// this looks useless
    ShowNote(COption::GetOptionString('pickpoint', 'comment'), COption::GetOptionString('pickpoint', 'comment_type'));
		
    $tabControl = new CAdminTabControl('tabControl', $arTabs);
    Tools::getOptionsCss();
	
    if ($ex = $APPLICATION->GetException()) 
	{
		CAdminMessage::ShowOldStyleError($ex->GetString());    
	}	
	?>		
    <form method="POST" action="<?=$APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANG?>" name="ara">
        <?=bitrix_sessid_post();?>
		<?		
		$tabControl->Begin();
		
		foreach ($arTabs as $arTab)
		{
			$tabControl->BeginNextTab();
			include_once($_SERVER['DOCUMENT_ROOT'].$arTab["PATH"]);
		}        
        $tabControl->Buttons();
		?>
		
        <script language="JavaScript">
            function RestoreDefaults() {
                if (confirm('<?=addslashes(Loc::getMessage('MAIN_HINT_RESTORE_DEFAULTS_WARNING'))?>'))
                    window.location = "<?=$APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?=LANG?>&mid=<?=urlencode($mid)?>&<?=bitrix_sessid_get()?>";
            }
        </script>
        <input type="submit" <?if ($CAT_RIGHT < 'W') { echo 'disabled'; }?> name="Update" value="<?=Loc::getMessage('MAIN_SAVE');?>" />
        <input type="hidden" name="Update" value="Y" />
        <input type="reset" name="reset" value="<?=Loc::getMessage('MAIN_RESET');?>" />
        <?$tabControl->End();?>
    </form>
<?endif;