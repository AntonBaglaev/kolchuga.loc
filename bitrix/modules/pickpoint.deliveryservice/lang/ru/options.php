<?
// Error messages
$MESS['PP_MODULE_OPTIONS_NOT_SET'] = 'Внимание!';
$MESS['PP_MODULE_OPTIONS_NOT_SET_TEXT'] = '<p>Для корректной работы модуля необходимо заполнить все обязательные параметры настроек. Рекомендуем руководствоваться информацией на вкладке "Документация", раздел "Настройка модуля". Часть данных, необходимых для настройки, указаны в Договоре, заключаемом вашим магазином и компанией PickPoint.</p><p><b>Пока модуль не настроен, автоматизированная служба доставки PickPoint не будет выводиться на странице оформления заказа.</b></p>';

// Legacy
$MESS['PP_WRONG_KEY'] = 'Введен неправильный ИКН магазина.';

// Used
$MESS['PP_ERROR_OPTONS_DONT_SAVED'] = 'Настройки модуля не сохранены';

// Setup 
// Some messages are in include.php, don't know why
$MESS['PP_API_LOGIN'] = 'Логин для входа в личный кабинет<br/><small>(необходимо запросить в PickPoint, доступ к работе через API)</small>';
$MESS['PP_API_PASSWORD'] = 'Пароль для входа в личный кабинет<br/><small>(необходимо запросить в PickPoint, доступ к работе через API)</small>';
$MESS['PP_TEST_MODE'] = 'Тестовый режим';
$MESS['PP_TERM_INC'] = 'Увеличить срок доставки на (дней)';
$MESS['PP_POSTAMAT_PICKER'] = 'Код свойства заказа, куда будет сохранен выбранный постамат';
$MESS['PP_ADD_INFO'] = 'Дописывать информацию о выбранном постамате в поле "Комментарий к заказу"';
$MESS['PP_PHONE_FROM_PROPERTY_TITLE'] = 'Брать телефон из свойства заказа?';
$MESS['PP_CITY_FROM_LOCATION'] = 'Город на основе автоматически определенной локации';
$MESS['PP_CITY_FROM_ORDER_PROP_STATUS'] = 'Брать город из свойства заказа?';

$MESS['PP_TYPE'] = 'Тип';
$MESS['PP_VALUE'] = 'Значение';
$MESS['PP_DELETE'] = 'Удалить';
$MESS['PP_VALUE_NAME'] = 'Название параметра';

$MESS['PP_CITY_FROM_ORDER_PROP'] = 'Укажите свойство, из которого будет браться город для доставки';
$MESS['PP_PHONE_FROM_PROPERTY_SELECT'] = 'Укажите свойство, из которого будет браться телефон<br/><small>(поле телефона должно быть обязательным для создания заказа)</small>';
$MESS['PP_FIO'] = 'ФИО получателя';
$MESS['PP_EMAIL'] = 'Email';

// Sender and revert
$MESS['PP_STORE_LOCATION'] = 'Город отправки';
$MESS['PP_VAT_DELIVERY_VAT_TITLE'] = 'Ставка НДС по сервисному сбору';

$MESS['PP_REVERT_TITLE'] = 'Настройки возврата';
$MESS['PP_REVERT_REGION'] = 'Название региона';
$MESS['PP_REVERT_CITY'] = 'Название города';
$MESS['PP_STORE_ADDRESS'] = 'Адрес клиентского возврата<br/><small>(обязательное поле для заполнения)</small>';
$MESS['PP_STORE_PHONE'] = 'Телефон клиентского возврата<br/><small>(обязательное поле для заполнения, в формате 79151234565)</small>';
$MESS['PP_REVERT_FIO'] = 'ФИО контактного лица';
$MESS['PP_REVERT_POST'] = 'Почтовый индекс';
$MESS['PP_REVERT_Organisation'] = 'Наименование организации';
$MESS['PP_REVERT_COMMENT'] = 'Комментарий при возврате';

// Dimensions
$MESS['PP_DIMENSIONS_TITLE'] = 'Габариты';
$MESS['PP_DIMENSIONS_WiDTH'] = 'Ширина в см<br/><small>(обязательное поле для заполнения)</small>';
$MESS['PP_DIMENSIONS_HEIGHT'] = 'Высота в см<br/><small>(обязательное поле для заполнения)</small>';
$MESS['PP_DIMENSIONS_DEPTH'] = 'Глубина в см<br/><small>(обязательное поле для заполнения)</small>';

