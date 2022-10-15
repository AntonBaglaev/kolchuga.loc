<?php

function SendOldBasket($dataup=false){
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******start SendOldBasket****\n", FILE_APPEND | LOCK_EX);
	if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog") )
	{
  
   global $by, $order;
	$by = (isset($by) ? $by : "DATE_UPDATE_MAX");
	$order = (isset($order) ? $order : "ASC");
	$objDateTimeFrom = new \Bitrix\Main\Type\DateTime();
	$objDateTimeFrom->add("- 24 hours");
	$objDateTimeTo = new \Bitrix\Main\Type\DateTime();
	$objDateTimeTo->add("- 23 hours");
	$arFilter=[
		'>=DATE_UPDATE'=> $objDateTimeFrom->toString(),
		'<=DATE_UPDATE'=>$objDateTimeTo->toString(),
		'!USER_ID'=>false,	
	];
	if(is_array($dataup) && (!empty($dataup['DATE_UPDATE_FROM']) || !empty($dataup['DATE_UPDATE_TO'])) ){
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******arFilter filter_old****\n".print_r($arFilter, true), FILE_APPEND | LOCK_EX);
		if(!empty($dataup['DATE_UPDATE_FROM'])){
			$arFilter['>=DATE_UPDATE']=$dataup['DATE_UPDATE_FROM'];
		}
		if(!empty($dataup['DATE_UPDATE_TO'])){
			$arFilter['<=DATE_UPDATE']=$dataup['DATE_UPDATE_TO'];
		}
	}
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******arFilter****\n".print_r($arFilter, true), FILE_APPEND | LOCK_EX);
	$dbResultList = \CSaleBasket::GetLeave(array($by => $order), $arFilter,false,false,array());
	while ($arBasket = $dbResultList->Fetch())
	{
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******send ".$arBasket["USER_EMAIL"]." ****\n".print_r($arBasket, true), FILE_APPEND | LOCK_EX);
		$sostavHtml2='';
		$arBasketItems=[];
		//\Kolchuga\Settings::xmp($arBasket,0, __FILE__.": ".__LINE__,true);
		$arFilterBasket = Array("ORDER_ID" => false, "FUSER_ID" => $arBasket["FUSER_ID"], "LID" => $arBasket["LID"]);
		$arFilterBasket["CAN_BUY"] = 'Y';
		
		$dbB = \CSaleBasket::GetList(
			array("ID" => "ASC"),
			$arFilterBasket,
			false,
			false,
			array("ID", "PRODUCT_ID", "NAME", "QUANTITY", "PRICE", "CURRENCY", "DETAIL_PAGE_URL", "LID", "SET_PARENT_ID", "TYPE")
		);
		while($arB = $dbB->Fetch())
		{
			$elementQueryObject = \CIBlockElement::getList(array(), array("ID" => $arB["PRODUCT_ID"]), false, false, array("IBLOCK_ID", "IBLOCK_TYPE_ID", 'DETAIL_PICTURE'));
			if ($elementData = $elementQueryObject->fetch())
			{
				$arB['IBLOCK_ID']=$elementData["IBLOCK_ID"];
				$arB['IBLOCK_TYPE_ID']=$elementData["IBLOCK_TYPE_ID"];
				//$arB['DETAIL_PICTURE']=\CFile::GetPath($elementData["DETAIL_PICTURE"]);
				$arB['DETAIL_PICTURE']=\CFile::ResizeImageGet(
							$elementData['DETAIL_PICTURE'],
							array('width' => 250, 'height' => 187),
							BX_RESIZE_IMAGE_PROPORTIONAL
						)['src'];
			}
			$arBasketItems[] = $arB;
		}

		$arBasketItems = getMeasures($arBasketItems);
			//\Kolchuga\Settings::xmp($arBasketItems,0, __FILE__.": ".__LINE__,true);
		foreach ($arBasketItems as $arB)
		{
			$a = \Kolchuga\StoreList::itemRazmerDostupByArt(false, array( 'IBLOCK_ID'=>$arB['IBLOCK_ID'], 'ID'=>$arB['PRODUCT_ID'] ,'ONLY_ID'=>'Y') );
			//\Kolchuga\Settings::xmp($a['ITEM'][0][''],0, __FILE__.": ".__LINE__,true);
			//\Kolchuga\Settings::xmp($a['SKU_COUNT_AMOUNT'],0, __FILE__.": ".__LINE__,true);
			if($a['SKU_COUNT_AMOUNT']>0){
				$english_format_number = number_format($arB['PRICE'], 2, '.', ' ');
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
																						   <td style="border-collapse:collapse; border-color:transparent; background-image:url(https://'.$_SERVER['HTTP_HOST'].$arB['DETAIL_PICTURE'].'); background-position:left center; background-repeat:no-repeat; background-size:contain; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 25px 0 0; text-align:left; width:225px" valign="top" width="225" align="left"><a href="https://'.$_SERVER['HTTP_HOST'].$arB['DETAIL_PAGE_URL'].'" style="text-decoration:none; color:#21385e"><img style="height:auto; line-height:100%; outline:0; text-decoration:none; border:0; display:block; margin:0; padding:0; width:200px" src="https://'.$_SERVER['HTTP_HOST'].$arB['DETAIL_PICTURE'].'" alt="'.$arB['NAME'].'" width="200" height="auto"> </a></td>
																						</tr>
																						<tr style="border-color:transparent">
																						   <td style="border-collapse:collapse; border-color:transparent; font-family:Arial, sans-serif; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 0 20px 0" valign="bottom" width="200">&nbsp;</td>
																						</tr>
																					 </tbody>
																				  </table>
																			   </td>
																			   <td style="border-collapse:collapse; border-color:transparent; color:#444; font-family:Arial, sans-serif; font-size:0; font-weight:lighter; line-height:0; margin:0; padding:0 0 35px 0; text-align:left; width:295px" valign="top" width="295" align="left">
																				  <p style="line-height:1.5; margin:0 !important; font-size:14px; color:#444; font-family:Arial, sans-serif; font-weight:normal; padding:0"><span style="font-size: 14px; color: #444444; display: block; text-decoration: none;"><a style="text-decoration:none; color:#444; font-size:14px" href="https://'.$_SERVER['HTTP_HOST'].$arB['DETAIL_PAGE_URL'].'"><strong>'.$arB['NAME'].'</strong></a></span></p>
																				  <p style=\'line-height:1.5; margin:0 !important; font-size:15px; color:#444; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight:normal; padding:0\'>&nbsp;</p>
																				  <p style="line-height:1.5; margin:0 !important; font-size:20px; color:#424242; font-family:Arial, sans-serif; font-weight:normal; padding:0"><strong>'.$english_format_number.' ₽</strong></p>
																				  <p style=\'line-height:1.5; margin:0 !important; font-size:25px; color:#444; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight:normal; padding:0\'>&nbsp;</p>
																				  <p style="line-height:1.5; margin:0 !important; font-size:14px; color:#24c1ff; font-family:Arial, sans-serif; font-weight:normal; padding:0"><span style="font-size: 14px; color: #808080; display: block; margin-bottom: -5px; text-decoration: none;"><a style="  display: block;width: 200px;font-family: PT Sans;font-size: 14px;color: #21385E;border: 1px solid #21385E;text-align: center;padding: 7px 0;text-decoration: none;" href="https://'.$_SERVER['HTTP_HOST'].$arB['DETAIL_PAGE_URL'].'">Перейти к товару</a></span></p>
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
		}
		//\Kolchuga\Settings::xmp($sostavHtml2,0, __FILE__.": ".__LINE__,true);
		if(!empty($sostavHtml2) && !empty($arBasket["USER_EMAIL"])){
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******send ".$arBasket["USER_EMAIL"]." ****\n", FILE_APPEND | LOCK_EX);
			\Bitrix\Main\Mail\Event::send(array(
				"EVENT_NAME" => "OLD_BASKET",
				"LID" => "s1",
				"C_FIELDS" => array(
					"EMAIL" => $arBasket["USER_EMAIL"], "SOSTAV_HTML2" => $sostavHtml2
				)
			));
		}
		
		
	}


	}
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_basketold.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******end SendOldBasket****\n", FILE_APPEND | LOCK_EX);
	return 'SendOldBasket();';
}

function SetNoObuv(){
	array_map('CModule::IncludeModule', ['iblock', 'catalog','sale']);
	set_time_limit(300);
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."******start****\n", FILE_APPEND | LOCK_EX);
	$rs = \CIBlockElement::GetList(
	   array(), 
	   array(
	   "IBLOCK_ID" => 40,
		'INCLUDE_SUBSECTIONS'=>'Y',
		'ACTIVE'=>'Y',
		'PROPERTY_SECT_ELEMENT'=>false,
		'NAME'=>["%Ботинки%","%Сапоги%","%кроссовки%","%полуботинки%","%полусапоги%","%тапочки%","%галоши%","%сабо%","%сандали%","%туфли%","%калоши%","%стельки%","%Крем для обуви%","%Кросовки%","%Чехол для обуви%","%Набор щеток%","%Рожок для обуви%","%Болотники%","%Чуни%","%Забродники%"]

	   ),
	   false, 
	   Array("nTopCount"=>350),
	   array("ID")
	);
	$mm=[];
	$el = new \CIBlockElement; 

	while($ar = $rs->GetNext()) {
	   $mm[]=$ar['ID'];
		//$res = $el->Update($ar['ID'], array('ACTIVE'=>'N'));
		\CIBlockElement::SetPropertyValuesEx(
					$ar['ID'],
					40,
					array(
						"SECT_ELEMENT" => 'Обувь',						
					)
				);
	}
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($mm, true), FILE_APPEND | LOCK_EX);
	
	/*$rsSections = \CIBlockSection::GetList(array('id' => 'ASC'), array("IBLOCK_ID" => 40,'ACTIVE'=>'Y', 'NAME'=>["%Обувь%",]),false, array("ID",'NAME'));
	$bs = new \CIBlockSection;

	while ($arSection = $rsSections->Fetch())
	{
		$res = $bs->Update($arSection['ID'], array('ACTIVE'=>'N'));
	}*/
	
    return 'SetNoObuv();';

}

