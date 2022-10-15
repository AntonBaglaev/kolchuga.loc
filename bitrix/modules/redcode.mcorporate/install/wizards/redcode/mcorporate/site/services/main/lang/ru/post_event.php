<?php

$MESS["FORM_NAME_SUBMIT"] = "Отправить";

/* Текст для 1 формы */
$MESS["FORM_TITLE_CALLBACK"] = "Обратный звонок";

$MESS["REDCODE_CALLBACK_SUBJECT"] = "Сообщение через форму обратной связи | #SITE_NAME#";
$MESS["REDCODE_CALLBACK_MESSAGE"] = "
<html>
<head>
    <title>Сообщение через форму обратной связи</title>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='600' align='center' style='border-width:2px; border-style:solid; border-color:#d9d9d9;'>
	<tbody>
		<tr>
			<td style='text-align:center; padding: 15px 0 0 0;'>
				<img style='max-height:100px;' src='//#SERVER_NAME##URL_IMG#' border='0' alt='Логотип' />
			</td>
		</tr>
		<tr>
			<td style='padding-left:10px; padding-top:20px; padding-bottom:20px; padding-right:10px;'>
				<p>Имя:  #AUTHOR_NAME#</p>
				<p>Телефон: #AUTHOR_PHONE#</p>
				<p>E-mail: #AUTHOR_EMAIL#</p>
				<p>Сообщение сгенерировано автоматически.</p>
			</td>
		</tr>
	</tbody>
</table>
</body>
";
$MESS["REDCODE_CALLBACK_TYPE_DESCRIPTION"] = "
#AUTHOR_NAME# - имя автора сообщения
#AUTHOR_PHONE# - телефон автора сообщения
#AUTHOR_EMAIL# - E-mail автора сообщения
#URL_IMG# - ссылка на логотип сайта
#EMAIL_TO# - email на который придет сообщение
";
$MESS["REDCODE_CALLBACK_TYPE_NAME"] = "Форма обратной связи";


/* Текст для 2 формы */
$MESS["FORM_TITLE_QUESTION"] = "Консультация по услуге";
$MESS["FORM_TITLE_PROJECTS"] = "Заказать проект";

$MESS["REDCODE_QUESTION_SUBJECT"] = "Вопрос об услуге от пользователя | #SITE_NAME#";
$MESS["REDCODE_QUESTION_MESSAGE"] = "
<html>
<head>
    <title>Вопрос об услуге от пользователя</title>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='600' align='center' style='border-width:2px; border-style:solid; border-color:#d9d9d9;'>
	<tbody>
		<tr>
			<td style='text-align:center; padding: 15px 0 0 0;'>
				<img style='max-height:100px;' src='//#SERVER_NAME##URL_IMG#' border='0' alt='Логотип' />
			</td>
		</tr>
		<tr>
			<td style='padding-left:10px; padding-top:20px; padding-bottom:20px; padding-right:10px;'>
				<p>Имя:  #AUTHOR_NAME#</p>
				<p>Телефон: #AUTHOR_PHONE#</p>
				<p>E-mail: #AUTHOR_EMAIL#</p>
				<p>Интересующая услуга: #NAME_SERVICES#</p>
				<p>Сообщение: </p>
				#AUTHOR_TEXT#
				<p>Сообщение сгенерировано автоматически.</p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
";
$MESS["REDCODE_QUESTION_TYPE_DESCRIPTION"] = "
#AUTHOR_NAME# - имя автора сообщения
#AUTHOR_PHONE# - телефон автора сообщения
#AUTHOR_EMAIL# - e-mail автора сообщения
#NAME_SERVICES# - интересующая услуга
#AUTHOR_TEXT# - текст автора сообщения
#URL_IMG# - ссылка на логотип сайта
#EMAIL_TO# - e-mail на который придет сообщение
";
$MESS["REDCODE_QUESTION_TYPE_NAME"] = "Вопрос по услуге";


