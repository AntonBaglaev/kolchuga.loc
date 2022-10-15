<?php

class Dellin {

	public static function SetKLADR($IdCity,$IdRegion){
	
	$IdCity = (int)$IdCity;
	$IdRegion = (int)$IdRegion;
	
	$result = $GLOBALS['DB']->Query('SELECT * FROM b_dellin_info WHERE bx_REGION_ID=' . $IdRegion . ' AND bx_CITY_ID='. $IdCity );
	return $result->Fetch();
	}

	public static function SetCity($IdRegion){
	$IdRegion = (int)$IdRegion;
	$result = $GLOBALS['DB']->Query('SELECT * FROM b_dellin_info WHERE bx_REGION_ID=' . $IdRegion);
	return $result;
	}

	//16-03-2015: изменен алгоритм получения $kladr
	// 18-12-2015: изменен алгоритм получения $kladr, зависит от версии Bitrix

	public static function GetZIPbyIDlocation($IdLocation,$IdCity,$IdRegion,$ccode){
		$locationAsCode = 0;

		if ((int)$ccode > 0) {
        	    $locationAsCode = 1;
		    $IdLocation = (int)$ccode;	    
		} else {
                    $IdLocation = (int)$IdLocation;
		}
/*		$IdLocation = (int)$IdLocation;

		$locationAsCode = 1;
		$firstVersion = explode(".", SM_VERSION);

		if ((int)$firstVersion[0] < 15) {
			if ((int)$firstVersion[1] < 5) {
				$locationAsCode = 0;
			}
		} */

		$GLOBALS['DB']->Query('CREATE TABLE IF NOT EXISTS `b_sale_loc_name` (id INT)');
		$result = $GLOBALS['DB']->Query('SELECT COUNT(*) as num_rows FROM `b_sale_loc_name`');
		$isExistTable = $result->Fetch();
		$numRows = $isExistTable['num_rows'];

		if($numRows == 0):

			$GLOBALS['DB']->Query('DROP TABLE IF EXISTS `b_sale_loc_name`');

			//$result = $GLOBALS['DB']->Query('SELECT * FROM b_dellin_info WHERE bx_REGION_ID=' . $IdRegion . ' AND bx_CITY_ID='. $IdCity );
			$result = $GLOBALS['DB']->Query('SELECT * FROM b_dellin_info WHERE b_dellin_info.bx_region=(SELECT NAME FROM b_sale_location_region_lang WHERE LID="ru" AND REGION_ID='.$IdRegion.') 
			AND b_dellin_info.bx_city=(SELECT NAME FROM b_sale_location_city_lang WHERE LID="ru" AND CITY_ID='.$IdCity.')');

		else:
		
			if ($locationAsCode == 0):
				$result = $GLOBALS['DB']->Query('SELECT `b_dellin_info`.`code` AS code , `b_dellin_info`.`bx_city` AS city FROM `b_dellin_info` , `b_sale_loc_name` 
				WHERE `b_sale_loc_name`.`LOCATION_ID` = '.$IdLocation.' AND `b_sale_loc_name`.`NAME` LIKE `b_dellin_info`.`bx_city` LIMIT 1');
			else:
				$result = $GLOBALS['DB']->Query('SELECT `b_dellin_info`.`code` AS code , `b_dellin_info`.`bx_city` AS city FROM `b_dellin_info`
				WHERE `b_dellin_info`.`bx_CODE` = '.$IdLocation.' LIMIT 1');
			endif;


		endif;	

		$info = $result->Fetch();
    	$zipCode = ( empty($info) ? false : $info['code']);

		return $zipCode;
	}	

}