function SetOnSklad(){
	$strt=time();
	array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale'));
	$arResult['STORE_LIST_ALL'] = array();
	//$arResult['obnova'] = array();
	$arResult['obnova2'] = array();

    $res = CIBlockElement::GetList(
        array('id' => 'asc'),
        array('IBLOCK_ID' => 7),
        false,
        false,
        array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_stores','PROPERTY_show_in_list')
    );

    while($store = $res->Fetch()){		
        $arResult['STORE_LIST_ALL'][] = $store;
    }
	
	$infoznach=[
		112=>765724,
		114=>765725,
		115=>765726,
		116=>765727,
		631125=>765728,
		699777=>765900,
	];

	$dbEl = \CIBlockElement::GetList(array('id' => 'asc'), array('IBLOCK_ID' => 40, ), false, false, Array('ID'));
	while($obEl = $dbEl->Fetch())	
	{
		$PRODUCT_ID=$obEl['ID'];
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$PRODUCT_ID,'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
			'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
		));
		while($arStoreProduct=$rsStoreProduct->fetch())
		{
			foreach($arResult['STORE_LIST_ALL'] as $kl=>$ckld){
				//$arResult['obnova'][$PRODUCT_ID][$ckld['ID']]='N';				
				if(in_array($arStoreProduct['STORE_XML_ID'],$ckld['PROPERTY_STORES_VALUE'] )){
					//$arResult['obnova'][$PRODUCT_ID][$ckld['ID']]='Y';
					$arResult['obnova2'][$PRODUCT_ID][]=$infoznach[$ckld['ID']];					
				}		
			}
		}
		if(empty($arResult['obnova2'][$PRODUCT_ID])){
			$arResult['obnova2'][$PRODUCT_ID][]='';
		}
	}
	foreach($arResult['obnova2'] as $ids=>$item){
		\CIBlockElement::SetPropertyValuesEx(
					$ids,
					40,
					array(
						"ON_SKLAD" => $item,						
					)
				);
	}
	$nnd=time()-$strt;
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_onsklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($nnd, true), FILE_APPEND | LOCK_EX);
	
	return 'SetOnSklad();';
}