// Zones
$MESS['PPOINT_ZONES_TAB'] = 'Тарифные зоны';
$MESS['PPOINT_ZONES_TAB_TITLE'] = 'Тарифные зоны';

$MESS['PP_TARIF_TITLE'] = '*При заполнении тарифной сетки обратите внимание на условия договора с PickPoint, <br />в зависимости от тарифного плана НДС может быть включен в Тариф, или вынесен отдельно.';
$MESS['PP_USER_PRICE'] = 'Цена для покупателя, руб';
$MESS['PP_DELIVERY_FREE_DISCOUNT'] = 'От какой цены бесплатная доставка?';
$MESS['PP_ZONE'] = 'Тарифная зона';
$MESS['PP_MOSKOV'] = '(Москва)';
$MESS['PP_PITER'] = '(Санкт-Петербург)';

$MESS['PP_COEFF'] = 'Региональный коэффициент';
$MESS['PP_USE_COEFF'] = 'Использовать региональный коэффициент';
$MESS['PP_COEFF_CUSTOM'] = 'Использовать свое значение регионального коэффициента (При пустом значении будет использоваться значение по умолчанию)';

// This section may be useless
$MESS['PP_ADDITIONAL_PHONES'] = 'Дополнительные телефоны пользователя';
$MESS['PP_NUMBER_P'] = '№ присвойки';
$MESS['MAIN_TAB_TITLE_CITIES'] = 'Города и цены';
$MESS['PP_PICKPOINT_CITIES'] = 'Города PickPoint';
$MESS['PP_LOCATIONS'] = 'Справочник местоположений';
$MESS['PP_NOT_CHOOSED'] = 'не выбрано';
$MESS['PP_CITY_ACTIVE'] = 'Активен';
$MESS['PP_ZONES_COUNT'] = 'Количество тарифных зон';
$MESS['PP_CITY_ACTIVE'] = 'Активен';
$MESS['PP_FREE_DELIVERY_PRICE'] = 'От какой цены бесплатная доставка, руб.';
// --

// FAQ
$MESS['PPOINT_FAQ_TAB'] = 'Документация';
$MESS['PPOINT_FAQ_TAB_TITLE'] = 'Помощь в настройке и работе с модулем';

// FAQ > About module
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HDR_MODULE'] = "О модуле";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ABOUT_TITLE'] = "- Для чего нужен модуль";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ABOUT_DESCR'] = "<p>Модуль специально разработан для магазинов-партнеров компании PickPoint, использующих CMS 1C-Битрикс. Модуль позволяет подключить интернет-магазин к системе PickPoint. Сеть PickPoint насчитывает более 8000 постаматов и пунктов выдачи в более чем 626 населённых пунктах России. Для выбора точки доставки используется интерактивная карта (виджет) с удобным интерфейсом для покупателей. Карта дистанционно обновляется при появлении новых точек.</p>
<p><strong>Функциональные возможности:</strong></p>
<ul>
<li>Расчет доставки в более 626 населённых пунктов России; </li>
<li>Возможность выбора точки из виджета и сохранения её в заказ;</li>
<li>Передача заказов автоматически в личный кабинет пользователя в системе PickPoint с помощью API PickPoint; </li>
<li>Возможность управлять стоимостью доставки; </li>
<li>Учет и отображение в заказе наценок наложенного платежа;</li>
<li>Используются последние тарифы на доставку (постоянно обновляются).</li>
</ul>
<p>В приложении все процессы автоматизированы и удобны как для сотрудников Интернет-магазина, так и для покупателей.</p>
<p>Обращаем внимание, модуль выбора точек доставки разработан для исходного кода CMS 1C-Битрикс, если в код вносились какие-либо изменения, а также осуществлялись доработки в CMS на стороне Интернет-магазина, компания PickPoint не гарантирует корректность работы функционала модуля.</p>
<p>Помощь по установке и настройке вы можете получить по электронной почте <a href='mailto:support@pickpoint.ru' target='_blank'>support@pickpoint.ru</a> или на сайте <a href='http://pickpoint.ru/' target='_blank'>http://pickpoint.ru/</a> .</p>";

