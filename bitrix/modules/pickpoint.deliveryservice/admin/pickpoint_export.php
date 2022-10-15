<?
use \PickPoint\DeliveryService\Option;

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/include.php';
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/pickpoint.deliveryservice/constants.php';
$iModuleID = 'pickpoint.deliveryservice';
$ST_RIGHT = $APPLICATION->GetGroupRight($iModuleID);

if ($ST_RIGHT == 'D') {
    $APPLICATION->AuthForm(GetMessage('ACCESS_DENIED'));
}
IncludeModuleLangFile(__FILE__);
$message = null;

// Check required options
$isRequiredOptionsSet = Option::isRequiredOptionsSet();
if (!$isRequiredOptionsSet)
{
	$optionsNotSetMessage = new CAdminMessage([
		'MESSAGE' => GetMessage("PP_MODULE_OPTIONS_NOT_SET"), 
		'TYPE' => 'ERROR', 
		'DETAILS' => GetMessage("PP_MODULE_OPTIONS_NOT_SET_TEXT"), 
		'HTML' => true
		]);
	echo $optionsNotSetMessage->Show();
}	

// обработка отправки в PickPoint
if (!empty($_REQUEST['updateStatus']) || !empty($_REQUEST['CANCEL']) || !empty($_REQUEST['EXPORT']) || !empty($_REQUEST['save']) || !empty($_REQUEST['show']) || !empty($_REQUEST['ARCHIVE']) || !empty($_REQUEST['FROMARCHIVE'])) {
    try {

        if (!empty($_REQUEST['show'])) {
            \PickPoint\Helper::setPageElementsCount($_REQUEST['show']);
            LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG);
        }

        $ppRequest = new \PickPoint\Request(
            $arServiceTypesCodes,
            $arOptionDefaults,
            $arEnclosingTypesCodes
        );
        $status = true;

        //  Обработка обновления статусов
        if (!empty($_REQUEST['updateStatus'])) {
            if ($_REQUEST['updateStatus'] == 'Y') {
                $ppRequest->updateAllInvoicesStatus();
                LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG.'&mess=update');
            }
        }

        //  Изменение статуса архива
        if (!empty($_REQUEST['ARCHIVE'])) {
            foreach ($_REQUEST['ARCHIVE'] as $orderId => $ppNumber) {
                $ppRequest->changeArchiveStatus($orderId);
            }

            LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG.'&mess=archive');
        }
		
		// Back from achive
		if (!empty($_REQUEST['FROMARCHIVE'])) {
            foreach ($_REQUEST['FROMARCHIVE'] as $orderId => $ppNumber) {
                $ppRequest->changeArchiveStatus($orderId);
            }

            LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG.'&mess=fromarchive');
        }		

        //  Обработка отмени заказов
        if (!empty($_REQUEST['CANCEL'])) {
            foreach ($_REQUEST['CANCEL'] as $orderId => $ppNumber) {
                $answer = $ppRequest->cancelInvoice(key($ppNumber), $orderId);
                if  (!$answer['STATUS']){
                    CAdminMessage::ShowMessage(array('MESSAGE' => $orderId . ' -> ' . $answer['TEXT'], 'TYPE' => 'ERROR'));
                    $status = false;
                }
            }

            if ($status){
                LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG.'&mess=delete');
            }
        }

        // Обработка отправки заказов в PickPoint
        if (!empty($_REQUEST['EXPORT']) && ($_REQUEST['export'])) {
            $bError = false;
            $arExportIDs = array();

            foreach ($_REQUEST['EXPORT'] as $iOrderID => $arFields) {
                if ($arFields['EXPORT']) {
                    $obOrder = CSaleOrder::GetList(
                        array(),
                        array('ID' => $iOrderID),
                        false,
                        false,
                        array('ID', 'PRICE', 'PAY_SYSTEM_ID', 'PERSON_TYPE_ID')
                    );
                    if ($arOrder = $obOrder->Fetch()) {
                        $arExportIDs[] = $arOrder['ID'];
                    } else {
                        $APPLICATION->ThrowException(GetMessage('NO_ORDER', array('#ORDER_ID#' => $iOrderID)));
                        break;
                    }
                }
            }

            $answer = $ppRequest->sendInvoice($arExportIDs); // отправка заказов в PickPoint

            foreach ($answer as $orderIdAnswer => $orderItemAnswer) {
                if  (!$orderItemAnswer['STATUS']) {
                    $bError = true;
                    foreach ($orderItemAnswer['ERRORS'] as $error) {
                        CAdminMessage::ShowMessage([
                            'MESSAGE' => GetMessage('PP_ERROR_IN_ORDER') . $orderIdAnswer . ' : ' . $error,
                            'TYPE' => 'ERROR'
                        ]);
                    }
                } else {
                    CAdminMessage::ShowMessage([
                        'MESSAGE' => GetMessage('PP_ORDER_WITH_NUMBER') . $orderIdAnswer . GetMessage('PP_ORDER_WITH_NUMBER_IS_SUCCESS'),
                        'TYPE' => 'OK'
                    ]);
                }
            }

            if (!$bError) {
                LocalRedirect('/bitrix/admin/pickpoint_export.php?lang=' . LANG . '&mess=ok');
            }
        } elseif ($_REQUEST['save']) {
            foreach ($_REQUEST['EXPORT'] as $iOrderID => $arFields) {
                CPickpoint::SaveOrderOptions($iOrderID);
            }
            LocalRedirect('/bitrix/admin/pickpoint_export.php?lang='.LANG.'&mess=save');
        }

    } catch (Bitrix\Main\SystemException $exception){
        CAdminMessage::ShowMessage(array('MESSAGE' => $exception->getMessage(), 'TYPE' => 'ERROR'));
    }
}