function activiteItemById($id=0){
	if(intval($id)>0){
		if (\CModule::IncludeModule("iblock")){
			$elementQueryObject = \CIBlockElement::getList(array(), array("ID" => $id), false, false, array("IBLOCK_ID", "ID", 'ACTIVE'));
			if ($elementData = $elementQueryObject->fetch())
			{
				if($elementData['ACTIVE']=='N' ){
					$el = new \CIBlockElement; 
					$res = $el->Update($elementData['ID'], array('ACTIVE'=>'Y'));
				}
			}
		}
	}
	return 'activiteItemById('.intval($id).');';
}

function activiteBlaser25(){
	
		if (\CModule::IncludeModule("iblock")){
			include_once $_SERVER["DOCUMENT_ROOT"].'/local/tools/SimpleXLSX.php';
			$arrXlsx=[];

			if ( $xlsx = \SimpleXLSX::parse($_SERVER["DOCUMENT_ROOT"].'/upload/blasersale2.xlsx') ) {
				$arrXlsx = $xlsx->rows();
			}

			$massa=[];
			$massa0=[];
			foreach($arrXlsx as $kl=>$vl){
				if($kl<4 || $kl>331){
					unset($arrXlsx[$kl]);
				}else{
					$massa[$vl[2]]=$vl[3];
					$massa0[]=$vl[2];
				}	
			}

			//собираем номенклатуру которую нужно отметить
			
			$items=[];
			$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'NAME'=>$massa0), false, false, Array('ID','NAME'));
			while($elIdArr = $dbEl->Fetch()) {
				$priceold0=( intval($massa[$elIdArr['NAME']])*100/75 );
				$priceold=ceil( $priceold0 );
				if($priceold>1){					
					\CIBlockElement::SetPropertyValuesEx($elIdArr['ID'], false, ['OLD_PRICE'=>$priceold]);
					$items[$elIdArr['ID']]=$elIdArr['NAME'].' ['.$massa[$elIdArr['NAME']].':'.$priceold.']';
				}
			}
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_activiteblaser25.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($items,true), FILE_APPEND | LOCK_EX);
		}
	
	return 'activiteBlaser25();';
}

