<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<link href='/master/fullcalendar/lib/main.css' rel='stylesheet'/>
<link href='/master/js/jquery-ui/jquery-ui.min.css' rel='stylesheet'/>
<script src='/master/fullcalendar/lib/moment.min.js'></script>
<script src='/master/fullcalendar/lib/main.js'></script>
<script src='/master/fullcalendar/lib/locales/ru.js'></script>
<script src='/master/js/jquery-ui/jquery-ui.min.js'></script>

<div id='calendar'></div>

<?

$arAllowed = [];

if ($GLOBALS['USER']->IsAuthorized()) {

    $arFilter = array("ID" => $GLOBALS['USER']->GetID());
    $arParams["SELECT"] = array("UF_SERVICE");
    $arRes = CUser::GetList($by, $order, $arFilter, $arParams);
    if ($res = $arRes->Fetch()) {
        foreach ($res["UF_SERVICE"] as $intId) {
            $rsRes = CUserFieldEnum::GetList(array(), array(
                "ID" => $intId,
            ));
            if ($arService = $rsRes->GetNext())
                $arAllowed[] = $arService["XML_ID"];
        }
    }

}

$serviceCenter = 'varvarka';

if ($_REQUEST['ITEM_CODE']) {

    if ($arParams['SERVICE_CENTERS']['TITLE'][$_REQUEST['ITEM_CODE']]) {
        $serviceCenter = addslashes(htmlspecialchars($_REQUEST['ITEM_CODE']));
    }

}

$obCalendarParams = [];

$obCalendarParams['slotMinTime'] = '10:00';
$obCalendarParams['slotMaxTime'] = '20:00';
$obCalendarParams['initialView'] = 'timeGridWeek';
$obCalendarParams['slotDuration'] = '01:00';
$obCalendarParams['selectable'] = true;
if ($GLOBALS['USER']->IsAuthorized() && !empty($arAllowed)) {
    $obCalendarParams['editable'] = true;
}

?>

