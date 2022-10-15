<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 17.12.15
 * Time: 15:39
 */
$arIDSinBasket = array();
$arResult['HAS_NOT_AVAILABLE'] = false;
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem){
    $arIDSinBasket[$arItem["PRODUCT_ID"]] = $arItem["QUANTITY"];
    if((int)$arItem['DETAIL_PICTURE'] > 0){
        $arResult['ITEMS']['AnDelCanBuy'][$key]['PREVIEW_PICTURE_SRC'] =
            CFile::ResizeImageGet(
                $arItem['DETAIL_PICTURE'],
                array('width' => 75, 'height' => 75),
                BX_RESIZE_IMAGE_PROPORTIONAL
            )['src'];
    }
}

//Items phrase prepare
$cnt = count($arResult['ITEMS']['AnDelCanBuy']);
$last_num = substr($cnt, -1);
$lastnum2 = substr($cnt, -2);

if (($lastnum2 >= 10) && ($lastnum2 <= 20))
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_5');
elseif ($last_num == 0 || $last_num > 4)
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_5');
elseif ($last_num == 1 && $this->arResult['INFO']['CNT'] !== 11)
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_1');
else
    $all_title = GetMessage('SALE_TITLE_STEP_1') .' '. $cnt.' '.GetMessage('SALE_COUNT_2');