function sendblaserostatki(){

array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale'));



$sh=[
29069424, 29069425, 29069422, 29069423, 29069421, 29063584, 29063582, 29063583, 29065630, 29044339, 29044335, 29059559, 29059571, 29044338, 29059569, 29059560, 29059568, 29044334, 29059570, 29059561, 29059562, 29059580, 29058376, 29059582, 29069381, 29059581, 29065005, 29065007, 29065006, 29065003, 29064990, 29064986, 29064991, 29064992, 29065001, 29064985, 29064983, 29064988, 29064982, 29064987, 29064995, 29064996, 29064981, 29065000, 29064980, 29064994, 29064997, 29064998, 29066411, 29066412, 29066413, 29067773, 29066414, 29067774, 29067775, 29067776, 29067771, 29067772, 29053629, 29053628, 29061941, 29055224, 29053587, 29053584, 29053583, 29056608, 29056607, 29055225, 29056609, 29053585, 29053586, 29057654, 29056613, 29056610, 29057724, 29056611, 29061909, 29056616, 29056615, 29061908, 29061910, 29061911, 29061912, 29061913, 29064934, 29064935, 29064938, 29064937, 29064936, 29063551, 29063552, 29063553, 29063554, 29069347, 29069346, 29069348, 29066346, 29066347, 29066349, 29066348, 29066356, 29066357, 29069349, 29069350, 29069351, 29069352, 29069353, 29056660, 29056661, 29056662, 29056663, 29061873, 29056653, 29056652, 29061874, 29056649, 29056664, 29056651, 29056648, 29061875, 29056650, 29061877, 29061887, 29061886, 29061888, 29064957, 29061889, 29063539, 29061890, 29063540, 29063541, 29063542, 29064946, 29064947, 29064949, 29065086, 29064941, 29064944, 29064942, 29064940, 29064952, 29064939, 29064954, 29064956, 29064951, 29064953, 29067750, 29064968, 29064967, 29064966, 29064962, 29064965, 29064969, 29064961, 29064964, 29064959, 29065087, 29064960, 29066368, 29066369, 29066370, 29066366, 29066373, 29066364, 29066375, 29066372, 29066371, 29066367, 29066402, 29066365, 29066374, 29067744, 29067745, 29067747, 29067746, 29067749, 29067748, 29069342, 29069343, 29069344, 29069345, 29069341
];

$massa=[];
$massa[]=['art','kol','id','name','bar'];
foreach($sh as $barcode){
	
$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'PROPERTY_CML2_BAR_CODE'=>"%".$barcode."%"), false, false, Array('ID','IBLOCK_ID','CATALOG_GROUP_2','NAME','PROPERTY_CML2_BAR_CODE'));
	while($arEl = $dbEl->GetNext())	
	{	
		$massa[]=[$barcode ,$arEl['CATALOG_QUANTITY'],$arEl['ID'],$arEl['NAME'],$arEl['PROPERTY_CML2_BAR_CODE_VALUE']];
		
	}
}
include_once $_SERVER["DOCUMENT_ROOT"].'/test/SimpleXLSXGen.php';
\SimpleXLSXGen::fromArray( $massa )->saveAs($_SERVER["DOCUMENT_ROOT"].'/upload/blaser.xlsx');

 $filename = $_SERVER["DOCUMENT_ROOT"].'/upload/blaser.xlsx'; //Имя файла для прикрепления
  $to = "market@elemax.life, ionov.vladimir@chain-mail.ru"; //Кому
  $from = "shop@kolchuga.ru"; //От кого
  $subject = "Остатки+контроль наличия и прогрузка маркетплейсов"; //Тема
  $message = "Файл"; //Текст письма
  $boundary = "---"; //Разделитель
  /* Заголовки */
  $headers = "From: $from\nReply-To: $from\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
  $body = "--$boundary\n";
  /* Присоединяем текстовое сообщение */
  $body .= "Content-type: text/html; charset='utf-8'\n";
  $body .= "Content-Transfer-Encoding: quoted-printablenn";
  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
  $body .= $message."\n";
  $body .= "--$boundary\n";
  $file = fopen($filename, "r"); //Открываем файл
  $text = fread($file, filesize($filename)); //Считываем весь файл
  fclose($file); //Закрываем файл
  /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
  $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($filename)."?=\n";
  $body .= "Content-Transfer-Encoding: base64\n";
  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
  $body .= chunk_split(base64_encode($text))."\n";
  $body .= "--".$boundary ."--\n";
  mail($to, $subject, $body, $headers); //Отправляем письмо
  
  return 'sendblaserostatki();';
}