// FAQ > Setup
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HDR_SETUP'] = "Настройка модуля";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_INTRO_TITLE'] = "- Введение";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_INTRO_DESCR'] = "<p>Перед тем, как приступить к использованию модуля, администратору интернет-магазина следует выполнить ряд операций по первичной настройке решения, а именно:</p>
<ul>
<li>Ввод регистрационных данных интернет-магазина, выбор источников данных для полей выгрузки, установка тарифов на доставку через PickPoint в различные зоны.</li>
<li>Активация автоматизированной службы доставки.</li>
<li>Активация способа оплаты для необходимых типов плательщиков.</li>
</ul>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ACCOUNT_TITLE'] = "- Регистрационные данные";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ACCOUNT_DESCR'] = "<p>Выполнение необходимых настроек производится на вкладке \"Настройки\". На скриншоте ниже показаны поля формы, далее даны пояснения по ним.</p>
<p>Обратите внимание: большинство полей обязательны к заполнению.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_account.png' />
<p><strong>\"ИКН магазина\"</strong> - 10-значное число, указанное в Договоре, заключаемом магазином и компанией PickPoint.</p>
<p><strong>\"Логин\"</strong> - значение, указанное в Договоре, заключаемом магазином и компанией PickPoint, данные для доступа к АПИ PickPoint.</p>
<p><strong>\"Пароль\"</strong> - значение, указанное в Договоре, заключаемом магазином и компанией PickPoint, данные для доступа к АПИ PickPoint.</p>
<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; Тестовые авторизационные данные</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<p>Для предварительной проверки работы модуля можно использовать следующие авторизационные данные:</p>
		<ul>
			<li>ИКН: 9990003041</li>
			<li>Логин: apitest</li>
			<li>Пароль: apitest</li>              
		</ul>
		<p>Также не забудьте включить флаг \"Тестовый режим\".</p>		
    </div>
</div>
<p><strong>\"Стандартное описание вложения\"</strong> - текстовое описание содержимого отправлений, передаваемое при Экспорте заказов в выгрузку. Связано с видом деятельности магазина. Согласуется с PickPoint.</p>
<p><strong>\"Тестовый режим\"</strong> - флаг, позволяющий включить тестовый режим. При его включении все запросы идут к тестовому серверу, заказы также выгружаются на тестовый сервер.</p>
<p><strong>\"Допустимые типы услуги\"</strong> - поле множественного выбора, позволяющее настроить услуги, доступные магазину согласно Договору с компанией PickPoint.</p>
<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; Типы услуги, доступные для выбора</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<ul>
			<li>STD - стандарт, доставка 100% предоплаченного товара – доставка без приема оплаты за товар.</li>
			<li>STDCOD - доставка с приемом оплаты за товар, т.е. наложенный платеж (сумму к оплате Интернет-магазин передает в PickPoint).</li>
			<li>PRIO – доставка в режиме «приоритет» (супер-экспресс) без приема оплаты (100% оплаченный товар).</li>
			<li>PRIOCOD - доставка в режиме «приоритет» наложенным платежом, т.е. с приемом оплаты за товар (сумму к оплате Интернет-магазин передает в PickPoint).</li>
		</ul>
		<p>В основном большинство Интернет-магазинов используют типы услуги: STD и STDCOD.</p>
		<p>Для выделения нескольких пунктов, следует нажать на клавишу «Ctrl» и левой кнопкой мыши выделить необходимый пункт списка.</p>		
    </div>
</div>
<p><strong>\"Допустимые виды приема\"</strong> - поле множественного выбора, в котором следует выбрать виды приема, доступные для магазина в соответствии с Договором, заключенным с компанией PickPoint.</p>
<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; Виды приема</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<ul>
			<li>CUR - вызов курьера (передача отправления с товаром курьеру).</li>
			<li>WIN - сдача товара в окне приема в сортировочном центре PickPoint.</li>
			<li>APTCON - сдача всех отправлений \"валом\" в один постамат в общую ячейку.</li>
			<li>APT - развоз курьерами интернет-магазина товаров по постаматам и самостоятельная раскладка по ячейкам.</li>
		</ul>
		<p>В основном все Интернет-магазины пользуются 2-мя видами передачи отправлений в PickPoint: CUR и WIN.</p>
		<p>Для выделения нескольких пунктов, следует нажать на клавишу «Ctrl» и левой кнопкой мыши выделить необходимый пункт списка.</p>		
    </div>
