<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


if (in_array($USER->GetID(),array(1146011460,10303, 1126211262)) || $_GET['nnn']==1 ){//10303
include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/new_template.php");

}else{

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
						//\Kolchuga\Settings::xmp($arResult['ORDER_PROP']['USER_PROPS_Y'],11460, __FILE__.": ".__LINE__);
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
							<?}elseif($prop['IS_EMAIL'] == 'Y'){?>							
								<div class="form__group">
									<label for="field_11"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
									<div class="form__input">
										<input id="field_11"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="email"
											   value="<?= $prop['VALUE'] ?>" <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
									</div>
								</div>
							
							<?}else{?>							
								<div class="form__group">
									<label for="field_11"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
									<div class="form__input">
										<input id="field_11"
											   name="<?= $prop['FIELD_NAME'] ?>"
											   type="text"
											   value="<?= $prop['VALUE'] ?>" <?if($prop['REQUIRED']=='Y'){?>required<?}?>>
									</div>
								</div>
							<?}?>
                            <? unset($arResult['ORDER_PROP']['USER_PROPS_Y'][$key]);
                        endif;
                    endforeach; ?>
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
                            <label for="field_99"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
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
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form__group--title">
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
                            <label for="field_99"><?= $prop['NAME'] ?><?if($prop['REQUIRED']=='Y'){?><span class="req">*</span><?}?></label>
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
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form__group">
                        <label for="field_88">Комментарий</label>
                        <div class="form__input">
                            <textarea id="field_88"
                                      name="ORDER_DESCRIPTION"
                                      rows="6"
                                      cols="40"><?= $arResult['ORDER_DATA']['ORDER_DESCRIPTION'] ?></textarea>
                        </div>
                    </div>

                    <div class="form__group c_pay_cash">
                        <label for="field_23" class="label_ORDER_PROP_23">Пожалуйста, укажите сумму, с которой Вам потребуется сдача</label>
                        <div class="form__input">
                            <input name="ORDER_PROP_23" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="form__order--right">
                    <div class="form__group--title">
                        Способы доставки
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
                        <div class="form__group--title">Выберите пункт самовывоза</div>
                        <div class="form__group"><select name="<?= $stores_prop['FIELD_NAME'] ?>">
                                <? foreach($arResult['STORE_LIST'] as $store): ?>                                
                                    <option value="<?= $store['NAME'] ?>"<?= $stores_prop['VALUE'] == $store['NAME'] ? ' selected="selected"' : '' ?>><?=
                                        $store['NAME']
                                        ?></option>
                                <? endforeach; ?>
                            </select></div>
                    <? endif ?>
					<? if($current_delivery == 31 && !empty($arResult['ORDER_PROP']['USER_PROPS_Y'][25])): ?>
                        <div class="form__group--title">Выберите пункт доставки</div>
                        <div class="form__group"><select name="<?= $arResult['ORDER_PROP']['USER_PROPS_Y'][25]['FIELD_NAME'] ?>" onchange="smenaKuda(this.value)">
                                <? 
								$select_class='TO_HOME';
								foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][25]["VARIANTS"] as $arVariants): ?>                                
                                    <option
                                    value="<?= $arVariants["VALUE"] ?>"<? if ($arVariants["SELECTED"] == "Y") echo " selected"; ?>><?= $arVariants["NAME"] ?></option>
									<?if($arVariants["SELECTED"] == "Y"){$select_class=$arVariants["VALUE"];}?>
                                <? endforeach; ?>
                            </select></div>
							<script type="text/javascript">
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
							</script>
							<div class="bx_result_price cdek_block C_<?=$select_class?>" >
												<a class="btn btn-default" onclick='orderWidjet.open(); return false;' style="cursor:pointer;">Выбрать пункт доставки</a>
											</div>
                    <? endif ?>
                    <div class="form__group--title">Способы оплаты</div>
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
				<div class="form__group" >
					<div class="label__block ">
                                <label class="label--radio">
                                    <input type="checkbox" name="soglasiecheck" id="soglasiecheck" required='required' value="Yes" class="no_check0" checked="checked" disabled>
                                    <div><span>Заполняя эту форму, я даю свое согласие на обработку персональных данных</span></div>                                    
                                 </label>                              
                            </div>
                            <input type="hidden" name="ORDER_PROP_34" value="Yes" >
				
				</div>
            <div class="js-order__result">
			
			<?//if ($_REQUEST['test_pay']=="2222"){?>
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
			<?//}?>
			<?/* <span style="font-size:1.2em;color:#EA5B35;display: block;background-color: #f3f3f3; padding: 10px;  border-left: 2px solid #ea5b35">
					Салоны «Кольчуга» открыты <br>Интернет-магазин сегодня не работает<br>Спасибо за понимание.
					</span> */?>
			
			
			<?/*if ($USER->GetID()=="11460" || $_REQUEST['test_pay']=="22"){
				if ($_REQUEST['ps']=="22"){
				$current_paysystem=22;
				}
				$kr=count($arResult['KORZINA']);
				$dop='';
				if($kr>1 && in_array($current_paysystem,[18,19,20,21,22])){$dop='<br>Корзина будет разделена на несколько заказов. Оплата каждого производится индивидуально.';}
				?><h4>Состав заказа <span style="font-size:0.7em;color:#ff0000;"><?=$dop?></span></h4>
				<input type="hidden" name="razdel" value="<?=$current_paysystem?>"><?
				if(in_array($current_paysystem,[18,19,20,21,22])){
					foreach($arResult['KORZINA'] as $sklad=>$tovarId){
						foreach($arResult['STORE_LIST_ALL'] as $s1=>$s2){
							if($s2['ID']==$sklad){?><h4>Заказ со склада <?=$s2['NAME']?></h4><?}
						}
						
						?>
						<table class="table table__order-list">
							<thead>
							<tr>
								<th class="td__name">Название</th>
								<th class="td__price">Цена</th>
								<th class="td__discount">Скидка</th>
								<th class="td__price-discount">Цена с учетом скидки</th>
								<th class="td__number">Кол-во</th>
								<th class="td__sum">Сумма</th>
								<th class="td__sum">Online оплата</th>
							</tr>
							</thead>
							<tbody>
							<? $items_count = 0;
							$hasUnavailable = false;
							foreach($arResult['BASKET_ITEMS'] as $item):?>
								<?if(in_array($item['PRODUCT_ID'], $tovarId)){?>
								<tr>
									<td class="td__name">
										<em>Название</em>
										<div class="td__inner">
											<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
										</div>
									</td>
									<td class="td__price">
										<em>Цена:</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__discount">
										<em>Скидка</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__price-discount">
										<em>Цена с учетом скидки</em>
										<div class="td__inner">
											<div class="price__block">
												<span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__number">
										<em>Кол-во:</em>
										<div class="td__inner">
											<span><?= $item['QUANTITY'] ?></span>
										</div>
									</td>
									<td class="td__sum">
										<em>Сумма:</em>
										<div class="td__inner">
											<div class="td__sum--price">
												<span class="price"><?= $item['SUM'] ?></span>
											</div>
										</div>
									</td>
									<td class="td__sum">
										<em>Online оплата:</em>
										<div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
												'<div class="text-success">Да</div>' :
												'<div class="text-warning">Нет</div>'?></div>
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
							<th class="td__name">Название</th>
							<th class="td__price">Цена</th>
							<th class="td__discount">Скидка</th>
							<th class="td__price-discount">Цена с учетом скидки</th>
							<th class="td__number">Кол-во</th>
							<th class="td__sum">Сумма</th>
							<th class="td__sum">Online оплата</th>
						</tr>
						</thead>
						<tbody>
						<? $items_count = 0;
						$hasUnavailable = false;
						foreach($arResult['BASKET_ITEMS'] as $item):?>
							<tr>
								<td class="td__name">
									<em>Название</em>
									<div class="td__inner">
										<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
									</div>
								</td>
								<td class="td__price">
									<em>Цена:</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__discount">
									<em>Скидка</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__price-discount">
									<em>Цена с учетом скидки</em>
									<div class="td__inner">
										<div class="price__block">
											<span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__number">
									<em>Кол-во:</em>
									<div class="td__inner">
										<span><?= $item['QUANTITY'] ?></span>
									</div>
								</td>
								<td class="td__sum">
									<em>Сумма:</em>
									<div class="td__inner">
										<div class="td__sum--price">
											<span class="price"><?= $item['SUM'] ?></span>
										</div>
									</div>
								</td>
								<td class="td__sum">
									<em>Online оплата:</em>
									<div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
											'<div class="text-success">Да</div>' :
											'<div class="text-warning">Нет</div>'?></div>
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
			/*}else{?>
			
                <h4>Состав заказа</h4>
                <table class="table table__order-list">
                    <thead>
                    <tr>
                        <th class="td__name">Название</th>
                        <th class="td__price">Цена</th>
                        <th class="td__discount">Скидка</th>
                        <th class="td__price-discount">Цена с учетом скидки</th>
                        <th class="td__number">Кол-во</th>
                        <th class="td__sum">Сумма</th>
                        <th class="td__sum">Online оплата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $items_count = 0;
                    $hasUnavailable = false;
                    foreach($arResult['BASKET_ITEMS'] as $item):?>
                        <tr>
                            <td class="td__name">
                                <em>Название</em>
                                <div class="td__inner">
                                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['~NAME'] ?></a>
                                </div>
                            </td>
                            <td class="td__price">
                                <em>Цена:</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['BASE_PRICE_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__discount">
                                <em>Скидка</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="discount"><?= $item['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__price-discount">
                                <em>Цена с учетом скидки</em>
                                <div class="td__inner">
                                    <div class="price__block">
                                        <span class="price"><?= $item['~PRICE_FORMATED'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__number">
                                <em>Кол-во:</em>
                                <div class="td__inner">
                                    <span><?= $item['QUANTITY'] ?></span>
                                </div>
                            </td>
                            <td class="td__sum">
                                <em>Сумма:</em>
                                <div class="td__inner">
                                    <div class="td__sum--price">
                                        <span class="price"><?= $item['SUM'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="td__sum">
                                <em>Online оплата:</em>
                                <div class="td__inner"><?=$item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY'] == 'true' ?
                                        '<div class="text-success">Да</div>' :
                                        '<div class="text-warning">Нет</div>'?></div>
                            </td>
                        </tr>
                        <? $items_count += $item['QUANTITY'];
                            if(!$hasUnavailable && $item['DOSTUPEN_DLYA_ELEKTRONNOY_OPLATY']){
                                $hasUnavailable = true;
                            }
                    endforeach ?>
                    </tbody>
                </table>
				
			<?}*/?>
				
                <?if($hasUnavailable):?>
                <div class="alert alert-warning js-unavailable" <?if($current_paysystem !== '3'){?>style="display: none"<?}?>><?=GetMessage('SOA_HAS_ONLINE_UNAVAILABLE')?></div>
                <?endif?>
                <?/*<div class="text-right">
                    <div class="table__total--wrap">
                        <table class="table table__total">
                            <tbody>
                            <tr class="order__sum">
                                <td>Цена без скидки</td>
                                <td><?= $arResult['PRICE_WITHOUT_DISCOUNT'] ?></td>
                            </tr><? if($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'] > 0): ?>
                                <tr class="order__discount">
                                <td>Скидка</td>
                                <td><?= number_format($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'], 2, '.', ' ') . ' руб' ?></td>
                                </tr><? endif ?>
                            <tr class="order__delivery">
                                <td>Доставка</td>
                                <td id="order_delivery"><?= $arResult['DELIVERY_PRICE_FORMATED'] ?></td>
                            </tr>
                            <tr class="order__total">
                                <td>Итого</td>
                                <td id="order_price"><?= $arResult['ORDER_TOTAL_PRICE_FORMATED'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="error-msg error-msg-agree"><div class="alert alert-danger">Поле "Согласие на обработку персональных данных" обязательно для заполнения</div></div>
                    <div class="form__group form__group_basket form_agree">
                        <label class="label--checkbox">
                            <input type="checkbox" name="form_text_28" value="1" required checked="checked">
                            <p class="form__group_basket">Подтверждаю согласие на обработку <a href="/information/politika-konfidentsialnosti.php">персональных данных</a>
                                                        <span class="req">*</span></p>
                        </label>
                    </div>
					<?if(1==2){
			?><noindex><strong>Временно оформление заказа в интернет-магазине недоступно.</strong></noindex><?			
		}else{?>
                    <div class="order__btn">
                        <a href="#" class="btn btn-primary js-btn-checkout">Оформить заказ</a>
                    </div>
		<?}?>
                </div>*/?>
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
<?}?>