function tovarnewyear(){
	array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale'));
	$strt=time();
$massa=[];
/* ножи */
/* $dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, 'SECTION_ID'=>17894, 'INCLUDE_SUBSECTIONS'=>'Y', '!PROPERTY_NEAKTSIYA_VALUE'=>'Да', ), false, false, Array('ID','NAME','PROPERTY_NEAKTSIYA'));
while($elIdArr = $dbEl->Fetch()) {
	$massa[]=$elIdArr;
	
	$allGroups=[];
	$realNavChain = array();
	$db_old_groups = \CIBlockElement::GetElementGroups($elIdArr['ID'], true);
	while($ar_group = $db_old_groups->Fetch()){
		if ($group["ID"] != 17894 && $group["ID"] != 17896 && $group["ID"] != 17900) 
		{
		  $allGroups[$elIdArr["ID"]][] = $ar_group["ID"];       
		}
		 
		
		$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
		while ($arNav=$navChain->GetNext()){			
			$realNavChain[$elIdArr["ID"]][] = $arNav["ID"];
			
		}		
	}
	  
	  
	  foreach ($allGroups as $elementId => $arGroups) 
		{
			if(!in_array(18061,$realNavChain[$elementId])){
				
				
				foreach($arGroups as $kl=>$vl){
					if(in_array($vl,[17894,17896,17900])){
						unset($arGroups[$kl]);
					}
				}
				if(!in_array(18376,$arGroups)){$arGroups[]=18376;}
				
								
			  \CIBlockElement::SetElementSection(
			   $elementId,
			   $arGroups   
			  ); 
			}else{
				foreach($arGroups as $kl=>$vl){
					if(in_array($vl,[18376])){
						unset($arGroups[$kl]);
					}
				}
				\CIBlockElement::SetElementSection(
				   $elementId,
				   $arGroups   
				  ); 
			}
		}

} */

$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, '!PROPERTY_NEAKTSIYA_VALUE'=>'Да','PROPERTY_TOVAR_PO_AKCII'=>'702828', ), false, false, Array('ID','NAME','PROPERTY_NEAKTSIYA','PROPERTY_TOVAR_PO_AKCII'));
while($elIdArr = $dbEl->Fetch()) {	
	$allGroups=[];
	$groupsObj = \CIBlockElement::GetElementGroups(
	   $elIdArr["ID"],
	   false,
	   array()
	  );
	  while($group = $groupsObj->Fetch())
	  {		
		$allGroups[$elIdArr["ID"]][] = $group["ID"];		    
	  }
	  
	  foreach ($allGroups as $elementId => $arGroups) 
		{
			$arGroups[]=18376;
		  \CIBlockElement::SetElementSection(
		   $elementId,
		   $arGroups   
		  );
		}
}