</div>
<p><strong>\"Увеличить срок доставки на (дней)\"</strong> - опция позволяет увеличить рассчитанный срок доставки на фиксированное количество дней. Может быть полезна, если вам необходимо учесть комплектацию заказов на вашем складе и т.п. задержки. Если требуется менять добавляемое количество дней по какой-либо логике, это можно сделать с помощью обработчика события модуля onCalculate - обратите внимание на раздел документации \"События модуля (для программистов)\".</p>
<p><strong>\"Код свойства заказа, куда будет сохранен выбранный постамат\"</strong> - в свойство заказа в этим кодом будет подставляться адрес и код выбранного постамата PickPoint при оформлении заказа на публичной части сайта. Если используется несколько разных типов плательщиков, у всех них должны быть свойства с одним и тем же кодом. Обычно для этой опции используется свойство заказа \"Адрес доставки\".</p>
<p><strong>\"Дописывать информацию о выбранном постамате в поле \"Комментарий к заказу\"</strong> - если в этом поле стоит галочка, в поле \"Комментарий\" всех заказов, доставляемых через сервис PickPoint, будет дописана информация о постамате, который выбрал клиент. Это сделано для удобства работы администраторов, которые смогут видеть эту информацию через стандартный интерфейс просмотра списка заказов.</p>
<p><strong>\"Брать телефон из свойств заказа\"</strong> - при отмеченной опции телефон, передаваемый в виджет PickPoint для оформления доставки, будет выбран из заполненного поля в параметрах оформления заказа (свойство \"Телефон\" в форме заказа должно быть обязательным). При этом в самом виджете поле для ввода номера будет отсутствовать.</p>
<p><strong>\"Город на основе автоматически определенной локации\"</strong> - при отмеченной данной опции в виджет будет передаваться автоматически определенное местоположение покупателя для показа карты постаматов в виджете PickPoint.</p>
<p><strong>\"Брать город из свойства\"</strong> - при отмеченной опции в виджет будет передаваться город из заполненного адреса доставки в оформлении заказа для показа карты постаматов в виджете PickPoint. <strong>Внимание:</strong> для корректной работы свойство заказа \"Местоположение\" должно быть типа LOCATION.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ORDERPROPS_TITLE'] = "- Источники данных для выгрузки заказов";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ORDERPROPS_DESCR'] = "<p>Выполнение необходимых настроек производится на вкладке \"Настройки\", таблица с выбором источников данных находится после блока регистрационных данных.</p>
<p>Так как основной задачей модуля является автоматизация выгрузок, содержащих заказы покупателей, для передачи их в личный кабинет PickPoint, следует правильно настроить соответствие полей.</p>
<p>Значение в каждом поле определяет источник, из которого модуль будет извлекать данные для формирования выгрузки. По умолчанию, мы настроили для Вас наиболее распространенные источники данных, однако вы можете произвольно изменять их. В каждой паре полей верхнее отвечает за выбор базовой сущности, из которой будет извлекаться значение, а нижнее поле отвечает непосредственно за значение.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_orderprops.png' />
<p><strong>Пример:</strong> Для параметра «ФИО получателя» выбраны значения Тип - \"Параметр пользователя\", Значение – \"Имя\". Это означает, что в выгрузке, которая будет передана в PickPoint, для всех заказов в поле \"ФИО получателя\" будет передано имя пользователя, хранящееся в базе данных пользователей сайта.</p>
<p><strong>Обратите внимание на параметр \"Укажите свойство, из которого будет браться город для доставки\"</strong>, настройка этого параметра используется при отмеченном флаге в параметре <strong>\"Брать город из свойства\"</strong>. Для его корректной работы свойство, из которого будет выбираться Местоположение, обязательно должно быть типа <strong>LOCATION</strong>.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ORDERPROPS_TITLE'] = "- Отправитель, возврат, габариты";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ORDERPROPS_DESCR'] = "<p>Выполнение настроек производится на вкладке \"Тарифные зоны\". На скриншоте ниже показаны поля формы, далее даны пояснения по ним.</p>
<p>Обратите внимание: ряд полей обязателен к заполнению.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_sender_revert.png' />
<p><strong>\"Город отправки\"</strong> - значение, указанное в Договоре, заключаемом магазином и компанией PickPoint, означает город непосредственной отправки грузов.</p>
<p><strong>\"Ставка НДС по сервисному сбору\"</strong> - здесь указывается ставка НДС на доставку. Выбор значения производится из выпадающего списка (Не выбран, 0%, 10%, 20%), необходимость настройки данного поля обговаривается с менеджером компании PickPoint на этапе обсуждения и подписания Договора между магазином и компанией PickPoint.</p>
<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; Подробнее о настройке НДС</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<p>Обратите внимание: в самом модуле НДС изначально не настраивается, модуль работает с налогами, настраиваемыми непосредственно в Битриксе. Ставки налогов (НДС) создаются и настраиваются на странице административного раздела: Магазин \ Настройки \ Налоги \ Ставки НДС.</p>		
		<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_vat_list.png' />		
		<p><strong>Более подробно о настройке НДС в Битриксе вы можете прочитать в <a href='https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=42&LESSON_ID=3458&sphrase_id=5310685' target='_blank'>официальной документации</a>.</strong></p>
		<p>Там же будет показано с примером как применить созданные ставки налогов для Каталога товаров и/или отдельным товарам.</p>
		<p>Для любого из существующих каталогов (инфоблоков торгового каталога) можно указать налог, который будет применятся при продаже товаров:</p>		
		<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_vat_iblock.png' />
		<p>Ставки налогов так же можно указывать для каждого товара или торгового предложения отдельно на вкладке Торговый каталог:</p>
		<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_vat_offer.png' />
		<p>Если значение НДС заполнено в товаре или торговом предложении, тогда модулем будут использованы именно эти данные по ставкам налогов. В противном случае будут использованы значения из настроек инфоблока.</p>
		<p>Эти значения налогов (если указаны) будут переданы при отправке заявки на доставку модулем в компанию PickPoint.</p>		
    </div>