// получение данних о заказах
try {
    $invoices = new \PickPoint\Invoices();
    $arItems = $invoices->getInvoicesArray();

} catch (Bitrix\Main\SystemException $exception){
    echo $exception->getMessage();
}

$arTabs = [];

$arTabs[] = [
    'DIV' => 'export',
    'TAB' => GetMessage('PP_EXPORT_NEW'),
    'TITLE' => GetMessage('PP_EXPORT_NEW'),
];
$arTabs[] = [
    'DIV' => 'forwarded',
    'TAB' => GetMessage('PP_EXPORT_FORWARDED'),
    'TITLE' => GetMessage('PP_EXPORT_FORWARDED'),
];
$arTabs[] = [
    'DIV' => 'revert',
    'TAB' => GetMessage('PP_EXPORT_REVERT'),
    'TITLE' => GetMessage('PP_EXPORT_REVERT'),
];
$arTabs[] = [
    'DIV' => 'ready',
    'TAB' => GetMessage('PP_EXPORT_READY'),
    'TITLE' => GetMessage('PP_EXPORT_READY'),
];
$arTabs[] = [
    'DIV' => 'canceled',
    'TAB' => GetMessage('PP_EXPORT_CANCELED'),
    'TITLE' => GetMessage('PP_EXPORT_CANCELED'),
];
$arTabs[] = [
    'DIV' => 'archive',
    'TAB' => GetMessage('PP_EXPORT_ARCHIVE'),
    'TITLE' => GetMessage('PP_EXPORT_ARCHIVE'),
];


