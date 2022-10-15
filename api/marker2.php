<?

set_time_limit(800);
ini_set('memory_limit', '12192M');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

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
						foreach($value as $key2=>$item){
							if(is_array($item['#'])){
								$result[$key][$key2]=ardt($item);
							}else{
								$result[$key][$key2]=$item['#'];
							}
						}
					}
					
				}
				
				return $result;
			}
$xml = file_get_contents("php://input");
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($xml, true), FILE_APPEND | LOCK_EX);


require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
			$objXML = new CDataXML();
			$objXML->LoadString($xml);
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($objXML, true), FILE_APPEND | LOCK_EX);
			$arData = $objXML->GetArray();
			//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arData, true), FILE_APPEND | LOCK_EX);
			
			$arResult=ardt($arData['file']);
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/api/test.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($arResult, true), FILE_APPEND | LOCK_EX);