</div>
<p><strong>\"Настройки возврата\"</strong> - значения для этой группы полей прописаны в Договоре, заключаемом магазином и компанией PickPoint. Эти поля содержат информацию о том, куда будут отправлены посылки, которые не были выкуплены или получены адресатами.</p>
<p><strong>\"Габариты\"</strong> - в этой группе полей указывается среднее значение габаритов для ваших отправлений. Оно носит информативный характер, но так как габариты необходимы для корректной работы модуля, то они являются обязательными для заполнения.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ZONES_TITLE'] = "- Тарифы и зоны доставки";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_ZONES_DESCR'] = "<p>Выполнение необходимых настроек производится на вкладке \"Тарифные зоны\", в отдельной таблице после блока \"Габариты\".</p>
<p>Для заполнения таблицы следует использовать значения, прописанные в Договоре, заключаемом магазином и компанией PickPoint.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_zones.png' />
<p>Для городов <strong>Москва и Санкт-Петербург выделены две отдельные зоны \"-1\" и \"0\"</strong>, остальные зоны заполняются в соответствии с тарифами, согласованными в Договоре.</p>
<p><strong>\"Цена для покупателя\"</strong> - значение соответствует стоимости услуги доставки через сервис PickPoint для конечного покупателя.</p>
<p><strong>\"От какой цены бесплатная доставка\"</strong> - значение соответствует сумме заказа, при которой стоимость доставки через сервис PickPoint для конечного покупателя будет бесплатной.</p>
<p><strong>\"Использовать региональный коэффициент\"</strong> - этот флаг позволяет задать свое значение для регионального коэффициента.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_DELIVERY_TITLE'] = "- Добавление службы доставки";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_DELIVERY_DESCR'] = "<p>Во время установки модуля автоматизированная служба доставки \"Доставка компанией PickPoint\" автоматически не создается. Ее необходимо добавить вручную.</p> 
<p>Перейдите в раздел \"Магазин / Настройки / Службы доставки\". Нажмите кнопку \"Добавить\" и выберите в списке <strong>\"Автоматизированная служба доставки\"</strong>.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_delivery_list.png' />
<p>Откроется страница добавления службы доставки, на ней перейдите на вкладку \"Настройки обработчика\" и в списке \"Служба доставки\" выберите <strong>\"PickPoint [pickpoint]\"</strong>.</p>
<p>Сохраните изменения, нажав кнопку \"Применить\". После этого станут доступны вкладки с профилями и ограничениями службы доставки.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_delivery_add.png' />
<p>При необходимости на вкладке \"Общие настройки\" можно изменить название, описание службы доставки, добавить логотип. Для работы службы доставки этого достаточно.</p>
<p>С помощью ограничений можно настроить показ службы доставки PickPoint согласно установленным правилам.</p>
<p>Обратите внимание: ограничения это штатный функционал CMS, модуль не добавляет своих типов ограничений и не модифицирует уже имеющиеся в системе. Для настройки ограничений рекомендуем руководствоваться <a href='https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=42&LESSON_ID=7330&LESSON_PATH=3912.4580.4828.3071.7330' target='_blank'>официальной документацией</a>.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_delivery_restr.png' />
<p>После сохранения изменений проверьте доступность службы доставки на странице оформления заказа.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_PAYSYSTEM_TITLE'] = "- Добавление платежной системы";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_PAYSYSTEM_DESCR'] = "<p>Для того, чтобы покупателям интернет-магазина был доступен способ оплаты \"Постамат PickPoint\", следует добавить платежную систему, связанную с обработчиком службы доставки PickPoint. Обработчик оплаты через PickPoint автоматически устанавливается при установке модуля.</p> 
<p>Перейдите в раздел \"Магазин / Настройки / Платежные системы\". Нажмите кнопку \"Добавить платежную систему\".</p>
<p>Откроется страница добавления платежной системы, на ней в списке \"Обработчик\" выберите <strong>\"PickPoint (pickpoint.deliveryservice)\"</strong>.</p>
<p>Укажите заголовок, название, описание для платежной системы и сохраните изменения, нажав кнопку \"Применить\". После этого станет доступна вкладка с ограничениями платежной системы.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_setup_paysystem_add.png' />
<p>Чтобы определить каким именно типам плательщиков доступен данный способ оплаты, можно задать ограничение по типу плательщика на вкладке \"Ограничения\". Если платежная система должна быть доступна всем покупателям, задавать это ограничение не следует.</p>
<p>Чтобы платежная система была доступна только при выборе службы доставки PickPoint, что может потребоваться, когда вы используете разные службы доставок одновременно, задайте ей ограничение по службам доставки. Выберите при настройке ограничения обработчик, соответствующий службе доставки PickPoint.</p>
<p>После осуществления необходимых настроек, сохраните внесенные изменения, нажав на кнопку \"Сохранить\". Служба оплаты PickPoint будет доступна для Ваших покупателей.</p>";

