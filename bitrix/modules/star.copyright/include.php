<?php
	global $APPLICATION;
	global $USER;
	$module_id = 'star.copyright';

	$contentGroup = false;
	$rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => "content_editor"));
	while($arGroup = $rsGroups->Fetch()) {
		$contentGroup = $arGroup["ID"];
	}

	if (ADMIN_SECTION !== TRUE && COption::GetOptionString($module_id, 'ENABLED'.SITE_ID) == 'Y' && (!$USER->IsAdmin())): ?>

		<?if (!in_array($contentGroup, CUser::GetUserGroup($USER->GetID()))):?>
			<script>
					var text = '<?=COption::GetOptionString($module_id, 'TEXT'.SITE_ID)?>';
			</script>
			<script src="/bitrix/js/<?=$module_id?>/script.js"></script>
		<?endif;?>
	<?endif;?>