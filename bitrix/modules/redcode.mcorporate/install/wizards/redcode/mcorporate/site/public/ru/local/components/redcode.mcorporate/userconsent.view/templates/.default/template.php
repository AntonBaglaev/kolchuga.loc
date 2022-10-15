<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/** @var array $arParams */
/** @var array $arResult */

if($arResult["TYPE"] == "C")
{
	echo $arResult["TEXT"];
}
else
{
?>
	<div class="standartText">
		<?php
		echo str_replace("\n", "<br/>", $arResult["TEXT"]);
		?>
	</div>
<?
}
?>