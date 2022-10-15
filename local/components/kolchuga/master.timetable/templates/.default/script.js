var calendar = {};

$(function () {

    var $arg_this = null;

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    service_center = service_center || '';

    var calendarEl = document.getElementById('calendar');

    var obCalendarParams = {
        expandRows: true,
//      weekends: false,
        dayMaxEvents: true,
        contentHeight: 600,
        unselectAuto: false,
        locale: 'ru',
        headerToolbar: {
            left: '',
            center: '',
            right: ''
        },
        /*        customButtons: {
                    closeButton: {
                        text: 'Закрыть',
                        click: function () {
                            oPopup.close();
                        }
                    }
                },*/
        footerToolbar: {
            left: 'title',
            center: '',
            right: 'prev,next'
        },
        navLinks: false,
        eventSources: [
            '/master/events.php?service_center=' + service_center,
        ],
        select: function (arg) {
            $arg_this = arg;
            selectEventHandler(arg);
        },
        eventDrop: function (arg) {
            eventDropHandler(arg);
        },
        eventResize: function (arg) {
            eventDropHandler(arg);
        },
        eventClick: function (arg) {
            eventClickHandler(arg);
        },
        loading: function (isLoading, view) {
            if (isLoading) {
                //BX.showWait();
            } else {
                BX.closeWait();
            }
        }
    };

    if (typeof obAdditionalParams === 'object') {
        $.extend(obCalendarParams, obAdditionalParams);

        calendar = new FullCalendar.Calendar(calendarEl, obCalendarParams);

    }

    $('#c_dialog').dialog({
        autoOpen: false,
        width: 400,
        buttons: [
            {
                text: "Отправить заявку",
                icon: "ui-icon-check",
                click: function () {

                    addEventHandler($arg_this, $(this));

                }
            },
            {
                text: "Отмена",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $('#c_auth').dialog({
        autoOpen: false,
        width: 400,
        title: "Авторизация",
        open: function (event, ui) {
            $(".ui-widget-overlay").css({
                opacity: 0.5,
                filter: "Alpha(Opacity=50)",
                backgroundColor: '#000000'
            });
        },
        modal: true,
        buttons: [
            {
                text: "Авторизоваться на сайте",
                icon: "ui-icon-check",
                click: function () {

                    __this = $(this);

                    var form = __this.find('form');

                    $.post("/master/auth_user.php", {
                            sessid: BX.bitrix_sessid(),
                            service_center: service_center,
                            data: form.serialize(),
                        },
                        function (data) {

                            if (typeof data === 'string' && data != '') {
                                var response = JSON.parse(data);

                                if (response.msg != 'undefined') {
                                    $('#auth_form').after('<div class="_error">' + response.msg + '</div>');
                                }

                                if (response.status == 'ok') {
                                    __this.dialog('close');

                                    window.location.reload();

                                } else if (response.status == 'error') {

                                    var arErrors = response.errors;

                                    if (arErrors != 'undefined') {
                                        $.each(arErrors, function (i, obj) {
                                            if (obj.field) {

                                                $('#c_auth_' + obj.field).css('borderColor', 'red');

                                                $('#c_auth_' + obj.field).after('<div class="_error">' + obj.message + '</div>');

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

                }
            },
            {
                text: "Отмена",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    var viewRecordDialog = $('#viewRecord').dialog({
        autoOpen: false,
        width: 400,
        buttons: [
            {
                text: "Закрыть окно",
                icon: "ui-icon-check",
                click: function () {
                    $(this).dialog('close');
                }
            },
        ]
    });

    if (service_event) {

        var viewButtons = viewRecordDialog.dialog("option", "buttons");

        $.extend(viewButtons, {
            1: {
                text: "Удалить бронь",
                icon: "ui-icon-trash",
                click: function () {
                    var event_id = $(this).find('.event_id').val();

                    eventDeleteHandler(event_id);

                    $(this).dialog('close');
                }

            }
        });

        viewRecordDialog.dialog("option", "buttons", viewButtons);
    }

    $('#viewRecord').on('dialogclose', function (event) {
        $("#viewRecord").html('');
    });

    $('#c_dialog').on('dialogclose', function (event) {
        calendar.unselect();
        BX.closeWait();
    });

    $('#c_auth').on('dialogclose', function (event) {
        calendar.unselect();
        BX.closeWait();
    });

    $(document).on('click', '.js-open-auth', function () {
        $("#c_auth").dialog("open");
    });

});
