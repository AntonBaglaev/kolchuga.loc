<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обратная связь");
?><p>
	 Мы ценим ваше мнение и будем признательны за вопросы, пожелания или предложения по улучшению нашей работы в салонах и интернет-магазине «Кольчуга»
</p>
 <style>
.form {
    padding: 5px 5px;
    margin: 5px auto;
    font-size: 20px;
    background: #F0F0F0;
}
</style>
<div align="center" class="form">
	 <?$APPLICATION->IncludeComponent(
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
);?>
</div>
<p>
	 Согласно политике нашей компании, мы не можем отвечать на анонимные письма. Просим вас оставлять свои контактные данные в письме, чтобы мы могли дать полный развернутый ответ, который вас удовлетворит.
</p>
<p>
	 Любые обращения, которые содержат нецензурные выражения или несут оскорбительный характер, а также массовые рассылки до адресата не доходят, так как автоматически блокируются почтовым сервером. Письма с вложениями более 10 Мб не доставляются на наш почтовый сервер и мы, к сожалению, не сможем их получить.
</p>
<p>
	 А своими идеями* вы можете поделиться, написав на почту директора Группы Компаний «Кольчуга».
</p>
<p>
	 (иконка) Служба клиентской поддержки: создать адрес
</p>
<p>
	 Обратная связь: Директору Группы Компаний «Кольчуга» (активная ссылка на письмо)
</p>
<p>
	 *Обращаем ваше внимание, что все письма, прямо не касающиеся деятельности группы компаний «Кольчуга», клиентского сервиса и реализуемой нами продукции, направленные на адрес директора группы компаний, не рассматриваются.
</p>
<p>
	 Мы заботимся о своих клиентах и хотим получать обратную связь по существу нашей деятельности!
</p>
<p>
	 Для связи с другими департаментами воспользуйтесь страницей&nbsp;Контакты.
</p>
<p>
	 (пиктограмма телефона) +7(495) 234-34-43
</p>
<p>
	 с понедельника по пятницу с 8:00 до 22:00
</p>
 Заранее благодарим, отдел взаимодействия с покупателями Группы Компаний «Кольчуга». <br>
 <br>
 <?$APPLICATION->IncludeComponent(
	"altasib:feedback.form",
	"",
Array()
);?><br>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>