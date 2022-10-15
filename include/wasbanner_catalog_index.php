<script src="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/jquery.arcticmodal-0.32.min.js"></script>
<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/jquery.arcticmodal-0.32.css">
<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/themes/simple.css?<?= time() ?>">

<div style="display: none;">
    <div class="box-modal" id="boxUserFirstInfo2">
        <? /* <div class="box-modal_close arcticmodal-close">X</div> */ ?>
        <br>

        <table>
            <tr>
                <td class="td18" style="font-size: 120px; padding: 10px 30px 10px 10px; color: #21385e;">18+</td>
                <td>
                    <h3 style="color: #21385e;font-weight: 700;">Внимание!</h3><br>

                    <p>Для просмотра сайта www.kolchuga.ru необходимо подтвердить свой совершеннолетний возраст.</p>
                    <p style="color: #21385e;font-size: 1.20em;font-weight: 700;">Вам уже есть 18 лет?</p>
                    <div class="knopka">
                        <a class="arcticmodal2-close" href="javascript:void(0);"
                           style="padding: 10px 20px; display: block;color: #ffffff;background: #21385e;max-width: 300px;text-align: center;"
                           onclick="storeInSession18plusAgreement()">Подтверждаю</a>
                    </div>
                </td>
            </tr>
        </table>


    </div>
</div>

<script>
    $(function () {

        // Проверим, есть ли запись в куках о посещении посетителя
        // Если запись есть - ничего не делаем
        if (!$.cookie('18plusAgreement')) {

            function getWindow() {
                // Покажем всплывающее окно
                $('#boxUserFirstInfo2').arcticmodal2({
                    closeOnOverlayClick: false,
                    closeOnEsc: true,

                });
            };

            setTimeout(getWindow, 2000);

        }

    })
</script>


<script src="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/jquery.arcticmodal-0.3r.min.js"></script>
<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/jquery.arcticmodal-0.3r.css">
<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/plugins/arcticmodal/themes/simple.css?<?= time() ?>">

<div style="display: none;">
    <div class="box-modal" id="boxUserFirstInfo">
        <? /* <div class="box-modal_close arcticmodal-close">X</div> */ ?>
        <br>
        <h3>Уважаемые клиенты!</h3><br>

        <p>Обращаем ваше внимание, на сайте kolchuga.ru используются материалы с возрастным ограничением 18+. Если вам
            меньше 18 лет просьба покинуть сайт kolchuga.ru. Лицензионная продукция на сайте kolchuga.ru представлена в
            ознакомительных целях, и не может быть оплачена и приобретена дистанционным способом.</p>
        <div class="knopka text-center">
            <a class="arcticmodal-close mx-auto" href="javascript:void(0);"
               style="padding: 10px 20px; display: block;color: #ffffff;background: #21385e;max-width: 300px;"
               onclick="storeInSession18plus()">Ознакомлен(а)</a>
        </div>

    </div>
</div>

<script>

    $(function () {

        // Проверим, есть ли запись в куках о посещении посетителя
        // Если запись есть - ничего не делаем
        if (!$.cookie('18plus')) {

            function getWindow() {
                // Покажем всплывающее окно
                $('#boxUserFirstInfo').arcticmodal({
                    closeOnOverlayClick: false,
                    closeOnEsc: true,

                });
            };


            if ($(window).width() > 640) {
                setTimeout(getWindow, 3000);
            }


        }

    })


    function storeInSession18plusAgreement() {
        $.cookie('18plusAgreement', true, {
            expires: 7,
            path: '/'
        });
    }

    function storeInSession18plus() {
        $.cookie('18plus', true, {
            expires: 7,
            path: '/'
        });
    }
</script>
