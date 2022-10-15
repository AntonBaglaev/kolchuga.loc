<?php
//if ($USER->GetID()=="11460"){echo "<pre>";print_r($arResult['NEW_SECTIONS']);echo "</pre>";}
if(!empty($arResult['NEW_SECTIONS'])){
	define("NEWSHLIST", "Y");
}