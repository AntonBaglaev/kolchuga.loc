<? $APPLICATION->SetAdditionalCSS("/local/templates/kolchuga_2016/css/bootstrap.css");
$APPLICATION->AddHeadScript("/local/templates/kolchuga_2016/js/bootstrap.min.js"); ?>
<div id="response-contaaa" style="width: 100%;display: none;">
    <div class="contacts-section__body px-0">

        <?

        $arServiceCenters = ["TITLE" => ['barvikha'      => 'ТК «БАРВИХА Luxury Village»',
                                         'varvarka'      => 'ул. Варварка, 3 «Гостиный двор»',
                                         'volokolamskoe' => 'Волоколамское шоссе, 86',
                                         'leninsky'      => 'Ленинский проспект, 44',
                                         'lyubertsy'     => 'г. Люберцы, ул. Котельническая, 24А',
        ]];

        $APPLICATION->IncludeComponent(
            'kolchuga:master.timetable',
            '',
            array(
                'ITEM_CODE'       => $_REQUEST['ITEM_CODE'],
                'SERVICE_CENTERS' => $arServiceCenters,
                'CACHE_TYPE'      => 'A',
                'CACHE_TIME'      => '7200',
            )
        );
        ?>


        <? /*$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"contacts_new",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => Array(),
		"WEB_FORM_ID" => 4
	)
);*/ ?>
    </div>
</div>
<script>

    var oPopup = {};

    BX.ready(function () {

        var obPopupParams = {
            offsetTop: 0,
            offsetLeft: 0,
            overlay: true,
            lightShadow: true,
            closeIcon: true,
            closeByEsc: true,
            events: {
                onAfterPopupClose: function (popup) {
                }
            },
        };

        oPopup = BX.PopupWindowManager.create('contaaa', window.body, obPopupParams);
        oPopup.setContent(BX('response-contaaa'));

        $(document).on('click', '.js_get_sert', function () {

            BX.showWait();

            service_center = $(this).data('salon') || '';

            arr_service_centers = new Array();
            $.each(ob_service_centers, function (key, value) {
                arr_service_centers[key] = value;
            });

            if (arr_service_centers[service_center]) {

                var eventSources = calendar.getEventSources();
                var len = eventSources.length;
                for (var i = 0; i < len; i++) {
                    eventSources[i].remove();
                }

                var arEvents = calendar.getEvents();
                var len = arEvents.length;
                for (var i = 0; i < len; i++) {
                    arEvents[i].remove();
                }

                calendar.addEventSource('/master/events.php?service_center=' + service_center);

                var arServiceTime = [];

                arServiceTime['barvikha'] = {'start': '10:00', 'end': '23:00'};
                arServiceTime['varvarka'] = {'start': '10:00', 'end': '20:00'};
                arServiceTime['volokolamskoe'] = {'start': '10:00', 'end': '19:00'};
                arServiceTime['leninsky'] = {'start': '10:00', 'end': '19:00'};
                arServiceTime['lyubertsy'] = {'start': '10:00', 'end': '20:00'};

                if (arServiceTime[service_center].start)
                calendar.setOption('slotMinTime', arServiceTime[service_center].start);

                if (arServiceTime[service_center].end)
                calendar.setOption('slotMaxTime', arServiceTime[service_center].end);

                calendar.render();

                $('.fc-theme-standard .fc-toolbar-ltr .fc-toolbar-chunk:first').html(arr_service_centers[service_center]);

                oPopup.show();
                calendar.updateSize();
            }

        });

    });

</script>