<script>
    var service_center = '<?= $serviceCenter?>';
    var raw_service_centers = '<?= json_encode($arParams['SERVICE_CENTERS']['TITLE']);?>';
    var ob_service_centers = JSON.parse(raw_service_centers);

    var obAdditionalParams = <?= json_encode($obCalendarParams);?>

    if ($(window).width() < 769) {
        obAdditionalParams.initialView = 'timeGrid';
        obAdditionalParams.dayCount = 3;
    }

    function eventDropHandler(arg) {
        <? if ($GLOBALS['USER']->IsAuthorized() && !empty($arAllowed)):?>
        $.ajax({
            url: '/master/update_events.php',
            data: 'title=' + arg.event.title + '&service_center=' + service_center + '&start=' + arg.event.startStr + '&end=' + arg.event.endStr + '&id=' + arg.event.id,
            type: "POST",
            success: function (json) {
            }
        });
        <? endif?>
    }

    function eventDeleteHandler(event_id) {
        <? if ($GLOBALS['USER']->IsAuthorized() && !empty($arAllowed)):?>
        if (event_id) {
            var decision = confirm("Вы точно хотите удалить бронь?");
            if (decision) {
                $.ajax({
                    type: "POST",
                    url: "/master/delete_event.php",
                    data: "&id=" + event_id,
                    success: function (json) {
                        calendar.getEventById(event_id).remove();
                    }
                });
            }
        }
        <? endif?>
    }

    function eventClickHandler(arg) {
        <? if ($GLOBALS['USER']->IsAuthorized() && !empty($arAllowed)):?>
        $("#viewRecord").prepend(
            '    <div class="row">' +
            '      <div class="col-3">Имя</div>' +
            '      <div class="col-4">' + arg.event.extendedProps.name + '</div>' +
            '    </div>' +
            '    <div class="row">' +
            '      <div class="col-3">E-mail</div>' +
            '      <div class="col-4">' + arg.event.extendedProps.email + '</div>' +
            '    </div>' +
            '    <div class="row">' +
            '      <div class="col-3">Телефон</div>' +
            '      <div class="col-4">' + arg.event.extendedProps.phone + '</div>' +
            '    </div>' +
            '    <div class="row">' +
            '      <div class="col-12"><br>' + arg.event.extendedProps.message +
            '      <input type="hidden" class="event_id" value="' + arg.event.id + '"></div>' +
            '    </div>'
        );

        $("#viewRecord").dialog('open');
        <? endif?>
    }

    function addEventHandler(arg, __this) {
        <? if ($GLOBALS['USER']->IsAuthorized()):?>
        var form = __this.find('form');

        $.post("/master/add_events.php", {
                sessid: BX.bitrix_sessid(),
                service_center: service_center,
                start: arg.startStr,
                end: arg.endStr,
                data: form.serialize(),
            },
            function (data) {
                if (typeof data === 'string' && data != '') {
                    var response = JSON.parse(data);

                    if (response.msg != undefined)
                        console.log(response.msg);

                    if (response.status == 'ok' && response.id && response.title) {
                        calendar.addEvent({
                            id: response.id,
                            name: response.name,
                            email: response.email,
                            phone: response.phone,
                            message: response.message,
                            title: response.title,
                            start: arg.start,
                            end: arg.end,
                            allDay: arg.allDay
                        });

                        calendar.unselect();

                        document.getElementById('new_event_form').reset();
                        __this.dialog('close');
                    } else if (response.status == 'error') {

                        var arErrors = response.errors;

                        if (arErrors != 'undefined') {
                            $.each(arErrors, function (i, obj) {
                                if (obj.field) {

                                    $('#c_' + obj.field).css('borderColor', 'red');

                                    $('#c_' + obj.field).after('<div class="_error">' + obj.message + '</div>');

                                }

                            });

                            setTimeout(() => {
                                $('.form-control').css('borderColor', '#1d355b');
                                $('._error').remove();
                            }, 2000);

                        }
                    }
                } else {
                    console.error('Что-то не так...');
                }
            });

        <? endif?>
    }

    function selectEventHandler(arg) {
        <? if ($GLOBALS['USER']->IsAuthorized()):?>

        $("#c_dialog").dialog("open");

        <? endif?>
    }

    var service_event = false;
    <? if ($GLOBALS['USER']->IsAuthorized() && !empty($arAllowed)):?>
    service_event = true || false;
    <? endif?>
</script>

<div id="c_dialog">
    <form name="form_1" id="new_event_form" action="/" method="POST">
        <input type="hidden" name="AUTH_ANTIBOT" value="">
        <div class="form-group">
            <label for="c_message">Сообщение*</label>
            <textarea name="message" class="form-control" id="c_message" autocomplete="off"
                      class="event_form_field"></textarea>
        </div>
        <div class="form-group">
            <label for="c_name">Имя*</label>
            <input type="text" class="form-control" name="name" id="c_name" value="" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="c_email">E-mail*</label>
            <input type="text" class="form-control" name="email" id="c_email" value=""
                   autocomplete="off">
        </div>
        <div class="form-group">
            <label for="c_phone">Номер телефона</label>
            <input type="text" class="form-control" name="phone" id="c_phone" value=""
                   autocomplete="off">
        </div>
    </form>
</div>

<div id="viewRecord"></div>

<div id="c_auth" class="js-rmodal-content" data-rmodal="auth">
    <form name="form_1" id="auth_form" action="/" method="POST">
        <input type="hidden" name="AUTH_ANTIBOT" value="">
        <div class="form-group">
            <label for="c_auth_email">E-mail*</label>
            <input type="text" class="form-control" name="email" id="c_auth_email" value="">
        </div>
        <div class="form-group">
            <label for="c_auth_password">Пароль*</label>
            <input type="password" class="form-control" name="password" id="c_auth_password" value=""
                   autocomplete="off">
        </div>
    </form>
</div>