$dbEl = \CIBlockElement::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => 40, '!PROPERTY_NEAKTSIYA_VALUE'=>'Да','PROPERTY_TOVAR_PO_AKCII'=>'702827', ), false, false, Array('ID','NAME','PROPERTY_NEAKTSIYA','PROPERTY_TOVAR_PO_AKCII'));
while($elIdArr = $dbEl->Fetch()) {
	
	$allGroups=[];
	$groupsObj = \CIBlockElement::GetElementGroups(
	   $elIdArr["ID"],
	   false,
	   array()
	  );
	  while($group = $groupsObj->Fetch())
	  {		
		$allGroups[$elIdArr["ID"]][] = $group["ID"];		    
	  }
	  
	  foreach ($allGroups as $elementId => $arGroups) 
		{
			$arGroups[]=18376;
		  \CIBlockElement::SetElementSection(
		   $elementId,
		   $arGroups   
		  );
		}
}
	
	$bs = new \CIBlockSection;
	$res = $bs->Update(18376, ['ACTIVE'=>'Y']);
	$strt_end=time()-$strt;
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/agent_tovarnewyear.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($strt_end.' sec.',true), FILE_APPEND | LOCK_EX);
	return 'tovarnewyear();';
}

function patronNareznoy($arr_id=array(),$printer='N'){
	array_map('CModule::IncludeModule', array('iblock', 'catalog', 'sale'));
	$massa246_1=[
			'.223'=>'.223 Rem',			
			'9.3x62'=>'9,3x62',			
			'8х68'=>'8x68 S',
			'.300'=>'.300 WM',
			'.300 Win Mag'=>'.300 WM',
			'.308'=>'.308 Win',
			'.308 W'=>'.308 Win',
			'.308 Win Mag'=>'.308 Win',
			'.338'=>'.338 Win Mag',
			'.338 Lapua M'=>'.338 Lapua Magnum',
			'.338 Lapua Mag'=>'.338 Lapua Magnum',
			'6.5'=>'6,5 Creedmoor',
			'6.5 creedmoor'=>'6,5 Creedmoor',
			'6.5 Creedmoor'=>'6,5 Creedmoor',		
			'9.3x62'=>'9,3x62',
			'9.3x74 R'=>'9,3x74 R',
			'9.3x74'=>'9,3x74 R',
			'9.3x74 R'=>'9,3x74 R',
			'9.3х74 R'=>'9,3x74 R',
			'9mm Para'=>'9x19',
			'.222'=>'.222 Rem',
			'.243'=>'.243 Win',
			'.30-06 Spr'=>'.30-06',
			'.30-06 Sprg'=>'.30-06',
			'10.3х60 R'=>'10.3x60 R',
			'8x57 JS'=>'8х57 JS',			
		];
	$arFilter=array(
		"IBLOCK_ID"=>40,
		'SECTION_ID'=>17859,
		'INCLUDE_SUBSECTIONS'=>'Y',
			array(
				  "ID" => \CIBlockElement::SubQuery("ID", array(
					"IBLOCK_ID" => 40,
					"PROPERTY_KALIBR" => array_keys($massa246_1),
				  ))
			)
		);
		if(!empty($arr_id)){$arFilter['ID']=$arr_id;}
	$rs = \CIBlockElement::GetList(
	   array(), 
	   $arFilter,
	   false, 
	   false,
	   array("ID",'IBLOCK_ID','ACTIVE')
	);
	$mm=[];
	$el = new \CIBlockElement; 
	while($ob = $rs->GetNextElement()){
		$ar = $ob->GetFields();
		$ar['PROP'] = $ob->GetProperties(array(), array('CODE' => 'KALIBR'));
	   $mm[]=$ar;
	   $arrItemP=[];
	   foreach($ar['PROP']['KALIBR']['VALUE'] as $itemP){
		    if(!empty($massa246_1[$itemP])){
				$arrItemP[]=$massa246_1[$itemP];
			}
	   }
	   if(!empty($arrItemP)){
		\CIBlockElement::SetPropertyValuesEx($ar["ID"], false, array("KALIBR" => $arrItemP));
		$resUp = $el->Update($ar["ID"], ['ACTIVE'=>$ar["ACTIVE"]]);
	   }
	}
	if($printer=='Y'){	print_r($mm); }
	return 'patronNareznoy();';
}