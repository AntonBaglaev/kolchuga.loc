<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//if($arResult['ONLY_SKLAD']=='N'){return false;}
if( ($arResult['OPLATA_BANK']==17  && $arResult['PS_ONLY']=='N') || ($arResult['OPLATA_BANK']==3  && $arResult['PS_ONLY']=='Y') ){
		//return false;
	
}
?><style>.nosee {display:none;}</style><?

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/autocomplete.js');
$tmp_path = $component->__template->__folder;

// 1.Redirect on submit
include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/helpers/redirect.php"); ?>

<?
// 2.Auth needle
if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N"){
    include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/helpers/need_auth.php");
} else{// 3.Confirm
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y"){
        if(strlen($arResult["REDIRECT_URL"]) == 0)
            include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/parts/confirm.php");
    } else{// 4.Form html
        ?>
        <form class="form__horizontal form__order js-order"
              action="<?= $APPLICATION->GetCurPage(); ?>"
              method="POST"
              name="ORDER_FORM"
              id="ORDER_FORM"
              enctype="multipart/form-data">
            <?//var_dump($_POST)?>
            <input type="hidden" name="is_ajax_post" value="Y">
            <? if($_REQUEST['is_ajax_post'] == 'Y') $APPLICATION->RestartBuffer();
            echo bitrix_sessid_post();
            if($_REQUEST['PERMANENT_MODE_STEPS'] == 1):?>
                <input type="hidden" name="PERMANENT_MODE_STEPS" value="1"/>
            <? endif ?>

            <?// 5.Show errors
            if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y"){
                include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/helpers/error.php");
            }

            //7. Prepay fields
            if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                echo $arResult["PREPAY_ADIT_FIELDS"];

            // 8. Hidden form fields
            include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/helpers/hidden.php");

            //                    foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $prop) {
            //                        if ($prop['IS_PHONE'] == 'Y' && $prop['IS_ADDRESS'] == 'Y') continue;
            //                        echo '<input type="hidden" name="'.$prop['FIELD_NAME'].'" value="'.$prop['VALUE'].'">';
            //                    }

            //9. Submit Form
            ?>

            <div class="form__order--wrapper">
                <div class="form__order--left">
                    <div class="form__group--title">
                        ???????????? ????????????
                    </div>
					<?$tovar_na_sklad=array();
						foreach($arResult['BASKET_ITEMS'] as $key=>$arItem) {
							foreach($arItem['SET_SKLAD'] as $skladid=> $sklad){
								$tovar_na_sklad[]=$skladid.':'.$arItem['PRODUCT_ID'].':'.$sklad['PRODUCT_ID'][$arItem['PRODUCT_ID']];
							}
						}
						file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/log/order_tovar_na_sklad.txt", "\n** ".date("d.m.Y H:i:s")." ****". __FILE__ ." ". __LINE__ ."**********\n".print_r($tovar_na_sklad, true), FILE_APPEND | LOCK_EX);
					?>
					
                    <? foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $key => $prop):
                        if($prop['IS_PHONE'] == 'Y' || $prop['IS_EMAIL'] == 'Y' || $prop['IS_PAYER'] == 'Y' || $prop['PROPS_GROUP_ID1']==1 || in_array($prop['ID'], [27,28,29])):?>
                            <?if($prop['ID']==1){?>
								<input id="field_11_<?$prop['ID']?>"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="hidden"
											   value="<?= $prop['VALUE'] ?>">
							<?}elseif($prop['ID']==30){?>
								<input id="field_11_<?$prop['ID']?>"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="hidden"
											   value="<?//= implode(";",$tovar_na_sklad) ?>">
							<?}else{?>							
								<div class="form__group">
									<label for="field_11"><?= $prop['NAME'] ?><span class="req">*</span></label>
									<div class="form__input">
										<input id="field_11"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="text"
											   value="<?= $prop['VALUE'] ?>">
									</div>
								</div>
							<?}?>
                            <? unset($arResult['ORDER_PROP']['USER_PROPS_Y'][$key]);
                        endif;
                    endforeach; ?>
                    <div class="form__group--title">
                        ???????????? ?????? ????????????????
                    </div>
                    <?
                    $text_location_name = '';
                    $stores_prop = false;

                    foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $key => $prop){
                        if($prop['CODE'] == 'CITY'){
                            $text_location_name = $prop['FIELD_NAME'];
                            unset($arResult['ORDER_PROP']['USER_PROPS_Y'][$key]);
                        } elseif($prop['CODE'] == 'PICKUP_POINT'){
                            $stores_prop = $prop;
                            unset($arResult['ORDER_PROP']['USER_PROPS_Y'][$key]);
                        }
                    }

					
					
						
					
					
					
					
					
                    foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $key => $prop): ?>
						<?if($prop['ID']==25){continue;}?>
                        <div class="form__group">
                            <label for="field_99"><?= $prop['NAME'] ?><span class="req">*</span></label>
                            <div class="form__input">
                                <? if($prop['IS_ADDRESS'] == 'Y'): ?>
                                    <textarea name="<?= $prop['FIELD_NAME'] ?>"
                                              type="text"><?= $prop['VALUE'] ?></textarea>
                                <? elseif($prop['IS_LOCATION'] == 'Y'):

                                    $prop['TEXT_VALUE'] = '';
                                    if($prop['VALUE'] > 0){

                                        $arLocs = CSaleLocation::GetByID($prop['VALUE'], LANGUAGE_ID);

                                        $prop['TEXT_VALUE'] = $arLocs['CITY_NAME'];

                                        if($arLocs["REGION_NAME"]){
                                            $prop['TEXT_VALUE'] .= ", " . $arLocs["REGION_NAME"];
                                        }

                                    }
                                    ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="hidden"
                                           value="<?= $prop['VALUE'] ?>">

                                    <input name="<?= $text_location_name ?>"
                                           type="text"
                                           class="search-loc"
                                           autocomplete="off"
                                           value="<?= $prop['TEXT_VALUE'] ?>">
                                    <div class="form__result js-search-result-loc"></div>
                                    <?
                                else: ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="text"
                                           value="<?= $prop['VALUE'] ?>">
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form__group--title">
                        ???????????????????????????? ????????????????????
                    </div>
					
					<?foreach($arResult['ORDER_PROP']['USER_PROPS_N'] as $key => $prop){
						if($prop['ID']==30){?>
									<input id="field_11_<?$prop['ID']?>"
												   name="<?= $prop['FIELD_NAME'] ?>"
												   type="hidden"
												   value="<?//= implode("; ",$tovar_na_sklad) ?>">
						<?}
					}?>
											   
					<?foreach($arResult['ORDER_PROP']['USER_PROPS_N'] as $key => $prop): ?>
						<?if($prop['ID']!=24){continue;}?>
                        <div class="form__group">
                            <label for="field_99"><?= $prop['NAME'] ?><span class="req">*</span></label>
                            <div class="form__input">
                                <? if($prop['IS_ADDRESS'] == 'Y'): ?>
                                    <textarea name="<?= $prop['FIELD_NAME'] ?>"
                                              type="text"><?= $prop['VALUE'] ?></textarea>
                                <? elseif($prop['IS_LOCATION'] == 'Y'):

                                    $prop['TEXT_VALUE'] = '';
                                    if($prop['VALUE'] > 0){

                                        $arLocs = CSaleLocation::GetByID($prop['VALUE'], LANGUAGE_ID);

                                        $prop['TEXT_VALUE'] = $arLocs['CITY_NAME'];

                                        if($arLocs["REGION_NAME"]){
                                            $prop['TEXT_VALUE'] .= ", " . $arLocs["REGION_NAME"];
                                        }

                                    }
                                    ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="hidden"
                                           value="<?= $prop['VALUE'] ?>">

                                    <input name="<?= $text_location_name ?>"
                                           type="text"
                                           class="search-loc"
                                           autocomplete="off"
                                           value="<?= $prop['TEXT_VALUE'] ?>">
                                    <div class="form__result js-search-result-loc"></div>
                                    <?
                                else: ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="text"
                                           value="<?= $prop['VALUE'] ?>">
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form__group">
                        <label for="field_88">??????????????????????</label>
                        <div class="form__input">
                            <textarea id="field_88"
                                      name="ORDER_DESCRIPTION"
                                      rows="6"
                                      cols="40"><?= $arResult['ORDER_DATA']['ORDER_DESCRIPTION'] ?></textarea>
                        </div>
                    </div>

                    <div class="form__group c_pay_cash">
                        <label for="field_23" class="label_ORDER_PROP_23">????????????????????, ?????????????? ??????????, ?? ?????????????? ?????? ?????????????????????? ??????????</label>
                        <div class="form__input">
                            <input name="ORDER_PROP_23" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="form__order--right">
                    <div class="form__group--title">
                        ?????????????? ????????????????
                    </div>
                    <div class="form__group">
                        <? $current_delivery = 0;
						include_once $_SERVER["DOCUMENT_ROOT"].'/api/SimpleXLSX.php';
							if ( $xlsx = SimpleXLSX::parse($_SERVER["DOCUMENT_ROOT"].'/upload/zonipickpoint.xlsx') ) {
								$massiv1 = $xlsx->rows();
							}
                        foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
							
							if($arDelivery['ID']==34){
								
							if($arResult['ORDER_PROP']['USER_PROPS_Y'][5]['VALUE'] > 0){

								$arLocs = \CSaleLocation::GetByID($arResult['ORDER_PROP']['USER_PROPS_Y'][5]['VALUE'], LANGUAGE_ID);
																	
							foreach($massiv1 as $el){
								if($el[0]==$arLocs['CITY_NAME'] && $el[3]>4){
									//echo "<pre style='text-align:left;'>";print_r($el);echo "</pre>";
									$sregio=explode(' ',$el[1]);
									$pos=strpos($arLocs['REGION_NAME'], $sregio[0]);
									if ($pos !== false) {
									unset($arResult["DELIVERY"][34]);
									}
								}
							}
							}
							}
						}
                        foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery):
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}
                            if($delivery_id !== 0 && intval($delivery_id) <= 0):
                                foreach($arDelivery["PROFILES"] as $profile_id => $arProfile):?>
                                    <div class="label__block popover">
                                        <label class="label--radio label--img">
                                            <input data-price="<?=$arDelivery['PRICE']?>" data-ident="<?=$arDelivery['ID']?>" type="radio"
                                                   name="<?= htmlspecialcharsbx($arProfile["FIELD_NAME"]) ?>"
                                                   value="<?= $delivery_id . ":" . $profile_id; ?>"
                                                <?= $arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : ""; ?>
                                            >
                                            <div class="label-inner">
                                                <? if($arProfile['LOGOTIP']): ?>
                                                    <em class="label-icon"><img
                                                            src="<?= $arProfile['LOGOTIP']['SRC'] ?>"
                                                            alt=""></em>
                                                <? endif ?>
                                                <div><span><?= htmlspecialcharsbx($arDelivery["TITLE"]) ?></span></div>

                                            </div>
                                        </label>
                                        <? if($arProfile['DESCRIPTION']): ?>
                                            <span class="label-help"><span class="icon-help-with-circle"></span></span>
                                            <div class="popover-box">
                                                <a href="#" class="popover-close"><i class="icon-close"></i></a>
                                                <?= $arProfile['DESCRIPTION'] ?>
                                            </div>
                                        <? endif ?>
                                    </div>
                                <?endforeach;
                            else:
                                if($arDelivery["CHECKED"] == "Y")
                                    $current_delivery = $arDelivery['ID'];
                                ?>
                                <div class="label__block popover">
                                    <label class="label--radio label--img">
                                        <input data-price="<?=$arDelivery['PRICE']?>" data-ident="<?=$arDelivery['ID']?>" type="radio"
                                               name="<?= htmlspecialcharsbx($arDelivery["FIELD_NAME"]) ?>"
                                               value="<?= $delivery_id ?>"
                                            <?= $arDelivery["CHECKED"] == "Y" ? "checked=\"checked\"" : ""; ?>>
                                        <div class="label-inner">
                                            <? if($arDelivery['LOGOTIP']): ?>
                                                <em class="label-icon"><img src="<?= $arDelivery['LOGOTIP']['SRC'] ?>"
                                                                            alt=""></em>
                                            <? endif ?>
                                            <div><span><?= htmlspecialcharsbx($arDelivery["NAME"]) ?></span></div>
                                        </div>
                                    </label>
                                    <? if($arDelivery['DESCRIPTION']): ?>
                                        <span class="label-help"><span class="icon-help-with-circle"></span></span>
                                        <div class="popover-box classdel<?=$arDelivery['ID']?><?=($arDelivery['ID']=='34' && $arDelivery["CHECKED"] == "Y" ? ' popover-open':'')?>">
                                            <a href="#" class="popover-close"><i class="icon-close"></i></a>
                                            <?= $arDelivery['DESCRIPTION'] ?>
                                        </div>
                                    <? endif ?>
                                </div>
                            <?endif;
                        endforeach;?>
                    </div>
                    <? if($current_delivery == 2 && $stores_prop && count($arResult['STORE_LIST']) > 0): ?>
                        <div class="form__group--title">???????????????? ?????????? ????????????????????</div>
                        <div class="form__group"><select name="<?= $stores_prop['FIELD_NAME'] ?>">
                                <? foreach($arResult['STORE_LIST'] as $store): ?>                                
                                    <option value="<?= $store['NAME'] ?>"<?= $stores_prop['VALUE'] == $store['NAME'] ? ' selected="selected"' : '' ?>><?=
                                        $store['NAME']
                                        ?></option>
                                <? endforeach; ?>
                            </select></div>
                    <? endif ?>
					<? if($current_delivery == 31 && !empty($arResult['ORDER_PROP']['USER_PROPS_Y'][25])): ?>
                        <div class="form__group--title">???????????????? ?????????? ????????????????</div>
                        <div class="form__group"><select name="<?= $arResult['ORDER_PROP']['USER_PROPS_Y'][25]['FIELD_NAME'] ?>">
                                <? foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][25]["VARIANTS"] as $arVariants): ?>                                
                                    <option
                                    value="<?= $arVariants["VALUE"] ?>"<? if ($arVariants["SELECTED"] == "Y") echo " selected"; ?>><?= $arVariants["NAME"] ?></option>
                                <? endforeach; ?>
                            </select></div>
                    <? endif ?>
                    <div class="form__group--title">?????????????? ????????????</div>
                    <div class="form__group">
                        <?$current_paysystem = 0;
                        foreach($arResult['PAY_SYSTEM'] as $paysystem):
						
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && !in_array($paysystem['ID'],$arResult['OPLATA'])){continue;}
                            if($paysystem['CHECKED'] == 'Y')
                                $current_paysystem = $paysystem['ID']?>
                            <div class="label__block popover">
                                <label class="label--radio label--img">
                                    <input type="radio"
                                        <?= $paysystem['CHECKED'] == 'Y' ? 'checked="checked"' : '' ?>
                                           name="PAY_SYSTEM_ID"
                                           value="<?= $paysystem['ID'] ?>">
                                    <div class="label-inner">
                                        <? if($paysystem['PSA_LOGOTIP']['SRC']): ?>
                                            <em class="label-icon">
                                                <img src="<?= $paysystem['PSA_LOGOTIP']['SRC'] ?>"
                                                     alt="<?= $paysystem['NAME'] ?>">
                                            </em>
                                        <? endif ?>
                                        <div><span><?= $paysystem['NAME'] ?></span></div>
                                    </div>
                                </label>
                                <? if($paysystem['DESCRIPTION']): ?>
                                    <span class="label-help"><span class="icon-help-with-circle"></span></span>
                                    <div class="popover-box">
                                        <a href="#" class="popover-close"><i class="icon-close"></i></a>
                                        <?= $paysystem['DESCRIPTION'] ?>
                                    </div>
                                <? endif ?>
                            </div>
                        <? endforeach; ?>
						
                    </div>
                </div>
            </div>
            <div class="js-order__result">
			
			<?if ($USER->GetID()=="11460" || $_REQUEST['test_pay']=="22"){
				if ($_REQUEST['ps']=="22"){
				$current_paysystem=22;
				}
				$kr=count($arResult['KORZINA']);
				$dop='';
				if($kr>1 && in_array($current_paysystem,[18,19,20,21,22])){$dop='<br>?????????????? ?????????? ?????????????????? ???? ?????????????????? ??????????????. ???????????? ?????????????? ???????????????????????? ??????????????????????????.';}
				?><h4>???????????? ???????????? <span style="font-size:0.7em;color:#ff0000;"><?=$dop?></span></h4>
				<input type="hidden" name="razdel" value="<?=$current_paysystem?>"><?
				if(in_array($current_paysystem,[18,19,20,21,22])){
					foreach($arResult['KORZINA'] as $sklad=>$tovarId){
						foreach($arResult['STORE_LIST_ALL'] as $s1=>$s2){
							if($s2['ID']==$sklad){?><h4>?????????? ???? ???????????? <?=$s2['NAME']?></h4><?}
						}
						
						?>
						<table class="table table__order-list">
							<thead>
							<tr>
								<th class="td__name">????????????????</th>
								<th class="td__price">????????</th>
								<th class="td__discount">????????????</th>
								<th class="td__price-discount">???????? ?? ???????????? ????????????</th>
								<th class="td__number">??????-????</th>
								<th class="td__sum">??????????</th>
								<th class="td__sum">Online ????????????</th>
							</tr>
							</thead>
							<tbody>
							<? $items_count = 0;
							$hasUnavailable = false;
							foreach($arResult['BASKET_ITEMS'] as $item):?>
								<?if(in_array($item['PRODUCT_ID'], $tovarId)){?>
								<tr>
									<td class="td__name">
										<em>????????????????</em>
										<div class="td__inner">
											<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
										</div>
									</td>
									<td class="td__price">
										<em>????????:</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__discount">
										<em>????????????</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__price-discount">
										<em>???????? ?? ???????????? ????????????</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__number">
										<em>??????-????:</em>
										<div class="td__inner">
											<span><?= $item['QUANTITY'] ?></span>
										</div>
									</td>
									<td class="td__sum">
										<em>??????????:</em>
										<div class="td__inner">
											<div class="td__sum--price">
												<span class="price"><?= $item['SUM'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__sum">
										<em>Online ????????????:</em>
										<div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
												'<div class="text-success">????</div>' :
												'<div class="text-warning">??????</div>'?></div>
									</td>
								</tr>
								<?}?>
								<? $items_count += $item['QUANTITY'];
									if(!$hasUnavailable && $item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY']){
										$hasUnavailable = true;
									}
							endforeach ?>
							</tbody>
						</table>
						<?
					}
				}else{
					?>
					<table class="table table__order-list">
						<thead>
						<tr>
							<th class="td__name">????????????????</th>
							<th class="td__price">????????</th>
							<th class="td__discount">????????????</th>
							<th class="td__price-discount">???????? ?? ???????????? ????????????</th>
							<th class="td__number">??????-????</th>
							<th class="td__sum">??????????</th>
							<th class="td__sum">Online ????????????</th>
						</tr>
						</thead>
						<tbody>
						<? $items_count = 0;
						$hasUnavailable = false;
						foreach($arResult['BASKET_ITEMS'] as $item):?>
							<tr>
								<td class="td__name">
									<em>????????????????</em>
									<div class="td__inner">
										<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
									</div>
								</td>
								<td class="td__price">
									<em>????????:</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__discount">
									<em>????????????</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__price-discount">
									<em>???????? ?? ???????????? ????????????</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__number">
									<em>??????-????:</em>
									<div class="td__inner">
										<span><?= $item['QUANTITY'] ?></span>
									</div>
								</td>
								<td class="td__sum">
									<em>??????????:</em>
									<div class="td__inner">
										<div class="td__sum--price">
											<span class="price"><?= $item['SUM'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__sum">
									<em>Online ????????????:</em>
									<div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
											'<div class="text-success">????</div>' :
											'<div class="text-warning">??????</div>'?></div>
								</td>
							</tr>
							<? $items_count += $item['QUANTITY'];
								if(!$hasUnavailable && $item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY']){
									$hasUnavailable = true;
								}
						endforeach ?>
						</tbody>
					</table>
					<?
				}
			}else{?>
			
                <h4>???????????? ????????????</h4>
                <table class="table table__order-list">
                    <thead>
                    <tr>
                        <th class="td__name">????????????????</th>
                        <th class="td__price">????????</th>
                        <th class="td__discount">????????????</th>
                        <th class="td__price-discount">???????? ?? ???????????? ????????????</th>
                        <th class="td__number">??????-????</th>
                        <th class="td__sum">??????????</th>
                        <th class="td__sum">Online ????????????</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $items_count = 0;
                    $hasUnavailable = false;
                    foreach($arResult['BASKET_ITEMS'] as $item):?>
                        <tr>
                            <td class="td__name">
                                <em>????????????????</em>
                                <div class="td__inner">
                                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
                                </div>
                            </td>
                            <td class="td__price">
                                <em>????????:</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__discount">
                                <em>????????????</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__price-discount">
                                <em>???????? ?? ???????????? ????????????</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__number">
                                <em>??????-????:</em>
                                <div class="td__inner">
                                    <span><?= $item['QUANTITY'] ?></span>
                                </div>
                            </td>
                            <td class="td__sum">
                                <em>??????????:</em>
                                <div class="td__inner">
                                    <div class="td__sum--price">
                                        <span class="price"><?= $item['SUM'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__sum">
                                <em>Online ????????????:</em>
                                <div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
                                        '<div class="text-success">????</div>' :
                                        '<div class="text-warning">??????</div>'?></div>
                            </td>
                        </tr>
                        <? $items_count += $item['QUANTITY'];
                            if(!$hasUnavailable && $item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY']){
                                $hasUnavailable = true;
                            }
                    endforeach ?>
                    </tbody>
                </table>
				
			<?}?>
				
                <?if($hasUnavailable):?>
                <div class="alert alert-warning js-unavailable" <?if($current_paysystem !== '3'){?>style="display: none"<?}?>><?=GetMessage('SOA_HAS_ONLINE_UNAVAILABLE')?></div>
                <?endif?>
                <div class="text-right">
                    <div class="table__total--wrap">
                        <table class="table table__total">
                            <tbody>
                            <tr class="order__sum">
                                <td>???????? ?????? ????????????</td>
                                <td><?= $arResult['PRICE_WITHOUT_DISCOUNT'] ?></td>
                            </tr><? if($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'] > 0): ?>
                                <tr class="order__discount">
                                <td>????????????</td>
                                <td><?= number_format($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'], 2, '.', ' ') . ' ??????' ?></td>
                                </tr><? endif ?>
                            <tr class="order__delivery">
                                <td>????????????????</td>
                                <td id="order_delivery"><?= $arResult['DELIVERY_PRICE_FORMATED'] ?></td>
                            </tr>
                            <tr class="order__total">
                                <td>??????????</td>
                                <td id="order_price"><?= $arResult['ORDER_TOTAL_PRICE_FORMATED'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="error-msg error-msg-agree"><div class="alert alert-danger">???????? "???????????????? ???? ?????????????????? ???????????????????????? ????????????" ?????????????????????? ?????? ????????????????????</div></div>
                    <div class="form__group form__group_basket form_agree">
                        <label class="label--checkbox">
                            <input type="checkbox" name="form_text_28" value="1" required checked="checked">
                            <p class="form__group_basket">?????????????????????? ???????????????? ???? ?????????????????? <a href="/information/politika-konfidentsialnosti.php">???????????????????????? ????????????</a>
                                                        <span class="req">*</span></p>
                        </label>
                    </div>
					<?if(1==2){
			?><noindex><strong>???????????????? ???????????????????? ???????????? ?? ????????????????-???????????????? ????????????????????.</strong></noindex><?			
		}else{?>
                    <div class="order__btn">
                        <a href="#" class="btn btn-primary js-btn-checkout">???????????????? ??????????</a>
                    </div>
		<?}?>
                </div>
            </div>

            <? if($_REQUEST['is_ajax_post'] == 'Y') die(); ?>
        </form>

        <div style="display:none">
            <div id="order_total_price"><?=$arResult['ORDER_TOTAL_PRICE']?></div>
        </div>

        <?
    }
}?><p>

</p>