<?php
IncludeTemplateLangFile(__FILE__);

$arStyles = array(
	"titleH2" => array("title" => GetMessage("TITLE_H2"), "tag" => "h2"),
	"titleH3" => array("title" => GetMessage("TITLE_H3"), "tag" => "h3"),
	"titleH4" => array("title" => GetMessage("TITLE_H4"), "tag" => "h4"),
	"fullImage" => array("title" => GetMessage("FULL_IMAGE"), "tag" => "imgFull"),
    "standartText" => array("title" => GetMessage("STANDART_TEXT"), "tag" => "p"),    
);

return $arStyles;