// FAQ > Work
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HDR_WORK'] = "Работа с модулем";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_SEND_TITLE'] = "- Оформление и передача заказов";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_SEND_DESCR'] = "<p>Для передачи заказов в PickPoint, администратору магазина необходимо перейти в раздел \"Магазин / PickPoint экспорт\".</p>
<p>В таблице выводятся все неотмененные и незавершенные заказы, для которых в качестве службы доставки был выбран PickPoint.</p>
<img class='PICKPOINT_DELIVERYSERVICE_border' src='/bitrix/images/pickpoint.deliveryservice/faq_work_export_list.png' />
<p>Значение \"Вид приема\" служит для того, чтобы определить тип доставки, который будет осуществлен сервисом PickPoint для данного заказа.</p>
<p>Выберите необходимые заказы, поставив галочки в соответствующих строках таблицы, и нажмите на кнопку \"Отправить\". Модуль автоматически сформирует и передаст все выбраные заказы в кабинет на сайте PickPoint.</p>
<p>Для удобства работы таблица поделена на несколько вкладок: \"Новые заказы\", \"Отправленные заказы\", \"Заказы на возврат\", \"Готовые заказы\", \"Отмененные заказы\" и \"Архив заказов\". По мере работы с заказами и в зависимости от их текущих статусов, они будут перемещаться между вкладками.</p>
<p>Для запроса статусов заказов следует использовать кнопку \"Обновить статусы\".</p>";

