<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//if($arResult['ONLY_SKLAD']=='N'){return false;}
if( ($arResult['OPLATA_BANK']==17  && $arResult['PS_ONLY']=='N') || ($arResult['OPLATA_BANK']==3  && $arResult['PS_ONLY']=='Y') ){
		//return false;	
}
?><style>.nosee {display:none;}</style><?

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/autocomplete.js');
$APPLICATION->AddHeadString('<script type="text/javascript" src="https://widget.cdek.ru/widget/widjet.js" id="ISDEKscript" ></script>');
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

<style>
.form__horizontal.form__order .label-inner{line-height:30px;}
.form__horizontal.form__order .label--radio.label--img{ border: 1px solid #21385E; line-height: 14px;}
.form__horizontal.form__order .label--img .iradio{margin-top:10px}
.iradio:before{background: #c4c4c4;width:7px;height:7px;content: "";position: absolute;border-radius: 50%; top: 4px; left: 4px;}
.iradio.checked:before{background: #EA5B35;width:7px;height:7px;}
.icheckbox, .iradio {border:none;}
.block_oformlenie--delivery2 .iradio:before{background:transparent;}
.form__horizontal.form__order .block_oformlenie--delivery2 .label--radio.label--img{border: none;}
.block_oformlenie--delivery2 .iradio {display:none;}
.form__horizontal.form__order .label--radio {padding-right:0;}
.form__horizontal.form__order .label-inner .label-icon{margin-right:0;width: 100%;}

.block_oformlenie--paysystem1 .iradio:before{background:transparent;}
.form__horizontal.form__order .block_oformlenie--paysystem1 .label--radio.label--img{border: none;}
.block_oformlenie--paysystem1 .iradio {display:none;}


.form__horizontal.form__order .kolonka-2 .iradio {display:none;}
.form__horizontal.form__order .kolonka-2 .label--radio.label--img{border: none;}
/* .form__horizontal.form__order .kolonka-3 .iradio {display:none;}
.form__horizontal.form__order .kolonka-3 .label--radio.label--img{border: none;} */
/* .form__horizontal .kolonka-4 .popover-box{border: 1px solid #C4C4C4;} */
.form__horizontal .kolonka-4 .popover-box{    border: none;    box-shadow: none; padding-left: 0;}
.form__horizontal .kolonka-4 .popover-box span.opisanie{color:#5C5C5C;font-size: 14px;} 
.form__horizontal .kolonka-4 .bx_result_price .btn{color: #032A5F; font-size: 0.8em; border-radius: 0; margin-top: 10px; background-color: #fff; text-transform: none; border: 1px solid #032A5F;}
.classdel34 .popover-close {display:none;}
.classdel31 .selectric-items {border: 1px solid #C4C4C4;}
.classdel31 .selectric-items li{    line-height: 34px;   padding: 0px 10px;}
.form__horizontal.form__order .label-inner .label-icon {height: 52px;    line-height: 48px;}
.form__horizontal.form__order .checked+.label-inner .label-icon{border-color:#21385E;border-width: 1px;}
.form__horizontal.form__order .label-inner .label-icon img{max-height: 48px;}
.form__horizontal.form__order .label--radio{padding-bottom: 8px;}
.form__horizontal.form__order .form__input{width:100%;}
table#tPP {
    display: none !important;
}
/* .form__horizontal.form__order label{display:none;} */
.form__horizontal.form__order input{border-width: 0 0 1px 0;    border-color: #C4C4C4;}
.form__horizontal.form__order textarea{border-width: 1px;    border-color: #C4C4C4;}
.form__horizontal.form__order .form__order--left::after{display:none;}
.form__horizontal.form__order .form__order--left label, .form__horizontal.form__order .form__order--right label, .form__horizontal.form__order .dopolnitelinayainfo label{
	color: #b1bbc4;
	font-size: 0.8em;
	font-weight: normal;
	position: absolute;
	pointer-events: none;
	left: 5px;
	top: 10px;
	transition: 0.1s ease all;
	-moz-transition: 0.1s ease all;
	-webkit-transition: 0.1s ease all;
	z-index: 1;
text-align: left;
width: 100%;
}
.form__horizontal.form__order .form__input input:focus~label,
.form__horizontal.form__order .form__input input[value]:not([value=""])~label,
.form__horizontal.form__order .form__input textarea:focus~label,
.form__horizontal.form__order .form__input textarea[value]:not([value=""])~label {
	top: -25px;
	font-size: 14px;
	color: #402e26;
	font-weight: 500;
	display:none;
}
.bx_result_price{
    text-align: center;
}
.form__horizontal.form__order .label-inner>div>span{color:#032A5F;font-size:14px;}
.form__horizontal.form__order .label--radio.no-border{border:none;}
.form__horizontal.form__order .label--radio.no-border span{color:#5C5C5C;}
.form__horizontal.form__order .label--radio.no-check{border:1px solid #e5e5e5;}

.popover{z-index:1;}
@media (min-width: 768px) {
	.form__horizontal .kolonka-2 .popover{padding-left:0.25rem;padding-right:0.25rem;}
	.form__horizontal .kolonka-2 .popover:first-child{padding-left:15px;}
	.form__horizontal .kolonka-2 .popover:last-child{padding-right:15px;}
}
.CDEK-widget__popup-mask{z-index:1;}
.C_TO_HOME{display:none;}
.C_TO_PUNKT{display:block;}

</style>
				<div class="row delivery-pay">
					<?
					$oneblock='N';
					foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
						if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}    
						//if(!in_array($arDelivery['ID'], [1,2,32])){continue;}
						if(!in_array($arDelivery['ID'], [2])){continue;}
						$oneblock='Y';
					}
					?>
					<?if($oneblock=='Y'){?>
						<div class="kolonka-1 col-12 col-md-6">
							<div class="form__group--title">
								Способы доставки
							</div>
							<div class="row form__group">
							<? $current_delivery = 0;
							foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
								if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}    
								
								if(!in_array($arDelivery['ID'], [1,2,32])){continue;}
								if(!in_array($arDelivery['ID'], [2])){continue;}
								
								if($arDelivery["CHECKED"] == "Y")
									$current_delivery = $arDelivery['ID'];
								?>
								
									<div class="col-6 label__block popover">
										<label class="label--radio label--img">
											<input data-price="<?=$arDelivery['PRICE']?>" data-ident="<?=$arDelivery['ID']?>" type="radio"
												   name="<?= htmlspecialcharsbx($arDelivery["FIELD_NAME"]) ?>"
												   value="<?= $delivery_id ?>"
												<?= $arDelivery["CHECKED"] == "Y" ? "checked=\"checked\"" : ""; ?>>
											<div class="label-inner">                                            
												<div><span><?= htmlspecialcharsbx($arDelivery["NAME"]) ?></span></div>
											</div>
										</label>
										
									</div>
								
							<?}?>
							</div>
							
						</div>
					<?}?>
					<div class="kolonka-2 col-12 col-md-6">
						<div class="form__group--title">
							<!-- Доставка по Московской области, России и СНГ: -->
							Способы доставки
						</div>
						<? 
						$countdelivery=0;
						foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}  
							if(in_array($arDelivery['ID'], [2])){continue;}
							$countdelivery++;
						}?>
						<div class="row form__group row-cols-<?=ceil($countdelivery/2)?> row-cols-md-<?=$countdelivery?>">
                        <? 						
						$current_delivery = 0;
						foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}    
							
							//if(in_array($arDelivery['ID'], [1,2,32])){continue;}
							if(in_array($arDelivery['ID'], [2])){continue;}
							
							if($arDelivery["CHECKED"] == "Y")
								$current_delivery = $arDelivery['ID'];
							?>
                                <div class="col label__block popover">
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
                                            
                                        </div>
                                    </label>
                                    
                                </div>
                            
                        <?}?>
						</div>
					</div>
					<div class="kolonka-3 col-12 col-md-6 order-md-1 order-2">
						<div class="form__group--title">Способы оплаты</div>
						<?$countpay=0;
						foreach($arResult['PAY_SYSTEM'] as $paysystem){
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && !in_array($paysystem['ID'],$arResult['OPLATA'])){continue;}
							$countpay++;
						}?>
						<div class="row form__group">
							<?$current_paysystem = 0;
							$podmena_payname=[
								22=>'On-line картой',
								1=>'Наличными курьеру',
								11=>'Картой курьеру',
							];
							foreach($arResult['PAY_SYSTEM'] as $paysystem):
							
								if($arResult['RAZRESHIT_DOSTAVKI']=='N' && !in_array($paysystem['ID'],$arResult['OPLATA'])){continue;}
								if($paysystem['CHECKED'] == 'Y')
									$current_paysystem = $paysystem['ID']?>
								<?/* <div class="col-4 label__block popover">
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
								   
								</div> */?>
								<div class="col-<?=($countpay<3 ? 6:4)?> label__block popover">
										<label class="label--radio label--img <?= $paysystem['CHECKED'] != 'Y' ? 'no-border no-check' : '' ?>">
											<input type="radio" <?= $paysystem['CHECKED'] == 'Y' ? 'checked="checked"' : '' ?> name="PAY_SYSTEM_ID" value="<?= $paysystem['ID'] ?>">
											<div class="label-inner">                                            
												<div><span><?= (!empty($podmena_payname[$paysystem['ID']]) ? $podmena_payname[$paysystem['ID']]:htmlspecialcharsbx($paysystem["NAME"]) )?></span></div>
											</div>
										</label>
										
									</div>
							<? endforeach; ?>
							
						</div>
					</div>
					<div class="kolonka-4 col-12 col-md-6 order-md-2 order-1">
						<div class="form__group">
                        <? $current_delivery = 0;
						foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery){
							if($arResult['RAZRESHIT_DOSTAVKI']=='N' && $arDelivery['ID']!=2){continue;}    
							
							if(in_array($arDelivery['ID'], [1,2,32])){continue;}
							
							if($arDelivery["CHECKED"] == "Y")
								$current_delivery = $arDelivery['ID'];
							?>                               
                                    <? if($arDelivery['DESCRIPTION']): ?>
                                        
                                        <div class="popover-box classdel<?=$arDelivery['ID']?><?=($arDelivery['ID']=='34' && $arDelivery["CHECKED"] == "Y" ? ' popover-open':'')?>">
                                            <a href="#" class="popover-close"><i class="icon-close"></i></a>
                                            <?= $arDelivery['DESCRIPTION'] ?>
                                        </div>
                                    <? endif ?>  
									<? if($current_delivery == 31 && !empty($arResult['ORDER_PROP']['USER_PROPS_Y'][25])): ?>
									
										<div class="popover-box classdel<?=$arDelivery['ID']?><?=($arDelivery["CHECKED"] == "Y" ? ' popover-open':'')?>">
											<div class="form__group--title" style="margin-top:0;">Выберите пункт доставки</div>
											<div class="form__group" style="max-width: 230px;"><select name="<?= $arResult['ORDER_PROP']['USER_PROPS_Y'][25]['FIELD_NAME'] ?>" onchange="smenaKuda(this.value)">
												<? 
												$select_class='TO_HOME';//"TO_PUNKT" "TO_HOME"
												foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][25]["VARIANTS"] as $arVariants): ?>                                
													<option
													value="<?= $arVariants["VALUE"] ?>"<? if ($arVariants["SELECTED"] == "Y") echo " selected"; ?>><?= $arVariants["NAME"] ?></option>
												<?if($arVariants["SELECTED"] == "Y"){
													$select_class=$arVariants["VALUE"];
												}?>
												<? endforeach; ?>
											</select></div>
											
											<script type="text/javascript">
											console.log($('input[name="ORDER_PROP_6"]').val().split(/[,]+/)[0]);
											
											console.log(<?echo json_encode($arResult['ORDER_PROP']['USER_PROPS_Y'][25]["VARIANTS"])?>);
												var orderWidjet = new ISDEKWidjet({
													popup: true,
													country: 'Россия',
													defaultCity: $('input[name="ORDER_PROP_6"]').val().split(/[,]+/)[0],
													cityFrom: 'Москва',
													hidedress: true,
													hidecash: true,
													hidedelt: true,
													link: false,
													path: 'https://widget.cdek.ru/widget/scripts/',
													servicepath: 'https://www.kolchuga.ru/test/cdek/service.php', //ссылка на файл service.php на вашем сайте
													goods: [ // установим данные о товарах из корзины
														{ length : 10, width : 20, height : 20, weight : 5 }
													],
													onReady : function(){ // на загрузку виджета отобразим информацию о доставке до ПВЗ
														ipjq('#linkForWidjet').css('display','inline');
													},
													onChoose : function(info){ // при выборе ПВЗ: запишем номер ПВЗ в текстовое поле и доп. информацию
													console.log(info);
														//ipjq('[name="chosenPost"]').val(info.id);
														ipjq('[name="ORDER_PROP_7"]').val(info.cityName+', '+info.PVZ.Address +' ['+info.id+']');
														// расчет стоимости доставки
														//var price = (info.price < 500) ? 500 : Math.ceil( info.price/100 ) * 100;
														//ipjq('[name="pricePost"]').val(price);
														//ipjq('[name="timePost"]').val(info.term);
														orderWidjet.close(); // закроем виджет
													}
												});
												function smenaKuda(e){
													if(e=='TO_PUNKT'){
														$('.cdek_block').removeClass('C_TO_HOME').removeClass('C_TO_PUNKT');
														$('.cdek_block').addClass('C_TO_PUNKT');
													}else{
														$('.cdek_block').removeClass('C_TO_HOME').removeClass('C_TO_PUNKT');
														$('.cdek_block').addClass('C_TO_HOME');
													}
												}
											</script>
											<div class="bx_result_price cdek_block C_<?=$select_class?>" >
												<a class="btn btn-default" onclick='orderWidjet.open(); return false;' style="cursor:pointer;">Выбрать пункт доставки</a>
											</div>
											
										</div>
									<? endif ?>
                            
                        <?}?>
						
						</div>
					</div>
				</div>

            <div class="form__order--wrapper">
                <div class="form__order--left">
                    <div class="form__group--title">
                        Личные данные
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
									
									<div class="form__input">
										<input id="field_11_<?$prop['ID']?>"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="text"
											   value="<?= $prop['VALUE'] ?>" <?if($prop['REQUIRED']=='Y'){?>required<?}?>
											  >
									<label for="field_11_<?$prop['ID']?>"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
									</div>
								</div>
							<?}?>
                            <? unset($arResult['ORDER_PROP']['USER_PROPS_Y'][$key]);
                        endif;
                    endforeach; ?>
                    
                    
                </div>
                <div class="form__order--right">
                    <div class="form__group--title">
                        Данные для доставки
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
                            
                            <div class="form__input">
                                <? if($prop['IS_ADDRESS'] == 'Y'): ?>
                                    <textarea name="<?= $prop['FIELD_NAME'] ?>"
                                              type="text" <?if($prop['REQUIRED']=='Y'){?>required<?}?>><?= $prop['VALUE'] ?></textarea>
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
                                           value="<?= $prop['TEXT_VALUE'] ?>" <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
                                    <div class="form__result js-search-result-loc"></div>
                                    <?
                                else: ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="text"
                                           value="<?= $prop['VALUE'] ?>" <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
                                <? endif; ?>
							<label for="field_99"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
			<div class="row dopolnitelinayainfo">
			<div class="col-12 col-md-6">
					<div class="form__group--title mt-0">
                        Дополнительная информация
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
                            
                            <div class="form__input">
                                <? if($prop['IS_ADDRESS'] == 'Y'): ?>
                                    <textarea name="<?= $prop['FIELD_NAME'] ?>"
                                              type="text" <?if($prop['REQUIRED']=='Y'){?>required<?}?>><?= $prop['VALUE'] ?></textarea>
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
                                           value="<?= $prop['TEXT_VALUE'] ?>"
										   <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
                                    <div class="form__result js-search-result-loc"></div>
                                    <?
                                else: ?>
                                    <input name="<?= $prop['FIELD_NAME'] ?>"
                                           type="text"
                                           value="<?= $prop['VALUE'] ?>"
										   <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
                                <? endif; ?>
								<label for="field_99"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form__group">
                        
                        <div class="form__input">
                            <textarea id="field_88"
                                      name="ORDER_DESCRIPTION"
                                      rows="6"
                                      cols="40"><?= $arResult['ORDER_DATA']['ORDER_DESCRIPTION'] ?></textarea>
									  <label for="field_88">Комментарий</label>
                        </div>
                    </div>

                    <div class="form__group c_pay_cash">
                        <label for="field_23" class="label_ORDER_PROP_23">Пожалуйста, укажите сумму, с которой Вам потребуется сдача</label>
                        <div class="form__input">
                            <input name="ORDER_PROP_23" type="text" value="">
                        </div>
                    </div>
			</div>
			</div>
            <div class="js-order__result">
			
			
				<?
				if ($_REQUEST['ps']=="22"){ $current_paysystem=22; }
				$kr=count($arResult['KORZINA']);
				$dop='';
				if($kr>1 && in_array($current_paysystem,[18,19,20,21,22,23,1,11])){$dop='Внимание!!! Корзина будет разделена на несколько заказов. Оплата каждого производится <span style="font-size:1.2em;">отдельно</span>.';}
				?><h4>Состав заказа <span style="font-size:1.1em;color:#EA5B35;display: block;<?=(!empty($dop) ? 'background-color: #f3f3f3; padding: 10px;  border-left: 2px solid #ea5b35;':'')?>"><?=$dop?></span></h4>
				<input type="hidden" name="razdel" value="<?=$current_paysystem?>">
				<?if($current_paysystem>0){?>
				<?include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/item.php");?>
				<?}else{?>
					<span style="font-size:0.7em;color:#EA5B35;display: block;background-color: #f3f3f3; padding: 10px;  border-left: 2px solid #ea5b35">
					Приносим наши извинения, но у вас в корзине находится товар, который на текущий момент в указанный вами город не доставляется. Пожалуйста измените адрес доставки или состав корзины для дальнейшего оформления заказа.<br>Спасибо за понимание.
					</span>
				<?}?>
				<div class="alert alert-warning showerrortext">Заполните все обязательные поля</div>
			
			
			
			
			
				
                <?if($hasUnavailable):?>
                <div class="alert alert-warning js-unavailable" <?if($current_paysystem !== '3'){?>style="display: none"<?}?>><?=GetMessage('SOA_HAS_ONLINE_UNAVAILABLE')?></div>
                <?endif?>
                
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