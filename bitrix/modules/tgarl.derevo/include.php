<?
global $DBType;
IncludeModuleLangFile(__FILE__);

global $DBType;
CModule::AddAutoloadClasses(
	"tgarl.derevo",
	array(
		"tgarl_derevo_pr" => "classes/general/basa.php",		
	)
);

?>