<?php

###########################
#						  #
# module REDCODE		  #
# @copyright 2017 REDCODE #
#						  #
###########################

if(!defined("MODULE_ID"))
	define("MODULE_ID", "redcode.mcorporate");

if(!defined("MODULE_CLASS"))
	define("MODULE_CLASS", "redcode");

\Bitrix\Main\Loader::registerAutoLoadClasses(
	MODULE_ID,
	array(
		"redcode" => "classes/general/main.php",
	)
);