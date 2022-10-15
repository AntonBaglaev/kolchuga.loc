<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>
<div class="registration">
	<div class="registration--left">
		<?$APPLICATION->IncludeComponent("bitrix:main.register", "", Array(
				"USER_PROPERTY_NAME" => "",
				"SEF_MODE" => "Y",
				"SHOW_FIELDS" => Array(
					0 => 'NAME',
					1 => 'PERSONAL_PHONE',
					2 => 'AGREE'	
				),
				"REQUIRED_FIELDS" => Array(
					0 => 'NAME',
					1 => 'PERSONAL_PHONE',
					2 => 'AGREE'
				),
				"AUTH" => "Y",
				"USE_BACKURL" => "Y",
				"SUCCESS_PAGE" => "/personal/profile/",
				"SET_TITLE" => "Y",
				"USER_PROPERTY" => Array(
					0 => "UF_ORG",
					1 => "UF_UR_ADDRESS",
					2 => "UF_INN",
					3 => "UF_PAY_NUMBER",
					4 => "UF_BANK",
					5 => "UF_CORR_NUMBER",
					6 => "UF_BANK_CITY"
				),
				"SEF_FOLDER" => "/",
				"VARIABLE_ALIASES" => Array(),
				"USE_CAPTCHA" => "Y"
			)
		); ?>
	</div>
	<div class="registration--right">
		<?$APPLICATION->IncludeComponent("bitrix:system.auth.form","social",Array(
			"REGISTER_URL" => "/register/",
			"FORGOT_PASSWORD_URL" => "/personal/profile/",
			"PROFILE_URL" => "/personal/profile/",
			"SHOW_ERRORS" => "Y"
		));?>
	</div>
</div>
<?if(!$USER->IsAuthorized()):?>
	<div class="registration__info">
		После регистрации на сайте Вам будет доступно отслеживание состояния заказов, онлайн-оплата заказа, личный кабинет, возможность использовать вашу скидочную карту и другие новые возможности.
	</div>
<?endif?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>