/* Текст для 3 формы */
$MESS["REDCODE_SUMMARY_SUBJECT"] = "Резюме на свободные вакансии | #SITE_NAME#";
$MESS["REDCODE_SUMMARY_MESSAGE"] = "
<html>
<head>
    <title>Резюме на свободные вакансии</title>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='600' align='center' style='border-width:2px; border-style:solid; border-color:#d9d9d9;'>
	<tbody>
		<tr>
			<td style='text-align:center; padding: 15px 0 0 0;'>
				<img style='max-height:100px;' src='//#SERVER_NAME##URL_IMG#' border='0' alt='Логотип' />
			</td>
		</tr>
		<tr>
			<td style='padding-left:10px; padding-top:20px; padding-bottom:20px; padding-right:10px;'>
				<p>Название вакансии: #SUMMARY_NAME#</p>
				<p>Файл с резюме прикреплен к данному сообщению.</p>
				<p>Сообщение сгенерировано автоматически.</p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
";
$MESS["REDCODE_SUMMARY_TYPE_DESCRIPTION"] = "
#SUMMARY_NAME# - название вакансии
#URL_IMG# - ссылка на логотип сайта
#EMAIL_TO# - email на который придет сообщение
";
$MESS["REDCODE_SUMMARY_TYPE_NAME"] = "Отправка резюме от пользователя сайта";


/* Текст для 4 формы */
$MESS["REDCODE_WRITE_US_SUBJECT"] = "Сообщение от пользователя сайта | #SITE_NAME#";
$MESS["REDCODE_WRITE_US_MESSAGE"] = "
<html>
<head>
    <title>Сообщение от пользователя сайта</title>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='600' align='center' style='border-width:2px; border-style:solid; border-color:#d9d9d9;'>
	<tbody>
		<tr>
			<td style='text-align:center; padding: 15px 0 0 0;'>
				<img style='max-height:100px;' src='//#SERVER_NAME##URL_IMG#' border='0' alt='Логотип' />
			</td>
		</tr>
		<tr>
			<td style='padding-left:10px; padding-top:20px; padding-bottom:20px; padding-right:10px;'>
				<p>Имя:  #AUTHOR_NAME#</p>
				<p>Тема сообщения:  #THEME_MESSAGE#</p>
				<p>Телефон:  #AUTHOR_PHONE#</p>
				<p>E-mail: #AUTHOR_EMAIL#</p>
				<p>Сообщение: </p>
				#AUTHOR_TEXT#
				<p>Сообщение сгенерировано автоматически.</p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
";
$MESS["REDCODE_WRITE_US_TYPE_DESCRIPTION"] = "
#AUTHOR_NAME# - имя автора сообщения
#THEME_MESSAGE# - тема сообщения
#AUTHOR_PHONE# - телефон автора сообщения
#AUTHOR_EMAIL# - e-mail автора сообщения
#AUTHOR_TEXT# - текст автора сообщения
#URL_IMG# - ссылка на логотип сайта
#EMAIL_TO# - email на который придет сообщение
";
$MESS["REDCODE_WRITE_US_TYPE_NAME"] = "Сообщение от пользователя сайта";


/* Текст для 5 формы */
$MESS["REDCODE_NEW_ORDERS_SUBJECT"] = "Новый заказ | #SITE_NAME#";
$MESS["REDCODE_NEW_ORDERS_MESSAGE"] = "
<html>
<head>
    <title>Поступил новый заказ с сайта</title>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='600' align='center' style='border-width:2px; border-style:solid; border-color:#d9d9d9;'>
	<tbody>
		<tr>
			<td style='text-align:center; padding: 15px 0 0 0;'>
				<img style='max-height:100px;' src='//#SERVER_NAME##URL_IMG#' border='0' alt='Логотип' />
			</td>
		</tr>
		<tr>
			<td style='padding-left:10px; padding-top:20px; padding-bottom:20px; padding-right:10px;'>
				<p>Имя:  #AUTHOR_NAME#</p>
				<p>Телефон: #AUTHOR_PHONE#</p>
				<p>E-mail: #AUTHOR_EMAIL#</p>
				<p>Проект с которого было отправлено сообщение: #NAME_SERVICES#</p>
				<p>Сообщение: </p>
				#AUTHOR_TEXT#
				<p>Сообщение сгенерировано автоматически.</p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
";