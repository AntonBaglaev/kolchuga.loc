<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>
<div>
 <br>
	<p>
 <strong>4 шага к успешному бизнесу</strong>
	</p>
	<ol>
		<li>Вы заполняете форму на сайте или связываетесь с нами любым удобным способом</li>
		<li>Наши специалисты консультируют вас по всем вопросам, начиная от подбора ассортимента и заканчивая юридическими рекомендациям</li>
		<li>Мы согласуем и заключаем договор</li>
		<li>Через несколько дней - товар будет у вас!</li>
	</ol>
	 <a name="forma_partner"></a>
	<p>
 <b>Сделайте первый шаг прямо сейчас, используя форму обратной связи!</b>
	</p>
	<div class="stamp">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"optovik",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"VARIABLE_ALIASES" => Array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID"),
		"WEB_FORM_ID" => "5"
	)
);?>
	</div>
	<p>
 <em>&nbsp;</em>
	</p>
	<p>
		 Или просто позвоните нам в рабочее время, по будням с 10.00 до 19.00.
	</p>
	<p>
 <strong>Контакты</strong>
	</p>
	<div class="tel_block_text">
		<div>
 <span class="tel_text_left">Отдел продаж:</span> <a href="tel:+74956981779" class="tel_text_right">+7 (495) 698-17-79</a><br>
 <a href="tel:+74956981023" class="tel_text_right">+7 (495) 698-10-23</a>
		</div>
		<p>
		</p>
	</div>
</div>
 <br>
 <style>
.knopka {
    display: table;
    padding: 5px 20px;
    margin: auto;
    background: #21385e;
    border-radius: 15px;
}
</style>
<div align="center" class="knopka">
 <a href="mailto:Diler@kolchuga.ru" style="color: #ffffff">Сделать первый заказ</a>
</div>
 <br>