// FAQ > Info
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HDR_INFO'] = "Справочная информация";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_EVENTHANDLERS_TITLE'] = "- События модуля (для программистов)";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_EVENTHANDLERS_DESCR'] = "<p><b>Внимание:</b> реализацию обработчиков событий модуля следует поручить разработчику, хорошо знакомому с работой CMS Битрикс. Если у вас нет собственных специалистов, настоятельно рекомендуем обратиться в техническую поддержку модуля по электронной почте <a href='mailto:support@pickpoint.ru' target='_blank'>support@pickpoint.ru</a>.</p>
<p><b>Компания PickPoint не несет какой-либо ответственности за любые последствия, произошедшие по причине некорректно созданных и/или используемых обработчиков событий модуля.</b></p>
<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; onCalculate - изменение стоимости и сроков доставки</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<p>С помощью обработчика этого события можно изменить рассчитанные модулем стоимость и сроки доставки по практически любой желаемой логике.</p>
		<div style='color:#AC12B1'><pre>
AddEventHandler(\"pickpoint.deliveryservice\", \"onCalculate\", \"onCalculateHandler\");

function onCalculateHandler(&\$arResult, \$profile, \$arConfig, \$arOrder)
{
<div style='color:#008000'>
	/*
		Внутри обработчика задаются условия его работы в зависимости от значений параметров:
		
		\$profile - профиль службы доставки
		\$arConfig - настройки обработчика службы доставки
		\$arOrder - параметры заказа
			наиболее часто используемые:
			LOCATION_TO   - местоположение получателя
			LOCATION_FROM - местоположение отправителя
			PRICE         - стоимость заказа
			WEIGHT        - вес заказа в граммах
		\$arResult - результат расчета стоимости доставки
			RESULT  - OK, если расчет прошел успешно, или ERROR, если произошла ошибка
			VALUE   - стоимость доставки в рублях
			TRANSIT - срок доставки в днях			
		
		Внимание: \$arResult это указатель на массив
	*/
	
	/*
		Увеличим рассчитанную стоимость доставки на 5 рублей:
	*/
</div>	
		if (\$arResult['RESULT'] == 'OK')		
			\$arResult['VALUE'] += 5;		
}
		</pre></div>				
    </div>
</div>

<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; onJSHandlersSet - установка обработчиков событий для фронтенда</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<p>С помощью обработчика этого события производится регистрация имен методов обработчиков событий, используемых в JS скрипте модуля на фронтенде страницы оформления заказа.</p>
		<p>В обработчик передается указатель на массив событий, каждому из которых можно сопоставить свой метод или функцию. Если конкретное событие вас не интересует, сопоставлять ему какую-либо функцию не нужно.</p>
		<p><b>Внимание:</b> регистрируются именно JS методы, не PHP.</p>
		<div style='color:#AC12B1'><pre>
AddEventHandler(\"pickpoint.deliveryservice\", \"onJSHandlersSet\", \"onJSHandlersSetHandler\");

function onJSHandlersSetHandler(&\$arHandlers)
{	
<div style='color:#008000'>
	/*
		Подпишем метод onAfterPostamatSelectedHandler JS объекта PPDSExtension на событие onAfterPostamatSelected, срабатывающее после выбора постамата в виджете
	*/
</div>	
	if (array_key_exists('onAfterPostamatSelected', \$arHandlers))
		\$arHandlers['onAfterPostamatSelected'] = 'PPDSExtension.onAfterPostamatSelectedHandler';
}
		</pre></div>				
    </div>
</div>

<div class='PICKPOINT_DELIVERYSERVICE_subFaq'>
    <a class='PICKPOINT_DELIVERYSERVICE_smallHeader' onclick='$(this).next().toggle(); return false;'>&gt; onAfterPostamatSelected - получение данных о выбранном клиентом постамате</a>
    <div class='PICKPOINT_DELIVERYSERVICE_inst PICKPOINT_DELIVERYSERVICE_borderBottom'>
		<p>Данное событие возникает в JS скрипте модуля после того, как клиент сайта выбрал постамат через виджет. С помощью обработчика этого события можно получить все данные о выбранном постамате, которые возвращает виджет: адрес, почтовый индекс, географические координаты и т.д. Это может быть полезно, если вы хотите сохранить данные, штатно не используемые модулем, либо у вас нестандартное оформление заказа и требуется своя программная реализация для сохранения этих данных. Другой вариант: вы хотите каким-либо способом информировать клиента сайта, что он успешно выбрал постамат, а штатный блок, выводимый модулем, визуально скрыть.</p>
		<p><b>Внимание: для использования обработчика этого события, предварительно нужно зарегистрировать JS метод с помощью обработчика события модуля onJSHandlersSet.</b></p>
		<p>Кроме того, необходимо подключить скрипт с JS обработчиком на странице оформления заказа. Это можно сделать разными способами: от прямого подключения через теги &lt;script&gt; в начале страницы до создания собственного расширения и подключения его с помощью метода АПИ Битрикса CJSCore::RegisterExt(). Основное требование: на момент срабатывания обработчика onAfterPostamatSelected ваш скрипт должен быть подключен и загружен, иначе обработчик не сработает. </p>
		<div style='color:#AC12B1'><pre>
<div style='color:#008000'>
/*
	Воспользуемся штатным событием компонента оформления заказа bitrix:sale.order.ajax для подключения кастомного JS с обработчиком
*/
</div>
AddEventHandler(\"sale\", \"OnSaleComponentOrderOneStepPersonType\", \"setAdditionalPPDSJS\");
		
function setAdditionalPPDSJS(&\$arResult, &\$arUserResult, \$arParams)
{			
	global \$APPLICATION;
<div style='color:#008000'>
	/*
		Создадим JS объект PPDSExtension с методом onAfterPostamatSelectedHandler, который будет выводить в консоль браузера короткий адрес выбранного постамата.
		В обработчик передается объект data, его содержимое - данные о выбранном постамате.
		Добавим код объекта обработчика на страницу сайта с помощью AddHeadString().
	*/
</div>	
	\$jsCode = \"&lt;script type='text/javascript'&gt;var PPDSExtension = {onAfterPostamatSelectedHandler: function(data) {console.log(data.shortaddress);}};&lt;/script&gt;\";
	\$APPLICATION->AddHeadString(\$jsCode);
}		
		</pre></div>		
		<p>Примеры информации, которую возвращает виджет после выбора точки, можно <a href='https://pickpoint.ru/sales/' target='_blank'>посмотреть на сайте PickPoint</a>, скачав там файл по ссылке <b>\"Инструкция установки карты PickPoint >>>\"</b> (она примерно в середине страницы). Либо просто выведите в консоль весь объект data, смысл большинства параметров будет интуитивно понятен.</p>		
    </div>
</div>
";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_UPDATE_TITLE'] = "- Обновление модуля";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_UPDATE_DESCR'] = "<p>Загрузить обновления модуля Вы можете через административный интерфейс Вашего сайта, обратившись к разделу \"Marketplace / Установленные решения\". Модуль находится в таблице \"Доступные решения\".</p>
<p>При наличии не установленных обновлений для модуля в колонке \"Статус\" появится ссылка \"Доступны обновления\", по клику на ней Вы перейдете к форме установки обновлений.</p>
<p>Перед установкой обновлений рекомендуется сделать полную резервную копию сайта. При возникновении не прогнозируемых заранее технических проблем (сбой на хостинге, у интернет-провайдера и т.д.) наличие резервной копии поможет оперативно восстановить работу сайта и избежать потери данных.</p>
<p><strong>Внимание:</strong> для получения обновлений через Marketplace необходим активный лицензионный ключ продукта \"1С-Битрикс: Управление сайтом\". Если лицензионный ключ просрочен, для восстановления возможности получения обновлений через Marketplace потребуется приобрести и активировать купон продления лицензии.</p>
<p>При необходимости, деинсталляция модуля производится из раздела \"Marketplace / Установленные решения\". Для полного удаления файлов модуля с сайта необходимо воспользоваться опцией \"Стереть\" в таблице \"Доступные решения\" раздела \"Marketplace / Установленные решения\", опция становится доступна после удаления модуля.</p>";

$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HELP_TITLE'] = "- Помощь";
$MESS['PICKPOINT_DELIVERYSERVICE_FAQ_HELP_DESCR'] = "<p>Помощь по установке и настройке вы можете получить по электронной почте <a href='mailto:support@pickpoint.ru' target='_blank'>support@pickpoint.ru</a> или на сайте <a href='http://pickpoint.ru/' target='_blank'>http://pickpoint.ru/</a> .</p>
<p>Мы будем рады получить Ваши комментарии и предложения, касающиеся работы модуля.</p>";