$arResult['COUNT_PHRASE'] = $all_title;





    foreach ($arResult['ITEMS']['AnDelCanBuy'] as $key => $arItem) {
        $IDKOMPLEKTA = "";
        $rs = CIBlockElement::GetList(
            Array(),
            Array("IBLOCK_ID" => "40", "ID" => $arItem["PRODUCT_ID"]),
            false,
            Array(),
            Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_IDGLAVNOGO", "PROPERTY_IDKOMPLEKTA","PROPERTY_IS_SKU")
        );
        while ($ar_fields = $rs->GetNext()) {
            $IDGLAVNOGO = $ar_fields["PROPERTY_IDGLAVNOGO_VALUE"];
        }
        if($IDGLAVNOGO!=""){
            $rs = CIBlockElement::GetList(
                Array(),
                Array("IBLOCK_ID" => "40", "XML_ID" => $IDGLAVNOGO),
                false,
                Array("nPageSize"=>50),
                Array("ID", "IBLOCK_ID", "NAME", "XML_ID", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_IDGLAVNOGO", "PROPERTY_IDKOMPLEKTA","PROPERTY_IS_SKU")
            );
            while ($ar_fields = $rs->GetNext()) {
                $IDKOMPLEKTA = $ar_fields["PROPERTY_IDKOMPLEKTA_VALUE"];
                $XML_ID =  $ar_fields["XML_ID"];
                if($ar_fields["PROPERTY_IDKOMPLEKTA_VALUE"]==""){
                    $dopTovar = true;
                }
                else{
                    $dopTovar = false;

                }

            }
            if($IDKOMPLEKTA!=""){
                $komplekt = false;
                $ids = array();
                $rs = CIBlockElement::GetList(
                    Array(),
                    Array("IBLOCK_ID" => "40", "PROPERTY_IDGLAVNOGO" => $IDKOMPLEKTA),
                    false,
                    Array("nPageSize"=>50),
                    Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_IDGLAVNOGO", "PROPERTY_IDKOMPLEKTA","PROPERTY_IS_SKU")
                );

                while ($ar_fields = $rs->GetNext()) {
                    if($ar_fields["PROPERTY_IS_SKU_VALUE"]=="Нет"){
                        $glavnyTovar = array(
                            "TOVAR" => $arItem["NAME"],
                            "TOVAR_COUNT" => $arItem["QUANTITY"],
                            "KOMPLEKT" => array(
                                "NAME" => $ar_fields["NAME"],
                                "DETAIL_PAGE_URL" => $ar_fields["DETAIL_PAGE_URL"],
                                "DETAIL_PICTURE" => $ar_fields["DETAIL_PICTURE"]
                            ),
                        );
                    }
                    $ids[] = $ar_fields["ID"];
                }
                $cnt = 0;
                foreach ($ids as $id) {
                    if(array_key_exists($id,$arIDSinBasket)){
                        if($arIDSinBasket[$id]>=$arItem["QUANTITY"]){
                            $komplekt = true;
                            break;
                        }else{
                            $cnt += $arIDSinBasket[$id];
                            if($cnt>=$arItem["QUANTITY"]){
                                $komplekt = true;
                                break;
                            }
                        }
                    }
                }
                if($komplekt!==true){
                    $arResult["KOMPLEKT"][] = $glavnyTovar;
                }
            }



            /*            if(!$dopTovar){
							$rs = CIBlockElement::GetList(
								Array(),
								Array("IBLOCK_ID" => "40", "PROPERTY_IDGLAVNOGO" => $IDKOMPLEKTA),
								false,
								Array("nPageSize"=>50),
								Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_IDGLAVNOGO", "PROPERTY_IDKOMPLEKTA","PROPERTY_IS_SKU")
							);
							while ($ar_fields = $rs->GetNext()) {

								if(in_array($ar_fields["ID"],$arIDSinBasket)){
									$komplekt = true;

								}else{
									if($ar_fields["PROPERTY_IS_SKU_VALUE"]=="Нет"){
										$arResult["KOMPLEKT"][] = array(
											"TOVAR" => $arItem["NAME"],
											"KOMPLEKT" => array(
												"NAME" => $ar_fields["NAME"],
												"DETAIL_PAGE_URL" => $ar_fields["DETAIL_PAGE_URL"],
												"DETAIL_PICTURE" => $ar_fields["DETAIL_PICTURE"]
											),
										);
									}
								}
							}

						}*/
            /*else{
                $rs = CIBlockElement::GetList (
                    Array(),
                    Array("IBLOCK_ID" => "40", "PROPERTY_IDKOMPLEKTA" => $XML_ID),
                    false,
                    Array (),
                    Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE","XML_ID")
                );
                while($ar_fields = $rs->GetNext()) {
                    $rs2 = CIBlockElement::GetList (
                        Array(),
                        Array("IBLOCK_ID" => "40", "PROPERTY_IDGLAVNOGO" => $ar_fields["XML_ID"]),
                        false,
                        Array (),
                        Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE","PROPERTY_IS_SKU")
                    );
                    while($ar_fields2 = $rs2->GetNext()) {
                        if(in_array($ar_fields2["ID"],$arIDSinBasket)){
                            $komplekt = true;
                        }else{
							if($ar_fields2["PROPERTY_IS_SKU_VALUE"]=="Нет") {
								$arResult["KOMPLEKT"][] = array(
									"TOVAR" => $arItem["NAME"],
									"KOMPLEKT" => array(
										"NAME" => $ar_fields["NAME"],
										"DETAIL_PAGE_URL" => $ar_fields["DETAIL_PAGE_URL"],
										"DETAIL_PICTURE" => $ar_fields["DETAIL_PICTURE"]
									),
								);
							}
                        }
                    }

                }

            }*/


            //echo $arItem["NAME"];echo ($komplekt)?" - комплект":" - НЕ комплект"; echo "<br>";

        }

			$realNavChain = array();
		$db_old_groups = \CIBlockElement::GetElementGroups($arItem["PRODUCT_ID"], true);
		while($ar_group = $db_old_groups->Fetch()){
			$navChain = \CIBlockSection::GetNavChain($ar_group["IBLOCK_ID"], $ar_group["ID"]);
			while ($arNav=$navChain->GetNext()){
				$realNavChain[$arNav['ID']]=$arNav['NAME'];
			}			
		}
		$arResult['ITEMS']['AnDelCanBuy'][$key]['SECT']=$realNavChain;
    }



//if($USER->IsAdmin()){ 	echo "<pre>";print_r($arResult);echo "</pre>"; }