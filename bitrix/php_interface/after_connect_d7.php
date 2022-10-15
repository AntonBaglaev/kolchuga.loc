<?
$connection = \Bitrix\Main\Application::getConnection();
$connection->queryExecute("SET NAMES 'utf8'");
$connection->queryExecute('SET collation_connection = "utf8_unicode_ci"');
//$connection->queryExecute("SET LOCAL time_zone='Europe/Moscow'");
$connection->queryExecute("SET LOCAL time_zone='".date('P')."'"); 
$connection->queryExecute("SET sql_mode=''");
$connection->queryExecute("SET innodb_strict_mode=0");
?>
