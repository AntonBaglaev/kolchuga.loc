<?php
/**
 * Created by PhpStorm.
 * User: Corndev
 * Date: 14/09/15
 * Time: 12:01
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
header('Content-Type: application/json');

if(CModule::IncludeModule('sale') && strlen($_REQUEST['query']) > 2) {

    /* Locations */
    if(strlen($_REQUEST['query']) > 2) {
        $q = $_REQUEST['query'];
        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
            'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, '%NAME.NAME' => $q),
            'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
        ));

        $locations = array();

        while ($vars = $res->Fetch()) {


//            if($vars['REGION_NAME'])
//                $vars['CITY_NAME'] = $vars['CITY_NAME'] . ', ' . $vars['REGION_NAME'];

            $locations[] = array(
                'NAME' => $vars['NAME_RU'],
                'ID' => $vars['ID'],
            );

        }

        echo json_encode($locations);
        die();
    }

}