$tabControl = new CAdminTabControl('tabControl', $arTabs);
?>
    <style>
        a.knopka {
            color: #fff; /* цвет текста */
            text-decoration: none; /* убирать подчёркивание у ссылок */
            user-select: none; /* убирать выделение текста */
            background: rgb(212,75,56); /* фон кнопки */
            padding: .6em 1.5em; /* отступ от текста */
            outline: none; /* убирать контур в Mozilla */
        }
        a.knopka:hover { background: rgb(232,95,76); } /* при наведении курсора мышки */
        a.knopka:active { background: rgb(152,15,0); } /* при нажатии */


        span.knopka {
            color: #000000; /* цвет текста */
            padding: .3em 1em; /* отступ от текста */
            border: 1px solid #0b011d;
            cursor: pointer;
            margin-top: 10px;
        }

        .show_div {
            float: left;
            font-size: 14px;
        }
        .show_div a{
            text-decoration: none;
        }
        .show_div span{
            font-weight: bold;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function SelectAll(cSelectAll) {
            bVal = (cSelectAll.checked);
            Table = document.getElementById("table_export");
            arInputs = Table.getElementsByClassName("cToExport");
            for (i = 0; i < arInputs.length; i++) {
                if (!arInputs[i].hasAttribute("disabled"))
                    arInputs[i].checked = bVal;
            }

        }
		
		function CheckFields(cSelectAll) {			
			var check = ['cToExport', 'cToCancel', 'cToArchive'];
			
			var tab = $('[name=find_form]').find('div.adm-detail-content:visible').attr('id');			
			if (tab == 'undefined')
				return false;
			
			var Table = $('#'+tab).find('#'+tab+"_edit_table");  					
			
			for (c = 0; c < check.length; c++)
			{
				var inputs = $(Table).find('input.'+check[c]);										
				if (inputs.length)
				{
					for (i = 0; i < inputs.length; i++) {						
						if ($(inputs[i]).prop('checked')) 
							return true;
					}					
				}
			}		
			
            return false;
        }
        function CheckServiceType(select, orderId) {
            price = document.getElementById("export_price_" + orderId);
            payedprice = document.getElementById("export_payed_price_" + orderId);
            if (select.value == 1 || select.value == 3) {
                payedprice.innerHTML = '<input type = "text" size = "8" name="EXPORT[' + orderId + '][PAYED]" value="' + price.value + '"/>';
            }
            else {
                payedprice.innerHTML = '<?=GetMessage('PP_NO')?>';
            }
        }
        function showAll(elements) {
            $('.id_' + elements).show();
            $('.button_' + elements).hide();
        }
    </script>

<?php if ($_REQUEST['mess'] == 'ok') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_NEW_INVOICE'), 'TYPE' => 'OK'));
}
if ($_REQUEST['mess'] == 'save') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_SAVE_SETTINGS'), 'TYPE' => 'OK'));
}
if ($_REQUEST['mess'] == 'update') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_UPDATED'), 'TYPE' => 'OK'));
}
if ($_REQUEST['mess'] == 'delete') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_DELETE'), 'TYPE' => 'OK'));
}
if ($_REQUEST['mess'] == 'archive') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_ARCHIVE'), 'TYPE' => 'OK'));
}
if ($_REQUEST['mess'] == 'fromarchive') {
    CAdminMessage::ShowMessage(array('MESSAGE' => GetMessage('PP_FROMARCHIVE'), 'TYPE' => 'OK'));
}
?>

    <form method="post" action="<?= $APPLICATION->GetCurPage() ?>" name="find_form">
        <?php
        if ($ex = $APPLICATION->GetException()) {
            CAdminMessage::ShowOldStyleError($ex->GetString());
        }
        if (strlen($_REQUEST['message']) > 0) {
            echo CAdminMessage::ShowNote($_REQUEST['message']);
        }
        $arServiceTypes = (unserialize(COption::GetOptionString($iModuleID, 'pp_service_types_all')));
        $arAllowedServiceTypes = unserialize(COption::GetOptionString($iModuleID, 'pp_service_types_selected'));
        $arEnclosingTypes = (unserialize(COption::GetOptionString($iModuleID, 'pp_enclosing_types_all')));
        $arAllowedEnclosingTypes = unserialize(COption::GetOptionString($iModuleID, 'pp_enclosing_types_selected'));

        $tabControl->Begin();
        $tabControl->BeginNextTab();?>

        <div style="text-align: center; height: 30px">
            <div class="show_div">
                <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
            </div>
            <?if ($isRequiredOptionsSet):?>			
				<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
					<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
				</a>
			<?endif;?>
        </div>
        <!--        tab1        -->
        <tr>
            <td>
                <table width="100%" class="edit-table" id="table_export">
                    <tr class="heading">
                        <td><input type="checkbox" id="cSelectAll" onclick="SelectAll(this)"/></td>
                        <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                        <td><?= GetMessage('PP_SUMM') ?></td>
                        <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                        <td><?= GetMessage('PP_ADDRESS') ?></td>
                        <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                        <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                        <td><?= GetMessage('PP_WIDTH') ?></td>
                        <td><?= GetMessage('PP_HEIGHT') ?></td>
                        <td><?= GetMessage('PP_DEPTH') ?></td>
                        <td><?= GetMessage('PP_ACTION_EDIT') ?></td>
                        <td><?= GetMessage('PP_ARCHIVE_ADD') ?></td>
                    </tr>
					<?php if (is_array($arItems['NEW']) && count($arItems['NEW'])):?>
						<?php foreach ($arItems['NEW'] as $key => $arItem) : ?>
							<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
							$bActive = $arItem['INVOICE_ID'] ? false : true;

							$arItem['PAYED'] = $arItem['PRICE'];
							$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

							if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
								$arItem['PAYED_PP_SET'] = 1;
							}
							?>
							<tr class="id_new" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
								<td><input <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
										type="checkbox" <?= ($arRequestItem['EXPORT']) ? 'checked' : '' ?> class="cToExport"
										name="EXPORT[<?= $arItem['ORDER_ID'] ?>][EXPORT]" autocomplete="off"/></td>
								<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
									<br/><?= $arItem['ORDER_DATE'] ?></td>
								<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
									<?php if ($bActive) : ?><input type="hidden"id="export_price_<?= $arItem['ORDER_ID'] ?>"
																   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
								<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
									<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
										<?= $arItem['PAYED'] ?>
									<?php else : ?>
										<?= GetMessage('PP_NO') ?>
									<?php endif; ?>
								</td>
								<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
								<td align="center">
									<?php if ($arItem['PAYED_BY_PP']) : ?>
										<?= $arServiceTypes[1] ?>
									<?php else : ?>
										<?= $arServiceTypes[0] ?>
									<?php endif ?>
								</td>
								<td align="center">
									<?php
									$encl_type = null;
									if ($arRequestItem['ENCLOSING_TYPE']) {
										$encl_type = $arRequestItem['ENCLOSING_TYPE'];
									} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
										$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
									}
									?>
									<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
										name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
									<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
										<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
											<option <?= $encl_type == $iKey ? 'selected' : '' ?>
												value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
									</select>
								</td>
								<td align="center"><?= number_format(floatval($arItem['WIDTH']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['HEIGHT']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['DEPTH']) , 2); ?></td>
								<td style="text-align: center">
									<?php if (!$arItem['CANCELED']) : ?>
										<a target="_blank" style="text-decoration: none" href="/bitrix/admin/pickpoint_edit.php?ORDER_ID=<?= $arItem['ORDER_ID'] ?>"><?= GetMessage('PP_EDIT_LINK') ?></a>
									<?php endif; ?>
								</td>
								<td align="center">
									<input type="checkbox" class="cToArchive"
										   name="ARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
										   autocomplete="off"/>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
                </table>
                <?php if (is_array($arItems['NEW']) && (count($arItems['NEW']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                    <div style="text-align: center; height: 30px">
                        <span class="knopka button_new" onclick="showAll('new')">
                            <?= GetMessage('PP_SHOW_MORE') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
            <?php $tabControl->BeginNextTab(); ?>
            <div style="text-align: center; height: 30px">
                <div class="show_div">
                    <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
                </div>
				<?if ($isRequiredOptionsSet):?>
					<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
						<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
					</a>
				<?endif;?>
            </div>            <!--        tab2        -->
            <tr>
                <td>
                    <table width="100%" class="edit-table" id="table_export">
                        <tr class="heading">
                            <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                            <td><?= GetMessage('PP_INVOICE_ID') ?></td>
                            <td><?= GetMessage('PP_STATUS') ?></td>
                            <td><?= GetMessage('PP_SUMM') ?></td>
                            <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                            <td><?= GetMessage('PP_ADDRESS') ?></td>
                            <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                            <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                            <td><?= GetMessage('PP_WIDTH') ?></td>
                            <td><?= GetMessage('PP_HEIGHT') ?></td>
                            <td><?= GetMessage('PP_DEPTH') ?></td>
                            <td><?= GetMessage('PP_ACTION_CANCEL') ?></td>
                            <td><?= GetMessage('PP_ACTION_EDIT') ?></td>
                            <td><?= GetMessage('PP_ARCHIVE_ADD') ?></td>
                        </tr>
						<?php if (is_array($arItems['FORWARDED']) && count($arItems['FORWARDED'])):?>
							<?php foreach ($arItems['FORWARDED'] as $key => $arItem) : ?>
								<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
								$bActive = $arItem['INVOICE_ID'] ? false : true;

								$arItem['PAYED'] = $arItem['PRICE'];
								$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

								if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
									$arItem['PAYED_PP_SET'] = 1;
								}
								?>
								<tr class="id_forward" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
									<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
										<br/><?= $arItem['ORDER_DATE'] ?></td>
									<td align="center"><?= $arItem['INVOICE_ID'] ? $arItem['INVOICE_ID'] : '' ?></td>
									<td align="center" style="font-weight: bold" title="<?= $statusTable[$arItem['STATUS']]['TEXT'] ?>"><?= $arItem['STATUS']; ?></td>
									<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
										<?php if ($bActive) : ?><input type="hidden"id="export_price_<?= $arItem['ORDER_ID'] ?>"
																	   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
									<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
										<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
											<?= $arItem['PAYED'] ?>
										<?php else : ?>
											<?= GetMessage('PP_NO') ?>
										<?php endif; ?>
									</td>
									<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
									<td align="center">
										<?php if ($arItem['PAYED_BY_PP']) : ?>
											<?= $arServiceTypes[1] ?>
										<?php else : ?>
											<?= $arServiceTypes[0] ?>
										<?php endif ?>
									</td>
									<td align="center">
										<?php
										$encl_type = null;
										if ($arRequestItem['ENCLOSING_TYPE']) {
											$encl_type = $arRequestItem['ENCLOSING_TYPE'];
										} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
											$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
										}
										?>
										<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
												name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
										<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
											<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
												<option <?= $encl_type == $iKey ? 'selected' : '' ?>
														value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
										</select>
									</td>
									<td align="center"><?= number_format(floatval($arItem['WIDTH']) , 2); ?></td>
									<td align="center"><?= number_format(floatval($arItem['HEIGHT']) , 2); ?></td>
									<td align="center"><?= number_format(floatval($arItem['DEPTH']) , 2); ?></td>
									<td style="text-align: center">
										<?php if ($arItem['CANCELED'] && $arItem['INVOICE_ID']) : ?>
											<span style="color: red;"><?= GetMessage('PP_CANCEL_SUCCESS') ?></span>
										<?php elseif($arItem['INVOICE_ID'] && !$arItem['CANCELED']): ?>
											<input type="checkbox" class="cToCancel"
												   name="CANCEL[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
												   autocomplete="off"/>
										<?php else: ?>
											<span style="color: green;"><?= GetMessage('PP_CANCEL_NOT_EXPORT') ?></span>
										<?php endif; ?>
									</td>
									<td style="text-align: center">
										<?php if (!$arItem['CANCELED']) : ?>
											<a target="_blank" style="text-decoration: none" href="/bitrix/admin/pickpoint_edit.php?ORDER_ID=<?= $arItem['ORDER_ID'] ?>"><?= GetMessage('PP_EDIT_LINK') ?></a>
										<?php endif; ?>
									</td>
									<td align="center">
										<input type="checkbox" class="cToArchive"
											   name="ARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
											   autocomplete="off"/>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
                    </table>
                    <?php if (is_array($arItems['FORWARDED']) && (count($arItems['FORWARDED']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                        <div style="text-align: center; height: 30px">
                            <span class="knopka button_forward" onclick="showAll('forward')">
                                <?= GetMessage('PP_SHOW_MORE') ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $tabControl->BeginNextTab(); ?>
            <div style="text-align: center; height: 30px">
                <div class="show_div">
                    <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                    <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
                </div>
				<?if ($isRequiredOptionsSet):?>
					<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
						<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
					</a>
				<?endif;?>
            </div>            <!--        tab3        -->
            <tr>
                <td>
                    <table width="100%" class="edit-table" id="table_export">
                        <tr class="heading">
                            <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                            <td><?= GetMessage('PP_INVOICE_ID') ?></td>
                            <td><?= GetMessage('PP_STATUS') ?></td>
                            <td><?= GetMessage('PP_SUMM') ?></td>
                            <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                            <td><?= GetMessage('PP_ADDRESS') ?></td>
                            <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                            <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                            <td><?= GetMessage('PP_WIDTH') ?></td>
                            <td><?= GetMessage('PP_HEIGHT') ?></td>
                            <td><?= GetMessage('PP_DEPTH') ?></td>
                            <td><?= GetMessage('PP_ACTION_CANCEL') ?></td>
                            <td><?= GetMessage('PP_ACTION_EDIT') ?></td>
                            <td><?= GetMessage('PP_ARCHIVE_ADD') ?></td>
                        </tr>
						<?php if (is_array($arItems['REVERTED']) && count($arItems['REVERTED'])):?>
							<?php foreach ($arItems['REVERTED'] as $key => $arItem) : ?>
								<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
								$bActive = $arItem['INVOICE_ID'] ? false : true;

								$arItem['PAYED'] = $arItem['PRICE'];
								$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

								if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
									$arItem['PAYED_PP_SET'] = 1;
								}
								?>
								<tr class="id_revert" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
									<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
										<br/><?= $arItem['ORDER_DATE'] ?></td>
									<td align="center"><?= $arItem['INVOICE_ID'] ? $arItem['INVOICE_ID'] : '' ?></td>
									<td align="center" style="font-weight: bold" title="<?= $statusTable[$arItem['STATUS']]['TEXT'] ?>"><?= $arItem['STATUS']; ?></td>
									<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
										<?php if ($bActive) : ?><input type="hidden"id="export_price_<?= $arItem['ORDER_ID'] ?>"
																	   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
									<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
										<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
											<?= $arItem['PAYED'] ?>
										<?php else : ?>
											<?= GetMessage('PP_NO') ?>
										<?php endif; ?>
									</td>
									<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
									<td align="center">
										<?php if ($arItem['PAYED_BY_PP']) : ?>
											<?= $arServiceTypes[1] ?>
										<?php else : ?>
											<?= $arServiceTypes[0] ?>
										<?php endif ?>
									</td>
									<td align="center">
										<?php
										$encl_type = null;
										if ($arRequestItem['ENCLOSING_TYPE']) {
											$encl_type = $arRequestItem['ENCLOSING_TYPE'];
										} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
											$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
										}
										?>
										<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
												name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
										<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
											<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
												<option <?= $encl_type == $iKey ? 'selected' : '' ?>
														value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
										</select>
									</td>
									<td align="center"><?= number_format(floatval($arItem['WIDTH']) , 2); ?></td>
									<td align="center"><?= number_format(floatval($arItem['HEIGHT']) , 2); ?></td>
									<td align="center"><?= number_format(floatval($arItem['DEPTH']) , 2); ?></td>
									<td style="text-align: center">
										<?php if ($arItem['CANCELED'] && $arItem['INVOICE_ID']) : ?>
											<span style="color: red;"><?= GetMessage('PP_CANCEL_SUCCESS') ?></span>
										<?php elseif($arItem['INVOICE_ID'] && !$arItem['CANCELED']): ?>
											<input type="checkbox" class="cToCancel"
												   name="CANCEL[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
												   autocomplete="off"/>
										<?php else: ?>
											<span style="color: green;"><?= GetMessage('PP_CANCEL_NOT_EXPORT') ?></span>
										<?php endif; ?>
									</td>
									<td style="text-align: center">
										<?php if (!$arItem['CANCELED']) : ?>
											<a target="_blank" style="text-decoration: none" href="/bitrix/admin/pickpoint_edit.php?ORDER_ID=<?= $arItem['ORDER_ID'] ?>"><?= GetMessage('PP_EDIT_LINK') ?></a>
										<?php endif; ?>
									</td>
									<td align="center">
										<input type="checkbox" class="cToArchive"
											   name="ARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
											   autocomplete="off"/>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
                    </table>
                    <?php if (is_array($arItems['REVERTED']) && (count($arItems['REVERTED']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                        <div style="text-align: center; height: 30px">
                            <span class="knopka button_revert" onclick="showAll('revert')">
                                <?= GetMessage('PP_SHOW_MORE') ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php $tabControl->BeginNextTab(); ?>
        <div style="text-align: center; height: 30px">
            <div class="show_div">
                <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
            </div>
			<?if ($isRequiredOptionsSet):?>
				<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
					<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
				</a>
			<?endif;?>
        </div>        <!--        tab3        -->
        <tr>
            <td>
                <table width="100%" class="edit-table" id="table_export">
                    <tr class="heading">
                        <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                        <td><?= GetMessage('PP_INVOICE_ID') ?></td>
                        <td><?= GetMessage('PP_STATUS') ?></td>
                        <td><?= GetMessage('PP_SUMM') ?></td>
                        <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                        <td><?= GetMessage('PP_ADDRESS') ?></td>
                        <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                        <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                        <td><?= GetMessage('PP_WIDTH') ?></td>
                        <td><?= GetMessage('PP_HEIGHT') ?></td>
                        <td><?= GetMessage('PP_DEPTH') ?></td>
                        <td><?= GetMessage('PP_ARCHIVE_ADD') ?></td>
                    </tr>
					<?php if (is_array($arItems['READY']) && count($arItems['READY'])):?>
						<?php foreach ($arItems['READY'] as $key => $arItem) : ?>
							<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
							$bActive = $arItem['INVOICE_ID'] ? false : true;

							$arItem['PAYED'] = $arItem['PRICE'];
							$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

							if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
								$arItem['PAYED_PP_SET'] = 1;
							}
							?>
							<tr class="id_ready" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
								<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
									<br/><?= $arItem['ORDER_DATE'] ?></td>
								<td align="center"><?= $arItem['INVOICE_ID'] ? $arItem['INVOICE_ID'] : '' ?></td>
								<td align="center" style="font-weight: bold" title="<?= $statusTable[$arItem['STATUS']]['TEXT'] ?>"><?= $arItem['STATUS']; ?></td>
								<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
									<?php if ($bActive) : ?><input type="hidden"id="export_price_<?= $arItem['ORDER_ID'] ?>"
																   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
								<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
									<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
										<?= $arItem['PAYED'] ?>
									<?php else : ?>
										<?= GetMessage('PP_NO') ?>
									<?php endif; ?>
								</td>
								<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
								<td align="center">
									<?php if ($arItem['PAYED_BY_PP']) : ?>
										<?= $arServiceTypes[1] ?>
									<?php else : ?>
										<?= $arServiceTypes[0] ?>
									<?php endif ?>
								</td>
								<td align="center">
									<?php
									$encl_type = null;
									if ($arRequestItem['ENCLOSING_TYPE']) {
										$encl_type = $arRequestItem['ENCLOSING_TYPE'];
									} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
										$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
									}
									?>
									<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
											name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
									<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
										<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
											<option <?= $encl_type == $iKey ? 'selected' : '' ?>
													value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
									</select>
								</td>
								<td align="center"><?= number_format(floatval($arItem['WIDTH']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['HEIGHT']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['DEPTH']) , 2); ?></td>
								<td align="center">
									<input type="checkbox" class="cToArchive"
										   name="ARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
										   autocomplete="off"/>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
                </table>
                <?php if (is_array($arItems['READY']) && (count($arItems['READY']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                    <div style="text-align: center; height: 30px">
                        <span class="knopka button_ready" onclick="showAll('ready')">
                            <?= GetMessage('PP_SHOW_MORE') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <?php $tabControl->BeginNextTab(); ?>
        <div style="text-align: center; height: 30px">
            <div class="show_div">
                <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
            </div>
			<?if ($isRequiredOptionsSet):?>
				<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
					<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
				</a>
			<?endif;?>
        </div>        <!--        tab3        -->
        <tr>
            <td>
                <table width="100%" class="edit-table" id="table_export">
                    <tr class="heading">
                        <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                        <td><?= GetMessage('PP_INVOICE_ID') ?></td>
                        <td><?= GetMessage('PP_STATUS') ?></td>
                        <td><?= GetMessage('PP_SUMM') ?></td>
                        <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                        <td><?= GetMessage('PP_ADDRESS') ?></td>
                        <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                        <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                        <td><?= GetMessage('PP_WIDTH') ?></td>
                        <td><?= GetMessage('PP_HEIGHT') ?></td>
                        <td><?= GetMessage('PP_DEPTH') ?></td>
                        <td><?= GetMessage('PP_ARCHIVE_ADD') ?></td>
                    </tr>
					<?php if (is_array($arItems['CANCELED']) && count($arItems['CANCELED'])):?>
						<?php foreach ($arItems['CANCELED'] as $key => $arItem) : ?>
							<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
							$bActive = $arItem['INVOICE_ID'] ? false : true;

							$arItem['PAYED'] = $arItem['PRICE'];
							$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

							if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
								$arItem['PAYED_PP_SET'] = 1;
							}
							?>
							<tr class="id_cancel" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
								<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
									<br/><?= $arItem['ORDER_DATE'] ?></td>
								<td align="center"><?= $arItem['INVOICE_ID'] ? $arItem['INVOICE_ID'] : '' ?></td>
								<td align="center" style="font-weight: bold" title="<?=$statusTable[$arItem['STATUS']]['TEXT']?>"><?= $arItem['STATUS']; ?></td>
								<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
									<?php if ($bActive) : ?><input type="hidden"id="export_price_<?= $arItem['ORDER_ID'] ?>"
																   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
								<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
									<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
										<?= $arItem['PAYED'] ?>
									<?php else : ?>
										<?= GetMessage('PP_NO') ?>
									<?php endif; ?>
								</td>
								<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
								<td align="center">
									<?php if ($arItem['PAYED_BY_PP']) : ?>
										<?= $arServiceTypes[1] ?>
									<?php else : ?>
										<?= $arServiceTypes[0] ?>
									<?php endif ?>
								</td>
								<td align="center">
									<?php
									$encl_type = null;
									if ($arRequestItem['ENCLOSING_TYPE']) {
										$encl_type = $arRequestItem['ENCLOSING_TYPE'];
									} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
										$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
									}
									?>
									<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
											name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
									<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
										<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
											<option <?= $encl_type == $iKey ? 'selected' : '' ?>
													value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
									</select>
								</td>
								<td align="center"><?= number_format(floatval($arItem['WIDTH']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['HEIGHT']) , 2); ?></td>
								<td align="center"><?= number_format(floatval($arItem['DEPTH']) , 2); ?></td>
								<td align="center">
									<input type="checkbox" class="cToArchive"
										   name="ARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
										   autocomplete="off"/>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
                </table>
                <?php if (is_array($arItems['CANCELED']) && (count($arItems['CANCELED']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                    <div style="text-align: center; height: 30px">
                        <span class="knopka button_cancel" onclick="showAll('cancel')">
                            <?= GetMessage('PP_SHOW_MORE') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <?php $tabControl->BeginNextTab(); ?>
        <div style="text-align: center; height: 30px">
            <div class="show_div">
                <span><?php echo GetMessage('PP_SHOW_ORDER') ?></span>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 20 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=20">20</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 50 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=50">50</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 100 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=100">100</a>
                <a <?= $arOptions['OPTIONS']['show_elements_count'] == 99999999 ? 'style="color:black;font-weight: bold;"' : ''; ?> href="<?= $APPLICATION->GetCurPage() ?>?show=99999999"><?php echo GetMessage('PP_ALL') ?></a>
            </div>
			<?if ($isRequiredOptionsSet):?>
				<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y">
					<?php echo GetMessage('PP_UPDATE_BUTTON') ?>
				</a>
			<?endif;?>
        </div>        <!--        tab3        -->
        <tr>
            <td>
                <table width="100%" class="edit-table" id="table_export">
                    <tr class="heading">
                        <td><?= GetMessage('PP_ORDER_NUMBER') ?></td>
                        <td><?= GetMessage('PP_INVOICE_ID') ?></td>
                        <td><?= GetMessage('PP_STATUS') ?></td>
                        <td><?= GetMessage('PP_SUMM') ?></td>
                        <td><?= GetMessage('PP_PAYED_BY_PP') ?></td>
                        <td><?= GetMessage('PP_ADDRESS') ?></td>
                        <td><?= GetMessage('PP_SERVICE_TYPE') ?></td>
                        <td><?= GetMessage('PP_RECEPTION_TYPE') ?></td>
                        <td><?= GetMessage('PP_ARCHIVE_DELETE') ?></td>
                    </tr>
					<?php if (is_array($arItems['ARCHIVE']) && count($arItems['ARCHIVE'])):?>
						<?php foreach ($arItems['ARCHIVE'] as $key => $arItem) : ?>
							<?php $arRequestItem = $_REQUEST['EXPORT'][$arItem['ORDER_ID']];
							$bActive = $arItem['INVOICE_ID'] ? false : true;

							$arItem['PAYED'] = $arItem['PRICE'];
							$arItem['PAYED'] = number_format($arItem['PAYED'], 2, '.', '');

							if (in_array($arItem['SETTINGS']['SERVICE_TYPE'], array(1, 3))) {
								$arItem['PAYED_PP_SET'] = 1;
							}
							?>
							<tr class="id_archive" <?= $key > $arOptions['OPTIONS']['show_elements_count'] ? 'style="display:none"' : ''; ?>>
								<td align="center"><?= GetMessage('PP_N') ?><?= $arItem['ORDER_ID'] ?> <?= GetMessage('PP_FROM') ?>
									<br/><?= $arItem['ORDER_DATE'] ?></td>
								<td align="center"><?= $arItem['INVOICE_ID'] ? $arItem['INVOICE_ID'] : '' ?></td>
								<td align="center" style="font-weight: bold" title="<?=$statusTable[$arItem['STATUS']]['TEXT']?>"><?= $arItem['STATUS']; ?></td>
								<td align="center"><?= CurrencyFormat($arItem['PRICE'], 'RUB') ?>
									<?php if ($bActive) : ?><input type="hidden" id="export_price_<?= $arItem['ORDER_ID'] ?>"
																   value="<?= $arItem['PRICE'] ?>" /><?php endif; ?></td>
								<td align="center" id="export_payed_price_<?= $arItem['ORDER_ID'] ?>">
									<?php if ($arItem['PAYED_BY_PP'] || $arItem['PAYED_PP_SET']): ?>
										<?= $arItem['PAYED'] ?>
									<?php else : ?>
										<?= GetMessage('PP_NO') ?>
									<?php endif; ?>
								</td>
								<td align="center"><?= $arItem['PP_ADDRESS'] ?></td>
								<td align="center">
									<?php if ($arItem['PAYED_BY_PP']) : ?>
										<?= $arServiceTypes[1] ?>
									<?php else : ?>
										<?= $arServiceTypes[0] ?>
									<?php endif ?>
								</td>
								<td align="center">
									<?php
									$encl_type = null;
									if ($arRequestItem['ENCLOSING_TYPE']) {
										$encl_type = $arRequestItem['ENCLOSING_TYPE'];
									} elseif ($arItem['SETTINGS']['ENCLOSING_TYPE']) {
										$encl_type = $arItem['SETTINGS']['ENCLOSING_TYPE'];
									}
									?>
									<select <?php if (!$bActive) : ?> disabled="disabled"<?php endif; ?>
											name="EXPORT[<?= $arItem['ORDER_ID'] ?>][ENCLOSING_TYPE]"/>
									<?php foreach ($arEnclosingTypes as $iKey => $sEnclosingType): ?>
										<?php if (in_array($iKey, $arAllowedEnclosingTypes)): ?>
											<option <?= $encl_type == $iKey ? 'selected' : '' ?>
													value="<?= $iKey ?>"><?= $sEnclosingType ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
									</select>
								</td>
								<td align="center">
									<input type="checkbox" class="cToArchive"
										   name="FROMARCHIVE[<?= $arItem['ORDER_ID'] ?>][<?= $arItem['INVOICE_ID'] ?>]"
										   autocomplete="off"/>
								</td>
							 </tr>
						<?php endforeach; ?>
					<?php endif; ?>
                </table>
                <?php if (is_array($arItems['ARCHIVE']) && (count($arItems['ARCHIVE']) > $arOptions['OPTIONS']['show_elements_count'])): ?>
                    <div style="text-align: center; height: 30px">
                        <span class="knopka button_archive" onclick="showAll('archive')">
                            <?= GetMessage('PP_SHOW_MORE') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <?php $tabControl->Buttons(); ?>
		<?if ($isRequiredOptionsSet):?>	
			<input type="submit" class="adm-btn-save" name="export" onclick="return CheckFields();" value="<?php echo GetMessage('PP_EXPORT_BUTTON') ?>">		   
			<a class="knopka" href="<?= $APPLICATION->GetCurPage() ?>?updateStatus=Y"><?php echo GetMessage('PP_UPDATE_BUTTON') ?></a>
		<?endif;?>
        <?php
        $tabControl->End();
        $tabControl->ShowWarnings('find_form', $message);

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php';
