<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?><?
CHTTP::SetStatus("503 Service Unavailable");
?>
<html>
<head>
<title>503 Service Temporarily Unavailable</title>
</head>
<body>
<h1>Доступ к сайту временно ограничен (5 мин.)</h1>
Вы сделали слишком много запросов в секунду.
</body></html>
<?die();?>